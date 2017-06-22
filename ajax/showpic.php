<?php


	define('DISTANT_URL', dirname(dirname( ( dirname( dirname(__FILE__) ) ) )).'/retire.ly/html'  );
	define('DISTANT_HTTP_URL', 'http://retire.ly' );

if ( !defined('MYPATH') )
		define('MYPATH', dirname( dirname(__FILE__) ). '/');

require_once(MYPATH . 'wp-load.php');
require_once(MYPATH . '/wp-admin/includes/file.php');
?>

<?php
	$name     = $_FILES["image"]["name"];
    $temp_name  = $_FILES['image']['tmp_name'];  
    if(isset($name))
	{
        if(!empty($name))
		{ 
				 
				 $location = DISTANT_URL.'/upload/'; 
	  			 str_replace( "\\", "/", $location );
	  			 
				 $correctname = $location.$name;
                
				 str_replace( '\\', '/', $correctname );
 
				if( move_uploaded_file( $temp_name, $correctname  ) )
				{		

					$_SESSION['img_name'] = 'upload/'.$name;
					echo $img_name = DISTANT_HTTP_URL.'/'.$_SESSION['img_name'];
					$_SESSION['url'] = $img_name;
					$_SESSION['img_name'] = $img_name;
				 
				}
				else
				{
					echo "not moved";
				}
		}
    }  
	else 
	{
        echo 'please upload';
    }
?>