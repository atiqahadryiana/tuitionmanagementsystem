<?php
session_start();
include('db_connection.php');

// Ensure that the user is logged in and is a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: login_page.php");
    exit();
}

$teacher_id = $_SESSION['user_id']; // Get the teacher's ID

// Fetch existing salary requests for the teacher
$query = "SELECT * FROM salary_records WHERE teacher_id = '$teacher_id'";
$result = mysqli_query($conn, $query);

// Submit a salary request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $status = 'pending'; // Set status to pending initially

    $insert_query = "INSERT INTO salary_records (teacher_id, amount, status) VALUES ('$teacher_id', '$amount', '$status')";
    if (mysqli_query($conn, $insert_query)) {
        echo "<script>alert('Salary request submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error submitting salary request: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Requests</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Salary Requests</h2>

        <!-- Display existing salary requests -->
        <table>
            <tr>
                <th>Amount</th>
                <th>Status</th>
                <th>Request Date</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                    <td><?php echo $row['payment_date'] ? $row['payment_date'] : 'N/A'; ?></td>
                </tr>
            <?php } ?>
        </table>

        <!-- Submit a new salary request -->
        <form method="POST">
            <label for="amount">Salary Amount</label>
            <input type="number" name="amount" required>

            <button type="submit">Submit Salary Request</button>
        </form>
    </div>
</body>
</html>

