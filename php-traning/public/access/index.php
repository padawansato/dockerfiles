<?php

$logFileName = "log/access.log"; // ログファイルの場所と名前

$accessDateTime = date('Y/m/d H:i:s'); // アクセスした日時の取得

if (!file_exists('log')) {
    mkdir('log', 0777);
}

$file = fopen($logFileName, 'a'); // ファイルを追記モードで開く&ファイルが存在しないときはファイルを作成
if ($file) {
    fwrite($file, $accessDateTime . "\n"); // ログファイルに書き込む
    fclose($file); // ファイルを閉じる
}

$accessLogs = file($logFileName, FILE_IGNORE_NEW_LINES); // ログファイルへの読み込み

$totalAccess = count($accessLogs); // アクセス数をカウント
echo 'アクセス総数: ' . $totalAccess . '件' . '<br>'; // アクセス総数を出力

$recentAccessLogs = array_slice($accessLogs, -20); // 最新の20件のアクセスログを取得
rsort($recentAccessLogs); // アクセスログを降順に並べる

$accessNumber = 1; // $accessNumberを初期化
foreach ($recentAccessLogs as $log) { // $recentAccessLogsの配列の値を１つずつ取り出す
    echo $accessNumber . '. ' . $log . '<br>'; // 番号付きの値を出力する
    $accessNumber++; // 番号を１だけ増やす
}

?>