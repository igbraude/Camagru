<?php
include("../confi/database-setup.php");
if (isset($_GET['username']) && isset($_GET['password'])) {
    $username = $_GET['username'];
    $password = $_GET['password'];
    $query = "SELECT `user` WHERE `username`= ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$username]);
    $result = $stmt->fetch(PDO::FETCH_BOTH);
    if (password_verify($password, $result['password'])) {
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
        <li><a href="login.php">Sign In</a></li>
        <li><a href="register.php">Sign up</a></li>
    </ul>

</div>

</header>

</html>
<?php 
    }
    else {
        header("location: ../index.php");
    }
}
else {
    header("location: ../index.php");
}
?>