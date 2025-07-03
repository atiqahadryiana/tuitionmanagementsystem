<?php
session_start();
include('db_connection.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $ic_number = mysqli_real_escape_string($conn, $_POST['ic_number']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = $_POST['role']; // student, clerk, teacher, manager

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $sql = "INSERT INTO users (first_name, last_name, email, ic_number, password, role)
            VALUES ('$first_name', '$last_name', '$email', '$ic_number', '$hashed_password', '$role')";

    if (mysqli_query($conn, $sql)) {
        echo "User registered successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
