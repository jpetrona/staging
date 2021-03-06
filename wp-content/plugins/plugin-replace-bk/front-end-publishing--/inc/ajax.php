<?php

/**
* Matches submitted content against restrictions set in the options panel
*
* @param array $content The content to check
* @return string: An html string of errors
*
*/

function fep_post_has_errors($content){
	$fep_plugin_options = get_option('fep_post_restrictions');
	$fep_misc 			= get_option('fep_misc');
	$min_words_title 	= $fep_plugin_options['min_words_title'];
	$max_words_title 	= $fep_plugin_options['max_words_title'];
	$min_words_content 	= $fep_plugin_options['min_words_content'];
	$max_words_content 	= $fep_plugin_options['max_words_content'];
	$min_words_bio 		= $fep_plugin_options['min_words_bio'];
	$max_words_bio 		= $fep_plugin_options['max_words_bio'];
	$max_links 			= $fep_plugin_options['max_links'];
	$max_links_bio 		= $fep_plugin_options['max_links_bio'];
	$min_tags 			= $fep_plugin_options['min_tags'];
	$max_tags 			= $fep_plugin_options['max_tags'];
	$thumb_required 	= $fep_plugin_options['thumbnail_required'];
	$error_string 		= '';

	
	$tags_array 		= explode(',', $content['post_tags']);
	$stripped_bio 		= strip_tags($content['about_the_author']);
	$stripped_content 	= strip_tags($content['post_content']);



    /*if( ($min_words_title && empty($content['post_title']) ) || ($min_words_content && empty($content['post_content'])) || ($min_words_bio && empty($content['about_the_author'])) || ($min_tags && empty($content['post_tags'])) ){
        $error_string .= 'You missed one or more required fields<br/>';
    }*/
	
    if ( !empty($content['post_title']) && str_word_count( $content['post_title'] ) < $min_words_title )
        $error_string .= 'The title is too short<br/>';
    if ( !empty($content['post_title']) && str_word_count( $content['post_title'] ) > $max_words_title )
        $error_string .= 'The title is too long<br/>';
    if ( !empty($content['post_content']) && str_word_count( $stripped_content ) < $min_words_content )
        $error_string .= 'The article is too short<br/>';
    if ( str_word_count( $stripped_content ) > $max_words_content )
        $error_string .= 'The article is too long<br/>';
	if ( !empty($content['about_the_author']) && $stripped_bio != -1 && str_word_count( $stripped_bio ) < $min_words_bio )
        $error_string .= 'The bio is too short<br/>';
    if ( $stripped_bio != -1 && str_word_count( $stripped_bio ) > $max_words_bio )
        $error_string .= 'The bio is too long<br/>';
	if ( substr_count( $content['post_content'], '</a>' ) > $max_links )
        $error_string .= 'There are too many links in the article body<br/>';
	if ( substr_count( $content['about_the_author'], '</a>' ) > $max_links_bio )
        $error_string .= 'There are too many links in the bio<br/>';
	if ( !empty( $content['post_tags'] ) && count($tags_array) < $min_tags )
		$error_string .= 'You haven\'t added the required number of tags<br/>';
	if ( count($tags_array) > $max_tags )
		$error_string .= 'There are too many tags<br/>';
	if ( $thumb_required == 'true' && $content['featured_img'] == -1 )
		$error_string .= 'You need to choose a featured image<br/>';
	
	if ( str_word_count( $error_string ) < 2 )
		return false;
	else
		return $error_string;
}

/**
* Ajax function for fetching a featured image
*
* @param array $_POST The id of the image
* @return string: A JSON encoded string
*
*/

function fep_fetch_featured_image(){
	$image_id = $_POST['img']; 
	echo wp_get_attachment_image( $image_id, array(200,200) );
	die();
}
add_action( 'wp_ajax_fep_fetch_featured_image', 'fep_fetch_featured_image' );
add_action( 'wp_ajax_nopriv_fep_fetch_featured_image', 'fep_fetch_featured_image' );

/**
* Ajax function for deleting a post
*
* @param array $_POST The id of the post and a nonce value
* @return string: A JSON encoded string
*
*/

function fep_delete_posts(){
	try{
		if(!wp_verify_nonce($_POST['delete_nonce'], 'fepnonce_delete_action'))
			throw new Exception('Sorry! You failed the security check', 1);

		if(!current_user_can('delete_post', $_POST['post_id']))
			throw new Exception("You don't have permission to delete this post", 1);

		$result = wp_delete_post( $_POST['post_id'], true );
		if(!$result)
			throw new Exception("The article could not be deleted", 1);

		$data['success'] = true;
		$data['message'] = 'The article has been deleted successfully!';
	}
	catch(Exception $ex){
		$data['success'] = false;
		$data['message'] = $ex->getMessage();
	}
	die( json_encode($data) );
}
add_action( 'wp_ajax_fep_delete_posts', 'fep_delete_posts' );
add_action( 'wp_ajax_nopriv_fep_delete_posts', 'fep_delete_posts' );

/**
* Ajax function for adding a new post.
*
* @param array $_POST The user submitted post
* @return string: A JSON encoded string
*
*/
 
