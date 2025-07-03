<?php
session_start();
include('db_connection.php');

// Ensure the user is logged in and is a student or clerk
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'student' && $_SESSION['role'] != 'clerk')) {
    header("Location: login_page.php");
    exit();
}

$student_id = $_SESSION['user_id']; // Get student ID

// Fetch fee records for the student
$query = "SELECT * FROM fee_records WHERE student_id = '$student_id'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Fees</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Pay Your Fees</h2>

        <!-- Display fee records -->
        <table>
            <tr>
                <th>Amount</th>
                <th>Status</th>
                <th>Pay Now</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                    <td>
                        <?php if ($row['status'] == 'unpaid') { ?>
                            <form method="POST" action="payment_gateway.php">
                                <input type="hidden" name="fee_record_id" value="<?php echo $row['fee_record_id']; ?>">
                                <input type="hidden" name="amount" value="<?php echo $row['amount']; ?>">
                                <button type="submit" class="btn">Pay Now</button>
                            </form>
                        <?php } else { ?>
                            Paid
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
