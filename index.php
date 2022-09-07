<?php include('controller/database.php');

    session_start();
    $db = dbConnect();
    
    if (isset($_POST['createtask'])) {
        $newtask = $_POST['newtask'];
        taskCreate($db, $newtask);
    }
    
    if (isset($_POST['deletetask'])) {
        $deletetask = $_POST['task_id'];
        taskDelete($db, $deletetask);
    }
    
    $tasks = tasks($db);
    $posts = diary($db);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/header.css">
    <title>mission6|ホーム</title>
</head>

<body>
    <div>
        <?php include('header.php');?>
    </div>
	
	<div class="container">
        <div class="column1">
        	<h2>今日のタスク</h2>
        	<table class="tasktable">
        	    <tr>
        	        <td><form action="" method="post">
            	        新しいタスク <input type="text" name="newtask" required>
            	    </td>
            	    <td>
            	        <input type="submit" name="createtask" value="追加">
            	    </form>
            	    </td>
            	    
        	    </tr>
        	<?php if(count($tasks) == 0): ?>
                <tr>
                    <td>タスクがありません</td>
                </tr>
            <?php else: ?>
                <?php foreach ($tasks as $task): ?>
                    <tr class="icon">
                        <td><?= $task['task_name'];?></td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="task_id" value="<?= $task['task_id'];?>">
                                <input type="submit" name="deletetask" value="削除">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </table>
    	</div>
    	<div class="column2">
        	<h2>日記</h2>
        	<table class="diarytable">
        	<?php if(count($posts) == 0): ?>
                <tr>
                    <td>投稿がありません</td>
                </tr>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?= nl2br($post['post_name']) ;?></td>
                    </tr>
                    <tr class="border">
                        <td class="bordertd"><img class="diaryimg" src="<?= $post['img_path'];?>" alt=""></td>
                    </tr>
                    
                <?php endforeach; ?>
            <?php endif; ?>
            </table>
    	</div>
    </div>
</body>

</html>