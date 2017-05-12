<html>
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>LaunchPad</title>

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css" rel="stylesheet" integrity="sha384-+ENW/yibaokMnme+vBLnHMphUYxHs34h9lpdbSLuAwGkOKFRl4C34WkjazBtb7eT" crossorigin="anonymous">
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

     <style>
     .panel-body  {
    word-break:break-all
}
</style>
</head>

<body>
<?php
session_start();										
require 'dbconnect.php';	
//require 'navbar.php';								
$user_name = $_SESSION['email'];
$sqlquery=$conn->query("select NULL, f.uname2, c.pname, date(c.commtime),c.commtime as d,NULL,NULL,NULL
                        from follows f,comments c
                        where f.uname1 ='$user_name' and f.uname2 = c.uname  
                        union
                        (select f.uname2,NULL, l.project_name, date(l.datetime),l.datetime as d,NULL,NULL,NULL
                        from follows f,likes l
                        where f.uname1 ='$user_name' and f.uname2 = l.user_name)
                        union
                        (select u.upname, u.updesc,NULL, u.media,u.timestamp as d, p.uname, p.pname, date(u.timestamp)
                        from follows f,updates u, projects p
                        where f.uname1 ='$user_name' and u.pname = p.pname and p.uname = f.uname2)
                        union
                        (select u.upname, u.updesc,NULL, u.media,u.timestamp as d, p.uname, p.pname, date(u.timestamp)
                        from likes l, updates u, projects p
                        where l.user_name ='$user_name' and l.project_name=p.pname and p.pname = u.pname)
                        union
                        (select p.pname, p.pdesc, p.uname,NULL, p.datetime as d, p.cover_page, date(p.datetime),NULL
                        from follows f,projects p
                        where f.uname1 ='$user_name' and f.uname2 = p.uname ) order by d desc");  
$pledgedprojects = $conn->query("select distinct activity from userlogs where email = '$user_name' and activitytype='projectpledge' order by logtime desc limit 3;"); 
$viewedprojects = $conn->query("select distinct activity from userlogs where email = '$user_name' and activitytype='projectview' order by logtime desc limit 3;"); 
$visitedprofiles = $conn->query("select distinct activity from userlogs where email = '$user_name' and activitytype='profilevisit' order by logtime desc limit 3;"); 
?>
<div class="container">
<div class="row">

<div class="col-lg-9">


</div>
<div class="col-lg-3">
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Your recent pledges</h3>
  </div>
  <div class="panel-body">
  
    <?php
    while($row = mysqli_fetch_array($pledgedprojects))
    {
         echo '<p class>
                  <a href="projectdetails.php?id='.$row[0].'">
                '.$row[0].'</a>
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
    while($row1 = mysqli_fetch_array($viewedprojects))
    {
         echo '<p class>
                  <a href="projectdetails.php?id='.$row1[0].'">
                '.$row1[0].'</a>
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
    while($row2 = mysqli_fetch_array($visitedprofiles))
    {
         echo '<p class>
                  <a href="myprofiledetails.php?email='.$row2[0].'">
                '.$row2[0].'</a>
                </p>
                ';
    }
    ?>
  </div>
</div>
</div>
</div>
</div>

</body>
</html>