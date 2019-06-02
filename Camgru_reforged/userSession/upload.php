<?php

include("./formPost/Post.upload.php");

if (isset($_FILES['fileToUpload'])) {
    if ($_FILES['fileToUpload']['error'] != 0) {
        header ("location: takePicture.php");
    }
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


<?php if (isset($_POST['selectedImage'])) {?>
    <form class="newPic" action="takePicture.php" enctype="multipart/form-data" method="post">
         <input type=hidden name="imagePath" value="<?php echo $_POST['uploadedImage'] ?>">
         <input type="hidden" name="addImage" value="addImage">
         <img width="500px" height="500px" src="<?php echo $_POST['uploadedImage'] ?>" alt="cadre">
         <a href="#" class="addPicture">Add image</a>
    </form>

<script>
    (() => {
    const initElement = element => {
        element = element.querySelector('.addPicture')
        element.addEventListener("click", (event) => {
        event.preventDefault()
        -document.querySelector(".newPic").submit();
        
        })
    }
    Array.from(document.querySelectorAll('.newPic'))
            .forEach(initElement)
    })()
</script>

<?php } ?>

<form class="img" enctype="multipart/form-data" method="post">
    Click on the montage you prefer
      <div class="montageImage">
        <input type="hidden" name="selectedImage" value="">
         <a href="#" class="imageMontage"><img width="50px" height="50px" src="../imageMontage/image/cadre.png" alt="cadre"></a>
         <a href="#" class="imageMontage"><img width="50px" height="50px" src="../imageMontage/image/camera.png" alt="cadre"></a>
         <a href="#" class="imageMontage"><img width="50px" height="50px" src="../imageMontage/image/cigarette.png" alt="cadre"></a>
         <a href="#" class="imageMontage"><img width="50px" height="50px" src="../imageMontage/image/down.png" alt="cadre"></a>
         <a href="#" class="imageMontage"><img width="50px" height="50px" src="../imageMontage/image/hat.png" alt="cadre"></a>
         <a href="#" class="imageMontage"><img width="50px" height="50px" src="../imageMontage/image/load.png" alt="cadre"></a>
         <a href="#" class="imageMontage"><img width="50px" height="50px" src="../imageMontage/image/up.png" alt="cadre"></a>
      </div>
</form>

<br>

<?php if ($uploadOk == 0) { ?>
<form class="upload" action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="submit" value="UploadImage" name="submit" value="">
    <input type="file" name="fileToUpload" id="fileToUpload" accept="image/jpeg" value="">
</form>
<?php } ?>

<script type="text/javascript">

image = document.getElementsByClassName("imageMontage")
for (var i = 0; i < image.length; i++) {
        image[i].addEventListener('click', function(event) {
        event.preventDefault()
        document.querySelector('input[name="selectedImage"]').value = event.target.getAttribute("src")
        document.querySelector(".img").submit()
    }, false)
}

</script>

</body>
</html>