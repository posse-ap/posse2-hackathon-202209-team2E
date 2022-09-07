<?php
require('/var/www/html/dbconnect.php');
require('/auth/login/index.php');

session_start();

// １．参加ボタンをおす
// ２．ログインしているユーザーのidを取得
// ３．そのidがpresenceにしているイベントを取得
// ４．イベントを表示させる

$stmt = $db->query("SELECT * FROM event_attendance WHERE user_id === id");
$event_attendance = $stmt->fetchAll();
