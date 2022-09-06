<?php

session_start();
unset($_SESSION['user_id']);
header('Location: /auth/login');
exit();
