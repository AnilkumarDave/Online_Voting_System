<?php
$host = "localhost";   // Database host
$user = "root";        // Database username
$pass = "";            // Database password
$db   = "gujarat_voting_system"; // Updated database name

$conn = new mysqli($host, $user, $pass, $db, 3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
