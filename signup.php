<?php 
    include('controller/database.php');

    $name = "";
    $email = "";
    $hashpass = "";
    
    if (isset($_POST["submit"])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $hashpass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        $db = dbConnect();
        $sql = 'SELECT COUNT(*) FROM users WHERE email=:email';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['COUNT(*)'] == 1) {
            echo "このメールアドレスは既に登録されています";
        } else {
            $sql = "INSERT INTO users (name, email, password) VALUE (:name, :email, :password)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashpass);
            $stmt->execute();
            
            header("Location: complete.html");
        }
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/login.css">
    <title>mission6|ユーザー登録ページ</title>
</head>

<body>
    <div class="box">
        <div>
            <h1>新規ユーザー登録</h1>
        </div>
        <form action="" method="post">
            ユーザー名：<input type="text" name="name" required><br>
            メールアドレス：<input type="text" name="email" required><br>
            パスワード：<input type="text" name="password" required><br>
            <input type="submit" name="submit" value="新規登録"><br>
        </form>
        <div>
            <p>すでに登録済みの方は<a href="login.php">こちら</a></p>
        </div>
    </div>
</body>

</html>