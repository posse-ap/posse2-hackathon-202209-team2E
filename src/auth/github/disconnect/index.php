<?php

require('/var/www/html/dbconnect.php');

session_start();

if (isset($_SESSION['user_id'])) {
    $stmt = $db->prepare('UPDATE users SET github_id = NULL WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    header('Location: /auth/github/setting');
    exit();
}
