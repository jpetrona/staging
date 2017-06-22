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
require( dirname(__FILE__) . '/wp-load.php' );

if(isset($_FILES["upload"])){
     $name = $_FILES["upload"]["name"];
     $upload_dir = wp_upload_dir();
     $extention = explode(".", $_FILES['upload']['name'] );
     $ext = $extention[count($extention) - 1];
     
     $link = $upload_dir['basedir']."/avatar/" . $_POST['uid'].".jpg";
      $link = str_replace("\\","/",$link);
      if(file_exists($link)){
     unlink($link);
    }

     move_uploaded_file( $_FILES["upload"]["tmp_name"],  $link );
} 
 echo site_url()."/wp-content/uploads/avatar/".$_POST['uid'].".jpg";
 exit();
?>