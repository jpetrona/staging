<?php include('in_header.php');
$email = $_GET['email']; ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="height:450px;">
    <tr>
        <td align="center" valign="middle">
            <table width="400px" border="0" align="center" cellpadding="0" cellspacing="1">
                <tr>        
                    <td style="padding:10px;"> 
                    <?php  if(isset($_POST['submit']))
				  			{
							//$email = $_POST['email'];
							$confirm_password = $_POST['confirm_password'];
							$password = $_POST['password'];
							if($confirm_password == $password){
							$sql="SELECT * FROM adminusers WHERE email='$email'";
							$result=mysql_query($sql);
							$row=mysql_fetch_row($result);
							$username = $row['1'];
							$password = md5($password);
							$sql1="UPDATE `adminusers` SET `password`= '$password' WHERE `email`= '$email'";
							$result1=mysql_query($sql1) or die(mysql_error());
							$subject = 'Reset Password';
							$headers = "MIME-Version: 1.0" . "\r\n";
							$message = '<b>Hi '.$username.'</b>,<br />
							<br />
								Thank you  !<br /><br />
								
								
								Your Password has been updated successfully, To check your login access please click on below link<br /><br />
								
								http://retire.ly/mobile/index.php<br /><br />
								
								
								For Support :<br /><br />
								
								You can also mail us directly at admin@intlfaces.com, or call us at 805-284-9336.<br /><br /><br />Support Team,<br /><b>retire.ly </b>';
								$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
								$headers .= 'From: retire.ly <info@retire.ly>' . "\r\n";
								$success = mail($email,$subject,$message,$headers);
								}else{
									echo "<p>Confirm password and password does not matched!</p>";
									}
								?>
                                    <p>Congratulations! Your password has been updated successfully.</p>
									<br />
                                    Click here: <a href="index.php">Login</a>
                                    <p>&nbsp;</p>
							<?php }else{?>
                        <form method="post">                    
                            <table width="100%" border="0" cellpadding="0" cellspacing="2">                                
                                <tr>
                                    <td width="78"><h2>Password:</h2></td>
                                    <td width="6">:</td>
                                    <td width="294"><input id="password" type="password" name="password" required></td>
                                </tr>
                                <tr>
                                    <td width="78"><h2>Confirm Password:</h2></td>
                                    <td width="6">:</td>
                                    <td width="294"><input id="password" type="password" name="confirm_password" required></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><button name="submit" type="submit" class="btn btn-default btn-main">Reset</button></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td style="color:red;"><span id="spanerror"></span></td>
                                </tr>
                            </table> 
                            </form> 
                             <?php } ?>                      
                    </td>        
                </tr>
            </table>
        </td>	
    </tr>	
</table>
<?php include('in_footer.php'); ?>