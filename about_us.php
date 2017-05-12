<?php

session_start();
  $user_name = $_SESSION['email'];
  if(is_null($user_name)){
    require 'navbar2.php';
  } else{
    require 'navbar.php';
  }

	 

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
*/?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
</body>
</html>
<?php 

//echo '<h1 style="text-align:center;">Hello</h1>';
echo '<html>
<head>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootcards/1.0.0/css/bootcards-desktop.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Gruppo"/>
<link rel="stylesheet" href="style.css" type="text/css" />
<style>
h1 {
	font-family: Gruppo;
	font-size: 40px;
	font-style: normal;
	font-variant: normal;
	font-weight: bold;
	line-height: 56px;
}

h3 {
	font-family: Gruppo;
	font-size: 30px;
	font-style: italic;
	font-variant: normal;
	font-weight: normal;
	line-height: 56px;
	col
}

h4 {
	font-family: Gruppo;
	font-size: 30px;
	font-style: normal;
	font-variant: normal;
	font-weight: normal;
	line-height: 40px;
	col
}
body{
	
}
</style>
</head>
<body>


<div class="row">
<h1 style="text-align:center;">Welcome to Kickstarter!</h1>
<hr>
<h3 style="margin-left:75px;margin-right:75px;text-align:center;font-family: Poiret One; font-size:30px;font-weight:400;">
Kickstarter helps artists, musicians, filmmakers, designers, and other creators find the resources and support they need to make their ideas a reality. To date, tens of thousands of creative projects — big and small — have come to life with the support of the Kickstarter community.</h3></div>
<hr>
<blockquote><h4 style="margin-left:75px;margin-right:75px;text-align:center;font-family: Poiret One; font-size:25px;font-weight:400;"">Every Kickstarter project is an opportunity to create the universe and culture you want to see. The games you wish you could play, the films you wish you could watch, the technology you wish someone was building — on Kickstarter, people work together to make those things a reality.

Take a look around: right this minute, thousands of people are funding their creative ideas. Feel like joining them?

</h4></blockquote>';



?>
