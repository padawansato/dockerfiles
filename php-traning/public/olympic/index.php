<?php

const WEEKDAYS_NAMES = ['日', '月', '火', '水', '木', '金', '土']; //曜日名の格納

/**
 * オリンピックまでの残り時間の表示情報を作成
 * @param DateTime $parisOlympicsDate
 * @param DateTime $currentDate
 * @return array
 */
function displayOlympicsRemainingTime(DateTime $parisOlympicsDate, DateTime $currentDate): array //displayOlympicsRemainingTime関数を定義
{
    $remainingTime = $parisOlympicsDate->diff($currentDate); //オリンピックまでの日時
    $remainingDays = $remainingTime->format('%a'); //オリンピックまでの日数
    $remainingHours = $remainingTime->format('%h'); //オリンピックまでの時間
    $remainingMinutes = $remainingTime->format('%i'); //オリンピックまでの分数
    $remainingSeconds = $remainingTime->format('%s'); //オリンピックまでの秒数

    $totalRemainingSeconds = ($remainingHours * 60 * 60) + ($remainingMinutes * 60) + (int)$remainingSeconds; //オリンピックまでの時間、分、秒を合計した総残り秒数

    return [$remainingDays, $totalRemainingSeconds]; //オリンピックまでの日数と秒数を返す
}

$currentDate = new DateTime();
$parisOlympicsDate = new DateTime('2024-07-26 00:00:00'); //オリンピックの開催日時

[$remainingDays, $totalRemainingSeconds] = displayOlympicsRemainingTime($parisOlympicsDate, $currentDate); //olympicsRemainingTime関数の呼び出し

$accessDateTime = $currentDate->format('Y年m月d日 H時i分s秒'); //アクセスした日時
$accessWeekDay = $currentDate->format('w'); //曜日の値を返す

$accessWeekDayName = WEEKDAYS_NAMES[$accessWeekDay]; //該当する曜日を取得

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Olympics Remaining Time</title>
    <link rel="stylesheet" href="/html/assets/css/olympic.css">
</head>
<body>
<div class="title">オリンピック開催まで<br></div> <!-- タイトルの出力 -->
<div
    class="remaining_time"> <?php echo '残り：' . $remainingDays . '日' . $totalRemainingSeconds . '秒' . '<br>'; ?> </div>
<!-- 残りの日数、秒数の出力 -->
<div class="access_time"><?php echo 'アクセス日時：' . $accessDateTime . '（' . $accessWeekDayName . '）'; ?></div>
<!-- アクセス日時の出力 -->
</body>
</html>