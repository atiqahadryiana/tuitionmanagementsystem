<?php
session_start();
include('db_connection.php');

// Ensure the user is logged in and is a manager
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'manager') {
    header("Location: login_page.php");
    exit();
}

// Fetch salary records for pending status
$query = "SELECT * FROM salary_records WHERE status = 'pending'";
$result = mysqli_query($conn, $query);

// Handle salary request approval or rejection
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $salary_id = $_POST['salary_id'];
    $action = $_POST['action'];

    if ($action == 'approve') {
        // Update salary status to 'paid'
        $update_query = "UPDATE salary_records SET status = 'paid' WHERE salary_id = '$salary_id'";
        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('Salary request approved!');</script>";
        } else {
            echo "<script>alert('Error approving salary request.');</script>";
        }
    } elseif ($action == 'reject') {
        // Set salary status to 'rejected'
        $update_query = "UPDATE salary_records SET status = 'rejected' WHERE salary_id = '$salary_id'";
        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('Salary request rejected.');</script>";
        } else {
            echo "<script>alert('Error rejecting salary request.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Status</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
</head>
<body>
    <div class="container">
        <h2>Salary Status for Teachers</h2>
        <table class="salary-table">
            <tr>
                <th>Salary ID</th>
                <th>Teacher ID</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Request Date</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['salary_id']; ?></td>
                    <td><?php echo $row['teacher_id']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                    <td><?php echo $row['payment_date'] ? $row['payment_date'] : 'N/A'; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="salary_id" value="<?php echo $row['salary_id']; ?>">
                            <button type="submit" name="action" value="approve" class="approve-btn"><i class="fas fa-check-circle"></i> Approve</button>
                        </form>
                        |
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="salary_id" value="<?php echo $row['salary_id']; ?>">
                            <button type="submit" name="action" value="reject" class="reject-btn"><i class="fas fa-times-circle"></i> Reject</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
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
            max-width: 1200px;
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

        .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #6a4c9c;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .approve-btn, .reject-btn {
            color: #6a4c9c;
            font-size: 1.1em;
            padding: 8px 16px;
            border: none;
            background: none;
            cursor: pointer;
        }

        .approve-btn:hover {
            color: green;
        }

        .reject-btn:hover {
            color: red;
        }

        .approve-btn:focus, .reject-btn:focus {
            outline: none;
        }
    </style>
</body>
</html>

