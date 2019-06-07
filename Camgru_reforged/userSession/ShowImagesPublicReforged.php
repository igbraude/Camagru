<?php

/*

    File showImagesPublic :
        Display public image of everyone.
        User can click on the image to see the commentary, like, dislike of the pointed one.

*/

session_start();

include('../Class/Class.image.php');
include('../config/database-setup.php');

function getImages() {
    global $conn;
    $imgObject = [];
    $min = 0;
    $max = 5;
    $query = 'SELECT * FROM `image` LIMIT ' . $min .', ' . $max .'';

    foreach ($conn->query($query) as $row) {
        $img = new Images($row['image_id'], $row['username'], $row['path'], $row['like'], $row['dislike'], $row['private']);
        if ($imgObject == null) {
         $imgObject = array($img);
        }
        else  {
            array_push($imgObject, $img);
        }
    }
    return ($imgObject);
}

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
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


</head>

<body>

<header class="header-user-dropdown">

<div class="header-limiter">
    <h1><a href="./session.php">Camagru</a></h1>

    <nav>
        <a href="./showImages.php">My Gallery</a>
        <a href="./showImagesPublic.php">Public Gallery</a>
        <a href="./takePicture.php">Take Picture</a>
        <a href="./setting.php">Settings</a>
        <input type="hidden" name="logout" value="">
        <a href="./logout.php">Logout</a>

    </nav>
</div>

</header>