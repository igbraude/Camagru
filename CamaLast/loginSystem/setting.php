<?php
session_start();


include("config.php");
$query = sprintf('SELECT * FROM `user` WHERE `username`="%s"', $_SESSION['username']);
$stmt = $conn->prepare($query);
$stmt->execute();
$search = $stmt->fetch(PDO::FETCH_OBJ);

if (isset($_POST['oldPassword'])) {
    if (password_verify($_POST['oldPassword'], $search->password)) {
        // here change Password
        include("config.php");
        echo '<script> alert("Your Password has been change") </script>';
        $query = sprintf('UPDATE `user` SET `password`="%s" WHERE `username`="%s"',password_hash($_POST['newPassword'], PASSWORD_DEFAULT), $_SESSION['username']);
        $stmt = $conn->prepare($query);
        $stmt->execute();
    }
    else {
        echo '<script> alert("Old password does not match") </script>';
    }
}

if (isset($_POST['newUsername'])) {
    include("config.php");
    $query = sprintf('SELECT * FROM `user` WHERE `username`="%s"', $_POST['newUsername']);
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $usernameCheck = $stmt->fetch(PDO::FETCH_OBJ);

    if ($usernameCheck == null) {
        // here change username
        $query = sprintf('UPDATE `user` SET `username`="%s" WHERE `username`="%s"',$_POST['newUsername'], $_SESSION['username']);
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $_SESSION['username'] = $_POST['newUsername'];
    }
    else {
        echo '<script> alert("This username is already taken") </script>';
    }

}

if (isset($_POST['changeEmail'])) {
    //here change mail
    include("config.php");
    $query = sprintf('UPDATE `user` SET `email`="%s" WHERE `username`="%s"',$_POST['newEmail'], $_SESSION['username']);
    $stmt = $conn->prepare($query);
    $stmt->execute();
}

echo '<br><br>';

echo 'Post variable: <br>';
var_dump($_POST);
echo '<br> Get variable: <br>';
var_dump($_GET);
echo '<br> FILES variable: <br>';
var_dump($_FILES);
echo '<br> Session variable: <br>';
var_dump($_SESSION);

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
                    <a href="user_session/showImages.php" name="gallerie">Gallerie</a>
                </div>
        </ul>
</header>
<form class="settings" method="post">
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