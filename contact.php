<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "bike_user";

$conn = new mysqli($servername, $username, $password, $database);

$data = json_decode(file_get_contents('php://input'), true);

$username = $data["username"];
$address = $data["address"];
$job = $data["job"];
$description = $data["description"];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    if (!empty($data)) {
        $sql = "INSERT INTO contact_info (username, address, job, description) VALUES ('$username', '$address', '$job', '$description')";
        $result = $conn->query($sql);
    
            if ($result) {
        
                echo "Contact data inserted successfully!";
        
            } else {
        
                echo "Error!";
        
            }
        }
    } catch (Exception $ex) {

        echo "Error in SQL: " . $ex->getMessage();

    }

$conn->close();
?>

