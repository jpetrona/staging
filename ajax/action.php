<?php include('../config.php'); 
$result = 0;
if(isset($_POST) && $_POST['action'] == "signin"){	
	$email1=$_POST['email'];
	$password = $_POST['password'];
	$add_campaign = $_POST['add_campaign'];
	$password1 = mysql_escape_string(md5($password));
	$result1=mysql_query("select * from advisors where email='$email1' and password='$password1'") or die(mysql_error());
	$row_count=mysql_num_rows($result1);
	if($row_count > 0){
		session_start();
		$row = mysql_fetch_array($result1);
		$_SESSION['advisorid'] = $row['advisorid'];
		$_SESSION['name'] = $row['fname']." ".$row['lname'];
		$result = "1";
	}
	else{
		$result = "Invalid Email or Password.";
	} 	
}
else if(isset($_POST) && $_POST['action'] == "signup"){
	$email = $_POST['email'];	
	$pwd = $_POST['password'];
	$add_campaign = $_POST['add_campaign'];
	$pwd = mysql_escape_string(md5($pwd));
	$fname = $_POST['firstname'];
	$lname = $_POST['lastname'];
	$location = $_POST['city'];
	$phone = $_POST['phone'];
	$terms = $_POST['terms'];
	$name = $fname." ".$lname;
	$date = date('YmdHis');  
	$auth ="SELECT * FROM `advisors` where email ='$email'";
	$result =  mysql_query($auth);
	$row = mysql_num_rows($result);	
	if($row == 0)
	{
		$q = "INSERT INTO advisors VALUES ('','$fname','$lname','$email','','','$pwd','','$location',0,'','','','','','$phone',
'','',0,0,'','','',0,'{$date}',10,0,0,'{$date}','','$terms','')";
		if(mysql_query($q))
		{
			$id = mysql_insert_id(); 
			session_start();
			$row = mysql_fetch_array($result);
			$_SESSION['advisorid'] = $id;
			$_SESSION['name'] = $name;
			$result = "1";
		}
		else
		{
			$result  = "Error in processing your request.";
		}
	}
	else
	{
		$result  = "Email already register. Please use another email.";
	}
}
else if(isset($_POST) && $_POST['action'] == "editaccount"){
	$userid = $_POST['userid'];
	$customerid = $_POST['customerid'];
	$user_fname = $_POST['fname'];
	$user_lname = $_POST['lname'];
	$address = $_POST["address"];
	$city = $_POST["city"];
	$state = $_POST["state"];
	$zipcode = $_POST["zip"];
	$phone1 = $_POST["phone1"];
	$phone2 = $_POST["phone2"];
	$phone3 = $_POST["phone3"];
	$name = $user_fname." ".$user_lname;
	$phone = $phone1.$phone2.$phone3;
	$email = $_POST['email'];
	
	$q ="SELECT * FROM `wp_users` where user_email ='$email' AND userid <> $userid";
	$result =  mysql_query($q);
	$row = mysql_num_rows($result);	
	if($row == 0)
	{
		$q ="UPDATE wp_users SET user_login = '$email', user_nicename = '$name', user_email = '$email' WHERE id = $userid";
		mysql_query($q);		
		$metavalues = "UPDATE wp_usermeta SET meta_value = '$user_fname' WHERE user_id = $userid AND meta_key = 'first_name'";
		mysql_query($metavalues);
		$metavalues = "UPDATE wp_usermeta SET meta_value = '$user_lname' WHERE user_id = $userid AND meta_key = 'last_name'";
		mysql_query($metavalues); 
		$metavalues = "UPDATE wp_usermeta SET meta_value = '$name' WHERE user_id = $userid AND meta_key = 'nickname'";
		mysql_query($metavalues);
		
		if($customerid == "")
		{
			$q ="SELECT * FROM `wp_doner_info` where userid = $userid";
			$res =  mysql_query($q);				
			if(mysql_num_rows($res) > 0)
			{
				$row = mysql_fetch_array($res);
				$customerid = $row["customerid"];
			}
		}
		
        if($customerid != "")
		{
			$result = Braintree_Customer::update(
				$customerid,
				array(
				  'firstName' => $user_fname,
				  'lastName' => $user_lname,
				  'email' => $email,
				  'phone' => $phone
				));
			if($result->success)
			{
				$q ="UPDATE wp_doner_info SET firstname = '$user_fname', lastname = '$user_lname', address = '$address', city = '$city', state = '$state', zipcode = '$zipcode', phone = '$phone', email = '$email' WHERE userid = $userid";
				mysql_query($q);
				$message = 10;
			}
		}
		else
		{
			$result = Braintree_Customer::create(array(
				"firstName" => $user_fname,
				"lastName" => $user_lname,
				"email" => $email,
				"phone" => $phone
			));
			if ($result->success) {
				$customerid = $result->customer->id;
                $q ="UPDATE wp_doner_info SET firstname = '$user_fname', lastname = '$user_lname', address = '$address', city = '$city', state = '$state', zipcode = '$zipcode', phone = '$phone', email = '$email', customerid = '$customerid' WHERE userid = $userid";
				mysql_query($q);
				$message = 10;				
			}
		}		
	}
	else
	{
		$message = 'Email already register.';
	}	
}
else if(isset($_POST) && $_POST['action'] == "updatebillinginfo"){
	$donerinfoid = $_POST['donerinfoid']; 
    $userid = $_POST['userid'];
	$customerid = $_POST['customerid'];
	$cardtype = $_POST['cardtype'];
	$number = $_POST['number'];
	$cvv = $_POST["cvv"];
	$expdate = $_POST["expdate"];
	$fname = '';
	$lname = '';
	$address = '';
	$city = '';
	$state = '';
	$zipcode = '';
	$q ="SELECT * FROM wp_doner_info WHERE id = $donerinfoid";
	$result =  mysql_query($q);					
	if(mysql_num_rows($result) > 0)
	{
		$row = mysql_fetch_array($result);
		$fname = $row["firstname"];
		$lname = $row["lastname"];
		$address = $row["address"];
	    $city = $row["city"];
	    $state = $row["state"];
	    $zipcode = $row["zip"];
		$customerid = $row["customerid"];
	}	
	
	if($customerid != "")
	{
		$updateResult = Braintree_Customer::update(
			$customerid,
			array(
				"firstName" => $fname,
				"lastName" => $lname,
				"creditCard" => array(
					"number" => $number,
					"expirationDate" => $expdate,
					"cvv" => $cvv,
					"billingAddress" => array(
						"firstName" => $fname,
						"lastName" => $lname,
						"streetAddress" => $address,
						"locality" => $city,
						"region" => $state,
						"postalCode" => $zipcode
					)
				)
			)
		);
		if($updateResult->success)
		{
			$message = 10;
		}
	}
	else
	{
		$result = Braintree_Customer::create(array(
			"firstName" => $fname,
			"lastName" => $lname,
			"creditCard" => array(
				"number" => $number,
				"expirationDate" => $expdate,
				"cvv" => $cvv,
				"billingAddress" => array(
					"firstName" => $fname,
					"lastName" => $lname,
					"streetAddress" => $address,
					"locality" => $city,
					"region" => $state,
					"postalCode" => $zipcode
				)
			)
		));
		if ($result->success) {
			$customerid = $result->customer->id;
			$q ="UPDATE wp_doner_info SET customerid = '$customerid' WHERE id = $donerinfoid";
			mysql_query($q);
			$message = 10;				
		}
	}
	
}
else if(isset($_POST) && $_POST['action'] == "updatepaymentinfo"){
	$userid = $_POST['userid']; 
    $donerinfoid = $_POST['donerinfoid']; 
    $subscriptionid = $_POST['subscriptionid'];
	$frequency = $_POST['frequency'];
	$amount = $_POST['amount'];
	$planid = "";
	$customerid = "";
	if($frequency == "Weekly")
	{
		$planid = 'gxwm';
	}
	else if($frequency == "Biweekly")
	{
		$planid = '8yqg';
	}
	else if($frequency == "Monthly")
	{
		$planid = 'px3r';
	}
	if($customerid == "")
	{
		$q ="SELECT * FROM `wp_doner_info` WHERE id = $donerinfoid";
		$res =  mysql_query($q);				
		if(mysql_num_rows($res) > 0)
		{
			$row = mysql_fetch_array($res);
			$customerid = $row["customerid"];
		}
	}
	if($customerid != "")
	{	
		if($subscriptionid == "")
		{
			$customer = Braintree_Customer::find($customerid);
			$payment_method_token = $customer->creditCards[0]->token;			
			$result = Braintree_Transaction::sale(array(
				"amount" => $amount,
				"recurring" => true,
				"customerId" => $customerid,
				"paymentMethodToken" => $payment_method_token,
				"customFields" => array(
					"category"    => $category,
					"notes"    => $notes,
				),
				"options" => array(
					"submitForSettlement" => true
				)
			));
			if ($result->success) {
				$transactionid = $result->transaction->id;	
			}
			
			$resultSubscription = Braintree_Subscription::create(array(
				'paymentMethodToken' => $payment_method_token,
				'planId' => $planid
			)); 
			$subscriptionid = $resultSubscription->subscription->id;	
			$result = Braintree_Subscription::update($subscriptionid,array(				
				'price' => $amount						
			));	
			if($result->success)
			{
				$q ="UPDATE wp_doner_info SET subscriptionid = '$subscriptionid' WHERE id = $donerinfoid";
				mysql_query($q);
				$q = "INSERT INTO `wp_donate_transactions` VALUES ('','$userid','$donerinfoid','$amount','$category', '$frequency','','$transactionid','{$date}',10)";
				mysql_query($q);
				$message = 10;
			}
		}
		else
		{	
			$result = Braintree_Subscription::update($subscriptionid,array(
				'planId' => $planid,
				'price' => $amount						
			));
			if($result->success)
			{
				$message = 10;
			}
		}
	}
	else
	{
		$message = -1;
	}
}
else if(isset($_POST) && $_POST['action'] == "resetpassword"){
	$userid = $_POST['userid']; 
    $pwd = $_POST['password'];
	$pwd = wp_hash_password($pwd);
	$q ="UPDATE wp_users SET user_pass = '$pwd' WHERE id = $userid";
	mysql_query($q);
	$message = 10;
}
else if(isset($_POST) && $_POST['action'] == "forgotpassword"){
    $pwd = mt_rand(99999,9999999);
	$email = "";
	$ency_pwd = "";	
	$ency_pwd = wp_hash_password($pwd);
	if(isset($_POST["email"]))
	{
		$email = $_POST["email"];
		$email = mysql_escape_string($email);
	}	
	$q ="SELECT * FROM wp_users WHERE user_email = '$email'";
	$result =  mysql_query($q);			
	if(mysql_num_rows($result) > 0)
	{
		$q ="UPDATE wp_users SET user_pass = '$ency_pwd' WHERE user_email = '$email'";
		if(mysql_query($q))
		{
			$message = 10;			
			$msg= "<b>Your new password is: ".$pwd."</b><br /><br />";
			$msg = $msg."Your password has been changed. You don't need to do anything, this message is simply a notification to protect the security of your account. Your new password has been activated. If it does not work on your first try, please try again later. "."<br /><br />";
			$msg = $msg."The RLA Team";
			$to = $email;
			$subject = "Your RLA Account Password has been changed";						
			//$headers .= ' MIME-Version: 1.0'. "\r\n";
			$headers .= 'Content-Type: text/html; charset=ISO-8859-1'. "\r\n"; 
			$headers .= 'From: RLA <eden.c@realityla.com>';
			@mail($to,$subject,$msg,$headers);
		}	
	}
	else
	{
		$message = 11;
	}
}
else{
	$message =11;
}
echo $result;
?>