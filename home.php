<?php
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);
error_reporting(0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />
<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css" rel="stylesheet" integrity="sha384-+ENW/yibaokMnme+vBLnHMphUYxHs34h9lpdbSLuAwGkOKFRl4C34WkjazBtb7eT" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


<style>
.panel-body  {
    word-break:break-all
}

.col-lg-9{
  margin-top: 100px;
}
.col-lg-3{
margin-top: 150px;
    text-align: center;
    font-family: Verdana, Geneva, sans-serif;
    font-size: 20px;
}</style>
</head>
<body>

<?php
session_start();
require 'navbar.php';
require 'dbconnect.php';
$user_name = $_SESSION['email'];

$pledgedprojects = $conn->query("select distinct activity from userlogs where email = '$user_name' and activitytype='projectpledge' order by logtime desc limit 3;"); 
$viewedprojects = $conn->query("select distinct activity from userlogs where email = '$user_name' and activitytype='projectview' order by logtime desc limit 3;"); 
$visitedprofiles = $conn->query("select distinct activity from userlogs where email = '$user_name' and activity <> '' and activitytype='profilevisit' order by logtime desc limit 3;");
$recentsearch = $conn->query("select distinct activity from userlogs where email = '$user_name' and activitytype='search' order by logtime desc limit 3;");
$recentcomments = $conn->query("select f.useremail, c.projectid, p.title, u.firstname,
    DATE(c.postdate),
    c.postdate AS d
FROM
    follower f,
    projectcomments c, user u, project p
WHERE
(f.followeremail = '$user_name'
AND 
u.email = f.useremail
AND p.projectid = c.projectid    
AND f.useremail = c.email)
ORDER BY d DESC;        
");
$recentlikes = $conn->query("select 
    f.useremail,
    l.projectid,
    p.title,
    u.firstname,
    DATE(l.liketime),
    l.liketime AS d
FROM
    follower f,
    projectlikes l,
    user u,
    project p
WHERE
    f.followeremail = '$user_name'
        AND u.email = f.useremail
        AND p.projectid = l.projectid
        AND f.useremail = l.email
ORDER BY d DESC;");
$recentupdates = $conn->query("select u.projectid, u.longdescription, u.updatedate as d, p.owneremail, p.title, date(u.updatedate), p.title,
    us.firstname
                        from follower f,projectupdates u, project p, user us
                        where f.followeremail ='$user_name' and u.projectid = p.projectid and p.owneremail = f.useremail and us.email = p.owneremail;");
?>



<div class="container">
	<!-- <a href="http://www.google.com/">Kickstarter</a><br /><br />
    <p>Welcome <?php echo $userRow['firstname']; ?> </p>
    <a href="newsfeed.php">News Feed</a><br /><br />
 -->
<div class="col-lg-3">
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Recent Supported Projects</h3>
  </div>
  <div class="panel-body">
  
    <?php
    while($row = $pledgedprojects->fetch_array())
    {
      $title=$conn->query("select title from project where projectid = $row[0]");
      $titlerow = $title->fetch_array(); 
         echo '<p class>
                  <a href="projectdetail.php?'.$row[0].'">
                '.$titlerow[0].'</a>
                </p>
                ';
    }
    ?>
  
  </div>
</div>

<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Recent Project Visits</h3>
  </div>
    <div class="panel-body">
       <?php
    while($row1 = $viewedprojects->fetch_array())
    {
      $title1=$conn->query("select title from project where projectid = $row1[0]");
      $titlerow1 = $title1->fetch_array();
         echo '<p class>
                  <a href="projectdetail.php?'.$row1[0].'">
                '.$titlerow1[0].'</a>
                </p>
                ';
    }
    ?>
    </div>
  </div>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Recent Profile Visits</h3>
  </div>
  <div class="panel-body">
    <?php
    while($row2 = $visitedprofiles->fetch_array())
    {
      $userdetails = $conn->query("select firstname, lastname, email from user where email = '$row2[0]'");
      $user = $userdetails->fetch_array();
         echo '<p class>
                  <a href="myprofiledetails.php?email='.$user[2].'">
                '.$user[0].' '.$user[1].'</a>
                </p>
                ';
    }
    ?>
  </div>
</div>

<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Recent Searches</h3>
  </div>
  <div class="panel-body">
    <?php
    while($row3 =$recentsearch->fetch_array())
    {
         echo '<p class>
                  <a href="search_results.php?id='.$row3[0].'">
                '.$row3[0].'</a>
                </p>
                ';
    }
    ?>
  </div>
</div>
</div>


<div class="container">
<div class="row">

<div class="col-lg-9">
<h3>Notifications</h3>
<hr>
<?php

while($row = $recentcomments->fetch_array()){

echo '<div class="row">
            <div class="col-md-12"> 
                <span class="pull-right text-muted small time-line">
                    '.$row[4].'  <span class="glyphicon glyphicon-time" data-toggle="tooltip" data-placement="bottom"></span>
                </span> 
                
                <i class="glyphicon glyphicon-comment"></i>&nbsp <a href="myprofiledetails.php?email='.$row[0].'" style="text-decoration:none;">'.$row[3].'</a> commented on <a href="projectdetail.php?'.$row[1].'" style="text-decoration:none;">'.$row[2].'</a>
            </div>
          </div>
          <hr>';  
}

while($row = $recentlikes->fetch_array()){

echo '<div class="row">
            <div class="col-md-12"> 
                <span class="pull-right text-muted small time-line">
                    '.$row[4].'  <span class="glyphicon glyphicon-time" data-toggle="tooltip" data-placement="bottom"></span>
                </span> 
                
                <i class="glyphicon glyphicon-heart"></i>&nbsp <a href="myprofiledetails.php?email='.$row[0].'" style="text-decoration:none;">'.$row[3].'</a> liked <a href="projectdetail.php?'.$row[1].'" style="text-decoration:none;">'.$row[2].'</a>
            </div>
          </div>
          <hr>';  
}

while($row = $recentupdates->fetch_array()){
echo '<div class="row">
            <div class="col-md-12"> 
            <i class="glyphicon glyphicon-bullhorn"></i>&nbsp Update on <a href="projectdetail.php?'.$row[0].'" style="text-decoration:none;">'.$row[6].'</a> by <a href="myprofiledetails.php?email='.$row[3].'" style="text-decoration:none;">'.$row[7].'</a>
                <span class="pull-right text-muted small time-line">
                    '.$row[5].'  <span class="glyphicon glyphicon-time" data-toggle="tooltip" data-placement="bottom"></span>
                </span> 
                 <h4><strong>'.$row[1].'</strong></h4>
                

            </div>
          </div>
          <hr>';
}
?>
</div>
</div>
</body>
</html>