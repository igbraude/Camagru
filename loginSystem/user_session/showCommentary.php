<?php

// Show commentary
session_start();

include('Class.commentary.php');
include('../config.php');


function getCommentaries() {

    global $conn;
    $commentaryObject = [];

    $query = sprintf("SELECT * FROM `commentary` WHERE `image_id`=%d;", $_SESSION['image_id']);
    foreach($conn->query($query) as $row) {
        $com = new commentary($row['message'], $row['username'], $row['image_id'], $row['commentary_id']);
        if ($commentaryObject == null) {
            $commentaryObject = array($com);
        }
        else  {
            array_push($commentaryObject, $com);
        }
    }
    return ($commentaryObject);
}

if (isset($_POST['action']) && $_POST['action'] == "delete") {
    include("../config.php");
    $query = sprintf("DELETE FROM `commentary` WHERE `commentary_id`=%d", $_POST['id']);
    $stmt = $conn->prepare($query);
    $stmt->execute();
}

if (isset($_POST['action']) && $_POST['action'] == "edit") {
    include("../config.php");
    $query = sprintf("UPDATE `commentary` SET `message`='%s' WHERE commentary_id=%d",$_POST['content'], $_POST['id']);
    $stmt = $conn->prepare($query);
    $stmt->execute();
}

if (isset($_POST['img_id'])) {
    $_SESSION['image_id'] = $_POST['img_id'];
}
if (isset($_POST['imgPath'])) {
    $_SESSION['img_path'] = $_POST['imgPath'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>Camagru</title>
<head>
<body>
<a href="showImages.php">Back to Gallery</a>
<img alt="img" src="<?php echo $_SESSION['img_path'] ?>" width="200" height="200">
<form method="post">
        <textarea rows="12" cols="60" name="commentaryField" id="commentaryField"></textarea>
       <button class="post" name="postCommentary" id="postCommentary">Post</button>
</form>
    <?php
        $listComment = getCommentaries();

        foreach($listComment as $comment) {
            $comment->displayCommentaries();
        }
    ?>
<script>
    (() => {
        const initElement = element => {
            const content = element.querySelector('.content').innerHTML
            element.querySelector('.comment-delete').addEventListener('click', (event) => {
                event.preventDefault()
                element.querySelector('input[name="action"]').value = "delete"
                element.submit()
            })
            element.querySelector('.comment-edit').addEventListener('click', (event) => {
                event.preventDefault()
                element.querySelector('input[name="action"]').value = "edit"
                element.querySelector('.content').innerHTML = `
                    <div class="content">
                        <textarea name="content">${element.querySelector('.content > p').textContent}</textarea>
                        <button type="submit">Submit</button> | <a href="#" id="cancel">Cancel</a>
                    </div>
                `
                element.querySelector('#cancel').addEventListener('click', (event) => {
                    event.preventDefault()
                    element.querySelector('.content').innerHTML = content
                    initElement(element)
                })
            })
        }
        Array.from(document.querySelectorAll('.comment'))
            .forEach(initElement)
    })()
</script>
</body>

</html>