<html>
<body>
	<?php
	$querystring = $_SERVER['QUERY_STRING'];
	$projectid = str_replace("projectid=", "", $querystring);
	?>
	<div role="tabpanel" class="tab-pane" id="pledges">
		    	
    <div id="pledgesection">
		 
				
	<?php
	
	$sql_pledge_dis = "SELECT * FROM pledge where projectid=".$projectid;
	$res = $conn->query($sql_pledge_dis);
	while ($pledge_array=mysqli_fetch_assoc($res))
	{
		echo "<div class='col-sm-5'>";
		echo "<div class='panel panel-default'>";
		echo "<div class='panel-heading'>";
		echo "<strong>".$pledge_array["email"]."</strong> <span class='text-muted'>pledged on ".$pledge_array["pledgedate"]."</span>";
		echo "</div>";
		echo "<div class='panel-body'>";
		echo "Amount: $".$pledge_array["pledgeamount"];
		echo "</div>";
		echo "</div>";
		echo "</div>";
	}

	?>

		</div>
	</div>
</body>

</html>
