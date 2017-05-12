<?php
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);
error_reporting(0);
?>

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
     <html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />
</head>

</head>
<body>

<?php
session_start();										
require 'dbconnect.php';	
//require 'navbar.php';		
$user_name = $_SESSION['email'];
$sqlquery = $conn->query("select * from user where email='$user_name'");   
$row = $sqlquery->fetch_array();

$sqlqueryccn = $conn->query("select ccn from creditcardowner where email='$user_name'");
$rowccn = $sqlqueryccn->fetch_all();
$countccn = count($rowccn);
$userccn='';
if($countccn!=0){
$userccn = implode(',', array_column($rowccn, 0));
}

$sqlqueryinterests = $conn->query("select interest from userinterests where email='$user_name'");
$rowinterests = $sqlqueryinterests->fetch_all();
$countinterests = count($rowinterests);
$userinterests='';
if($countinterests!=0){
$userinterests = implode(',', array_column($rowinterests, 0));
}
if(isset($_POST['btn_save']))
{
	
  $firstname = strip_tags($_POST['firstname']);
  $lastname = strip_tags($_POST['lastname']);
  //$email = strip_tags($_POST['email']);
  $upass = strip_tags($_POST['password']);
  $phonenumber = strip_tags($_POST['phonenumber']);
  $hometown = strip_tags($_POST['hometown']);
  $ccn = strip_tags($_POST['ccn']);
  $interests = strip_tags($_POST['interests']);
  
  $firstname = $conn->real_escape_string($firstname);
  $lastname = $conn->real_escape_string($lastname); 
 // $email = $conn->real_escape_string($email);
  $upass = $conn->real_escape_string($upass);
  $phonenumber = $conn->real_escape_string($phonenumber);
  $hometown = $conn->real_escape_string($hometown);
  $ccn = $conn->real_escape_string($ccn);
  $interests = $conn->real_escape_string($interests);
  
  //$hashed_password = password_hash($upass, PASSWORD_DEFAULT); // this function works only in PHP 5.5 or latest version
  
  if(password_verify($upass, $row['password']))
	{
		/*if(getimagesize($_FILES['propic']['tmp_name']) != FALSE)
		{	
			$imageFile = $_FILES['propic']['name'];
			$imgExt = strtolower(pathinfo($imageFile,PATHINFO_EXTENSION));
			$image = addslashes($_FILES['propic']['tmp_name']);
			$image = file_get_contents($image);
			$image = base64_encode($image);
			
			$qry = "Update user set firstname = '$firstname', lastname = '$lastname', email = '$email', profile_pic = '$image' 
					where email = '$email'";
			$result = $conn->query($qry);
		}
		else
		{*/
			$qry = "Update user set firstname = '$firstname', lastname = '$lastname', hometown = '$hometown', phonenumber='$phonenumber' where email = '$user_name'";
			$result = $conn->query($qry);	

      if($conn->query($qry) && isset($_POST['interests']) && isset($_POST['ccn'])){
    $interests_split= explode(",", $interests);
    $cnt=count($interests_split);
    $queryDeleteInterests="delete from userinterests where email = '$user_name'";
    $conn->query($queryDeleteInterests);    
    for($i=0;$i<$cnt;$i++){
    $queryInterests="insert into userinterests (email,interest) values ('$user_name', '$interests_split[$i]')";
    $conn->query($queryInterests);
    }
    $ccn_split= explode(",", $ccn);
    $cntccn=count($ccn_split);
    $queryDeleteCCN="delete from creditcardowner where email = '$user_name'";
    $conn->query($queryDeleteCCN);  
    
    for($i=0;$i<$cntccn;$i++){
    $queryCCN = "INSERT INTO creditcardowner(email,ccn) VALUES ('$user_name', '$ccn_split[$i]')";
    $conn->query($queryCCN);
    }
    
		//}
			echo '<script>
			window.location = "myprofiledetails.php?email='.$user_name.'";
		</script>';
}
}
	else
	{
		echo '
        		<div class="alert alert-info alert-dismissable">
          		<a class="panel-close close" data-dismiss="alert">×</a> 
          		Not you? The password is not correct.
        		</div>
        	';
	}
}
?>

