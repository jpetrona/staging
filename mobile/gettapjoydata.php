<?php
//function getStatistics(){
$conn=mysql_connect("internal-db.s169264.gridserver.com","db169264","Id6ZpIb9e0oT3Z");
//$conn=mysql_connect("localhost","root","");
if(!$conn)
{
  die('could not connect:'.mysql_error());
}
mysql_select_db("db169264_retirelynew",$conn);
//echo dirname(__FILE__); die;
/*for($i=28;$i<=29;$i++)
{
$date = Date('2014-04-'.$i);*/
$date = date("Y-m-d");
$url = "https://api.tapjoy.com/reporting_data.xml?email=admin%40intlfaces.com&api_key=7894974590ac4f059c23cb38e22b1d08&date=".$date;
	$xml = simplexml_load_file($url);
	$date = $xml->Date;		
	//$xml=simplexml_load_file("test.xml");
	//echo '<pre>';
	//print_r($xml);
    //var_dump($xml);
	?>
    <?php
		foreach ($xml->App as $xml_data) 
		{
			$Name        				 = $xml_data->Name;
			$AppKey       				 = $xml_data->AppKey;
			$url            			 = $xml_data->url;
			$Platform           		 = $xml_data->Platform;
			$PaidInstalls          		 = $xml_data->PaidInstalls;
			$PaidInstallsHourly      	 = $xml_data->PaidInstallsHourly;
			$PaidClicks     			 = $xml_data->PaidClicks;
			$PaidClicksHourly       	 = $xml_data->PaidClicksHourly;
			$Spend       				 = $xml_data->Spend;
			$SpendHourly             	 = $xml_data->SpendHourly;
			$Sessions        			 = $xml_data->Sessions;
			$SessionsHourly  		  	 = $xml_data->SessionsHourly;
			$NewUsers 		 			 = $xml_data->NewUsers;
			$NewUsersHourly   			 = $xml_data->NewUsersHourly;
			$DailyActiveUsers        	 = $xml_data->DailyActiveUsers;
			$OfferwallRevenue   		 = $xml_data->OfferwallRevenue;
			$OfferwallRevenueHourly 	 = $xml_data->OfferwallRevenueHourly;
			$OfferwallImpressions 		 = $xml_data->OfferwallImpressions;
			$OfferwallImpressionsHourly  = $xml_data->OfferwallImpressionsHourly;
			$OfferwallClicks 		  	 = $xml_data->OfferwallClicks;
			$OfferwallClicksHourly 		 = $xml_data->OfferwallClicksHourly;
			$OfferwallConversions        = $xml_data->OfferwallConversions;
			$OfferwallConversionsHourly  = $xml_data->OfferwallConversionsHourly;
			$FeaturedOfferRevenue 	  	 = $xml_data->FeaturedOfferRevenue;
			$FeaturedOfferRevenueHourly  = $xml_data->FeaturedOfferRevenueHourly;
			$FeaturedOfferRequests    	 = $xml_data->FeaturedOfferRequests;
			$FeaturedOfferRequestsHourly = $xml_data->FeaturedOfferRequestsHourly;
			$FeaturedOfferImpressions    = $xml_data->FeaturedOfferImpressions;
			$FeaturedOfferImpressionsHourly = $xml_data->FeaturedOfferImpressionsHourly;
			$FeaturedOfferClicks 			= $xml_data->FeaturedOfferClicks;
			$FeaturedOfferClicksHourly 		= $xml_data->FeaturedOfferClicksHourly;
			$FeaturedOfferConversions    	= $xml_data->FeaturedOfferConversions;
			$FeaturedOfferConversionsHourly = $xml_data->FeaturedOfferConversionsHourly;
			$DisplayRevenue      			= $xml_data->DisplayRevenue;
			$DisplayRevenueHourly        	= $xml_data->DisplayRevenueHourly;
			$DisplayRequests       			= $xml_data->DisplayRequests;
			$DisplayRequestsHourly       	= $xml_data->DisplayRequestsHourly;
			$DisplayImpressions        		= $xml_data->DisplayImpressions;
			$DisplayImpressionsHourly 		= $xml_data->DisplayImpressionsHourly;
			$DisplayClicks 					= $xml_data->DisplayClicks;
			$DisplayClicksHourly 			= $xml_data->DisplayClicksHourly;
			$DisplayConversions 			= $xml_data->DisplayConversions;
			$DisplayConversionsHourly 		= $xml_data->DisplayConversionsHourly;
			$TJMOfferwallRevenue 			= $xml_data->TJMOfferwallRevenue;
			$TJMOfferwallRevenueHourly 		= $xml_data->TJMOfferwallRevenueHourly;
			$TJMOfferwallImpressions 		= $xml_data->TJMOfferwallImpressions;
			$TJMOfferwallImpressionsHourly 	= $xml_data->TJMOfferwallImpressionsHourly;
			$TJMOfferwallClicks 			= $xml_data->TJMOfferwallClicks;
			$TJMOfferwallClicksHourly 		= $xml_data->TJMOfferwallClicksHourly;
			$TJMOfferwallConversions 		= $xml_data->TJMOfferwallConversions;
			$TJMOfferwallConversionsHourly 	= $xml_data->TJMOfferwallConversionsHourly;
			
			$Name	  					 = (string)$Name;
			$AppKey  					 = (string)$AppKey;
			$url      					 = (string)$url;
			$Platform    				 = (string)$Platform;
			$PaidInstalls      			 = (string)$PaidInstalls;
			$PaidInstallsHourly 		 = (string)$PaidInstallsHourly;
			$PaidClicks     			 = (string)$PaidClicks;
			$PaidClicksHourly       	 = (string)$PaidClicksHourly;
			$Spend       				 = (string)$Spend;
			$SpendHourly             	 = (string)$SpendHourly;
			$Sessions        			 = (string)$Sessions;
			$SessionsHourly  		  	 = (string)$SessionsHourly;
			$NewUsers 		 			 = (string)$NewUsers;
			$NewUsersHourly   			 = (string)$NewUsersHourly;
			$DailyActiveUsers        	 = (string)$DailyActiveUsers;
			$OfferwallRevenue   		 = (string)$OfferwallRevenue;
			$OfferwallRevenueHourly 	 = (string)$OfferwallRevenueHourly;
			$OfferwallImpressions 		 = (string)$OfferwallImpressions;
			$OfferwallImpressionsHourly  = (string)$OfferwallImpressionsHourly;
			$OfferwallClicks 		  	 = (string)$OfferwallClicks;
			$OfferwallClicksHourly 		 = (string)$OfferwallClicksHourly;
			$OfferwallConversions        = (string)$OfferwallConversions;
			$OfferwallConversionsHourly  = (string)$OfferwallConversionsHourly;
			$FeaturedOfferRevenue 	  	 = (string)$FeaturedOfferRevenue;
			$FeaturedOfferRevenueHourly  = (string)$FeaturedOfferRevenueHourly;
			$FeaturedOfferRequests    	 = (string)$FeaturedOfferRequests;
			$FeaturedOfferRequestsHourly = (string)$FeaturedOfferRequestsHourly;
			$FeaturedOfferImpressions    = (string)$FeaturedOfferImpressions;
			$FeaturedOfferImpressionsHourly = (string)$FeaturedOfferImpressionsHourly;
			$FeaturedOfferClicks 			= (string)$FeaturedOfferClicks;
			$FeaturedOfferClicksHourly 		= (string)$FeaturedOfferClicksHourly;
			$FeaturedOfferConversions    	= (string)$FeaturedOfferConversions;
			$FeaturedOfferConversionsHourly = (string)$FeaturedOfferConversionsHourly;
			$DisplayRevenue      			= (string)$DisplayRevenue;
			$DisplayRevenueHourly        	= (string)$DisplayRevenueHourly;
			$DisplayRequests       			= (string)$DisplayRequests;
			$DisplayRequestsHourly       	= (string)$DisplayRequestsHourly;
			$DisplayImpressions        		= (string)$DisplayImpressions;
			$DisplayImpressionsHourly 		= (string)$DisplayImpressionsHourly;
			$DisplayClicks 					= (string)$DisplayClicks;
			$DisplayClicksHourly 			= (string)$DisplayClicksHourly;
			$DisplayConversions 			= (string)$DisplayConversions;
			$DisplayConversionsHourly 		= (string)$DisplayConversionsHourly;
			$TJMOfferwallRevenue 			= (string)$TJMOfferwallRevenue;
			$TJMOfferwallRevenueHourly 		= (string)$TJMOfferwallRevenueHourly;
			$TJMOfferwallImpressions 		= (string)$TJMOfferwallImpressions;
			$TJMOfferwallImpressionsHourly 	= (string)$TJMOfferwallImpressionsHourly;
			$TJMOfferwallClicks 			= (string)$TJMOfferwallClicks;
			$TJMOfferwallClicksHourly 		= (string)$TJMOfferwallClicksHourly;
			$TJMOfferwallConversions 		= (string)$TJMOfferwallConversions;
			$TJMOfferwallConversionsHourly 	= (string)$TJMOfferwallConversionsHourly;	
			//$original_url = $url;
/*function curl_exec_follow($ch, &$maxredirect = null) {
  
  // we emulate a browser here since some websites detect
  // us as a bot and don't let us do our job
  $user_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5)".
                " Gecko/20041107 Firefox/1.0";
  curl_setopt($ch, CURLOPT_USERAGENT, $user_agent );

  $mr = $maxredirect === null ? 5 : intval($maxredirect);

  if (ini_get('open_basedir') == '' && ini_get('safe_mode') == 'Off') {

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $mr > 0);
    curl_setopt($ch, CURLOPT_MAXREDIRS, $mr);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

  } else {
    
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);

    if ($mr > 0)
    {
      $original_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
      $newurl = $original_url;
      
      $rch = curl_copy_handle($ch);
      
      curl_setopt($rch, CURLOPT_HEADER, true);
      curl_setopt($rch, CURLOPT_NOBODY, true);
      curl_setopt($rch, CURLOPT_FORBID_REUSE, false);
      do
      {
        curl_setopt($rch, CURLOPT_URL, $newurl);

        ob_start();
        curl_exec($rch);
        $header = ob_get_contents();
        ob_end_flush();

        if (curl_errno($rch)) {
          $code = 0;
        } else {
          $code = curl_getinfo($rch, CURLINFO_HTTP_CODE);
          if ($code == 301 || $code == 302) {
            preg_match('/Location:(.*?)\n/', $header, $matches);
            $newurl = trim(array_pop($matches));
            
            // if no scheme is present then the new url is a
            // relative path and thus needs some extra care
            if(!preg_match("/^https?:/i", $newurl)){
              $newurl = $original_url . $newurl;
            }   
          } else {
            $code = 0;
          }
        }
      } while ($code && --$mr);
      
      curl_close($rch);
      
      if (!$mr)
      {
        if ($maxredirect === null)
        trigger_error('Too many redirects.', E_USER_WARNING);
        else
        $maxredirect = 0;
        
        return false;
      }
      curl_setopt($ch, CURLOPT_URL, $newurl);
    }
  }

  ob_start();
  curl_exec($ch);
  $ret = ob_get_contents();
  ob_end_flush(); 

  return $ret;
}*/
			/*$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Must be set to true so that PHP follows any "Location:" header
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			$a = curl_exec($ch); // $a will contain all headers
			
			$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL); // This is what you need, it will return you the last effectiveURL*/
			 /*$url1 = "http://itunes.apple.com/search?term=".$Name."&media=software";
			 $fields = array(
			 	term=>$Name,
			  	media=>'software'
				);
			   $ch = curl_init();
			   // Set the url, number of POST vars, POST data
			   curl_setopt($ch, CURLOPT_URL, $url1);
			   curl_setopt($ch, CURLOPT_POST, true);
			   curl_setopt($ch, CURLOPT_HTTPHEADER, array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15"));
			   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			   // Disabling SSL Certificate support temporarly
			   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
			   // Execute post
			   echo $result = curl_exec($ch);
			   die;*/
			$sql="SELECT * FROM reporting_cart WHERE url='$url' and date = '$date'";
			$result=mysql_query($sql) or die(mysql_error());
			$row=mysql_fetch_row($result);
			$id = $row[0];
			if($row){			
				$sql = mysql_query("UPDATE `reporting_cart` SET `name`='".$Name."',`url`='".$url."',`platform`='".$Platform."',`paidInstalls`='".$PaidInstalls."',`paidclicks`='".$PaidClicks."',`spend`='".abs($Spend)."',`spendhourly`='".$SpendHourly."',`sessions`='".$Sessions."',`sessionshourly`='".$SessionsHourly."',`newusers`='".$NewUsers."',`newusershourly`='".$NewUsersHourly."',`dailyactiveusers`='".$DailyActiveUsers."',`offerwallrevenue`='".$OfferwallRevenue."',`offerwallrevenuehourly`='".$SessionsHourly."',`offerwallImpressions`='".$OfferwallImpressions."',`offerwallImpressionshourly`='".$OfferwallImpressionsHourly."',`offerwallclicks`='".$OfferwallClicks."',`offerwallclickshourly`='".$OfferwallClicksHourly."',`offerwallconversions`='".$OfferwallConversions."',`date`='".$date."' WHERE id = '$id'") or die(mysql_error());
		echo 'Update<br>';
				}
				else
				{
			$sql = "INSERT INTO `reporting_cart`(`id`, `name`, `url`, `platform`, `paidInstalls`, `paidclicks`, `spend`, `spendhourly`, `sessions`, `sessionshourly`, `newusers`, `newusershourly`, `dailyactiveusers`, `offerwallrevenue`, `offerwallrevenuehourly`, `offerwallImpressions`, `offerwallImpressionshourly`, `offerwallclicks`, `offerwallclickshourly`, `offerwallconversions`,`date`) VALUES (NULL,'".$Name."','".$url."','".$Platform."','".$PaidInstalls."','".$PaidClicks."','".abs($Spend)."','".$SpendHourly."','".$Sessions."','".$SessionsHourly."','".$NewUsers."','".$NewUsersHourly."','".$DailyActiveUsers."','".$OfferwallRevenue."','".$OfferwallRevenueHourly."','".$OfferwallImpressions."','".$OfferwallImpressionsHourly."','".$OfferwallClicks."','".$OfferwallClicksHourly."','".$OfferwallConversions."','".$date."')";
			
			mysql_query($sql) or die(mysql_error());
			echo 'success<br>';
				}
	} 
	$query = "INSERT INTO `errorException`(`id`, `error_msg`, `date`) VALUES (NULL,'update',now())";
	mysql_query($query) or die(mysql_error());
//}

/*sleep(60000*60); // wait for 1 hour
getStatistics(); // call this function again
}*/
?>