<?php
/*
Template Name: Password Reset Template 
*/
get_header(); 
?>
<style>
.forget-block-sectn {
    padding-left: 25%;
}
.frgt-text {
    color: #333333 !important;
    font-size: 2.76923em;
    font-weight: 600;
    line-height: 1.2;
    margin: 5% 0 1%;
}
.frgt-para-text {
    color: #333333;
}
.form-frgt {
    padding-top: 10px;
}
.form-label {
    border-bottom: 1px solid #ebebeb;
    border-top: 1px solid #ebebeb;
    padding: 15px 0;
}
.email-text {
    float: left;
    padding-top: 5px;
    text-align: right;
    width: 25%;
}
.frgt-email-text {
    float: left;
    width: 73%;
}
.inpt-frgt-field {
    background: none repeat scroll 0 0 #fff;
    border: 1px solid #e1e1e1;
    border-radius: 3px;
    display: inline-block;
    padding: 5px;
    width: 42%;
}
.form-sbmt {
    padding: 1% 0 0 25%;
}
.cnfm-btnn {
    background-color: #ffffff;
    border: 1px solid #66afe9;
    border-radius: 5px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(102, 175, 233, 0.6);
    font-size: 1.21429em;
    font-weight: 300;
    line-height: 1.4;
    outline: 0 none;
    padding: 0.4em 2.2em;
}
.back-text {
    padding-top: 5px;
}
.back-login-text {
    color: #0a489d !important;
    font-size: 11px;
    font-weight: 500;
    text-decoration: underline !important;
}

</style>
<?php
global $wpdb, $user_ID;

function tg_validate_url() {
	global $post;
	$page_url = esc_url(get_permalink( $post->ID ));
	$urlget = strpos($page_url, "?");
	if ($urlget === false) {
		$concate = "?";
	} else {
		$concate = "&";
	}
	return $page_url.$concate;
}

