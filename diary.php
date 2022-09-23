<?php include('controller/database.php');

    session_start();
    $db = dbConnect();

    $editpost = "";
    $img_path = "";
    $edit_id = "";

    if (isset($_POST["diarysubmit"])) {
        $post_name = $_POST['diary'];

        if (empty($_POST['edit_id'])) {
            if (!empty($_FILES['img']['tmp_name']) && !empty($_FILES['img']['name'])) {
                $imgname = $_FILES['img']['name'];
                $img_path = 'img/'.$imgname;
                $result = move_uploaded_file($_FILES['img']['tmp_name'], $img_path);
            }
            diaryCreate($db, $post_name, $img_path);
        } else {
            $editdiary = $_POST['edit_id'];
            diaryUpdate($db, $post_name, $editdiary);
        }
    }

    if (isset($_POST['editdiary'])) {
        $editdiary = $_POST['diary_id'];
        $edit_id = $_POST['diary_id'];
        $row = diaryEdit($db, $editdiary);

        $editpost = $row['post_name'];
    }

    if (isset($_POST['deletediary'])) {
        $deletediary = $_POST['diary_id'];
        diaryDelete($db, $deletediary);
    }

    $start = "2022-09-01 00:00:00";
    $stop = date("Y-m-d H:i:s");
    if (isset($_POST['between'])) {
        if (!empty($_POST['start']) && !empty($_POST['stop'])) {
            $start = $_POST['start']." 00:00:00";
            $stop = $_POST['stop']." 23:59:59";
        }
        elseif (empty($_POST['start']) && !empty($_POST['stop'])) {
            $stop = $_POST['stop']." 23:59:59";
        }
        elseif (!empty($_POST['start']) && empty($_POST['stop'])) {
            $start = $_POST['start']." 00:00:00";
        }
    }
    $posts = diarySearch($db, $start, $stop);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/diary.css">
    <link rel="stylesheet" href="css/header.css">
    <title>mission6|ホーム</title>
</head>

<body>
    <div>
        <?php include('header.php');?>
    </div>
    <div>
        <h2>新しい投稿</h2>
    	    <form action="" method="post" enctype="multipart/form-data">
    	        <textarea name="diary" rows="5" cols="30" required><?= $editpost;?></textarea>
    	        <input type="hidden" name="edit_id" value="<?= $edit_id;?>"><br>
    	        <input type="file" name="img" accept=".png, .jpg, .jpeg, .gif" onchange="previewImg(this);">
    	        <p><img id="preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" style="max-width:200px;"></p>
    	        <input type="submit" name="diarysubmit" value="投稿">
    	    </form>
    </div>
    <div>
    	<h2>日記</h2>
    	<div>
    	    <form action="" method="post">
    	        <input type="date" name="start"> ～
    	        <input type="date" name="stop">
    	        <input type="submit" name="between" value="検索">
    	    </form>
    	</div>
    	<table class="diarytable">
    	<?php if(count($posts) == 0): ?>
            <tr>
                <td>投稿がありません</td>
            </tr>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?= nl2br($post['post_name']); ?></td>
                </tr>
                <tr>
                    <td class="bordertd"><img class="diaryimg" src="<?= $post['img_path'];?>" alt=""></td>
                </tr>
                <tr class="border">
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="diary_id" value="<?= $post['post_id'];?>">
                            <input type="submit" name="editdiary" value="編集">
                            <input type="submit" name="deletediary" value="削除">
                        </form>
                    </td>
                    <td class="date">投稿日:<?= $post['create_at']; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
	</div>
    <script type="text/javascript" src="js/preview.js"></script>
</body>

</html>
