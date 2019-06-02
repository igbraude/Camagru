<?php

/*
    File showImages : 
        Display image of the user only.
        User can delete the image or click on it to show commentaries, like, dislike of the pointed image.

*/

include("./formPost/Post.showImages.php");

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
                    <a href="session.php" name="session">Home</a><br>
                    <a href="profile.php" name="profile">Profile</a><br>
                    <a href="setting.php" name="settings">Settings</a><br>
                    <a href="showImages.php" name="gallerie">Gallerie</a><br>
                    <a href="showImagesPublic.php" name="gallerie">Gallerie Public</a>
                </div>
        </ul>
</header>
<?php

$listImages = getImages();

foreach($listImages as $img) {
    $img->displayImages();

}

?>

<form method="get" action="takePicture.php">
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