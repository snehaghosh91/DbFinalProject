<html>
	<?php
	require 'head.php'; 
	?>
<body>
	<?php
	require 'navbar.php';
	$querystring = $_SERVER['QUERY_STRING'];
	$projectid = str_replace("projectid=", "", $querystring);

	$sqlfindmaxfund = "SELECT maxfund from project where projectid = ".$projectid;
	$result_maxfund = $conn->query($sqlfindmaxfund);
	while ($fund_array=mysqli_fetch_assoc($result_maxfund))
	{
		$maxfund = $fund_array["maxfund"];
	}
	$sqlfindpledged = "SELECT sum(pledgeamount) as pledged from pledge where projectid = ".$projectid;
	$result_pledged = $conn->query($sqlfindpledged);
	while ($pledge_array=mysqli_fetch_assoc($result_pledged))
	{
		$pledgedsofar = $pledge_array["pledged"];
	}
	?>
	<div class="signin-form">
	<div class="container">
    <form class="form-signin" action="createpledge.php" method="post" name="pledge-form" id="pledge-form" onsubmit="return validateForPledge(<?php echo $maxfund.",".$pledgedsofar ?>)">
    <h2 class="form-signin-heading">Support this project</h2><hr />
 		<div class="form-group">
        <input type="text" class="form-control" placeholder="Pledge Amount" name="pledgeamount" required/>
        <div id="pledgeerror" class="showerror"> </div>
        </div>
		<div class="form-group">
		<?php
			$sql = "SELECT ccn FROM creditcardowner where email='".$email."'";
			$result = $conn->query($sql);
			echo "<select name='ccn' required class='form-control' onchange=document.getElementById('selectedcard').value=this.options[this.selectedIndex].text>";
			$count = 0;
			echo "<option value='' > Select Card </option>";
			while ($ccn_array=mysqli_fetch_assoc($result))
			{
				$count += 1;
			    echo "<option value=$count >".htmlspecialchars($ccn_array["ccn"])."</option>";
			}
			echo "</select>";
			?>
			<input type="hidden" name="selectedcard" id="selectedcard" value="" />
			<input type="hidden" name="projectid" id="projectid" value="<?php echo $projectid ?>" />
			
		</div>
		<div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-pledge">
    		<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Pledge
			</button> 
            <button type="reset" class="btn btn-default"> Clear
            </button>
        </div>

	</form>
<script type="text/javascript">
	
function validateForPledge(maxfund,pledgedsofar) {
	flag = true;
	totalpledgeamount = parseInt(document.forms["pledge-form"]["pledgeamount"].value) + pledgedsofar;
	allowedpledge = maxfund - pledgedsofar;
 	if(totalpledgeamount > maxfund){
 		flag = false;
 		document.getElementById('pledgeerror').innerHTML="Sorry you cannot pledge more than "+allowedpledge;
    	
 	}
    return flag;
}
</script>
</body>
</html>