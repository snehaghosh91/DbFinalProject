<html>
	<?php
	require 'head.php'; 
	?>
	<script type="text/javascript">
		$( function() {
	    $( "#enddatepicker" ).datepicker({showButtonPanel: true,
	                changeMonth: true,
	                dateFormat: 'yy-mm-dd'});

	    $( "#releasedatepicker" ).datepicker({showButtonPanel: true,
	                changeMonth: true,
	                dateFormat: 'yy-mm-dd'});
		});
	</script>
<body>
	<?php
	require 'header.php';
	$querystring = $_SERVER['QUERY_STRING'];
	$projectid = str_replace("projectid=", "", $querystring);
	$sql = "SELECT * FROM project where projectid=".$projectid;
	$result = $conn->query($sql);
	while ($project_array=mysqli_fetch_assoc($result))
	{
		$title = $project_array["title"];
		$description = $project_array["shortdescription"];
		$categoryname = $project_array["categoryname"];
		$minfund = $project_array["minfund"];
	 	$maxfund = $project_array["maxfund"];
	}
	?>


<div class="signin-form">
	<div class="container">
       <form class="form-signin" action="updateproject.php"  method="post" name="updateproject-form" id="updateproject-form" enctype="multipart/form-data">
        <h2 class="form-signin-heading">Edit Your Campaign</h2><hr />
          
        <div class="form-group">
        <input type="text" class="form-control" placeholder="Project Name" name="title" value="<?php echo $title; ?>" required/>
        </div>

		<div class="form-group">
		<textarea name="description" class="form-control" placeholder="Description" rows="2" cols="45" required><?php echo $description; ?></textarea>
        </div>
		
        <div class="form-group">
        <input type="file" class="form-control" placeholder="Media"  name="myimage" required>
        </div>
        
        
		<input type="hidden" name="projectid" id="projectid" value="<?php echo $projectid; ?>"  />
        
        
		<div class="form-group">
        <input type="text" class="form-control" placeholder="Min Fund" name="minfund" value="<?php echo $minfund; ?>" required>
        </div>
		
		<div class="form-group">
        <input type="text" class="form-control" placeholder="Max Fund" name="maxfund" value="<?php echo $maxfund; ?>" required>
        </div>
        
		<div class="form-group">
        <input type="text" class="form-control" placeholder="End Date" id="enddatepicker" name="enddate" required>
        </div>
        
		<div class="form-group">
        <input type="text" class="form-control" placeholder="Release  Date" id="releasedatepicker" name="releasedate" required>
        </div>
     	<hr />
        
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-createproj">
    		<span class="glyphicon glyphicon-log-in"></span> &nbsp; Update Project
			</button>
        </div> 
      
      </form>

    </div>
    
</div>

</body>
</html>