<?php
    // starting session
    session_start(); 
    // if User exit session, User doesnt need to signin and signup
   if (isset($_SESSION['login_id'])) {
        if (isset($_SESSION['pageStore'])) {
            $pageStore= $_SESSION['pageStore'];
            header("location: $pageStore"); // Reddirection to profile page
        }
    }
    
    // Sign in buttom , login process start
    if (isset($_POST['signIn'])) {
        if (empty($_POST['username']) || empty($_POST['password'])) {
            echo "Username and Password should not be empty";
        }
        else {
            // Connection with mySQL server
            include('config.php');
            $username = $_POST['username'];
            $stmt = $conn->prepare("SELECT `user_id`, `username`, `password` FROM `user` WHERE `username` = ?");
            $stmt->execute([$username]);
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            echo $_POST['password'];
            if (password_verify($_POST['password'], $result->password))
            {
                $conn = NULL;
                $_SESSION['username'] =  $_POST['username'];

                header('location: session.php');
            }
            else {
                echo "Email or Password not valid";
            }
          /*  $count = $stmt->rowCount();
           if ($count > 0) {
                $_SESSION["username"] = $_POST["username"];
                header("location: session.php");
            }
            else {
                header("location: index.php");
            }*/
           /* if ($stmt->fetch()) {
                if(password_verify($password, $hash)) {
                    $_SESSION['login_id'] = $id;
                    
                    if (isset($_SESSION['pageStore'])) {
                        $pageStore = $_SESSION['pageStore'];
                    }
                    else {
                        $pageStore = "index.php";
                    }
                    header("location: $pageStore"); // Reddirecting to profile page
                    $stmt->close();
                    $conn->close();
                }
                else {
                    echo "Invalid Username or Password";
                }
                $stmt->close();
                $conn->close();
             }*/
        }
    }
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Camagru</title>
    <link rel="stylesheet" type="text/css" href="rlform.css">

</head>

<body>
    <div class="rlform">
        <div class="rlform rlform-wrapper">
            <div class="rlform-box">
                <form method="post">
                    <p>Signin to continue</p>
                    
                    <div class="rlform-group">
                        <label>Username</label>
                        <input type="username" name="username" class="rlform-input"
                        required>
                    </div>

                    <div class="rlform-group">
                        <label>Password</label>
                        <input type="password" name="password" class="rlform-input"
                        required>
                    </div>

                    <button type="submit" class="rlform-btn" name="signIn">Sign in</button>
                    <div class="text-foot">
                        Don't have an account ?<a href="register.php">Register</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>