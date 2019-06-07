<?php
/*
    File setting :
        This file is about user login.
        User can change Password, email, username.
        He can also delete his profile or gallerie.
        A mail is send when an update is done.

*/
 
include("./formPost/Get.setting.php");

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


</head>

<body>

<header class="header-user-dropdown">

<div class="header-limiter">
    <h1><a href="./session.php">Camagru</a></h1>

    <nav>
        <a href="./showImages.php?page=1">My Gallery</a>
        <a href="./showImagesPublic.php?page=1">Public Gallery</a>
        <a href="./takePicture.php">Take Picture</a>
        <a href="./setting.php">Settings</a>
        <input type="hidden" name="logout" value="">
        <a href="./logout.php">Logout</a>

    </nav>
</div>

</header>
<form class="settings" method="get">
    <div class="settingContent">
        <input type="hidden" name="action" value="">
        <a href="#" name="password" class="settingEdit">Change Password</a><br>
        <a href="#" name="username" class="settingEdit">Change username</a><br>
        <a href="#" name="email" class="settingEdit">Change email</a><br>
        <a href="#" name="Delete profile" class="settingEdit">Delete Profile</a><br>
        <a href="#" name="Delete Gallerie" class="settingEdit">Delete Gallerie</a><br>
    </div>
</form>

<script>

    //check the new password if it match

    function checkPassword(input) {
        if (input.value != document.getElementById('newPassword').value) {
            input.setCustomValidity('Password Must be Matching.');
        } else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
        }
    }

    //check the new email if it match

    function checkEmail(input) {
        if (input.value != document.getElementById('newEmail').value) {
            input.setCustomValidity('Email Must be Matching.');
        } else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
        }
    }


    var setting = document.getElementsByClassName("settingEdit")
    for (var i = 0; i < setting.length; i++) {
        setting[i].addEventListener("click", function(event) {
            event.preventDefault()
            var change = event.target.getAttribute("name")
            document.querySelector('input[name="action"]').value = change
            if (change == "email") {
                console.log(change);
                document.querySelector(".settings").innerHTML = `
                <div class="new"> 
                    New email: <input type="email" name="newEmail" value="" id="newEmail" required>
                    Confirm email: <input type="email" name="confirmEmail" value"" id="confirmEmail" oninput="checkEmail(this)" required>
                    <input type="submit" name="action" value="Submit">
                </div>`
            }
            if (change == "password") {
                document.querySelector(".settings").innerHTML = `
                <div class="new"> 
                    Old password: <input type="password" name="oldPassword" value="" id="oldPassword" required>
                    New password: <input type="password" name="newPassword" value="" id="newPassword" required>
                    Confirm Password: <input type="password" name="confirmPassword" value="" id="confirmPassword" oninput="checkPassword(this)" required>
                    <input type="submit">
                </div>`
            }
            if (change == "username") {
                document.querySelector(".settings").innerHTML = `
                New username: <input type="text" name="newUsername" value="" required>
                    <input type="submit" name="action" value="Submit">
                `
            }
            if (change == "Delete profile") {

            }
            if (change == "Delete Gallerie") {

            }
        })
    }
    console.log(setting);
</script>
</body>
</html>