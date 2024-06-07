<?php

// These variables hold the connection details for the MySQL database. The script will use these details to establish a connection.
$servername = "localhost";
$username = "root";
$password = "";
$database = "bike_user";

// This creates a new mysqli object, attempting to connect to the MySQL database with the provided credentials.
$conn = new mysqli($servername, $username, $password, $database);

// This line reads the raw POST data from the request body (expected to be in JSON format) and decodes it into a PHP associative array.
$data = json_decode(file_get_contents('php://input'), true);

// These lines extract individual pieces of user data (username, email, phone number, and password) from the associative array.
$username = $data["username"];
$email = $data["email"];
$phonenumber = $data["phonenumber"];
$password = password_hash($data["password"], PASSWORD_BCRYPT); // Hash the password

// If the connection to the database fails, the script will terminate and print an error message.
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    if (!empty($data)) {    // Ensures that the data array is not empty before attempting to insert.
        $stmt = $conn->prepare("INSERT INTO user_info (Username, Email, Phonenumber, Password) VALUES (?, ?, ?, ?)");   // Constructs an SQL INSERT query to add the user data to the user_info table.
        $stmt->bind_param("ssss", $username, $email, $phonenumber, $password); // Bind parameters
        $result = $stmt->execute();     // Executes the query using the query method of the mysqli object.
        
        if ($result) { // Checks if the query execution was successful and outputs the corresponding message. If there is an exception, it catches and prints the error message.
            
            echo "Register data inserted successfully!";
        
        } else {
          
            echo "Error!";
        
        }
        
        $stmt->close(); // Close the prepared statement
    }

    } catch (Exception $ex) {

        echo "Error in SQL!" . $ex->getMessage();

}

$conn->close(); // This line closes the connection to the database.
?>




