<?php
// admin/dashboard.php
session_start();
require_once '../config/config.php';

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../admin_login.php');
    exit();
}

$admin_name = $_SESSION['user_name'];

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /*
         * Temporary / Debugging styles:
         * If the external style.css is not loading, these inline styles will
         * help confirm if the issue is with the link path or with the CSS itself.
         * You can remove these once the external CSS is confirmed to be working.
         */
        body {
            background-color: #f0f2f5; /* Light grey background */
            font-family: Arial, sans-serif;
        }
        .admin-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .admin-container h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 2em;
        }
        .admin-container p {
            color: #666;
            margin-bottom: 30px;
        }
        .admin-dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        .dashboard-card {
            background-color: #e9f7ff; /* Light blue card background */
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid #cceeff;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }
        .dashboard-card h3 {
            color: #0056b3;
            margin-top: 0;
            font-size: 1.4em;
            margin-bottom: 15px;
        }
        .dashboard-card p {
            font-size: 0.95em;
            color: #555;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .back-link {
            margin-top: 40px;
            text-align: center;
        }
        .back-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Welcome, Admin <?php echo htmlspecialchars($admin_name); ?>!</h1>
        <p style="text-align: center;">Manage the Career Guidance System content and users.</p>

        <div class="admin-dashboard-grid">
            <div class="dashboard-card">
                <h3>Manage Careers</h3>
                <p>Add, edit, or delete career paths available to users.</p>
                <a href="manage_careers.php" class="btn-primary">Go to Careers</a>
            </div>

            <div class="dashboard-card">
                <h3>Manage Skills</h3>
                <p>Add, edit, or delete skills that users can select in their profiles.</p>
                <a href="manage_skills.php" class="btn-primary">Go to Skills</a>
            </div>

            <div class="dashboard-card">
                <h3>Manage Users</h3>
                <p>View registered users and manage their accounts.</p>
                <a href="manage_users.php" class="btn-primary">Go to Users</a>
            </div>

            <div class="dashboard-card">
                <h3>Manage Courses</h3>
                <p>Add, edit, or delete online courses and link them to skills for recommendations.</p>
                <a href="manage_courses.php" class="btn-primary">Go to Courses</a>
            </div>
        </div>

        <div class="back-link">
            <p><a href="../auth/logout.php">Logout</a></p>
        </div>
    </div>
</body>
</html>
