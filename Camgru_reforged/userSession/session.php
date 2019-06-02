<?php
session_start ();
include('../config/database-setup.php');

if (isset($_GET['logout'])) {
    header("location: logout.php");
}

if (isset($_GET['takeNewPicture'])) {
    header("location: takePicture.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>Camagru</title>
</head>

<body>
    <header style="background-color:black;" class="header">
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

<div class="container">
    <div style="" class="contained">Here will be the gallerie
    <form method="get">
        <button type="submit" name="takeNewPicture" class="button-new-picture">Take a new picture</button>
    </form>
    <aside style="width:25%;float:right;text-align:right;" class="side-container">
        <div class="side-article-author">Article author</div>
    </div>
    </aside>
</div>

<footer class="footer">
    <div style="background-color: black;color:white;" class="site-footer--container">
        <p>Footer</p>
    </div>
</footer>

</body>
</html>