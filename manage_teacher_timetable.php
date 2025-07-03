<?php
session_start();
include('db_connection.php');

// Ensure the user is logged in and is a manager
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'manager') {
    header("Location: login_page.php");
    exit();
}

// Fetch teacher timetables
$query = "SELECT * FROM teacher_timetable";
$result = mysqli_query($conn, $query);

// Handle timetable updates or deletions (if needed)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // For example, updating or deleting timetables, not implemented here for simplicity
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teacher Timetables</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Manage Teacher Timetables</h2>
        <table>
            <tr>
                <th>Teacher ID</th>
                <th>Subject</th>
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['teacher_id']; ?></td>
                    <td><?php echo $row['subject']; ?></td>
                    <td><?php echo $row['day']; ?></td>
                    <td><?php echo $row['start_time']; ?></td>
                    <td><?php echo $row['end_time']; ?></td>
                    <td>
                        <a href="edit_timetable.php?id=<?php echo $row['timetable_id']; ?>">Edit</a> |
                        <a href="delete_timetable.php?id=<?php echo $row['timetable_id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
