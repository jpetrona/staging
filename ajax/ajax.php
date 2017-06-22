<?php require_once( '../config.php' );
if(isset($_POST['value']))
{

$value=$_POST['value'];
$id=$_POST['id'];
mysql_query("UPDATE offers SET status = '$value' WHERE offerid = $id") or die(mysql_error());
//echo $value;
}
?>
<?php 
$admin_id = $_SESSION["advisorid"];

$sum11 = 'SELECT count(*) as count FROM `offers` WHERE status = "10" and `advisorid` = '.$admin_id;	 
$select_sum11=mysql_query($sum11) or die(mysql_error());
	while($total11=mysql_fetch_array($select_sum11))
	{ ?>
<?php echo $total11['count'];?>
<?php }?>