<?php
session_start();
include('db_connection.php');

// Ensure the user is logged in as a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login_page.php");
    exit();
}

$student_id = $_SESSION['user_id'];

// Fetch attendance records for the student
$query = "SELECT * FROM attendance WHERE user_id = '$student_id'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Your Attendance</h2>
        
        <table>
            <tr>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
