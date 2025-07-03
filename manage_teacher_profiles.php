<?php
include('db_connection.php'); // Database connection
session_start();

if ($_SESSION['role'] != 'clerk' && $_SESSION['role'] != 'manager') {
    header("Location: login_page.php");
    exit();
}

// Fetch teachers
$query = "SELECT * FROM users WHERE role = 'teacher'";
$result = mysqli_query($conn, $query);

// Fetch salary requests
$salary_query = "SELECT * FROM salary_records WHERE status = 'pending'";
$salary_result = mysqli_query($conn, $salary_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teacher Profiles</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Manage Teacher Profiles</h1>
        
        <!-- Teacher Profiles Table -->
        <h2>Teacher Profiles</h2>
        <table>
            <tr>
                <th>Teacher ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                </tr>
            <?php } ?>
        </table>

        <!-- Salary Requests Table -->
        <h2>Pending Salary Requests</h2>
        <table>
            <tr>
                <th>Salary ID</th>
                <th>Teacher ID</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($salary_result)) { ?>
                <tr>
                    <td><?php echo $row['salary_id']; ?></td>
                    <td><?php echo $row['teacher_id']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
