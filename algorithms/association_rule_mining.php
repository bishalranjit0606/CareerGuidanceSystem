<?php
// algorithms/association_rule_mining.php

/**
 * Recommends new skills based on existing user skills using pre-defined association rules.
 *
 * @param array $user_skills_ids An array of skill IDs the user possesses.
 * @param array $all_skills An array of all available skills (id, name).
 * @return array An array of suggested skill names.
 */
function getAssociationSkillSuggestions($user_skills_ids, $all_skills) {
    $suggested_skills_ids = [];
    $all_skill_names_map = []; // Map ID to Name for output
    foreach ($all_skills as $skill) {
        $all_skill_names_map[$skill['id']] = $skill['name'];
    }

    // Define simplified association rules:
    // If a user has skill A, suggest skill B.
    // Key = existing skill ID, Value = array of suggested skill IDs
    $association_rules = [
        1 => [3, 4],    // If Programming (PHP), suggest Database Management (MySQL), Problem Solving
        2 => [1, 13],   // If Web Design (HTML/CSS), suggest Programming (PHP), Graphic Design
        3 => [1, 9],    // If Database Management (MySQL), suggest Programming (PHP), Data Analysis
        9 => [5, 10],   // If Data Analysis, suggest Critical Thinking, Machine Learning
        12 => [11, 4],  // If Cybersecurity, suggest Networking, Problem Solving
        15 => [6, 14]   // If Marketing, suggest Communication, Content Writing
    ];

    foreach ($user_skills_ids as $skill_id) {
        if (isset($association_rules[$skill_id])) {
            foreach ($association_rules[$skill_id] as $suggested_id) {
                // Only suggest if the user doesn't already have the skill
                if (!in_array($suggested_id, $user_skills_ids) && !in_array($suggested_id, $suggested_skills_ids)) {
                    $suggested_skills_ids[] = $suggested_id;
                }
            }
        }
    }

    // Convert suggested skill IDs to names
    $suggested_skill_names = [];
    foreach ($suggested_skills_ids as $id) {
        if (isset($all_skill_names_map[$id])) {
            $suggested_skill_names[] = $all_skill_names_map[$id];
        }
    }

    return $suggested_skill_names;
}
?>
