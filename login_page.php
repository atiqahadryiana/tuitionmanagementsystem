<?php
session_start();
include('db_connection.php');

// Simplified login - no authentication required
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Just set a session variable to simulate a login
    $_SESSION['user_id'] = 'user1';  // Example: Hardcoded user ID
    $_SESSION['role'] = 'student';    // Example: Hardcoded role

    // Redirect based on role
    header("Location: " . ($_SESSION['role'] == 'clerk' ? 'clerk_dashboard.php' : 'student_dashboard.php'));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        input[type="text"], input[type="password"], input[type="email"] {
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
            background-color: #5a3a8c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="login.php">
    User ID : <input type="text" name="user_id" required><br>
    Password: <input type="password" name="password" required><br>
    Role: 
    <select name="role" required>
        <option value="student">Student</option>
        <option value="staff">Staff</option>
    </select><br>
    <input type="submit" value="Login">
</form>

    </div>
</body>
</html>






