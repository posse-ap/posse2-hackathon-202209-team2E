<?php
require('../dbconnect.php');
session_start();
header('Content-Type: application/json; charset=UTF-8');
session_start();

$eventId = $_POST['event_id'];
$userId = $_SESSION['user_id'];
$status = $_POST['status'];

// すでに登録済みか確認
$stmt = $db->prepare('SELECT * FROM event_attendance WHERE event_id = :event_id AND user_id = :user_id');
$stmt->execute([
  ':event_id' => $eventId,
  ':user_id' => $userId
]);
$eventAttendance = $stmt->fetch();

if ($eventAttendance) {
  // 登録済みならUPDATE
  $sql = 'UPDATE event_attendance SET status = :status WHERE event_id = :event_id AND user_id = :user_id';
} else {
  // 未登録ならINSERT
  $sql = 'INSERT INTO event_attendance(event_id, user_id, status) VALUES (:event_id, :user_id, :status)';
}
$stmt = $db->prepare($sql);
$stmt->execute([
  ':event_id' => $eventId,
  ':user_id' => $userId,
  ':status' => $status
]);
