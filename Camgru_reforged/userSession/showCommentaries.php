<?php

/*
    File ShowCommentaries :
        Display the image pointed by the user.
        Create new object for a commentary of an image and display it (commentary), loop foreach commentary.
        User can create, edit, delete his own commentaries.
*/

include("./formPost/Post.showCommentaries.php");

function getCommentaries() {

    global $conn;
    $commentaryObject = [];

    $query = sprintf("SELECT * FROM `commentary` WHERE `image_id`=%d;", $_SESSION['image_id']);
    foreach($conn->query($query) as $row) {
        $com = new Commentary($row['message'], $row['username'], $row['image_id'], $row['commentary_id']);
        if ($commentaryObject == null) {
            $commentaryObject = array($com);
        }
        else  {
            array_push($commentaryObject, $com);
        }
    }
    return ($commentaryObject);
}
var_dump($_POST);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>Camagru</title>
    <head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>User Dropdown Header</title>

<link rel="stylesheet" href="css/header-user-dropdown.css">
<link href='http://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>


</head>

<body>

<header class="header-user-dropdown">

<div class="header-limiter">
    <h1><a href="./session.php">Camagru</a></h1>

    <nav>
        <a href="./showImages.php?page=1">My Gallery</a>
        <a href="./showImagesPublic.php?page=1">Public Gallery</a>
        <a href="./takePicture.php">Take Picture</a>
        <a href="./setting.php">Settings</a>
        <input type="hidden" name="logout" value="">
        <a href="./logout.php">Logout</a>

    </nav>
</div>

</header>

<a href="<?php if ($_POST['Gallery'] == "Public") { echo "./showImagesPublic.php?page=1";} else { echo "./showImages.php?page=1"; } ?>">Back to Gallery</a>
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