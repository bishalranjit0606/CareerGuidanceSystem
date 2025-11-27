<?php
// config/config.php

// Database configuration
// Use environment variables if available (Docker), otherwise fall back to local defaults (XAMPP)
define('DB_SERVER', getenv('DB_SERVER') ?: 'localhost');
define('DB_USERNAME', getenv('DB_USERNAME') ?: 'root');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'career_guidance_db');
define('DB_PORT', getenv('DB_PORT') ?: 3307);

// Attempt to establish a database connection
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
