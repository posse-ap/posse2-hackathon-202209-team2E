<?php

require('/var/www/html/dbconnect.php');

$stmt = $db -> query('SELECT * FROM users');
$users = $stmt -> fetchAll();
$eventDate = [
  'start' => date('Y/m/d', strtotime('+1 day')) . ' 00:00',
  'end' => date('Y/m/d', strtotime('+1 day')) . ' 23:59'
];
$stmt = $db -> prepare(
  'SELECT id, name, 
  TIME_FORMAT(start_at, "%H:%i") start_at, 
  TIME_FORMAT(end_at, "%H:%i") end_at 
  FROM events where start_at > ? AND start_at < ?');
$stmt -> execute([$eventDate['start'], $eventDate['end']]);
$events = $stmt -> fetchAll();

mb_language('ja');
mb_internal_encoding('UTF-8');
foreach($events as $event){
  foreach($users as $user){
    $to = $user['email'];
    $subject = $event['name'] . 'の前日リマインド';
    $name = $user['name'];
    $eventName = $event['name']; 
    $startAt = $event['start_at'];
    $endAt = $event['end_at'];
    $headers = ["From"=>"system@posse-ap.com", "Content-Type"=>"text/plain; charset=UTF-8", "Content-Transfer-Encoding"=>"8bit"];
    $body = <<<EOT
    {$name}さん

    明日、{$eventName}を
    {$startAt} ~ {$endAt}
    に開催します。お楽しみに！
    EOT;
    mb_send_mail($to, $subject, $body, $headers);
  }
}

echo "メールを送信しました";
