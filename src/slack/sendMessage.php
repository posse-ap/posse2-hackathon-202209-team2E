<?php

// 第一引数に本文、第二引数にメンションする人
function sendMessage(string $text, array $members)
{
  $memberId = [
    '寺下渓志郎' => '<@U041VQ2JKFT>',
    '青柳仁' => '<@U041AMSQF1C>',
    '寺嶋里紗' => '<@U041W18Q6HX>',
    '小林哲' => '<@U041HGE5343>'
  ];
  $mention = '';

  // メンション作成
  foreach ($members as $member) {
    $mention = $mention . ' ' . $memberId[$member];
  }

  // 本文とメンションを結合
  $message = $text . $mention;


  // メッセージを実際に送信
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://slack.com/api/chat.postMessage');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  $post = array(
    'channel' => 'C041H5UUU58',
    'text' => $message
  );
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  $headers = array();
  $headers[] = 'Authorization: Bearer xoxb-4051196261986-4054270876084-dqo5pk7M1xfZ1tbSMGSTrkAw';
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $result = curl_exec($ch);
  if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
  }
  curl_close($ch);
}
