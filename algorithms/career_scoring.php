<?php
// algorithms/career_scoring.php

/**
 * Calculates a compatibility score for each career based on user's skills and quiz answers.
 * This replaces the strict rule-based filtering with a more flexible scoring system.
 *
 * @param array $user_skills_ids An array of skill IDs the user possesses.
 * @param array $user_answers An associative array of quiz questions and their answers.
 * @param array $all_careers An array of all available careers (id, title, description).
 * @param array $all_skills An array of all available skills (id, name).
 * @return array An associative array of career_title => score, sorted descending.
 */
function getCareerCompatibilityScores($user_skills_ids, $user_answers, $all_careers, $all_skills) {
    $career_scores = [];

    // Map skill names to IDs for easier rule definition
    $skill_names_to_ids = [];
    foreach ($all_skills as $skill) {
        $skill_names_to_ids[strtolower($skill['name'])] = $skill['id'];
    }

    // Define scoring factors for each career
    // Each career has:
    // - 'key_skills': skill IDs crucial for this career (high points)
    // - 'relevant_skills': skill IDs beneficial for this career (medium points)
    // - 'ideal_answers': quiz answers that strongly align (question => expected_answer_substring => points)
    $scoring_factors = [
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
                'What is your preferred work environment?' => ['Flexible environment' => 10],
                'Which of these activities do you enjoy most?' => ['Solving complex logical puzzles' => 10],
                'How do you prefer to learn new things?' => ['Hands-on practical experience' => 5],
                'What kind of challenges motivate you?' => ['Technical problems' => 5]
            ],
            'base_score' => 10 // Starting score for any career
        ],
        // Data Scientist (ID: 2)
        2 => [
            'key_skills' => [
                $skill_names_to_ids['data analysis'] ?? 0,
                $skill_names_to_ids['machine learning'] ?? 0 // If added as skill
            ],
            'relevant_skills' => [
                $skill_names_to_ids['critical thinking'] ?? 0,
                $skill_names_to_ids['problem solving'] ?? 0
            ],
            'ideal_answers' => [
                'Which of these activities do you enjoy most?' => ['Solving complex logical puzzles' => 10],
                'How do you prefer to learn new things?' => ['Reading books and articles' => 10],
                'What is your preferred work environment?' => ['Structured office setting' => 5]
            ],
            'base_score' => 10
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
                'What kind of challenges motivate you?' => ['Technical problems' => 10]
            ],
            'base_score' => 10
        ],
        // Digital Marketing Specialist (ID: 4)
        4 => [
            'key_skills' => [
                $skill_names_to_ids['marketing'] ?? 0,
                $skill_names_to_ids['communication'] ?? 0
            ],
            'relevant_skills' => [
                $skill_names_to_ids['content writing'] ?? 0,
                $skill_names_to_ids['web design (html/css)'] ?? 0
            ],
            'ideal_answers' => [
                'Which of these activities do you enjoy most?' => ['Helping and communicating with people' => 10],
                'What is your preferred work environment?' => ['Collaborative team-based environment' => 10]
            ],
            'base_score' => 10
        ],
        // Graphic Designer (ID: 5)
        5 => [
            'key_skills' => [
                $skill_names_to_ids['graphic design'] ?? 0
            ],
            'relevant_skills' => [
                $skill_names_to_ids['web design (html/css)'] ?? 0,
                // Assume creativity, artistic flair as implicit skills
            ],
            'ideal_answers' => [
                'Which of these activities do you enjoy most?' => ['Creating visual designs or art' => 15],
                'How do you prefer to learn new things?' => ['Hands-on practical experience' => 10]
            ],
            'base_score' => 10
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
                'Are you comfortable with repetitive tasks?' => ['Very comfortable' => 10]
            ],
            'base_score' => 10
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
                'What kind of challenges motivate you?' => ['Strategic planning' => 10],
                'What is your preferred work environment?' => ['Collaborative team-based environment' => 10]
            ],
            'base_score' => 10
        ],
    ];

    foreach ($all_careers as $career) {
        $current_career_id = $career['id'];
        $current_career_title = $career['title'];
        $score = 0;

        if (isset($scoring_factors[$current_career_id])) {
            $factors = $scoring_factors[$current_career_id];
            $score += $factors['base_score'];

            // Score based on key skills
            foreach ($factors['key_skills'] as $skill_id) {
                if ($skill_id > 0 && in_array($skill_id, $user_skills_ids)) {
                    $score += 15; // High points for key skills
                }
            }

            // Score based on relevant skills
            foreach ($factors['relevant_skills'] as $skill_id) {
                if ($skill_id > 0 && in_array($skill_id, $user_skills_ids)) {
                    $score += 5; // Medium points for relevant skills
                }
            }

            // Score based on quiz answers
            foreach ($factors['ideal_answers'] as $question_text => $answer_contributions) {
                if (isset($user_answers[$question_text])) {
                    $user_answer = $user_answers[$question_text];
                    foreach ($answer_contributions as $expected_answer_substring => $contribution) {
                        if (strpos(strtolower($user_answer), strtolower($expected_answer_substring)) !== false) {
                            $score += $contribution;
                        }
                    }
                }
            }
        }
        $career_scores[$current_career_title] = $score;
    }

    // Sort careers by score in descending order
    arsort($career_scores);

    return $career_scores;
}
?>
