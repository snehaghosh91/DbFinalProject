<html>
	<?php
	require 'head.php';
	?>
<body>
	<?php
	session_start();
	$querystring = $_SERVER['QUERY_STRING'];
	$user_name = $_SESSION['email'];
	if(is_null($user_name)){
		require 'navbar2.php';
	} else{
		require 'navbar.php';
	}
	$categoryname = str_replace("cat=", "", $querystring);
	?>
	<div id="main-content" class="container">
	  <h2 class="text-center title">Projects in <?php echo $categoryname; ?> Category</h2>
	  <div id="menu-item">
	    
	    
	<?php
	$sql = "SELECT * FROM project where categoryname='".$categoryname."'";
	$result = $conn->query($sql);
	$count = 0;
	while ($project_array=mysqli_fetch_assoc($result))
	{
		if($count %3 == 0){
			echo "<div class='row'>";
		}
		
	    echo "<div class='col-lg-4 col-md-4 col-sm-4 col-xs-12'>";
	    ?>
	    <img class="projimg" user="<?php echo $user_name; ?>" id="<?php echo $project_array["projectid"]; ?>" src="imageView.php?image_name=<?php echo $project_array["bannername"]; ?>" height="300" width="300"/><br/>
	    <?php
	    echo "<h3><b>".ucwords($project_array["title"])."</b></h3> <div> <h4>".$project_array["shortdescription"]." <h4></div>";
	    if($project_array["status"] == "completed"){
	    	echo '<h5 style="margin-top: 15px;">Status:  <span class="label label-success"><b>'.$project_array["status"].'</b></span></h5>';
	    } else{
	    	echo '<h5 style="margin-top: 15px;">Status:  <span class="label label-warning"><b>'.$project_array["status"].'</b></span></h5>';
	    }
	    

		fetchTags($conn, $project_array["projectid"]);
		fetchLikes($conn, $project_array["projectid"]);
		echo "<span class='avgrating'>";
		fetchAvgRating($conn, $project_array["projectid"]);
		echo "</span>";
		
		echo '<h3 class="name"><a href="myprofiledetails.php?email='.$project_array['owneremail'].'" style="text-decoration:none;">'.$project_array['owneremail'].'</a></h3>';
		echo "</div>";
	    if(($count+1) %3 == 0){
			echo "</div>";
		}
	    $count += 1;
	}
	?>
	</div>
	</div>
	<script>
	$(document).ready(function(){
	$('.projimg').click(function() {
	   var id = $(this).attr('id');
	   var user = $(this).attr('user');
	   if(user == ''){
	   		window.location.href = "login.php";
	   } else{
	   		window.location.href = "projectdetail.php?projectid="+id;
	   }
	   
   	   return false;
	});
	});
	</script>
</body>
<?php
function fetchMedia($conn, $projectid) {
    $sql = "SELECT * FROM projectmedia where projectid='".$projectid."'";
	$result = $conn->query($sql);
	while ($media_array=mysqli_fetch_assoc($result))
	{
		?>
			<img src="imageView.php?image_id=<?php echo $media_array["mediaid"]; ?>" height="300" width="300"/><br/>
		<?php
	}
}
function fetchTags($conn, $projectid) {
    $sql = "SELECT distinct tagname FROM projecttags join tag where projectid='".$projectid."'";
	$result = $conn->query($sql);
	if (mysqli_num_rows($result) > 0) {
		$tags = "|";
	} else {
		return;
	}
	while ($tags_array=mysqli_fetch_assoc($result))
	{
		$tags = $tags." ".$tags_array["tagname"]." | ";
	}
	echo $tags;
}
function fetchLikes($conn, $projectid) {
    $sql = "SELECT count(*) as likes FROM projectlikes where projectid='".$projectid."'";
	$result = $conn->query($sql);
	
	while ($like_array=mysqli_fetch_assoc($result))
	{
		echo "<h4> Likes: ".$like_array["likes"]."</h4>";
	}
}
function fetchAvgRating($conn, $projectid) {
	$sqlfind = "SELECT AVG(rating) as avgrating from projectrating where projectid = ".$projectid;
			$result = $conn->query($sqlfind);
			if (mysqli_num_rows($result) > 0) {
				while ($rating_array=mysqli_fetch_assoc($result))
				{
					if(!is_null($rating_array['avgrating'])){
						echo "<h3> Avg. ".$rating_array['avgrating']." out of 5 </h3>";
					}
			  		
				}
			} 
}
?>
</html>