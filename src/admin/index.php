<?php

require('/var/www/html/dbconnect.php');

session_start();
// 管理者でないときログインページへ
if ($_SESSION['role_id'] !== '2') {
  header('Location: /auth/login');
  exit();
}

// 作成ボタン押下時
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($_POST['event'] && $_POST['start_at'] && $_POST['end_at']) {
    $eventName = $_POST['event'];
    $startAt = (string)$_POST['start_at'];
    $endAt = (string)$_POST['end_at'];
    unset($_POST['event']);
    unset($_POST['start_at']);
    unset($_POST['end_at']);
    $stmt = $db -> prepare(
    'INSERT INTO events SET name=?, start_at=?, end_at=?');
    $stmt -> execute([$eventName, $startAt, $endAt]);
    echo('<script>alert("イベントが作成されました")</script>');
  } else {
    $errorMessage = 'イベント名、開始日時、終了日時を入力してください';
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
  <title>Document</title>
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
      <h2 class="text-md font-bold mb-5">イベント作成</h2>
      <?php if (isset($errorMessage)) : ?>
        <p class="text-red-500 font-bold mb-3"><?= $errorMessage ?></p>
      <?php endif; ?>
      <form action="" method="POST">
        <input name="event" type="text" placeholder="イベント名" class="w-full p-4 text-sm mb-3">
        <p>開始日時</p>
        <input name="start_at" type="text" placeholder="開始日時" class="w-full p-4 text-sm mb-3">
        <p>終了日時</p>
        <input name="end_at" type="text" placeholder="開始終了日時" class="w-full p-4 text-sm mb-3">
        <input type="submit" value="作成" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
      </form>
    </div>
  </main>
</body>

</html>