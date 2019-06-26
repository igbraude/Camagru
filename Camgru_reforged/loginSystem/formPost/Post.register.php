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
        $iQuery = "INSERT INTO `user` (username, email, `password`, `active`) value (?, ?, ?, ?)";

        $stmt = $conn->prepare($sQuery);
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_BOTH);
        if ($result['username'] == $fullName) {
            echo "<script> alert('This user already exists') </script>";
        }
        else {
        $stmt = $conn->prepare($iQuery);
        $stmt->execute(
            array(
                $fullName,
                $email,
                $hash,
                "N"
            )
        );
            $validAccount = 1;
            $to      = $fullName + "<" + $email + ">"; // Send email to our user
            $subject = 'Signup | Verification'; // Give the email a subject
            $message = "check\r\n"; 
            // $message = '
            
            // Thanks for signing up!
            // Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
            
            // ------------------------
            // Username: '.$fullName.'
            // Password: '.$password.'
            // ------------------------
            
            // Please click this link to activate your account:
            // localhost:8008/Archive/Camagru/Camagru/Camgru_reforged/loginSystem/verifyEmail.php?username='.$fullName.'&hash='.$hash.'
            
            // '; // Our message above including the link
                                
            $headers = 'From:noreply@Camagru.fr' . "\r\n"; // Set from headers
            //echo $to . "\n" . $subject . "\n" . $message . "\n" . $fullName . "\n" . $password . "\n" . $email . "\n" . $hash . "\n" . $headers;
            $validMail = mail("igorbraudel@gmail.com", 'helo', $message, $headers);
            if (!$validMail) {
                // $errorMessage = error_get_last()['message'];
                echo "error";
                print_r(error_get_last());
            }
            else {
                echo "check";
            }
            // if ($validMail == TRUE) {
            //     echo $to;
            //     echo "check mail !!";}
            // else {
            //     echo "fail mail";}
            // }
    }
}
// if ($validAccount == 1) {
//     header("location: login.php");
 }
?>