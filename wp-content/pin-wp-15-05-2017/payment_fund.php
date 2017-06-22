<?php
/*
Template Name: Payment Fund
*/
require_once( ABSPATH . 'config.php' );
// Database variables
$rewrd_bid = $_POST['rewrd-bid'];
$item_amount = $_POST['amount'];
$campaignname= "Transfer Fund";
$item_name = $campaignname;

// PayPal settings
//$paypal_email = 'jitendrashakya777-facilitator@gmail.com';
//$paypal_email = 'admin@Intlfaces.com';
$paypal_email = $_POST['payeremail'];

$login_email = $_POST['login_email'];
//start transaction
$admin_id = $_SESSION["advisorid"];

// Include Functions
include 'payment_function.php';
$date = date('YmdHis');	
$adminfundid="";
$return_url = get_bloginfo("url").'/payment-fund?fid='.$adminfundid;
$cancel_url = get_bloginfo("url");
$notify_url = get_bloginfo("url").'/payment-fund';
	
// Check if paypal request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){
 
	$sql = "INSERT INTO `adminfund`(`adminfundid`, `advisorid`, `amount`, `datetime`, `paypalemail`, `paidto`, `transactionid`, `status`) VALUES ( 'NULL','$admin_id','$item_amount','{$date}','$login_email','$paypal_email','','Start')";
	$res = mysql_query($sql);
	if( !$res )
	{
		echo mysql_error();
	}
	 
	$adminfundid=mysql_insert_id();
	
	$return_url = get_bloginfo("url").'/payment-fund?fid='.$adminfundid;
	// Firstly Append paypal account to querystring
	$querystring .= "?business=".urlencode($paypal_email)."&";	
	
	// Append amount& currency (£) to quersytring so it cannot be edited in html
	
	//The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
	$querystring .= "item_name=".urlencode($item_name)."&";
	$querystring .= "amount=".urlencode($item_amount)."&";
	
	//loop for posted values and append to querystring
	foreach($_POST as $key => $value){
		$value = urlencode(stripslashes($value));
		$querystring .= "$key=$value&";
	}
	
	// Append paypal return addresses
	$querystring .= "return=".urlencode(stripslashes($return_url))."&";
	$querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
	$querystring .= "notify_url=".urlencode($notify_url);
	
	// Append querystring with custom field
	//$querystring .= "&custom=".USERID;
	// Redirect to paypal IPN
	ob_start();
	header('location:https://www.paypal.com/cgi-bin/webscr'.$querystring);
	exit();
}else{

	// READ THE POST FROM PayPal AND ADD 'cmd'
	if(isset($_POST['txn_id']) && $_POST['txn_id'] != ""){
		$tras_id = $_POST['txn_id'];	
		$fid=$_GET['fid'];
		$q = "UPDATE `adminfund` SET `datetime`='{$date}',`transactionid`='$tras_id',`status`='Complete' WHERE `adminfundid`=$fid";
		mysql_query($q) or die(mysql_error());
	}else{
		$tras_id = $_POST['txn_id'];	
		$fid=$_GET['fid'];
		$q = "UPDATE `adminfund` SET `datetime`='{$date}',`transactionid`='$tras_id',`status`='Invalid' WHERE `adminfundid`=$fid";
		mysql_query($q) or die(mysql_error());
	}	
	ob_start();
	header('location:'.get_bloginfo("url").'/thank-you');
	exit();
}
?>