<?php

require('/var/www/html/dbconnect.php');

$stmt = $db -> query('SELECT * FROM users');
$users = $stmt -> fetchAll();
$eventDate = [
  'start' => date('Y/m/d', strtotime('+1 day')) . ' 00:00',
  'end' => date('Y/m/d', strtotime('+1 day')) . ' 23:59'
];
$stmt = $db -> prepare('SELECT * FROM events where start_at > ? AND start_at < ?');
$stmt -> execute([$eventDate['start'], $eventDate['end']]);
$events = $stmt -> fetchAll();
var_dump($events);

mb_language('ja');
mb_internal_encoding('UTF-8');

foreach($users as $user){
  $to = $user['email'];
  $subject = 'イベントの前日リマインド';
  $name = $user['name'];
  $event = 
  $body = <<<EOT
  {$name}さん


  EOT;
}

$to = "hackathon-teamX@posse-ap.com";
$subject = "PHPからメール送信サンプル";
$body = "本文";
$headers = ["From"=>"system@posse-ap.com", "Content-Type"=>"text/plain; charset=UTF-8", "Content-Transfer-Encoding"=>"8bit"];

$name = "テスト";
$date = "2021年08月01日（日） 21:00~23:00";
$event = "縦モク";
$body = <<<EOT
{$name}さん

${date}に${event}を開催します。
参加／不参加の回答をお願いします。

http://localhost/
EOT;

// mb_send_mail($to, $subject, $body, $headers);
echo "メールを送信しました";