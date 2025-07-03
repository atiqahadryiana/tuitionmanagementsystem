<?php
session_start();
include('db_connection.php');

// Simulate registration without actual form validation or hashing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Hardcoded registration (no input validation or password hashing)
    $user_id = 'user1';  // Example: Hardcoded user ID
    $role = $_POST['role'] ?? 'student';  // Role selection

    // Insert user into the database (no password validation)
    $query = "INSERT INTO users (user_id, role) VALUES ('$user_id', '$role')";
    if (mysqli_query($conn, $query)) {
        echo "User registered successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #6a4c9c; /* Soft Purple */
        }
        label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="date"], input[type="tel"] {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            background-color: #6a4c9c; /* Soft Purple */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #5a3a8c; /* Slightly darker purple on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student Registration</h2>
        <form action="register_student.php" method="POST">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" required><br>

            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" required><br>

            <label for="email">Email</label>
            <input type="email" name="email" required><br>

            <label for="ic_number">IC Number</label>
            <input type="text" name="ic_number" required><br>

            <label for="password">Password</label>
            <input type="password" name="password" required><br>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>

