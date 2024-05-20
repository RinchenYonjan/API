<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "bike_user";

$conn = new mysqli($servername, $username, $password, $database);

$data = json_decode(file_get_contents('php://input'), true);

$username = $data["username"];
$password = $data["password"];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT username, password FROM user_info WHERE username = '$username' AND password = '$password'";

$result = $conn->query($sql);
$sql_result = array();

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sql_result = array("username" => $row["username"], "password" => $row["password"]);
        }
        echo json_encode($sql_result);
    } else {
        echo json_encode("not found");
    }
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
