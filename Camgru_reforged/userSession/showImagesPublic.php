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

<link rel="stylesheet" href="css/demo.css">
<link rel="stylesheet" href="css/header-user-dropdown.css">
<link href='http://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>


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
<?php

$listImages = getImages();

foreach($listImages as $img) {
    $img->displayImagesPublic();

}

if (isset($_POST['newImage'])) {
    header('location: takePicture.php');
}

?>

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