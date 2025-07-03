<?php
session_start();
include('db_connection.php'); // Include the database connection

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // We won't use this variable for verification
    $role = $_POST['role']; // Get the role selected (student or staff)

    // Debugging: Output the submitted values (for testing purposes)
    echo "User ID: " . $user_id . "<br>";
    echo "Password: " . $password . "<br>";

    if ($role == 'student') {
        // If the role is student, check IC number
        $sql_student = "SELECT * FROM users WHERE ic_number = '$user_id' AND role = 'student'";
        $result_student = mysqli_query($conn, $sql_student);

        if (mysqli_num_rows($result_student) > 0) {
            // If student found, just set session variables
            $row = mysqli_fetch_assoc($result_student);
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = 'student';
            // Redirect to student dashboard using PHP header
            header("Location: student_dashboard.php");
            exit();
        } else {
            echo "No student found with this IC number!";
        }
    } elseif ($role == 'staff') {
        // If the role is staff, check email
        $sql_staff = "SELECT * FROM users WHERE email = '$user_id' AND role IN ('clerk', 'teacher', 'manager')";
        $result_staff = mysqli_query($conn, $sql_staff);

        if (mysqli_num_rows($result_staff) > 0) {
            // If staff found, just set session variables
            $row = mysqli_fetch_assoc($result_staff);
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = $row['role'];

            // Redirect to the correct dashboard based on the role
            if ($row['role'] == 'clerk') {
                header("Location: clerk_dashboard.php");
            } elseif ($row['role'] == 'teacher') {
                header("Location: teacher_dashboard.php");
            } elseif ($row['role'] == 'manager') {
                header("Location: manager_dashboard.php");
            }
            exit(); // Stop further execution
        } else {
            echo "No staff found with this email!";
        }
    }
}
?>



