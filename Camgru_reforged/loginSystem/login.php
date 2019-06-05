<?php
/*
    File login :
        Login page, user can log with his login
        If password and username match with one in the database, the user connect.
        A Register button is here if an user doesn't have an account.
        A Forgot Password button is here if an user forgot is password.

*/


include("./formPost/Post.login.php");

    // if User exit session, User doesnt need to signin and signup
   if (isset($_SESSION['login_id'])) {
        if (isset($_SESSION['pageStore'])) {
            $pageStore = $_SESSION['pageStore'];
            header("location: $pageStore"); // Reddirection to profile page
        }
    }

?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Camagru</title>

    <link rel="stylesheet" href="css/header-login-signup.css">
    <link rel="stylesheet" href="css/form-login.css">
	<link href='http://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>

</head>

<body>

<header class="header-login-signup">

<div class="header-limiter">

    <h1><a href="#">Camagru</a></h1>

    <ul>
        <li><a href="#">Forgot Password ?</a></li>
        <li><a href="register.php">Sign up</a></li>
    </ul>

</div>

</header>
<form method="post">
<div class="form-log-in-with-email">

<div class="form-white-background">

    <div class="form-title-row">
        <h1>Log in</h1>
    </div>

    <div class="form-row">
        <label>
            <span>Username</span>
            <input type="username" name="username" requiered>
        </label>
    </div>

    <div class="form-row">
        <label>
            <span>Password</span>
            <input type="password" name="password" required>
        </label>
    </div>

    <div class="form-row">
        <button type="submit" name="signIn">Log in</button>
    </div>

</div>
</div>
<form>

</body>
</html>