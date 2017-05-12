<?php

header("content-type:image/jpeg");
require 'dbconnect.php'; 

$name=$_GET['name'];

$select_image="select * from media where imagename='$name'";

$var=mysql_query($select_image);

if($row=mysql_fetch_array($var))
{
 $image_name=$row["imagename"];
 $image_content=$row["imagecontent"];
}
echo $image;

?>
