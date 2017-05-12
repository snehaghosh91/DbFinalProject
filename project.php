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
	?>


<div class="signin-form">
	<div class="container">
       <form class="form-signin" action="createproject.php"  method="post" name="createproject-form" id="createproject-form" enctype="multipart/form-data">
        <h2 class="form-signin-heading">Start Your Campaign</h2><hr />
          
        <div class="form-group">
        <input type="text" class="form-control" placeholder="Project Name" name="title" required/>
        </div>

		<div class="form-group">
		<textarea name="description" class="form-control" placeholder="Description" rows="2" cols="45" required></textarea>
        </div>
		
        <div class="form-group">
        <input type="file" class="form-control" placeholder="Media"  name="myimage" required>
        </div>
        
        <div class="form-group">
        <?php 
		$categories = array();
		$sql = "SELECT categoryname FROM categories";
		$result = $conn->query($sql);
		echo "<select name='category' class='form-control' placeholder='Category' onchange=document.getElementById('selectedcategory').value=this.options[this.selectedIndex].text>";
		$count = 0;
		echo "<option value=$count > Select Category </option>";
		while ($cat_array=mysqli_fetch_assoc($result))
		{
			$count += 1;
		    echo "<option value=$count >".htmlspecialchars($cat_array["categoryname"])."</option>";
		}
		echo "</select>";
		?>
		<input type="hidden" name="selectedcategory" id="selectedcategory" value=""  />
        </div>
        
		<div class="form-group">
        <input type="text" class="form-control" placeholder="Min Fund" name="minfund" required>
        </div>
		
		<div class="form-group">
        <input type="text" class="form-control" placeholder="Max Fund" name="maxfund" required>
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
    		<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Project
			</button>
        </div> 
      
      </form>

    </div>
    
</div>

</body>
</html>