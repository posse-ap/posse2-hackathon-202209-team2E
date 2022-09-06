<?php

session_start();

if($_SESSION['role_id'] !== '2'){
  header('Location: /auth/login');
  exit();
} else {
  echo '管理者としてログインしました';
}


