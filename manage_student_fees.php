<?php
session_start();
include('db_connection.php');

// Ensure the user is logged in and is a clerk
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'clerk') {
    header("Location: login_page.php");
    exit();
}

// Fetch all student fee records
$query = "SELECT f.fee_record_id, f.amount, f.status, u.first_name, u.last_name, u.user_id 
          FROM fee_records f
          JOIN users u ON f.student_id = u.user_id 
          WHERE u.role = 'student'";
$result = mysqli_query($conn, $query);

// Handle fee status updates (paid/unpaid)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fee_record_id = $_POST['fee_record_id'];
    $status = $_POST['status'];

    // Update fee status
    $update_query = "UPDATE fee_records SET status = '$status' WHERE fee_record_id = '$fee_record_id'";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Fee status updated successfully!'); window.location.href='manage_student_fees.php';</script>";
    } else {
        echo "<script>alert('Error updating fee status.');</script>";
    }
}

// Handle creating a new pay request (create fee record)
if (isset($_POST['create_request'])) {
    $student_id = $_POST['student_id'];
    $amount = $_POST['amount'];

    // Create a new fee record with status 'unpaid'
    $insert_query = "INSERT INTO fee_records (student_id, amount, status) VALUES ('$student_id', '$amount', 'unpaid')";

    if (mysqli_query($conn, $insert_query)) {
        echo "<script>alert('Pay request created successfully!'); window.location.href='manage_student_fees.php';</script>";
    } else {
        echo "<script>alert('Error creating pay request.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Student Fees</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Manage Student Fees</h2>

        <!-- Table for managing existing fees -->
        <table>
            <tr>
                <th>Student Name</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                    <td>
                        <!-- Change Fee Status -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="fee_record_id" value="<?php echo $row['fee_record_id']; ?>">
                            <select name="status" required>
                                <option value="paid" <?php echo ($row['status'] == 'paid') ? 'selected' : ''; ?>>Paid</option>
                                <option value="unpaid" <?php echo ($row['status'] == 'unpaid') ? 'selected' : ''; ?>>Unpaid</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <!-- Create new pay request form -->
        <h3>Create Pay Request</h3>
        <form method="POST">
            <div class="form-group">
                <label for="student_id">Select Student</label>
                <select name="student_id" required>
                    <option value="">Select Student</option>
                    <?php
                    // Fetch all students to select from
                    $students_query = "SELECT user_id, first_name, last_name FROM users WHERE role = 'student'";
                    $students_result = mysqli_query($conn, $students_query);
                    while ($student = mysqli_fetch_assoc($students_result)) {
                        echo "<option value='" . $student['user_id'] . "'>" . $student['first_name'] . " " . $student['last_name'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" required>
            </div>

            <button type="submit" name="create_request" class="btn">Create Pay Request</button>
        </form>
    </div>
</body>
</html>
