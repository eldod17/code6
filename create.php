<?php
// configuration
$dbhost = "localhost";
$dbname = "educational_platform";
$dbuser = "root";
$dbpass = "";

// create connection
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL queries to create tables
$sql = "
CREATE TABLE IF NOT EXISTS users2 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'admin') NOT NULL DEFAULT 'student'
);

CREATE TABLE IF NOT EXISTS lessons_access (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    lesson_id INT NOT NULL,
    access_allowed BOOLEAN NOT NULL DEFAULT TRUE,
    FOREIGN KEY (user_id) REFERENCES users2(id),
    UNIQUE KEY (user_id, lesson_id)
);

CREATE TABLE IF NOT EXISTS lessons (
    lesson_id INT AUTO_INCREMENT PRIMARY KEY,
    lesson_name VARCHAR(100) NOT NULL
);
";

// execute the SQL queries
if ($conn->multi_query($sql) === TRUE) {
    echo "Tables created successfully";
} else {
    echo "Error creating tables: " . $conn->error;
}

// close connection
$conn->close();
?>
