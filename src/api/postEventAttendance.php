<?php
require('../dbconnect.php');
header('Content-Type: application/json; charset=UTF-8');
session_start();

$eventId = $_POST['eventId'];
$USER_ID = $_SESSION['user_id'];
$status = $_POST['status'];

$stmt = $db->prepare("INSERT INTO event_attendance(event_id, user_id, status) VALUES (?,?,?)");
$stmt->execute([$eventId, $USER_ID, $status]);
