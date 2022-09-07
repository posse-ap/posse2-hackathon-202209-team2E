<?php

if ($_SESSION['role_id'] !== '2') {
  header('Location: /auth/login');
  exit();
}

require('/var/www/html/dbconnect.php');

$name = htmlspecialchars($_POST['name']);
$startAt = htmlspecialchars($_POST['start_at']);
$endAt = htmlspecialchars($_POST['end_at']);
$detail = htmlspecialchars($_POST['detail']);
$id = htmlspecialchars($_POST['id']);

$stmt = $db -> prepare('UPDATE events SET name=?, start_at=?, end_at=?, detail=? WHERE id = ?');
$stmt -> execute([$name, $startAt, $endAt, $detail, $id]);

echo '<script> alert("イベントを編集しました") </script>';
