<?php
// 投稿フォームからデータを受け取り、データベースに保存するコード

require_once __DIR__ . '/lib/Board.php'; // ファイルの読み込み

session_start(); // ユーザごとに状態を保持する

/**
 * 投稿フォームから投稿情報を受け取る
 * @return array
 */
function receivePost(): array
{
    // 投稿フォームに入力された'name'と'message'を取得する
    $name = $_POST["name"] ?? "";
    $message = $_POST["message"] ?? "";

    return [$name, $message];
}

/**
 * データベースに投稿を保存する
 * @param string $name
 * @param string $message
 * @return bool
 */
function savePost(string $name, string $message): bool
{
    $board = new Board();
    return $board->addPost($name, $message);
}

// POSTリクエストされた場合は投稿の内容を取得
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    [$name, $message] = receivePost();

    // 投稿が空の場合は、エラーメッセージを書き込んで、処理を中断する
    if (empty($message)) {
        $_SESSION["error"] = "ERROR: メッセージを入力してください。";
        header("Location: index.php");
        exit;
    }

    // 正常に保存できる場合は、入力された名前をセッション変数に書き込んで投稿後に名前が削除されないようにする
    if (savePost($name, $message)) {
        $_SESSION["name"] = $name;
    } else {  // 正常に保存できない場合は、”ERROR＂をセッション変数に書き込む
        $_SESSION["error"] = "ERROR";
    }
    header("Location: index.php");
    exit;
}