<html>
	<?php
	require 'head.php';
	?>
<body>
	<?php
	require 'navbar.php';
	$commentdata = $_POST['comment'];
	$projectid = $_POST['projectid'];
	$user_name = $_SESSION['email'];
	?>
	<div id="main-content" class="container">
	  <h2 class="text-center menu-title">Projects</h2>
	  <div id="menu-item"> 
	    <h3 class="menu-item-title"><?php echo $projectid;
	    echo $commentdata; ?></h3>
	    <?php
	    $sqlcomment = "INSERT INTO projectcomments values (".$projectid.", '".$user_name."', '".$commentdata."', now())";
		if ($conn->query($sqlcomment) === TRUE) {
		    echo "Congratulations!! Your comment has been created successfully.";
		} else {
		    echo "Error: <br>" . $conn->error;
		}
	
	?>
	</div>
	</div>
</body>

</html>