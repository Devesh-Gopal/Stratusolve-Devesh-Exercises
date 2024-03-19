<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    // Handle the case when the user is not logged in
    // For example, redirect to the login page
    header("Location: login.php");
    exit();
}

// Check if the post ID is provided and valid
if (isset($_POST['post_id']) && is_numeric($_POST['post_id'])) {
    $postId = $_POST['post_id'];

    // Database connection
    include "database_connection.php"; // Adjust the path as needed

    // SQL query to delete the post
    $deleteQuery = "DELETE FROM posts WHERE post_id = $postId";

    // Execute the query
    if (mysqli_query($conn, $deleteQuery)) {
        // Post deleted successfully
        echo json_encode(array('success' => true));
    } else {
        // Error deleting post
        echo json_encode(array('success' => false, 'message' => 'Error deleting post.'));
    }

    // Close database connection
    mysqli_close($conn);
} else {
    // Invalid post ID provided
    echo json_encode(array('success' => false, 'message' => 'Invalid post ID.'));
}
