<?php
session_start();
include('db_connection.php');

// Ensure the user is logged in and is a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: login_page.php");
    exit();
}

$teacher_id = $_SESSION['user_id']; // Get teacher's ID

// Fetch the teacher's timetable (classes they are teaching)
$query = "SELECT * FROM teacher_timetable WHERE teacher_id = '$teacher_id'";
$timetable_result = mysqli_query($conn, $query);

// Fetch the students enrolled in the teacher's classes
$students_query = "SELECT u.user_id, u.first_name, u.last_name, c.subject 
                   FROM users u 
                   JOIN class_timetable c ON u.user_id = c.student_id 
                   WHERE c.teacher_id = '$teacher_id'";
$students_result = mysqli_query($conn, $students_query);

// Handle attendance submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $status = $_POST['status'];
    $date = date('Y-m-d'); // Attendance date

    // Insert attendance record into the database
    $insert_attendance = "INSERT INTO attendance (user_id, status, date) VALUES ('$student_id', '$status', '$date')";

    if (mysqli_query($conn, $insert_attendance)) {
        echo "<script>alert('Attendance recorded successfully!');</script>";
    } else {
        echo "<script>alert('Error recording attendance.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Attendance</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Manage Attendance</h2>

        <form method="POST">
            <table>
                <tr>
                    <th>Student</th>
                    <th>Status</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($students_result)) { ?>
                    <tr>
                        <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                        <td>
                            <input type="hidden" name="student_id" value="<?php echo $row['user_id']; ?>">
                            <select name="status" required>
                                <option value="present">Present</option>
                                <option value="absent">Absent</option>
                                <option value="excused">Excused</option>
                            </select>
                        </td>
                    </tr>
                <?php } ?>
            </table>

            <button type="submit" class="btn">Submit Attendance</button>
        </form>
    </div>
</body>
</html>

