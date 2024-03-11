<?php

// Database connection parameters
$SERVER_NAME = "127.0.0.1";
$USERNAME = "root";
$PASSWORD = "Devesh0905";
$DB_NAME = "Person";

// Create a new database connection
$conn = new mysqli($SERVER_NAME, $USERNAME, $PASSWORD, $DB_NAME);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// User class - Properties and methods defined
class Person
{
    // Properties representing the attributes of a person
    public $firstName, $surname, $dateOfBirth, $emailAddress, $age;
    private $conn; // holds db connection

    // Constructor to set up the database connection
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Methods-functions

    // Inserts a new person into the database
    public function createPerson(string $firstName, string $surname, string $dateOfBirth, string $emailAddress, $age): array
    {
        // Convert the age to an integer
        $age = (int)$age;

        // Validate input
        if (empty($firstName) || empty($surname) || empty($dateOfBirth) || empty($emailAddress) || empty($age)) {
            return ["success" => false, "message" => "All fields are required"];
        }

        // Try multiple date formats until a valid one is found
        $validFormats = ['Y-m-d', 'd-m-Y', 'm-d-Y', 'Y/d/m', 'm/d/Y', 'd/m/Y'];
        $formattedDate = null;

        foreach ($validFormats as $format) {
            $dateObj = DateTime::createFromFormat($format, $dateOfBirth);

            if ($dateObj && $dateObj->format($format) === $dateOfBirth) {
                $formattedDate = $dateObj->format('Y-m-d');
                break;
            }
        }

        if (!$formattedDate) {
            return ["success" => false, "message" => "Invalid date of birth format. Please enter a valid date."];
        }

        // Use prepared statement to prevent SQL injection
        $stmt = $this->conn->prepare("INSERT INTO Person (FirstName, Surname, DateOfBirth, EmailAddress, Age) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $firstName, $surname, $formattedDate, $emailAddress, $age);

        // Execute the statement
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Person added successfully"];
        } else {
            return ["success" => false, "message" => "Error creating person: " . $stmt->error];
        }
    }

    // Updates an existing person in the database
    public function updatePerson(string $firstName, string $surname, string $dateOfBirth, string $emailAddress, int $age, int $id): array
    {
        $stmt = $this->conn->prepare("UPDATE Person SET FirstName=?, Surname=?, DateOfBirth=?, EmailAddress=?, Age=? WHERE id=?");
        $stmt->bind_param("ssssii", $firstName, $surname, $dateOfBirth, $emailAddress, $age, $id);

        if ($stmt->execute()) {
            return ["success" => true, "message" => "Person updated successfully"];
        } else {
            $errorMessage = "Error updating person: " . $stmt->error;
            error_log($errorMessage);
            return ["success" => false, "message" => $errorMessage];
        }
    }

    // Loads a person from the database
    public function loadPerson(int $id): array
    {
        $sql = "SELECT * FROM Person WHERE id=$id";
        $result = $this->conn->query($sql);

        // Error handling
        if ($result === FALSE) {
            return ["success" => false, "message" => "Error loading person: " . $this->conn->error];
        }

        // Return the loaded person as an associative array (key-value pairs)
        return ["success" => true, "data" => $result->fetch_assoc()];
    }

    // Saves a person to the database
    public function savePerson(): array
    {
        $sql = "INSERT INTO Person (FirstName, Surname, DateOfBirth, EmailAddress, Age)
                VALUES ('$this->firstName', '$this->surname', '$this->dateOfBirth', '$this->emailAddress', '$this->age')";

        if ($this->conn->query($sql) === FALSE) {
            return ["success" => false, "message" => "Error occurred while trying to save the person: " . $this->conn->error];
        } else {
            return ["success" => true, "message" => "Person saved successfully"];
        }
    }

    // Deletes a person from the database
    public function deletePerson(int $id): array
    {
        $sql = "DELETE FROM Person WHERE id=$id";

        if ($this->conn->query($sql) === TRUE) {
            return ["success" => true, "message" => "Record deleted successfully"];
        } else {
            return ["success" => false, "message" => "Error deleting record: " . $this->conn->error];
        }
    }

    // Loads all people from the database
    public function loadAllPeople(): array
    {
        // Log the id to a file (for debugging purposes)
        file_put_contents("log.txt", "Loading all people" );
        $sql = "SELECT * FROM Person";
        $result = $this->conn->query($sql);

        // Error handling - check if the query was successful
        if ($result === FALSE) {
            return ["success" => false, "message" => "Error loading all people: " . $this->conn->error];
        }

        // Fetch all people as an array of associative arrays
        $allPeople = [];
        while ($row = $result->fetch_assoc()) {
            $allPeople[] = $row;
        }

        return ["success" => true, "data" => $allPeople];
    }

    // Deletes all people from the database
    public function deleteAllPeople(): array
    {
        $sql = "DELETE FROM Person";

        if ($this->conn->query($sql) === TRUE) {
            return ["success" => true, "message" => "All records deleted successfully"];
        } else {
            return ["success" => false, "message" => "Error deleting all records: " . $this->conn->error];
        }
    }
}

// Create an instance of the Person class with the database connection
$person = new Person($conn);

// Check the HTTP request method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST["action"]) ? $_POST["action"] : "";

    if ($action == "create") {
        // Create a new person
        $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : "";
        $surname = isset($_POST["surname"]) ? $_POST["surname"] : "";
        $dateOfBirth = isset($_POST["dateOfBirth"]) ? $_POST["dateOfBirth"] : "";
        $emailAddress = isset($_POST["emailAddress"]) ? $_POST["emailAddress"] : "";
        $age = isset($_POST["age"]) ? $_POST["age"] : "";

        // Call the createPerson method and echo the result as JSON
        $result = $person->createPerson($firstName, $surname, $dateOfBirth, $emailAddress, $age);
        echo json_encode($result);

    } elseif ($action == "update") {
        // Update an existing person
        $id = isset($_POST["id"]) ? $_POST["id"] : "";
        $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : "";
        $surname = isset($_POST["surname"]) ? $_POST["surname"] : "";
        $dateOfBirth = isset($_POST["dateOfBirth"]) ? $_POST["dateOfBirth"] : "";
        $emailAddress = isset($_POST["emailAddress"]) ? $_POST["emailAddress"] : "";
        $age = isset($_POST["age"]) ? $_POST["age"] : "";

        // Call the updatePerson method and echo the result as JSON
        $result = $person->updatePerson($firstName, $surname, $dateOfBirth, $emailAddress, $age, $id);
        echo json_encode($result);

    } elseif ($action == "delete") {
        // Delete a person
        $id = isset($_POST["id"]) ? $_POST["id"] : "";

        // Call the deletePerson method and echo the result as JSON
        $result = $person->deletePerson($id);
        echo json_encode($result);

    } else {
        // Invalid action
        echo json_encode(["success" => false, "message" => "Invalid action"]);
    }

} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Load all people
    $result = $person->loadAllPeople();
    echo json_encode($result);
}

// Close the database connection
$conn->close();

