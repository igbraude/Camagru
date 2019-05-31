<?php
session_start();

include("./Class.image.php");

if (isset($_FILES['fileToUpload'])) {
    if ($_FILES['fileToUpload']['error'] != 0) {
        header ("location: takePicture.php");
    }
}

$uploadOk = 0;
if (isset($_POST['submit'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "jpeg") {
        echo "Sorry, only JPG, JPEG files are allowed.";
        $uploadOk = 0;
        header("location: takePicture.php");
    }
else {
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
            move_uploaded_file($_FILES['fileToUpload']['tmp_name'], 'uploads/' . basename($_FILES['fileToUpload']['name']));
            echo '<br>' . $_FILES['fileToUpload']['tmp_name'], 'uploads/' . basename($_FILES['fileToUpload']['name']);
        } else {
                echo "File is not an image.";
                $uploadOk = 0;
                header("location: takePicture.php");
            }
        } 
    }
}
if(isset($_POST['submit']) && $uploadOk == 1) {
    $dst = imagecreatefromjpeg('uploads/' .basename($_FILES["fileToUpload"]["name"]));
    $src = resize_imagejpeg('uploads/' .basename($_FILES["fileToUpload"]["name"]), 500, 500);
    imagejpeg($dst, "../userImage/imageMontage2.jpg");
    $info = exif_imagetype("../userImage/imageMontage2.jpg");
    echo $info;
    echo '<img height="200px" width="200px" src="../userImage/imageMontage.jpg" alt="photoMontage">';
}

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

//function to resize the uploaded image
function resize_imagejpeg($file, $w, $h, $crop=FALSE) {
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
            $newwidth = 500;
            $newheight = 500;
        } else {
            $newheight = 500;
            $newwidth = 500;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagesavealpha($dst, true);

    $trans_colour = imagecolorallocatealpha($dst, 0, 0, 0, 127);
    imagefill($dst, 0, 0, $trans_colour);
    
    $red = imagecolorallocate($dst, 255, 0, 0);
    imagefilledellipse($dst, 500, 500, $newwidth, $newheight, $red);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    return $dst;
}

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

if(isset($_POST['selectedImage'])) {
    $dst = imagecreatefromjpeg("../userImage/imageMontage2.jpg");
    $src = imagecreatefrompng($_POST['selectedImage']);
    $dst = resize_imagejpeg("../userImage/imageMontage2.jpg", 500, 500);
    if ($_POST['selectedImage'] == "../image/cigarette.png") {
        $src = resize_image($_POST['selectedImage'], 150, 150);
        //variable pour un montage plus precis a soustraire a $dst_x et $dst_y
        $min_x = 250;
        $min_y = 150;
    }
    else if ($_POST['selectedImage'] == "../image/cadre.png") {
        $src = resize_image($_POST['selectedImage'], 480, 430);
        //variable pour un montage plus precis a soustraire a $dst_x et $dst_y
        $min_x = 12;
        $min_y = 75;
    }
    else if ($_POST['selectedImage'] == "../image/camera.png") {
        $src = resize_image($_POST['selectedImage'], 150, 150);
        //variable pour un montage plus precis a soustraire a $dst_x et $dst_y
        $min_x = 350;
        $min_y = 350;
    }
    else if ($_POST['selectedImage'] == "../image/down.png") {
        $src = resize_image($_POST['selectedImage'], 150, 150);
        //variable pour un montage plus precis a soustraire a $dst_x et $dst_y
        $min_x = 350;
        $min_y = 350;
    }
    else if ($_POST['selectedImage'] == "../image/up.png") {
        $src = resize_image($_POST['selectedImage'], 150, 150);
        //variable pour un montage plus precis a soustraire a $dst_x et $dst_y
        $min_x = 350;
        $min_y = 350;
    }
    else if ($_POST['selectedImage'] == "../image/hat.png") {
        $src = resize_image($_POST['selectedImage'], 200, 200);
        //variable pour un montage plus precis a soustraire a $dst_x et $dst_y
        $min_x = 150;
        $min_y = 350;
    }
    else if ($_POST['selectedImage'] == "../image/load.png") {
        $src = resize_image($_POST['selectedImage'], 150, 150);
        //variable pour un montage plus precis a soustraire a $dst_x et $dst_y
        $min_x = 350;
        $min_y = 350;
    }
    else {
        $src = resize_image($_POST['selectedImage'], 350, 350);
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
    $_POST['uploadedImage'] = base64Image("../userImage/imageMontage.jpg");
}

print_r($_POST);
echo '<br>Files <br>';
print_r($_FILES);
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


<?php if (isset($_POST['selectedImage'])) {?>
    <form class="newPic" action="takePicture.php" enctype="multipart/form-data" method="post">
         <input type=hidden name="imagePath" value="<?php echo $_POST['uploadedImage'] ?>">
         <input type="hidden" name="addImage" value="addImage">
         <img width="500px" height="500px" src="../userImage/imageMontage.jpg" alt="cadre">
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
<?php } else { ?>
    <input type="hidden" name="uploadedPhoto" value="<?php echo $_FILES['fileToUpload']['tmp_name'], 'uploads/' . basename($_FILES['fileToUpload']['name']); ?>">
    <img width="500px" height="500px" src="<?php echo 'uploads/' .basename($_FILES["fileToUpload"]["name"]); ?>" alt="cadre">
<?php } ?>

<form class="img" enctype="multipart/form-data" method="post">
    Click on the montage you prefer
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
console.log(image.length);
for (var i = 0; i < image.length; i++) {
        image[i].addEventListener('click', function(event) {
        event.preventDefault()
        document.querySelector('input[name="selectedImage"]').value = event.target.getAttribute("src")
        console.log(event.target.getAttribute("src"))
       document.querySelector(".img").submit()
    }, false)
}
</script>

</body>
</html>