<?php
include 'database_connection.php';
session_start();


function sanitise_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function normalizeEmail($email) {
    return strtolower($email);
}

if (isset($_POST['login'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = normalizeEmail(sanitise_input($_POST['email']));
        $password = sanitise_input($_POST['password']);

        $sql_login = "SELECT * FROM Users WHERE EmailAddress = ? LIMIT 1";
        $stmt = $conn->prepare($sql_login);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

                $userid = $row['UserId'];
                $firstname = $row['FirstName'];
                $lastname = $row['LastName'];
                $email = $row['EmailAddress'];

            if (password_verify($password, $row['Password'])) {
                // Allow login without email verification
                // if ($row['VerifyStatus'] == "1") {
                $_SESSION['userid'] = $row['UserId'];
                $_SESSION['firstname'] = $row['FirstName'];
                $_SESSION['lastname'] = $row['LastName'];
                $_SESSION['email'] = $row['EmailAddress'];

                header("Location: ../homepage.php");
                exit;
                // } else {
                //     echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
                //     echo '<script src="../js/sweetAlerts.js"></script>';
                //     echo "<script>";
                //     echo "document.addEventListener('DOMContentLoaded', function() {";
                //     echo "showAlert('error', 'Invalid', 'Please verify your email address to login', 'login.php');";
                //     echo "});";
                //     echo "</script>";
                //     exit;
                // }
            } else {
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
                echo '<script src="../js/sweetAlerts.js"></script>';
                echo "<script>";
                echo "document.addEventListener('DOMContentLoaded', function() {";
                echo "showAlert('error', 'Invalid', 'Login failed. Invalid password', 'login.php');";
                echo "});";
                echo "</script>";
                exit;
            }
        } else {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
            echo '<script src="../js/sweetAlerts.js"></script>';
            echo "<script>";
            echo "document.addEventListener('DOMContentLoaded', function() {";
            echo "showAlert('error', 'Invalid', 'Login failed. Invalid email', 'login.php');";
            echo "});";
            echo "</script>";
            exit;
        }
    }
}

mysqli_close($conn);




