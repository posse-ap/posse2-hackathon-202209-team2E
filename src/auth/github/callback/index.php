<?php

require('/var/www/html/dbconnect.php');

session_start();

if (!isset($_GET['code'])) {
    $_SESSION['error_message'] = 'ログインに失敗しました';
    header('Location: /auth/login');
    exit();
}
$code = htmlspecialchars($_GET['code']);

// アクセストークンの取得
$url = 'https://github.com/login/oauth/access_token';
$data = [
    'client_id' => 'ee26015c6f1a5c400c2b',
    'client_secret' => 'cffa9a4f1365a94dbf0e072d94b16c28aa96db6f',
    'code' => $code
];
$context = [
    'http' => [
        'method'  => 'POST',
        'header'  => implode("\r\n", ['Content-Type: application/x-www-form-urlencoded', 'Accept: application/json']),
        'content' => http_build_query($data)
    ]
];
$res = file_get_contents($url, false, stream_context_create($context));
$res = (array)json_decode($res);
$accessToken = $res['access_token'];

// ユーザー情報の取得
$url = 'https://api.github.com/user';
$context = [
    'http' => [
        'method' => 'GET',
        'header'  => implode("\r\n", ['User-Agent: 202209hackathon2E', 'Authorization: token ' . $accessToken, 'Content-Type: application/x-www-form-urlencoded', 'Accept: application/json']),
    ]
];
$res = file_get_contents($url, false, stream_context_create($context));
$res = (array)json_decode($res);
$github_id = $res['login'];

if (isset($_SESSION['user_id'])) {
    // 連携設定中の場合(ログイン中)
    $stmt = $db->prepare('UPDATE users SET github_id = :github_id WHERE id = :user_id');
    $stmt->execute([
        ':github_id' => $github_id,
        ':user_id' => $_SESSION['user_id']
    ]);
    header('Location: /auth/github/setting');
    exit();
} else {
    // GitHubでログイン試行時(未ログイン状態)
    $stmt = $db->prepare('SELECT * FROM users WHERE github_id = ?');
    $stmt->execute([$github_id]);
    $loginUser =$stmt->fetch();
    if ($loginUser) {
        $_SESSION['user_id'] = $loginUser['id'];
        $_SESSION['user_name'] = $loginUser['name'];
        $_SESSION['role_id'] = $loginUser['role_id'];
        header('Location: /');
        exit();
    } else {
        $_SESSION['error_message'] = 'ログインに失敗しました';
        header('Location: /login');
        exit();
    }
}
