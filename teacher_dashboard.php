<?php
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: login_page.php"); // Redirect to login page if not logged in or wrong role
    exit();
}

$teacher_id = $_SESSION['user_id']; // Get the logged-in teacher's user ID
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            max-width: 1000px;
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

        .btn {
            background-color: #6a4c9c; /* Soft Purple */
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            text-align: center;
            width: 100%;
            margin: 10px 0;
        }

        .btn:hover {
            background-color: #5a3a8c;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            margin-top: 30px;
        }

        .card {
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            width: 48%;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card a {
            display: inline-block;
            color: #6a4c9c;
            font-size: 1.2em;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .card-container {
                flex-direction: column;
            }

            .card {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?php echo $teacher['first_name']; ?>!</h2>

        <!-- Manage Sections -->
        <div class="card-container">
            <div class="card">
                <h3>View Your Timetable</h3>
                <p>Check your upcoming classes and schedule.</p>
                <a href="teacher_timetable.php" class="btn">View Timetable</a>
            </div>
            
            <div class="card">
                <h3>Manage Your Profile</h3>
                <p>Update your personal information and profile.</p>
                <a href="manage_teacher_profile.php" class="btn">Manage Profile</a>
            </div>
        </div>

        <div class="card-container">
            <div class="card">
                <h3>Salary Requests</h3>
                <p>Submit your salary requests for processing.</p>
                <a href="salary_requests.php" class="btn">Submit Salary Request</a>
            </div>
            
            <div class="card">
                <h3>Logout</h3>
                <p>Sign out of the system.</p>
                <a href="?logout=true" class="btn" style="background-color: #e74c3c;">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>

