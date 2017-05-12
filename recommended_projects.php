<?php
session_start();
require 'dbconnect.php';
require 'navbar.php';
$email = $_SESSION['email'];
//echo $email;
$sqluser="SELECT * FROM user WHERE email='$email'";
$result = mysqli_query($conn,$sqluser);
$userRow = mysqli_fetch_array($result, MYSQLI_BOTH);

$res = $conn->query("select projectid,interest from interestingprojects where email = '$email' and projectid IS NOT NULL group by projectid, email order by postdate limit 800");
$interests="";
$res1 = $conn->query("select interest from userinterests where email = '$email'");

while($rows=$res1->fetch_array()){
	//echo $rows['interest'];
$interests = $interests.''.$rows['interest'].',';
}
//echo $interests;
echo '<html>
<head>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootcards/1.0.0/css/bootcards-desktop.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />
<link href="css/recommendation_style.css" rel="stylesheet" type="text/css">
<!-- Bootstrap and Bootcards JS -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootcards/1.0.0/js/bootcards.min.js"></script>
<style>

</style>
</head>
<body>';?>


<div class="row">
<h3 style="margin-left:25px;font-family: Poiret One; font-size:30px;font-style:italic;font-weight:800;">Since your interests lie in  
  <span style="color: #ff0000"><?php echo $interests;?></span>
  these projects may interest you...</h3>
     <div class="col-sm-12 col-sm-offset-0">
     	<?php
     while($row = $res->fetch_array()){
     	$project = $row['projectid'];
     	$res_proj = $conn->query("select * from project where projectid = $project");
     	$row_proj = $res_proj->fetch_array();
     	$owneremail=$row_proj['owneremail'];
     	$ownerid = $conn->query("select * from user where email = '$owneremail'");
     	$ownerrow = $ownerid->fetch_array();

$sqlquery2 = $conn->query("select * from projectlikes where projectid = '$project'");
							            $count_likes = $sqlquery2->num_rows;
							            
							            $sqlquery_pledges = $conn->query("select * from pledge where projectid = '$project'");
							            $count_pledges = $sqlquery_pledges->num_rows;
							            $sqlquery1 = $conn->query("select * from projectcomments where projectid = '$project'");
							            $count_comments = $sqlquery1->num_rows;            
							            $sqlquery1 = $conn->query("select sum(pledgeamount) as tot_funds from pledge where projectid = '$project'");
							            $total_funds = mysqli_fetch_assoc($sqlquery1);

							            $sqlquery1 = $conn->query("select minfund, maxfund from project where projectid = '$project'");
							            $project_details = mysqli_fetch_assoc($sqlquery1);
							            if(is_null($total_funds['tot_funds']))
							            {
							                $total_funds['tot_funds'] = '0';
							            }
							            $remaining_funds = $project_details['maxfund']-$total_funds['tot_funds'];
							            


echo'
<div class="panel panel-default bootcards-summary">
  <div class="panel-heading">
    <h3 class="h3-title"><a href="projectdetail.php?'.$row_proj['projectid'].'" style="text-decoration:none;">'.$row_proj['title'].'</a></h3>
  </div>
  <div class="panel-body" width>
    <div class="row">
    <div class="stats-container">
							                                        <div class="stats">
							                                            <h5>'.$count_likes.'</h5>
							                                            <p style="font-size: 15px;">Like(s)</p>
							                                        </div>
							                                        <div class="stats">
							                                            <h5>'.$count_pledges.'</h5>
							                                            <p style="font-size: 15px;">Pledge(s)</p>
							                                        </div>
							                                        <div class="stats">
							                                            <h5>'.$count_comments.'</h5>
							                                            <p style="font-size: 15px;">Comment(s)</p>
							                                        </div>
							                                        <div class="stats">
							                                            <h5>$'.$total_funds['tot_funds'].'</h5>
							                                            <p style="font-size: 15px;">Funds Collected</p>
							                                        </div>
							                                        <div class="stats">
							                                            <h5>$'.$remaining_funds.'</h5>
							                                            <p style="font-size: 15px;">Maximum amount that you can pledge</p>
							                                        </div>
							                                        <div class="stats">
							                                            <h5><a href="myprofiledetails.php?email='.$ownerrow['email'].'" style="text-decoration:none;">'.$ownerrow['firstname'].'</a></h5>
							                                            <p style="font-size: 15px;">Owner</p>
							                                        </div>
							                                    </div>
      <div class="col-xs-6 col-sm-4">';
      
          
   echo' </div>
  </div>
  <div class="panel-footer">';
  if($row_proj['status']=='completed'){
							                                    	echo '<h5 class="text-center1" style="margin-top: 15px;">Status:  <span class="label label-success"><b>'.$row_proj['status'].'</b></span></h5>';
							                                    }
							                                    else{
							                                    	echo '<h5 class="text-center1" style="margin-top: 15px;">Status:  <span class="label label-warning"><b>'.$row_proj['status'].'</b></span></h5>';
							                                    }
   echo'
  </div>
</div>';
}
echo'
</div>
</div>
</body>
</html>';
?>