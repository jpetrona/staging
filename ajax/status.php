<?php 
include('../config.php');
if(isset($_POST['offerid'])){
	$id = $_POST['offerid'];
	$bid = $_POST['bid'];
	$q = "UPDATE offers SET rewardedbid = '$bid', status='0', user_bid= '',publisher_bid='',profit='' WHERE offerid = $id";
	mysql_query($q)or die(mysql_error());
	echo 'success';
}?>