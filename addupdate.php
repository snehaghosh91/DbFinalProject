<html>
	<?php
	require 'head.php'; 
	?>
    <body>
	    <?php
		require 'header.php'; 
		?>
        <?php
           	date_default_timezone_set("America/New_York");
			$updatedate = date("Y-m-d H:i:s");
		   	$projectid = $_POST["projectid"];
		   	$longdescription = $_POST["longdescription"];
		   	$title = $_POST["title"];
		   	$sqlprojectupdate = "INSERT INTO projectupdates values (".$projectid.", '".$updatedate."', '".$title."', '".$longdescription."')";
			if ($conn->query($sqlprojectupdate)) {
			    echo "Project media";
			} else {
			    echo "Error: <br>" . $conn->error;
			}
			$countoffiles = $_POST["countoffiles"];
	        //Loop through each file
	        for($i=0; $i < $countoffiles; $i++){
	        	$imagename = $_FILES['projmedia'.$i]['name'];
	        	echo $imagename;
	        	if($imagename != null){
					$imgData = addslashes(file_get_contents($_FILES['projmedia'.$i]['tmp_name']));
					$sqlmedia = "INSERT INTO media(name, media) VALUES ('{$imagename}', '{$imgData}')";
					if ($conn->query($sqlmedia) === TRUE) {
						$inserted_id = $conn->insert_id;
					    echo "New media created successfully";
					} else {
				    	echo "Error: <br>" . $conn->error;
				    	$sqlfetchmedia = "SELECT mediaid from media where media='{$imgData}'";
				    	$result = $conn->query($sqlfetchmedia);
				    	while ($array=mysqli_fetch_assoc($result))
						{
				    		$inserted_id=$array["mediaid"];
				    	}
					}
					$sqlprojmedia = "INSERT INTO projectmedia values (".$inserted_id.", ".$projectid.", '".$updatedate."')";
					if ($conn->query($sqlprojmedia) === TRUE) {
						$inserted_id = $conn->insert_id;
					    echo "New projectmedia created successfully";
					} else {
				    	echo "Error: <br>" . $conn->error;
					}
				}
			}
			
        ?>
        
    </body>
</html> 