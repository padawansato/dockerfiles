<?php
// 3つのJSONファイルを読んで順位表を出力するプログラム

// ファイルの定義
$dataDirectoryPath = __DIR__ . '/data';
$leagueFileName = "league_master.json";
$teamFileName = "team_master.json";
$statsFileName = "stats.json";

//  デフォルトのリーグIDの定義
const defaultLeagueId = "SeriaA";

/**
 * GETリクエストパラメータからリーグIDを取得する
 * @return string
 */
function getLeagueIdRequestParameter(): string
{
    $leagueId = $_GET["league_id"] ?? '';
    // デフォルトでセリエＡを使う
    if (empty($leagueId)) {
        $leagueId = defaultLeagueId;
    }
    return $leagueId;
}

/**
 * ファイル読み込み
 * @param string $directoryPath
 * @param string $fileName
 * @return array
 */
function loadFile(string $directoryPath, string $fileName): array
{
    $filePath = $directoryPath . "/" . $fileName;
    return json_decode(file_get_contents($filePath), true);
}

/**
 * 勝ち点と得失点差を計算する
 * @param array $statsJSON
 * @return array
 */
function calculateScores(array $statsJSON): array
{
    foreach ($statsJSON["stats"] as $i => $teamStats) {
        // 勝ち点を計算して追加
        $statsJSON["stats"][$i]["winning"] = $teamStats["won"] * 3 + $teamStats["draw"];
        // 得失点差を計算して追加
        $statsJSON["stats"][$i]["diff"] = $teamStats["scored"] - $teamStats["against"];
    }
    return $statsJSON;
}

/**
 * 順位表を作る
 * @param string $leagueId
 * @param array $leagueJSON
 * @param array $teamJSON
 * @param array $statsJSON
 * @return array
 */
function createLeagueRanking(string $leagueId, array $leagueJSON, array $teamJSON, array $statsJSON): array
{
    // 指定のリーグIDに対応するリーグ名の取得
    $leagueName = '';
    foreach ($leagueJSON as $league) {
        if ($leagueId === $league["leagueId"]) {
            $leagueName = $league["name"];
        }
    }
    // 指定のリーグIDに属するチーム情報の作成
    $ranking = [];
    foreach ($teamJSON as $team) {
        if ($team["leagueId"] === $leagueId) {
            // チームID、チーム名、試合統計情報の配列を作成
            foreach ($statsJSON["stats"] as $stats) {
                if ($team["teamId"] === $stats["teamId"]) {
                    $ranking[] = [
                        "teamId" => $team["teamId"],
                        "name" => $team["name"],
                        "stats" => $stats,
                    ];
                }
            }
        }
    }

    // 勝ち点と得失点差でソートする
    $tempWinning = [];
    $tempDiff = [];
    foreach ($ranking as $key => $row) {
        $tempWinning[$key] = $row["stats"]["winning"];
        $tempDiff[$key] = $row["stats"]["diff"];
    }
    array_multisort(
        $tempWinning, SORT_DESC, SORT_NUMERIC,
        $tempDiff, SORT_DESC, SORT_NUMERIC,
        $ranking
    );

    // 順位を付ける
    $previousTeamStats = null;
    $currentRank = 1;
    $rankingOfEachTeam = [];
    foreach ($ranking as $team) {
        // 直前のチームと現在のチームの統計情報を比較する（勝点と得失点差が異なる場合は順位を1つ上げる）
        if ($previousTeamStats !== null && ($previousTeamStats['stats']['winning'] !== $team['stats']['winning'] || $previousTeamStats['stats']['diff'] !== $team['stats']['diff'])) {
            $currentRank++;
        }
        $team['rank'] = $currentRank;
        $rankingOfEachTeam[] = $team;
        $previousTeamStats = $team;
    }

    return [
        "leagueId" => $leagueId,
        "name" => $leagueName,
        "ranking" => $rankingOfEachTeam,
    ];
}

$leagueId = getLeagueIdRequestParameter();

$leagueJSON = loadFile($dataDirectoryPath, $leagueFileName);
$teamJSON = loadFile($dataDirectoryPath, $teamFileName);
$statsJSON = loadFile($dataDirectoryPath, $statsFileName);
$statsJSON = calculateScores($statsJSON);

$ranking = createLeagueRanking($leagueId, $leagueJSON, $teamJSON, $statsJSON);

// HTML形式で順位表を出力する
// 順位表のタイトル
$leagueName = $ranking["name"];
$title = $leagueName . "の順位表";

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <title>順位表</title>
    <link rel="stylesheet" href="/league/assets/css/style.css">
</head>
<body>
<a href="?league_id=SeriaA">セリエＡ</a>
<a href="?league_id=Premier">プレミアリーグ</a>
<a href="?league_id=LaLiga">リーガエスパニョーラ</a>
<h1><?= $title ?> </h1>
<table class="table">
    <tr>
        <th class="th">順位</th>
        <th class="th">チーム名</th>
        <th class="th">勝点</th>
        <th class="th">試合数</th>
        <th class="th">勝数</th>
        <th class="th">引分数</th>
        <th class="th">敗数</th>
        <th class="th">得点</th>
        <th class="th">失点</th>
        <th class="th">得失点差</th>
    </tr>

    <?php foreach ($ranking["ranking"] as $team): ?>
        <tr>
            <td class="td"><?= $team['rank'] ?></td>
            <td class="td"><?= $team['name'] ?></td>
            <td class="td"><?= $team['stats']['winning'] ?></td>
            <td class="td"><?= $team['stats']['played'] ?></td>
            <td class="td"><?= $team['stats']['won'] ?></td>
            <td class="td"><?= $team['stats']['draw'] ?></td>
            <td class="td"><?= $team['stats']['lost'] ?></td>
            <td class="td"><?= $team['stats']['scored'] ?></td>
            <td class="td"><?= $team['stats']['against'] ?></td>
            <td class="td"><?= $team['stats']['diff'] ?></td>
        </tr>
    <?php endforeach; ?>

</table>
</body>
</html>