if (!$user_ID) { 

//block logged in users
$error = "";
$sucess = "";
	if(isset($_GET['key']) && $_GET['action'] == "reset_pwd") {
		$reset_key = $_GET['key'];
		$user_login = $_GET['login'];
		$user_data = $wpdb->get_row($wpdb->prepare("SELECT ID, user_login, user_email FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s", $reset_key, $user_login));
		
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
		
		if(!empty($reset_key) && !empty($user_data)) {
			$new_password = wp_generate_password(7, false);
				//echo $new_password; exit();
				wp_set_password( $new_password, $user_data->ID );
				//mailing reset details to the user
			$message = __('Your new password for the account at:') . "\r\n\r\n";
			$message .= get_option('siteurl') . "\r\n\r\n";
			$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
			$message .= sprintf(__('Password: %s'), $new_password) . "\r\n\r\n";
			$message .= __('You can now login with your new password at: ') . get_option('siteurl')."/login" . "\r\n\r\n";
			$headers = 'From: Retirely < retirely@news.retire.ly >' . "\r\n";
			if ( $message && !wp_mail($user_email, 'Password Reset Request', $message,$headers) ) {
				$error.=  "Email failed to send for some unknown reason<br>";
				//exit();
			}
			else {
				$redirect_to = get_bloginfo('url')."/myprofile";
				wp_safe_redirect($redirect_to);
				//exit();
			}
		} 
		//else exit('Not a Valid Key.');
		
	}
	//exit();

	if($_POST['action'] == "tg_pwd_reset"){
		if ( !wp_verify_nonce( $_POST['tg_pwd_nonce'], "tg_pwd_nonce")) {
		  //exit("No trick please");
	   }  
		if(empty($_POST['user_input'])) {
			$error.=  "Please enter your Username or E-mail address<br>";
			//exit();
		}
		//We shall SQL escape the input
		$user_input = $wpdb->escape(trim($_POST['user_input']));
		
		if ( strpos($user_input, '@') ) {
			$user_data = get_user_by_email($user_input);
			if(empty($user_data) || $user_data->caps[administrator] == 1) { //delete the condition $user_data->caps[administrator] == 1, if you want to allow password reset for admins also
				$error.=  "Invalid E-mail address!<br>";
				//exit();
			}
		}
		else {
			$user_data = get_userdatabylogin($user_input);
			if(empty($user_data) || $user_data->caps[administrator] == 1) { //delete the condition $user_data->caps[administrator] == 1, if you want to allow password reset for admins also
				$error.=  "Invalid Username!<br>";
				//exit();
			}
		}
		
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
		
		$new_password = wp_generate_password(7, false);
		//echo $new_password; exit();
		wp_set_password( $new_password, $user_data->ID );
		//mailing reset details to the user
		$message = __('Your new password for the account at:') . "\r\n\r\n";
		$message .= get_option('siteurl') . "\r\n\r\n";
		$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
		$message .= sprintf(__('Password: %s'), $new_password) . "\r\n\r\n";
		$message .= __('You can now login with your new password at: ') . get_option('siteurl')."/myprofile" . "\r\n\r\n";
		$headers = 'From: Retirely < retirely@news.retire.ly> ' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		if ( $message && !wp_mail($user_email, 'Password Reset Request', $message,$headers) ) {
			$error.=  "Email failed to send for some unknown reason.<br>";
			//exit();
		}
		else {
			$sucess =  "<div class='success' style='color:#090;'>We have just sent you an email with Password reset.</div>";
			//exit();
		}
		
	} 

?>
<div class="home-fullwidth" style="background:#FFF;">
	<?php if ( have_posts() ) : ?>
	
		<?php while ( have_posts() ) : the_post(); ?>
        <div class="forget-section">
	  <div class="forget-block">
	   <div class="forget-block-sectn">
	    <h1 class="frgt-text">Forget your password?</h1>
	    <p class="frgt-para-text">Enter your email address and we will send you a link to reset your password</p>
		<?php if($error){ ?>
       			 <div class='error' style="color:#C00;"><?php echo $error; ?></div>
			<?php }
			else {
				echo $sucess;
				}
			?>
        </div>
			
			<form class="user_form" id="wp_pass_reset" action="" method="post">	
            <div class="form-label">
				<div class="email-text"><p class="label">Your email<span class="astric">*</span> </p></div>
				<div class="frgt-email-text">		
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="inpt-frgt-field" name="user_input" value="" required="required"  />
			<input type="hidden" name="action" value="tg_pwd_reset" />
			<input type="hidden" name="tg_pwd_nonce" value="<?php echo wp_create_nonce("tg_pwd_nonce"); ?>" />
            </div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
			<div class="form-sbmt">
			<input type="submit" id="submitbtn" class="cnfm-btnn" tabindex="1" name="submit" value="Confirm" />					
			</form>
            
             <div class="back-text">
			<a href="/myprofile/" class="back-login-text">Back to Login</a>
			|
			<a href="/myprofile/" class="back-login-text">or Sign Up</a>
		</div>
             </div>
         <br /><br />   
	</div>
			<div id="result"></div> <!-- To hold validation results -->
			<script type="text/javascript">  						
			$("#wp_pass_reset").submit(function() {			
			$('#result').html('<span class="loading">Validating...</span>').fadeIn();
			var input_data = $('#wp_pass_reset').serialize();
			$.ajax({
			type: "POST",
			url:  "<?php echo get_permalink( $post->ID ); ?>",
			data: input_data,
			success: function(msg){
			$('.loading').remove();
			$('<div>').html(msg).appendTo('div#result').hide().fadeIn('slow');
			}
			});
			return false;
			
			});
			</script>
			
	<?php endwhile; ?>
		
	<?php else : ?>
		
			<h2><?php _e('Not Found'); ?></h1>
			
	<?php endif; ?>
	
</div><!-- content -->
<?php

get_footer();
	}


else {
	wp_redirect( home_url() ); exit;
	//redirect logged in user to home page
}
?>