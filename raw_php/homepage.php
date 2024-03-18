<?php
session_start();

$user_id = isset($_SESSION['userid']) ? $_SESSION['userid'] : 'none';
$firstname = isset($_SESSION['firstname']) ? $_SESSION['firstname'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Social Sphere</title>
    <style>
        /* Override default SweetAlert styles */
        .swal2-popup {
            font-size: 1.6rem; /* Example: Adjust font size */
            background: #1b2d5b;
        }

        .swal2-title {
            color: #ffffff; /* Example: Change title color */
        }

        .swal2-content {
            color: #ffffff; /* Example: Change content color */
        }

        .swal2-actions {
            display: flex;
            justify-content: center;
        }

        .swal2-confirm {
            background-color: #5271FF; /* Example: Change confirm button color */
        }




        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #0c0c0c;
            font-size: 20px;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 30px;
        }
        .sidebar {
            flex: 0 0 250px;
            background-color: #0c0c0c;
            padding: 20px;
            box-shadow: 0 0 20px rgb(255, 255, 255);
            border-radius: 10px;
        }
        .main-content {
            flex: 1;
            max-width: 800px;
            background-color: #0c0c0c;
            padding: 20px;
            margin-left: 20px;
            box-shadow: 0 0 20px rgb(255, 255, 255);
            border-radius: 10px;
        }
        h1, h2 {
            color: #ffffff;
            padding-top: -40px;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        li {
            margin-bottom: 10px;
        }
        a {
            text-decoration: none;
            color: #333;
        }
        .post {
            background-color: #fff;
            border: 5px solid #2e49ce;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
        }
        .post img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        #post-text {
            width: calc(100% - 40px);
            margin-bottom: 10px;
            border-radius: 5px;
            padding: 10px;
            border: 1px solid #ccc;
            resize: none;
        }
        #post-image {
            width: calc(100% - 40px);
            margin-bottom: 10px;
            border-radius: 5px;
            padding: 10px;
            border: 1px solid #ccc;
        }
        button {
            background: #5271FF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #5271FF;
        }
        .post-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }
        .user-info {
            display: flex;
            align-items: center;
        }
        .user-info img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .like-button {
            background-color: transparent;
            border: none;
            cursor: pointer;
        }
        .comment-button {
            background-color: transparent;
            border: none;
            cursor: pointer;
        }
        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="sidebar">
        <img src="newlogo.png" alt="logo" style="width: 150px; height: 150px; margin-left: -14%; margin-top: -10px; margin-bottom: 10px;">
        <h2>Menu</h2>
        <ul style="list-style: none; padding: 0;">
            <li style="line-height: 45px;"><a href="user_profile.php" style="color: white;"><img src="usericon.png" alt="Profile" style="width: 40px; height: 42px; margin-right: 5px; vertical-align: middle;"> Profile</a></li>
        </ul>
    </div>



    <div class="main-content">
        <h2>What's happening?!</h2>
        <form id="post-form" enctype="multipart/form-data">
            <textarea id="post-text" rows="4" placeholder="What's happening?!"></textarea><br>
            <label for="file-input">
                <img src="imageicon.png" alt="Add File" style="width: 30px; height: 30px; cursor: pointer;">
            </label>
            <input type="file" id="file-input" style="display: none;"><br>
            <button type="submit">Post a sphere!</button>
        </form>
        <hr> <!-- Line between Post button and Latest Posts heading -->

        <h2>Your Sphere</h2>
        <div id="posts-container">
            <!-- Posts will be dynamically inserted here using JavaScript -->
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Display welcome message with user's first name using SweetAlert
        Swal.fire({
            icon: 'success',
            title: 'Welcome <?php echo $firstname; ?>!',
            text: 'We are excited to have you.',
            showConfirmButton: false,
            timer: 3000 // Close after 3 seconds
        });

        // Event listener for form submission
        $("#post-form").submit(function(event) {
            event.preventDefault(); // Prevent default form submission
            submitPost();
        });

        // Fetch existing posts when the page loads
        fetchExistingPosts();
    });

    // Function to fetch existing posts
    function fetchExistingPosts() {
        $.ajax({
            url: 'fetch_posts.php', // Your PHP script to fetch posts
            type: 'GET',
            success: function(response) {
                // Display existing posts
                $("#posts-container").html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    // Function to handle post submission
    function submitPost() {
        var postText = $("#post-text").val();
        var postImage = $("#file-input")[0].files[0];

        console.log("Post Text:", postText); // Log post text
        console.log("Post Image:", postImage); // Log post image

        if ($.trim(postText) === "" && !postImage) {
            alert("Please enter some text or select an image for your post.");
            return;
        }

        // Create FormData object to send data to server
        var formData = new FormData();
        formData.append('post_text', postText);
        formData.append('post_image', postImage);

        // Send AJAX request to add_post.php
        $.ajax({
            url: 'add_post.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // Post added successfully
                console.log(response);
                // Display new post
                displayNewPost(postText, postImage);
            },
            error: function(xhr, status, error) {
                // Error occurred
                console.error('Error:', error);
            }
        });
    }
    // Function to handle displaying new posts
    function displayNewPost(postText, postImage) {
        var postContainer = $("#posts-container");
        var newPost = $("<div>").addClass("post");

        // Create user info section
        var userInfo = $("<div>").addClass("user-info");
        var userAvatar = $("<img>").attr("src", "default-avatar.jpg").attr("alt", "User Avatar").addClass("user-avatar");
        var username = $("<span>").text("<?php echo $firstname; ?>");
        userInfo.append(userAvatar, username);

        // Append user info to post
        newPost.append(userInfo);

        if (postImage) {
            var img = $("<img>").attr("src", URL.createObjectURL(postImage)).addClass("post-image");
            newPost.append(img);
        }

        if ($.trim(postText) !== "") {
            var textNode = $("<p>").text(postText);
            newPost.append(textNode);
        }

        // Create post footer
        var postFooter = $("<div>").addClass("post-footer");
        var likeButton = $("<button>").addClass("like-button").text("Like");
        var commentButton = $("<button>").addClass("comment-button").text("Comment");
        postFooter.append(likeButton, commentButton);

        // Append post footer to post
        newPost.append(postFooter);

        // Prepend new post to the top of the container
        postContainer.prepend(newPost);

        // Clear the textarea and file input after posting
        $("#post-text").val("");
        $("#file-input").val("");
    }
</script>

</body>
</html>


