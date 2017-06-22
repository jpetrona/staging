<?php
class userUpdates
{

/* Users Background Details */
public function userDetails($user_id)
{
	$data = get_user_meta( $user_id );
	return $data;
}

/* Intro Tour Check */
public function userBackgroundUpdate($user_id,$actual_image_name)
{
	if ( get_user_meta($user_id,  'profile_background', true ) != $actual_image_name ){
		update_user_meta($user_id, 'profile_background', $actual_image_name);
	}else{
		add_user_meta( $user_id, 'profile_background', $actual_image_name);
	}
	return "true";
}

/* Intro Tour Check */
public function userBackgroundPositionUpdate($user_id,$position)
{  
	if ( get_user_meta($user_id,  'profile_background_position', true ) != $position ){
		update_user_meta($user_id, 'profile_background_position', $position);
	}else{
		add_user_meta( $user_id, 'profile_background_position', $position);
	}

	return "true";
}

}
?>