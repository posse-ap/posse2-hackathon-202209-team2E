<?php

require('/var/www/html/dbconnect.php');

// 全ユーザーを取得
$stmt = $db->query('SELECT * FROM users');
$users = $stmt->fetchAll();

// 3日後のイベントを取得
$eventDate = date('Y-m-d', strtotime('+3 day'));
$stmt = $db->prepare(
  'SELECT
    id,
    name,
    events.detail,
    TIME_FORMAT(start_at, "%H:%i") start_at,
    TIME_FORMAT(end_at, "%H:%i") end_at
  FROM
    events
  WHERE DATE_FORMAT(start_at, "%Y-%m-%d") = ?'
);
$stmt->execute([$eventDate]);
$events = $stmt->fetchAll();

// メール送信
mb_language('ja');
mb_internal_encoding('UTF-8');
foreach ($events as $event) {
  foreach ($users as $user) {
    $to = $user['email'];
    $subject = $event['name'] . 'の参加回答期限が迫っています';
    $name = $user['name'];
    $eventName = $event['name'];
    $detail = $event['detail'];
    $startAt = $event['start_at'];
    $endAt = $event['end_at'];
    $headers = ["From" => "system@posse-ap.com", "Content-Type" => "text/plain; charset=UTF-8", "Content-Transfer-Encoding" => "8bit"];
    $body = <<<EOT
    {$name}さん

    以下のイベントの参加回答期限は今日の23:59までです。期限までに参加可否を回答してください。

    ----------------------------------------------
    イベント名: {$eventName}
    開催日時: {$startAt} ~ {$endAt}
    詳細: {$detail}
    ----------------------------------------------
    EOT;
    mb_send_mail($to, $subject, $body, $headers);
  }
}

echo "メールを送信しました\n";
