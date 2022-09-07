<?php

require('/var/www/html/dbconnect.php');

session_start();

// GETメソッドでアクセス時
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (!isset($_GET['token'])) {
    echo '不正なアクセスです';
    exit();
  }
  $token = htmlspecialchars($_GET['token'], ENT_QUOTES);

  // トークンがDBにあるか確認する
  $stmt = $db->prepare('SELECT * FROM password_resets WHERE token = ?');
  $stmt->execute([$token]);
  $passwordResetUser = $stmt->fetch();

  if (!$passwordResetUser) {
    echo '不正なアクセスです';
    exit();
  }

  if (strtotime($passwordResetUser['token_sent_at']) > strtotime('+1 day')) {
    echo 'リンクの有効期限が切れています';
    exit();
  }
}

// フォーム送信時
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_POST['token'])) {
    echo '不正なアクセスです';
    exit();
  }
  $token = htmlspecialchars($_POST['token']);
  $stmt = $db->prepare('SELECT * FROM password_resets WHERE token = ?');
  $stmt->execute([$token]);
  $passwordResetUser = $stmt->fetch();

  if (!$passwordResetUser) {
    echo '不正なアクセスです';
    exit();
  }

  if (strtotime($passwordResetUser['token_sent_at']) > strtotime('+1 day')) {
    echo 'リンクの有効期限が切れています';
    exit();
  }

  if (!isset($_POST['password']) || !isset($_POST['password_confirmation'])) {
    $_SESSION['error_message'] = 'フィールドを全て入力してください';
    header('Location: /auth/reset/new?token=' . $token);
    exit();
  }

  if ($_POST['password'] !== $_POST['password_confirmation']) {
    $_SESSION['error_message'] = 'パスワードが一致しません';
    header('Location: /auth/reset/new?token=' . $token);
    exit();
  }

  // パスワードを更新
  try {
    $db->beginTransaction();
    $stmt = $db->prepare('UPDATE users SET password = :password WHERE email = :email');
    $stmt->execute([
      ':password' => password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT),
      ':email' => htmlspecialchars($_POST['email'])
    ]);

    $stmt = $db->prepare('DELETE FROM password_resets WHERE token = ?');
    $stmt->execute([$token]);

    $db->commit();
    header('Location: /auth/logout');
    exit();
  } catch (PDOException $e) {
    $db->rollBack();
    exit($e->getMessage());
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>パスワード再設定 | POSSE</title>
</head>

<body>
  <header class="h-16">
    <div class="flex justify-between items-center w-full h-full mx-auto pl-2 pr-5">
      <div class="h-full">
        <img src="/img/header-logo.png" alt="" class="h-full">
      </div>
    </div>
  </header>

  <main class="bg-gray-100 h-screen">
    <div class="w-full mx-auto py-10 px-5">
      <h2 class="text-md font-bold mb-5">パスワード再設定</h2>
      <?php if (isset($errorMessage)) : ?>
        <p class="text-red-500 font-bold mb-3"><?= $errorMessage ?></p>
      <?php endif; ?>
      <form action="" method="POST">
        <input type="hidden" name="token" value="<?= $token ?>">
        <input type="hidden" name="email" value="<?= $passwordResetUser['email'] ?>">
        <input name="password" type="password" placeholder="新しいパスワード" class="w-full p-4 text-sm mb-3">
        <input name="password_confirmation" type="password" placeholder="新しいパスワード(確認)" class="w-full p-4 text-sm mb-3">
        <input type="submit" value="再設定する" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
      </form>
    </div>
  </main>
</body>

</html>
