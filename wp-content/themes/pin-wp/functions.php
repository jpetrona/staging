<?php
// ------------------------------------------------ 
// ---------- Options Framework Theme -------------
// ------------------------------------------------
require_once ('admin/index.php');
// --------------- Load Scripts -----------------
include("functions/scripts.php");
// --------------- Load Custom Widgets ----------
include("functions/widgets.php");
include("functions/widgets/widget-tags.php");
include("functions/widgets/widget-posts.php");
include("functions/widgets/widget-top-posts.php");
include("functions/widgets/widget-cat.php");
include("functions/widgets/widget-feedburner.php");
include("functions/widgets/widget-review.php");
include("functions/widgets/widget-review-rand.php");
include("functions/widgets/widget-review-recent.php");
include("functions/widgets/widget-categories.php");
include("functions/widgets/widget-banner.php");
// --------------- Load Custom ------------------
include("functions/custom/comments.php");
// ------ Content width -------------------------
if ( ! isset( $content_width ) ) $content_width = 950;
// ------ Post thumbnails ----------------------- 
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
    add_image_size( 'thumbnail-gallery-single', 180, 180, true ); // Gallery thumbnails 
    add_image_size( 'thumbnail-blog-featured', 300, 165, true ); // Blog thumbnails home featured posts 
    add_image_size( 'thumbnail-blog-masonry', 300, '', true ); // Blog thumbnails home masonry style 
    add_image_size( 'thumbnail-widget', 250, 130, true ); // Sidebar Widget thumbnails 
    add_image_size( 'thumbnail-widget-small', 55, 55, true ); // Sidebar Widget thumbnails small 
	add_image_size( 'thumbnail-single-image', 950, '', true ); // Single thumbnails 
} 

// ---------------------------------------------- 
// ------ feed links ---------------------------- 
// ---------------------------------------------- 
 add_theme_support( 'automatic-feed-links' );  

// ---------------------------------------------- 
// ------ title tag ---------------------------- 
// ---------------------------------------------- 
 add_theme_support( 'title-tag' ); 
  
// ---------------------------------------------- 
// ---- Makes Theme available for translation --- 
// ---------------------------------------------- 
 load_theme_textdomain( 'anthemes', get_template_directory() . '/languages' );  

// ---------------------------------------------- 
// -------------- Register Menu ----------------- 
// ---------------------------------------------- 
add_theme_support( 'nav-menus' ); 
add_action( 'init', 'register_my_menus_anthemes' );  

function register_my_menus_anthemes() { 
    register_nav_menus( 
        array( 
            'primary-menu' => esc_html__( 'Header Navigation', 'anthemes' ), 
            'secondary-menu' => esc_html__( 'Categories Navigation', 'anthemes' ), 
        ) 
    ); 
}  

// ------------------------------------------------  
// ---- Add  rel attributes to embedded images ---- 
// ------------------------------------------------  
function insert_rel_anthemes($content) { 
    $pattern = '/<a(.*?)href="(.*?).(bmp|gif|jpeg|jpg|png)"(.*?)>/i'; 
    $replacement = '<a$1href="$2.$3" class=\'wp-img-bg-off\' rel=\'mygallery\'$4>'; 
    $content = preg_replace( $pattern, $replacement, $content ); 
    return $content; 
} 
add_filter( 'the_content', 'insert_rel_anthemes' );  

//Start Facebook tags for sharing
function insert_fb_in_head() {
    global $post;
    if ( !is_singular()) //if it is not a post or a page
        return;
        echo '<meta property="fb:app_id" content="1632539196982448" />';
        echo '<meta property="og:title" content="' . get_the_title() . '"/>';
        //echo '<meta property="og:type" content="article"/>';
        echo '<meta property="og:url" content="' . get_permalink() . '"/>';
        echo '<meta property="og:site_name" content="retire.ly"/>';
	echo '<meta property="og:image:width" content="200" />';
        echo '<meta property="og:image:height" content="200" />';
    if(!has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
        $default_image="http://example.com/image.jpg"; //replace this with a default image on your server or an image in your media library
        echo '<meta property="og:image" content="' . $default_image . '"/>';
    }
    else{
        $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
        echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
    }
    echo "
";
}
add_action( 'wp_head', 'insert_fb_in_head', 5 );
//End Facebook tags

// ------------------------------------------------ 
// ---- Add  rel attributes AI TYPE  to embedded images ---- 
// ------------------------------------------------   

add_filter('upload_mimes', 'custom_upload_mimes'); 
function custom_upload_mimes ( $existing_mimes=array() )  
{  
   // Add *.EPS files to Media upload 
    $existing_mimes['eps'] = 'application/postscript'; 
    // Add *.AI files to Media upload 
     $existing_mimes['ai'] = 'application/postscript';  
    return $existing_mimes; 
} 
  
// ---- Add  rel attributes to gallery images ---- 
add_filter('wp_get_attachment_link', 'add_gallery_id_rel_anthemes'); 
function add_gallery_id_rel_anthemes($link) { 
    global $post; 
    return str_replace('<a href', '<a rel="mygallery" class="wp-img-bg-off" href', $link); 
}   

// ------------------------------------------------  
// --- Pagination class/style for entry articles -- 
// ------------------------------------------------  
function custom_nextpage_links_anthemes($defaults) { 
$args = array( 
'before' => '<div class="my-paginated-posts"><p>' . '<span>', 
'after' => '</span></p></div>', 
); 
$r = wp_parse_args($args, $defaults); 
return $r; 
} 
add_filter('wp_link_pages_args','custom_nextpage_links_anthemes');   

// ------------------------------------------------  
// ------------ Nr of Topics for Tags ------------- 
// ------------------------------------------------   
add_filter ( 'wp_tag_cloud', 'tag_cloud_count_anthemes' ); 
function tag_cloud_count_anthemes( $return ) { 
return preg_replace('#(<a[^>]+\')(\d+)( topics?\'[^>]*>)([^<]*)<#imsU','$1$2$3$4 <span>($2)</span><',$return); 
}   

// ------------------------------------------------  
// --------------- Posts Time Ago ----------------- 
// ------------------------------------------------    

function time_ago_anthemes( $type = 'post' ) { 
    $d = 'comment' == $type ? 'get_comment_time' : 'get_post_time'; 
    return human_time_diff($d('U'), current_time('timestamp')) . " "; 
}   

// ------------------------------------------------  
// --------------- Author Social Links ------------ 
// ------------------------------------------------  
function anthemes_contactmethods( $contactmethods ) { 
    $contactmethods['twitter']   = ''. esc_html__('Twitter Username', 'anthemes') .''; 
    $contactmethods['facebook']  = ''. esc_html__('Facebook Username', 'anthemes') .''; 
    $contactmethods['google']    = ''. esc_html__('Google+ Username', 'anthemes') .''; 
    return $contactmethods; 
} 
add_filter('user_contactmethods','anthemes_contactmethods',10,1);   

// ---------------------------------------------- 
// ---------- excerpt length adjust ------------- 
// ---------------------------------------------- 
function anthemes_excerpt($str, $length, $minword = 3) 
{ 
    $sub = ''; 
    $len = 0; 
    foreach (explode(' ', $str) as $word) 
    { 
        $part = (($sub != '') ? ' ' : '') . $word; 
        $sub .= $part; 
        $len += strlen($part); 
         
        if (strlen($word) > $minword && strlen($sub) >= $length) 
        { 
            break; 
        } 
    } 
    return $sub . (($len < strlen($str)) ? ' ..' : ''); 
} 
    
