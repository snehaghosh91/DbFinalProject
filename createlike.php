<?php
session_start();
require 'dbconnect.php';

$projectid = $_POST["projectid"];
$user_name = $_SESSION['email'];

$sqlfind = "SELECT * from projectlikes where email = '".$user_name."' and projectid = ".$projectid;
$result = $conn->query($sqlfind);
if (mysqli_num_rows($result) > 0) {
  $sqldelete = "DELETE FROM projectlikes where email = '".$user_name."' and projectid = ".$projectid;
  $conn->query($sqldelete);
} else {
  $sqlinsert = "INSERT INTO projectlikes(projectid, email, liketime) values (".$projectid.", '".$user_name."', now())";
  $conn->query($sqlinsert);
}
?>
