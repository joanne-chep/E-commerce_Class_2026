<?php
// Enable explicit error reporting to expose any suppressed runtime exceptions
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Import the database credentials and active MySQLi connection object
require "db.php";

// Define the schema for the tasks table if it does not already exist
$sql = "CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('pending', 'in_progress', 'done') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Execute table creation query on the pre-selected institutional database
if ($conn->query($sql) === TRUE) {
    echo "<h2>Setup complete!</h2>";
    echo "<p><a href='index.php'>Go to Tasks App</a></p>";
} else {
    echo "Error creating table: " . $conn->error;
}

// Terminate the active MySQL connection handle
$conn->close();