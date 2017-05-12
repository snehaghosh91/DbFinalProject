
<?php
	require 'dbconnect.php';
	date_default_timezone_set("America/New_York");
	$updatedate = date("Y-m-d H:i:s");
	$title = $_POST["title"];
	$shortdescription = $_POST["description"];
	$minfund = $_POST["minfund"];
	$projectid = $_POST["projectid"];
	$maxfund = $_POST["maxfund"];
	$enddate = $_POST["enddate"];
	$releasedate = $_POST["releasedate"];
	$imagename = $_FILES["myimage"]["name"];
	$sqlproject = 'Update project set title="'.$title.'",  shortdescription="'.$shortdescription.'", bannername="'.$imagename.'", postdate="'.$updatedate.'", enddate="'.$enddate.'", plannedrelease="'.$releasedate.'",  minfund='.$minfund.', maxfund='.$maxfund.' where projectid='.$projectid;
	if ($conn->query($sqlproject) === TRUE) {
	    // echo "Congratulations!! Your project has been created successfully.";
	} else {
	    echo "Error: <br>" . $conn->error;
	}
	if($imagename != null){
		$imgData = addslashes(file_get_contents($_FILES['myimage']['tmp_name']));
		$sqlimage = "INSERT INTO media(name, media) VALUES ('{$imagename}', '{$imgData}')";
		if ($conn->query($sqlimage) === TRUE) {
		   // echo "New record created successfully";
		} else {
	    echo "Error: <br>" . $conn->error;
	}
	}
	$redirectTo ='projectdetail.php?projectid='.$projectid.'';
	echo "<script type='text/javascript'>document.location.href='{$redirectTo}';</script>";
?>