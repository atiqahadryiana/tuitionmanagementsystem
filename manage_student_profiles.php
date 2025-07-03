<?php
include('db_connection.php'); // Database connection
session_start();

if ($_SESSION['role'] != 'clerk' && $_SESSION['role'] != 'manager') {
    header("Location: login_page.php");
    exit();
}

// Fetch students
$query = "SELECT * FROM users WHERE role = 'student'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Student Profiles</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Manage Student Profiles</h1>
        <table>
            <tr>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>

