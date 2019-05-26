<?php
// starting session
session_start();
 // if User exit session, User doesnt need to signin and signup
if(isset($_SESSION['login_id'])) {
    if(isset($_SESSION['pageStore'])) {
        $pageStore = $_SESSION['pageStore'];
        header("location: $pageStore"); // Reddirection to profile page
    }
}

// Sign in buttom , login process start
if (isset($_POST['signUp'])) {
    if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['newPassword'])) {
        echo "Please fill up all the required field.";
    }
    else {
        $fullName = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['newPassword'];
        $hash = password_hash($password, PASSWORD_DEFAULT);

        //Make a connection with mySQL server
        include('config.php');

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
    }
        //to protect from mySQL injection

 /*       $stmt = $conn->prepare($sQuery);

        $rnum = $stmt->num_rows;

        if ($rnum == 0) {
            $stmt->close();

            $stmt = $conn->prepare($iQuery);
            $stmt->bind_param("sss", $fullName, $email, $hash);
            if($stmt->execute()) {
                echo "Register sucessfully, Please login with login details";
            }
            else {
               echo "Someone already register with this ($email) email address"; 
            }
            $stmt->close();
            $conn->close(); //Closing database connection
        } */
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="rlform.css">
    </head>
    <body>
        <div class="rlform">
            <div class="rlform rlform-wrapper">
                <div class="rlform-box">
                    <div class="rlform-box-inner">
                        <form method="post" oninput="validatePassword()">
                            <p>Let's create your account</p>

                            <div class="rlform-group">
                                <label>Username</label>
                                <input type="text" name="username" class="rlform-input"
                                required>
                            </div>

                            <div class="rlform-group">
                                <label>Email</label>
                                <input type="email" name="email" class="rlform-input"
                                required>
                            </div>

                            <div class="rlform-group">
                                <label>Password</label>
                                <input type="password" name="newPassword" id="newPass" class="rlform-input"
                                required>
                            </div>

                            <div class="rlform-group">
                                <label>Confirm password</label>
                                <input type="password" name="confirmPassword" id="confirmPass" class="rlform-input"
                                required>
                            </div>

                            <button class="rlform-btn" name="signUp">Sign Up</button>
                            <div class="text-foot">
                                Already have an account ?
                                <a href="login.php">Login</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function validatePassword() {
                if(newPass.value != confirmPass.value) {
                    confirmPass.setCustomValidity('Password do not match.');
                }
                else {
                    confirmPass.setCustomValidity('');
                }
            }
        </script>
    </body>
</html>





                            
