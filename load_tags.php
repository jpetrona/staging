<?php
    $x = $_REQUEST['word'];
    $url = 'http://d.yimg.com/autoc.finance.yahoo.com/autoc?query='.$x.'&callback=YAHOO.Finance.SymbolSuggest.ssCallback';
  
    $ch = curl_init();
       // set url
        curl_setopt($ch, CURLOPT_URL, $url );

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);
        
        // close curl resource to free up system resources
        curl_close($ch);    
        $output = str_replace("YAHOO.Finance.SymbolSuggest.ssCallback(", "", $output );
        $output = substr($output , 0 , strlen( $output ) - 1 );

        $arr = json_decode( $output );
       
          $output = json_encode( $arr->ResultSet->Result  );


        echo $output;         
        exit();

?>