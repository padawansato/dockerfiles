<?php
//[PHP課題.02] NUMだけ抽出する
//要件：「3の倍数」または「3を含む整数のみ」を出力すること。0〜10000の間から出力すること。

const MIN = 0; //ループの最小値
const MAX = 10000; //ループの最大値
const NUM = 3; //0は禁止

$output = ""; //$outputを代入する空配列
$total = 0; //総数の初期値

for ($i = MIN + 1; $i <= MAX; $i++) { //1から10000まで繰り返す

    if ($i % NUM === 0 || preg_match("/" . NUM . "/", (string)$i)) { //$iをNUMで割った余りが0、またはpreg_match()関数で“NUM”を$i内で検索し、$i内に“NUM”と一致する部分がある場合
        $output .= $i . "<br>"; //$iを$outputに代入する
        $total++; //総数をカウントする
    }
}

echo MIN . "〜" . MAX . "の間で3の倍数または3を含む整数<br>総数: " . $total . "個数<br><br>"; //総数の出力
echo $output; //$iの出力