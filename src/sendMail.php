<?php

require('/var/www/html/dbconnect.php');

$eventDate = [
  'start' => date('Y/m/d', strtotime('+1 day')) . ' 00:00',
  'end' => date('Y/m/d', strtotime('+1 day')) . ' 23:59'
];
$stmt = $db -> prepare(
  'SELECT 
  events.name event,
  events.detail,
  TIME_FORMAT(start_at, "%H:%i") start_at, 
  TIME_FORMAT(end_at, "%H:%i") end_at ,
  users.name name,
  users.email email 
  FROM
  events RIGHT JOIN event_attendance ON events.id = event_id LEFT JOIN users ON user_id = users.id 
  where start_at > ? AND start_at < ? AND status = "presence"');
$stmt -> execute([$eventDate['start'], $eventDate['end']]);
$results = $stmt -> fetchAll();

mb_language('ja');
mb_internal_encoding('UTF-8');
foreach($results as $result){
  $to = $result['email'];
  $subject = $result['event'] . 'の前日リマインド';
  $name = $result['name'];
  $eventName = $result['event']; 
  $detail = $result['detail'];
  $startAt = $result['start_at'];
  $endAt = $result['end_at'];
  $headers = ["From"=>"system@posse-ap.com", "Content-Type"=>"text/plain; charset=UTF-8", "Content-Transfer-Encoding"=>"8bit"];
  $body = <<<EOT
  {$name}さん

  明日、{$eventName}を
  {$startAt} ~ {$endAt}
  に開催します。
  {$detail}
  お楽しみに！
  EOT;
  mb_send_mail($to, $subject, $body, $headers);
}

echo "メールを送信しました";
