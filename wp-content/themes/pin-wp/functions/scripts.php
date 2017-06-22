<?php
// ----------------------------------------------
// ------------ JavaScrips Files ----------------
// ----------------------------------------------


if( !function_exists( 'anthemes_enqueue_scripts' ) ) {
    function anthemes_enqueue_scripts() {

		// Register css files
        wp_register_style( 'style', get_stylesheet_uri(), '', microtime());
	wp_register_style( 'default', get_template_directory_uri() . '/css/colors/default.css','', microtime());
	wp_register_style( 'responsive', get_template_directory_uri() . '/css/responsive.css', '', microtime());
        wp_register_style( 'fancyboxcss', get_template_directory_uri() . '/fancybox/jquery.fancybox-1.3.4.css', TRUE);       
        wp_register_style( 'google-font', '//fonts.googleapis.com/css?family=Ruda:400,700', TRUE);
        wp_register_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome-4.2.0/css/font-awesome.min.css', TRUE);
		
		// Register scripts
	wp_enqueue_script( "form-jquery", 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', array('jquery') );
	wp_register_script( 'customjs', get_template_directory_uri() . '/js/custom.js', 'jquery', '', TRUE);
        wp_register_script( 'validatecontact', get_template_directory_uri() . '/js/jquery.validate.min.js', 'jquery', '', TRUE);
        wp_register_script( 'mainfiles',  get_template_directory_uri() . '/js/jquery.main.js', 'jquery', '', TRUE);
        wp_register_script( 'fancyboxjs', get_template_directory_uri() . '/fancybox/jquery.fancybox-1.3.4.pack.js', 'jquery', '', TRUE);

        /*5-12-2015 scripts*/
        wp_register_script( 'jquery-ui', get_template_directory_uri() . '/js/jquery-ui.js', 'jquery', '', TRUE);
        wp_enqueue_script('jquery-ui');

        // Display js files in Header via wp_head();
        wp_enqueue_style('style');
        wp_enqueue_style('default');
        wp_enqueue_style('responsive');
        wp_enqueue_style('google-font');
        wp_enqueue_style('font-awesome');
        wp_enqueue_script('jquery');
        /*Start css and js for front end publishing*/
        wp_enqueue_style( 'validate', get_template_directory_uri() . '/css/validate.css', array(), '1.0', 'all' );
        /*End css and js for front end publishing*/

        // Load Comments & .js files.
        if( is_single() ) {
            wp_enqueue_style('fancyboxcss');
            wp_enqueue_script('comment-reply');
            wp_enqueue_script('fancyboxjs');
         }

        // Load js validate in contact and job page.
        if( is_page_template( 'template-contact.php' ) ) { 
            wp_enqueue_script('validatecontact');
         }

        // Load js for masonry style with infinite scroll.
        if( ! is_singular() || is_single() || is_page() || is_page_template( 'template-home.php') ) { 
            wp_enqueue_script('mainfiles');
         }
 
        // Display js and css files in Footer via wp_footer();
        wp_enqueue_script('customjs');
    }
    add_action('wp_enqueue_scripts', 'anthemes_enqueue_scripts');
}
?>
