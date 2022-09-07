<?php

if (!isset($_GET['code'])) {
    echo '不正なアクセスです';
    exit();
}
$code = htmlspecialchars($_GET['code']);

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
$res = json_decode($res);
var_dump($res);
