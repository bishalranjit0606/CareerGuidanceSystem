<?php
// user/generate_resume.php
session_start();
require_once '../config/config.php';

// Check if user is logged in and is a regular user
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's basic details
$user_details = [];
$sql_user_details = "SELECT name, email FROM users WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql_user_details)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user_details = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

// Fetch user's selected skills
$user_skills = [];
$sql_user_skills = "SELECT s.name FROM user_skills us JOIN skills s ON us.skill_id = s.id WHERE us.user_id = ?";
if ($stmt = mysqli_prepare($conn, $sql_user_skills)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $user_skills[] = $row['name'];
    }
    mysqli_stmt_close($stmt);
}

// You might also want to fetch academic details (major, GPA) if you've added them to the 'users' table
// Example (uncomment if you added 'major' and 'gpa' columns):
// $sql_academic_details = "SELECT major, gpa FROM users WHERE id = ?";
// if ($stmt = mysqli_prepare($conn, $sql_academic_details)) {
//     mysqli_stmt_bind_param($stmt, "i", $user_id);
//     mysqli_stmt_execute($stmt);
//     $result = mysqli_stmt_get_result($stmt);
//     $academic_details = mysqli_fetch_assoc($result);
//     mysqli_stmt_close($stmt);
// }
// $user_major = $academic_details['major'] ?? 'Not specified';
// $user_gpa = $academic_details['gpa'] ?? 'Not specified';

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generated Resume - <?php echo htmlspecialchars($user_details['name'] ?? 'User'); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { background-color: #f4f4f4; }
        .resume-container {
            max-width: 850px;
            margin: 30px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .resume-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 15px;
        }
        .resume-header h1 {
            margin: 0;
            color: #007bff;
            font-size: 2.5em;
        }
        .resume-header p {
            margin: 5px 0;
            font-size: 1.1em;
            color: #555;
        }
        .resume-section {
            margin-bottom: 25px;
        }
        .resume-section h2 {
            background-color: #f0f0f0;
            color: #007bff;
            padding: 10px 15px;
            margin-top: 0;
            margin-bottom: 15px;
            border-left: 5px solid #007bff;
            font-size: 1.5em;
        }
        .resume-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .resume-section ul li {
            margin-bottom: 8px;
            padding-left: 20px;
            position: relative;
        }
        .resume-section ul li::before {
            content: '•';
            color: #007bff;
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
            position: absolute;
            left: 0;
        }
        .skills-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .skill-tag {
            background-color: #e9f7ff;
            color: #007bff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.9em;
            border: 1px solid #cceeff;
        }
        .back-link { display: block; text-align: center; margin-top: 30px; }
        .back-link a {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .back-link a:hover { background-color: #5a6268; }
        .print-button {
            text-align: center;
            margin-top: 20px;
        }
        .print-button button {
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }
        .print-button button:hover {
            background-color: #218838;
        }
        @media print {
            .back-link, .print-button, .sidebar, .navbar {
                display: none; /* Hide navigation and buttons when printing */
            }
            body {
                background-color: #fff;
                margin: 0;
                padding: 0;
            }
            .resume-container {
                box-shadow: none;
                border: none;
                margin: 0;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="resume-container">
        <div class="resume-header">
            <h1><?php echo htmlspecialchars($user_details['name'] ?? 'Your Name'); ?></h1>
            <p><?php echo htmlspecialchars($user_details['email'] ?? 'your.email@example.com'); ?></p>
            <p>123-456-7890 | LinkedIn.com/in/yourprofile</p>
        </div>

        <div class="resume-section">
            <h2>Summary</h2>
            <p>
                A dedicated and enthusiastic individual with a passion for [mention relevant field, e.g., web development/data analysis]. Possessing a strong foundation in [mention 2-3 key skills] and eager to apply learned knowledge to real-world challenges. Highly motivated to learn and grow in a dynamic professional environment.
                </p>
        </div>

        <?php
        // Uncomment and adapt if you added major and gpa to your users table
        /*
        <div class="resume-section">
            <h2>Education</h2>
            <ul>
                <li><strong>[Your University Name]</strong> - [Your Degree], [Major]</li>
                <li>GPA: <?php echo htmlspecialchars($user_gpa); ?> (on 4.0 scale)</li>
                <li>[Graduation Year]</li>
            </ul>
        </div>
        */
        ?>

        <div class="resume-section">
            <h2>Skills</h2>
            <?php if (!empty($user_skills)): ?>
                <div class="skills-list">
                    <?php foreach ($user_skills as $skill): ?>
                        <span class="skill-tag"><?php echo htmlspecialchars($skill); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No skills added yet. Please update your profile.</p>
            <?php endif; ?>
        </div>

        <div class="resume-section">
            <h2>Experience</h2>
            <ul>
                <li><strong>[Job Title]</strong> | [Company Name] | [City, State] | [Start Date] – [End Date]</li>
                <li>Description of responsibilities and achievements (e.g., Developed, Managed, Analyzed, Implemented).</li>
                <li>Description of responsibilities and achievements.</li>
            </ul>
            <ul>
                <li><strong>[Job Title]</strong> | [Company Name] | [City, State] | [Start Date] – [End Date]</li>
                <li>Description of responsibilities and achievements.</li>
            </ul>
        </div>

        <div class="resume-section">
            <h2>Projects</h2>
            <ul>
                <li><strong>[Project Name]</strong> | [Technologies Used]</li>
                <li>Brief description of the project and your role/contributions.</li>
            </ul>
            <ul>
                <li><strong>[Project Name]</strong> | [Technologies Used]</li>
                <li>Brief description of the project and your role/contributions.</li>
            </ul>
        </div>

        <div class="print-button">
            <button onclick="window.print()">Print/Save as PDF</button>
        </div>

        <div class="back-link">
            <p><a href="dashboard.php">Back to Dashboard</a></p>
        </div>
    </div>
</body>
</html>
