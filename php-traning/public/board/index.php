<?php
// 投稿一覧、エラーメッセージの取得と掲示板を表示するコード

require_once __DIR__ . '/lib/Board.php'; // ファイルの読み込み

session_start(); // ユーザごとに状態を保持する

/**
 * 投稿一覧を取得する
 * @return array
 */
function getPosts(): array
{
    $board = new Board();
    return $board->getAllPosts();
}

/**
 * エラーメッセージを取得する
 * @return string
 */
function getErrorMessage(): string
{
    if (!empty($_SESSION["error"])) {
        $error = $_SESSION["error"];
        unset($_SESSION["error"]);
        return $error;
    }
    return "";
}

$posts = getPosts();
$error = getErrorMessage();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>掲示板</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div id="container">
    <h1 class="title">掲示板</h1>

    <div class="all-posts">
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <span
                    class="post-info"><?php echo $post["id"]; ?>. <?php echo $post["created_at"]; ?> <?php echo empty($post['name']) ? '(ななし)' : $post['name']; ?>さん</span>
                <div class="message"><?php echo $post["message"]; ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (!empty($error)): ?>
        <div id="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div>
        <form action="post.php" method="POST">
            <label for="name">お名前</label><br>
            <input type="text" id="name" name="name" placeholder="ななし"
                   value="<?php echo $_SESSION["name"] ?? ""; ?>"><br>

            <label for="message">メッセージ</label><br>
            <textarea id="message" name="message" placeholder="メッセージを入力してください。"></textarea><br>

            <input type="submit" value="投稿する">
        </form>
    </div>
</div>
</body>
</html>