<?php
//session_start();
//
//// Check if the user is logged in
//if (!isset($_SESSION['userid'])) {
//    // User is not logged in, handle accordingly (redirect to login page or show an error message)
//    exit("Error: User not logged in");
//}
//
//// Check if the post text is set
//if (!isset($_POST['post_text'])) {
//    exit("Error: Post text not provided");
//}
//
//// Establish database connection
//$SERVER_NAME = "127.0.0.1";
//$USERNAME = "root";
//$PASSWORD = "Devesh0905";
//$DB_NAME = "RawPhp";
//
//// Create a new database connection
//$conn = new mysqli($SERVER_NAME, $USERNAME, $PASSWORD, $DB_NAME);
//
//// Check connection
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}
//
//// Prepare and bind SQL statement to insert post into database
//$stmt = $conn->prepare("INSERT INTO Posts (PostTimeStamp, PostText, UserId) VALUES (NOW(), ?, ?)");
//$stmt->bind_param("si", $post_text, $user_id);
//
//// Set parameters and execute statement
//$user_id = $_SESSION['userid'];
//$post_text = $_POST['post_text'];
//
//// Execute the statement
//if ($stmt->execute() === TRUE) {
//    echo "Post added successfully";
//} else {
//    echo "Error: " . $stmt->error;
//}
//
//// Close statement and database connection
//$stmt->close();
//$conn->close();




//session_start();
//
//// Check if the user is logged in
//if (!isset($_SESSION['userid'])) {
//    // User is not logged in, handle accordingly (redirect to login page or show an error message)
//    exit("Error: User not logged in");
//}
//
//// Check if the post text is set
//if (!isset($_POST['post_text'])) {
//    exit("Error: Post text not provided");
//}
//
//// Establish database connection
//$SERVER_NAME = "127.0.0.1";
//$USERNAME = "root";
//$PASSWORD = "Devesh0905";
//$DB_NAME = "RawPhp";
//
//// Create a new database connection
//$conn = new mysqli($SERVER_NAME, $USERNAME, $PASSWORD, $DB_NAME);
//
//// Check connection
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}
//
//// Handle image upload
//$imageURL = ''; // Initialize imageURL variable
//if (isset($_FILES['post_image']) && $_FILES['post_image']['error'] === UPLOAD_ERR_OK) {
//    $targetDir = "uploads/"; // Directory where images will be stored
//    $targetFile = $targetDir . basename($_FILES['post_image']['name']);
//    $uploadOk = 1;
//    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
//
//    // Check if file already exists
//    if (file_exists($targetFile)) {
//        echo "Error: File already exists.";
//        $uploadOk = 0;
//    }
//
//    // Check file size
//    if ($_FILES['post_image']['size'] > 500000) {
//        echo "Error: File is too large.";
//        $uploadOk = 0;
//    }
//
//    // Allow only certain file formats
//    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
//        && $imageFileType != "gif") {
//        echo "Error: Only JPG, JPEG, PNG & GIF files are allowed.";
//        $uploadOk = 0;
//    }
//
//    // Check if $uploadOk is set to 0 by an error
//    if ($uploadOk == 0) {
//        echo "Error: File was not uploaded.";
//    } else {
//        if (move_uploaded_file($_FILES['post_image']['tmp_name'], $targetFile)) {
//            // Concatenate directory path with filename to form complete URL
//            $imageURL = $targetFile;
//        } else {
//            echo "Error: There was an error uploading your file.";
//        }
//    }
//} else {
//    echo "Error: File upload error.";
//}
//
//// Prepare and bind SQL statement to insert post into database
//$stmt = $conn->prepare("INSERT INTO Posts (PostTimeStamp, PostText, UserId) VALUES (NOW(), ?, ?)");
//$stmt->bind_param("si", $post_text, $user_id);
//
//// Set parameters and execute statement
//$user_id = $_SESSION['userid'];
//$post_text = $_POST['post_text'];
//
//// Execute the statement
//if ($stmt->execute() === TRUE) {
//    echo "Post added successfully";
//} else {
//    echo "Error: " . $stmt->error;
//}
//
//// Close statement
//$stmt->close();
//
//// If imageURL is not empty, store image details in the Pictures table
//if (!empty($imageURL)) {
//    // Prepare and bind SQL statement to insert image into database
//    $stmt_img = $conn->prepare("INSERT INTO Pictures (UserId, ImageURL, Caption, UploadTimestamp) VALUES (?, ?, ?, NOW())");
//    $stmt_img->bind_param("iss", $user_id, $imageURL, $caption);
//
//    // Set parameters and execute statement
//    $caption = ''; // Provide default caption if not provided
//    if (isset($_POST['caption'])) {
//        $caption = $_POST['caption'];
//    }
//
//    // Execute the statement
//    if ($stmt_img->execute() === TRUE) {
//        echo "Image added successfully";
//    } else {
//        echo "Error: " . $stmt_img->error;
//    }
//
//    // Close statement
//    $stmt_img->close();
//}
//
//// Close database connection
//$conn->close();


session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    // User is not logged in, handle accordingly (redirect to login page or show an error message)
    exit("Error: User not logged in");
}

// Check if the post text is set
if (!isset($_POST['post_text'])) {
    exit("Error: Post text not provided");
}

// Establish database connection
$SERVER_NAME = "127.0.0.1";
$USERNAME = "root";
$PASSWORD = "Devesh0905";
$DB_NAME = "RawPhp";

// Create a new database connection
$conn = new mysqli($SERVER_NAME, $USERNAME, $PASSWORD, $DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind SQL statement to insert post into database
$stmt = $conn->prepare("INSERT INTO Posts (PostTimeStamp, PostText, UserId) VALUES (NOW(), ?, ?)");
$stmt->bind_param("ss", $post_text, $user_id);

// Set parameters and execute statement
$user_id = $_SESSION['userid'];
$post_text = $_POST['post_text'];

// Execute the statement
if ($stmt->execute() === TRUE) {
    // Retrieve the last inserted PostId
    $postId = $conn->insert_id;

    // If imageURL is not empty, store image details in the Pictures table
    if (isset($_FILES['post_image']) && $_FILES['post_image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/"; // Directory where images will be stored
        $targetFile = $targetDir . basename($_FILES['post_image']['name']);

        // Move the uploaded image to the target directory
        if (move_uploaded_file($_FILES['post_image']['tmp_name'], $targetFile)) {
            // Insert the image details into the Pictures table along with the PostId
            $imageURL = $targetFile;
            $stmt_img = $conn->prepare("INSERT INTO Pictures (PostId, ImageURL) VALUES (?, ?)");
            $stmt_img->bind_param("is", $postId, $imageURL);
            if ($stmt_img->execute() === TRUE) {
                echo "Post and image added successfully";
            } else {
                echo "Error inserting image: " . $stmt_img->error;
            }
            $stmt_img->close();
        } else {
            echo "Error moving uploaded file";
        }
    } else {
        echo "Post added successfully";
    }
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and database connection
$stmt->close();
$conn->close();



