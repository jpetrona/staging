<?php
include("config.php");
$id=$_REQUEST["id"];
$status=$_REQUEST["status"];
$q="UPDATE advisors SET status = $status WHERE advisorid = $id";
if(!mysql_query($q))
{
	die(mysql_error());
}
?>
