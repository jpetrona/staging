<?php
/*// Create a curl handle
$ch = curl_init('http://www.yahoo.com/');

// Execute
curl_exec($ch);

// Check if any error occurred
if(!curl_errno($ch))
{
 $info = curl_getinfo($ch);

 echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'];
}

// Close handle
curl_close($ch);*/
?>
 <?php
    //echo dirname(__FILE__);
    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, "http://retire.ly/mobile/gettapjoydata.php");
    curl_exec ($curl);
    curl_close ($curl);
?> 
