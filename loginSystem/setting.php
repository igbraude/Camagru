<?php
include('session.php');
$_SESSION['pageStore'] = "setting.php";
if(isset($_SESSION['login_id'])) {
    header("location: login.php"); //Redirecting to login page
}
?>