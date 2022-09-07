<?php
require('../dbconnect.php');
session_start();
header('Content-Type: application/json; charset=UTF-8');

$eventId = $_POST['eventId'];
$USER_ID = $_SESSION['user_id'];
$stmt = $db->prepare("INSERT INTO event_attendance(event_id, user_id) VALUES (?,?)");
$stmt->execute([$eventId, $USER_ID]);