function fep_process_form_input(){

	try{
		/*if(!wp_verify_nonce($_POST['post_nonce'], 'fepnonce_action'))
			throw new Exception("Sorry! You failed the security check", 1);*/

        $post_author_id = get_post_field( 'post_author', $_POST['post_id'] );




		if($_POST['post_id'] != -1 &&   !( $post_author_id == $_POST['post_author_ide'] ) )
			throw new Exception('*You don\'t have permission to edit this post. * current(user) ='.$_POST['post_author_ide'], 1);

		$fep_role_settings = get_option('fep_role_settings');
		$fep_misc = get_option('fep_misc');

		if($fep_role_settings['no_check'] && current_user_can( $fep_role_settings['no_check']))
			$errors = false;
		else
			$errors = fep_post_has_errors($_POST);
		
		if($errors)
			throw new Exception($errors, 1);

		if($fep_misc['nofollow_body_links'])
			$post_content = wp_rel_nofollow($_POST['post_content']);
		else
			$post_content = $_POST['post_content'];

		$new_post = array(
			'post_title'   		=> sanitize_text_field( $_POST['post_title'] ),
			'post_category'  	=> array( $_POST['post_category'] ),
			'tags_input'  		=> sanitize_text_field($_POST['post_tags']),
			'post_content' 		=> wp_kses_post($post_content),
			'post_author'       => $_POST['post_author_ide']

		);


		if( $fep_role_settings['instantly_publish'] && current_user_can( 'publish_posts' ) ){
			$post_action = 'published';
			$new_post['post_status'] = 'publish';
		}
		else{
			$post_action = 'submitted';
			$new_post['post_status'] = 'publish';
		}


		if($_POST['post_id'] != -1){
			$new_post['ID'] = $_POST['post_id'];
			$new_post['post_date'] = get_post_field( 'post_date', $_POST['post_id'] );
			$new_post['post_date_gmt'] = get_post_field( 'post_date_gmt', $_POST['post_id'] );
			$post_action = 'updated';
		}

		$new_post_id = wp_insert_post($new_post, true);
		if(is_wp_error($new_post_id))
			throw new Exception($new_post_id->get_error_message(), 1);
		
		if(!$fep_misc['disable_author_bio']){
			if($fep_misc['nofollow_bio_links'])
				$about_the_author = wp_rel_nofollow($_POST['about_the_author']);
			else
				$about_the_author = $_POST['about_the_author'];
			update_post_meta($new_post_id, 'about_the_author', $about_the_author);
		} 



		if( $_POST['post_topic'] != -1 )
			{
				update_field( $_POST['post_topic_key'] , $_POST['post_topic'] , $new_post_id );
			}
		if( $_POST['post_source'] != -1 )
			{
				update_field( $_POST['post_source_key'] , $_POST['post_source'] , $new_post_id );
			}
		if( $_POST['post_source_link'] != -1 )
		{
			update_field( $_POST['post_source_link_key'] , $_POST['post_source_link'] , $new_post_id );
		}
		

		if($_POST['featured_img'] != -1)
			set_post_thumbnail( $new_post_id, $_POST['featured_img'] );

		$data['success'] = true;
		$data['post_id'] = $new_post_id;
		$data['message'] = 'Your article has been '.$post_action.' successfully!<br/><a href="#" id="fep-continue-editing">Continue Editing</a>';
	}
	catch(Exception $ex){
		$data['success'] = false;
		$data['message'] = '<h2>Your submission has errors. Please try again!</h2>'.$ex->getMessage();
	}
	die(json_encode($data));
}
add_action( 'wp_ajax_fep_process_form_input', 'fep_process_form_input' );
add_action( 'wp_ajax_nopriv_fep_process_form_input', 'fep_process_form_input' );




function Company_Name_Nasdaq()
{
    $x = $_REQUEST['word'];
    // a1_nasdaq
    global $wpdb;
    $sql = "SELECT `Symbol` , `Name` FROM `a1_nasdaq` WHERE `Symbol` REGEXP '^$x' OR `Symbol` LIKE '%$x%' OR `Name` LIKE '%$x%' ORDER BY case when `Symbol` = '$x' then 1 else 2 end,
         `Symbol` ASC  LIMIT 0 , 5";
    	//SELECT `Symbol` , `Name`
    $result = $wpdb->get_results($sql) or die(mysql_error());
    foreach ( $result as $key => $value) {  
     	$string .= "%22{$value->Symbol}%22";
     	if( count($result) != ( $key + 1 ) )
    	{ 	$string .= ","; }
     	//,%22AAPL%22,%22GOOG%22,%22MSFT%22";
     }
     	$yql_query_url = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quotes%20where%20symbol%20in%20%28$string%29&env=http://datatables.org/alltables.env&format=json"; 
	    // Make call with cURL
    	$session = curl_init($yql_query_url);
	    curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
    	$json = curl_exec($session); 

    	$jsonnew=json_decode($json,true);
 		$result_manu = array();
    	foreach ($jsonnew[query][results][quote] as $key => $value) { 
    		if( count( $result ) == 1 ){
    			 
    			$jsonnew[query][results][quote]['id']=1;
	    		$jsonnew[query][results][quote]['name']=$result[0]->Name;
	    		$jsonnew[query][results][quote]['LastTradeWithTime'] = '';
	    		$result_manu[0] = $jsonnew[query][results][quote];
    		}else
    		{ 
	    		$jsonnew[query][results][quote][$key]['id']=$key;
	    		$jsonnew[query][results][quote][$key]['name']=$result[$key]->Name;
	    		$jsonnew[query][results][quote][$key]['LastTradeWithTime'] = '';
	    		$result_manu = $jsonnew[query][results][quote];
    		}
    	} 
        $output = json_encode( $result_manu ,true  );
           
        $output = preg_replace('/[\x00-\x1F\x7F]/', '', $output);
 
        echo $output;   
        exit();

}
add_action( 'wp_ajax_Company_Name_Nasdaq', 'Company_Name_Nasdaq' );
add_action( 'wp_ajax_nopriv_Company_Name_Nasdaq', 'Company_Name_Nasdaq' );