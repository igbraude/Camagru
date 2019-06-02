<?php
/*

    Formulaire Post : ref: ../register.php
        $_POST['signup'] ---> User pressed the signup button. Check if the inputs are not empty or if the username is already taken.
                            insert into the database the new user. He can now connect.

*/
session_start();
$validAccount = 0;
if (isset($_POST['signUp'])) {
    if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['newPassword'])) {
        echo "Please fill up all the required field.";
    }
    else {
        $fullName = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['newPassword'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        include('../config/database-setup.php');

        $sQuery = "SELECT `user_id`, `username`, `password` FROM `user` WHERE email = ?";
        $iQuery = "INSERT INTO `user` (username, email, `password`) value (?, ?, ?)";

        $stmt = $conn->prepare($sQuery);
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        if ($result->username == $fullName) {
            echo "This user already exists";
        }
        else {
        $stmt = $conn->prepare($iQuery);
        $stmt->execute(
            array(
                $fullName,
                $email,
                $hash
            )
        );
        $validAccount = 1;
        }
    }
}
if ($validAccount == 1) {
    header("location: login.php");
}
?>