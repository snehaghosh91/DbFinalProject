<?php
session_start();
require 'head.php'; 
require 'dbconnect.php';

$projectid = $_POST["projectid"];
$user_name = $_SESSION['email'];
$rating = $_POST["rating"];

$sqlfind = "SELECT * from projectrating where email = '".$user_name."' and projectid = ".$projectid;
$result = $conn->query($sqlfind);
echo $conn->error;
if (mysqli_num_rows($result) > 0) {
  $sqlupdate = "UPDATE projectrating set rating = ".$rating." where email = '".$user_name."' and projectid = ".$projectid;
  $conn->query($sqlupdate);
} else {
  $sqlrating = "INSERT INTO projectrating(projectid, email, rating) values (".$projectid.", '".$user_name."', ".$rating.")";
  $conn->query($sqlrating);
}
?>