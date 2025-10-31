<?php
// db.php - Basic database connection
$servername = "sql311.infinityfree.com";
$username = "if0_39831271";
$password = "elvora123";
$dbname = "if0_39831271_elvora";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
