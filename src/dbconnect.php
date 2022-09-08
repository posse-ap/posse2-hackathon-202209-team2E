<?php
$dsn = 'mysql:host=mysql;dbname=posse;charset=utf8;';
$user = 'posse_user';
$password = 'password';

try {
  $db = new PDO(
    $dsn,
    $user,
    $password,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
  );
} catch (PDOException $e) {
  echo '接続失敗: ' . $e->getMessage();
  exit();
}
