<?php

// 第一引数に本文、第二引数にメンションする人
function sendMessage(string $text, array $slack_ids, $token)
{
  $mention = '';

  // メンション作成
  foreach ($slack_ids as $slack_id) {
    $mention = $mention . ' <@' . $slack_id . '>';
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
  $headers[] = 'Authorization: Bearer ' . $token;
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $result = curl_exec($ch);
  if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
  }
  curl_close($ch);
}
