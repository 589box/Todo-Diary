<?php
    session_start();
    $_SESSION = array();
    session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/login.css">
    <title>mission6|ログアウトページ</title>
</head>

<body>
    <div class="box">
        <div>
            <h1>ログアウトしました</h1>
        </div>
        <div>
            <p></p><a href="login.php">ログイン画面へ戻る</a></p>
        </div>
    </div>
</body>

</html>