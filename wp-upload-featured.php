<?php
/**
 * WordPress User Page
 *
 * Handles authentication, registering, resetting passwords, forgot password,
 * and other user handling.
 *
 * @package WordPress
 */

/** Make sure that the WordPress bootstrap has run before continuing. */
//Just uploading photo or attachments
require( dirname(__FILE__) . '/wp-load.php' );
require_once(ABSPATH . "wp-admin" . '/includes/image.php');
require_once(ABSPATH . "wp-admin" . '/includes/file.php');
require_once(ABSPATH . "wp-admin" . '/includes/media.php');
$uploaddir = wp_upload_dir();
if (!file_exists($_FILES['featured']['tmp_name']) || !is_uploaded_file($_FILES['featured']['tmp_name'])) 
{
    echo json_encode(array('invalid'=>'Invalid requet'));
 exit();
}else{
$file = $_FILES['featured' ];
$uploadfile = $uploaddir['path'] . '/' . basename( $file['name'] );
$uploadfileurl = $uploaddir['url'] . '/' . basename( $file['name'] );
move_uploaded_file( $file['tmp_name'] , $uploadfile );
$filename = basename( $uploadfile );
$wp_filetype = wp_check_filetype(basename($filename), null );
$attachment = array(
    'post_mime_type' => $wp_filetype['type'],
    'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
    'post_content' => '',
    'post_status' => 'inherit',
    'menu_order' => $_i + 1000
    );
$attach_id = wp_insert_attachment( $attachment, $uploadfile );
echo json_encode(array('attach_id'=>$attach_id,'uploadfile'=>$uploadfileurl));
 exit();
 }
?>