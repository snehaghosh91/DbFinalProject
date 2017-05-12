<html>
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Kickstarter</title>

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css" rel="stylesheet" integrity="sha384-+ENW/yibaokMnme+vBLnHMphUYxHs34h9lpdbSLuAwGkOKFRl4C34WkjazBtb7eT" crossorigin="anonymous">
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
     <link href="http://netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css?family=Arima+Madurai:100,200,300,400,500,700,800,900" rel="stylesheet">
    <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>

    <link href="css/users_style.css" rel="stylesheet" type="text/css">
    <style>
    .card .header {
    padding: 15px 20px;
    height: 110px;
    }
    .card .motto{
    font-family: 'Arima Madurai', cursive;
    border-bottom: 1px solid #EEEEEE;
    color: #999999;
    font-size: 14px;
    font-weight: 400;
    padding-bottom: 5px;
    text-align: center;
    }
    </style>
</head>
<body>
<?php
session_start();										
require 'dbconnect.php';	
//require 'navbar.php';								
$user_name = $_SESSION['email'];
$user = $_GET['id'];
$query = $conn->query("select * from follower where useremail = '$user'");
$count_follow = $query->num_rows;
$sqlquery = $conn->query("select * from user where email = '$user'");
$row_user_details = mysqli_fetch_array($sqlquery);
?>
<div class="container">
  <h1><?php echo $row_user_details['firstname']." "; echo $row_user_details['lastname']; ?>'s followers -</h1>
  <hr>
  <!-- #####################################################################################################################  -->
  
    <div class="row">
     <div class="col-sm-12 col-sm-offset-0">
         
         <?php 
         if($count_follow == 0)
         {
          echo '<h4 class="text-muted" style="text-align: center; font-size: 30px;">This user is not followed by anyone!</h4>';
         }
         while($row_followers = mysqli_fetch_array($query))
         {
            $follower = $row_followers['followeremail'];
            
            $sqlquery1 = $conn->query("select * from user where email = '$follower'");
            $row_user = mysqli_fetch_array($sqlquery1);
            $sqlquery_projects = $conn->query("select * from project where owneremail = '$follower'");
            $count_campaigns = $sqlquery_projects->num_rows;
            
            $sqlquery = $conn->query("select * from follower where useremail = '$follower'");
            $count_followers = $sqlquery->num_rows;
            $sqlquery = $conn->query("select * from follower where followeremail = '$follower'");
            $count_following = $sqlquery->num_rows;
            echo '<div class="col-sm-12 col-sm-offset-0" style="height:230px; margin:40px;">
               <div class="card-container">
                  <div class="card">
                      <div class="front">
                          <div class="content">
                              <div class="main">
                                  <h3 class="name"><a href="myprofiledetails.php?email='.$row_user['email'].'" style="text-decoration:none;">'.$row_user['firstname'].' '.$row_user['lastname'].'</a></h3>
                                  <p class="profession">'.$row_user['email'].'</p>

                                  <div class="stats-container">
                                      <div class="stats">
                                        <h4>'.$count_followers.'</h4>
                                        <p style="font-size: 12px;">Follower(s)</p>
                                      </div>
                                      <div class="stats">
                                        <h4>'.$count_campaigns.'</h4>
                                        <p style="font-size: 12px;">Campaign(s)</p>
                                      </div>
                                      <div class="stats">
                                        <h4>'.$count_following.'</h4>
                                        <p style="font-size: 12px;">Following</p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div> <!-- end front panel -->
                  </div> <!-- end card -->
              </div> <!-- end card-container -->
          </div> <!-- end col sm 3 -->
          <!--<div class="col-sm-1"></div> -->';
        }
            ?>
        
    </div> <!-- end row -->
    <div></div>
</div>
</div>
</body>
</html>