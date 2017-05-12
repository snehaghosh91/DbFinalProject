<?php

    

require 'dbconnect.php';

/*if (!isset($_SESSION['email'])) {
	header("Location: login.php");
}*/

if(isset($_POST['submit_button']))
{
    $searchkey = $_POST['searchkey'];
    $redirectTo ='search_results.php?id='.$searchkey.'';
    
    echo "<script type='text/javascript'>document.location.href='{$redirectTo}';</script>";
}

//$email = $_SESSION['email'];

/*$sql="SELECT * FROM user WHERE email='$email'";
$result = mysqli_query($conn,$sql);
$userRow = mysqli_fetch_array($result, MYSQLI_BOTH);
*/echo '

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="about_us.php">Kickstarter</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="login.php">Create a project</a></li>
            <li><a href="login.php">Recommendations</a></li>
            <li><a href="explore.php">Explore</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span>&nbsp; Login</a></li>
          </ul>
           <form method="post" class="navbar-form navbar-right" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" name="searchkey" placeholder="Search this site">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default" name="submit_button">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </form>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
</body>
</html>';
?>


