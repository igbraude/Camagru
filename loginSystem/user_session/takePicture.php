<?php
session_start();
include("./Class.image.php");

// function to encode the montage in base64
function base64Image($path) {
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $base64;
}

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
    imagesavealpha($dst, true);

    $trans_colour = imagecolorallocatealpha($dst, 0, 0, 0, 127);
    imagefill($dst, 0, 0, $trans_colour);
    
    $red = imagecolorallocate($dst, 255, 0, 0);
    imagefilledellipse($dst, 500, 500, $newwidth, $newheight, $red);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    //$black = imagecolorallocate($dst, 0, 0, 0);
    //imagecolortransparent($dst, $black);
    return $dst;
}

if(isset($_POST['newPicture'])) {
    $dst = imagecreatefromjpeg($_POST['newPicture']);
    $src = imagecreatefrompng($_POST['imgSelect']);

    if ($_POST['imgSelect'] == "../image/cigarette.png") {
        $src = resize_image($_POST['imgSelect'], 150, 150);
        //variable pour un montage plus precis a soustraire a $dst_x et $dst_y
        $min_x = 250;
        $min_y = 150;
    }
    else if ($_POST['imgSelect'] == "../image/cadre.png") {
        $src = resize_image($_POST['imgSelect'], 480, 430);
        //variable pour un montage plus precis a soustraire a $dst_x et $dst_y
        $min_x = 12;
        $min_y = 75;
    }
    else if ($_POST['imgSelect'] == "../image/camera.png") {
        $src = resize_image($_POST['imgSelect'], 150, 150);
        //variable pour un montage plus precis a soustraire a $dst_x et $dst_y
        $min_x = 350;
        $min_y = 350;
    }
    else if ($_POST['imgSelect'] == "../image/down.png") {
        $src = resize_image($_POST['imgSelect'], 150, 150);
        //variable pour un montage plus precis a soustraire a $dst_x et $dst_y
        $min_x = 350;
        $min_y = 350;
    }
    else if ($_POST['imgSelect'] == "../image/up.png") {
        $src = resize_image($_POST['imgSelect'], 150, 150);
        //variable pour un montage plus precis a soustraire a $dst_x et $dst_y
        $min_x = 350;
        $min_y = 350;
    }
    else if ($_POST['imgSelect'] == "../image/hat.png") {
        $src = resize_image($_POST['imgSelect'], 200, 200);
        //variable pour un montage plus precis a soustraire a $dst_x et $dst_y
        $min_x = 150;
        $min_y = 350;
    }
    else if ($_POST['imgSelect'] == "../image/load.png") {
        $src = resize_image($_POST['imgSelect'], 150, 150);
        //variable pour un montage plus precis a soustraire a $dst_x et $dst_y
        $min_x = 350;
        $min_y = 350;
    }
    else {
        $src = resize_image($_POST['imgSelect'], 350, 350);
        $min_x = 0;
        $min_y = 0;
    }

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
    imagecopy($dst, $src, $dst_x - $min_x, $dst_y - $min_y, 0, 0, $width_src, $height_src);
    imagejpeg($dst, "../userImage/imageMontage.jpg");
    $info = exif_imagetype("../userImage/imageMontage.jpg");
    echo $info;
    echo '<img height="200px" width="200px" src="../userImage/imageMontage.jpg" alt="photoMontage">';
    $_POST['newPicture'] = base64Image("../userImage/imageMontage.jpg");
}

if (isset($_POST['selectedImage'])) {
    $disabled = null;
}
else {
    $disabled = "disabled";
}

echo 'Post <br>';
print_r($_POST);
echo '<br>Files <br>';
print_r($_FILES);

//echo $_FILES['fileToUpload']['error'];

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


<form class="img" enctype="multipart/form-data" method="post">
    <div id="my_camera">
      <video width="500" height="500" id="video" controls>
      </video>
      <button type="submit" id="takePicButton" <?php if ($disabled != null) { echo $disabled; } ?>>Take photo</button>
      <div class="montageImage">
        <input type="hidden" name="selectedImage" value="">
         <a href="#" class="imageMontage"><img width="50px" height="50px" src="../image/cadre.png" alt="cadre"></a>
         <a href="#" class="imageMontage"><img width="50px" height="50px" src="../image/camera.png" alt="cadre"></a>
         <a href="#" class="imageMontage"><img width="50px" height="50px" src="../image/cigarette.png" alt="cadre"></a>
         <a href="#" class="imageMontage"><img width="50px" height="50px" src="../image/down.png" alt="cadre"></a>
         <a href="#" class="imageMontage"><img width="50px" height="50px" src="../image/hat.png" alt="cadre"></a>
         <a href="#" class="imageMontage"><img width="50px" height="50px" src="../image/load.png" alt="cadre"></a>
         <a href="#" class="imageMontage"><img width="50px" height="50px" src="../image/up.png" alt="cadre"></a>
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
          console.log(document.querySelector('input[name="imgSelect"]').value);
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
        console.log(data)
        document.querySelector(".newPic").submit();
        
        })
    }
    Array.from(document.querySelectorAll('.newPic'))
            .forEach(initElement)
})()

image = document.getElementsByClassName("imageMontage")
console.log(image.length);
for (var i = 0; i < image.length; i++) {
        image[i].addEventListener('click', function(event) {
        event.preventDefault()
        document.querySelector('input[name="selectedImage"]').value = event.target.getAttribute("src")
        document.querySelector(".img").submit()
    }, false)
}

upload = document.getElementsByClassName("upload")
console.log(upload)

</script>

</body>
</html>