<?php
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

//// Fetch existing posts from the database
//$sql = "SELECT * FROM Posts ORDER BY PostTimeStamp DESC"; // Adjust this query according to your database schema
//$result = $conn->query($sql);
//
//// Output posts as HTML
//if ($result->num_rows > 0) {
//    while($row = $result->fetch_assoc()) {
//        // Format post HTML here (similar to the displayNewPost() function)
//        echo "<div class='post'>";
//        echo "<p>" . $row['PostText'] . "</p>";
//        // Add more post content here
//        echo "</div>";
//    }
//} else {
//    echo "No posts found";
//}
//
//// Close database connection
//$conn->close();


// Fetch existing posts from the database along with associated pictures
$sql = "SELECT Posts.*, Users.firstname, Users.lastname, Pictures.ImageURL 
        FROM Posts 
        INNER JOIN Users ON Posts.UserId = Users.UserId 
        LEFT JOIN Pictures ON Posts.PostId = Pictures.PostId 
        ORDER BY Posts.PostTimeStamp DESC";

$result = $conn->query($sql);

// Output posts as HTML
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Format post HTML here
        echo "<div class='post'>";
        echo "<p><strong>Posted by: </strong>" . $row['firstname'] . " " . $row['lastname'] . "</p>"; // Display name above post content
        echo "<p>" . $row['PostText'] . "</p>"; // Display post content
        if (!empty($row['ImageURL'])) {
            // Assuming ImageURL stores the complete URL including the filename
            echo "<img src='" . $row['ImageURL'] . "' alt='Post Image'>"; // Display image if available
        }
        echo "<p><strong>Posted at: </strong>" . $row['PostTimeStamp'] . "</p>"; // Display date and time below post content
        // Add more post content here
        echo "</div>";
    }
} else {
    echo "No posts found";
}

// Close database connection
$conn->close();




