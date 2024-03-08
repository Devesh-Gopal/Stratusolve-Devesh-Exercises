<?php

// Database connection
$SERVER_NAME = "127.0.0.1";
$USERNAME = "root";
$PASSWORD = "Devesh0905";
$DB_NAME = "Person";

// Create connection
$conn = new mysqli($SERVER_NAME, $USERNAME, $PASSWORD, $DB_NAME);

// Check connection
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

        // Validate date of birth (check if it's not empty)
        if (empty($dateOfBirth)) {
            return ["success" => false, "message" => "Date of birth cannot be empty"];
        }

        $sql = "INSERT INTO Person (FirstName, Surname, DateOfBirth, EmailAddress, Age)
            VALUES ('$firstName', '$surname', '$dateOfBirth', '$emailAddress', '$age')";

        // Error handling
        if ($this->conn->query($sql) === FALSE) {
            return ["success" => false, "message" => "Error creating person: " . $this->conn->error];
        } else {
            return ["success" => true, "message" => "Person added successfully"];
        }
    }

    // Updates an existing person in the database
    public function updatePerson(string $firstName, string $surname, string $dateOfBirth, string $emailAddress, int $age, int $id): array
    {
        $sql = "UPDATE Person SET FirstName='$firstName', Surname='$surname', DateOfBirth='$dateOfBirth', EmailAddress='$emailAddress', Age='$age' WHERE id=$id";

        // Error handling
        if ($this->conn->query($sql) === FALSE) {
            return ["success" => false, "message" => "Error updating person: " . $this->conn->error];
        } else {
            return ["success" => true, "message" => "Person updated successfully"];
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the POST request
    $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : "";
    $surname = isset($_POST["surname"]) ? $_POST["surname"] : "";
    $dateOfBirth = isset($_POST["dateOfBirth"]) ? $_POST["dateOfBirth"] : "";
    $emailAddress = isset($_POST["emailAddress"]) ? $_POST["emailAddress"] : "";
    $age = isset($_POST["age"]) ? $_POST["age"] : "";

    // Call the createPerson method to handle the form data
    $result = $person->createPerson($firstName, $surname, $dateOfBirth, $emailAddress, $age);

    // Output the result
    echo json_encode($result);

    // Check if the delete action is requested
    $action = isset($_POST["action"]) ? $_POST["action"] : "";
    if ($action == "delete") {
        $id = isset($_POST["id"]) ? $_POST["id"] : "";

        // Call the deletePerson method to handle the DELETE request
        $result = $person->deletePerson($id);

        // Output the result
        echo json_encode($result);
        exit(); // Add this line to stop the script after processing the delete action
    } else {
        echo json_encode(["success" => false, "message" => "Invalid action"]);
    }


    $action = isset($_POST["action"]) ? $_POST["action"] : "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && $action == "update") {
        // Retrieve data from the POST request (for update)
        parse_str(file_get_contents("php://input"), $_POST);

        // Validate required fields
        $id = isset($_POST["id"]) ? $_POST["id"] : "";
        $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : "";
        $surname = isset($_POST["surname"]) ? $_POST["surname"] : "";
        $dateOfBirth = isset($_POST["dateOfBirth"]) ? $_POST["dateOfBirth"] : "";
        $emailAddress = isset($_POST["emailAddress"]) ? $_POST["emailAddress"] : "";
        $age = isset($_POST["age"]) ? $_POST["age"] : "";

        if (empty($id) || empty($firstName) || empty($surname) || empty($dateOfBirth) || empty($emailAddress) || empty($age)) {
            // Handle validation error
            $error = ["error" => "All fields are required"];
            echo json_encode($error);
        } else {
            // Call the updatePerson method to handle the POST request (for update)
            $result = $person->updatePerson($firstName, $surname, $dateOfBirth, $emailAddress, $age, $id);

            // Output the result with action set to "update"
            $response = ["action" => "update", "result" => $result];
            echo json_encode($response);
        }
    }


} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Call the loadAllPeople method to handle the GET request
    $result = $person->loadAllPeople();

    // Output the result
    echo json_encode($result);


}

// Close the database connection
$conn->close();