<div class="container">
    <h1>Edit Profile</h1>
  	<hr>
  		<form method="post" enctype="multipart/form-data" class="form-horizontal">
		<div class="row">
      		<!--div class="col-md-3">
      			<div class="text-center">

	      		<?php 
	      		/*if(!empty($row[5]))
	  			{
	  				echo '<img class="avatar img-circle" alt="avatar" src="data:image;base64,'.$row[5].'" 
	  				style="width: 180px; height: 150px; border-radius: 50%; border: 2px solid #00bfff;">';
	  			}
	  			else
	  			{
	  				echo '<img class="avatar img-circle" alt="avatar" src="default-user-image.png"  
	  				style="max-width: 180px; max-height: 150px; border-radius: 50%; border: 2px solid #00bfff;">';		
	  			}*/
          
          		?>
          
          	<br><br>
          	<h6>Upload a different photo</h6>
          
          		<input class="form-control" type="file" name="propic" accept="image/*" />
        		</div>
      		</div>-->
      
      		<!-- edit form column -->
      		<div class="col-md-9 personal-info">
        
        	<h3>Personal info</h3>
        	<br>
          	<div class="form-group">
            <label class="col-lg-3 control-label">First name:</label>
            	<div class="col-lg-8">
              	<input class="form-control" type="text" value="<?php echo $row['firstname']; ?>" required="" name="firstname">
            	</div>
          	</div>
          
          	<div class="form-group">
            <label class="col-lg-3 control-label">Last name:</label>
            	<div class="col-lg-8">
              	<input class="form-control" type="text" value="<?php echo $row['lastname']; ?>" required="" name="lastname">
            	</div>
         	 </div>
          
          	<div class="form-group">
            <label class="col-lg-3 control-label">Email:</label>
            	<div class="col-lg-8">
              	<input class="form-control" type="text" value="<?php echo $row['email']; ?>" DISABLED  name="email">
            	</div>
          	</div>
          
          	<div class="form-group">
            <label class="col-md-3 control-label">Password:</label>
            	<div class="col-md-8">
              	<input class="form-control" type="password" placeholder="Please re-enter your password" required="" name="password">
            	</div>
          	</div>

            <div class="form-group">
            <label class="col-lg-3 control-label">Hometown:</label>
              <div class="col-lg-8">
                <input class="form-control" type="text" value="<?php echo $row['hometown']; ?>" required="" name="hometown">
              </div>
            </div>

            <div class="form-group">
            <label class="col-lg-3 control-label">Phone Number:</label>
              <div class="col-lg-8">
                <input class="form-control" type="text" value="<?php echo $row['phonenumber']; ?>" required="" name="phonenumber">
              </div>
            </div>

            <div class="form-group">
            <label class="col-lg-3 control-label">Credit Card Number</label>
              <div class="col-lg-8">
                <input class="form-control" type="text"  value="<?php echo $userccn; ?>" required="" name="ccn">
              </div>
           </div>

            <div class="form-group">
            <label class="col-lg-3 control-label">Interests</label>
              <div class="col-lg-8">
                <input class="form-control" type="text" value="<?php echo $userinterests; ?>"  name="interests">
              </div>
           </div>

          	<div class="form-group">
            <label class="col-md-3 control-label"></label>
            	<div class="col-md-8">
              	<button type="Submit" class="btn btn-info" style="margin-right: 15px;" name="btn_save">Save Changes</button>
              	<span></span>
              	<?php echo'<a href="myprofiledetails.php?email='.$user_name.'">';?><button type="button" class="btn btn-default">Cancel</button></a>
            	</div>
          	</div>
      	
      </div>
  </div>
  </form>
</div>

</body>
</html>