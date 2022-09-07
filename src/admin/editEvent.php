<?php

require('/var/www/html/dbconnect.php');

session_start();

if ($_SESSION['role_id'] !== '2') {
  header('Location: /auth/login');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require ('commitChange.php');
}

if (!isset($_GET['event_id'])){
  header('Location: events.php');
  exit();
}

$eventId = htmlspecialchars($_GET['event_id']);

$stmt = $db -> prepare('SELECT * FROM events WHERE id = ?');
$stmt -> execute([$eventId]);
$event = $stmt -> fetch();
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
      <div>
        <a href="events.php" class="text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200">戻る</a>
      </div>
    </div>
  </header>
  <main class="bg-gray-100 h-screen">
    <div class="w-full mx-auto py-10 px-5">
      <h2 class="text-md font-bold mb-5">イベントの編集</h2>
      <form action="" method="POST">
        <p>イベント名</p>
        <input name="name" type="text" placeholder="<?= $event['name'] ?>" value="<?= $event['name'] ?>" class="w-full p-4 text-sm mb-3">
        <p>開始日時</p>
        <input name="start_at" type="text" placeholder="<?= $event['start_at'] ?>" value="<?= $event['start_at'] ?>" class="w-full p-4 text-sm mb-3">
        <p>終了日時</p>
        <input name="end_at" type="text" placeholder="<?= $event['end_at'] ?>" value="<?= $event['end_at'] ?>" class="w-full p-4 text-sm mb-3">
        <p>イベントの内容</p>
        <textarea name="detail" id="" cols="30" rows="10"><?= $event['detail'] ?></textarea>
        <input type="hidden" name="id" value="<?= $event['id'] ?>">
        <input type="submit" value="確定" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
      </form>
    </div>
  </main>
</body>
</html>
