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
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Register</title>
    </head>
    <body>
        <div>
            <div>
                <div>
                    <div>
                        <form method="post" oninput="validatePassword()">
                            <p>Let's create your account</p>

                            <div>
                                <label>Username</label>
                                <input type="text" name="username"
                                required>
                            </div>

                            <div>
                                <label>Email</label>
                                <input type="email" name="email"
                                required>
                            </div>

                            <div>
                                <label>Password</label>
                                <input type="password" name="newPassword" id="newPass"
                                required>
                            </div>

                            <div>
                                <label>Confirm password</label>
                                <input type="password" name="confirmPassword" id="confirmPass"
                                required>
                            </div>

                            <button name="signUp">Sign Up</button>
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