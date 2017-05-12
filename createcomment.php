<html>
	<?php
	require 'head.php';
	?>
<body>
	<?php
	require 'dbconnect.php';
	$querystring = $_SERVER['QUERY_STRING'];
	$projectid = str_replace("projectid=", "", $querystring);
	?>
	<div role="tabpanel" class="tab-pane" id="comments">
		    	
    	<div class="signin-form">
		<div class="container">
	       <form class="form-signin" method="post" id="addComment" action="addupdate.php?projectid=<?php echo $projectid; ?>">
	        <h2 class="form-signin-heading">Add comments here</h2><hr />
	        <div class="form-group">
	        <div id='comment_type_area' class='comment_type_area'>
            
            <textarea class='comment' rows="2" cols="45" projectid='<?php echo $projectid; ?>' id='text_comment' placeholder='Write a Comment'></textarea>
            </div>
	        </div>
	       
			</form>
		</div>
		</div>
	<br>
	<?php
	require 'commentsdisplay.php';
	?>
</div>
</body>
</html>