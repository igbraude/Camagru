<?php
session_start();
include("./Class.image.php");

// function to resize img for html balise
function imageResize($width, $height, $target) {

    if ($width > $height) {
    $percentage = ($target / $width);
    }
    else {
    $percentage = ($target / $height);
    }
    $width = round($width * $percentage);
    $height = round($height * $percentage);
    return 'width="'. $width .'" height="' .$height .'"';
}

//function to resize the image montage, maybe i can use it with some input and $_POST variable to make better montage
function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefrompng($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    $black = imagecolorallocate($dst, 0, 0, 0);
    imagecolortransparent($dst, $black);
    return $dst;
}

$src = imagecreatefrompng("../image/hat.png");
if(isset($_POST['newPicture'])) {
    $dst = imagecreatefrompng($_POST['newPicture']);
    $src = resize_image("../image/hat.png", 350, 350);
    $width_dst = imagesx($dst);
    $height_dst = imagesy($dst);
    $width_src = imagesx($src);
    $height_src = imagesy($src);
    echo $width_src, '<br>';
    echo $width_dst, '<br>';
    echo $height_src, '<br>';
    echo $height_dst, '<br>';
    $dst_x = $width_dst - $width_src;
    $dst_y =  $height_dst - $height_src;
    imagecopy($dst, $src, $dst_x, $dst_y, 0, 0, $width_src, $height_src);
    imagepng($dst, "../userImage/imageMontage.png");
    $info = exif_imagetype("../userImage/imageMontage.png");
    echo $info;
    echo '<img height="200px" width="200px" src="../userImage/imageMontage.png" alt="photoMontage">';
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
                    <a href="../session.php" name="session">Home</a><br>
                    <a href="profile.php" name="profile">Profile</a><br>
                    <a href="setting.php" name="settings">Settings</a><br>
                    <a href="showImages.php" name="gallerie">Gallerie</a>
                </div>
        </ul>
</header>


<form enctype="multipart/form-data" method="post">
    <div id="my_camera">
      <video width="500" height="500" id="video" controls>
      </video>
      <button type="submit" id="takePicButton">Take photo</button>
      <div class="montageImage">
        <img width="50px" height="50px" src="../image/cadre.png" alt="cadre">
        <img width="50px" height="50px" src="../image/camera.png" alt="cadre">
        <img width="50px" height="50px" src="../image/cigarette.png" alt="cadre">
        <img width="50px" height="50px" src="../image/down.png" alt="cadre">
        <img width="50px" height="50px" src="../image/hat.png" alt="cadre">
        <img width="50px" height="50px" src="../image/load.png" alt="cadre">
        <img width="50px" height="50px" src="../image/up.png" alt="cadre">
      </div>
    </div>
    <canvas width="500" height="500" style="display:none;" id="canvas"></canvas>
</form>


<form class="montage" enctype="multipart/form-data" method="post">
    <div id="imgMontage">
    <?php /*
        <input type="hidden" name="newPicture">
        <?php if (isset($_POST['submit']) && $_POST['submit'] == "UploadImage") {
            echo '<img width="320ps" height="240px" id="uploadedImg" src="" alt="uploadedImg"><br>';
        }
        else { ?>
        <img id="photo" alt="screenCapture"> <br>

        <?php } ?>
        <input type="submit" value="UploadImage" name="submit">
        <input type="file" value="fileToUpload" name="fileToUpload"/> */?>
    <input type="hidden" name="newPicture" value="">
    </form>
    <?php if (isset($_POST['newPicture'])) {
            echo  '<form class="newPic" enctype="multipart/form-data" method="post">';
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
          var data = canvas.toDataURL('image/png');
          document.querySelector('input[name="newPicture"]').value = data;
          console.log(document.querySelector('input[name="newPicture"]').value);
          document.querySelector(".montage").submit();
      }
  }
  window.addEventListener('load', startup, false);
}) ();

(() => {
    const initElement = element => {
        element = element.querySelector('.addPicture')
        element.addEventListener("click", (event) => {
        var data = canvas.toDataURL('image/png');
        event.preventDefault()
        console.log(data)
        document.querySelector(".newPic").submit();
        
        })
    }
    Array.from(document.querySelectorAll('.montage'))
            .forEach(initElement)
})()



</script>

</body>
</html>