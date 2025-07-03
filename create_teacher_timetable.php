<?php
session_start();
include('db_connection.php');

// Ensure the user is logged in and is a clerk
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'clerk') {
    header("Location: login_page.php");
    exit();
}

// Fetch all teachers to display in a dropdown
$query = "SELECT * FROM users WHERE role = 'teacher'";
$result = mysqli_query($conn, $query);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teacher_id = $_POST['teacher_id'];
    $subject = $_POST['subject'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Insert timetable into the database
    $insert_query = "INSERT INTO teacher_timetable (teacher_id, subject, day, start_time, end_time) 
                     VALUES ('$teacher_id', '$subject', '$day', '$start_time', '$end_time')";

    if (mysqli_query($conn, $insert_query)) {
        echo "<script>alert('Timetable created successfully!'); window.location.href='manage_teacher_timetable.php';</script>";
    } else {
        echo "<script>alert('Error creating timetable. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Teacher Timetable</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Create Teacher Timetable</h2>

        <form method="POST">
            <div class="form-group">
                <label for="teacher_id">Select Teacher</label>
                <select name="teacher_id" required>
                    <option value="">Select Teacher</option>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $row['user_id']; ?>"><?php echo $row['first_name'] . " " . $row['last_name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" name="subject" required>
            </div>

            <div class="form-group">
                <label for="day">Day</label>
                <select name="day" required>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                </select>
            </div>

            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="time" name="start_time" required>
            </div>

            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="time" name="end_time" required>
            </div>

            <button type="submit" class="btn">Create Timetable</button>
        </form>
    </div>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #6a4c9c;
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 1.1em;
            color: #6a4c9c;
            margin-bottom: 8px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group input:focus, .form-group select:focus {
            border-color: #6a4c9c; /* Soft purple border on focus */
            outline: none;
        }

        .btn {
            background-color: #6a4c9c; /* Soft Purple */
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2em;
            text-align: center;
            width: 100%;
        }

        .btn:hover {
            background-color: #5a3a8c;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h2 {
                font-size: 2em;
            }

            .form-group label {
                font-size: 1em;
            }

            .form-group input {
                padding: 10px;
            }

            .btn {
                font-size: 1.1em;
            }
        }
    </style>
</body>
</html>
