<html>
	<?php
	require 'head.php';
	?>
	<script src="processupdates.js"></script>
<body>
	<?php
	require 'navbar.php';
	$user_name = $_SESSION['email'];
	$querystring = $_SERVER['QUERY_STRING'];
	$projectid = str_replace("projectid=", "", $querystring);
	$log = $conn->query("insert into userlogs values('$user_name','$projectid','projectview', now())");
	$sql = "SELECT * FROM project where projectid=".$projectid;
	$result = $conn->query($sql);
	while ($project_array=mysqli_fetch_assoc($result))
	{
		$owneremail = $project_array["owneremail"];
	    ?>
	    <div class="container" id="product-section">
		  <div class="row">
		   <div class="col-md-6">
		   <div class="usertitle"> 
		   <?php fetchUser($conn, $owneremail); ?>
		   </div>
		    <img class="projimg" id="<?php echo $project_array["projectid"]; ?>" src="imageView.php?image_name=<?php echo $project_array["bannername"]; ?>" height="300" width="300"/>
		   </div>
		   <div class="col-md-6">
		   <div class="row">
			
		   	<h1>
		   	<?php echo "<b>".ucwords($project_array["title"])."</b>"; ?>
	    	</h1>
		   	<?php
		   	fetchTags($conn, $project_array["projectid"]);
		   	echo "<h4>".$project_array["shortdescription"]."</h4>";
		   	fetchPledge($conn, $project_array["projectid"]);
		   	echo "<br> pledged of $".$project_array["maxfund"]." goal <br>";
		    
		    ?>
		    </br>
		    <div>
			    <a type="submit" class="btn btn-default" name="btn-pledge" title="Back this project" href="pledge.php?projectid=<?php echo $project_array["projectid"]; ?>" id="btn-pledge">
			    <span class="glyphicon glyphicon-log-in"></span> &nbsp; Back this project
				</a>
				&nbsp;
				<?php
				if(findlike($conn, $project_array["projectid"])):
				?>
				  <img alt="like" src="http://iconshow.me/media/images/Application/Modern-Flat-style-Icons/png/512/Like.png" 
				  style="height: 40px; width: 50px" id="imgClickAndChange" onclick="changeImage()"  />
				<?php
				else:
				?>
				<img alt="like" src="https://image.flaticon.com/icons/svg/20/20664.svg" 
				  style="height: 40px; width: 50px" id="imgClickAndChange" onclick="changeImage()"  />
				<?php
				endif;
				?>
			</div>
			<br>
			<span class="avgrating">
			<?php 
			
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
			?>
			</span>
			<?php 
			if (showRating($conn, $project_array["projectid"]) && $project_array["status"] == "completed"):
			$proj_rating = getRating($conn, $project_array["projectid"]);
			?>
			<div class="rate">
			<?php
			$row_count = 5;
			while($row_count >= 1){
				if($proj_rating !=0 && $proj_rating <= $row_count){
					$checked = "checked";
				} else{
					$checked = "";
				}
				echo '<input type="radio" '.$checked.' id="star'.$row_count.'" name="rate" value='.$row_count.' />
			  	<label for="star'.$row_count.'" title="text" class="'.$row_count.'star">'.$row_count.' stars</label>';
			  	$row_count -= 1;
			}
			
			?>
			
			</div> <!-- rate -->
			<?php 
			endif;
			?>
			<?php 
		    if($user_name == $owneremail):
		    ?>
			<a type="submit" class="btn btn-default" name="btn-editproject" title="Edit project" href="editproject.php?projectid=<?php echo $project_array["projectid"]; ?>" id="btn-editproject">
			<span class="glyphicon glyphicon-log-in"></span> &nbsp; Edit project
			</a>
			<?php
			endif;
			?>
		   </div>
		  </div><!-- end row -->
		</div>

	    <div>
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#pledges" aria-controls="pledges" role="tab" data-toggle="tab">Pledges</a></li>
		    <li role="presentation"><a href="#updates" aria-controls="updates" role="tab" data-toggle="tab">Updates</a></li>
		    <li role="presentation"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">Comments</a></li>
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
		    <div role="tabpanel" class="tab-pane active" id="pledges"><?php require "pledgedisplay.php"; ?>
		    	
		    </div>


		    <div role="tabpanel" class="tab-pane" id="updates">
		    <?php 
		    if($user_name == $owneremail):
		    ?>
			<div class="signin-form">
			<div class="container">
		       <form class="form-signin" method="post" id="addUpdate" enctype="multipart/form-data" action="addupdate.php?projectid=<?php echo $project_array["projectid"]; ?>">
		        <h2 class="form-signin-heading">Add Updates</h2><hr />
		        <div class="form-group">
		        <input type="text" name="title" id="title" class="form-control" placeholder="Title">
		        
		        </div>
		        <div class="form-group">
		        <textarea class='form-control' rows="4" cols="45" projectid='<?php echo $project_array["projectid"]; ?>' name='longdescription' id='longdescription' placeholder='Content' required></textarea>
		        </div>
		        
		        <div class="form-group">
		        <input type="file" name="projmedia" id="projmedia" class="form-control" multiple="multiple" placeholder="Media">
		     	<input type="hidden" id="projectid" name="projectid" value="<?php echo $project_array["projectid"]; ?>" >
		        </div>
		     	<hr/>
		        <div class="form-group">
		            <button type="submit" class="btn btn-default" name="btn-update" id="btn-update">
		    		<span class="glyphicon glyphicon-log-in"></span> &nbsp; Submit
					</button>
				</div>

				</form>
				</div>
		    	</div>
				<?php 
				endif;
				require 'projupd.php'; ?>
			
		    
		    </div>
		    <div role="tabpanel" class="tab-pane" id="comments">
		    
		    <div class="signin-form">
			<div class="container">
		       <form class="form-signin" method="post" id="addComment" action="">
		        <h2 class="form-signin-heading">Add comments here</h2><hr />
		        <div class="form-group">
		        <div id='comment_type_area' class='comment_type_area'>
	            
	            <textarea class='comment' rows="2" cols="45" projectid='<?php echo $project_array["projectid"]; ?>' id='text_comment' placeholder='Write a Comment'></textarea>
	            </div>
	            <input type="hidden" id="projectid" name="projectid" value="<?php echo $project_array["projectid"]; ?>" >
		        </div>
		       
				</form>
			</div>
			</div>
		    <?php	
	        require 'commentsdisplay.php';
	        ?>
		    </div>
		  </div>

		</div>
		
	    <?php
	}
	?>
