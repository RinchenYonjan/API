<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "bike_user";

$conn = new mysqli($servername, $username, $password, $database);

$data = json_decode(file_get_contents('php://input'), true);

$username = $data["username"];
$email = $data["email"];
$phonenumber = $data["phonenumber"];
$password = $data["password"];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    if (!empty($data)) {
        $sql = "INSERT INTO user_info (username, email, phonenumber, password) VALUES ('$username', '$email', '$phonenumber', '$password')";
        $result = $conn->query($sql);
    
            if ($result) {
        
                echo "Register data inserted successfully!";
        
            } else {
        
                echo "Error";
        
            }
        }
    } catch (Exception $ex) {

        echo "Error in SQL: " . $ex->getMessage();

    }

$conn->close();
?>

