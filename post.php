<?php

// These variables hold the connection details for the MySQL database. The script will use these details to establish a connection.
$servername = "localhost";
$username = "root";
$password = "";
$database = "bike_user";

// This creates a new mysqli object, attempting to connect to the MySQL database with the provided credentials.
$conn = new mysqli($servername, $username, $password, $database);

// If the connection to the database fails, the script will terminate and print an error message.
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// This line reads the raw POST data from the request body (expected to be in JSON format) and decodes it into a PHP associative array.
$data = json_decode(file_get_contents('php://input'), true);

// These lines extract individual pieces of user data (username and password) from the associative array.
$username = $data["username"];
$password = $data["password"];

// Constructs a prepared statement to find a user with the provided username.
$sql = "SELECT username, password FROM user_info WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);  // Bind the username parameter
$stmt->execute();
$result = $stmt->get_result();

$sql_result = array();

if ($result) {  // Checks if the query was successful.
    if ($result->num_rows > 0) {    // If there are rows returned
        $row = $result->fetch_assoc();

        // Verify the hashed password
        if (password_verify($password, $row['password'])) {

            $sql_result = array("username" => $row["username"]);
            echo json_encode($sql_result);

        } else {

            echo json_encode("Not found!");  

        }

    } else {    // If no rows are returned

        echo json_encode("Not found!");  

    }
    
} else {    // If the query fails

    echo "Error: " . $conn->error;

}

$stmt->close();  // Close the statement
$conn->close();  // Close the connection
?>