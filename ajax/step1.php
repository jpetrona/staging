<?php include('../config.php');  
if($_POST['action']== 'step1')
{
	$campaignname = $_POST['app_name'];
	$campaignname = stripslashes($campaignname);
	$campaignname = mysql_real_escape_string($campaignname);
	$app_category = $_POST['app-category'];
	$campaign_type=$_POST['campaign_type'];
	$invok_url = $_POST['invok-url'];
	$scheme_url = $_POST['scheme-url'];
	$url = $_POST['url'];
	$formattedPrice = $_POST['formattedPrice'];
	$_SESSION["campaignname"]=$campaignname;
	$_SESSION["app_category"]=$app_category;
	$_SESSION["invok_url"]=$invok_url;
	$_SESSION["formattedPrice"]=$formattedPrice;
	$_SESSION["campaign_type"]=$campaign_type;
	$_SESSION["scheme_url"]=$scheme_url;
	$_SESSION["url"]=$url;
	 echo "<span>1</span>";
}	
	
	
else if($_POST['action']== 'step2')
{
	  $ad_copy = $_POST['ad-copy'];
	  $icon = $_POST['icon_pic'];
	  $headline = $_POST["headline"];
	  $_SESSION["ad_copy"]=$ad_copy;
	  $_SESSION["icon"]=$icon;
	  $_SESSION["headline"]=$headline;
	 echo "<span>2</span>";
}
		
else if($_POST['action']== 'step3')
{
	$country = $_POST['country'];
	$_SESSION["country"]=$country;
	 echo "<span>3</span>";
}	
	
