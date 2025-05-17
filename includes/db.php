<?php
// Database configuration
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '254KeNYA&&!!';
$DB_NAME = 'fin';
$DB_PORT = 3306;

// Create connection
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: set charset to utf8mb4 for full Unicode support
$conn->set_charset("utf8mb4");
?>
