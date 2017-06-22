<?php 
session_start();
if($_SESSION["myusername"]=="" && $_SESSION["mypassword"]=="")
{
	header("location:index.php");
} 
include('in_header.php');
include('action.php');
$error='';
if(isset($_POST["submit"])=="Submit")
{
	$error = AppVersion();
}
?>
<?php
$id = 0;
if(isset($_GET["id"]) != "")
{
	$id = $_GET["id"];
}
$str="SELECT * FROM appversion where id = $id";
$result=mysql_query($str);
$rn = mysql_num_rows($result);
if($rn!="0")
{
	$row = mysql_fetch_assoc($result);
	$id = $row["id"];
	$version = $row["version"];
	$url = $row["url"];
	$message = $row["message"];
}
?>	
 <div class="right">      
    <div class="center_mess">App Version</div>
    	<form method="post" enctype="multipart/form-data">
        <table width="100%" border="0" cellspacing="2" cellpadding="5" style="text-align:left;vertical-align:top; margin">   
        <tr>
			<td valign="top" class="lable" width="120px;">Version*:</td>
			<td width="350px;"><input type="text" name="version" id="version" value="<?php echo $version; ?>" class="maxwidth" required></input></td>
			<td></td>
        </tr>
		<tr>
				<td valign="top" class="lable">Download Url*:</td>
				<td><input type="text" name="url" id="url" value="<?php echo $url; ?>" class="maxwidth" required></input></td>
			</tr>
		<tr>
			<td valign="top" class="lable">Description:</td>
			<td><textarea name="message" id="message" rows="7" cols="41" required><?php echo $message; ?></textarea></td>
			<td></td>
		</tr>      
        <tr>
			<td></td>
			<td align="left" style="padding-top:10px;" colspan="2"><input type="submit" name="submit" id="submit" value="Submit"></td></tr>
        <tr>
			<td></td>
			<td align="left" style="padding-top:10px;" colspan="2"><?php if(isset($error)){echo "<P>".$error."</p>";}?></td></tr>
        </table>
        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
        </form>			
</div><!-- /right -->
<?php include('in_footer.php'); ?>