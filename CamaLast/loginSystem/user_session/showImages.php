<?php
/*
session_start();

include('Class.image.php');
include('../config.php');

function getImages() {
    global $conn;
    $imgObject = [];

    $query = sprintf('SELECT * FROM `image` WHERE `username`="%s"',$_SESSION['username']);
    foreach($conn->query($query) as $row) {
        $img = new Images($row['image_id'], $row['username'], $row['path'], $row['like'], $row['dislike'], $row['private']);
        if ($imgObject == null) {
            $imgObject = array($img);
        }
        else  {
            array_push($imgObject, $img);
        }
    }
    return ($imgObject);
}

/* if (isset($_POST['action']) && $_POST['action'] == "delete") {
    include("../config.php");
    $query = sprintf("DELETE FROM `image` WHERE `image_id`=%d", $_POST['img_id']);
    $stmt = $conn->prepare($query);
    $stmt->execute();
} */

/*echo '<br><br>';

echo 'Post variable: <br>';
var_dump($_POST);
echo '<br> Get variable: <br>';
var_dump($_GET);
echo '<br> FILES variable: <br>';
var_dump($_FILES);
echo '<br> Session variable: <br>';
var_dump($_SESSION);*/

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>Camagru</title>
<head>
<body>
<header  style="background-color:black;" class="header">
        <ul>
                <form method="get">
                    <button style="background-color:black;color:white;" type="submit" class="logout" name="logout">Logout</button>
                </form>
                <li style="color:white;" class="user_choice" name="user_choice">
                    <details class="user_choice_details" name="user_choice_details">
                        <summary class="header_profile">Profile
                        </summary>
                <div class="dropdownMenu" name="feature">
                    <p class="FeatureTitle">Feature<p>
                    <a href="../session.php" name="session">Home</a><br>
                    <a href="profile.php" name="profile">Profile</a><br>
                    <a href="setting.php" name="settings">Settings</a><br>
                    <a href="showImages.php" name="gallerie">Gallerie</a>
                </div>
        </ul>
</header>
<?php

$listImages = getImages();

foreach($listImages as $img) {
    $img->displayImages();

}

if (isset($_POST['newImage'])) {
    header('location: takePicture.php');
}

?>

<form method="post">
    <button type="submit" class="newImage" name="newImage">Add new picture</button>
</form>

<script>

   (() => {
        const initElement = element => {
            // script when pressing delete button. It delete the pointed image.
            const content = element.querySelector('.content').innerHTML

            element.querySelector('.img-delete').addEventListener('click', (event) => {
                event.preventDefault()
                element.querySelector('input[name="action"]').value = "delete"
                element.submit()
            })
            element.querySelector('.showImage').addEventListener('click', (event) => {
                event.preventDefault()
                element.querySelector('input[name="action"]').value = "showImage"
                element.action = element.querySelector('.showImage').href
                console.log(element);
                element.submit()
            })
        }
        Array.from(document.querySelectorAll('.images'))
            .forEach(initElement)
   })()
</script>

</body>

</html>