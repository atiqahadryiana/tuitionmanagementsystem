<?php
session_start();
include('db_connection.php');

// Ensure the user is logged in and is a clerk
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'clerk') {
    header("Location: login_page.php");
    exit();
}

// Fetch all students
$students_query = "SELECT * FROM users WHERE role = 'student'";
$students_result = mysqli_query($conn, $students_query);

// Fetch available classes
$class_query = "SELECT * FROM class_timetable";
$class_result = mysqli_query($conn, $class_query);

// Handle form submission (assign student to a class)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $class_id = $_POST['class_id'];

    // Assign student to class by adding an entry into class_timetable
    $assign_query = "INSERT INTO class_timetable (student_id, timetable_id) VALUES ('$student_id', '$class_id')";
    
    if (mysqli_query($conn, $assign_query)) {
        echo "<script>alert('Student assigned to class successfully!');</script>";
    } else {
        echo "<script>alert('Error assigning student to class.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Student to Class</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Assign Student to Class</h2>
        <form method="POST">
            <div class="form-group">
                <label for="student_id">Select Student</label>
                <select name="student_id" required>
                    <option value="">Select Student</option>
                    <?php while ($student = mysqli_fetch_assoc($students_result)) { ?>
                        <option value="<?php echo $student['user_id']; ?>"><?php echo $student['first_name'] . " " . $student['last_name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="class_id">Select Class</label>
                <select name="class_id" required>
                    <option value="">Select Class</option>
                    <?php while ($class = mysqli_fetch_assoc($class_result)) { ?>
                        <option value="<?php echo $class['timetable_id']; ?>"><?php echo $class['subject'] . " - " . $class['day'] . " " . $class['start_time']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" class="btn">Assign to Class</button>
        </form>
    </div>
</body>
</html>
