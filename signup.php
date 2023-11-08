<?php
// Handle signup request
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "Nightowl@123");
define("DB_NAME", "userdb");

// Database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error or $conn == null) {
    die("Connection failed: " . $conn->connect_error);
}

//Get the input values
$data = json_decode(file_get_contents("php://input"));

$username = $data->username;
$password = password_hash($data->password, PASSWORD_BCRYPT);

$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    $response = ["success" => true];
} else {
    $response = ["success" => false];
}

//echo json_encode($response);
$conn->close();
