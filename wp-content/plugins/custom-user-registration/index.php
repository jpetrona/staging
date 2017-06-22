<?php
/*
  Plugin Name: Custom Registration
  Description: Custom user registration form
  Author: Iframeits
  Author URI: http://iframeits.com
 */
add_action('init', 'register_script');
function register_script() {
wp_register_style( 'form-style', plugins_url('/css/form-style.css', __FILE__), false, '1.0.0', 'all');
}

// use the registered jquery and style above

	add_action('wp_enqueue_scripts', 'enqueue_style');
	function enqueue_style(){
		wp_enqueue_style( 'form-style' );
	}
	
	add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );
	function wpse27856_set_content_type(){
    return "text/html";
	}
	
	
	function registration_form( $username, $password, $email) {
       ?>
		<div class="sign-block">
		<div class="sign-section clearfix">
		<div class="margin-default-box"></div>
		
		<div class="sign-box">
		<div class="sign-top">
		<p class="sign-text mrgn-cls"> Sign Up</p>
		<form id="user-registration" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
		<div class="form-group mrgn-cls">
		<label for="username" class="form-lbl-text">User Name <strong>*</strong></label>
		<input type="text" class="form-control inpt" id='username'  name="username" placeholder="Username" pattern="[A-Za-z].{2,}"  value="">
	        <span class='username-error state-error' style='display:none'>Please enter username of min 4 characters</span>
	        <span class='username-error-space state-error' style='display:none'>Space not allow in username</span>
               </div>
		 
		<div class="form-group mrgn-cls">
		<label for="password" class="form-lbl-text">Password <strong>*</strong></label>
		<input type="password" name="password" id='pwd'  class="form-control inpt" placeholder="Password"  value="">
                 <span class='password-error state-error' style='display:none'>Please enter password</span>
		</div>
		 
		<div class="form-group mrgn-cls">
		<label for="email" class="form-lbl-text">Email <strong>*</strong></label>
		<input type="text" name="email" id='useremail'  class="form-control inpt" placeholder="Email" value="">
                <span class='email-error state-error' style='display:none'>Please enter valid email id</span>
		</div>
		 
		<div>
		<input type="submit" class="btn btn-default reg-btn  sign-btnn mrgn-cls" disabled  name="submit" value="Register"/>
		</form></div></div>
		<div class="sign-bottom"><?php do_action( 'wordpress_social_login' ); ?><div style="clear:both"></div>					 					 
				</div>
		</div></div></div>
		<?php
	}

	function registration_validation( $username, $password, $email)  {
		global $reg_errors;
		$reg_errors = new WP_Error;
		$username_arr = explode(' ', $username);
		if ( empty( $username ) || empty( $password ) || empty( $email ) ) {
		$reg_errors->add('field', 'Required form field is missing');
		}
		if ( 4 > strlen( $username ) ) {
		$reg_errors->add( 'username_length', 'Username too short. At least 4 characters is required' );
		}
		if ( sizeof($username_arr)>1 )  {
		$reg_errors->add( 'user_name', 'Space not allow in username' );
		}		
		if ( username_exists( $username ) )
		$reg_errors->add('user_name', 'Sorry, that Username already exists!');
		
		if ( ! validate_username( $username ) ) {
		$reg_errors->add( 'username_invalid', 'Sorry, the Username you entered is not valid' );
		}
		if ( !is_email( $email ) ) {
		$reg_errors->add( 'email_invalid', 'Email is not valid' );
		}
		if ( email_exists( $email ) ) {
		$reg_errors->add( 'email', 'Email Id is already in use' );
		}

		if ( is_wp_error( $reg_errors ) ) {
	 ?>
     <div class="errorbox">
     <?php
		foreach ( $reg_errors->get_error_messages() as $error ) {
		 
			echo '<span class="error">';
			echo $error . '<br/>';
			echo '</span>';
			 
		}
	 ?>
     </div>
     <?php
		}
	}


	function complete_registration() {
		global $reg_errors, $username, $password, $email;
		$username = str_replace(' ', '-', $username);
		if ( 1 > count( $reg_errors->get_error_messages() ) ) {
			$userdata = array(
			'user_login'    =>   strtolower($username),
			'user_email'    =>   $email,
			'user_pass'     =>   $password,
			'role'          =>    get_option('default_role') 
			);
			$user = wp_insert_user( $userdata );
                        after_registration($email,$password,$add_campaign,$username,$lastname);
			$password1 = mysql_escape_string(md5($password));
			add_user_meta( $user, 'userpassword', $password1);

   				if ( $user && !is_wp_error( $user ) ) {
        		        $code = sha1( $user . time() );
				//$activation_link = add_query_arg( array( 'key' => $code, 'user' => $user ), get_permalink( 946 ));
				$activation_link = 'http://'.$username.'.'.$_SERVER['HTTP_HOST'].'/user-activation/?key='.$code.'&user='.$user;
				add_user_meta( $user, 'has_to_be_activated', $code, true );
					
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,"http://financialadvisors.retire.ly/action.php");
			        //curl_setopt($ch,CURLOPT_URL,"http://www.retire.ly/action.php"); 
                          	curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,"action=signup&email=$email&password=$password&firstname=$username&lastname=&city=&phone=&terms");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$server_output = curl_exec ($ch);
				curl_close ($ch);

			$message = '<div style="height: auto; max-width: 500px; width: 100%; background-color:#FEFEFE; border:1px solid grey; margin:0 auto; ">
							<div style="height: auto;  border-bottom: 1px solid grey; padding-bottom: 14px;">
							   <div style="display:inline-block; width: 22%;">
								  <img style="margin-left:12px; margin-top: 16px;" src="'.site_url().'/wp-content/uploads/2015/03/Rcolornowhite-1.png" />
							   </div>
							   <div style="display:inline-block; width:70%; float: right;">
								  <p style="color: #045bb8; float: right; padding-top: 10px; padding-right: 10px;"><i style="font-size:12px;">Discover the Best Financial Advisors Worldwide</i></p>
							   </div>
							</div>
							<div style="height: auto; padding-bottom: 15%;">
									<p style="font-size: 25px; color: #606062; margin-left: 25px;">Hello, <span>'.$username.'</span></p>
						
									<p style="color: #606062; font-size: 13.5px; margin-left: 25px;">We are glad that you joined us!</p>
						
									<p style="color: #606062; font-size: 13.5px; margin-left: 25px;">Everybody is waiting for you. Time to login and start communicating!</p>
						
									<div style="background-color: #f2f4f5; border-radius: 6px; height:auto;margin:0 30px 0 60px; border:1px solid #DADCDE;">
									<p style="color: #606062;font-size: 20px; text-align: center; margin-top: 10px; ">Your login and password on Retirely</p>
						
									<p style="color: #606062; font-size: 13px; margin-left: 25px; padding-top: 15px;">Login : <span>'.$username.'</span></p>
									<p style="color: #606062; font-size: 13px; margin-left: 25px;">Password : <span>'.$password.'</span></p>
									</div>
						
									<p style="color: #606062; font-size: 13px; margin-left: 25px; margin-top: 25px;">Retirely wishes you successful advising!</p>
						
									<p style="color: #606062; font-size: 13px; margin-left: 25px;">All you need is to press the button below to verify your account.</p>
						
									<p style="display: block; margin: 0 auto; text-align: center; text-decoration: none; margin: 35px auto 0;">
									  <a href="'.$activation_link.'" style="text-decoration:none; border: 1px solid #66afe9;
								border-radius: 4px;
								box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(102, 175, 233, 0.6);
								color: grey; padding: 9px 18px; ">Confirm Registration</a></p>
							</div>
</div>
';
			
			$email_to = $email;
			$email_subject = 'User confirmation';
			$headers = 'From: Retirely < retirely@news.retire.ly >' . "\r\n";
			//$send_mail = wp_mail($email_to, $email_subject, $message, $headers);

			//if($send_mail){
				echo "<div class='sucess'>Thank You for the registration. Please login.</div>";
			//	}
			//echo 'Registration complete. Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>.';   
		}
            }
	}
	
	function custom_registration_function() {
		if ( isset($_POST['submit'] ) ) {
			registration_validation(
			$_POST['username'],
			$_POST['password'],
			$_POST['email']
			);
			 
			// sanitize user form input
			global $username, $password, $email;
			$username   =   sanitize_user( strtolower($_POST['username']) );
			$password   =   esc_attr( $_POST['password'] );
			$email      =   sanitize_email( $_POST['email'] );
	 
			// call @function complete_registration to create the user
			// only when no WP_error is found
			complete_registration($username,$password,$email);
		}
	 
		registration_form($username,$password,$email);
	}


