<?php include('../config.php');
$spentamount=array();
$spentamounts= '';
$spends=0.00;
$fund = array();
$commission = 0.00;
$offerid=$_POST['offerid'];
if(isset($_POST['offer_name']))
{
$offer_name=$_POST['offer_name'];
$q1 = 'SELECT * FROM '.RETIRELY_DB.'.offers WHERE offerid= '.$offerid;	 
$res = mysql_query($q1) or die(mysql_error());
if(mysql_num_rows($res) != 0)
		{
		while($rows=mysql_fetch_array($res))
			{
				 $advisorid = $rows['advisorid'];
				 $commission = $rows['commission'];
			}
		}
		else{
			$advisorid = 172;
			}
if($advisorid == 172)
{
	$q = "SELECT sum(amount) as fund FROM ".RETIRELY_DB.".adminfund WHERE advisorid = $advisorid and status='Complete'";
		$res =  mysql_query($q) or die(mysql_error());
		if(mysql_num_rows($res) > 0)
		{
		  $row = mysql_fetch_assoc($res);
		  $fund = $row["fund"];
		}else{
			$fund[] = 0.00;
			}
	$qoffer= 'select * from '.RETIRELY_DB.'.offers';
	$resultoffer = mysql_query($qoffer) or die(mysql_error());
	if(mysql_num_rows($resultoffer) > 0)
		{
			while($addoffer= mysql_fetch_array($resultoffer))
			{
				$id = $addoffer['offerid'];
				$app_name = $addoffer['title'];
				$commission = $addoffer['commission'];
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
		}else{
			$spends = '0';
			}
	$string  = rtrim($spends,',');
	$string = explode(",",$string);
	$string = array_sum ($string);
	$string_new = ($commission / 100) * $string;
	$string = $string +$string_new;
	$string = number_format($string,2);
	$q = "SELECT offerid FROM ".RETIRELY_DB_OFFERWALL.".usertracking WHERE `offerid` in (select `offerid` from ".RETIRELY_DB_OFFERWALL.".offers where extofferid !=0)";
		$res =  mysql_query($q) or die(mysql_error());
		if(mysql_num_rows($res) > 0)
		{ 
			while($row = mysql_fetch_assoc($res))
			{
				$offer_id = $row["offerid"];
				$query = "SELECT sum(IFNULL(`rewardedbid`,0)) as spentamount, count(*) as counts FROM ".RETIRELY_DB_OFFERWALL.".offers WHERE `offerid` =".$offer_id;
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
			$spend = $string + $spentamounts;
			$spentamount = $spend;
		} 
		else{
				$spentamounts = '0';
				$spend = $string + $spentamounts;
				$spentamount = $spend;
			}
	}
	else{	
	$q = "SELECT sum(amount) as fund FROM ".RETIRELY_DB.".adminfund WHERE advisorid = $advisorid and status='Complete'";
		$res =  mysql_query($q) or die(mysql_error());
		if(mysql_num_rows($res) > 0)
		{
			$row = mysql_fetch_assoc($res);
			if($row["fund"]==''){
				$fund[] = 0.00;
				}
				else{
				  $fund[] = $row["fund"];
				}
		}else{
			$fund[] = 0.00;
			}
//echo $value;
		$qoffer= 'select * from '.RETIRELY_DB.'.offers where offerid = '.$offerid;
		$resultoffer = mysql_query($qoffer) or die(mysql_error());
		if(mysql_num_rows($resultoffer) > 0)
		{
			while($addoffer= mysql_fetch_array($resultoffer))
			{
				$app_name = $addoffer['title'];
				$commission = $addoffer['commission'];
				$url = $addoffer['websiteurl'];
				$q = "SELECT  sum( conversions * rewardbid) AS spend, sum( conversions ) AS paidInstalls, sum( clicks ) AS paidclicks
				FROM ".RETIRELY_DB.".hasofferstats
				WHERE `offerurl` = '$url'";
				$resoffer = mysql_query($q) or die(mysql_error());
				if(mysql_num_rows($resoffer) > 0)
				{
					while($row = mysql_fetch_assoc($resoffer)) 
					{
						$spends = $row["spend"];				   
					} 
				}				
			}	
		}else
		{
			$spends = '0';
		}
		$spentamount = $spends;
		/*
		if($app_name != '$15+ per hour Jobs Now Hiring in your Area! Click Now! -- CPA (All) - US')
		{
			$string  = rtrim($spends,',');
			$string = explode(",",$string);
			$string = array_sum ($string);
			$string_new = ($commission / 100) * $string;
			$string = $string +$string_new;
			$q = "SELECT offerid FROM ".RETIRELY_DB_OFFERWALL.".usertracking WHERE `offerid` in (select `offerid` from ".RETIRELY_DB_OFFERWALL.".offers where `extid`= $advisorid)";
			$res =  mysql_query($q) or die(mysql_error());
			if(mysql_num_rows($res) > 0)
			{
				$row = mysql_fetch_assoc($res);
				$offer_id = $row["offerid"];
				$query = "SELECT sum(IFNULL(`rewardedbid`,0)) as spentamount FROM ".RETIRELY_DB_OFFERWALL.".offers WHERE `offerid` =".$offer_id;
				$result =  mysql_query($query) or die(mysql_error());
				$result_row = mysql_fetch_assoc($result);
				$spentamount = $result_row["spentamount"];
				$spentamount = number_format($spentamount,2);
				$spend = $string + $spentamounts;
				$spentamount = $spend;
			} 
			else
			{
				$spentamount = '0';
				$spend = $string + $spentamounts;
				$spentamount = $spend;
			}
		}
		else
		{
			$spentamount = $spends;
		}
		*/
	}
}
?>
<?php 
	$sum11 = 'SELECT count(*) as count FROM '.RETIRELY_DB.'.offers WHERE status = "10" and offerid= '.$offerid; 
	$select_sum11=mysql_query($sum11);
	if(mysql_num_rows($res) > 0)
	{
		while($total11=mysql_fetch_array($select_sum11))
		{ 
			$runningcamp = $total11['count'];
		}
	}else
	{
		$runningcamp = 0;
	}
//header('Content-type: application/json'); 
$final;
  $final["fund"] =$fund;
  $spentamount = number_format($spentamount,2); 
  $spentamount1 = str_replace(',', '', $spentamount);
  $final["spends"] = $spentamount1;
  $final["runningcamp"] =$runningcamp;   
echo json_encode($final);
?>