<?php

require 'dbAccess.php';

$obj = $_POST["id"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

$sql = "DELETE FROM persons WHERE id = " . $obj;
$conn->query($sql);
    
$conn->close();

?>
