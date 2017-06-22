<?php
define("dba","db169264_retirely");
define("host","internal-db.s169264.gridserver.com");
define("user","db169264");
define("pass","Id6ZpIb9e0oT3Z");
function connection()
{
 $conn=mysql_connect(host,user,pass) or die(mysql_error());
 $dba=mysql_select_db(dba,$conn) or die(mysql_error()); 
}

function AppVersion()
{
	connection();
	$output = "";
	$id = $_POST["id"];
	$version = $_POST["version"];
	$url = $_POST["url"];
    $message = $_POST["message"];
	$date = date("YmdHis");	
		
	if($id != "0")
	{
		$q = "UPDATE appversion SET url = '$url', version = '$version', message = '$message' WHERE id = $id";	

		if(mysql_query($q))
		{			
			$output = "Record updated successfully.";		
		}
		else
		{
		   $output = "Error in processing request. Please try again.";		
		}
	}
	
	return $output; 
}

