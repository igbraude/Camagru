<?php 

include("./formPost/Post.register.php");

if(isset($_SESSION['login_id'])) {
    if(isset($_SESSION['pageStore'])) {
        $pageStore = $_SESSION['pageStore'];
        header("location: $pageStore");
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

    <link rel="stylesheet" href="css/form-register.css">
	<link rel="stylesheet" href="css/header-login-signup.css">
	<link href='http://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>

</head>

<body>

<header class="header-login-signup">

<div class="header-limiter">

    <h1><a href="#">Camagru</a></h1>

    <ul>
        <li><a href="#">Forgot Password ?</a></li>
        <li><a href="login.php">Sign in</a></li>
    </ul>

</div>

</header>
<body>
<form class="form-register" method="post" oninput="validatePassword()">

            <div class="form-register-with-email">

                <div class="form-white-background">

                    <div class="form-title-row">
                        <h1>Create an account</h1>
                    </div>

                    <div class="form-row">
                        <label>
                            <span>Name</span>
                            <input type="text" name="username" required>
                        </label>
                    </div>

                    <div class="form-row">
                        <label>
                            <span>Email</span>
                            <input type="email" name="email" required>
                        </label>
                    </div>

                    <div class="form-row">
                        <label>
                            <span>Password</span>
                            <input type="password" name="newPassword" =id="newPass" required>
                        </label>
                    </div>

                    <div class="form-row">
                        <label>
                            <span>Confirm Password</span>
                            <input type="password" name="confirmPassword" id="confirmPass" required>
                        </label>
                    </div>

                    <div class="form-row">
                        <button type="submit" name="signUp" action="./login.php">Register</button>
                    </div>

                </div>

        </form>
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