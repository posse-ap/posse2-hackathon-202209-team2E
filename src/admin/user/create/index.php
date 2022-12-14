<?php
require('/var/www/html/dbconnect.php');
session_start();

if (isset($_GET['action']) && isset($_SESSION['form'])) {
  $form = $_SESSION['form'];
} else {
  $form = [
    'name' => '',
    'email' => '',
    'password' => '',
    'role_id' => '',
  ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $form['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
  $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $form['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  $form['role_id'] = filter_input(INPUT_POST, 'role_id', FILTER_SANITIZE_NUMBER_INT);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $db->prepare('insert into users(name, email, password, role_id) VALUES (?,?,?,?)');
  $password = password_hash($form['password'], PASSWORD_DEFAULT);
  $stmt->execute([$form['name'], $form['email'], $password, $form['role_id']]);

  unset($_SESSION['form']);
  header('Location: /admin/user/create');
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>ユーザー新規登録 | 管理画面</title>
</head>

<body>
  <header class="h-16">
    <div class="flex justify-between items-center w-full h-full mx-auto pl-2 pr-5">
      <div class="h-full">
        <img src="/img/header-logo.png" alt="" class="h-full">
      </div>
      <div>
        <a href="/" class="text-sm text-blue-400 mb-3">ユーザー画面へ</a>
      </div>
      <div>
        <a href="/auth/logout" class="text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200">ログアウト</a>
      </div>
    </div>
  </header>

  <main class="bg-gray-100 h-screen">
    <div class="w-full mx-auto p-5">
      <div class="text-sm text-blue-400 mb-3"><a href="/admin/event/list">イベント一覧</a></div>
      <div class="text-sm text-blue-400 mb-3"><a href="/admin/event/create">イベント作成</a></div>
      <div class="text-sm text-blue-400 mb-3"><a href="/admin/user/create">ユーザー新規登録</a></div>
      <h2 class="text-md font-bold mb-5">ユーザー新規登録 | 管理画面</h2>
      <?php if (isset($errorMessage)) : ?>
        <p class="text-red-500 font-bold mb-3"><?= $errorMessage ?></p>
      <?php endif; ?>
      <form action="" method="POST">
        <p>名前</p>
        <input name="name" type="text" placeholder="名前" class="w-full p-4 text-sm mb-3" value="<?php echo htmlspecialchars($form['name']); ?>">
        <p>メールアドレス</p>
        <input name="email" type="email" placeholder="メールアドレス" class="w-full p-4 text-sm mb-3" value="<?php echo htmlspecialchars($form['email']); ?>">
        <p>パスワード</p>
        <input name="password" type="password" placeholder="パスワード" class="w-full p-4 text-sm mb-3" value="<?php echo htmlspecialchars($form['password']); ?>">
        <p>ユーザータイプ</p>
        <select name="role_id" class="w-full p-4 text-sm mb-3">
          <option value="1">一般ユーザー</option>
          <option value="2">管理者</option>
        </select>
        <input type="submit" value="登録" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
      </form>
    </div>
  </main>
</body>

</html>
