<?php ob_start();session_start();
	define('DISTANT_URL', dirname( dirname( ( dirname( dirname(__FILE__) ) ) ) ).'/retire.ly'  );
	define('DISTANT_HTTP_URL', 'http://retire.ly' );

 


if($_SERVER['HTTP_HOST']=="localhost")
	{
		$conn=mysql_connect("localhost","root","" , true );
		if(!$conn)
		{
		  die('could not connect:'.mysql_error());
		}
		mysql_select_db("retirely",$conn); 
		define( "RETIRELY_DB" , "retirely" );
		define( "RETIRELY_DB_OFFERWALL" , "linkixvk_offerwall" );
	}
	elseif($_SERVER['HTTP_HOST']=="projects.linkites.com"){
				$conn=mysql_connect("localhost","linkixvk_retire","retire" , true );
				if(!$conn)
				{
				  die('could not connect:'.mysql_error());
				}
				mysql_select_db("linkixvk_retirelynew",$conn);
				define( "RETIRELY_DB" , "linkixvk_retirelynew" );
				define( "RETIRELY_DB_OFFERWALL" , "linkixvk_offerwall" );
	}
	else
	{
		$conn=mysql_connect("internal-db.s169264.gridserver.com","db169264","Retirely@11" , true );
		if(!$conn)
		{
		  die('could not connect:'.mysql_error());
		}
		mysql_select_db("db169264_retirelynew",$conn);
		define( "RETIRELY_DB" , "db169264_retirelynew" );
		define( "RETIRELY_DB_OFFERWALL" , "db169264_offerwall" );
	}

	if ( !defined('MYPATH') )
		define('MYPATH', dirname( dirname(__FILE__) ). '/');

	?>