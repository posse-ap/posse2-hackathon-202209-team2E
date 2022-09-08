<?php

session_start();
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['role_id']);
header('Location: /auth/login');
exit();
