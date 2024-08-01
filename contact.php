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

// These lines extract individual pieces of user data (username, address, job, and description) from the associative array.
$company = $data["company"];
$country = $data["country"];
$name = $data["name"];
$description = $data["description"];

try {
    if (!empty($data)) {
        // Constructs a prepared statement to insert the user data.
        $stmt = $conn->prepare("INSERT INTO contact_info (company, country, name, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $company, $country, $name, $description); // Bind parameters to the prepared statement
        
        // Executes the prepared statement
        if ($stmt->execute()) {
            echo "Contact data inserted successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    }
} catch (Exception $ex) {
    echo "Error in SQL: " . $ex->getMessage();
}

// This line closes the connection to the database.
$conn->close();
?>

