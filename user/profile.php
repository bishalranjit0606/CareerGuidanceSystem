<?php
// user/profile.php
session_start();
require_once '../config/config.php';

// Check if user is logged in and is a regular user
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Fetch existing user details
$user_details = [];
$sql_user_details = "SELECT name, email FROM users WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql_user_details)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user_details = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

// Fetch all available skills
$all_skills = [];
$sql_all_skills = "SELECT id, name FROM skills ORDER BY name ASC";
$result_all_skills = mysqli_query($conn, $sql_all_skills);
if ($result_all_skills) {
    while ($row = mysqli_fetch_assoc($result_all_skills)) {
        $all_skills[] = $row;
    }
}

// Fetch user's currently selected skills
$user_selected_skills_ids = [];
$sql_user_skills = "SELECT skill_id FROM user_skills WHERE user_id = ?";
if ($stmt = mysqli_prepare($conn, $sql_user_skills)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $user_selected_skills_ids[] = $row['skill_id'];
    }
    mysqli_stmt_close($stmt);
}

// Fetch user's previous quiz answers (if any)
$user_answers = [];
$sql_user_answers = "SELECT question, answer FROM user_answers WHERE user_id = ?";
if ($stmt = mysqli_prepare($conn, $sql_user_answers)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $user_answers[$row['question']] = $row['answer'];
    }
    mysqli_stmt_close($stmt);
}

