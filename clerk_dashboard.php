<?php
session_start();
include('db_connection.php');

// Check if user is logged in and is a clerk
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'clerk') {
    header("Location: login_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clerk Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
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
        <h2>Welcome, Clerk</h2>

        <!-- Manage Sections -->
        <div class="card-container">
            <div class="card">
                <h3>Approve Pending Students</h3>
                <p>Review and approve student registrations.</p>
                <a href="approve_student.php" class="btn">Approve Pending Students</a>
            </div>
            
            <div class="card">
                <h3>Manage Student Profiles</h3>
                <p>View and update student profiles.</p>
                <a href="manage_student_profiles.php" class="btn">Manage Student Profiles</a>
            </div>
        </div>

        <div class="card-container">
            <div class="card">
                <h3>Manage Teacher Profiles</h3>
                <p>View and update teacher profiles.</p>
                <a href="manage_teacher_profiles.php" class="btn">Manage Teacher Profiles</a>
            </div>
            
            <div class="card">
                <h3>Manage Teacher Timetables</h3>
                <p>Create and manage teacher timetables.</p>
                <a href="create_teacher_timetable.php" class="btn">Create Teacher Timetables</a>
            </div>
        </div>

        <div class="card-container">
            <div class="card">
                <h3>Manage Student Fees</h3>
                <p>Update the fee status and create new pay requests.</p>
                <a href="manage_student_fees.php" class="btn">Manage Student Fees</a>
            </div>
            
            <div class="card">
                <h3>Logout</h3>
                <p>Sign out of the system.</p>
                <a href="logout.php" class="btn" style="background-color: #e74c3c;">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>



