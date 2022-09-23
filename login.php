<?php
    include('controller/database.php');

    session_start();

    $email = "";
    $password = "";

    if (isset($_POST["submit"])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $pdo = dbConnect();
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $result['password'])) {
            $_SESSION['user_id'] = $result['user_id'];
            $_SESSION['name'] = $result['name'];
            header("Location: index.php");
        } else {
            echo "メールアドレスかパスワードが間違っています";
        }
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/login.css">
    <title>mission6|ログインページ</title>
</head>

<body>
    <div class="box">
        <div>
            <h1>ログイン</h1>
        </div>
        <form action="" method="post">
            メールアドレス：<input type="text" name="email"><br>
            パスワード：<input type="text" name="password"><br>
            <input type="submit" name="submit" value="ログイン"><br>
        </form>
        <div>
            <p>ユーザー登録は<a href="signup.php">こちら</a></p>
        </div>
    </div>
</body>

</html>
