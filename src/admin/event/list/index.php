<?php

require('/var/www/html/dbconnect.php');

session_start();

if ($_SESSION['role_id'] !== '2') {
  header('Location: /auth/login');
  exit();
}

$stmt = $db->query('SELECT events.id, events.name, events.start_at, events.end_at, count(status = "presence" or null) AS total_participants FROM events LEFT JOIN event_attendance ON events.id = event_attendance.event_id GROUP BY events.id ORDER BY events.start_at ASC');
$events = $stmt->fetchAll();

function get_day_of_week($w)
{
  $day_of_week_list = ['日', '月', '火', '水', '木', '金', '土'];
  return $day_of_week_list["$w"];
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>イベント一覧 | 管理画面</title>
</head>

<body>
  <header class="h-16">
    <div class="flex justify-between items-center w-full h-full mx-auto pl-2 pr-5">
      <div class="h-full">
        <img src="/img/header-logo.png" alt="" class="h-full">
      </div>
      <!--
      <div>
        <a href="/auth/login" class="text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200">ログイン</a>
      </div>
      -->
      <div>
        <a href="/" class="text-sm text-blue-400 mb-3">ユーザー画面へ</a>
      </div>
      <div>
        <a href="/auth/logout" class="text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200">ログアウト</a>
      </div>
    </div>
  </header>

  <main class="bg-gray-100">
    <div class="w-full mx-auto p-5">
      <div id="events-list">
        <div class="text-sm text-blue-400 mb-3"><a href="/admin/event/list">イベント一覧</a></div>
        <div class="text-sm text-blue-400 mb-3"><a href="/admin/event/create">イベント作成</a></div>
        <div class="text-sm text-blue-400 mb-3"><a href="/admin/user/create">ユーザー新規登録</a></div>
        <h2 class="text-md font-bold mb-5">イベント一覧 | 管理画面</h2>

        <!-- 各イベントボックス（一覧）見た目 -->
        <?php
        $futureEvents = [];
        foreach ($events as $event) {
          $start_date = strtotime($event['start_at']);
          if ($start_date < strtotime(date('Y-m-d G:i'))) {
            continue;
          }
          array_push($futureEvents, $event);
        }

        ?>

        <!-- 以下ページネーション -->
        <?php
        define('MAX', 10); //1ページの記事の表示数

        $events_num = count($futureEvents); //トータルデータ件数
        $max_page = ceil($events_num / MAX); //トータルページ数


        if (!isset($_GET['page'])) { // $_GET['page_id'] はURLに渡された現在のページ数
          $page = 1; // 設定されてない場合は1ページ目にする
        } else {
          $page = (int)htmlspecialchars($_GET['page']);
        }
        // 前のページ番号は1と比較して大きい方を使う
        $prev = max($page - 1, 1);

        // 次のページ番号は最大ページ数と比較して小さい方を使う
        $next = min($page + 1, $max_page);

        function paging($max_page, $page = 1)
        {
          $prev = max($page - 1, 1); // 前のページ番号
          $next = min($page + 1, $max_page); // 次のページ番号

        ?>
          <div class="flex justify-between">
            <?php
            if ($page != 1) { // 最初のページ以外で「前へ」を表示
            ?>
              <a href="?page=<?= $prev ?>" class="block w-fit px-2 py-1 bg-blue-600 text-base text-white font-semibold rounded hover:bg-blue-500">&laquo; 前へ</a>
            <?php
            }
            if ($page < $max_page) { // 最後のページ以外で「次へ」を表示
            ?>
              <a href="?page=<?= $next ?>" class="block w-fit px-2 py-1 bg-blue-600 text-base text-white font-semibold rounded hover:bg-blue-500">次へ &raquo;</a>
            <?php
            }
            ?>
          </div>
        <?php
        }

        // 1ページに10個だけ表示させる
        $startNo = ($page - 1) * MAX;

        $disp_data = array_slice($futureEvents, $startNo, MAX, true);

        foreach ($disp_data as $event) :
          $start_date = strtotime($event['start_at']);
          $end_date = strtotime($event['end_at']);
          $day_of_week = get_day_of_week(date("w", $start_date));
        ?>

          <div class="modal-open bg-white mb-3 p-4 flex justify-between rounded-md shadow-md cursor-pointer" id="event-<?php echo $event['id']; ?>" onclick="location.href = '<?= '/admin/event/edit?event_id=' . $event['id'] ?>'">
            <div>
              <h3 class="font-bold text-lg mb-2"><?php echo $event['name'] ?></h3>
              <p><?php echo date("Y年n月j日($day_of_week)", $start_date); ?></p>
              <p class="text-xs text-gray-600">
                <?php
                if (date('Y-m-d', $start_date) === date('Y-m-d', $end_date)) {
                  echo date('G:i', $start_date) . '~' . date('G:i', $end_date);
                } else {
                  echo date('G:i', $start_date) . '~' . date('n月j日 G:i', $end_date);
                }
                ?>
              </p>
            </div>
            <div class="flex flex-col justify-between text-right">
              <div>
                <?php if ($event['id'] % 3 === 1) : ?>
                  <!--
                    <p class="text-sm font-bold text-yellow-400">未回答</p>
                    <p class="text-xs text-yellow-400">期限 <?php echo date("m月d日", strtotime('-3 day', $end_date)); ?></p>
                    -->
                <?php elseif ($event['id'] % 3 === 2) : ?>
                  <!--
                    <p class="text-sm font-bold text-gray-300">不参加</p>
                    -->
                <?php else : ?>
                  <!--
                    <p class="text-sm font-bold text-green-400">参加</p>
                    -->
                <?php endif; ?>
              </div>
              <p class="text-sm w-20"><span class="text-xl"><?php echo $event['total_participants']; ?></span>人参加</p>
            </div>
          </div>
        <?php endforeach;

        paging($max_page, $_GET['page']);
        ?>
      </div>
    </div>
  </main>

  <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-black opacity-80"></div>

    <div class="modal-container absolute bottom-0 bg-white w-screen h-4/5 rounded-t-3xl shadow-lg z-50">
      <div class="modal-content text-left py-6 pl-10 pr-6">
        <div class="z-50 text-right mb-5">
          <svg class="modal-close cursor-pointer inline bg-gray-100 p-1 rounded-full" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 18 18">
            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
          </svg>
        </div>

        <!-- <div id="modalInner"></div> -->

      </div>
    </div>
  </div>

  <!-- <script src="/js/main.js"></script> -->
</body>

</html>
