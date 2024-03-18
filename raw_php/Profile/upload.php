<?php
// ini_set('display_startup_errors', 1);
// ini_set('display_errors', 1);
// error_reporting(-1);
include '../login/database_connection.php';
session_start();

$email = $_SESSION['email'];

// class ProfileUpload
// {
//     static function processFileUploads($conn)
//     {


//         $errors = [];
//         $uploadedFiles = [];
//         $uploadPath = 'images' . DIRECTORY_SEPARATOR;

//         // Create the uploads directory if it doesn't exist
//         if (!file_exists($uploadPath)) {
//             mkdir($uploadPath, 0777, true);
//         }

//         // Process each uploaded file
//         foreach ($_FILES as $file) {
//             $file_name = $file['name'];
//             $file_tmp = $file['tmp_name'];
//             $file_size = $file['size'];
//             $file_error = $file['error'];

//             // Check for errors
//             if ($file_error !== UPLOAD_ERR_OK) {
//                 $errors[] = 'File ' . $file_name . ' failed to upload with error code ' . $file_error;
//                 continue;
//             }

//             // Move the uploaded file to the images directory
//             $date = date_create();
//             $timestamp = date_timestamp_get($date);
//             $uploadFilePath = $uploadPath . $file_name.'_'.$timestamp;
//             move_uploaded_file($file_tmp, $uploadFilePath);
//             $FilePath = __DIR__;
//             $FilePath = str_replace('\\', '/', $FilePath) . '/';
//             $FilePath = "$FilePath" . str_replace('\\', '/', $uploadFilePath);
//             //$uploadedFiles[] = $FilePath;

//         }

//         // Display success or error messages
//         if (!empty($errors)) {
//             // echo "Error uploading files:" . "\n";
//             // echo implode("\n", $errors);
//         } else {
//             // Create connection
//             // Check connection
//             if ($conn->connect_error) {
//                 die("Connection failed: " . $conn->connect_error);
//             }

//             $sql = "INSERT INTO FileUploads (FileSource)
//             VALUES ('$FilePath')";

//             if ($conn->query($sql) === TRUE) {
//                 // $_SESSION['photo'] = $photo;
//             } else {
//                 return "Error: " . $sql . "<br>" . $conn->error;
//             }

//             return $FilePath;
//         }
//     }
// }






if(isset($_FILES['my_image'])){

    $img_name = $_FILES['my_image']['name'];
    $img_size = $_FILES['my_image']['size'];
    $tmp_name = $_FILES['my_image']['tmp_name'];
    $error    = $_FILES['my_image']['error'];

    if($error === 0){
        $maxFileSize = 5 * 1024 * 1024;
        if($img_size > $maxFileSize){
            $em = "Sorry, your file is too large.";
            $error = array('error' => 1, 'em'=> $em);
            echo json_encode($error);
            exit();
        }else{
            $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ext_lc = strtolower($img_ext);
            $allowed_exs = array("jpg", "jpeg", "png");

            if(in_array($img_ext_lc, $allowed_exs)){
                $new_img_name = uniqid("IMG-", true).'.'.$img_ext_lc;

                $img_upload_path = "images/".$new_img_name;

                move_uploaded_file($tmp_name, $img_upload_path);

                $sql_upload = "UPDATE User SET ImgPath = '$new_img_name' WHERE Email = '$email'";

                $sql_upload_run = mysqli_query($conn, $sql_upload);

                $_SESSION['img_path'] = $new_img_name;

                $res = array('error' => 0, 'src'=> $new_img_name);

                echo json_encode($res);
                exit();
            }else{
                $em = "You can't upload files of this type";

                $error = array('error' => 1, 'em'=> $em);

                echo json_encode($error);
                exit();
            }
        }
    }else{
        $em = "unknown error occured!";
        $error = array('error' => 1, 'em'=> $em);
        echo json_encode($error);
        exit();
    }
}

mysqli_close($conn);

