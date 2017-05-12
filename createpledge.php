<html>
	<?php
	session_start();
	require 'head.php'; 
	?>
<body>
	<?php
	require 'dbconnect.php';
	
	$projectid = $_POST["projectid"];
	$user_name = $_SESSION['email'];
	$ccn = $_POST["selectedcard"];
	$pledgeamount = $_POST["pledgeamount"];
	$log = $conn->query("insert into userlogs values('$user_name','$projectid','projectpledge', now())");

	$sqlpledge = "INSERT INTO pledge(projectid, email, ccn, pledgeamount, pledgedate) values (".$projectid.", '".$user_name."', '".$ccn."', ".$pledgeamount.", now())";
	if ($conn->query($sqlpledge) === TRUE) {
	    $redirectTo ='projectdetail.php?projectid='.$projectid.'';
    	echo "<script type='text/javascript'>document.location.href='{$redirectTo}';</script>";
	} else {
	    echo "Error: <br>" . $conn->error;
	}
	
?>
</body>
</html>