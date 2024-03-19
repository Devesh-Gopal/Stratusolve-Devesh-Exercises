<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <!-- Include SweetAlert2 from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .blur-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(8px); /* Adjust the blur intensity as needed */
        }

        .swal2-popup {
            width: 500px; /* Adjust the width of the SweetAlert dialog */
            font-size: 1.3rem; /* Example: Adjust font size */
            background: #1b2d5b;
        }

        .swal2-title {
            color: #ffffff; /* Change title color */
        }

        .swal2-content {
            color: #ffffff; /* Change content color */
        }

        .swal2-actions {
            display: flex;
            justify-content: center;
        }

        .swal2-confirm {
            background-color: #5271FF; /* Change confirm button color */
        }
    </style>
</head>
<body>

<!-- Blur background layer -->
<div class="blur-background" id="blurBackground"></div>

<script>
    // Function to toggle blur background
    function toggleBlurBackground() {
        var blurBackground = document.getElementById('blurBackground');
        blurBackground.style.display = (blurBackground.style.display === 'none') ? 'block' : 'none';
    }

    // Display SweetAlert for confirmation when the page is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Blur the background when the confirmation dialog appears
        toggleBlurBackground();

        Swal.fire({
            title: 'Logout',
            text: 'Are you sure you want to logout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#5271FF',
            cancelButtonColor: '#5271FF', // Change cancel button color
            confirmButtonText: 'Yes, logout!',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Logged Out',
                    text: 'You have been successfully logged out.',
                    icon: 'success',
                    timer: 2000, // Auto-close the alert after 2 seconds
                    showConfirmButton: false
                }).then(function() {
                    // Redirect to the login page after logout
                    window.location.href = '../raw_php/login/user_login.php';
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // Handle cancel action
                history.go(-1); // Go back one page
            }
        }).finally(() => {
            // Remove blur effect when the confirmation dialog is closed
            toggleBlurBackground();
        });
    });

</script>

</body>
</html>


