<?php

require('/var/www/html/dbconnect.php');

session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: /auth/login');
  exit();
}

$stmt = $db->prepare('SELECT github_id FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$github_id = $stmt->fetch()['github_id'];
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>GitHub連携設定 | POSSE</title>
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
      <h2 class="text-md font-bold mb-5">GitHub連携設定</h2>
      <?php if (is_null($github_id)) : ?>
        <p>現在GitHubアカウントと未連携です</p>
        <div class="mt-6 pt-3">
          <a href="https://github.com/login/oauth/authorize?client_id=ee26015c6f1a5c400c2b" class="block text-center bg-black text-sm w-full p-3 text-white mx-auto rounded-3xl">GitHubアカウントと連携する</a>
        </div>
      <?php else : ?>
        <p>連携中(アカウント名: <?= $github_id ?>)</p>
        <div class="mt-6 pt-3">
          <button href="" class="block text-center bg-red-600 text-sm w-full p-3 text-white mx-auto rounded-3xl" onclick="disconnectGithub()">連携解除</button>
        </div>
      <?php endif; ?>
      <div class="mt-6">
        <a href="/" class="text-sm text-blue-400 my-3">イベント一覧</a>
      </div>
  </main>

  <script>
    function disconnectGithub() {
      if (confirm('連携解除しますか？')) {
        location.href = '/auth/github/disconnect';
      }
    }
  </script>
</body>

</html>
