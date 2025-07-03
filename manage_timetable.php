<?php
session_start();
include('db_connection.php'); // Ensure the database connection is included

// Ensure the teacher is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: login_page.php");
    exit();
}

$teacher_id = $_SESSION['user_id']; // Get the logged-in teacher's user ID

// Handle the form submission to add a new class to the timetable
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_name = mysqli_real_escape_string($conn, $_POST['class_name']);
    $day = mysqli_real_escape_string($conn, $_POST['day']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);

    // Insert the new class into the timetable table
    $sql = "INSERT INTO timetable (teacher_id, class_name, day, time) VALUES ('$teacher_id', '$class_name', '$day', '$time')";
    if (mysqli_query($conn, $sql)) {
        echo "Class added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch teacher's timetable from the database
$sql_timetable = "SELECT * FROM timetable WHERE teacher_id = '$teacher_id'";
$result_timetable = mysqli_query($conn, $sql_timetable);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Timetable</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .btn {
            background-color: #6a4c9c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }
        .btn:hover {
            background-color: #5a3a8c;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Manage Your Timetable</h2>

    <!-- Add Timetable Form -->
    <form method="POST">
        <label>Class Name: </label>
        <input type="text" name="class_name" required><br><br>
        <label>Day: </label>
        <input type="text" name="day" required><br><br>
        <label>Time: </label>
        <input type="text" name="time" required><br><br>
        <button type="submit" class="btn">Add Class</button>
    </form>

    <h3>Your Timetable</h3>
    <table>
        <thead>
            <tr>
                <th>Class Name</th>
                <th>Day</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result_timetable)) { ?>
                <tr>
                    <td><?php echo $row['class_name']; ?></td>
                    <td><?php echo $row['day']; ?></td>
                    <td><?php echo $row['time']; ?></td>
                    <td>
                        <a href="edit_timetable.php?id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                        <a href="delete_timetable.php?id=<?php echo $row['id']; ?>" class="btn" style="background-color: #e74c3c;">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>

