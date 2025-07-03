<?php
session_start();
include('db_connection.php');

// Ensure the user is logged in and is a clerk
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'clerk') {
    header("Location: login_page.php");
    exit();
}

// Fetch all students
$students_query = "SELECT user_id, first_name, last_name FROM users WHERE role = 'student'";
$students_result = mysqli_query($conn, $students_query);

// Handle pay request creation
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
    <title>Create Pay Request</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Create Pay Request</h2>

        <form method="POST">
            <div class="form-group">
                <label for="student_id">Select Student</label>
                <select name="student_id" required>
                    <option value="">Select Student</option>
                    <?php while ($row = mysqli_fetch_assoc($students_result)) { ?>
                        <option value="<?php echo $row['user_id']; ?>"><?php echo $row['first_name'] . " " . $row['last_name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" required>
            </div>

            <button type="submit" name="create_request" class="btn">Create Pay Request</button>
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
