<?php

session_start();

// フォーム送信時
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // メールアドレス未入力時
  if (empty($_POST['email'])) {
    $_SESSION['error_message'] = 'メールアドレスを入力してください';
    header('Location: /auth/reset');
    exit();
  }

  // メールアドレスバリデーション
  $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
  if (!$email) {
    $_SESSION['error_message'] = '正しいメールアドレスを入力してください';
    header('Location: /auth/reset');
    exit();
  }

  // DB検索
  $stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  // DBにメールアドレスがない場合、何もせずに送信完了画面に飛ばす
  if (!$user) {
    header('Location: /auth/sent');
    exit();
  }

  // パスワードリセット中のユーザーかどうか判定
  $stmt = $db->prepare('SELECT * FROM password_resets WHERE email = ?');
  $stmt->execute([$email]);
  $passwordResetUser = $stmt->fetch();
  if (!$passwordResetUser) {
    $sql = 'INSERT INTO password_resets(email, token, token_sent_at) VALUES(:email, :token, :token_sent_at)';
  } else {
    $sql = 'UPDATE password_resets SET token = :token, token_sent_at = :token_sent_at WHERE email = :email';
  }
  // パスワードリセット用トークン発行
  $passwordResetToken = uniqid(bin2hex(random_bytes(1)));

  try {
    $pdo->beginTransaction();

    // ユーザーをpassword_resetsに登録する
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      ':email' => $email,
      ':token' => $passwordResetToken,
      ':token_sent_at' => (new DateTime())->format('Y-m-d H:i:s')
    ]);

    // パスワードリセット用メールを送信する
    mb_language('ja');
    mb_internal_encoding('UTF-8');

    $url = "http://localhost/auth/reset/new?token={$passwordResetToken}";
    $subject =  'パスワード再設定のご案内';
    $body = <<<EOD
        以下のリンクにアクセスし、パスワードの再設定を行なってください。リンクの有効期限は24時間です。
        {$url}
        EOD;
    $headers = ["From" => "system@posse-ap.com", "Content-Type" => "text/plain; charset=UTF-8", "Content-Transfer-Encoding" => "8bit"];

    // 送信失敗時はエラーを出してロールバックする
    $isSent = mb_send_mail($email, $subject, $body, $headers);
    if (!$isSent) throw new Exception('メール送信に失敗しました。');

    // メール送信が完了した時点でテーブルの変更を確定する
    $pdo->commit();
  } catch (Exception $e) {
    $pdo->rollBack();
    exit($e->getMessage());
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
        <input name="email" type="email" placeholder="メールアドレス" class="w-full p-4 text-sm mb-3">
        <input type="submit" value="再設定用メールを送信" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
      </form>
    </div>
  </main>
</body>

</html>
