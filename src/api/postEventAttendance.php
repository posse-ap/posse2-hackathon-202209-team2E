<?php
require('../dbconnect.php');
session_start();
header('Content-Type: application/json; charset=UTF-8');
session_start();

$eventId = $_POST['event_id'];
$userId = $_SESSION['user_id'];
$status = $_POST['status'];

$stmt = $db->prepare("INSERT INTO event_attendance(event_id, user_id, status) VALUES (?,?,?)");
$stmt->execute([$eventId, $userId, $status]);
