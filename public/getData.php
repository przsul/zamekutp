<?php

header("Content-Type: application/json; charset=UTF-8");

require 'authConfig.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

$sql = "SELECT * FROM persons";
$result = $conn->query($sql);

echo json_encode($result->fetch_all(MYSQLI_ASSOC));

$result->free();
$conn->close();

?>
