<?php include('../config.php');
if(isset($_POST['update_email'])){
	$advisorid = $_SESSION["advisorid"];
	$update_email = $_POST['update_email'];
	$update_password = $_POST['update_password'];
	$update_password = md5($update_password);
	$q = "UPDATE `advisors` SET `email`='$update_email',`password`='$update_password' WHERE `advisorid` = '$advisorid'";
	mysql_query($q)or die(mysql_error());
	echo 'success';	
}?>