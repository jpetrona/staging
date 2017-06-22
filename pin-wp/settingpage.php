<?php
	/*
	Template Name: Setting Page
	*/
     get_header(); // add header  


?>
<style>
	.arrow-wrapper-down{
		top:7%;
		z-index: 9;
	}
</style>
<?php if(is_user_logged_in()){
  echo do_shortcode("[SignIn val='']"); 
}else{
?>
<script>
var redirect_url = "<?php echo site_url().'/sign-in/'; ?>";
window.location.replace(redirect_url);
window.location.href = redirect_url;
</script>
<?php

 // echo do_shortcode("[SignIn val='".$user_id_val."']"); 
}?>
<?php echo do_shortcode("[EDITPROFILE]"); ?>
<div class="clear"></div>
<?php get_footer(); // add footer  ?>
