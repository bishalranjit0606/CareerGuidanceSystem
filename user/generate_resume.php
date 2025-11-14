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

// Fetch user's basic details including all new fields for resume
$user_details = [];
$sql_user_details = "SELECT name, email, major, gpa, experience_summary, projects_summary, phone_number, linkedin_url, summary_text, university_name, graduation_year FROM users WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql_user_details)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user_details = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
} else {
    // Log error if statement preparation fails
    error_log("Failed to prepare user details fetch statement for resume: " . mysqli_error($conn));
    // Provide default empty values to prevent errors on page load
    $user_details = [
        'name' => '', 'email' => '', 'major' => '', 'gpa' => '',
        'experience_summary' => '', 'projects_summary' => '',
        'phone_number' => '', 'linkedin_url' => '', 'summary_text' => '',
        'university_name' => '', 'graduation_year' => ''
    ];
}


// --- NEW LOGIC: Decode JSON summaries into structured data ---
$work_experiences = json_decode($user_details['experience_summary'] ?? '[]', true);
if (!is_array($work_experiences)) $work_experiences = [];

$projects = json_decode($user_details['projects_summary'] ?? '[]', true);
if (!is_array($projects)) $projects = [];
// -----------------------------------------------------------


// Fetch user's currently selected skills (names)
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

mysqli_close($conn);

// Helper function to format multi-line text into list items
function format_description($description) {
    // Split the description by newlines or a common list delimiter (like '*' or '-')
    $lines = explode("\n", trim($description));
    
    // Clean up empty lines
    $lines = array_filter($lines, 'trim');

    if (empty($lines)) {
        return '';
    }

    $output = '<ul>';
    foreach ($lines as $line) {
        $output .= '<li>' . htmlspecialchars(ltrim($line, "*- ")) . '</li>';
    }
    $output .= '</ul>';
    return $output;
}

