<?php
session_start();

if (!isset($_SESSION['email'])) {
	header("Location: about_us.php");
} else if (isset($_SESSION['email'])!="") {
	header("Location: home.php");
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['email']);
	header("Location: about_us.php");
}
