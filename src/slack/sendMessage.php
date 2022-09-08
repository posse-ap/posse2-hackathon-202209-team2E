<?php

// require('createMessage.php');

// 第一引数に本文、第二引数にメンションする人
function sendMessage(string $text, array $members){
  $memberId = [
    '寺下渓志郎' => '<@U041VQ2JKFT>',
    '青柳仁' => '<@U041AMSQF1C>',
    '寺嶋里紗' => '<@U041W18Q6HX>'
  ];
  $mention = "";

  foreach($members as $member){
    $mention = $mention . $memberId[$member];
  }

  $url = "https://hooks.slack.com/services/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";
  $message = [
    "channel" => "#event_app",
    "text" => $text . $mention
  ];
  
  $ch = curl_init();
  
  $options = [
    CURLOPT_URL => $url,
    // 返り値を文字列で返す
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    // POST
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
      'payload' => json_encode($message)
    ])
  ];
  
  curl_setopt_array($ch, $options);
  curl_exec($ch);
  curl_close($ch);
}