// ------------------------------------------------  
// ------------ Number of post views -------------- 
// ------------------------------------------------  
// function to display number of posts. 
function getPostViews_anthemes($postID){ 
    $count_key = 'post_views_count'; 
    $count = get_post_meta($postID, $count_key, true); 
    if($count==''){ 
        delete_post_meta($postID, $count_key); 
        add_post_meta($postID, $count_key, '0'); 
        return '0 <span>' . esc_html__('View', 'anthemes') . '</span>'; 
    } 
    return $count.' <span>' . esc_html__('Views', 'anthemes') . '</span>'; 
}  
// function to count views. 
function setPostViews_anthemes($postID) { 
    $count_key = 'post_views_count'; 
    $count = get_post_meta($postID, $count_key, true); 
    if($count==''){ 
        $count = 0; 
        delete_post_meta($postID, $count_key); 
        add_post_meta($postID, $count_key, '0'); 
    }else{ 
        $count++; 
        update_post_meta($postID, $count_key, $count); 
    } 
}   
// ------------------------------------------------  
// ------------ Meta Box -------------------------- 
// ------------------------------------------------ 
$prefix = 'anthemes_'; 
global $meta_boxes; 
$meta_boxes = array();  
// 1st meta box 
$meta_boxes[] = array( 
    'id' => 'standard', 
    'title' => esc_html__( 'Article Page Options', 'anthemes' ), 
    'context' => 'normal', 
    'priority' => 'high', 
    'autosave' => true,  
    // Youtube 
    'fields' => array( 
        // TEXT 
        array( 
            // Field name - Will be used as label 
            'name'  => esc_html__( 'Video Youtube', 'anthemes' ), 
            // Field ID, i.e. the meta key 
            'id'    => "{$prefix}youtube", 
            // Field description (optional) 
            'desc'  => esc_html__( 'Add Youtube code ex: HIrMIeN5ttE', 'anthemes' ), 
            'type'  => 'text', 
            // Default value (optional) 
            'std'   => esc_html__( '', 'anthemes' ), 
            // CLONES: Add to make the field cloneable (i.e. have multiple value) 
            'clone' => false, 
        ),   
    // Vimeo 
        // TEXT 
        array( 
            // Field name - Will be used as label 
            'name'  => esc_html__( 'Video Vimeo', 'anthemes' ), 
            // Field ID, i.e. the meta key 
            'id'    => "{$prefix}vimeo", 
            // Field description (optional) 
            'desc'  => esc_html__( 'Add Vimeo code ex: 7449107', 'anthemes' ), 
            'type'  => 'text', 
            // Default value (optional) 
            'std'   => esc_html__( '', 'anthemes' ), 
            // CLONES: Add to make the field cloneable (i.e. have multiple value) 
            'clone' => false, 
        ),  
    // Gallery 
        // IMAGE UPLOAD 
        array( 
            'name' => esc_html__( 'Gallery', 'anthemes' ), 
            'id'   => "{$prefix}slider", 
            // Field description (optional) 
            'desc'  => esc_html__( 'Image with any size!', 'anthemes' ),             
            'type' => 'image_advanced', 
        ),  
    // Hide Featured Image 
        // CheckBox 
        array( 
            'name' => esc_html__( 'Featured Image', 'anthemes' ), 
            'id'   => "{$prefix}hideimg", 
            'desc'  => esc_html__( 'Hide Featured Image on single page for this article', 'anthemes' ), 
            'type' => 'checkbox', 
        ),   
    ),  
);    
/** 
 * Register meta boxes 
 * 
 * @return void 
 */ 
function anthemes_register_meta_boxes() 
{ 
    // Make sure there's no errors when the plugin is deactivated or during upgrade 
    if ( !class_exists( 'RW_Meta_Box' ) ) 
        return;  

    global $meta_boxes; 
    foreach ( $meta_boxes as $meta_box ) 
    { 
        new RW_Meta_Box( $meta_box ); 
    } 
} 
// Hook to 'admin_init' to make sure the meta box class is loaded before 
// (in case using the meta box class in another plugin) 
// This is also helpful for some conditionals like checking page template, categories, etc. 
add_action( 'admin_init', 'anthemes_register_meta_boxes' );   

// ------------------------------------------------  
// ---------- TGM_Plugin_Activation ------------- 
// ------------------------------------------------  
require_once dirname( __FILE__ ) . '/functions/custom/class-tgm-plugin-activation.php'; 
add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );  

