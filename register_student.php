<?php
session_start();
include('db_connection.php');

// Function to generate a 12-character alphanumeric user_id
function generateUserId() {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $user_id = '';
    for ($i = 0; $i < 12; $i++) {
        $user_id .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $user_id;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the user inputs
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $ic_number = mysqli_real_escape_string($conn, $_POST['ic_number']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the email already exists
    $email_check_sql = "SELECT * FROM users WHERE email = '$email'";
    $email_check_result = mysqli_query($conn, $email_check_sql);

    if (mysqli_num_rows($email_check_result) > 0) {
        echo "<script>alert('Email is already registered!');</script>";
    } else {
        // Generate a unique 12-digit alphanumeric user_id
        $user_id = generateUserId(); // This uses the function above

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into the users table
        $sql = "INSERT INTO users (user_id, first_name, last_name, email, ic_number, password, role, status)
                VALUES ('$user_id', '$first_name', '$last_name', '$email', '$ic_number', '$hashed_password', 'student', 'pending')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Successfully registered!'); window.location.href = 'login_page.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>


