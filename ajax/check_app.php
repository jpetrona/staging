<?php include('../config.php'); 
if(isset($_POST['appname'])){
	$advisorid = $_SESSION["advisorid"];
	$appname = $_POST['appname'];
	$app_category = $_POST['app_category'];
	$q = "SELECT * FROM `offers` WHERE `title` = '$appname' AND`platform` = '$app_category' AND advisorid = '$advisorid'";
	$row = mysql_query($q)or die(mysql_error());
	if(mysql_num_rows($row)>0)
	{
		echo 'fail';
		
	}
	else
	{
		echo 'success';
	}
	

}?>