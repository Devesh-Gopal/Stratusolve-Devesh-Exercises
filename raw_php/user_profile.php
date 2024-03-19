<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include "../raw_php/login/database_connection.php";

$email = $_SESSION['email'];
$sql = "SELECT * FROM Users WHERE EmailAddress = '$email' LIMIT 1";
$sql_run = mysqli_query($conn, $sql);

// Initialize $img_path before using it
$img_path = '';

if ($sql_run && mysqli_num_rows($sql_run) > 0) {
    $user_data = mysqli_fetch_assoc($sql_run);
    // Use session variable for the image path
    $img_path = isset($_SESSION['img_path']) ? $_SESSION['img_path'] : $user_data['ImgPath'];
} else {
    // Handle the case when user data is not available
    $img_path = isset($_SESSION['img_path']) ? $_SESSION['img_path'] : 'images/profile.jpeg';
    // $img_path = 'profile.jpeg'; // or set a default image path
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <link rel="stylesheet" href="user_profile.css">
    <title>My Profile</title>

    <style>
        .second-container #popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .popup-container a {
            color: black;
            display: flex;
            flex-direction: row-reverse;
        }
    </style>
</head>

<body>

<div class="">
    <div class="row second-container background-image">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-8 align-center">
            <div class="inner-container">

                <div class="gallery">
                    <img src="images/<?php echo $img_path; ?>" alt="Profile picture" class="img-fluid" id="profilePic" name="photo" style="border-radius: 50%;">
                </div>

                <div class="icon text-center" onclick="togglePopup()"><i class="fa-solid fa-upload" style="font-size: 1.5rem; margin-top: 10px; cursor:pointer; color: #4161b4;"></i></div>
                <div class="popup-container" id="popup">
                    <a href="stdProfile.php"><i class="fa-solid fa-x"></i></a>

                    <h4>Upload Profile Picture</h4>

                    <form action="upload.php" method="post" enctype="multipart/form-data" id="form" class="d-flex">
                        <input id="imgInput" type="file" class="form-control" name="photo">
                        <input type="submit" class="btn pass-btn" id="submit" name="upload" value="Upload"> <!-- style="height: 20%; margin-top: 25px; margin-left: 100px;" -->
                    </form>
                </div>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <form role="form" action="" method="post">

                            <div style="margin-top: 10px;">
                                <div class="form-group">
                                    <h4><?= $_SESSION['firstname']; ?> <?= $_SESSION['lastname']; ?></h4>
                                </div>
                                <div class="form-group">
                                    <p><?= $_SESSION['email']; ?> </p>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="row buttons">
                    <div class="col-sm-4">
                        <a href="editStdProfile.php"><button type="button" class="btn edit-btn">Edit My Profile</button></a>
                    </div>
                    <div class="col-sm-4">
                        <a href="editStdPass.php"><button type="button" class="btn pass-btn">Change Password</button></a>
                    </div>
                    <div class="col-sm-4">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>


<script>
    $(document).ready(function() {
        $("#submit").click(function(e) {
            e.preventDefault();

            let form_data = new FormData();
            let img = $("#imgInput")[0].files;

            if (img.length > 0) {
                form_data.append('my_image', img[0]);

                $.ajax({
                    url: 'upload.php',
                    type: 'post',
                    data: form_data,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        console.log(res);
                        const data = JSON.parse(res);


                        if (data.error != 1) {
                            let path = "images/" + data.src;
                            $("#profilePic").attr("src", path);
                            $("#profilePic").fadeOut(1).fadeIn(1000);
                            $("#imgInput").val('');
                            togglePopup();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: data.em,
                                confirmButtonColor: '#361596',
                            });
                        }
                    }
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid',
                    text: 'Please select at least one file.',
                    confirmButtonColor: '#361596',
                });
            }
        })

    });

    function togglePopup() {
        var popup = document.getElementById('popup');
        popup.style.display = (popup.style.display === 'none' || popup.style.display === '') ? 'block' : 'none';
    }
</script>
</body>

</html>
