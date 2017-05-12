<?php
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);
error_reporting(0);
require 'navbar.php';
?>
<html>
<head>
	<title>Kickstarter</title>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css" rel="stylesheet" integrity="sha384-+ENW/yibaokMnme+vBLnHMphUYxHs34h9lpdbSLuAwGkOKFRl4C34WkjazBtb7eT" crossorigin="anonymous">
    <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arima+Madurai:100,200,300,400,500,700,800,900" rel="stylesheet">
    <link href="css/users_style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootcards/1.0.0/css/bootcards-desktop.min.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
	<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
	<link rel="stylesheet" href="style.css" type="text/css" />
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/bootcards/1.0.0/js/bootcards.min.js"></script>
	
</head>
<body>
<?php 
//session_start();

require 'dbconnect.php';

								
$email = $_SESSION['email'];
$current_user_query = $conn->query("select * from user where email = '$email'");
$curr_user_row = $current_user_query->fetch_array();
$user = $_GET['email'];
$sqlquery = $conn->query("select * from user where email='$user'");   
$row = $sqlquery->fetch_array();
$sqlquery_projects = $conn->query("select p.projectid,p.title, p.status, 
                                case when DATEDIFF(date(enddate), date(now())) < 1 then 0 
                                    else DATEDIFF(date(enddate), date(now())) END as daysleft 
                                from project as p 	
                            	where owneremail = '$user' order by daysleft desc");
$no_of_campaigns = $sqlquery_projects->num_rows;
$projrow = $sqlquery_projects->fetch_array();

//->num_rows;
$sqlquery1 = $conn->query("select * from follower where useremail = '$user'");
$no_of_followers = $sqlquery1->num_rows;
$sqlquery2 = $conn->query("select * from follower where followeremail = '$user'");
$no_of_following = $sqlquery2->num_rows;
$sqlquery3 = $conn->query("select * from pledge where email = '$user'");
$no_of_pledges = $sqlquery3->num_rows;
$sqlquery_fol = $conn->query("select * from follower where followeremail = '$email' and useremail = '$user'");
$follows_flag = $sqlquery_fol->num_rows;
$sqlquery_follow = $conn->query("select * from follower where followeremail = '$user' and useremail = '$email'");
$following_flag = $sqlquery_follow->num_rows;
//echo $following_flag;
if($follows_flag == 1)
{
	$a = 'Following';
    $c = 'glyphicon glyphicon-check';
}
else
{
	$a = ' Follow';
    $c = 'glyphicon glyphicon-unchecked';
}


$sqlqueryinterests = $conn->query("select interest from userinterests where email='$user'");
$rowinterests = $sqlqueryinterests->fetch_all();
$countinterests = count($rowinterests);
$userinterests='';
if($countinterests!=0){
$userinterests = implode(', ', array_column($rowinterests, 0));
}

?>

<br>
	<div class="container target">
    	<div class="row">
        	<div class="col-sm-10">

      			

      		
             	<h1 style="font-family: Poiret One; font-size: 60px;"><?php echo $row['firstname']." "; echo $row['lastname']; ?></h1>
             	<h4 class="text-muted" style="font-family: Poiret One; font-size: 30px;"><?php echo $row['email']; ?></h4>
             	<h6 style="font-family: Poiret One; font-size: 25px;"><?php echo"Interests: "; echo $userinterests; ?></h6>
             	<h6 style="font-family: Poiret One; font-size: 25px;"><?php echo"Hometown: "; echo $row['hometown']; ?></h6>
             	<h6 style="font-family: Poiret One; font-size: 25px;"><?php echo"Contact: "; echo $row['phonenumber']; ?></h6>     	
             	
             	<br>
             	
     			<?php
     			if($user == $email)
     			{
     				echo '<a href="edit_profile.php"><button type="button" class="btn btn-success" style="margin-right: 5px;">Edit Profile</button></a>'; 
     			
     			}	  
    			else
    			{
    				echo '<button class="btn btn-info" name = "follows" onclick="follows()">
                	<span class="'.$c.'" id ="sp1"></span> '.$a.'</button>';
                	$sqlquery_log = $conn->query("insert into userlogs values('$email','$user','profilevisit', now())");
    			}
    			?>
    			<br>
    			<br>
        	</div>
      		
      		
    	</div>
	  	
	    <div class="row">
	        <div class="col-sm-3">
	            <ul class="list-group">
	                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Campaigns</strong></span>
	                <?php echo $no_of_campaigns; ?></li>
	                <li class="list-group-item text-right"><span class="pull-left"><strong><a href="user_followers.php?id=<?php echo $user; ?>" style="text-decoration:none;">Followers</a></strong></span><?php echo $no_of_followers; ?></li>
	                <li class="list-group-item text-right"><span class="pull-left"><strong><a href="user_following.php?id=<?php echo $user; ?>" style="text-decoration:none;">Following</a></strong></span><?php echo $no_of_following; ?></li>
	                <li class="list-group-item text-right"><span class="pull-left"><strong>Pledges</strong></span><?php echo $no_of_pledges; ?></li>
	            </ul>
	        </div>
	        
	        <div class="col-sm-9" contenteditable="false" style="">
	            <div class="panel panel-default target">
	                <div class="panel-heading" contenteditable="false">All Campaigns</div>
	                	<div class="panel-body">
	                  		<div class="row">
							     <div class="col-sm-12 col-sm-offset-0">
							         
							         <?php  
							         
							         if($no_of_campaigns == 0)
							         {
							         	echo '<h4 class="text-muted" style="text-align: center; font-size: 30px;">There are no campaigns to display!
							         			</h4>';
							         }
							         while($row_proj = mysqli_fetch_array($sqlquery_projects))
							         {
							         	
							            $project = $row_proj['projectid'];
							            $sqlquery2 = $conn->query("select * from projectlikes where projectid = '$project'");
							            $count_likes = $sqlquery2->num_rows;
							            
							            $sqlquery_pledges = $conn->query("select * from pledge where projectid = '$project'");
							            $no_of_pledges = $sqlquery_pledges->num_rows;
							            $sqlquery1 = $conn->query("select * from projectcomments where projectid = '$project'");
							            $count_comments = $sqlquery1->num_rows;            
							            $sqlquery1 = $conn->query("select sum(pledgeamount) as tot_funds from pledge where projectid = '$project'");
							            $sumfunds = mysqli_fetch_assoc($sqlquery1);
							            $sqlquery1 = $conn->query("select minfund, maxfund from project where projectid = '$project'");
							            $project_details = mysqli_fetch_assoc($sqlquery1);
							            if(is_null($sumfunds['tot_funds']))
							            {
							                $sumfunds['tot_funds'] = '0';
							            }
							            $remaining_funds = $project_details['maxfund']-$sumfunds['tot_funds'];
							            
							            $fundedpercent = intval(($sumfunds['tot_funds']/$project_details['maxfund'])*100);
							          
							            
							            echo '<div class="col-sm-12 col-sm-offset-0">
							                 <div class="card-container">
							                    <div class="card">
							                        <div class="front">';
							                            echo '<div class="content">
							                                <div class="main">
							                                    <a href="projectdetail.php?'.$row_proj['projectid'].'"><h6 class="name">'.$row_proj['title'].'</h6></a>';
							                                    if($row_proj['status']=='completed'){
							                                    	echo '<h5 class="text-center" style="margin-top: 15px;">Status:  <span class="label label-success"><b>'.$row_proj['status'].'</b></span></h5>';
							                                    }
							                                    else{
							                                    	echo '<h5 class="text-center" style="margin-top: 15px;">Status:  <span class="label label-warning"><b>'.$row_proj['status'].'</b></span></h5>';
							                                    }

							                                    
							                                   
							                                    if($row_proj['status'] == 'open')
							                                    {
							                                        echo '<h5 class="text-center" style="margin-top: 15px;"><b><h4>'.$row_proj['daysleft'].' </h4>days to go!</b></h5>';
							                                    }
							                                    else {
							                                    	echo '<br><br><br>';
							                                    }
//Testing

echo '<div class="stats-container">
							                                        <div class="stats">
							                                            <h5>'.$count_likes.'</h5>
							                                            <p style="font-size: 15px;">Likes</p>
							                                        </div>
							                                        <div class="stats">
							                                            <h5>'.$no_of_pledges.'</h5>
							                                            <p style="font-size: 15px;">Pledges</p>
							                                        </div>
							                                        <div class="stats">
							                                            <h5>'.$count_comments.'</h5>
							                                            <p style="font-size: 15px;">Comment</p>
							                                        </div>
							                                    </div>
							                                    <hr width="85%">
							                                    <div class="stats-container">
							                                        <div class="stats">
							                                            <h5>'.$sumfunds['tot_funds'].'</h5>
							                                            <p style="font-size: 15px;">Funds Collected ('.$fundedpercent.'%)</p>
							                                        </div>
							                                        <div class="stats">
							                                            <h5>$'.$project_details['minfund'].'</h5>
							                                            <p style="font-size: 15px;">Minimum Goal</p>
							                                        </div>
							                                        <div class="stats">
							                                            <h5>$'.$remaining_funds.'</h5>
							                                            <p style="font-size: 15px;">Maximum amount that you can pledge</p>
							                                        </div>
							                                    </div>
							                                    <hr width="85%">
							                                    
							                                    ';

//Testing ends

							                                
							                                echo '</div>
							                             
							                            </div>
							                        </div> <!-- end front panel -->';
							                      
echo '</div>
							                </div> 
							            </div>';
							        }
									?>							    
									</div> 
							    </div> 
							    <div class="space-200"></div>
	            		</div>
	                </div>
	    		</div>
	    	</div>
		</div>
	</div>';
?>

<script>
 	function follows()
    {
    	var uname = '<?php echo $email; ?>';
        var other_uname = '<?php echo $user; ?>';
        
        $.ajax({ url: 'add_follower.php',
        data: {uname: uname, other_uname: other_uname},
        type: 'post',
        success: function(out) {
                  window.location = "myprofiledetails.php?email="+other_uname;/*"add_follower.php";//*/
              }
		});
    }
</script>
</body>
<html>