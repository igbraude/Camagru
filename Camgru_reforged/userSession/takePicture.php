<?php

/*
        File takePicture: 
            Display the cameras of the user and some image for an amazing montage...\
            User can take a screenshot of his camera or upload an valid image.jpeg.
                (if the user click the button Upload File it redirect him to upload.php)
            after clicking on TakePicture button, the Montage with the screenshot and the image is display.
            User can now add the montage in his gallerie and show his photo to all other users.

*/

include("./formPost/Post.takePicture.php");

?>
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


<form class="img" enctype="multipart/form-data" method="post">
    <div id="my_camera">
      <video width="500" height="500" id="video" controls>
      </video>
      <button type="submit" id="takePicButton" <?php if ($disabled != null) { echo $disabled; } ?>>Take photo</button>
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
    </div>
    <canvas width="500" height="500" style="display:none;" id="canvas"></canvas>
</form>

<br>

<form class="upload" action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload" accept="image/jpeg" value>
    <input type="submit" value="UploadImage" name="submit" value="">
</form>

<br>
<form class="montage" enctype="multipart/form-data" method="post">
    <div id="imgMontage">
    <input type="hidden" name="newPicture" value="">
    <input type="hidden" name="imgSelect" value="<?php echo $_POST['selectedImage'] ?>">
    </form>
    <?php if (isset($_POST['newPicture'])) {
            echo '<form class="newPic" enctype="multipart/form-data" method="post">';
            echo '<input type=hidden name="imagePath" value="'. $_POST['newPicture'] .'">';
            echo '<input type="hidden" name="addImage" value="addImage">';
            echo '<img height="500px" width="500px" src="'. $_POST['newPicture'] .'" id="photo"> <br>';
            echo '<a href="#" class="addPicture">Add image</a>';
            echo '</form>';
        } ?>
    </div>
</form>


<script type="text/javascript">
(function() {
  var width = 500;
  var height = 500;

  var streaming = false;

  var video = null;
  var canvas = null;
  var photo = null;
  var startbutton = null;

  function startup() {
      video = document.getElementById('video');
      canvas = document.getElementById('canvas');
      photo = document.getElementById('photo');
      startbutton = document.getElementById('takePicButton');
      navigator.mediaDevices.getUserMedia({video: true, audio: false})
          .then(function(stream) {
              video.srcObject = stream;
              video.play();
          })
          .catch(function(err) {
              console.log("An error occured: " + err);
          }) ;
          video.addEventListener('canplay', function(ev) {
              if (!streaming) {
                  canvas.setAttribute('width', width);
                  canvas.setAttribute('height', height);
                  streaming = true;
              }
          }, false) ;
          takePicButton.addEventListener('click', function(ev) {
              takepicture();
              ev.preventDefault();
          }, false) ;
  }

  function takepicture() {
      var context = canvas.getContext('2d');
      if (width && height) {
          context.drawImage(video, 0, 0, width, height);
          var data = canvas.toDataURL('image/jpeg');
          document.querySelector('input[name="newPicture"]').value = data;
          document.querySelector(".montage").submit();
      }
  }
  window.addEventListener('load', startup, false);
}) ();

(() => {
    const initElement = element => {
        element = element.querySelector('.addPicture')
        element.addEventListener("click", (event) => {
        var data = canvas.toDataURL('image/jpeg');
        event.preventDefault()
        document.querySelector(".newPic").submit();
        
        })
    }
    Array.from(document.querySelectorAll('.newPic'))
            .forEach(initElement)
})()

image = document.getElementsByClassName("imageMontage")
for (var i = 0; i < image.length; i++) {
        image[i].addEventListener('click', function(event) {
        event.preventDefault()
        document.querySelector('input[name="selectedImage"]').value = event.target.getAttribute("src")
        document.querySelector(".img").submit()
    }, false)
}

upload = document.getElementsByClassName("upload")

</script>

</body>
</html>