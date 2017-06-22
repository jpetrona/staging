<?php
require(dirname(__FILE__) . '/wp-load.php');
include(dirname(__FILE__) . '/userUpdates.php');
global $current_user;
get_currentuserinfo();
$session_uid = $current_user->id;
echo 'session_uid '.$session_uid;
$upload_dir = wp_upload_dir();
$path = $upload_dir['basedir'] . "/CoverPage/";
include_once(dirname(__FILE__) . '/getExtension.php');

$userUpdates = new userUpdates();

$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","PNG","JPG","JPEG","GIF","BMP");
if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST" && isset($session_uid))
{
$name = $_FILES['photoimg']['name'];
$size = $_FILES['photoimg']['size'];


if(strlen($name))
{
$ext = getExtension($name);
if(in_array($ext,$valid_formats))
{
if($size<(1024*1024*1024))
{
$actual_image_name = time().$session_uid.".".$ext;
$tmp = $_FILES['photoimg']['tmp_name'];
$bgSave='<div id="uX'.$session_uid.'" class="bgSave wallbutton blackButton">Save Cover</div>';
if(move_uploaded_file($tmp, $path.$actual_image_name))
{
$data=$userUpdates->userBackgroundUpdate($session_uid,$actual_image_name);
if($data)
echo $bgSave.'<img src="'.$upload_dir['baseurl'].'/CoverPage/'.$actual_image_name.'"  id="timelineBGload" class="headerimage ui-corner-all" style="top:0px;left:0px;"/>';
}				
else
{
echo "Fail upload folder with read access.";
}
}
else
echo "Image file size max 1 MB";
}
else
echo "Invalid file format.";
}

else
echo "Please select image..!";

exit;
}
?>
