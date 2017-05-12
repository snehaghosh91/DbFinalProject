<?php
session_start();
if (isset($_SESSION['email'])!="") {
	header("Location: home.php");
}
require_once 'dbconnect.php';
require 'phpmailer/PHPMailerAutoload.php';


if(isset($_POST['btn-signup'])) {
	
	$firstname = strip_tags($_POST['firstname']);
	$lastname = strip_tags($_POST['lastname']);
	$email = strip_tags($_POST['email']);
	$upass = strip_tags($_POST['password']);
	$phonenumber = strip_tags($_POST['phonenumber']);
	$hometown = strip_tags($_POST['hometown']);
	$ccn = strip_tags($_POST['ccn']);
	$interests = strip_tags($_POST['interests']);
	
	$firstname = $conn->real_escape_string($firstname);
	$lastname = $conn->real_escape_string($lastname);	
	$email = $conn->real_escape_string($email);
	$upass = $conn->real_escape_string($upass);
	$phonenumber = $conn->real_escape_string($phonenumber);
	$hometown = $conn->real_escape_string($hometown);
	$ccn = $conn->real_escape_string($ccn);
	$interests = $conn->real_escape_string($interests);
	
	$hashed_password = password_hash($upass, PASSWORD_DEFAULT); // this function works only in PHP 5.5 or latest version
	
	$check_email = $conn->query("SELECT email FROM user WHERE email='$email'");
	$count=$check_email->num_rows;
	
	if ($count==0) {
		
		$query = "INSERT INTO user(firstname,lastname,email,password, phonenumber,hometown) VALUES('$firstname','$lastname','$email','$hashed_password','$phonenumber','$hometown')";
		
		if($conn->query($query) && isset($_POST['interests']) && isset($_POST['ccn'])) {
			$interests_split= explode(",", $interests);
			$cnt=count($interests_split);
			for($i=0;$i<$cnt;$i++){
				$queryInterests="insert into userinterests (email,interest) values ('$email', '$interests_split[$i]')";
				$conn->query($queryInterests);
			}
			$ccn_split= explode(",", $ccn);
			$cntccn=count($ccn_split);
			for($i=0;$i<$cntccn;$i++){
				$queryCCN = "INSERT INTO creditcardowner(email,ccn) VALUES ('$email', '$ccn_split[$i]')";
				//$conn->query($queryCCN);
			}
		//$queryCCN = "INSERT INTO creditcardowner(email,ccn) VALUES('$email','$ccn')";
			if($conn->query($queryCCN)){
				/*$msg = "<div class='alert alert-success'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; successfully registered !
					</div>";*/

				$mail = new PHPMailer;
				//$recipient = $_GET['id'];

				//$mail->SMTPDebug = 3;                               // Enable verbose debug output

				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'riyapatni2407@gmail.com';        
				// SMTP username
				$mail->Password = '';                           
				// SMTP password - Removed from code for submission purpose.
				$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 587;                                    // TCP port to connect to
				$mail->setFrom('riyapatni2407@gmail.com', 'Kickstarter Team');
				$mail->addAddress($email);     // Add a recipient
				//$mail->addAddress('rsp378@nyu.edu');               // Name is optional
				//$mail->addReplyTo('riyapatni2407@gmail.com', 'Mailer');
				//$mail->addCC('riyapatni2407@gmail.com');
				//$mail->addBCC('riyapatni2407@gmail.com');

				$mail->isHTML(true);                                  // Set email format to HTML

				$mail->Subject = 'Welcome to Kickstarter';
				$mail->Body    = 'Hi '.$firstname.', Thank you for joining Kickstarter! Your username is '.$email;
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				if(!$mail->send()) {
				    echo 'Message could not be sent.';
				    echo 'Mailer Error: ' . $mail->ErrorInfo;
				} else {
				    echo 'Congratulations. You have been successfully registered. Click here to login'; echo '<a href="login.php">Login</a>';
				}


			}
}else {
			$msg = "<div class='alert alert-danger'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; error while registering !
					</div>";
		}
		
	} else {
		
		
		$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; sorry email already taken !
				</div>";
			
	}
	
	$conn->close();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login & Registration System</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div class="signin-form">

	<div class="container">
     
        
       <form class="form-signin" method="post" name="register-form" id="register-form">
        <h2 class="form-signin-heading">Sign Up</h2><hr />
        
        <?php
		/*if (isset($msg)) {
			echo $msg;
		}*/
		?>
          
        <div class="form-group">
        <input type="text" class="form-control" placeholder="First Name" name="firstname" required/>
        </div>

		<div class="form-group">
        <input type="text" class="form-control" placeholder="Last Name" name="lastname" required/>
        </div>
		
		
        <div class="form-group">
        <input type="email" class="form-control" placeholder="Email address" name="email" required/>
        <span id="check-e"></span>
        </div>
        
        <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" name="password" required/>
        </div>
        
		<div class="form-group">
        <input type="number" size="10" class="form-control" placeholder="Phone Number" name="phonenumber"/>
        </div>
		
		<div class="form-group">
        <input type="text" class="form-control" placeholder="Hometown" name="hometown"/>
        </div>
        
		<div class="form-group">
        <input type="number" size = "16" class="form-control" placeholder="Credit Card Number" name="ccn" required/>
        </div>
        
		<div class="form-group">
        <input type="text" class="form-control" placeholder="Interests" name="interests"/>
        </div>
        
     	<hr />
        
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-signup">
    		<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account
			</button> 
           <!-- <a href="login.php" class="btn btn-default" style="float:right;">Log In Here</a>-->
        </div> 
      
      </form>

    </div>
    
</div>

</body>
</html>