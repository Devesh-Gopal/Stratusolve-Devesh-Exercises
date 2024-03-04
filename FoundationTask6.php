<?php
require_once 'vendor/autoload.php'; //loads the Faker library files-generates fake data .
use Faker\Factory as Faker;

//Database connection
$servername = "127.0.0.1";
$username = "root";
$password = "Devesh0905";
$dbname = "Person";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// User Class-Properties and methods defined
class Person {

    // Properties- representing the attributes of a person
    public $firstName, $surname, $dateOfBirth, $emailAddress, $age;
    private $conn; // holds db connection

    // Constructor to set up the database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Methods-functions
    //Inserts a new person into the database
    public function createPerson($firstName, $surname, $dateOfBirth, $emailAddress, $age) {

        $birthDate = new DateTime($dateOfBirth);
        $currentDate = new DateTime();
        $age = $birthDate->diff($currentDate)->y;

        $sql = "INSERT INTO Person (FirstName, Surname, DateOfBirth, EmailAddress, Age)
                VALUES ('$firstName', '$surname', '$dateOfBirth', '$emailAddress', '$age')";

        // Error handling
        if ($this->conn->query($sql) === FALSE) {
            echo "Error creating person: " . $this->conn->error;
        }
    }

    //Updates an existing person in the database
    public function updatePerson($firstName, $surname, $dateOfBirth, $emailAddress, $age, $id) {
        $sql = "UPDATE Person SET FirstName='$firstName', Surname='$surname', DateOfBirth='$dateOfBirth', EmailAddress='$emailAddress', Age='$age' WHERE id=$id";

        // Error handling
        if ($this->conn->query($sql) === FALSE) {
            echo "Error updating person: " . $this->conn->error;
        }
    }

    // Loads a person from the database
    public function loadPerson($id) {
        $sql = "SELECT * FROM Person WHERE id=$id";
        $result = $this->conn->query($sql);

        // Error handling
        if ($result === FALSE) {
            echo "Error loading person: " . $this->conn->error;
        }

        // Return the loaded person as an associative array (key-value pairs)
        return $result->fetch_assoc();
    }

    // Saves a person to the database
    public function savePerson() {
        $sql = "INSERT INTO Person (FirstName, Surname, DateOfBirth, EmailAddress, Age)
                VALUES ('$this->firstName', '$this->surname', '$this->dateOfBirth', '$this->emailAddress', '$this->age')";

        if ($this->conn->query($sql) === FALSE) {
            echo "Error occurred while trying to save the person: " . $this->conn->error;
        }
    }

    // Deletes a person from the database
    public function deletePerson($id) {
        $sql = "DELETE FROM Person WHERE id=$id";

        if ($this->conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $this->conn->error;
        }
    }

    // Loads all people from the database
    public function loadAllPeople() {
        $sql = "SELECT * FROM Person";
        $result = $this->conn->query($sql);

        // Error handling-checks if the query was successful
        if ($result === FALSE) {
            echo "Error loading all people: " . $this->conn->error;

        }

        // Fetch all people as an array of associative arrays
        $allPeople = [];
        while ($row = $result->fetch_assoc()) {
            $allPeople[] = $row;
        }

        // Return the loaded people as an array
        return $allPeople;
    }

    // Deletes all people from the database
    public function deleteAllPeople() {
        $sql = "DELETE FROM Person";

        if ($this->conn->query($sql) === TRUE) {
            echo "All records deleted successfully";
        } else {
            echo "Error deleting all records: " . $this->conn->error;
        }
    }
}

// Create an instance of the Person class with the database connection
$person = new Person($conn);

// Example usage

//Creating a new record for a person
//$person->createPerson('John', 'Doe', '1990-01-01', 'john.doe@example.com', 30);

//Updating a persons record
//$person->updatePerson('Jane', 'Doe', '1995-02-15', 'jane.doe@example.com', 27, 1);

//// Load the person from the database
//$loadedPerson = $person->loadPerson(1);

//// Output the loaded person
//print_r($loadedPerson);

//Save a person
//$person->firstName = 'Alice';
//$person->surname = 'Wonderland';
//$person->dateOfBirth = '1985-05-20';
//$person->emailAddress = 'alice.wonder@example.com';
//$person->age = 35;
//$person->savePerson();

// Delete a person
//$person->deletePerson(1);

// Load all people
$allPeople = $person->loadAllPeople();
print_r($allPeople);

// Delete all people
//$person->deleteAllPeople();

// Generate and insert 10 random people into the database
$faker = Faker::create();
for ($i = 0; $i < 10; $i++) {
    $firstName = $faker->firstName;
    $surname = $faker->lastName;
    $dateOfBirth = $faker->date($format = 'Y-m-d', $max = 'now');
    $emailAddress = $faker->email;


    // Create a new person in the database
    $person->createPerson($firstName, $surname, $dateOfBirth, $emailAddress, 0);

// Starting clock time in seconds
    $start_time = microtime(true);
    $a = 1;

// Start loop
    for ($i = 1; $i <= 10000000; $i++) {
        $a++;
    }

// End clock time in seconds
    $end_time = microtime(true);

// Calculating the script execution time
    $execution_time = $end_time - $start_time;

    echo " Execution time of script = " . $execution_time . " seconds";
}

$conn->close();