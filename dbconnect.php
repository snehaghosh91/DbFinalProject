<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);
$db = 'kickstarter_schema';
$servername = "localhost:3306";
$username = "root";
$password = "";
// session_start();
// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
