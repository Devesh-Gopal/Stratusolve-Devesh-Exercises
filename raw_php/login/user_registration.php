<?php session_start();
$user = isset ($_SESSION['id'])? $_SESSION['id'] : 'none';
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
    <title>Register</title>
</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row second-container">
                <div class="col-md-6">
                    <img alt="" src="Logo.png" style="width: 80%;" class="left-img" />
                </div>
                <div class="col-md-6">
                    <form role="form" action="verify_registration.php" method="post">
                        <h3>Create your account with SS today.</h3>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="alert alert-success alert-dismissable" id="message">
                            <h3> Your password must adhere to the following requirements:</h3>
                            <p id="letter" class="invalid">- A <b>lowercase</b> letter</p>
                            <p id="capital" class="invalid">- An <b>uppercase</b> letter</p>
                            <p id="number" class="invalid">- A <b>number</b></p>
                            <p id="length" class="invalid">- Minimum <b>8 characters</b></p>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password" required>
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="signup" id="register" class="btn signup" value="Sign Up">
                        </div>

                        <p class="login-text">Already have an account? <a href="user_login.php" class="login-link" >Log In</a></p>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="register.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>