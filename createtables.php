<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task1DB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// sql to create table
$sql = "Create TABLE Users (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(600) NOT NULL,
name VARCHAR(300) NOT NULL,
password VARCHAR(200) NOT NULL,
reg_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Users created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
$sql = "Create TABLE Codes (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
uniqueid VARCHAR(60) NOT NULL,
username VARCHAR(60) NOT NULL,
code TEXT,
expirydate DATETIME,
reg_date TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Table Codes created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();

?>
