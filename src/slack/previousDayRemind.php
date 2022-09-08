<?php 

require('/var/www/html/dbconnect.php');
require('sendMessage.php');
require('/var/www/html/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable('/var/www/html');
$token = $dotenv->load('SLACK_TOKEN');

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
  users.name name
  FROM
  events RIGHT JOIN event_attendance ON events.id = event_id LEFT JOIN users ON user_id = users.id 
  where start_at > ? AND start_at < ? AND status = "presence"');
$stmt -> execute([$eventDate['start'], $eventDate['end']]);
$results = $stmt -> fetchAll();

// 本文と参加者の配列を要素とする
$reminders = [];

foreach($results as $result){
  $name = $result['name']; //参加者名
  $eventName = $result['event']; //イベント名
  $detail = $result['detail']; // イベント内容
  $startAt = $result['start_at']; // 開始
  $endAt = $result['end_at']; // 終了

  //そのイベントの要素がまだなかったら配列内にデータの置き場と本文を作成
  if(!$reminders[$eventName]){
    $body = <<<EOT
    明日、{$eventName}を {$startAt} ~ {$endAt} に開催します。
    {$detail}

    EOT;
    $reminders += [
      $eventName => [
        'text' => $body,
        'members' => []
      ]
    ];
  }
  // メンバーを一人ずつ追加
  array_push($reminders[$eventName]['members'], $name);
}

foreach($reminders as $reminder){
  sendMessage($reminder['text'], $reminder['members'], $token['SLACK_TOKEN']);
}
