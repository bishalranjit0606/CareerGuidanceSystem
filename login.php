<?php
// login.php
session_start(); // Start the session at the very beginning of the script

// Redirect if user is already logged in
// This prevents authenticated users from seeing the login page again.
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header('Location: admin/dashboard.php'); // Redirect admin to admin dashboard
    } else {
        header('Location: user/dashboard.php'); // Redirect regular user to user dashboard
    }
    exit; // Stop further script execution after redirection
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Career Guidance System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* General body styling to center content */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Ensures it takes full viewport height */
            margin: 0;
        }
        /* Container for the login form */
        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 350px; /* Fixed width for the form container */
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        /* Styling for form groups (label + input) */
        .form-group {
            margin-bottom: 15px;
            text-align: left; /* Align labels and inputs to the left */
        }
        .form-group label {
            display: block; /* Make label take full width */
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: calc(100% - 20px); /* Full width minus padding */
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        /* Styling for error messages */
        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
            margin-bottom: 15px; /* Add some space below error messages */
        }
        /* Styling for success messages */
        .success {
            color: green;
            font-size: 0.9em;
            margin-bottom: 15px; /* Add some space below success messages */
        }
        /* Styling for the submit button */
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%; /* Make button full width */
            box-sizing: border-box; /* Include padding in width calculation */
            transition: background-color 0.3s ease; /* Smooth hover effect */
        }
        .btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        /* Styling for links below the form */
        .link-text {
            margin-top: 20px;
            font-size: 0.9em;
        }
        .link-text a {
            color: #007bff;
            text-decoration: none;
        }
        .link-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php
        // Display error message if set in session (e.g., from process_login.php)
        if (isset($_SESSION['login_error'])) {
            echo '<p class="error">' . htmlspecialchars($_SESSION['login_error']) . '</p>';
            unset($_SESSION['login_error']); // Clear the error message after displaying
        }
        // Display success message if set in session (e.g., from process_registration.php)
        if (isset($_SESSION['registration_success'])) {
            echo '<p class="success">' . htmlspecialchars($_SESSION['registration_success']) . '</p>';
            unset($_SESSION['registration_success']); // Clear the success message after displaying
        }
        ?>
        <form action="backend/process_login.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <p class="link-text">Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>
</body>
</html>
