<?php
// Database configuration constants
define('DB_HOST', 'localhost');  // Replace with your database host
define('DB_USERNAME', 'root');   // Replace with your database username
define('DB_PASSWORD', '');       // Replace with your database password
define('DB_NAME', 'kodego_db');  // Replace with your database name

// Create a database connection
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
