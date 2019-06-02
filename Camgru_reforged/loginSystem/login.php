<?php
/*
    File login :
        Login page, user can log with his login
        If password and username match with one in the database, the user connect.
        A Register button is here if an user doesn't have an account.
        A Forgot Password button is here if an user forgot is password.

*/


include("./formPost/Post.login.php");

    // if User exit session, User doesnt need to signin and signup
   if (isset($_SESSION['login_id'])) {
        if (isset($_SESSION['pageStore'])) {
            $pageStore = $_SESSION['pageStore'];
            header("location: $pageStore"); // Reddirection to profile page
        }
    }

?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Camagru</title>

</head>

<body>
    <div>
        <div>
            <div>
                <form method="post">
                    <p>Signin to continue</p>
                    
                    <div >
                        <label>Username</label>
                        <input type="username" name="username"
                        required>
                    </div>

                    <div>
                        <label>Password</label>
                        <input type="password" name="password"
                        required>
                    </div>

                    <button type="submit" name="signIn">Sign in</button>
                    <div>
                        Don't have an account ?<a href="register.php">Register</a>
                    </div>
                    <div>
                        Forgot Password ?<a href="register.php">here</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>