function my_theme_register_required_plugins() {  

    $plugins = array( 
        array( 
            'name'                  => 'Meta Box', // The plugin name 
            'slug'                  => 'meta-box', // The plugin slug (typically the folder name) 
            'source'                => get_stylesheet_directory() . '/plugins/meta-box.zip', // The plugin source 
	            'required'              => true, // If false, the plugin is only 'recommended' instead of required 
            'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented 
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch 
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins 
            'external_url'          => '', // If set, overrides default API URL and points to an external URL 
        ),  
        array( 
            'name'                  => 'Shortcodes', // The plugin name 
            'slug'                  => 'anthemes-shortcodes', // The plugin slug (typically the folder name) 
            'source'                => get_stylesheet_directory() . '/plugins/anthemes-shortcodes.zip', // The plugin source 
            'required'              => false, // If false, the plugin is only 'recommended' instead of required 
            'version'               => '1.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented 
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch 
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins 
            'external_url'          => '', // If set, overrides default API URL and points to an external URL 
        ),  
        array( 
            'name'                  => 'Reviews', // The plugin name 
            'slug'                  => 'anthemes-reviews', // The plugin slug (typically the folder name) 
            'source'                => get_stylesheet_directory() . '/plugins/anthemes-reviews.zip', // The plugin source 
            'required'              => false, // If false, the plugin is only 'recommended' instead of required 
            'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented 
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch 
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins 
            'external_url'          => '', // If set, overrides default API URL and points to an external URL 
        ),  
        array( 
            'name'                  => 'Thumbs Likes System', // The plugin name 
            'slug'                  => 'thumbs-rating', // The plugin slug (typically the folder name) 
            'source'                => get_stylesheet_directory() . '/plugins/thumbs-rating.zip', // The plugin source 
            'required'              => false, // If false, the plugin is only 'recommended' instead of required 
            'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented 
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch 
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins 
            'external_url'          => '', // If set, overrides default API URL and points to an external URL 
        ),  
        array( 
            'name'                  => 'Google fonts', // The plugin name 
            'slug'                  => 'wp-google-fonts', // The plugin slug (typically the folder name) 
            'source'                => get_stylesheet_directory() . '/plugins/wp-google-fonts.zip', // The plugin source 
            'required'              => false, // If false, the plugin is only 'recommended' instead of required 
            'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented 
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch 
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins 
            'external_url'          => '', // If set, overrides default API URL and points to an external URL 
        ),   
        array( 
            'name'                  => 'Custom Sidebars', 
            'slug'                  => 'custom-sidebars', 
            'required'              => false, 
            'version'               => '', 
        ),  
        array( 
            'name'                  => 'Resume Builder', 
            'slug'                  => 'resume-builder', 
            'required'              => false, 
            'version'               => '', 
        ),          
        array( 
            'name'                  => 'Daves WordPress Live Search', 
            'slug'                  => 'daves-wordpress-live-search', 
            'required'              => false, 
            'version'               => '', 
        ),  
        array( 
            'name'                  => 'Multi-column Tag Map', 
            'slug'                  => 'multi-column-tag-map', 
            'required'              => false, 
            'version'               => '', 
        ),  
        array( 
            'name'                  => 'Responsive Menu', 
            'slug'                  => 'responsive-menu', 
            'required'              => false, 
            'version'               => '', 
        ),  
        array( 
            'name'                  => 'Social Count Plus', 
            'slug'                  => 'social-count-plus', 
            'required'              => false, 
            'version'               => '', 
        ),  
        array( 
            'name'                  => 'Social Share button', 
            'slug'                  => 'social-share-button', 
            'required'              => false, 
            'version'               => '', 
        ),  
        array( 
            'name'                  => 'WP-PageNavi', 
            'slug'                  => 'wp-pagenavi', 
            'required'              => false, 
            'version'               => '', 
        ),  
    );  
    // Change this to your theme text domain, used for internationalising strings 
    $theme_text_domain = 'tgmpa'; 
    $config = array( 
        'domain'            => $theme_text_domain,          // Text domain - likely want to be the same as your theme. 
        'default_path'      => '',                          // Default absolute path to pre-packaged plugins 
        'parent_menu_slug'  => 'themes.php',                // Default parent menu slug 
        'parent_url_slug'   => 'themes.php',                // Default parent URL slug 
        'menu'              => 'install-required-plugins',  // Menu slug 
        'has_notices'       => true,                        // Show admin notices or not 
        'is_automatic'      => false,                       // Automatically activate plugins after installation or not 
        'message'           => '',                          // Message to output right before the plugins table 
        'strings'           => array( 
            'page_title'                                => esc_html__( 'Install Required Plugins', $theme_text_domain ), 
            'menu_title'                                => esc_html__( 'Install Plugins', $theme_text_domain ), 
            'installing'                                => esc_html__( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name 
            'oops'                                      => esc_html__( 'Something went wrong with the plugin API.', $theme_text_domain ), 
            'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s) 
            'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s) 
            'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s) 
            'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s) 
            'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s) 
            'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s) 
            'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s) 
            'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s) 
            'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ), 
            'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ), 
            'return'                                    => esc_html__( 'Return to Required Plugins Installer', $theme_text_domain ), 
            'plugin_activated'                          => esc_html__( 'Plugin activated successfully.', $theme_text_domain ), 
            'complete'                                  => esc_html__( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link 
            'nag_type'                                  => 'updated' // Determines admin notice type - can only be 'updated' or 'error' 
        ) 
    );  
    tgmpa( $plugins, $config );  
} 
function featuredtoRSS($content) {
    global $post;
    if ( has_post_thumbnail( $post->ID ) ){
        $content = '<div>' . get_the_post_thumbnail( $post->ID, 'large', array( 'style' => 'margin-bottom: 15px;' ) ) . '</div>' . $content;
    }
    return $content;
}

add_filter('the_excerpt_rss', 'featuredtoRSS');
add_filter('the_content_feed', 'featuredtoRSS');   
/**
* Disable admin bar on the frontend of your website
* for subscribers.
*/
/*function themeblvd_disable_admin_bar() {
if( ! current_user_can('edit_posts') )
add_filter('show_admin_bar', '__return_false');
}
add_action( 'after_setup_theme', 'themeblvd_disable_admin_bar' );
*/
/**
* Redirect back to homepage and not allow access to
* WP admin for Subscribers.
*/
/*function themeblvd_redirect_admin(){
if ( ! current_user_can( 'edit_posts' ) ){
wp_redirect( site_url() );
exit;
}
}
add_action( 'admin_init', 'themeblvd_redirect_admin' );*/ 
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
} 
function example_ajax_request() {

     global $wpdb; // this is how you get access to the database

    // The $_REQUEST contains all the data sent via ajax

    if ( isset($_REQUEST) ) {
        $fruit = $_REQUEST['fruit'];
        update_user_meta( get_current_user_id() , 'nickname', $fruit );
        update_user_meta( get_current_user_id() , 'last_name', $fruit );
        echo $fruit;
     }
    // Always die in functions echoing ajax content
   exit();
}
add_action( 'wp_ajax_example_ajax_request', 'example_ajax_request' );

function firstname_change_ajax_request() {

     global $wpdb; // this is how you get access to the database

    // The $_REQUEST contains all the data sent via ajax

    if ( isset($_REQUEST) ) {
        $fruit = $_REQUEST['fruit'];
        update_user_meta( get_current_user_id() , 'first_name', $fruit );
        echo $fruit;
     }
    // Always die in functions echoing ajax content
   exit();
}
add_action( 'wp_ajax_firstname_change_ajax_request', 'firstname_change_ajax_request' ); 
    add_action( 'init', 'blockusers_init' );
    function blockusers_init() {

        if ( is_admin() && ! current_user_can( 'administrator' ) && 

           ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {

            wp_redirect( home_url() );
            exit;
        } 
    }
add_filter( 'posts_where', 'devplus_wpquery_where' );
function devplus_wpquery_where( $where ){
    global $current_user;

    if( is_user_logged_in() ){
         // logged in user, but are we viewing the library?
         if( isset( $_POST['action'] ) && ( $_POST['action'] == 'query-attachments' ) ){
            // here you can add some extra logic if you'd want to.
            $where .= ' AND post_author='.$current_user->data->ID;
        }
    }
    return $where;
}
// Apply filter
add_filter( 'get_avatar' , 'my_custom_avatar' , 10 , 5 );
function my_custom_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    $previous_avatar = $avatar;
    $user = false;
    if ( is_numeric( $id_or_email ) ) {
        $id = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );
    } elseif ( is_object( $id_or_email ) ) {
        if ( ! empty( $id_or_email->user_id ) ) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }
    } else {
        $user = get_user_by( 'email', $id_or_email );  
    }
    if ( $user && is_object( $user ) ) {
    $upload_dir = wp_upload_dir();
    $link = $upload_dir['basedir']."/avatar/" .  $user->data->ID.".jpg";
    $link = str_replace("\\","/",$link);
      $site_link =  site_url()."/wp-content/uploads/avatar/".$user->data->ID.".jpg";
      $avatar = $site_link;
      if( file_exists($link) )
      {
         $avatar = "<img alt='{$alt}' src='{$avatar}' class='codey avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";  
      } 
      else
      {
        $avatar =  $previous_avatar;
      } 
    }
    return $avatar;
}

/*this function is used to show graph on post detail page.*/
function Graph_price($post_id){
   $graph_value = get_post_meta ($post_id,'graph_value',true);
    $graph_value1 = explode(",",$graph_value);
    $nasdaq_data = Nasdaq_tag_symbol( $post_id ); //|| ( strcmp( $size , "thumbnail-blog-masonry" ) != 0 ) || ( strcmp( $size , "thumbnail-single-image" ) != 0 )
    $nasdaq_datanew = str_replace('"', "" ,$nasdaq_data);
    $nasdaq_datanew1 = explode(",",$nasdaq_datanew);
    foreach ($graph_value1 as $key => $value) {
        if(preg_match('/'.$nasdaq_datanew1[0].'/',$value)){
            $graph_valuenew = $value;
        }
    }
    $graph_value2 = $graph_valuenew !== '' ?  $graph_valuenew : '';
    return $graph_value2;   
}

