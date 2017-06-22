<?php
require_once(realpath(dirname(__FILE__)) . '/wp-load.php' );

global $wpdb;
$getpost = $wpdb->get_results( "SELECT ID FROM a1_posts WHERE post_status='publish'" );
//print_r($getpost);
//die;
?>
