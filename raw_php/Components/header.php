<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500;600&family=Poppins:wght@100&display=swap" rel="stylesheet" />

    <title>Header</title>

    <link rel="stylesheet" href="header.css">

    <style>
        @media (max-width: 991px) {
            body #main-navbar .navbar-nav {
                margin-top: 10px !important;
            }

            body #main-navbar .navbar-toggler {
                margin-top: 10px !important;
            }

            body #main-navbar .collapse {
                background-color: #ffff !important;
                margin-top: 15px !important;
                box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2) !important;
                z-index: 1000;
            }

            body #main-navbar .navbar-nav,
            body #main-navbar .navbar-nav li {
                display: block !important;
            }

            body .search {
                margin-left: 10px !important;
            }

            body .log-btn {
                width: 150% !important;
            }
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg" id="main-navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="../pages/stdPage.php">
            <h3><span>E</span>ducatis</h3>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <form class="d-flex search">
                <input type="text" id="searchinput" class="form-control" placeholder="Course Search">
                <button class="btn log-btn" type="submit" onclick="SearchNames()">Search</button>
            </form>

            <script>
                function SearchNames() {
                    var Userinput = document.getElementById('searchinput').value;

                    if (Userinput == '' || Userinput == null){
                        alert('Please enter something before searching');
                    } else {
                        // $.ajax({
                        // url: '../pages/Search.php',
                        // type: "POST",
                        // data: {query: Userinput},
                        // success: function (data) {
                        //     window.location.href = "../pages/SearchDashboard.php";
                        // },
                        // error: function (xhr, status, error) {
                        //     console.error('Error fetching results:', error);
                        // }
                        // });
                        var data = {
                            Userinput: Userinput,
                        };

                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', '../pages/Search.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/json');

                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    if (xhr.responseText == 'yes'){
                                        window.location.href = "../pages/SearchDashboard.php";
                                    }
                                } else {
                                    console.error('Error:', xhr.status, xhr.statusText);
                                    console.log('Response:', xhr.responseText);
                                }
                            }
                        };

                        xhr.onerror = function () {
                            console.error('Network error occurred.');
                        };

                        xhr.send(JSON.stringify(data));
                    }
                }
            </script>


            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-right: 30px;">
                        Categories
                    </a>
                    <ul class="dropdown-menu" id="categoryDropdown">
                        <!-- Categories will be dynamically inserted here -->
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="../pages/MyCoursePage.php" class="nav-link" aria-disabled="true">My Courses</a>
                </li>
            </ul>

            <!-- Include jQuery (you can download it or use a CDN) -->
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
            <!-- Your JavaScript for fetching categories -->
            <script>
                $(document).ready(function () {
                    // AJAX request to category.php
                    $.ajax({
                        url: '../CourseCreation/category.php',
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            // Iterate through the retrieved categories and append them to the dropdown menu
                            for (var i = 0; i < data.length; i++) {
                                $('#categoryDropdown').append('<li><a class="dropdown-item" onclick="DisplayCategories(' + data[i].id + ')"><i class="fa-solid fa-hashtag"></i>&nbsp' + data[i].cname + '</a></li>');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error fetching categories:', error);
                        }
                    });
                });

                function DisplayCategories(id){
                    var data = {
                        id: id,
                    };

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '../components/DisplayCategories.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/json');

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                window.location.href = "../pages/DashboardUser.php";
                                console.log('created');
                            } else {
                                console.error('Error:', xhr.status, xhr.statusText);
                            }
                        }
                    };

                    xhr.send(JSON.stringify(data));
                }
            </script>


            <div class="end-btns">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../components/cart2.php"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="27" viewBox="0 0 36 33" fill="none">
                                <path d="M0 1.09375C0 0.803669 0.125111 0.52547 0.347811 0.320352C0.57051 0.115234 0.872555 0 1.1875 0H4.75C5.01489 6.74001e-05 5.27214 0.0817046 5.48086 0.231929C5.68958 0.382154 5.83777 0.59234 5.90187 0.829062L6.86375 4.375H34.4375C34.6131 4.3751 34.7865 4.41107 34.9452 4.48033C35.1039 4.54959 35.244 4.65041 35.3553 4.77553C35.4666 4.90065 35.5464 5.04695 35.5889 5.20389C35.6315 5.36083 35.6357 5.52451 35.6012 5.68313L33.2262 16.6206C33.1743 16.8591 33.0375 17.0749 32.8375 17.2338C32.6375 17.3926 32.3857 17.4855 32.1219 17.4978L9.804 18.5303L10.4856 21.875H30.875C31.1899 21.875 31.492 21.9902 31.7147 22.1954C31.9374 22.4005 32.0625 22.6787 32.0625 22.9688C32.0625 23.2588 31.9374 23.537 31.7147 23.7421C31.492 23.9473 31.1899 24.0625 30.875 24.0625H9.5C9.22315 24.0623 8.95509 23.9729 8.74216 23.81C8.52923 23.647 8.38482 23.4206 8.33387 23.17L4.77375 5.70281L3.82375 2.1875H1.1875C0.872555 2.1875 0.57051 2.07227 0.347811 1.86715C0.125111 1.66203 0 1.38383 0 1.09375ZM7.36725 6.5625L9.36225 16.3603L31.0793 15.3563L32.9888 6.5625H7.36725ZM11.875 24.0625C10.6152 24.0625 9.40704 24.5234 8.51624 25.3439C7.62544 26.1644 7.125 27.2772 7.125 28.4375C7.125 29.5978 7.62544 30.7106 8.51624 31.5311C9.40704 32.3516 10.6152 32.8125 11.875 32.8125C13.1348 32.8125 14.343 32.3516 15.2338 31.5311C16.1246 30.7106 16.625 29.5978 16.625 28.4375C16.625 27.2772 16.1246 26.1644 15.2338 25.3439C14.343 24.5234 13.1348 24.0625 11.875 24.0625ZM28.5 24.0625C27.2402 24.0625 26.032 24.5234 25.1412 25.3439C24.2504 26.1644 23.75 27.2772 23.75 28.4375C23.75 29.5978 24.2504 30.7106 25.1412 31.5311C26.032 32.3516 27.2402 32.8125 28.5 32.8125C29.7598 32.8125 30.968 32.3516 31.8588 31.5311C32.7496 30.7106 33.25 29.5978 33.25 28.4375C33.25 27.2772 32.7496 26.1644 31.8588 25.3439C30.968 24.5234 29.7598 24.0625 28.5 24.0625ZM11.875 26.25C12.5049 26.25 13.109 26.4805 13.5544 26.8907C13.9998 27.3009 14.25 27.8573 14.25 28.4375C14.25 29.0177 13.9998 29.5741 13.5544 29.9843C13.109 30.3945 12.5049 30.625 11.875 30.625C11.2451 30.625 10.641 30.3945 10.1956 29.9843C9.75022 29.5741 9.5 29.0177 9.5 28.4375C9.5 27.8573 9.75022 27.3009 10.1956 26.8907C10.641 26.4805 11.2451 26.25 11.875 26.25ZM28.5 26.25C29.1299 26.25 29.734 26.4805 30.1794 26.8907C30.6248 27.3009 30.875 27.8573 30.875 28.4375C30.875 29.0177 30.6248 29.5741 30.1794 29.9843C29.734 30.3945 29.1299 30.625 28.5 30.625C27.8701 30.625 27.266 30.3945 26.8206 29.9843C26.3752 29.5741 26.125 29.0177 26.125 28.4375C26.125 27.8573 26.3752 27.3009 26.8206 26.8907C27.266 26.4805 27.8701 26.25 28.5 26.25Z" fill="#365194" />
                            </svg></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../Profile/user_profile.php"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 36 33" fill="none">
                                <path d="M15.5 15C17.4394 15 19.2994 14.2098 20.6707 12.8033C22.0421 11.3968 22.8125 9.48912 22.8125 7.5C22.8125 5.51088 22.0421 3.60322 20.6707 2.1967C19.2994 0.790177 17.4394 0 15.5 0C13.5606 0 11.7006 0.790177 10.3293 2.1967C8.95792 3.60322 8.1875 5.51088 8.1875 7.5C8.1875 9.48912 8.95792 11.3968 10.3293 12.8033C11.7006 14.2098 13.5606 15 15.5 15ZM20.375 7.5C20.375 8.82608 19.8614 10.0979 18.9471 11.0355C18.0329 11.9732 16.7929 12.5 15.5 12.5C14.2071 12.5 12.9671 11.9732 12.0529 11.0355C11.1386 10.0979 10.625 8.82608 10.625 7.5C10.625 6.17392 11.1386 4.90215 12.0529 3.96447C12.9671 3.02678 14.2071 2.5 15.5 2.5C16.7929 2.5 18.0329 3.02678 18.9471 3.96447C19.8614 4.90215 20.375 6.17392 20.375 7.5ZM30.125 27.5C30.125 30 27.6875 30 27.6875 30H3.3125C3.3125 30 0.875 30 0.875 27.5C0.875 25 3.3125 17.5 15.5 17.5C27.6875 17.5 30.125 25 30.125 27.5ZM27.6875 27.49C27.6851 26.875 27.3121 25.025 25.6595 23.33C24.0703 21.7 21.0794 20 15.5 20C9.91813 20 6.92975 21.7 5.3405 23.33C3.68788 25.025 3.31737 26.875 3.3125 27.49H27.6875Z" fill="#365194" />
                            </svg></a>
                    </li>

                    <li class="nav-item">
                        <button type="button" class="log-btn nav-link"><a href="../pages/logout.php">Log Out</a></button>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</nav>

<script>
    $(document).ready(function() {
        checkScreenWidth();
        $(window).resize(function() {
            checkScreenWidth();
        });

        function checkScreenWidth() {
            if ($(window).width() <= 991) {
                $("#main-navbar .navbar-toggler").show();
            } else {
                $("#main-navbar .navbar-toggler").hide();
            }
        }
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
