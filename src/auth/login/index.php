<?php

require('/var/www/html/dbconnect.php');

session_start();

// ログインフォーム送信時
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // メールアドレス、パスワードがなかった場合
  if (empty($_POST['email']) || empty($_POST['password'])) {
    $_SESSION['error_message'] = 'メールアドレスとパスワードを入力してください';
    header('Location: /auth/login');
    exit();
  }
  // 入力データをサニタイズ
  $data = [];
  foreach ($_POST as $key => $value) {
    $data[$key] = htmlspecialchars($value, ENT_QUOTES);
  }
  // DB検索
  $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
  $stmt->execute([':email' => $data['email']]);
  $user = $stmt->fetch();
  // ユーザー情報が照合できたらトップページに遷移
  $isLoginUser = password_verify($data['password'], $user['password']);
  if ($isLoginUser) {
    $_SESSION['user_id'] = $user['id'];
    header('Location: /');
    exit();
  } else {
    $_SESSION['error_message'] = 'メールアドレスまたはパスワードが間違っています';
    header('Location: /auth/login');
    exit();
  }
}

// エラーメッセージ
$errorMessage = $_SESSION['error_message'];
unset($_SESSION['error_message']);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>Schedule | POSSE</title>
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
      <h2 class="text-md font-bold mb-5">ログイン</h2>
      <?php if (isset($errorMessage)) : ?>
        <p class="text-red-500 font-bold mb-3"><?= $errorMessage ?></p>
      <?php endif; ?>
      <form action="" method="POST">
        <input name="email" type="email" placeholder="メールアドレス" class="w-full p-4 text-sm mb-3">
        <input name="password" type="password" placeholder="パスワード" class="w-full p-4 text-sm mb-3">
        <input type="submit" value="ログイン" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
      </form>
      <div class="text-center text-xs text-gray-400 mt-6">
        <a href="/">パスワードを忘れた方はこちら</a>
      </div>
    </div>
  </main>
</body>

</html>
