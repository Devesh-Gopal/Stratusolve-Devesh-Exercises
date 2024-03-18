<?php
include 'database_connection.php';

session_start();

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $verify_query = "SELECT VerifyToken, VerifyStatus FROM User WHERE VerifyToken = '$token' LIMIT 1";
    $verify_query_run = mysqli_query($conn, $verify_query);

    if (mysqli_num_rows($verify_query_run) > 0) {
        $row = mysqli_fetch_array($verify_query_run);

        if ($row['VerifyStatus'] == "0") {
            $clicked_token = $row['VerifyToken'];
            $update_sql = "UPDATE User SET VerifyStatus='1' WHERE VerifyToken = '$clicked_token' LIMIT 1";
            $update_sql_result = mysqli_query($conn, $update_sql);

            if ($update_sql_result) {
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
                echo '<script src="../js/sweetAlerts.js"></script>';
                echo "<script>";
                echo "document.addEventListener('DOMContentLoaded', function() {";
                echo "showAlert('success', 'Valid', 'You have been successfully verified. Please login.', 'login.php');";
                echo "});";
                echo "</script>";
                exit;
            } else {
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
                echo '<script src="../js/sweetAlerts.js"></script>';
                echo "<script>";
                echo "document.addEventListener('DOMContentLoaded', function() {";
                echo "showAlert('error', 'Invalid', 'Verification failed.', 'register.php');";
                echo "});";
                echo "</script>";
                exit;
            }
        } else {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
            echo '<script src="../js/sweetAlerts.js"></script>';
            echo "<script>";
            echo "document.addEventListener('DOMContentLoaded', function() {";
            echo "showAlert('error', 'Invalid', 'Email already verified. Please login.', 'login.php');";
            echo "});";
            echo "</script>";
            exit;
        }
    } else {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
        echo '<script src="../js/sweetAlerts.js"></script>';
        echo "<script>";
        echo "document.addEventListener('DOMContentLoaded', function() {";
        echo "showAlert('error', 'Invalid', 'This token does not exist.', 'register.php');";
        echo "});";
        echo "</script>";
        exit;
    }
} else {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
    echo '<script src="../js/sweetAlerts.js"></script>';
    echo "<script>";
    echo "document.addEventListener('DOMContentLoaded', function() {";
    echo "showAlert('error', 'Invalid', 'Not allowed.', 'register.php');";
    echo "});";
    echo "</script>";
    exit;
}

mysqli_close($conn);

