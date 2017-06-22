<?php
OnLoad();
class funcs_code 
{
   var $conn="";
   var $dba="db169264_retirelynew"; 
   var $host="internal-db.s169264.gridserver.com";
   var $user="db169264";
   var $pass="Retirely@11";  
  
   public function connection()
   {
      $this->conn=mysql_connect($this->host,$this->user,$this->pass) or die(mysql_error());	
      $this->dba=mysql_select_db($this->dba,$this->conn) or die(mysql_error());	
   }
   	
   public function query($sql_q)
   {
      $result=mysql_query($sql_q);
      if(!$result){die(mysql_error());}else{return $result;}
   }  
}
   
function OnLoad()
{
    $method = $_GET['method'];
    if($method == 'SetOnline')
    {
	SetOnline();
    }   
    else if ($method == 'SetOffline')
    {
	SetOffline();
    }
    else if ($method == 'SendNotification')
    {
        SendNotification();
    }
    else if ($method == 'SaveChatHistory')
    {
        SaveChatHistory();
    }
    else if ($method == 'send_notification')
    {
        send_notification();
    } 

} 

function SetOnline()
{
    $obj=new funcs_code();
    $obj->connection();	
    $output = "0";
    $id = $_GET["id"];
    $usertype = $_GET["usertype"];
    if($usertype == 'advisor')
    {
        $q = "UPDATE advisors SET online = '1' WHERE advisorid = $id";
    }
    else if($usertype == 'user')
    {
       $q = "UPDATE users SET online = '1' WHERE userid = $id";
    }
    mysql_query($q);
    $output = "1";    
    echo json_encode($output);
}

//For Sign Out
function SetOffline()
{
    $obj=new funcs_code();
    $obj->connection();	
    $output = "0";
    $id = $_GET["id"];
    $usertype = $_GET["usertype"];
    if($usertype == 'advisor')
    {
        $q = "UPDATE advisors SET online = '0' WHERE advisorid = $id";
    }
    else if($usertype == 'user')
    {
       $q = "UPDATE users SET online = '0' WHERE userid = $id";
    }
    mysql_query($q);
    $output = "1";
    echo json_encode($output);
}

function SendNotification()
{
    $obj=new funcs_code();
    $obj->connection();
    $id = 0;
    $deviceToken = "";
    $message = "";
    $custmsg = "";
    if(isset($_POST["id"]))
    {
        $id = $_POST["id"];
    }
    if(isset($_POST["msg"]))
    {
        $message = mysql_real_escape_string($_POST["msg"]);
    }
    if(isset($_POST["custmsg"]))
    {
        $custmsg = $_POST["custmsg"];
    }
    if(isset($_POST["usertype"]))
    {
        $usertype= $_POST["usertype"];
    }
    $msg = substr($message, 0, 100);
    $completemessage = str_replace($message, "", $custmsg);

    if($usertype == 'advisor')
    {
       $q = "SELECT * FROM users WHERE userid = $id";
    }
    else if($usertype == 'user')
    {       
       $q = "SELECT * FROM advisors WHERE advisorid = $id";
    }
    $res = mysql_query($q);		
    if(mysql_num_rows($res) > 0)
    {  
       $row = mysql_fetch_assoc($res);
       $status = $row["online"];
       $deviceToken = $row["devicetoken"];
       $devicetype = $row["devicetype"];    
       if(strtolower($devicetype) == "ios")
       {
          $deviceToken = str_replace("<","",$deviceToken);
          $deviceToken = str_replace(">","",$deviceToken);
          $deviceToken = str_replace(" ","",$deviceToken);
          $deviceToken = $deviceToken;
          iospushnotification($deviceToken,$msg,$completemessage);
       }
       else
       {
          androidpushnotification($deviceToken,$msg,$completemessage);
       }
   }
}

