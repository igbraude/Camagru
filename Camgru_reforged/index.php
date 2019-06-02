<?php
$_SESSION['pageStore'] = "index.php";

if (!isset($_SESSION['login_id'])) {
    header("location: ./loginSystem/login.php"); //Redirecting to login page
}
?>