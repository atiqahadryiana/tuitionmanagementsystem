<?php
session_start();
include('db_connection.php');
$user_id = $_SESSION['user_id'];

// Check if the user is logged in as a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login_page.php");
    exit();
}

// Fetch user data (optional, if you want to display more info on the dashboard)
$sql_student_info = "SELECT * FROM users WHERE user_id = '$user_id' AND role = 'student'";
$result_student_info = mysqli_query($conn, $sql_student_info);

if (mysqli_num_rows($result_student_info) > 0) {
    $row = mysqli_fetch_assoc($result_student_info);
    $student_name = $row['first_name'] . ' ' . $row['last_name'];
    $student_ic = $row['ic_number'];
    $student_email = $row['email'];
} else {
    // If no user found, log them out
    session_destroy();
    header("Location: login_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            max-width: 600px;
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

        p {
            font-size: 18px;
            margin: 10px 0;
        }

        .dashboard-btn {
            background-color: #6a4c9c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin: 20px 0;
        }

        .dashboard-btn:hover {
            background-color: #5a3a8c;
        }

        .dashboard-btn:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to Your Dashboard, <?php echo $student_name; ?>!</h2>

        <p><strong>Name:</strong> <?php echo $student_name; ?></p>
        <p><strong>IC Number:</strong> <?php echo $student_ic; ?></p>
        <p><strong>Email:</strong> <?php echo $student_email; ?></p>

        <button class="dashboard-btn" onclick="window.location.href='pay_fees.php'">Pay Fees</button>
        <button class="dashboard-btn" onclick="window.location.href='view_attendance.php'">View Attendance</button>

        <br><br>
        <button class="dashboard-btn" onclick="window.location.href='logout.php'">Logout</button>
    </div>
</body>
</html>




