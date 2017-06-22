<?php include('in_header.php'); ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="height:450px;">
    <tr>
        <td align="center" valign="middle">
            <table width="400px" border="0" align="center" cellpadding="0" cellspacing="1">
                <tr>        
                    <td style="padding:10px;">                       
                            <table width="100%" border="0" cellpadding="0" cellspacing="2">                                
                                <tr>
                                    <td width="78"><h2>Email*</h2></td>
                                    <td width="6">:</td>
                                    <td width="294"><input name="myusername" type="text" id="myusername" style="width:200px; padding:5px; font-size:16px;"/></td>
                                </tr>
                                <tr>
                                    <td><h2>Password*</h2></td>
                                    <td>:</td>
                                    <td><input name="mypassword" type="password" id="mypassword" style="width:200px; padding:5px; font-size:16px;" /></td>
                                </tr>
                                <tr>
                                    <td><a href="forgetpassword.php">Forgetpassword</a></td>
                                    <td>&nbsp;</td>
                                    <td><input type="submit" name="Submit" value="Login" onclick="DoLogin()"></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td style="color:red;"><span id="spanerror"></span></td>
                                </tr>
                            </table>                       
                    </td>        
                </tr>
            </table>
        </td>	
    </tr>	
</table>
<?php include('in_footer.php'); ?>