add_shortcode( 'custom_registration', 'custom_registration_shortcode');
function custom_registration_shortcode() {
        ob_start();
		custom_registration_function();
		return ob_get_clean();
	}
	
// override core function
if ( !function_exists('wp_authenticate') ) :
function wp_authenticate($username, $password) {
    $username = sanitize_user($username);
    $password = trim($password);

    $user = apply_filters('authenticate', null, $username, $password);

    if ( $user == null ) {
        // TODO what should the error message be? (Or would these even happen?)
        // Only needed if all authentication handlers fail to return anything.
        $user = new WP_Error('authentication_failed', __('<strong>ERROR</strong>: Invalid username or incorrect password.'));
    }/* elseif ( get_user_meta( $user->ID, 'has_to_be_activated', true ) != false ) {
        $user = new WP_Error('activation_failed', __('<strong>ERROR</strong>: User is not activated.'));
    }*/

    $ignore_codes = array('empty_username', 'empty_password');

    if (is_wp_error($user) && !in_array($user->get_error_code(), $ignore_codes) ) {
        do_action('wp_login_failed', $username);
    }

    return $user;
}
endif;

add_action( 'template_redirect', 'wpse8170_activate_user' );
function wpse8170_activate_user() {
}
function after_registration($email=0,$pwd=0,$add_campaign=0,$username=0,$lastname=0,$location=0,$phone=0,$terms=0){

	global $wpdb;

	$pwd = mysql_escape_string(md5($pwd));

	$result = $wpdb->insert( 

			'advisors', 

			array( 

				'email' => $email, 

				'password' => $pwd,

				'fname' => $username, 

				'lname' => $lastname,
                                  
                                'role' => 'user',  

			), 

			array( 

				'%s', 

				'%s',

				'%s', 

				'%s',
                           
                                '%s'

			) 

		);

    if($result){

		$id = $wpdb->insert_id;

		$name = $username." ".$lastname;

		session_start();

		$_SESSION['advisorid'] = $id;

		$_SESSION['name'] = $name;

		$result = "1";

		return $result;

    }

}
