<?php
// リクエストパラメータを取得してJSON形式で表示するプログラム

$logDirectoryPath = __DIR__ . '/../request/log';
$logFileName = 'request.log';

/**
 * リクエストパラメタを受け取って処理する
 * @return array
 */
function getRequestParameters(): array
{
    $requestParameters = array(
        'date' => date('Y-m-d H:i:s'),
        'method' => $_SERVER['REQUEST_METHOD'],
        'param' => $_REQUEST
    );

    //JSONでPOSTデータを送った時にリクエストパラメータをparamに表示
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postJSON = json_decode(file_get_contents('php://input'), true); // POSTされたJSONデータ
        if ($postJSON) {
            $requestParameters['param'] = array_merge($requestParameters['param'], $postJSON); // POSTデータをparamに追加
        }
    }
    return $requestParameters;
}


/**
 * ログディレクトリの作成とクエストパラメタをログファイルに追加
 * @param string $logDirectoryPath
 * @param string $logFileName
 * @param array $requestParameters
 * @return void
 */
function writeRequestParametersToTheLog(string $logDirectoryPath, string $logFileName, array $requestParameters): void
{
    if (!is_dir($logDirectoryPath)) {
        mkdir($logDirectoryPath, 0755, true);
    }
    $logFilePath = $logDirectoryPath . "/" . $logFileName;

    $requestParametersJSON = json_encode($requestParameters, JSON_UNESCAPED_UNICODE) . "\n";

    file_put_contents($logFilePath, $requestParametersJSON, FILE_APPEND | LOCK_EX);
}

// 受け取ったリクエストパラメタをJSONでレスポンスする
/**
 * ログデータをJSONで出力
 * @param array $requestParameters
 * @return void
 */
function responseRequestParameters(array $requestParameters): void
{
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($requestParameters, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); // JSON形式のログデータを改行して出力
}

// 関数を呼び出す

$requestParameters = getRequestParameters();

writeRequestParametersToTheLog($logDirectoryPath, $logFileName, $requestParameters);

responseRequestParameters($requestParameters);