<?php
// user/recommendations.php
session_start();
require_once '../config/config.php';
require_once '../algorithms/career_scoring.php'; // New file for primary recommendations
require_once '../algorithms/association_rule_mining.php';
require_once '../algorithms/linear_regression.php';

// Check if user is logged in and is a regular user
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// --- 1. Fetch User Data ---

// Fetch user's selected skills
$user_skills_ids = [];
$sql_user_skills = "SELECT skill_id FROM user_skills WHERE user_id = ?";
if ($stmt = mysqli_prepare($conn, $sql_user_skills)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $user_skills_ids[] = $row['skill_id'];
    }
    mysqli_stmt_close($stmt);
}

// Fetch user's quiz answers
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

// Fetch all available skills (needed for skill suggestions and scoring)
$all_skills = [];
$sql_all_skills = "SELECT id, name FROM skills";
$result_all_skills = mysqli_query($conn, $sql_all_skills);
if ($result_all_skills) {
    while ($row = mysqli_fetch_assoc($result_all_skills)) {
        $all_skills[] = $row;
    }
}

// Fetch all available careers (needed for rule-based and scoring)
$all_careers = [];
$sql_all_careers = "SELECT id, title, description FROM careers";
$result_all_careers = mysqli_query($conn, $sql_all_careers);
if ($result_all_careers) {
    while ($row = mysqli_fetch_assoc($result_all_careers)) {
        $all_careers[] = $row;
    }
}

// --- 2. Generate Recommendations using Algorithms ---

$career_compatibility_scores = []; // New primary recommendations
$skill_suggestions = [];
$success_predictions = []; // Associative array: career_title => score (from linear_regression)

// Only run algorithms if user has provided data (skills or answers)
if (!empty($user_skills_ids) || !empty($user_answers)) {
    // Primary Career Recommendations (Scoring-based)
    $career_compatibility_scores = getCareerCompatibilityScores($user_skills_ids, $user_answers, $all_careers, $all_skills);

    // Association Rule Mining: Skill Enhancement Suggestions
    $skill_suggestions = getAssociationSkillSuggestions($user_skills_ids, $all_skills);

    // Linear Regression: Predict Success Percentage for ALL careers
    foreach ($all_careers as $career) {
        $score = predictSuccessScore($user_skills_ids, $user_answers, $career, $all_skills);
        $success_predictions[$career['title']] = $score;
    }

    // --- Optional: Store top compatibility careers in 'recommendations' table ---
    // You might want to store only the top N most compatible careers,
    // or all careers with a score above a certain threshold.
    // For now, let's store careers that have a score > 0 and are somewhat significant.
    // Clear previous recommendations for this user
    $sql_delete_recommendations = "DELETE FROM recommendations WHERE user_id = ?";
    if ($stmt = mysqli_prepare($conn, $sql_delete_recommendations)) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Insert new recommendations based on compatibility scores
    $sql_insert_recommendation = "INSERT INTO recommendations (user_id, career_id, success_score) VALUES (?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $sql_insert_recommendation)) {
        foreach ($career_compatibility_scores as $career_title => $score) {
            // Only store if score is meaningful (e.g., above base score)
            if ($score > 10) { // Adjust threshold as needed
                $career_id_to_store = null;
                foreach ($all_careers as $c) {
                    if ($c['title'] == $career_title) {
                        $career_id_to_store = $c['id'];
                        break;
                    }
                }
                if ($career_id_to_store !== null) {
                    // Use the linear regression score if available, otherwise use the compatibility score directly
                    $score_to_store = $success_predictions[$career_title] ?? $score;
                    mysqli_stmt_bind_param($stmt, "iid", $user_id, $career_id_to_store, $score_to_store);
                    mysqli_stmt_execute($stmt);
                }
            }
        }
        mysqli_stmt_close($stmt);
    }

} else {
    $_SESSION['recommendation_message'] = "Please fill out your profile and quiz to get recommendations.";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Recommendations - User Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .recommendations-container { max-width: 900px; margin: 50px auto; padding: 30px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .recommendations-container h1 { color: #0056b3; margin-bottom: 20px; text-align: center; }
        .recommendation-section { margin-bottom: 30px; padding: 20px; border: 1px solid #eee; border-radius: 5px; }
        .recommendation-section h3 { margin-top: 0; color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-bottom: 20px;}
        .list-item { background-color: #f9f9f9; padding: 10px 15px; border-radius: 4px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center;}
        .list-item strong { color: #007bff; }
        .score { font-weight: bold; color: #28a745; }
        .no-data-message { color: #888; text-align: center; font-style: italic; margin-top: 20px; }
        .back-link { display: block; text-align: center; margin-top: 20px; }
        .back-link a { color: #007bff; text-decoration: none; }
        .back-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="recommendations-container">
        <h1>My Career Recommendations</h1>
        <p style="text-align: center;">Based on your profile, skills, and quiz answers.</p>

        <?php if (isset($_SESSION['recommendation_message'])): ?>
            <p class="no-data-message"><?php echo $_SESSION['recommendation_message']; ?></p>
            <?php unset($_SESSION['recommendation_message']); ?>
        <?php else: ?>
            <div class="recommendation-section">
                <h3>Top Career Paths (Scoring-Based Recommendation)</h3>
                <?php if (!empty($career_compatibility_scores)): ?>
                    <?php
                    $num_displayed_recommendations = 5; // Display top 5 careers
                    $displayed_count = 0;
                    foreach ($career_compatibility_scores as $career_title => $score):
                        if ($displayed_count >= $num_displayed_recommendations) break;
                        // Only display if the score is above a certain minimum (e.g., base score + some points)
                        if ($score > 10) : // Adjust this threshold as needed
                            ?>
                            <div class="list-item">
                                <strong><?php echo htmlspecialchars($career_title); ?></strong>
                                <span class="score">Compatibility Score: <?php echo htmlspecialchars($score); ?></span>
                            </div>
                            <?php
                            $displayed_count++;
                        endif;
                    endforeach;
                    if ($displayed_count == 0) :
                    ?>
                        <p class="no-data-message">No significant career recommendations found based on your current inputs. Try updating your profile and quiz answers.</p>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="no-data-message">No career compatibility scores available. Please ensure your profile and quiz answers are complete.</p>
                <?php endif; ?>
            </div>

            <div class="recommendation-section">
                <h3>Skill Enhancement Suggestions (Association Rule Mining)</h3>
                <?php if (!empty($skill_suggestions)): ?>
                    <?php foreach ($skill_suggestions as $skill_name): ?>
                        <div class="list-item">
                            <span>Consider learning: <strong><?php echo htmlspecialchars($skill_name); ?></strong></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-data-message">No specific skill enhancement suggestions at this time based on your current skills.</p>
                <?php endif; ?>
            </div>

            <div class="recommendation-section">
                <h3>Potential Success Percentages for All Careers (Linear Regression Model)</h3>
                <p>These scores indicate potential compatibility with various careers, considering a broader range of factors.</p>
                <?php if (!empty($success_predictions)): ?>
                    <?php
                    // Sort predictions by score in descending order
                    arsort($success_predictions);
                    ?>
                    <?php foreach ($success_predictions as $career_title => $score): ?>
                        <div class="list-item">
                            <span><strong><?php echo htmlspecialchars($career_title); ?></strong></span>
                            <span class="score"><?php echo htmlspecialchars($score); ?>%</span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-data-message">Unable to predict success percentages. Please ensure your profile and quiz answers are complete.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="back-link">
            <p><a href="dashboard.php">Back to Dashboard</a></p>
        </div>
    </div>
</body>
</html>
