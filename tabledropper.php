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
$sql = "DROP TABLE Users";
if ($conn->query($sql) === TRUE) {
    echo "Table Users created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
$sql = "DROP TABLE Codes";
if ($conn->query($sql) === TRUE) {
    echo "Table Codes created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
