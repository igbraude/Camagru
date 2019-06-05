<?php

/*

    File showImagesPublic :
        Display public image of everyone.
        User can click on the image to see the commentary, like, dislike of the pointed one.

*/

session_start();

include('../Class/Class.image.php');
include('../config/database-setup.php');

function getImages() {
    global $conn;
    $imgObject = [];

    $query = sprintf('SELECT * FROM `image`');
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
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


</head>

<body>

<header class="header-user-dropdown">

<div class="header-limiter">
    <h1><a href="./session.php">Camagru</a></h1>

    <nav>
        <a href="./showImages.php">My Gallery</a>
        <a href="./showImagesPublic.php">Public Gallery</a>
        <a href="./takePicture.php">Take Picture</a>
        <a href="./setting.php">Settings</a>
        <input type="hidden" name="logout" value="">
        <a href="./logout.php">Logout</a>

    </nav>
</div>

</header>

<div class="row">
<?php
$i = 0;
$listImages = getImages();
foreach($listImages as $img) {
    echo '<div class="col-sm-3">';
    $img->displayImagesPublic();
    echo '</div>';
    $i++;
    if ($i % 3 == 0) {
        echo '<div class="w-100"></div>';
    }

}
?>
</div>
<?php
if (isset($_POST['newImage'])) {
    header('location: takePicture.php');
}

?>
</div>

<script>

   (() => {
        const initElement = element => {
            // script when pressing delete button. It delete the pointed image.
            const content = element.querySelector('.content').innerHTML
            element.querySelector('.showImage').addEventListener('click', (event) => {
                event.preventDefault()
                element.querySelector('input[name="action"]').value = "showImage"
                element.action = element.querySelector('.showImage').href
                element.submit()
            })
        }
        Array.from(document.querySelectorAll('.images'))
            .forEach(initElement)
   })()
</script>

</body>

</html>