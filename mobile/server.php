<?php
// prevent the server from timing out
set_time_limit(0);

// include the web sockets server script (the server is started at the far bottom of this file)
require 'RetirelySocket.php';

// when a client sends data to the server
function wsOnMessage($clientID, $message, $messageLength, $binary) {
	global $Server;
	$ip = long2ip( $Server->wsClients[$clientID][6] );

	// check if message length is 0
	if ($messageLength == 0) {
		$Server->wsClose($clientID);
		return;
	}
    $values = explode("Δ", $message);
	$userid = 0;
	$name = "";
	$receiverid = -1;
	$msg = "";
    $time = "";
    $date = "";
	$sender = "";
	if(isset($values[0]))
	{
	    $userid = $values[0];
	}
	if(isset($values[1]))
	{
	    $name = $values[1];
	}
	if(isset($values[2]))
	{
	    $receiverid = $values[2];
	}
	if(isset($values[3]))
	{
	    $msg = $values[3];
	}
    if(isset($values[4]))
	{
	    $time = $values[4];
	}
    if(isset($values[5]))
	{
	    $date = $values[5];
	}
	if(isset($values[6]))
	{
	    $sender = $values[6];
	}
	//$Server->log($values[0]);
	//The speaker is the only person in the room. Don't let them feel lonely.
	//if (sizeof($Server->wsClients) == 1 )
	//	$Server->wsSend($clientID, "There isn't anyone else in the room, but I'll still listen to you. --Your Trusty Server");
	//else
	//{
		//Send the message to everyone but the person who said it
		$IsClientConnected = 0;
		foreach ( $Server->wsClients as $id => $client )
		{			
			if ( $id != $clientID)
			{				
				if($receiverid > 0 && $client[12] == $receiverid)
				{
					$IsClientConnected = 1;
					$Server->wsSend($id, "Visitor $clientID ($ip) said \"$message\"");
					$Server->wsSaveChatHistory($userid, $receiverid, $sender, $message);
				}
			}
			else
			{
				$Server->wsSetUserID($id, $userid, $sender);
			}            	
		}		
		if($receiverid > 0 && $IsClientConnected == 0)
		{						
			$mess = $name." says ".$msg;		
			$Server->wsSentNotification($receiverid,$sender,$mess,$message);
            $Server->wsSaveChatHistory($userid, $receiverid, $sender, $message);			
		}		
	//}		
}

// when a client connects
function wsOnOpen($clientID)
{
	global $Server;
	$ip = long2ip( $Server->wsClients[$clientID][6] );

	$Server->log( "$ip ($clientID) has connected." );

	//Send a join notice to everyone but the person who joined
	foreach ( $Server->wsClients as $id => $client )
		if ( $id != $clientID )
		{
			$Server->wsSend($id, "Visitor $clientID ($ip) has joined the room.");
		}
}

// when a client closes or lost connection
function wsOnClose($clientID, $status) {
	global $Server;
	$ip = long2ip( $Server->wsClients[$clientID][6] );

	$Server->log( "$ip ($clientID) has disconnected." );

	//Send a user left notice to everyone in the room
	foreach ( $Server->wsClients as $id => $client )
		$Server->wsSend($id, "Visitor $clientID ($ip) has left the room.");
}

// start the server
$Server = new RetirelyWebSocket();
$Server->bind('message', 'wsOnMessage');
$Server->bind('open', 'wsOnOpen');
$Server->bind('close', 'wsOnClose');
// for other computers to connect, you will probably need to change this to your LAN IP or external IP,
// alternatively use: gethostbyaddr(gethostbyname($_SERVER['SERVER_NAME']))
$Server->wsStartServer('72.47.226.58', 10000);
//$Server->wsStartServer('127.0.0.1', 9300);

?>