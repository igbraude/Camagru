<?php
$_SESSION['pageStore'] = "index.php";

if (!isset($_SESSION['login_id'])) {
    header("location: login.php"); //Redirecting to login page
}

echo '<div style="font-size: 35px"
<strong>Profile</strong>
<br>'
.$session-fullName
.'</br>
<a href="setting.php">Setting</a>
<a href="logout.php">Logout</a>
</div>';
?>