function iospushnotification($deviceToken ,$msg, $completemessage)
{ 
   //$deviceToken = '9f1896e0ed423971104e65994c04df266fe694dbe4b899028f19e3851985dd0d';
   //$message = "Hello Mr. Granade! message from memoji appp.";
   $passphrase = 'linkites';
   $payload['aps'] = array(
		'alert' => $msg,
		'badge' => 1, 
		'sound' => 'default'
	);
	$payload['custmsg'] = $completemessage;   
	$payload = json_encode($payload);
	//gateway.sandbox.push.apple.com pls use gateway.push.apple.com for production environment 
	$apnsHost = 'gateway.push.apple.com'; 
	$apnsPort = 2195;
	$apnsCert = 'retirely_production.pem'; //change production certificate
	//$apnsCert = 'RetirelyCertificates_Dec_12_2013Dev.pem';
	$streamContext = stream_context_create();
	stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
	//stream_context_set_option($streamContext, 'ssl', 'passphrase', $passphrase);
	$apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error,$errorString,60,STREAM_CLIENT_CONNECT,$streamContext); 
	$apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', $deviceToken) . chr(0) . chr(strlen($payload)) . $payload;
	fwrite($apns, $apnsMessage);
	@socket_close($apns);
	fclose($apns);
}

function androidpushnotification($deviceToken ,$msg, $completemessage) 
{ 
        $registatoin_ids[0] = $deviceToken;
                        
        $GOOGLE_API_KEY = "AIzaSyAZNPIhO5xv7ULaFoJ9OtGD8Ung4SevAQ4"; 
       
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';
 
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => array( "message" => $msg, "custmsg" => $completemessage),
         );
 
        $headers = array(
            'Authorization: key=' . $GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
        echo $result;
}

function send_notification() 
{
   $deviceToken = "APA91bFUNVk41aZfho0NVe5ez3SsezZ-Fs3S3a-tMojeWzaGFwOUIRXjzBb06Fo62J7ChfPjrZEZU0FN0YeENw3AYel4Ez-H40UYyNQlNaMlab0J-Il0IG_T-itvrj1yDB0g-QyuOSj0K9ZajyfCPtThoHWHw_0bdw";
$msg = "This is a testing message sent from retirely live server.";
$completemessage = "testing message sent from retirely live server.";
echo $deviceToken;
   androidpushnotification($deviceToken,$msg,$completemessage);
}
function SaveChatHistory()
{
    $obj=new funcs_code();
    $obj->connection();	
    $output = "0";
    $date = date('Ymd');
	$chatdate = date('YmdHis');
    $advisorid = 0;
    $userid = 0;
    $senderid = $_POST["senderid"];
    $receiverid = $_POST["receiverid"];
    $sender = $_POST["sender"];
    $message = $_POST["message"];
    if($sender == 'advisor')
    {
       $advisorid = $senderid; 
       $userid = $receiverid;
    }
    else if($sender == 'user')
    {
       $advisorid = $receiverid; 
       $userid = $senderid;
    }
    if($advisorid > 0 && $userid > 0)
    {
       $q = "SELECT * FROM chats WHERE advisorid = $advisorid AND userid = $userid AND date = '$date'";
       $res = mysql_query($q);		
       if(mysql_num_rows($res) > 0)
       { 
           $row = mysql_fetch_assoc($res);   
           $id = $row["id"];
           $msg = $row["message"];
           $chatmessage = $msg."\n".$message;
           $q = "UPDATE chats SET message = '".mysql_real_escape_string($chatmessage)."', chatdate='{$chatdate}' 
		   WHERE id = $id";
           mysql_query($q);
           $output = "1";
       }
       else
       {	
           $q = "INSERT INTO chats VALUES ('',$advisorid,$userid,'".mysql_real_escape_string($message)."','{$date}',
		   '{$chatdate}')";
	       mysql_query($q);
           $output = "1";			
	
       }
    }
    echo json_encode($output);
}
?>