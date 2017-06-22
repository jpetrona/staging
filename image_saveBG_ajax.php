 <?php
require(dirname(__FILE__) . '/wp-load.php');
include(dirname(__FILE__) . '/userUpdates.php');
$userUpdates = new userUpdates();
global $current_user;
get_currentuserinfo();
$session_uid = $current_user->id;

if(isset($_POST['position']) && isset($session_uid))
{
$position=$_POST['position'];
$data=$userUpdates->userBackgroundPositionUpdate($session_uid,$position);
if($data)
echo $position;
}
?>
