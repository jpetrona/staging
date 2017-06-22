<?php
require_once("wp-load.php");
global $wpdb;
echo "Hello";
echo $likedislike_count = getSinglePostLikeDislikecount(get_the_ID());
$likedislike_users = getSinglePostLikeDislikeUsers(get_the_ID());
public function test()
{
$var = 'Amit';
return $var;
}


?>