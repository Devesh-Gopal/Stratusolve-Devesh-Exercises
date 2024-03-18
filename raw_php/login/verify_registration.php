<?php

include 'database_connection.php';

//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
//use PHPMailer\PHPMailer\Exception;

//include 'vendor/autoload.php';

function sanitise_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function normalizeEmail($email)
{
    return strtolower($email);
}

//function sendEmail($firstname, $email, $verifytoken)
//{
//    try {
//        $mail = new PHPMailer(true);
//
//        $mail->isSMTP();
//        $mail->Host = 'smtp-mail.outlook.com';
//        $mail->SMTPAuth = true;
//        $mail->Username = 'socialsphere@outlook.com';
//        $mail->Password = 'SocialSphere100';
//        $mail->SMTPSecure = 'tls'; // or 'ssl'
//        $mail->Port = 587; // or 465 for SSL
//
//        $mail->setFrom('socialsphere@outlook.com', 'Social Sphere');
//        $mail->addAddress($email);
//
//        $mail->isHTML(true);
//        $mail->Subject = "Email Verification from Social Sphere";
//
//        $templatePath = '../templates/register_email.html';
//        $emailMessage = file_get_contents($templatePath);
//
//        $verifyLink = "http://localhost/raw_php/verify_email.php?token=$verifytoken";
//
//        $emailMessage = str_replace('[FirstName]', $firstname, $emailMessage);
//        $emailMessage = str_replace('href="https://www.example.com"', "href='$verifyLink'", $emailMessage);
//        $emailMessage = str_replace('[ButtonText]', "Click Me", $emailMessage);
//
//        $mail->Body = $emailMessage;
//        $mail->send();
//
//    } catch (Exception $e) {
//        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
//    }
//}

if (isset($_POST['signup'])) {
    $firstname = mysqli_real_escape_string($conn, sanitise_input($_POST["firstname"]));
    $lastname = mysqli_real_escape_string($conn, sanitise_input($_POST["lastname"]));
    $email = normalizeEmail(mysqli_real_escape_string($conn, sanitise_input($_POST["email"])));
    $password = mysqli_real_escape_string($conn, sanitise_input($_POST["password"]));
    $cpassword = mysqli_real_escape_string($conn, sanitise_input($_POST["cpassword"]));
    $verifytoken = md5(rand());

    $email_validation_regex = "/^[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/";
    // $email_validation_regex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $email_to_check = $email;

    if (strlen($password) < 8 || !preg_match("/[a-z]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password)) {
        echo "Password must be at least 8 characters long and include at least one lowercase character, one uppercase character, and one number";
        exit;
    }

    if (filter_var($email_to_check, FILTER_VALIDATE_EMAIL)) {
        if (strlen($firstname) > 2 && strlen($lastname) > 2) {
            $sql = "SELECT * FROM Users WHERE EmailAddress = '$email'";
            $result = mysqli_query($conn, $sql);
            $count_email = mysqli_num_rows($result);

            if ($count_email === 0) {
                if ($password == $cpassword) {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $default_img_path = 'logo.png';

                    $stmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, EmailAddress, Password, VerifyToken, ImgPath) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssss", $firstname, $lastname, $email, $hash, $verifytoken, $default_img_path);



                    $stmt->execute();
                    $stmt->close();

                    if ($stmt) {
                        // sendEmail("$firstname", "$email", "$verifytoken");

                        echo "Registered successfully.";
                        exit;
                    }
                } else {
                    echo "Password and confirm password do not match";
                    exit;
                }
            } else {
                echo "An account with this email address already exists";
                exit;
            }
        } else {
            echo "Names should be longer than 2 characters";
            exit;
        }
    } else {
        echo "The email address is not valid. Valid email addresses should have a fullstop and a @ sign, EG: yourname@mail.com";
        exit;
    }

    mysqli_close($conn);
}


