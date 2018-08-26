<?php

require 'authConfig.php';

$_last_name = $_POST["last_name"];
$_first_name = $_POST["first_name"];
$_card_id = $_POST["card_id"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

$sql = "INSERT INTO persons VALUES(DEFAULT, '" . $_last_name . "', '" . $_first_name . "', '" . $_card_id . "');";

if($conn->query($sql))
	echo '1';
else
	echo '0';

    
$conn->close();

?>
