<?php
session_start();
include('db_connection.php');

// Ensure that the user is logged in and is a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: login_page.php");
    exit();
}

$teacher_id = $_SESSION['user_id']; // Get the teacher's ID

// Fetch the teacher's profile details
$query = "SELECT * FROM users WHERE user_id = '$teacher_id'";
$result = mysqli_query($conn, $query);
$teacher = mysqli_fetch_assoc($result);

// Update profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $update_query = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email', password = '$password' WHERE user_id = '$teacher_id'";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Profile updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating profile: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teacher Profile</title>
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>Update Your Profile</h2>

        <form method="POST" class="profile-form">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" value="<?php echo $teacher['first_name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" value="<?php echo $teacher['last_name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="<?php echo $teacher['email']; ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" value="<?php echo $teacher['password']; ?>" required>
            </div>

            <button type="submit" class="btn">Update Profile</button>
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
            font-size: 2em;
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

        .form-group input {
            width: 100%;
            padding: 12px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group input:focus {
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
                font-size: 1.8em;
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

