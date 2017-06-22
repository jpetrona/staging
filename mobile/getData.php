<?php
$conn=mysql_connect("internal-db.s169264.gridserver.com","db169264","Id6ZpIb9e0oT3Z");
//$conn=mysql_connect("localhost","root","");
if(!$conn)
{
  die('could not connect:'.mysql_error());
}
mysql_select_db("db169264_retirelynew",$conn);
$query = "INSERT INTO `errorException`(`id`, `error_msg`, `date`) VALUES (NULL,'update',now())";
mysql_query($query) or die(mysql_error());
?>