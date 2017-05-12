<?php
session_start();
require 'dbconnect.php';
$email='';
$searchkeyRaw = $_GET['id'];
$searchkey = htmlspecialchars($searchkeyRaw, ENT_QUOTES);

if(isset($_SESSION['email'])!=''){
$email = $_SESSION['email'];
require 'navbar.php';
$search_log = $conn->query("insert into userlogs values('$email','$searchkey','search', now())");

}
else{
  require 'dbconnect.php';
  require 'navbar2.php';
}


$res = $conn->query("select distinct projectid from project_view where (LOWER(tagname) LIKE '%{$searchkey}%'
        OR LOWER(title) LIKE '%{$searchkey}%'
        OR LOWER(shortdescription) LIKE '%{$searchkey}%'
        OR LOWER(categoryname) LIKE '%{$searchkey}%');");
$res_user = $conn->query("select distinct email from user where (firstname LIKE '%{$searchkey}%'
  OR lastname LIKE '%{$searchkey}%' 
  OR email LIKE '%{$searchkey}%')");

echo '<html>
<head>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootcards/1.0.0/css/bootcards-desktop.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />

<!-- Bootstrap and Bootcards JS -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootcards/1.0.0/js/bootcards.min.js"></script>
<style>
.text-center1 {
	text-align:center;
	font-size:20px;
	margin: 5px 0;
    font-weight: 800;
    line-height: 20px;
}
.stats-container{
	width: 100%;
}
.stats{
	display: block;
	float: left;
	width: 33.333333%;
	text-align: center;
}

.stats:first-child{
	border-right: 1px solid #EEEEEE;
}
.stats:last-child{
	border-left: 1px solid #EEEEEE;
}
.stats h4{
	font-family: "Arima Madurai", cursive;
	font-weight: 300;
	margin-bottom: 5px;
}
.stats p{
	color: #777777;
	font-weight: 800;
	font-size:40px;
}
.h3-title{
 color: #7c795d; 
 font-family: "Trocchi", serif; 
 font-size: 25px; 
 font-weight: normal; 
 line-height: 48px; 
 margin: 0;


}
h5{
	font-family: "Arima Madurai", cursive;
	font-weight: 700;
	font-size:15px;
	margin-bottom: 5px;
}
}
</style>
</head>
<body>';?>


    <?php
    if($res->num_rows!=0){
      echo '<div class="row">
<h3 style="margin-left:25px;font-family: Poiret One; font-size:30px;font-style:italic;font-weight:800;">Since you are looking for  
  <span style="color: #ff0000">';echo $searchkey; echo '</span>
  these projects may interest you...</h3>
     <div class="col-sm-12 col-sm-offset-0">';
    }
    else{
     echo '<div class="row">
<h3 style="margin-left:25px;font-family: Poiret One; font-size:30px;font-style:italic;font-weight:800;">No matching project records found..</h3></div>';
     
    }
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
							                                            <p style="font-size: 15px;">Likes</p>
							                                        </div>
							                                        <div class="stats">
							                                            <h5>'.$count_pledges.'</h5>
							                                            <p style="font-size: 15px;">Pledges</p>
							                                        </div>
							                                        <div class="stats">
							                                            <h5>'.$count_comments.'</h5>
							                                            <p style="font-size: 15px;">Comments</p>
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
      
        /*<a class="bootcards-summary-item" href="#">
          <i class="fa fa-3x fa-users"></i>
          <h4>Likes <span class="label label-info">432</span></h4>
        </a>
      </div>
      <div class="col-xs-6 col-sm-4">
        <a class="bootcards-summary-item" href="#">
          <i class="fa fa-3x fa-building-o"></i>
          <h4>Pledges <span class="label label-info">98</span></h4>
        </a>
      </div>
      <div class="col-xs-6 col-sm-4">
        <a class="bootcards-summary-item" href="#">
          <i class="fa fa-3x fa-clipboard"></i>
          <h4>Rating <span class="label label-danger">54</span></h4>
        </a>
      </div>
      <div class="col-xs-6 col-sm-4">
        <a class="bootcards-summary-item" href="#">
          <i class="fa fa-3x fa-files-o"></i>
          <h4>Files <span class="label label-info">65</span></h4>
        </a>
      </div>
      <div class="col-xs-6 col-sm-4">
        <a class="bootcards-summary-item" href="#">
          <i class="fa fa-3x fa-check-square-o"></i>
          <h4>Tasks <span class="label label-warning">109</span></h4>
        </a>
      </div> */     
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
</div>';

