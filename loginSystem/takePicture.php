<?php 
session_start();
include ('config.php');

if (isset($_POST['logout'])) {
    header("location: logout.php");
}
?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">

    <title>Camagru</title>
    <link rel="stylesheet" type="text/css" href="video.css">
    <link rel="stylesheet" type="text/css" href="rlform.css">
    <link rel="stylesheet" type="text/css" href="header.css">
</head>

<body>
    <header  style="background-color:black;" class="header">
        <ul>
                <form method="post">
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
                    <a href="gallerie.php" name="gallerie">Gallerie</a>
                </div>
        </ul>
</header>

<div class="container">
<div style="position:absolute;" id="container">
    <video  id="video"></video>
    <button id="capture" class="capture-buttom">Take photo</button>
    <canvas id="canvas"></canvas></div>
    <script src="js/photo.js"></script>
    <aside style="width:25%;float:right;text-align:right;" class="side-container">
        <div class="side-article-author">My Images Stackables</div>
        </div>
    </aside>
</div>

<footer style="width:0px;" class="footer">
    <div style="background-color: black;color:white;" class="site-footer--container">
        <p>Footer</p>
    </div>
</footer>

</body>
</html>