<?php include('in_header.php'); ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="height:450px;">
    <tr>
        <td align="center" valign="middle">
            <table width="400px" border="0" align="center" cellpadding="0" cellspacing="1">
                <tr>        
                    <td style="padding:10px;"> 
                    <?php if(isset($_POST['submit'])){
						$email = $_POST['email'];
						$subject = 'Forgot Password';
						$headers = "MIME-Version: 1.0" . "\r\n";
						$message = '<b>Hi User</b>,<br />
						<br />
					
					To Reset Your password please click on the below link :<br /><br />
					
					http://retire.ly/mobile/resetpassword.php?email='.$email.'<br /><br />
					
					
					For Support :<br /><br />
					
					You can also mail us directly at info@retire.ly, or call us at 805-284-9336.<br /><br /><br />Support Team,<br /><b>retire.ly </b>';
					$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
					$headers .= 'From: retire.ly <info@retire.ly>' . "\r\n";
					$success = mail($email,$subject,$message,$headers); ?>
                    <!--<p>Congratulation! your password has been Updated.</p>-->
                    <p>Please check your email. Click on the link sent in the mail to reset your password.</p><br />
                   	Click here: <a href="index.php">Login</a>
                    <p>&nbsp;</p>
                    <br />
						<?php } else { ?>  
                        <form method="post">                    
                            <table width="100%" border="0" cellpadding="0" cellspacing="2">                                
                                <tr>
                                    <td width="78"><h2>Registered Email:</h2></td>
                                    <td width="6">:</td>
                                    <td width="294"><input id="username" type="email" name="email" required></td>
                                </tr>
                                <tr>
                                    <td><a href="index.php">Login</a></td>
                                    <td>&nbsp;</td>
                                    <td><button name="submit" type="submit" class="btn btn-default btn-main">Submit</button></td>
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