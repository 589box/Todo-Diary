<header>
    <h1>
        <a href="index.php">HOME</a>
    </h1>
    <nav class="pc-nav">
        <ul>
            <li><a href="diary.php">日記</a></li>
        </ul>
    </nav>
        <?php
            if (isset($_SESSION['name'])):?>
                <p class="hello">ようこそ <?php echo $_SESSION['name'];?> さん</p>
                <p class="logout"><a href="logout.php">ログアウト</a></p>
            <?php else:
                header("Location: login.php"); ?>
            <?php endif; ?>
    
    
</header>