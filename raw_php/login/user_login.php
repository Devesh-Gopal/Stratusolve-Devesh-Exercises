<?php
session_start();
$user_id = isset($_SESSION['userid']) ? $_SESSION['userid'] : 'none';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../js/sweetAlert.js"></script>

    <link rel="stylesheet" href="user_login.css">
    <title>Login</title>
</head>

<body>

<div class="container">
    <div class="row">
            <div class="row second-container">
                <div class="col-md-6">
                    <img alt="" src="Logo.png" style="width: 80%;" class="left-img" />
                </div>
                <div class="col-md-6">
                    <form role="form" action="verify_login.php" method="post">

                        <h3>Sign in to SS.</h3>

                        <div class="form-group">
                            <input type="text" class="form-control" name="email" id="email" placeholder="Username or Email Address" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <p class="forgot-password"><a href="forgotPassword.php">Forgot Password?</a></p>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="login" id="login" class="btn login" value="Log In">
                        </div>
                        <p class="signup-text">Don't have an account? <a href="user_registration.php" class="signup-link">Sign Up</a></p>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>