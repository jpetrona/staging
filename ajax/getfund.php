<?php include('../config.php');
$admin_id = $_SESSION["advisorid"];
$spentamounts='';
$spends='';
$commission=0.00;
$app_name = "";
define("ADMIN_ID" , 593 );

if($admin_id == ADMIN_ID )
{
	$qoffer= 'select * from '.RETIRELY_DB.'.offers';
	
	$resultoffer = mysql_query($qoffer) or die(mysql_error());
	if(mysql_num_rows($resultoffer) > 0)
	{
		while($addoffer= mysql_fetch_array($resultoffer))
		{
			$id = $addoffer['offerid'];
			$app_name = $addoffer['title'];
			if($app_name == '$15+ per hour Jobs Now Hiring in your Area! Click Now!'){
				$app_name = '$15+ per hour Jobs Now Hiring in your Area! Click Now! -- CPA (All) - US';
			}
			$commission = $addoffer['commission'];
			$qoffer = "SELECT * FROM ".RETIRELY_DB.".reporting_cart where name ='$app_name'";

			$resoffer = mysql_query($qoffer) or die(mysql_error());
			if(mysql_num_rows($resoffer) > 0)
			{
				$rowss = mysql_fetch_assoc($resoffer);
				$url = $rowss['url'];
				$qoffer1 = "SELECT sum(spend) as spend FROM ".RETIRELY_DB.".reporting_cart where name ='$app_name'";
				$resoffer1 = mysql_query($qoffer1) or die(mysql_error());
				if(mysql_num_rows($resoffer1) > 0)
				{	 
					while($rowoffer1 = mysql_fetch_assoc($resoffer1))
					{
					  $spends .= abs($rowoffer1['spend']/100).',';				   
					} 
					 
				}
			}
		}
	}else{
		$spends = '0';
	}
	$string  = rtrim($spends,',');
	$string = explode(",",$string);
	$string = array_sum ($string);
	$string_new = ($commission / 100) * $string;
	$string = $string +$string_new;
	$string = number_format($string,2);
	$q = "SELECT offerid FROM linkixvk_offerwall.usertracking WHERE `offerid` in (select `offerid` from linkixvk_offerwall.offers where offerid !=0)"; //extofferid !=0)";
		$res =  mysql_query($q) or die(mysql_error());
		if(mysql_num_rows($res) > 0)
		{ 
			while($row = mysql_fetch_assoc($res))
			{
				$offer_id = $row["offerid"];
				$query = "SELECT sum(IFNULL(`rewardedbid`,0)) as spentamount, count(*) as counts FROM linkixvk_offerwall.offers WHERE `offerid` =".$offer_id;
				$result =  mysql_query($query) or die(mysql_error());
				$result_row = mysql_fetch_assoc($result);
			 	$spentamount = $result_row["spentamount"];
				$count = $result_row["counts"];
			  //$spentamount = number_format($spentamount,2);
			    $spentamounts .= $spentamount.',';
			}
			$spentamounts1  = rtrim($spentamounts,',');
			$spentamounts = explode(",",$spentamounts1);
			$spentamounts = array_sum ($spentamounts);
			$spentamounts = number_format($spentamount,2);
			$string1 = str_replace(',', '', $string);
			echo $spentamounts = $string1 + $spentamounts;
		} 
		else{
				$spentamounts = '0';
				echo $spentamount = $string + $spentamounts;
			}
	}
	else
	{
		$qoffer= 'select * from '.RETIRELY_DB.'.offers where advisorid='.$admin_id;
		 
		$resultoffer = mysql_query($qoffer) or die(mysql_error());
		
		if(mysql_num_rows($resultoffer) > 0)
		{

			while($addoffer= mysql_fetch_array($resultoffer))
			{

				$app_name = $addoffer['title'];				
				$commission = $addoffer['commission'];
				$url = $addoffer['websiteurl'];
				if($app_name == 'Whotrades.com')
				{
					$app_name = 'WhoTrades - RegÃ­strese, abra una cuenta y reciba $50 para sus ganancias  -- CPA (All) - MX, Latin American, South America';
					$qoffer = "SELECT * FROM ".RETIRELY_DB.".reporting_cart where name ='$app_name'";
					$resoffer = mysql_query($qoffer) or die(mysql_error());
					if(mysql_num_rows($resoffer) > 0)
					{
						$qoffer1 = "SELECT sum(spend) as spend FROM ".RETIRELY_DB.".reporting_cart where name ='$app_name'";
						$resoffer1 = mysql_query($qoffer1) or die(mysql_error());
						if(mysql_num_rows($resoffer1) > 0)
						{	 
							while($rowoffer1 = mysql_fetch_assoc($resoffer1))
							{
							    $spends .= abs($rowoffer1['spend']/100).',';				   
							} 
						}
					}
				}
				else if($app_name == '$15+ per hour Jobs Now Hiring in your Area! Click Now!')
				{
					$app_name = '$15+ per hour Jobs Now Hiring in your Area! Click Now! -- CPA (All) - US';
					$q = "SELECT  sum( conversions ) AS paidInstalls, sum( clicks ) AS paidclicks,
					sum(conversions * rewardbid) AS spends
						FROM ".RETIRELY_DB.".hasofferstats
						WHERE `offerurl` = 'http://mesav.com/clk.cfm?dp=33&dc=2025&s1=&s2=&s3='";
					$resoffer = mysql_query($q) or die(mysql_error());
					if(mysql_num_rows($resoffer) > 0)
					{
						while($row = mysql_fetch_assoc($resoffer))
						{
						  $spends = $row["spends"];				   
						} 
					}					
					/*
					$que = "SELECT url FROM linkixvk_retirelynew.reporting_cart where name ='$app_name'";
					$result = mysql_query($que) or die(mysql_error());
					$rowss = mysql_fetch_assoc($result);
					$url = $rowss['url'];
					$qoffer = "SELECT * FROM linkixvk_retirelynew.reporting_cart where url ='$url'";
					$resoffer = mysql_query($qoffer) or die(mysql_error());
					if(mysql_num_rows($resoffer) > 0)
					{
						$qoffer1 = "SELECT sum(spend) as spend FROM linkixvk_retirelynew.reporting_cart where url ='$url'";
						$resoffer1 = mysql_query($qoffer1) or die(mysql_error());
						if(mysql_num_rows($resoffer1) > 0)
						{	 
							while($rowoffer1 = mysql_fetch_assoc($resoffer1))
							{
							  $spends .= abs($rowoffer1['spend']/100).',';				   
							} 
						}
					}
					*/
				}
				else
				{
					$q = "SELECT  sum( conversions ) AS paidInstalls, sum( clicks ) AS paidclicks,
					sum(conversions * rewardbid) AS spends FROM ".RETIRELY_DB.".hasofferstats
					WHERE `offerurl` = '$url'";
					$resoffer = mysql_query($q) or die(mysql_error());
					if(mysql_num_rows($resoffer) > 0)
					{
						while($row = mysql_fetch_assoc($resoffer))
						{
						  $spends = $row["spends"];				   
						} 
					}
				}
			}
	
		}else{
			$spends = '0';
		}
		echo $spends;
		/*
		if($app_name != '$15+ per hour Jobs Now Hiring in your Area! Click Now! -- CPA (All) - US' || $app_name != 'Register for WhoTrades and Receive $50!')
		{
			$string  = rtrim($spends,',');
			$string = explode(",",$string);
			$string = array_sum ($string);
			$string_new = ($commission / 100) * $string;
			$string = $string + $string_new;
			$q = "SELECT offerid FROM linkixvk_offerwall.usertracking WHERE `offerid` in (select `offerid` from linkixvk_offerwall.offers where `extid`= $admin_id)";
			$res =  mysql_query($q) or die(mysql_error());
			if(mysql_num_rows($res) > 0)
			{
				$row = mysql_fetch_assoc($res);
				$offer_id = $row["offerid"];
				$query = "SELECT sum(IFNULL(`rewardedbid`,0)) as spentamount FROM linkixvk_offerwall.offers WHERE `offerid` =".$offer_id;
				$result =  mysql_query($query) or die(mysql_error());
				$result_row = mysql_fetch_assoc($result);
				$spentamount = $result_row["spentamount"];
				$spentamount1 = number_format($spentamount,2);
				echo $spentamount = $string + $spentamount1;
			} 
			else
			{
				$spentamount = '0';
				echo $spentamount = $string + $spentamount;
			}
		}
		else
		{
			
		}
		*/
	}
	
?>