function Nasdaq_tag_symbol(  $id )
{  
		$post_tag_list = $tags = wp_get_post_tags( $id ); 
		$result = '';
		if ($tags){ 
		$post_tag_list_str  = '';
		foreach ($post_tag_list as $key => $value) { 
		$post_tag_list_str .= ",";
		$post_tag_list_str .= '"'.$value->name.'"';
		}
		$result =  substr($post_tag_list_str , 1 );
		}
		return $result;
}
add_filter('post_thumbnail_html', 'transparent_bar', 10, 5);
function transparent_bar( $html, $post_id, $post_thumbnail_id, $size, $attr )
{
    $nasdaq_data = Nasdaq_tag_symbol( get_the_ID() ); //|| ( strcmp( $size , "thumbnail-blog-masonry" ) != 0 ) || ( strcmp( $size , "thumbnail-single-image" ) != 0 )
    $nasdaq_datanew = str_replace('"', "" ,$nasdaq_data);
    $nasdaq_datanew1 = explode(",",$nasdaq_datanew);
    $posted_date = get_the_date('m/d/y');
    if( $nasdaq_data == ""  )
    {  
        return $html;
    } 
    if( strcmp( $size , "thumbnail-blog-masonry" ) == 0  )   //  strcmp( $size , "thumbnail-single-image" ) == 0  ||
    {
    $graph_value = get_post_meta ($post_id,'graph_value',true);
    $graph_value1 = explode(",",$graph_value);
    foreach ($graph_value1 as $key => $value) {
        if(preg_match('/'.$nasdaq_datanew1[0].'/',$value)){
            $graph_valuenew = $value;
        }
    }
    // $graph_value2 = $graph_value1[0] !== '' ?  $graph_value1[0] : '';
    $graph_value2 = $graph_valuenew !== '' ?  $graph_valuenew : '';
    $string = <<< heredoc
         <div class="thumbnail-function-php" >
             {$html}
               <div name="trig" class="multiple-trig-function-php trig-function-php">
                <input type="hidden" value='{$nasdaq_data}' class="tag-list"> 
                <input type="hidden" value='{$graph_value2}' id='tag-list-price-{$post_id}' class="tag-list-price">
                <input type="hidden" value='{$posted_date}' class="date-icon">  
               </div>
              <div class="thumbnail-transparent-bar" style="display:none;"></div>
        </div>
heredoc;
    }else if( strcmp( $size , "thumbnail-blog-featured" ) == 0  ){
    $nasdaq_datanew1 = array_diff($nasdaq_datanew1, array('featured'));
    $nasdaq_datanew = "";
    foreach ($nasdaq_datanew1 as $key => $value) {
        $nasdaq_datanew = $value;
    }
    $nasdaq_datanew1 = $nasdaq_datanew;
    //$graph_value2 = $graph_value1[0] !== '' ?  $graph_value1[0] : '';
    $nasdaq_data_price = "";
    $string = <<< heredoc
         <div class="video-container-graph" >
             {$html}
               <div id="graphdetail-{$post_id}" name="trig_featured" class="multiple-trig-function-php trig-function-php graph_instrument">
                <input type="hidden" value='{$nasdaq_datanew1}' class="instrument">
                <input type="hidden" value='{$nasdaq_data_price}' class="stockpostedprice">
                <input type="hidden" value='{$posted_date}' class="post_date">
                <div class='container frondendgraphhide' id='container-{$post_id}' ></div>
                <input type="hidden" value='{$post_id}' class="featured_post_id"> 
                <input type="hidden" value='{$nasdaq_data}' class="tag-list"> 
                <input type="hidden" value='{$graph_value2}' id='tag-list-price-{$post_id}' class="tag-list-price">
                <input type="hidden" value='{$posted_date}' class="date-icon">  
               </div>
              <div class="thumbnail-transparent-bar" style="display:none;"></div>
        </div>
heredoc;
    }
    else
    {
        return $html;
    } 
     return $string;
}

if( !is_admin() )
{
   add_filter( 'the_author', 'feed_author' ); 
}
function feed_author($name) {
    $fullname = $name;
    $display_name = explode(" ",$name);
    $name = isset($display_name[0]) && $display_name[0] ? $display_name[0] : '';
    $data  = get_the_author_meta( 'user_login' );
    $current_user = wp_get_current_user();
    $input = "//".$_SERVER['SERVER_NAME'];
    if($data==$current_user->user_login && is_user_logged_in()){
        $string .= $input."/myprofile";
    }else{
        $string .= $input."/".$data;
    }

   // $tag_addition = "<input type='hidden' value='{$input}'><a class=' the_author_link' style='color:blue !important;border-bottom:none;' href='{$string}'>$name</a>";
    if($name == 'Larry Iser'){
        $tag_addition = "<input type='hidden' value='{$input}'>
        <a class='the_author_link' target='_blank' style='color:blue !important;border-bottom:none;' href='http://www.kwikalaw.com '>Larry</a>";
    }else{
        $tag_addition = "<input type='hidden' value='{$input}'>
        <a class='the_author_link' style='color:blue !important;border-bottom:none;' title='{$fullname}'  href='{$string}'>$name</a>";
    }
    return $tag_addition;
}

function the_source($postid){
    global $wpdb;
    $no_url = false;
    $where = "";
    $source = get_post_meta($postid, "source",true);
    $source_link = get_post_meta($postid,"source_link",true );

    if( $source != '' ){
       // $source = str_replace(' ', '', $source);

 //     $where="sourceimg like '%".$source."%'";

     $where="sourceimg = '".$source.".jpg' or sourceimg = '".$source.".jpeg' or sourceimg = '".$source.".png'";

       $sql = "SELECT * FROM a1_source WHERE $where";
        $result = $wpdb->get_results($sql) or $no_url = true;
        if(sizeof($result)>0){
            if( $no_url )
            {
                $link = '';
            }
            else
            {
                $pos = strpos( $source_link, "http");
                if( $pos === false )
                {
                   $link = $result[0]->sourceurl;
                 }
                else
                {
                    $link = $source_link;
                }
            }

            $link_for_source_images = get_template_directory_uri()."/images/source/".$result[0]->sourceimg;
            $img_source = "<a class='inside-1' target='_blank'  href='{$link}'><img src='{$link_for_source_images}' style='height:auto;max-width:80px;'/></a>";
            echo  $img_source;
        }
    }
}

if( !is_admin() )
{
   add_filter( 'get_comment_author_link', 'get_comment_author_link_edit' ); 
} 

function get_comment_author_link_edit($name){
    $name = strip_tags( $name );
    return $name;    

}
function acf_load_select_field_choices( $field ) {
    $field['choices'] = array();
   // get the textarea value from options page without any formatting
    global $wpdb;
    $sql = "SELECT `sourcename`,`sourceimg` FROM a1_source";
    $result = $wpdb->get_results($sql) or die ('Error, query failed');
    $choices = array();
    foreach ( $result as $key => $value) {
        $img = pathinfo( $result[$key]->sourceimg , PATHINFO_FILENAME );
        $choices[ $img ] = $result[$key]->sourcename;
    }
    $choices = array_map('trim', $choices);
    $field['choices'] = $choices ;
    return $field;
}
add_filter('acf/load_field/name=source', 'acf_load_select_field_choices');
function acf_context( $field ) {
    $field['choices'] = array();
    // get the textarea value from options page without any formatting
    global $wpdb;
    $sql = "SELECT `contextname`,`contextimg` FROM a1_context";
    $result = $wpdb->get_results($sql) or die ('Error, query failed');
    $choices = array();
    foreach ( $result as $key => $value) {
      /*  $img = pathinfo( $result[$key]->contextimg , PATHINFO_FILENAME );
        if( $img == ''){
            $img = $result[$key]->contextname;
        }*/
        $choices[ $result[$key]->contextname ] = $result[$key]->contextname;
    }
    $choices = array_unique( $choices );
    $choices = array_map('trim', $choices);
    $field['choices'] = $choices ;
    return $field;
}
add_filter('acf/load_field/name=label_images', 'acf_context');

function acf_context_add( $post_id ){
    global $wpdb;
    $sql = "SELECT `contextname`,`contextimg` FROM a1_context";
    $result = $wpdb->get_results($sql) or die ('Error, query failed');
    $get_context_by_post = str_replace('.','',str_replace(' ','', get_post_meta( $post_id  , "label_images",true)));
    foreach ( $result as $key => $value) {
        if( strcmp( trim($result[$key]->contextname) , trim($get_context_by_post ) ) == 0 )
        {
            if( $result[$key]->contextimg == '' ){ return '<div ></div>';}
            $link = get_template_directory_uri().'/images/context/'.$result[$key]->contextimg;
            $html =  '<div><img alt="'.trim($result[$key]->contextname).'" src="'.$link.'" style="max-width:60px;" /></div>';
            return $html;
        }
    }
    return '<div></div>';
}
/*function prevent_wp_login_page( $username ){
     wp_redirect(home_url()."/sign-in/?action=Login-Failed");
}*/
function prevent_wp_login_page( $username ){
    //wp_redirect(home_url()."/sign-in/?action=Login-Failed");
    $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
    if(strpos($referrer,"sign-in")){
        wp_redirect(home_url()."/sign-in/?action=Login-Failed");
    }else{
        echo  json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
        exit();
    }
    die();
}

