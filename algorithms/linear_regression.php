<?php
// algorithms/linear_regression.php

/**
 * Predicts success percentage for a given career based on user data using a weighted formula.
 *
 * @param array $user_skills_ids An array of skill IDs the user possesses.
 * @param array $user_answers An associative array of quiz questions and their answers.
 * @param array $career_info An array containing career details (e.g., id, title, description).
 * @param array $all_skills An array of all skills (id, name).
 * @return float The predicted success score (0-100).
 */
function predictSuccessScore($user_skills_ids, $user_answers, $career_info, $all_skills) {
    $score = 0;
    $max_possible_score = 0;

    // Define weights for different factors
    $weights = [
        'skill_match' => 5, // Higher weight for direct skill matches
        'quiz_match' => 3,  // Moderate weight for quiz alignment
        'academic_match' => 2 // Placeholder for academic match (if implemented later)
    ];

    // Map skill names to IDs for easier rule definition
    $skill_names_to_ids = [];
    foreach ($all_skills as $skill) {
        $skill_names_to_ids[strtolower($skill['name'])] = $skill['id'];
    }

    // Define career-specific requirements/preferences and their base scores
    // This simulates the "coefficients" in a linear regression for each career.
    // Each career has:
    // - 'key_skills': skill IDs crucial for this career (higher contribution)
    // - 'relevant_skills': skill IDs beneficial for this career
    // - 'ideal_answers': quiz answers that strongly align (question => expected_answer_substring => score_contribution)
    $career_scoring_factors = [
        // Web Developer (ID: 1)
        1 => [
            'key_skills' => [
                $skill_names_to_ids['programming (php)'] ?? 0,
                $skill_names_to_ids['web design (html/css)'] ?? 0
            ],
            'relevant_skills' => [
                $skill_names_to_ids['database management (mysql)'] ?? 0,
                $skill_names_to_ids['problem solving'] ?? 0
            ],
            'ideal_answers' => [
                'What is your preferred work environment?' => ['Flexible environment' => 15],
                'Which of these activities do you enjoy most?' => ['Solving complex logical puzzles' => 10, 'Creating visual designs' => 5],
                'How do you prefer to learn new things?' => ['Hands-on practical experience' => 10],
                'What kind of challenges motivate you?' => ['Technical problems' => 10]
            ],
            'base_score' => 20 // Base score for being considered
        ],
        // Data Scientist (ID: 2)
        2 => [
            'key_skills' => [
                $skill_names_to_ids['data analysis'] ?? 0,
                $skill_names_to_ids['machine learning'] ?? 0
            ],
            'relevant_skills' => [
                $skill_names_to_ids['problem solving'] ?? 0,
                $skill_names_to_ids['critical thinking'] ?? 0,
                $skill_names_to_ids['programming (php)'] ?? 0 // If they know Python, etc.
            ],
            'ideal_answers' => [
                'Which of these activities do you enjoy most?' => ['Solving complex logical puzzles' => 15],
                'How do you prefer to learn new things?' => ['Reading books and articles' => 10, 'Through mentorship' => 5],
                'What kind of challenges motivate you?' => ['Technical problems' => 10, 'Strategic planning' => 5]
            ],
            'base_score' => 20
        ],
        // Cybersecurity Analyst (ID: 3)
        3 => [
            'key_skills' => [
                $skill_names_to_ids['networking'] ?? 0,
                $skill_names_to_ids['cybersecurity'] ?? 0
            ],
            'relevant_skills' => [
                $skill_names_to_ids['problem solving'] ?? 0,
                $skill_names_to_ids['critical thinking'] ?? 0
            ],
            'ideal_answers' => [
                'How do you prefer to learn new things?' => ['Hands-on practical experience' => 15],
                'What kind of challenges motivate you?' => ['Technical problems' => 15]
            ],
            'base_score' => 20
        ],
        // Digital Marketing Specialist (ID: 4)
        4 => [
            'key_skills' => [
                $skill_names_to_ids['marketing'] ?? 0
            ],
            'relevant_skills' => [
                $skill_names_to_ids['communication'] ?? 0,
                $skill_names_to_ids['content writing'] ?? 0,
                $skill_names_to_ids['web design (html/css)'] ?? 0
            ],
            'ideal_answers' => [
                'Which of these activities do you enjoy most?' => ['Helping and communicating with people' => 10, 'Creating visual designs' => 5],
                'What is your preferred work environment?' => ['Collaborative team-based environment' => 10, 'Flexible environment' => 5]
            ],
            'base_score' => 20
        ],
        // Graphic Designer (ID: 5)
        5 => [
            'key_skills' => [
                $skill_names_to_ids['graphic design'] ?? 0
            ],
            'relevant_skills' => [
                $skill_names_to_ids['web design (html/css)'] ?? 0,
                $skill_names_to_ids['creative thinking'] ?? 0 // assuming creativity is a skill, adjust as needed
            ],
            'ideal_answers' => [
                'Which of these activities do you enjoy most?' => ['Creating visual designs or art' => 20],
                'How do you prefer to learn new things?' => ['Hands-on practical experience' => 10]
            ],
            'base_score' => 20
        ],
        // Network Administrator (ID: 6)
        6 => [
            'key_skills' => [
                $skill_names_to_ids['networking'] ?? 0
            ],
            'relevant_skills' => [
                $skill_names_to_ids['database management (mysql)'] ?? 0,
                $skill_names_to_ids['problem solving'] ?? 0
            ],
            'ideal_answers' => [
                'What is your preferred work environment?' => ['Structured office setting' => 15],
                'Are you comfortable with repetitive tasks?' => ['Very comfortable, I like routine' => 10]
            ],
            'base_score' => 20
        ],
        // Project Manager (ID: 7)
        7 => [
            'key_skills' => [
                $skill_names_to_ids['project management'] ?? 0,
                $skill_names_to_ids['communication'] ?? 0
            ],
            'relevant_skills' => [
                $skill_names_to_ids['teamwork'] ?? 0,
                $skill_names_to_ids['problem solving'] ?? 0
            ],
            'ideal_answers' => [
                'Which of these activities do you enjoy most?' => ['Organizing and managing projects' => 15],
                'What kind of challenges motivate you?' => ['Strategic planning and execution' => 10],
                'What is your preferred work environment?' => ['Collaborative team-based environment' => 10]
            ],
            'base_score' => 20
        ]
        // Add scoring factors for more careers as needed
    ];

    $career_id = $career_info['id'];

    if (!isset($career_scoring_factors[$career_id])) {
        return 0; // No scoring factors defined for this career
    }

    $factors = $career_scoring_factors[$career_id];
    $score += $factors['base_score'];
    $max_possible_score += $factors['base_score'];

    // Score based on key skills
    foreach ($factors['key_skills'] as $skill_id) {
        if ($skill_id > 0 && in_array($skill_id, $user_skills_ids)) {
            $score += $weights['skill_match'];
        }
        $max_possible_score += $weights['skill_match'];
    }

    // Score based on relevant skills
    foreach ($factors['relevant_skills'] as $skill_id) {
        if ($skill_id > 0 && in_array($skill_id, $user_skills_ids)) {
            $score += $weights['skill_match'] * 0.5; // Half weight for relevant
        }
        $max_possible_score += $weights['skill_match'] * 0.5;
    }

    // Score based on quiz answers
    foreach ($factors['ideal_answers'] as $question_text => $answer_scores) {
        if (isset($user_answers[$question_text])) {
            $user_answer = $user_answers[$question_text];
            foreach ($answer_scores as $expected_answer_substring => $contribution) {
                if (strpos($user_answer, $expected_answer_substring) !== false) {
                    $score += $contribution;
                }
                $max_possible_score += $contribution;
            }
        }
        // If question not answered, we don't add to score or max_possible_score for that specific question's ideal answers
    }

    // Calculate percentage
    if ($max_possible_score > 0) {
        $percentage = ($score / $max_possible_score) * 100;
    } else {
        $percentage = 0;
    }

    // Cap at 100 and ensure non-negative
    return max(0, min(100, round($percentage, 2)));
}
?>