if($res_user->num_rows!=0){
      echo '<div class="row">
<h3 style="margin-left:25px;font-family: Poiret One; font-size:30px;font-style:italic;font-weight:800;">Looking for users with  
  <span style="color: #ff0000">'; echo $searchkey; echo '</span>
  ? Check these profiles...</h3>
     <div class="col-sm-12 col-sm-offset-0">';
    }
    else{
     echo '<div class="row">
<h3 style="margin-left:25px;font-family: Poiret One; font-size:30px;font-style:italic;font-weight:800;">No matching user records found..</h3></div>';
     
    }
while($row1 = $res_user->fetch_array()){
  
      
     $key = $row1['email'];
      $sql_user = $conn->query("select * from user where email = '$key'");
      $user_details = $sql_user->fetch_array();
      $sqlquery_projects = $conn->query("select * from project where owneremail = '$key'");
      $count_campaigns = $sqlquery_projects->num_rows;
        
            $sqlquery = $conn->query("select * from follower where useremail = '$key'");
            $count_followers = $sqlquery->num_rows;
            $sqlquery = $conn->query("select * from follower where followeremail = '$key'");
            $count_following = $sqlquery->num_rows;
            



echo'
<div class="panel panel-default bootcards-summary">
  <div class="panel-heading">
    <h3 class="h3-title"><a href="myprofiledetails.php?email='.$user_details['email'].'" style="text-decoration:none;">'.$user_details['firstname'].' '.$user_details['lastname'].'</a></h3>
  </div>
  <div class="panel-body" width>
    <div class="row">
    <div class="stats-container">
                                                      <div class="stats">
                                                          <h5>'.$count_campaigns.'</h5>
                                                          <p style="font-size: 15px;">Campaigns</p>
                                                      </div>
                                                      <div class="stats">
                                                          <h5>'.$count_following.'</h5>
                                                          <p style="font-size: 15px;">Following</p>
                                                      </div>
                                                      <div class="stats">
                                                          <h5>'.$count_followers.'</h5>
                                                          <p style="font-size: 15px;">Followers</p>
                                                      </div>
                                                      
                                                  </div>';
      //<div class="col-xs-6 col-sm-4">';
      
        /*<a class="bootcards-summary-item" href="#">
          <i class="fa fa-3x fa-users"></i>
          <h4>Likes <span class="label label-info">432</span></h4>
        </a>
      </div>
      <div class="col-xs-6 col-sm-4">
        <a class="bootcards-summary-item" href="#">
          <i class="fa fa-3x fa-building-o"></i>
          <h4>Pledges <span class="label label-info">98</span></h4>
        </a>
      </div>
      <div class="col-xs-6 col-sm-4">
        <a class="bootcards-summary-item" href="#">
          <i class="fa fa-3x fa-clipboard"></i>
          <h4>Rating <span class="label label-danger">54</span></h4>
        </a>
      </div>
      <div class="col-xs-6 col-sm-4">
        <a class="bootcards-summary-item" href="#">
          <i class="fa fa-3x fa-files-o"></i>
          <h4>Files <span class="label label-info">65</span></h4>
        </a>
      </div>
      <div class="col-xs-6 col-sm-4">
        <a class="bootcards-summary-item" href="#">
          <i class="fa fa-3x fa-check-square-o"></i>
          <h4>Tasks <span class="label label-warning">109</span></h4>
        </a>
      </div> */     
   echo' </div>
  </div>
</div>';
}
echo'
</div>
</div>';


echo'</body>
</html>';
?>