// --- NEW LOGIC: Sanitize summary text to remove excessive newlines ---
$cleaned_summary = $user_details['summary_text'] ?? '';
// Replaces 3 or more consecutive newlines with just 2 newlines (allowing a clean paragraph break)
$cleaned_summary = preg_replace("/\n{3,}/", "\n\n", $cleaned_summary);
// --------------------------------------------------------------------
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generated Resume - <?php echo htmlspecialchars($user_details['name']); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* --- MODERN RESUME STYLES (Black & White, Minimalist) --- */
        body { font-family: 'Times New Roman', serif; line-height: 1.4; color: #000; margin: 0; padding: 0; background-color: #f4f4f4; }
        .resume-container {
            max-width: 800px; /* Slightly narrower for classic look */
            margin: 30px auto;
            padding: 40px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            font-size: 11pt; /* Standard resume font size */
        }
        
        /* Header & Contact */
        .header-section { text-align: center; margin-bottom: 20px; }
        .header-section h1 { margin: 0 0 5px 0; font-size: 2.5em; color: #000; text-transform: uppercase; font-weight: 700; letter-spacing: 1px;}
        .contact-info { margin-top: 5px; font-size: 0.9em; display: flex; justify-content: center; flex-wrap: wrap; }
        .contact-info span { margin: 0 10px; }
        .contact-info a { color: #000; text-decoration: none; }
        .contact-info a:hover { text-decoration: underline; }

        /* Summary */
        .summary-text-container { margin: 15px 0; padding: 10px 0; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; font-style: italic; text-align: justify; }

        /* Section Title */
        .resume-section { margin-bottom: 20px; }
        .resume-section h2 {
            font-size: 1.2em;
            color: #000;
            border-bottom: 1px solid #000; /* Thin black line */
            padding-bottom: 3px;
            margin-bottom: 12px;
            text-transform: uppercase;
            font-weight: bold;
        }

        /* Skills */
        .skills-list { line-height: 1.6; }
        .skills-list strong { font-weight: bold; }

        /* Experience and Projects Styling */
        .item-entry { margin-bottom: 15px; }
        .item-header { display: flex; justify-content: space-between; margin-bottom: 0; }
        .item-title { font-weight: bold; font-size: 1em; color: #000; }
        .item-dates { font-size: 1em; font-weight: bold; }
        .item-subtitle { font-style: normal; font-size: 1em; color: #333; margin-bottom: 5px; }
        .item-location-gpa { font-style: italic; font-size: 0.95em; color: #555; }

        .item-description ul { margin-top: 5px; padding-left: 15px; list-style-type: disc; }
        .item-description ul li { margin-bottom: 3px; }

        /* Print Styles */
        @media print {
            .print-button, .back-link { display: none; }
            body { background-color: #fff; }
            .resume-container { margin: 0; box-shadow: none; border: none; padding: 0; }
        }

        .print-button { text-align: center; margin-top: 30px; }
        .print-button button {
            padding: 10px 20px;
            background-color: #555;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .print-button button:hover { background-color: #333; }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { color: #555; text-decoration: none; }
        .back-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="resume-container">
        <div class="header-section">
            <h1><?php echo htmlspecialchars($user_details['name'] ?? ''); ?></h1>
            <div class="contact-info">
                <?php if (!empty($user_details['phone_number'])): ?>
                    <span><?php echo htmlspecialchars($user_details['phone_number']); ?></span> |
                <?php endif; ?>
                <?php if (!empty($user_details['email'])): ?>
                    <span><?php echo htmlspecialchars($user_details['email']); ?></span> |
                <?php endif; ?>
                <?php if (!empty($user_details['linkedin_url'])): ?>
                    <span><a href="<?php echo htmlspecialchars($user_details['linkedin_url'] ?? '#'); ?>" target="_blank">LinkedIn Profile</a></span>
                <?php endif; ?>
            </div>
            <?php if (!empty($user_details['summary_text'])): ?>
                <div class="summary-text-container">
                    <!-- USE CLEANED SUMMARY TEXT HERE -->
                    <p style="margin: 0;"><?php echo nl2br(htmlspecialchars($cleaned_summary)); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <div class="resume-section">
            <h2>Education</h2>
            <?php if (!empty($user_details['university_name'])): ?>
                <div class="item-entry">
                    <div class="item-header">
                        <span class="item-title"><?php echo htmlspecialchars($user_details['university_name']); ?></span>
                        <span class="item-dates"><?php echo htmlspecialchars($user_details['graduation_year']); ?></span>
                    </div>
                    <div class="item-subtitle">
                        <?php echo htmlspecialchars($user_details['major'] ?? 'Major'); ?>
                        <?php if (!empty($user_details['gpa'])): ?>
                            <span class="item-location-gpa" style="margin-left: 15px;">| GPA: <?php echo htmlspecialchars($user_details['gpa']); ?>/4.0</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <p>No education details added yet. Please update your profile.</p>
            <?php endif; ?>
        </div>

        <div class="resume-section">
            <h2>Skills</h2>
            <?php if (!empty($user_skills)): ?>
                <div class="skills-list">
                    <!-- Format skills as a single comma-separated list, optionally categorized -->
                    <p style="margin: 0;">
                        <?php echo '<strong>Technical Skills:</strong> ' . htmlspecialchars(implode(', ', $user_skills)); ?>
                    </p>
                </div>
            <?php else: ?>
                <p>No skills added yet. Please update your profile.</p>
            <?php endif; ?>
        </div>

        <!-- STRUCTURED EXPERIENCE SECTION -->
        <div class="resume-section">
            <h2>Experience</h2>
            <?php if (!empty($work_experiences)): ?>
                <?php foreach ($work_experiences as $exp): ?>
                    <div class="item-entry">
                        <div class="item-header">
                            <span class="item-title"><?php echo htmlspecialchars($exp['company'] ?? ''); ?></span>
                            <span class="item-dates"><?php echo htmlspecialchars($exp['start_date'] ?? ''); ?> – <?php echo htmlspecialchars($exp['end_date'] ?? ''); ?></span>
                        </div>
                        <div class="item-subtitle"><?php echo htmlspecialchars($exp['position'] ?? ''); ?></div>
                        <div class="item-description">
                            <?php echo format_description($exp['description'] ?? ''); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No work experience details added yet. Please update your profile.</p>
            <?php endif; ?>
        </div>
        
        <!-- STRUCTURED PROJECTS SECTION -->
        <div class="resume-section">
            <h2>Projects</h2>
            <?php if (!empty($projects)): ?>
                <?php foreach ($projects as $proj): ?>
                    <div class="item-entry">
                        <div class="item-header">
                            <span class="item-title"><?php echo htmlspecialchars($proj['name'] ?? ''); ?></span>
                        </div>
                        <div class="item-description">
                            <?php echo format_description($proj['description'] ?? ''); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No project details added yet. Please update your profile.</p>
            <?php endif; ?>
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