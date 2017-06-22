<?php
//session_start();
$conn=mysql_connect("internal-db.s169264.gridserver.com","db169264","Retirely@11");
if(!$conn)
{
  die('could not connect:'.mysql_error());
}
mysql_select_db("db169264_retirelynew",$conn);
?>