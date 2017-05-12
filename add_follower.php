<?php		
	require 'dbconnect.php';					
	$followeremail = $_POST['uname'];
	$useremail = $_POST['other_uname'];
	$sqlquery = "insert into follower values ('$useremail', '$followeremail')";
    $conn->query($sqlquery);
    echo 'success';
  ?>