add_filter( 'wp_login_failed', prevent_wp_login_page , 20, 6 );

	add_filter( 'wp_nav_menu_items', 'add_loginout_link', 20, 5 );
	function add_loginout_link( $items, $args ) {
                    $link_for_share_and_update = site_url() . "/myprofile/?show=1"; //get_the_ID()
		if (is_user_logged_in()  && $args->menu_class == 'responsive-menu') {
			$items .= '<li  class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-1186">
						<a href="'. get_option('home') . '/myprofile/">My Profile</a></li>';
			$items .= '<li  class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-1186">
						<a href="'. get_option('home') .'/my-posting/">Write a Post</a></li>';
			$items .= '<li  class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-1186">
						<a href="'. get_option('home') .'/setting-page/">My Settings</a></li>';
			$items .= '<li  class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-1186">
						<a href="'. wp_logout_url() .'">Log Out</a></li>';
		}
		elseif(!is_user_logged_in() && $args->menu_class == 'responsive-menu') {
			$items .= '<li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-1186">
                       <a href="'. site_url("sign-in") .'">Sign In</a></li>';
			$items .= '<li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-1186">
                       <a href="'. site_url("user-registration") .'">Sign up</a></li>';
		}
		return $items;
	}
	add_filter( 'category_link', 're_get_category_link', 20, 5 );
	function re_get_category_link( $link , $id )
	{
		return  get_home_url()."/?cat_id=$id";
	}
    add_action( 'init', 'create_posttype' );
function create_posttype() {
  register_post_type( 'exchange',
    array(
      'labels' => array(
        'name' => __( 'Exchange' ),
        'singular_name' => __( 'Exchange' )
      ),
      'public' => true,
      'rewrite' => true,
      'show_ui' => true, // UI in admin panel
      '_builtin' => false, // It's a custom post type, not built in!
      '_edit_link' => 'post.php?post=%d',
      'capability_type' => 'post',
      'hierarchical' => false,
      'supports' => array(
      'title',
      'editor',
      'excerpt',
      'trackbacks',
      'custom-fields',
      'revisions',
      'thumbnail',
      'author',
      'page-attributes',
      )
    )
  );
}

remove_action( 'wp_ajax_fep_process_form_input', 'fep_process_form_input' );

