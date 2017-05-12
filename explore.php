<html>
<head>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootcards/1.0.0/css/bootcards-desktop.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />

<!-- Bootstrap and Bootcards JS -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootcards/1.0.0/js/bootcards.min.js"></script>
</head>
<?php
	session_start();
	$user_name = $_SESSION['email'];
	if(is_null($user_name)){
		require 'navbar2.php';
	} else{
		require 'navbar.php';
	}
?>
<body>
	<h2>Explore Categories</h2>
	<?php

	$sql = "SELECT categoryname FROM categories";
	$result = $conn->query($sql);
	
	?>
	<div 
	<div class="row">
	<div class="panel panel-default bootcards-summary">
	  <div class="panel-heading">
	  	<?php
		while ($cat_array=mysqli_fetch_assoc($result))
		{
		    echo "<h3 class='h3-title text-center'>";
			echo "<a href='projectlist.php?cat=".$cat_array["categoryname"]."''>".htmlspecialchars($cat_array["categoryname"])."</a> </br>";
			echo "</h3>";
		}
		?>
	    
	  </div>
	  </div>
	  </div>
</body>
</html>