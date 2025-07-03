<?php
$servername = "localhost";
$username = "root";
$password = ""; // Default MySQL password for root user is empty in XAMPP
$dbname = "timetable_management_system"; // Updated database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


