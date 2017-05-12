<?php
require 'dbconnect.php';
if(isset($_GET['image_name'])) {
$sql = "SELECT * FROM media WHERE name='" . $_GET['image_name']."'";
$result = $conn->query("$sql");
$row = mysqli_fetch_assoc($result);
header("Content-type: image/jpeg");
echo $row["media"];
}
?>