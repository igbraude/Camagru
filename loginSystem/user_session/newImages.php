<?php
 session_start();
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