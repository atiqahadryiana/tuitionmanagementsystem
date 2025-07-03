<?php
session_start();
include('db_connection.php');

// Ensure that only the clerk can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'clerk') {
    header("Location: login_page.php");
    exit();
}

$clerk_id = $_SESSION['user_id'];

// Fetch all pending student registrations
$sql = "SELECT * FROM users WHERE role = 'student' AND status = 'pending'";
$result = mysqli_query($conn, $sql);

// Accept or Reject student registration
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $action = $_POST['action'];

    if ($action == 'accept') {
        // Accept student registration
        $update_sql = "UPDATE users SET status = 'approved' WHERE user_id = '$student_id'";

        if (mysqli_query($conn, $update_sql)) {
            echo "<script>alert('Student registration accepted!');</script>";
        }
    } elseif ($action == 'reject') {
        // Reject student registration (delete from the database)
        $delete_sql = "DELETE FROM users WHERE user_id = '$student_id' AND role = 'student'";
        if (mysqli_query($conn, $delete_sql)) {
            echo "<script>alert('Student registration rejected!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Student Registrations</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external style.css -->
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>Pending Student Registrations</h2>
        <form method="POST">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <button type="submit" name="action" value="accept">
                                <i class="fas fa-check-circle"></i> Accept
                            </button>
                            <button type="submit" name="action" value="reject">
                                <i class="fas fa-times-circle"></i> Reject
                            </button>
                            <input type="hidden" name="student_id" value="<?php echo $row['user_id']; ?>">
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </form>
    </div>
</body>
</html>