// Define quiz questions and options
// This can be stored in the database for a more dynamic system,
// but for a procedural approach, hardcoding is fine for initial setup.
$quiz_questions = [
    [
        'question' => 'What is your preferred work environment?',
        'type' => 'radio',
        'name' => 'work_environment',
        'options' => [
            'Structured office setting with clear hierarchy',
            'Flexible environment with autonomy and creativity',
            'Collaborative team-based environment',
            'Fast-paced, high-pressure environment'
        ]
    ],
    [
        'question' => 'Which of these activities do you enjoy most?',
        'type' => 'radio',
        'name' => 'enjoy_activity',
        'options' => [
            'Solving complex logical puzzles',
            'Creating visual designs or art',
            'Helping and communicating with people',
            'Organizing and managing projects'
        ]
    ],
    [
        'question' => 'How do you prefer to learn new things?',
        'type' => 'radio',
        'name' => 'learn_preference',
        'options' => [
            'Hands-on practical experience',
            'Reading books and articles',
            'Attending lectures and workshops',
            'Through mentorship and guidance'
        ]
    ],
    [
        'question' => 'What kind of challenges motivate you?',
        'type' => 'checkbox', // Example of checkbox
        'name' => 'challenges_motivate',
        'options' => [
            'Technical problems and debugging',
            'Creative roadblocks and innovation',
            'Interpersonal conflicts and team dynamics',
            'Strategic planning and execution'
        ]
    ],
    [
        'question' => 'Are you comfortable with repetitive tasks?',
        'type' => 'radio',
        'name' => 'repetitive_tasks',
        'options' => [
            'Very comfortable, I like routine',
            'Somewhat comfortable, if necessary',
            'Not very comfortable, I prefer variety',
            'Strongly dislike repetitive tasks'
        ]
    ]
    // Add more quiz questions as needed
];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Process Personal & Academic Details (Dummy for now, as DB schema doesn't have grade fields)
    // For a real system, you'd add columns like `grade_level`, `gpa`, etc. to the `users` table
    // For now, we'll just acknowledge these inputs.

    // 2. Process Skills
    if (isset($_POST['skills']) && is_array($_POST['skills'])) {
        $selected_skill_ids = $_POST['skills'];

        // Remove existing skills for the user
        $sql_delete_skills = "DELETE FROM user_skills WHERE user_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql_delete_skills)) {
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        // Insert new skills
        $sql_insert_skill = "INSERT INTO user_skills (user_id, skill_id) VALUES (?, ?)";
        if ($stmt = mysqli_prepare($conn, $sql_insert_skill)) {
            foreach ($selected_skill_ids as $skill_id) {
                mysqli_stmt_bind_param($stmt, "ii", $user_id, $skill_id);
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        // If no skills are selected, ensure user_skills are cleared
        $sql_delete_skills = "DELETE FROM user_skills WHERE user_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql_delete_skills)) {
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }

    // 3. Process Quiz Answers
    // Clear previous answers to avoid duplicates on resubmission
    $sql_delete_answers = "DELETE FROM user_answers WHERE user_id = ?";
    if ($stmt = mysqli_prepare($conn, $sql_delete_answers)) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    $sql_insert_answer = "INSERT INTO user_answers (user_id, question, answer) VALUES (?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $sql_insert_answer)) {
        foreach ($quiz_questions as $q) {
            $question_text = $q['question'];
            $input_name = $q['name'];

            if ($q['type'] == 'radio' && isset($_POST[$input_name])) {
                $answer = $_POST[$input_name];
                mysqli_stmt_bind_param($stmt, "iss", $user_id, $question_text, $answer);
                mysqli_stmt_execute($stmt);
            } elseif ($q['type'] == 'checkbox' && isset($_POST[$input_name]) && is_array($_POST[$input_name])) {
                // For checkboxes, store answers as a comma-separated string
                $answers_str = implode(", ", $_POST[$input_name]);
                mysqli_stmt_bind_param($stmt, "iss", $user_id, $question_text, $answers_str);
                mysqli_stmt_execute($stmt);
            }
        }
        mysqli_stmt_close($stmt);
    }

    $_SESSION['profile_success'] = "Your profile information has been saved successfully!";
    header("Location: profile.php"); // Redirect back to profile to show success and updated data
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - User Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .profile-container { max-width: 800px; margin: 50px auto; padding: 30px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .profile-container h1 { color: #0056b3; margin-bottom: 20px; text-align: center; }
        .form-section { margin-bottom: 30px; padding: 20px; border: 1px solid #eee; border-radius: 5px; }
        .form-section h3 { margin-top: 0; color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-bottom: 20px;}
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="number"],
        .form-group textarea {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 10px;
            margin-top: 10px;
        }
        .skills-grid label {
            display: flex;
            align-items: center;
            background-color: #f0f0f0;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .skills-grid label:hover {
            background-color: #e0e0e0;
        }
        .skills-grid input[type="checkbox"] {
            margin-right: 8px;
        }
        .quiz-question { margin-bottom: 20px; }
        .quiz-question p { font-weight: bold; margin-bottom: 10px; }
        .quiz-options label { display: block; margin-bottom: 5px; cursor: pointer; }
        .quiz-options input[type="radio"],
        .quiz-options input[type="checkbox"] { margin-right: 8px; }

        .btn-submit {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            width: 100%;
            box-sizing: border-box;
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover { background-color: #218838; }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .back-link { display: block; text-align: center; margin-top: 20px; }
        .back-link a { color: #007bff; text-decoration: none; }
        .back-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="profile-container">
        <h1>My Profile</h1>
        <p style="text-align: center;">Update your details to get personalized career recommendations.</p>

        <?php
        if (isset($_SESSION['profile_success'])) {
            echo '<div class="success-message">' . $_SESSION['profile_success'] . '</div>';
            unset($_SESSION['profile_success']);
        }
        ?>

        <form action="profile.php" method="POST">
            <div class="form-section">
                <h3>Personal & Academic Details</h3>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user_details['name'] ?? ''); ?>" required readonly>
                    <small>Name is from your registration and cannot be changed here.</small>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_details['email'] ?? ''); ?>" required readonly>
                    <small>Email is from your registration and cannot be changed here.</small>
                </div>
                <div class="form-group">
                    <label for="major">Major/Field of Study:</label>
                    <input type="text" id="major" name="major" placeholder="e.g., Computer Science, Business" value="">
                </div>
                <div class="form-group">
                    <label for="gpa">GPA (on 4.0 scale):</label>
                    <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="4" placeholder="e.g., 3.5">
                </div>
            </div>

            <div class="form-section">
                <h3>Your Skills</h3>
                <p>Select all skills that apply to you:</p>
                <div class="skills-grid">
                    <?php if (!empty($all_skills)): ?>
                        <?php foreach ($all_skills as $skill): ?>
                            <label>
                                <input type="checkbox" name="skills[]" value="<?php echo $skill['id']; ?>"
                                    <?php echo in_array($skill['id'], $user_selected_skills_ids) ? 'checked' : ''; ?>>
                                <?php echo htmlspecialchars($skill['name']); ?>
                            </label>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No skills available. Please contact an admin.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-section">
                <h3>Career Interest Quiz</h3>
                <?php foreach ($quiz_questions as $q_index => $question_data): ?>
                    <div class="quiz-question">
                        <p><?php echo ($q_index + 1) . ". " . htmlspecialchars($question_data['question']); ?></p>
                        <div class="quiz-options">
                            <?php foreach ($question_data['options'] as $opt_index => $option): ?>
                                <label>
                                    <input type="<?php echo $question_data['type']; ?>"
                                           name="<?php echo htmlspecialchars($question_data['name']); ?><?php echo ($question_data['type'] == 'checkbox' ? '[]' : ''); ?>"
                                           value="<?php echo htmlspecialchars($option); ?>"
                                           <?php
                                           $prev_answer = $user_answers[$question_data['question']] ?? '';
                                           if ($question_data['type'] == 'radio') {
                                               echo ($prev_answer == $option) ? 'checked' : '';
                                           } elseif ($question_data['type'] == 'checkbox') {
                                               // Check if this option was part of previously selected checkbox answers
                                               $prev_answers_array = explode(", ", $prev_answer);
                                               echo in_array($option, $prev_answers_array) ? 'checked' : '';
                                           }
                                           ?>>
                                    <?php echo htmlspecialchars($option); ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="btn-submit">Save Profile and Quiz Answers</button>
        </form>

        <div class="back-link">
            <p><a href="dashboard.php">Back to Dashboard</a></p>
        </div>
    </div>
</body>
</html>
