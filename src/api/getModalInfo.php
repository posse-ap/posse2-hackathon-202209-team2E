<?php
require('../dbconnect.php');
header('Content-Type: application/json; charset=UTF-8');
session_start();

if (isset($_GET['eventId'])) {
  $eventId = htmlspecialchars($_GET['eventId']);
  try {
    // イベントのデータを取得
    $stmt = $db->prepare('SELECT events.id, events.name, events.start_at, events.end_at, events.detail, count(status = "presence" or null) AS total_participants FROM events LEFT JOIN event_attendance ON events.id = event_attendance.event_id WHERE events.id = ? GROUP BY events.id');
    $stmt->execute(array($eventId));
    $event = $stmt->fetch();

    // モーダルを開いたイベントについて、ログイン中のユーザーの参加ステータスを取得
    $stmt = $db->prepare('SELECT status FROM event_attendance WHERE event_id = ? AND user_id = ?');
    $stmt->execute([$eventId, $_SESSION['user_id']]);
    $eventAttendance = $stmt->fetch();

    $start_date = strtotime($event['start_at']);
    $end_date = strtotime($event['end_at']);

    if ($event['detail']) {
      $eventMessage = nl2br($event['detail']);
    } else {
      $eventMessage = date("Y年m月d日", $start_date) . '（' . get_day_of_week(date("w", $start_date)) . '） ' . date("H:i", $start_date) . '~' . date("H:i", $end_date) . 'に' . $event['name'] . 'を開催します。<br>ぜひ参加してください。';
    }

    $array = [
      'id' => $event['id'],
      'name' => $event['name'],
      'date' => date("Y年n月j日", $start_date),
      'day_of_week' => get_day_of_week(date("w", $start_date)),
      'start_at' => date("H:i", $start_date),
      'end_at' => date("H:i", $end_date),
      'total_participants' => $event['total_participants'],
      'message' => $eventMessage,
      'status' => $eventAttendance['status'],
      'deadline' => date("n月j日", strtotime('-3 day', $end_date)),
    ];

    echo json_encode($array, JSON_UNESCAPED_UNICODE);
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit();
  }
}

function get_day_of_week($w)
{
  $day_of_week_list = ['日', '月', '火', '水', '木', '金', '土'];
  return $day_of_week_list["$w"];
}