else if($_POST['action']== 'step4')
{
$rewrd_bid = $_POST['rewrd-bid'];
$rewrd_budgt = $_POST['amount'];
/*$watch_bid = $_POST['watch-bid'];
$watch_budgt = $_POST['watch-budgt'];
$display_bid = $_POST['display-bid'];
$display_budgt = $_POST['display-budgt'];*/
$daily_cap = $_POST['custom'];
$_SESSION["rewrd_bid"]=$rewrd_bid;
$_SESSION["rewrd_budgt"]=$rewrd_budgt;
$_SESSION["watch_bid"]=0;
$_SESSION["watch_budgt"]=0;
$_SESSION["display_bid"]=0;
$_SESSION["display_budgt"]=0;
$_SESSION["daily_cap"]=$daily_cap;
$campaignname=$_SESSION["campaignname"];
$app_category=$_SESSION["app_category"];
$invok_url=$_SESSION["invok_url"];
$campaign_type=$_SESSION["campaign_type"];
$scheme_url=$_SESSION["scheme_url"];
$url=$_SESSION["url"];
$ad_copy=$_SESSION["ad_copy"];
$country=$_SESSION["country"];
$rewrd_bid=$_SESSION["rewrd_bid"];
$rewrd_budgt=$_SESSION["rewrd_budgt"];
$watch_bid=$_SESSION["watch_bid"];
$watch_budgt=$_SESSION["watch_budgt"];
$display_bid=$_SESSION["display_bid"];
$display_budgt=$_SESSION["display_budgt"];
$daily_cap= $_SESSION["daily_cap"];
$admin_id = $_SESSION["advisorid"];
$formattedPrice=$_SESSION["formattedPrice"];
$headline=$_SESSION["headline"];
if($formattedPrice == "Free"){
	$formattedPrice = 'Free';
	}
else if($formattedPrice == ""){
	$formattedPrice = 'Free';
	}
else{
	$formattedPrice = 'Paid';
	}
if($url!=="")
{
	if($app_category == 'ios'){
			$sql = mysql_query("INSERT INTO db169264_retirelynew.offers(`offerid`, `advisorid`, `title`, `description`, `photopath`, `downloadurl`,`platform`,`campaign_type` ,`appurlscheme`, `date`, `status`,`country`, `rewardedbid`, `rewardedbudget`, `watchbid`, `watchbudget`, `displaybid`, 		`displaybudget`, `dailycap`,`project`,`formattedPrice`,`headline`,`commission`) VALUES (NULL,'".$admin_id."','".$campaignname."','".$ad_copy."','".$url."','".$invok_url."','".$app_category."','".$campaign_type."','".$scheme_url."',now(),'0','".$country."','".$rewrd_bid."','".$rewrd_budgt."','".$watch_bid."','".$watch_budgt."','".$display_bid."','".$display_budgt."','".$daily_cap."','retirely','".$formattedPrice."','".$headline."','25.00')") or die(mysql_error());
			$id = mysql_insert_id();
			$sql1 = mysql_query("INSERT INTO db169264_offerwall.offers(`offerid`, `sdkadminid`,`extid`,`extofferid`, `title`, `description`, `photopath`, `downloadurl`, 		`platform`,`campaign_type`, `appurlscheme`, `date`, `status`,`country`, `rewardedbid`, `rewardedbudget`, `watchbid`, `watchbudget`, `displaybid`,`displaybudget`, `dailycap`,`project`,`formattedPrice`,`headline`,`commission`) VALUES (NULL,'0','".$admin_id."','".$id."','".$campaignname."','".$ad_copy."','".$url."','".$invok_url."','".$app_category."','".$campaign_type."','".$scheme_url."',now(),'0','".$country."','".$rewrd_bid."','".$rewrd_budgt."','".$watch_bid."','".$watch_budgt."','".$display_bid."','".$display_budgt."','".$daily_cap."','retirely','".$formattedPrice."','".$headline."','25.00')") or die(mysql_error());
			
			
				$id = mysql_insert_id();
				$trackurl = "http://me.intlfaces.com/admin/tracking.php?id=".$id;
				$q = "UPDATE db169264_retirelynew.offers SET trackurl = '$trackurl' WHERE offerid = $id";
				mysql_query($q) or die(mysql_error());
				$qo = "UPDATE db169264_offerwall.offers SET trackurl = '$trackurl' WHERE offerid = $id";
				mysql_query($qo) or die(mysql_error());
				echo $trackurl;	
				$query = 'SELECT `fname`, `lname` FROM db169264_retirelynew.advisors WHERE `advisorid` = '.$admin_id;
				$result = mysql_query($query) or die(mysql_error());
				while($row = mysql_fetch_array($result)){
				$username = $row['fname']." ".$row['lname'];
				$email = 'alex@intlfaces.com';
				$subject = 'Thank You';
				$headers = "MIME-Version: 1.0" . "\r\n";
				$message = '<b>Hi Alex</b>,<br /><br />
				'.$username.' has beed added campaign sucessfully!<br /><br />
				To add this app '.$campaignname.' into your Tapjoy dashboard click here...<br /><br />
				https://dashboard.tapjoy.com/dashboard/apps/6cab2721-0eb8-48ff-be4b-54315e1ca271<br /><br />	
				<br /><br /><br />Support Team,<br /><b>Intlfaces </b>';
				$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
				$headers .= 'From: Intlfaces <admin@intlfaces.com>' . "\r\n";
				mail($email,$subject,$message,$headers);
				}
				unset($campaignname);
				unset($app_category);
				unset($invok_url);
				unset($url);
				unset($ad_copy);
				unset($country);
				unset($rewrd_bid);
				unset($rewrd_budgt);
				unset($watch_bid);
				unset($watch_budgt);
				unset($display_bid);
				unset($display_budgt);
				unset($daily_cap);	
			
	}	


	else if($app_category == 'android'){
	$sql = mysql_query("INSERT INTO db169264_retirelynew.offers(`offerid`, `advisorid`, `title`, `description`, `photopath`, `platform`,`campaign_type`, `androiddownloadurl`, `date`, `status`,`country`, `rewardedbid`, `rewardedbudget`, `watchbid`, `watchbudget`, `displaybid`, `displaybudget`, `dailycap`,`project`,`formattedPrice`,`headline`,`commission`) VALUES (NULL,'".$admin_id."','".$campaignname."','".$ad_copy."','".$url."','".$app_category."','".$campaign_type."','".$invok_url."',now(),'0','".$country."','".$rewrd_bid."','".$rewrd_budgt."','".$watch_bid."','".$watch_budgt."','".$display_bid."','".$display_budgt."','".$daily_cap."','retirely','".$formattedPrice."','".$headline."','25.00')") or die(mysql_error());
	$id = mysql_insert_id();
	$sql1 = mysql_query("INSERT INTO db169264_offerwall.offers(`offerid`, `sdkadminid`,`extid`,`extofferid`, `title`, `description`, `photopath`, `platform`,`campaign_type`, `androiddownloadurl`, `date`, `status`,`country`, `rewardedbid`, `rewardedbudget`, `watchbid`, `watchbudget`, `displaybid`, `displaybudget`, `dailycap`,`project`,`formattedPrice`,`headline`,`commission`) VALUES (NULL,'0','".$admin_id."','".$id."','".$campaignname."','".$ad_copy."','".$url."','".$app_category."','".$campaign_type."','".$invok_url."',now(),'0','".$country."','".$rewrd_bid."','".$rewrd_budgt."','".$watch_bid."','".$watch_budgt."','".$display_bid."','".$display_budgt."','".$daily_cap."','retirely','".$formattedPrice."','".$headline."','25.00')") or die(mysql_error());
	
	
				$id = mysql_insert_id();
				$trackurl = "http://me.intlfaces.com/admin/tracking.php?id=".$id;
				$q = "UPDATE db169264_retirelynew.offers SET trackurl = '$trackurl' WHERE offerid = $id";
				mysql_query($q);
				$qo = "UPDATE db169264_offerwall.offers SET trackurl = '$trackurl' WHERE offerid = $id";
				mysql_query($qo) or die(mysql_error());
				echo $trackurl;
				$query = 'SELECT `fname`, `lname` FROM db169264_retirelynew.advisors WHERE `advisorid` = '.$admin_id;
				$result = mysql_query($query) or die(mysql_error());
				while($row = mysql_fetch_array($result)){
					$username = $row['fname']." ".$row['lname'];
				$email = 'alex@intlfaces.com';
				$subject = 'Thank You';
				$headers = "MIME-Version: 1.0" . "\r\n";
				$message = '<b>Hi Alex</b>,<br /><br />
				'.$username.' has beed added campaign sucessfully!<br /><br />
				To add this app '.$campaignname.' into your Tapjoy dashboard click here...<br /><br />
				https://dashboard.tapjoy.com/dashboard/apps/6cab2721-0eb8-48ff-be4b-54315e1ca271<br /><br />	
				<br /><br /><br />Support Team,<br /><b>Intlfaces </b>';
				$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
				$headers .= 'From: Intlfaces <admin@intlfaces.com>' . "\r\n";
				mail($email,$subject,$message,$headers);
				}
				unset($campaignname);
				unset($app_category);
				unset($invok_url);
				unset($url);
				unset($ad_copy);
				unset($country);
				unset($rewrd_bid);
				unset($rewrd_budgt);
				unset($watch_bid);
				unset($watch_budgt);
				unset($display_bid);
				unset($display_budgt);
				unset($daily_cap);		
	}

	else if($app_category == 'web'){
	$sql = mysql_query("INSERT INTO db169264_retirelynew.offers (`offerid`, `advisorid`, `title`, `description`, `photopath`, `platform`, `campaign_type`, `date`, `status`,`websiteurl`,`country`, `rewardedbid`, `rewardedbudget`, `watchbid`, `watchbudget`, `displaybid`, `displaybudget`, `dailycap`,`project`,`formattedPrice`,`headline`,`commission`) VALUES (NULL,'".$admin_id."','".$campaignname."','".$ad_copy."','".$url."','".$app_category."','".$campaign_type."',now(),'0','".$invok_url."','".$country."','".$rewrd_bid."','".$rewrd_budgt."','".$watch_bid."','".$watch_budgt."','".$display_bid."','".$display_budgt."','".$daily_cap."','retirely','".$formattedPrice."','".$headline."','25.00')") or die(mysql_error());	
	$id = mysql_insert_id();
	$sql1 = mysql_query("INSERT INTO db169264_offerwall.offers(`offerid`, `sdkadminid`,`extid`,`extofferid`, `title`, `description`, `photopath`, `platform`,`campaign_type`,  `date`, `status`,`websiteurl`,`country`, `rewardedbid`, `rewardedbudget`, `watchbid`, `watchbudget`, `displaybid`, `displaybudget`, `dailycap`,`project`,`formattedPrice`,`headline`,`commission`) VALUES (NULL,'0','".$admin_id."','".$id."','".$campaignname."','".$ad_copy."','".$url."','".$app_category."','".$campaign_type."',now(),'0','".$invok_url."','".$country."','".$rewrd_bid."','".$rewrd_budgt."','".$watch_bid."','".$watch_budgt."','".$display_bid."','".$display_budgt."','".$daily_cap."','retirely','25.00')") or die(mysql_error());	
				$id = mysql_insert_id();
				$trackurl = "http://me.intlfaces.com/admin/tracking.php?id=".$id;
				$q = "UPDATE db169264_retirelynew.offers SET trackurl = '$trackurl' WHERE offerid = $id";
				mysql_query($q);
				$qo = "UPDATE db169264_offerwall.offers SET trackurl = '$trackurl' WHERE offerid = $id";
				mysql_query($qo) or die(mysql_error());
				echo $trackurl;	
				$query = 'SELECT `fname`, `lname` FROM db169264_retirelynew.advisors WHERE `advisorid` = '.$admin_id;
				$result = mysql_query($query) or die(mysql_error());
				while($row = mysql_fetch_array($result)){
					$username = $row['fname']." ".$row['lname'];
				$email = 'alex@intlfaces.com';
				$subject = 'Thank You';
				$headers = "MIME-Version: 1.0" . "\r\n";
				$message = '<b>Hi Alex</b>,<br /><br />
				'.$username.' has beed added campaign sucessfully!<br /><br />
				To add this app '.$campaignname.' into your Tapjoy dashboard click here...<br /><br />
				https://dashboard.tapjoy.com/dashboard/apps/6cab2721-0eb8-48ff-be4b-54315e1ca271<br /><br />	
				<br /><br /><br />Support Team,<br /><b>Intlfaces </b>';
				$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
				$headers .= 'From: Intlfaces <admin@intlfaces.com>' . "\r\n";
				mail($email,$subject,$message,$headers);
				}
				unset($campaignname);
				unset($app_category);
				unset($invok_url);
				unset($url);
				unset($ad_copy);
				unset($country);
				unset($rewrd_bid);
				unset($rewrd_budgt);
				unset($watch_bid);
				unset($watch_budgt);
				unset($display_bid);
				unset($display_budgt);
				unset($daily_cap);	
	
	}

	else {
		echo '<span>00</span>';
	}

}
else{
		$name = $_SESSION['icon'];
	
		if($app_category == 'ios'){
			$sql = mysql_query("INSERT INTO db169264_retirelynew.offers(`offerid`, `advisorid`, `title`, `description`, `photopath`, `downloadurl`,`platform`,`campaign_type`,`date`, `status`,`country`, `rewardedbid`, `rewardedbudget`, `watchbid`, `watchbudget`, `displaybid`, 		`displaybudget`, `dailycap`,`project`,`formattedPrice`,`headline`,`commission`) VALUES (NULL,'".$admin_id."','".$campaignname."','".$ad_copy."','".$name."','".		$invok_url."','".$app_category."','".$campaign_type."',now(),'0','".$country."','".$rewrd_bid."','".$rewrd_budgt."','".$watch_bid."','".$watch_budgt."','".$display_bid."','".$display_budgt."','".$daily_cap."','retirely','".$formattedPrice."','".$headline."','25.00')") or die(mysql_error());	
			$id = mysql_insert_id();
			
			$sql1 = mysql_query("INSERT INTO db169264_offerwall.offers(`offerid`, `sdkadminid`,`extid`,`extofferid`,`title`, `description`, `photopath`, `downloadurl`, 		`platform`,`campaign_type`, `date`, `status`,`country`, `rewardedbid`, `rewardedbudget`, `watchbid`, `watchbudget`, `displaybid`, `displaybudget`, `dailycap`,`project`,`formattedPrice`,`headline`,`commission`) VALUES (NULL,'0','".$admin_id."','".$id."','".$campaignname."','".$ad_copy."','".$name."','".$invok_url."','".$app_category."','".$campaign_type."',now(),'0','".$country."','".$rewrd_bid."','".$rewrd_budgt."','".$watch_bid."','".$watch_budgt."','".$display_bid."','".$display_budgt."','".$daily_cap."','retirely','".$formattedPrice."','".$headline."','25.00')") or die(mysql_error());
			
				$id = mysql_insert_id();
				$trackurl = "http://me.intlfaces.com/admin/tracking.php?id=".$id;
				$q = "UPDATE db169264_retirelynew.offers SET trackurl = '$trackurl' WHERE offerid = $id";
				mysql_query($q);
				$qo = "UPDATE db169264_offerwall.offers SET trackurl = '$trackurl' WHERE offerid = $id";
				mysql_query($qo) or die(mysql_error());
				$query = 'SELECT `fname`, `lname` FROM db169264_retirelynew.advisors WHERE `advisorid` = '.$admin_id;
				$result = mysql_query($query) or die(mysql_error());
				while($row = mysql_fetch_array($result)){
					$username = $row['fname']." ".$row['lname'];
				$email = 'alex@intlfaces.com';
				$subject = 'Thank You';
				$headers = "MIME-Version: 1.0" . "\r\n";
				$message = '<b>Hi Alex</b>,<br /><br />
				'.$username.' has beed added campaign sucessfully!<br /><br />
				To add this app '.$campaignname.' into your Tapjoy dashboard click here...<br /><br />
				https://dashboard.tapjoy.com/dashboard/apps/6cab2721-0eb8-48ff-be4b-54315e1ca271<br /><br />	
				<br /><br /><br />Support Team,<br /><b>Intlfaces </b>';
				$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
				$headers .= 'From: Intlfaces <admin@intlfaces.com>' . "\r\n";
				mail($email,$subject,$message,$headers);
				}
				echo $trackurl;	
				unset($campaignname);
				unset($app_category);
				unset($invok_url);
				unset($url);
				unset($ad_copy);
				unset($country);
				unset($rewrd_bid);
				unset($rewrd_budgt);
				unset($watch_bid);
				unset($watch_budgt);
				unset($display_bid);
				unset($display_budgt);
				unset($daily_cap);	
			
	}	


	else if($app_category == 'android'){
	$sql = mysql_query("INSERT INTO db169264_retirelynew.offers(`offerid`, `advisorid`, `title`, `description`, `photopath`, `platform`,`campaign_type`, `androiddownloadurl`, `date`, `status`,`country`, `rewardedbid`, `rewardedbudget`, `watchbid`, `watchbudget`, `displaybid`, `displaybudget`, `dailycap`,`project`,`formattedPrice`,`headline`,`commission`) VALUES (NULL,'".$admin_id."','".$campaignname."','".$ad_copy."','".$name."','".$app_category."','".$campaign_type."','".$invok_url."',now(),'0','".$country."','".$rewrd_bid."','".$rewrd_budgt."','".$watch_bid."','".$watch_budgt."','".$display_bid."','".$display_budgt."','".$daily_cap."','retirely','".$formattedPrice."','".$headline."','25.00')") or die(mysql_error());	
	$id = mysql_insert_id();
	$sql1 = mysql_query("INSERT INTO db169264_offerwall.offers(`offerid`, `sdkadminid`,`extid`,`extofferid`, `title`, `description`, `photopath`, `platform`,`campaign_type`, `androiddownloadurl`, `date`, `status`,`country`, `rewardedbid`, `rewardedbudget`, `watchbid`, `watchbudget`, `displaybid`, `displaybudget`, `dailycap`,`project`,`formattedPrice`,`headline`,`commission`) VALUES (NULL,'0','".$admin_id."','".$id."','".$campaignname."','".$ad_copy."','".$name."','".$app_category."','".$campaign_type."','".$invok_url."',now(),'0','".$country."','".$rewrd_bid."','".$rewrd_budgt."','".$watch_bid."','".$watch_budgt."','".$display_bid."','".$display_budgt."','".$daily_cap."','retirely','".$formattedPrice."','".$headline."','25.00')") or die(mysql_error());
				$id = mysql_insert_id();
				$trackurl = "http://me.intlfaces.com/admin/tracking.php?id=".$id;
				$q = "UPDATE db169264_retirelynew.offers SET trackurl = '$trackurl' WHERE offerid = $id";
				mysql_query($q);
				$qo = "UPDATE db169264_offerwall.offers SET trackurl = '$trackurl' WHERE offerid = $id";
				mysql_query($qo) or die(mysql_error());
				echo $trackurl;	
				$query = 'SELECT `fname`, `lname` FROM db169264_retirelynew.advisors WHERE `advisorid` = '.$admin_id;
				$result = mysql_query($query) or die(mysql_error());
				while($row = mysql_fetch_array($result)){
					$username = $row['fname']." ".$row['lname'];
				$email = 'alex@intlfaces.com';
				$subject = 'Thank You';
				$headers = "MIME-Version: 1.0" . "\r\n";
				$message = '<b>Hi Alex</b>,<br /><br />
				'.$username.' has beed added campaign sucessfully!<br /><br />
				To add this app '.$campaignname.' into your Tapjoy dashboard click here...<br /><br />
				https://dashboard.tapjoy.com/dashboard/apps/6cab2721-0eb8-48ff-be4b-54315e1ca271<br /><br />	
				<br /><br /><br />Support Team,<br /><b>Intlfaces </b>';
				$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
				$headers .= 'From: Intlfaces <admin@intlfaces.com>' . "\r\n";
				mail($email,$subject,$message,$headers);
				}
				unset($campaignname);
				unset($app_category);
				unset($invok_url);
				unset($url);
				unset($ad_copy);
				unset($country);
				unset($rewrd_bid);
				unset($rewrd_budgt);
				unset($watch_bid);
				unset($watch_budgt);
				unset($display_bid);
				unset($display_budgt);
				unset($daily_cap);	
	}

	else if($app_category == 'web'){
	$sql = mysql_query("INSERT INTO db169264_retirelynew.offers(`offerid`, `advisorid`, `title`, `description`, `photopath`, `platform`, `campaign_type`, `date`, `status`,`websiteurl`,`country`, `rewardedbid`, `rewardedbudget`, `watchbid`, `watchbudget`, `displaybid`, `displaybudget`, `dailycap`,`project`,`formattedPrice`,`headline`,`commission`) VALUES (NULL,'".$admin_id."','".$campaignname."','".$ad_copy."','".$name."','".$app_category."','".$campaign_type."',now(),'0','".$invok_url."','".$country."','".$rewrd_bid."','".$rewrd_budgt."','".$watch_bid."','".$watch_budgt."','".$display_bid."','".$display_budgt."','".$daily_cap."','retirely','".$formattedPrice."','".$headline."','25.00')") or die(mysql_error());	
	
	$id = mysql_insert_id();
	
	$sql1 = mysql_query("INSERT INTO db169264_offerwall.offers(`offerid`, `sdkadminid`,`extid` ,`extofferid`, `title`, `description`, `photopath`, `platform`,`campaign_type` , `date`, `status`,`websiteurl`,`country`, `rewardedbid`, `rewardedbudget`, `watchbid`, `watchbudget`, `displaybid`, `displaybudget`, `dailycap`,`project`,`formattedPrice`,`headline`,`commission`) VALUES (NULL,'0','".$admin_id."','".$id."','".$campaignname."','".$ad_copy."','".$name."','".$app_category."','".$campaign_type."',now(),'0','".$invok_url."','".$country."','".$rewrd_bid."','".$rewrd_budgt."','".$watch_bid."','".$watch_budgt."','".$display_bid."','".$display_budgt."','".$daily_cap."','retirely','".$formattedPrice."','".$headline."','25.00')") or die(mysql_error());	
				$id = mysql_insert_id();
				$trackurl = "http://me.intlfaces.com/admin/tracking.php?id=".$id;
				$q = "UPDATE db169264_retirelynew.offers SET trackurl = '$trackurl' WHERE offerid = $id";
				mysql_query($q);
				$qo = "UPDATE db169264_offerwall.offers SET trackurl = '$trackurl' WHERE offerid = $id";
				mysql_query($qo) or die(mysql_error());
				echo $trackurl;	
				$query = 'SELECT `fname`, `lname` FROM db169264_retirelynew.advisors WHERE `advisorid` = '.$admin_id;
				$result = mysql_query($query) or die(mysql_error());
				while($row = mysql_fetch_array($result)){
					$username = $row['fname']." ".$row['lname'];
					$email = 'alex@intlfaces.com';
					$subject = 'Thank You';
					$headers = "MIME-Version: 1.0" . "\r\n";
					$message = '<b>Hi Alex</b>,<br /><br />
					'.$username.' has beed added campaign sucessfully!<br /><br />
					To add this app '.$campaignname.' into your Tapjoy dashboard click here...<br /><br />
					https://dashboard.tapjoy.com/dashboard/apps/6cab2721-0eb8-48ff-be4b-54315e1ca271<br /><br />	
					<br /><br /><br />Support Team,<br /><b>Intlfaces </b>';
					$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
					$headers .= 'From: Intlfaces <admin@intlfaces.com>' . "\r\n";
					mail($email,$subject,$message,$headers);
				}
				unset($campaignname);
				unset($app_category);
				unset($invok_url);
				unset($url);
				unset($ad_copy);
				unset($country);
				unset($rewrd_bid);
				unset($rewrd_budgt);
				unset($watch_bid);
				unset($watch_budgt);
				unset($display_bid);
				unset($display_budgt);
				unset($daily_cap);	
	
	}

	else {
		echo '<span>00</span>';
	}
}
	}
	else{
		echo '<span>000</span>';
		}
?>