</body>
<?php
function fetchComments($conn, $projectid) {
    $sql = "SELECT * FROM projectcomments where projectid=".$projectid;
	$result = $conn->query($sql);
	while ($comment_array=mysqli_fetch_assoc($result))
	{
		?>

		<li class="media">
		<div class="media-left">
		<?php echo $comment_array["comment"]; ?>
		</div>
		</li>
		<?php
	}
}

function showRating($conn, $projectid) {
	$user_name = $_SESSION['email'];

	$sqlfind = "SELECT * from pledge where email = '".$user_name."' and projectid = ".$projectid;

	$result = $conn->query($sqlfind);
	return (mysqli_num_rows($result) > 0);
}
function getRating($conn, $projectid) {
	$user_name = $_SESSION['email'];

	$sqlfind = "SELECT rating from projectrating where email = '".$user_name."' and projectid = ".$projectid;

	$result = $conn->query($sqlfind);
	if (mysqli_num_rows($result) > 0) {
		while ($result_arr = mysqli_fetch_assoc($result)) {
			return $result_arr['rating'];
		}
	}
	return 0;
}
function fetchPledge($conn, $projectid) {
    $sql = "SELECT sum(pledgeamount) as pledgeamount FROM pledge where projectid=".$projectid;
	$result = $conn->query($sql);
	while ($pledge_array=mysqli_fetch_assoc($result))
	{
		?>
		<b>
		<?php
		if(is_null($pledge_array["pledgeamount"])){
			echo "$0";
		} else{
			echo "$".$pledge_array["pledgeamount"];
		}
		?>
		
		</b>
		<?php
	}
	
}
function findlike($conn, $projectid){
	$user_name = $_SESSION['email'];
	$sqlfind = "SELECT * from projectlikes where email = '".$user_name."' and projectid = ".$projectid;
	$result = $conn->query($sqlfind);
	return mysqli_num_rows($result) > 0;
}
function fetchUser($conn, $owneremail){
	$sqlfind = "SELECT firstname, lastname from user where email = '".$owneremail."'";
	$result = $conn->query($sqlfind);
	while ($user_array=mysqli_fetch_assoc($result))
	{
		echo "<h3> Campaign Started By: ";
		echo $user_array["firstname"]." ";
		echo $user_array["lastname"];
		echo "</h3>";
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
	echo "<div class='tags'>";
	echo $tags;
	echo "</div>";
}
?>


<script>
$(document).ready(function(){
	$('.projimg').click(function() {
	   var id = $(this).attr('id');
	   window.location.href = "projectdetail.php?projectid="+id;
   	   return false;
	});
	// $("#addUpdate").hide();
 //        $("#updatebtn").click(function(e) {
 //            $("#addUpdate").show();
 //            $("#updatebtn").hide();

 //    });

 	document.getElementById("addUpdate").onsubmit = function(){
    	setTimeout(window.location.reload(), 10);
	}
	$('.comment').keydown(function (e){
        if (e.keyCode == 13) {
            var projectid = $(this).attr('projectid');
            var comment = $(this).val();
            var posting = $.post('comment.php', { projectid: projectid, comment: comment });
	        	posting.done(function( data ){
	        		$('#comments').load('createcomment.php?projectid='+projectid);
	        	});
        }
	});

  $("#star1, #star2, #star3, #star4, #star5").click(function(e) {
    	var rating = $(this).val();
    	
    	var projectid = document.getElementById('projectid').value;
    	var posting = $.post('createrating.php', { projectid: projectid, rating: rating });
  });
});

function changeImage() {
        if (document.getElementById("imgClickAndChange").src == "https://image.flaticon.com/icons/svg/20/20664.svg") 
        {
            document.getElementById("imgClickAndChange").src = "http://iconshow.me/media/images/Application/Modern-Flat-style-Icons/png/512/Like.png";
        }
        else 
        {
            document.getElementById("imgClickAndChange").src = "https://image.flaticon.com/icons/svg/20/20664.svg";
        }
        var projectid = document.getElementById('projectid').value;
    	var posting = $.post('createlike.php', { projectid: projectid});
}

</script>
</html>