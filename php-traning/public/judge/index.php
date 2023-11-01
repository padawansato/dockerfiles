<?php

$values = [ // 入力値
    null,
    "",
    " ",
    "0",
    0,
    "1",
    1,
    "-1",
    -1,
    true,
    false,
    [],
    [0],
];

/**
 * PHPの判定構文の早見表の表示
 * @param $values
 * @return array
 */
function judgeTrueOrFalse($values): array // judgeTrueOrFalse関数を定義
{
    $results = [];
    foreach ($values as $value) {
        $result = [
            'isset' => isset($value), // 変数がセットされているかの判定
            'empty' => empty($value), // 変数が空であるかを判定
            'is_null' => is_null($value), // 変数がnullであるかを判定
            'if' => ($value), // 変数が真であるかを判定
            'if_==_0' => ($value == "0"), // 変数が文字列の0と等しいかを判定
            'if_===_0' => ($value === "0"), // 変数が文字列の0と完全に等しいかを判定
        ];
        $results[] = $result; // 判定結果を格納
    }
    return $results; // $resultを返す
}

$results = judgeTrueOrFalse($values); // 関数を呼び出して現在の値に対する判定結果を取得して$resultに格納

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Value Judgments</title>
    <link rel="stylesheet" href="/html/assets/css/judge.css">
</head>
<body>
<table class="table">
    <tr>
        <th class="th">値/判定</th>
        <th class="th">isset($value)</th>
        <th class="th">empty($value)</th>
        <th class="th">is_null($value)</th>
        <th class="th">if($value)</th>
        <th class="th">if($value == "0")</th>
        <th class="th">if($value === "0")</th>
    </tr>

    <?php foreach ($results as $index => $judgementResults): ?> <!-- $valuesの配列の要素を１つずつ取り出す -->
        <tr>
            <td class="td"><?php echo '$value = ' . json_encode($values[$index]) . ';'; ?></td>
            <!-- 現在の値をテーブルのセルの表示する -->
            <?php foreach ($judgementResults as $value): ?> <!-- 取得した$resultをループしてテーブルのセルに表示する -->
                <td class="td"><?php echo $value ? "true" : "false"; ?></td> <!-- 各判定結果を表示 -->
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>

</table>
</body>
</html>