add_action('wp_ajax_fep_process_form_input','fep_process_form_input1');
function fep_process_form_input1() { 
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
            'post_title'        => sanitize_text_field( $_POST['post_title'] ),
            'post_category'     => array( $_POST['post_category'] ),
            'tags_input'        => sanitize_text_field($_POST['post_tags']),
           // 'post_content'      => wp_kses_post($post_content),
          // 'post_content'      => strip_tags($post_content,"<b><strong><em><ul><li><iframe><p><code><!--more--><a><del><ins><img><blockquote>"),
           'post_content'      => $_POST['post_content'],  
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
        
        if($new_post_id){
            if(metadata_exists('post',$new_post_id,'graph_value')){
                update_post_meta($new_post_id,'graph_value', sanitize_text_field( $_POST['fep_tags_graph'] ));
            }else{
            add_post_meta( $new_post_id , 'graph_value',  sanitize_text_field( $_POST['fep_tags_graph'] ));
            }
        }
        if(metadata_exists('post',$new_post_id,'video_source')){
                update_post_meta($new_post_id,'video_source', $_POST['video_source'] );
            }else{
                add_post_meta( $new_post_id , 'video_source', $_POST['video_source'] );
        }

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

function get_graph( $post_ID ) {
    echo $post_ID;
    $graph_value = get_post_meta ($post_ID,'graph_value',true);
    $get_result = explode(",",$graph_value);
    $i = true;
    foreach ($get_result as $keys=>$value) {
      if( $i ){
        $get_result1[$keys] = explode(":",$value);
        $i = false;
      }
    }
    return  $get_result1;
}
add_action( 'get_graph', 'get_graph' );

/*function custom_admin_js() {
    $url = get_bloginfo('template_directory') . '/js/customadmin.js';
    $bootstrap = get_bloginfo('template_directory') . '/js/bootstrap.min.js';
    $urlcss = get_bloginfo('template_directory') . '/css/customadmin.css';
    $modalcss = get_bloginfo('template_directory') . '/css/modify-bootstrap.min.css';
    echo '"<script type="text/javascript" src="'. $url . '"></script>"';
    echo '<link rel="stylesheet" href="'. $urlcss . '" type="text/css" media="all" />';
    echo '<link rel="stylesheet" href="'. $modalcss . '" type="text/css" media="all" />';
    echo '"<script type="text/javascript" src="'. $bootstrap . '"></script>"';
}
add_action('admin_footer', 'custom_admin_js');
*/
function my_admin_scripts() {
wp_enqueue_script( "form-valid", get_template_directory_uri().'/js/jquery.validate.min.js', array('jquery') );
wp_enqueue_script( "customadmin", get_bloginfo('template_directory') . '/js/customadmin.js', array('jquery') );
wp_enqueue_script( "bootstrap", get_bloginfo('template_directory') . '/js/bootstrap.min.js', array('jquery') );
wp_enqueue_script('my-upload', get_bloginfo('template_directory') .'/js/my-script.js', array('jquery','media-upload','thickbox'));
wp_enqueue_script('my-upload');
wp_enqueue_media();
wp_enqueue_script( "fep-script-token", get_template_directory_uri().'/js/jquery.tokeninput.js', array('jquery') );
wp_localize_script( 'fep-scripta', 'fepajaxhandler', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
}
 
function my_admin_styles() {
wp_enqueue_style('thickbox');
wp_enqueue_style('customadmin',get_bloginfo('template_directory') . '/css/customadmin.css');
wp_enqueue_style('bootstrap-css',get_bloginfo('template_directory') . '/css/modify-bootstrap.min.css');
wp_enqueue_style( 'fep-style-token', get_bloginfo('template_directory') .'/css/frontend/token-input.css');
wp_enqueue_style( 'fep-style-token-facebook',  get_bloginfo('template_directory') .'/css/frontend/token-input-facebook.css');
wp_enqueue_style( 'fep-style-token-mac',  get_bloginfo('template_directory') .'/css/frontend/token-input-mac.css');
}
 
add_action('admin_print_scripts', 'my_admin_scripts');
add_action('admin_print_styles', 'my_admin_styles');

/* Proper way to enqueue scripts and styles */
//function mytheme_custom_scripts(){
    // Register and Enqueue a Stylesheet
    // get_template_directory_uri will look up parent theme location
//    wp_register_style( 'selectbox', get_template_directory_uri() . '/css/jquery.selectbox.css');
//    wp_enqueue_style( 'selectbox' );
//}

function frontend_graph( $id = false, $type = false,$context = false) {
   global $wpdb;
   $frondendgraph_table = $wpdb->prefix."frondendgraph";
   $context_table = $wpdb->prefix."context";
   $source_table = $wpdb->prefix."source";
       if($type=='graph'){
            $querystr = "select * from  ".$frondendgraph_table." where status=1 and id =".$id;
            $getrecords = $wpdb->get_results($querystr, OBJECT);
       }elseif($type=='context'){
            $querystrcontext = "select * from  ".$context_table;
            $allcontext = $wpdb->get_results($querystrcontext, OBJECT);
            foreach($allcontext as $key => $value ){
                if($context==$value->contextname){
                    $getrecords['context-image'] = $value->contextimg;
                }
            }
       }elseif($type=='image'){
            $size = array(950,663);  
            $getrecords = wp_get_attachment_image_src(  $id , $size);
       }elseif($type=='source'){
            $querystrsource = "select * from  ".$source_table;
            $allsource = $wpdb->get_results($querystrsource, OBJECT);
            foreach($allsource as $key => $value ){
                if($context == $value->sourcename){
                    $getrecords['source'] = $value->sourceimg;
                }
            }
       }else{

       }
   return $getrecords;
}

function graph_human_time_diff( $from, $to = '' ) {
        if ( empty( $to ) )
                $to = time();
        $diff = (int) abs( $to - $from );
        if ( $diff <= HOUR_IN_SECONDS ) {
                $mins = round( $diff / MINUTE_IN_SECONDS );
                if ( $mins <= 1 ) {
                        $mins = 1;
                }
                /* translators: min=minute */
                $since = sprintf( _n( '%s min', '%s mins', $mins ), $mins );
        } elseif ( ( $diff <= DAY_IN_SECONDS ) && ( $diff > HOUR_IN_SECONDS ) ) {
                $hours = round( $diff / HOUR_IN_SECONDS );
                if ( $hours <= 1 ) {
                        $hours = 1;
                }
                $since = sprintf( _n( '%s hour', '%s hours', $hours ), $hours );
        } elseif ( $diff >= DAY_IN_SECONDS ) {
                $days = round( $diff / DAY_IN_SECONDS );
                if ( $days <= 1 ) {
                        $days = 1;
                }
                $since = sprintf( _n( '%s day', '%s days', $days ), $days );
        }
        return $since;
}

function make_script_async( $tag, $handle, $src )
{
    if ( 'my_script' == $handle || 'frontend-script' == $handle ) {
        return str_replace( '<script', '<script async', $tag );
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'make_script_async', 10, 3 );

/*this function is used to add Whotrades on right sidebar*/
function load_my_script(){
    wp_register_script( 
        'my_script', 
         '//partners.whotrades.com/static/js/newsplugin.js', 
        array( 'jquery' )
    );
    //wp_enqueue_script( 'my_script' ); 
  //  wp_register_style( 'my-plugin','//partners.whotrades.com/stcache/40/401b1f88a8.css' );
    wp_enqueue_style( 'my-plugin' );
    wp_register_script( 
        'slimscroll-script', 
        get_template_directory_uri() . '/js/jquery.slimscroll.min.js', 
        array( 'jquery' )
    );
    wp_enqueue_script( 'slimscroll-script' );
    wp_register_script( 
        'frontend-script', 
        get_template_directory_uri() . '/js/frontend-script.js', 
        array( 'jquery' )
    );
    wp_enqueue_script( 'frontend-script' );
    //wp_enqueue_script("form-valid-frontend",get_template_directory_uri().'/js/jquery.validate.min.js',array('jquery'));
    wp_enqueue_script("form-valid-frontend",get_template_directory_uri().'/js/new_jquery.validate.js',array('jquery')); 
   wp_register_script( 
        'jquery.ddslick', 
        get_template_directory_uri() . '/js/jquery.ddslick.min.js', 
        array( 'jquery' )
    );
    wp_enqueue_script( 'jquery.ddslick' );
    
   wp_register_style( 'modal-css',get_template_directory_uri() . '/css/jquery.modal.css' );
    wp_enqueue_style( 'modal-css' );
    wp_register_script( 
        'modal-js', 
        get_template_directory_uri() . '/js/jquery.modal.js', 
        array( 'jquery' )
    );
    wp_enqueue_script( 'modal-js' );
}
add_action('wp_enqueue_scripts', 'load_my_script');

function graph_container( $paged) {
    global $wpdb;
    $frondendgraph_table = $wpdb->prefix."frondendgraph";
    $querystr = "select * from  ".$frondendgraph_table." where status=1 order by id Desc";
    $allcontext = $wpdb->get_results($querystr, OBJECT);
    return $allcontext;
}


add_action( 'init', 'my_script_enqueuer' );

function my_script_enqueuer() {
   wp_register_script( "my_voter_script", WP_PLUGIN_URL.'/tab/js/tab.js', array('jquery') );
   wp_localize_script( 'my_voter_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        

   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'my_voter_script' );

}

/*Below function is used to add the guest user in chat*/
add_action("wp_ajax_add_guest_user", "add_guest_user");
add_action("wp_ajax_nopriv_add_guest_user", "add_guest_user");

function add_guest_user() {
   global $wpdb; 
   $name = ucfirst(stripslashes($_REQUEST["chaterName"])); 
   $posted_date = $_REQUEST["inputDate"];
   $operation = $wpdb->query( $wpdb->prepare("INSERT INTO retirely_messages (name,user_type,msg,posted) VALUES ( %s,%s,%s,%s)",array($name,'guest','',$posted_date)));
   $result = [];
   $result['chatterName'] = stripslashes($name) ;
   if($operation) {
      $result['res'] = true;
	}else {
      $result['res'] = false;
    }
	echo json_encode($result);
    die();	
}

/*this function is used to get the past chat*/
add_action("wp_ajax_get_chat", "get_chat");
add_action("wp_ajax_nopriv_get_chat", "get_chat");

function get_chat() {
   global $wpdb; 
   $lastChatID = (isset($_REQUEST["lastChatID"]) && $_REQUEST["lastChatID"] > 0) ?  $_REQUEST["lastChatID"] : 0 ;
   $querystr = "select * from retirely_messages WHERE  msg != '' and chat_id > $lastChatID order by chat_id";
   $getRecords = $wpdb->get_results($querystr, OBJECT);
   $counter= count($getRecords);
   $html = '';
   $result = [];
   if($counter){
	   foreach($getRecords as $key=>$value){
		 $result['last_id'] = $value->chat_id;
         $avatar =''; 
         if ($value->sender_id !=0){
            $avatardata = get_avatar($value->sender_id, 30);
            $src = (string) reset(simplexml_import_dom(DOMDocument::loadHTML($avatardata))->xpath("//img/@src"));
            $srcarr = explode('/', $src);
            if (strpos($src, "retire.ly")>0) {
                $avatar = get_avatar($value->sender_id, 30);
            }else{
                $avatar = '<img alt="" src="http://www.akc.org/assets/default-avatar.png" class="codey avatar avatar-30 photo" height="30" width="30">';
            }
         }else{
           $avatar = '<img alt="" src="//bitbucket-assetroot.s3.amazonaws.com/c/photos/2012/Nov/19/gravatar-taglib-logo-1063751969-6_avatar.png" class="codey avatar avatar-30 photo" height="30" width="30">';
         }

	        $html .= "<div class='msg' title=".stripslashes($value->name).">".$avatar."<span class='chatername'>".stripslashes($value->name).":<span class='chat-datetime'>{$value->posted}</span></span><span class='msgc'>".stripslashes($value->msg)."</span></div>";
            }
	   $result['msgs'] = $html;
   }else{
	   $result['last_id'] = '';
	   $result['msgs'] = '';
   }
   //print_r($result);
   //die;
   echo json_encode($result);
   die();	
}

/*this function is used to submit message*/
add_action("wp_ajax_submit_message", "submit_message");
add_action("wp_ajax_nopriv_submit_message", "submit_message");

function submit_message() {
	global $wpdb;
	$senderID = (isset($_REQUEST["senderID"]) && $_REQUEST["senderID"] > 0) ?  $_REQUEST["senderID"] : 0 ;
	$user_type = (isset($_REQUEST["senderID"]) && $_REQUEST["senderID"] > 0) ?  'logged_in_user' : 'guest' ;
	$posted_date = $_REQUEST["inputDate"];
	$senderName = $_REQUEST["senderName"];
	$msg = stripslashes($_REQUEST["msg"]);
        $operation = $wpdb->query( $wpdb->prepare("INSERT INTO retirely_messages (name,sender_id,user_type,msg,posted) VALUES ( %s,%d,%s,%s,%s)",array($senderName,$senderID,$user_type,$msg,$posted_date)));
    $result = [];
    if($operation) {
      $result['res'] = true;
    }else {
      $result['res'] = false;
    }
	echo json_encode($result);
    die();
}

/*this function is used to count login user*/
function getLoggedInUser() {
   global $wpdb;
   $sql ="UPDATE online_users SET counter = counter+1 WHERE key_way = 'logged_in_user'";
   $wpdb->query($sql);
}
add_action('wp_login', 'getLoggedInUser');

/*this function is used to substract login user*/
add_action('wp_logout', 'substractLogInUser');
function substractLogInUser(){
  global $wpdb;
   $sql ="UPDATE online_users SET counter = counter-1 WHERE key_way = 'logged_in_user'";
   $wpdb->query($sql);
}

/*get online logged in user*/
function loggedInUserCount(){
   global $wpdb;
   $sql ="select counter from online_users WHERE key_way = 'logged_in_user' ";
   $opt = $wpdb->get_results($sql, OBJECT); 
   return $opt[0]->counter;
}

/*Below function is used to get recent post for intlface.com*/
add_action("wp_ajax_get_all_posts", "get_all_posts");
add_action("wp_ajax_nopriv_get_all_posts", "get_all_posts");

function get_all_posts() {
   global $wpdb; 
   $post = '';
   $args = array(
    'numberposts' => 30,
    'offset' => 0,
    'category' => 0,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'include' => '',
    'exclude' => '',
    'meta_key' => '',
    'meta_value' => '',
    'post_type' => 'post',
    'post_status' => 'draft, publish, future, pending',
    'suppress_filters' => true );

    $recent_posts = wp_get_recent_posts( $args, ARRAY_A );
    if(count($recent_posts)){
               foreach($recent_posts as $key=>$value){
			$post[$value['ID']]['title'] = $value['post_title'];
			$post[$value['ID']]['url'] = $value['guid'];
		}
	}else{
		$result = -1 ;
	}
  //print_r($post);
	//echo json_encode($post);
echo json_encode($post, JSON_UNESCAPED_SLASHES), "\n";
   die();	
}

/*get count of the comments*/
function getPostLikeDislikecount($comment_id,$user_id){
   global $wpdb;
   $data = ''; 
   $sql ="select sum(`like_dislike`) as likecount from a1_commentlike WHERE comment_id = ".$comment_id."";
   $sql2 ="select like_dislike from a1_commentlike WHERE user_id = ".$user_id." and comment_id = ".$comment_id."";
   $opt = $wpdb->get_results($sql, OBJECT);
   $opt2 = $wpdb->get_results($sql2, OBJECT);
   if(isset($opt[0]->likecount) && $opt[0]->likecount != ''){
        $data['comment_counter'] = $opt[0]->likecount ;
   }else{
        $data['comment_counter'] = 0 ;
   }
   if(isset($opt2[0]->like_dislike) &&$opt2[0]->like_dislike != '' && $user_id != ''){
        $data['commenter_status'] = $opt2[0]->like_dislike;
   }else{
        $data['commenter_status'] = 0 ;
   }
   return $data;
}
 

/*Below function is used to add the like or dislike when user clicked on button*/
add_action("wp_ajax_add_action_on_comment", "add_action_on_comment");
add_action("wp_ajax_nopriv_add_action_on_comment", "add_action_on_comment");

function add_action_on_comment() {
   global $wpdb; 
   $comment_id = $_REQUEST["comment_id"];
   $operation = $_REQUEST["operation"]; 
   $opt = ($operation == 'dislike') ? -1 : +1;
   $user_id = get_current_user_id();
   $output = [];
   $sql ="select id from a1_commentlike WHERE user_id = ".$user_id." and comment_id = ".$comment_id."";
   $selectResult = $wpdb->get_results( $sql );
   $output['res'] = false;
   if(isset($selectResult[0]) && $selectResult[0]->id != ''){
      /*this is called will on update like or dislike*/
      $updateResult = $wpdb->update( 
        'a1_commentlike', 
        array( 
            'like_dislike' => $opt,  
        ), 
        array( 'comment_id' => $comment_id , 'user_id' => $user_id)
      );
      $output['res'] = true;
      $output['update'] = true;
   }else{
        $flag =$wpdb->insert("a1_commentlike", array(
           "comment_id" => $comment_id,
           "user_id" => $user_id ,
           "like_dislike" => $opt,
        ));
        if($flag){
            $output['res'] = true;    
        }
        $output['insert'] = true;
   }
    $getCount = getPostLikeDislikecount($comment_id,$user_id);
    $output['comment_counter'] = $getCount['comment_counter'];
    echo json_encode($output);
    die;
}

// This will occur when the comment is posted
function plc_comment_post( $incoming_comment )
{

    // convert everything in a comment to display literally
    $incoming_comment['comment_content'] = strip_tags( $incoming_comment['comment_content'] );

    // the one exception is single quotes, which cannot be #039; because WordPress marks it as spam
    $incoming_comment['comment_content'] = str_replace( "'", '&apos;', $incoming_comment['comment_content'] );

    return( $incoming_comment );
}

// This will occur before a comment is displayed
function plc_comment_display( $comment_to_display )
{

    // Put the single quotes back in
    $comment_to_display = str_replace( '&apos;', "&#039;", $comment_to_display );

    return $comment_to_display;
}

add_filter( 'preprocess_comment', 'plc_comment_post', '', 1);
add_filter( 'comment_text', 'plc_comment_display', '', 1);
add_filter( 'comment_text_rss', 'plc_comment_display', '', 1);
add_filter( 'comment_excerpt', 'plc_comment_display', '', 1);
remove_filter( 'comment_text', 'make_clickable', 9 );

function ajax_login(){
    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    }

    die();
}
/*this is function for ajax login */
add_action( "wp_ajax_nopriv_ajaxlogin", "ajax_login" );
add_action("wp_ajax_add_ajaxlogin", "ajax_login");
/*this is using to redirect user after login */
function do_anything() {
    $location = $_SERVER['HTTP_REFERER'];
    global $wpdb;
    global $wpdb;
    $user = $_POST['log'];
    $email = "";
    $querystr = "SELECT * FROM a1_users where user_login='".$user."'";
    $getuser = $wpdb->get_results($querystr, OBJECT);
    if($getuser[0]->user_login==$user){
        $email = $getuser[0]->user_email;
    }
    $password = base64_encode("123456");
    echo "<script>window.location.href='https://www.retire.ly/financialadvisors/action.php?action=autologin&e=".$email."&p=".$password."'</script>";
    //wp_safe_redirect($location);
    exit();
}
add_action('wp_login', 'do_anything');


/*Below function is used to add the like or dislike when user clicked on top gainer detail page.*/
add_action("wp_ajax_add_action_on_top_gainer", "add_action_on_top_gainer");
add_action("wp_ajax_nopriv_add_action_on_top_gainer", "add_action_on_top_gainer");

function add_action_on_top_gainer() {
   global $wpdb; 
   $task = $_REQUEST["task"];
   $post_id = $_REQUEST["post_id"]; 
   if ( $task == "like" ) {
      /*this is called will on update like or dislike*/
        $query = $wpdb->prepare(
                "UPDATE a1_frondendgraph SET votes = votes + 1 WHERE id = %d",$post_id
                );
    }elseif($task == "unlike" ){
        $query = $wpdb->prepare(
                "UPDATE a1_frondendgraph SET votes = votes - 1 WHERE id = %d",$post_id
        );
    }else{
    }
    $success = $wpdb->query( $query );
    $query1 = $wpdb->prepare(
                "select votes from a1_frondendgraph WHERE id = %d",$post_id
        ); 
    $getData = $wpdb->get_results($query1, OBJECT);;
    if(isset($getData[0]) && $getData['0']->votes != ''){
       $output['count'] = $getData['0']->votes;
    }else{
       $output['count'] = 0;
    }
    if ($success){
        $output['response'] = 0;
        $output['msg']  = __( 'Thanks for your vote.', 'wti-like-post' );
    }else{
        $output['response'] = 1;
        $output['msg'] = __( 'Could not process your vote.', 'wti-like-post' );
    }
    echo json_encode($output);
    die;
}

/*Below function is used to add the like or dislike when user clicked on top gainer detail page.*/
add_action("wp_ajax_add_action_on_post_frontend", "add_action_on_post_frontend");
add_action("wp_ajax_nopriv_add_action_on_post_frontend", "add_action_on_post_frontend");

function add_action_on_post_frontend() {
   global $wpdb; 
   $post_id = $_REQUEST["post_id"];
   $task = $_REQUEST["task"]; 
   $opt = ($task == 'unlike') ? -1 : +1;
   $user_id = get_current_user_id();
   $output = [];
   $sql ="select id from a1_postlike WHERE user_id = ".$user_id." and post_id = ".$post_id."";
   $selectResult = $wpdb->get_results( $sql );
   $output['res'] = false;
   if(isset($selectResult[0]) && $selectResult[0]->id != ''){
      /*this is called will on update like or dislike*/
      $updateResult = $wpdb->update(
        'a1_postlike',
        array(
            'like_dislike' => $opt,
        ),
        array( 'post_id' => $post_id , 'user_id' => $user_id)
      );
      $output['res'] = true;
      $output['update'] = true;
   }else{
        $flag =$wpdb->insert("a1_postlike", array(
           "post_id" => $post_id,
           "user_id" => $user_id ,
           "like_dislike" => $opt,
        ));
        if($flag){
            $output['res'] = true;
        }
        $output['insert'] = true;
   }
    //$getCount = getPostsLikeDislikecount($post_id,$user_id);
    //$output['post_counter'] = $getCount['post_counter'];
    $getCount = getSinglePostLikeDislikecount($post_id);
    $output['post_counter'] = $getCount['like_counter']+$getCount['dislike_counter'];
    $likedislike_users = getSinglePostLikeDislikeUsers($post_id);
    $post_user_list = '<div class="like-unlike-popup-like"><div class="rtl-like rtl-like-rtl-Dislike"> <p style="padding:0px 15px;">Like '.$getCount['like_counter'].'</p></div><ul class="like-unlike-popup-list">';
    foreach($likedislike_users['like_users'] as $userlikeval){
        $users_data = get_userdata( $userlikeval->user_id );
        $post_user_list.= '<li><a href="Javascript:void(0);">'.get_avatar($userlikeval->user_id,31).$users_data->display_name.'</a></li>';
    }
    $post_user_list.= '</ul></div><div class="like-unlike-popup-unlike"><div class="rtl-Dislike rtl-like-rtl-Dislike"><p style="padding:0px 15px;">Dislike '.$getCount['dislike_counter'].'</p></div><ul class="like-unlike-popup-list">';
    foreach($likedislike_users['dislike_users'] as $userlikeval){
        $users_data = get_userdata( $userlikeval->user_id );
        $post_user_list.= '<li><a href="Javascript:void(0);">'.get_avatar($userlikeval->user_id,31).$users_data->display_name.'</a></li>';
    }

    $post_user_list.= '</ul></div>';
    $output['post_users_list'] = $post_user_list;
    echo json_encode($output);
    die;
}
/*get count of the posts*/
function getPostsLikeDislikecount($post_id,$user_id){
   global $wpdb;
   $data = ''; 
   $sql  ="select sum(`like_dislike`) as likecount from a1_postlike WHERE post_id = ".$post_id."";
   $sql2 ="select like_dislike from a1_postlike WHERE user_id = ".$user_id." and post_id = ".$post_id."";
   $opt = $wpdb->get_results($sql, OBJECT);
   $opt2 = $wpdb->get_results($sql2, OBJECT);
   if(isset($opt[0]->likecount) && $opt[0]->likecount != ''){
        $data['post_counter'] = $opt[0]->likecount ;
   }else{
        $data['post_counter'] = 0 ;
   }
   if(isset($opt2[0]->like_dislike) &&$opt2[0]->like_dislike != '' && $user_id != ''){
        $data['user_post_status'] = $opt2[0]->like_dislike;
   }else{
        $data['user_post_status'] = 0 ;
   }
   return $data;
}

function getSinglePostLikeDislikecount($post_id){
   global $wpdb;
   $data = ''; 
   $sql  ="select count(*) as likecount from a1_postlike WHERE post_id = ".$post_id." and like_dislike=1";
   $sql2  ="select count(*) as likecount from a1_postlike WHERE post_id = ".$post_id." and like_dislike=-1";
   $opt = $wpdb->get_results($sql, OBJECT);
   $opt2 = $wpdb->get_results($sql2, OBJECT);
   if(isset($opt[0]->likecount) && $opt[0]->likecount != ''){
        $data['like_counter'] = $opt[0]->likecount ;
   }
   if(isset($opt2[0]->likecount) && $opt2[0]->likecount != ''){
        $data['dislike_counter'] = $opt2[0]->likecount ;
   }

   return $data;
}

function getSinglePostLikeDislikeUsers($post_id){
   global $wpdb;
   $data = ''; 
   $sql  ="select user_id from a1_postlike WHERE post_id = ".$post_id." and like_dislike=1";
   $sql2  ="select user_id from a1_postlike WHERE post_id = ".$post_id." and like_dislike=-1";
   $opt = $wpdb->get_results($sql);
   $opt2 = $wpdb->get_results($sql2);
   $data['like_users'] = $opt;
   $data['dislike_users'] = $opt2;

   return $data;
}

add_action( 'wp_insert_post', 'filter_handler', '99', 2  );
function filter_handler( $postid , $data ){
   
    $tags = wp_get_post_tags($postid);
      
   $tag_list = '';
   foreach($tags as $tag){
        $string = $tag->name;
        $yql_query_url ="https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quotes%20where%20symbol%20in%20(%22$string%22)&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys";
        $ch = $session = curl_init($yql_query_url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
        $json = curl_exec($session);
        $jsonnew = json_decode($json,true);
        if( count($tags) == 1 ){
            $tag_list = $string .':'.$jsonnew[query][results][quote][LastTradePriceOnly];
        }else{
            $tag_list .= $string .':'.$jsonnew[query][results][quote][LastTradePriceOnly].',';
        }
   }

   $tag_list = trim($tag_list, ",");
   update_post_meta($postid,'graph_value',$tag_list);
}
/*Below function is used to get source link image on posting page*/
add_action("wp_ajax_get_website_image", "get_website_image");
add_action("wp_ajax_nopriv_get_website_image", "get_website_image");

function get_website_image() {
   global $wpdb;
   ini_set('error_reporting', E_STRICT);
   $output = array();
    $source_link = $_REQUEST['source_link'];
    if(isset($source_link)){
        $sql  ="SELECT `sourcename`,`sourceimg` FROM `" . $wpdb->prefix . "source` WHERE `sourceurl` LIKE '".$source_link."'";
         $result = $wpdb->get_results($sql);
         
         if (sizeof($result)) {
             $output= $result;
             $var1 = $output[0]->sourceimg;
             $value_tmp = explode('.', $var1);

             $value_name = $value_tmp[0];

             $feched_img = $output[0]->sourceimg;
             $new_img = get_template_directory_uri().'/images/source/'.$feched_img;
             $output[0]->sourceimg = $new_img;
             $output[1] = $value_name;
            

           echo wp_send_json($output);
          
         }else{
             $output[0]->sourceimg = '//d3aauwrblcdnb4.cloudfront.net/wp-content/uploads/2017/06/12130930/oie_vrOTKYplXH2T.png';
             $output[1] = '';
            echo wp_send_json($output);
         }
        //die;
    }else{
        return false;
    }
}
?>

