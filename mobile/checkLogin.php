<?php
session_start();
include_once('config.php');
// username and password sent from form
$myusername=$_GET['un'];
$mypassword=md5($_GET['pwd']);
// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);

$sql="SELECT * FROM adminusers WHERE username='$myusername' AND password='$mypassword' AND status=10";

$result=mysql_query($sql);
$row=mysql_fetch_row($result);
// Mysql_num_row is counting table row
$count=mysql_num_rows($result);
// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){
// Register $myusername, $mypassword and redirect to file "login_success.php"
session_is_registered("myusername");
session_is_registered("mypassword");
$_SESSION["admin_id"]=$row['0'];
$_SESSION["myusername"]=$myusername;
$_SESSION["mypassword"]=$mypassword;
//header("location:admin_index.php?action=all&search=all&sc=Select&sl=Select");
echo "<span>1</span>";
}
else {
//header("Location:main_login.php");
echo "<span>0</span>";
}
?>