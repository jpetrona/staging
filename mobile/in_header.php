<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Adminstrator Control Panel</title>
<link href="css/master.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<link href="css/datePicker.css" rel="stylesheet" type="text/css" />
<?php include('config.php');
include_once("ps_pagination.php");?>
</head>
<body style="text-align:center; width:100%; margin:0px;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" style="padding-top:5px;">
	<!-- Universal Header :::::::::::::: -->
			<div class="main">		
			<!-- header (left) :::::::::: -->
				<?php /*?><div class="hleft"><?php */?>
                	
                       <table border="0" cellpadding="0" cellspacing="0" width="100%" class="header">
                        <tr>
                        	<td align="left" valign="middle">
                            	<?php
								if(isset($_SESSION["admin_id"]) == ""){?>                                	
                                	<table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                    		
                        				<td align="left" valign="bottom" style="padding-bottom: 10px;">
                                        	<img src="images/logo.png" alt="logo"  style="width:340px;"/>
                                           
                                        </td>	
                                    </tr>	
                                    </table>                                   
                                 <?php }else{?>
                            		<table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                    	<td></td>	
                        				<td align="left" valign="bottom" style="padding-top:7px;">
                                        	<img src="images/logo.png" alt="logo"  style="width:340px"/>
                                        </td>	
                                    </tr>	
                                    </table>  
                                  <?php }?>
                            </td>                                                     	
                    	</tr>
                        </table>	
                        <?php
						if(isset($_SESSION["admin_id"]) != ""){?>
                        <table border="0" cellpadding="5" cellspacing="0" width="100%"  class="toplinks">
                            <tr>
                                <td align="right" valign="middle">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>   
                                            <td class="items right-border"><a href="promocode.php">Promo Codes</a></td>	
<td class="items right-border"><a href="appversions.php">App Versions</a></td>														
                                            <td class="items right-border"><a href="users.php">Users</a></td>
                                            <td class="items right-border"><a href="advisors.php">Advisors</a></td>
                                            <td class="items"><a href="logout.php" title="Sign Out">Sign Out</a></td>
                                        </tr>
                                    </table>
                                </td>	
                        	</tr>	
                        </table>
                        <?php }?>
				<?php /*?></div><?php */?><!-- /hleft -->
        </div>
        <div class="content">