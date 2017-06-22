<?php 

/* 

Template Name: ShareUpdate 

*/ 

?>
 
<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<head>
    <?php
    // Options from admin panel
    global $smof_data;
    
    $favicon = $smof_data['custom_favicon'];
    if (empty($favicon)) { $favicon = get_template_directory_uri().'/images/web-icon.png'; }
    
    $site_logo = $smof_data['site_logo'];
    if (empty($site_logo)) { $site_logo = get_template_directory_uri().'/images/logo.png'; }

    if (empty($smof_data['featured-posts'])) { $smof_data['featured-posts'] = '12'; }
    $boxed_version_select = (isset($smof_data['boxed_version_select'])) ? $smof_data['boxed_version_select'] : 'No';
    ?>
    <!-- Meta Tags -->
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

    <!-- Title -->
    <?php if ( ! function_exists( '_wp_render_title_tag' ) ) { function theme_slug_render_title() { ?>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php } add_action( 'wp_head', 'theme_slug_render_title' ); } // Backwards compatibility for older versions. ?> 

    <!-- Mobile Device Meta -->
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui' /> 
    
    <!-- The HTML5 Shim for older browsers (mostly older versions of IE). -->
    <!--[if IE]> <script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/html5.js"></script> <![endif]-->

    <!-- Favicons and rss / pingback -->
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php esc_url(bloginfo('rss2_url')); ?>" />
    <link rel="pingback" href="<?php esc_url(bloginfo('pingback_url')); ?>" />
    <link rel="shortcut icon" type="image/png" href="<?php echo esc_url($favicon); ?>"/>  
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.min.css">	
	<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>


    <!-- Custom style -->
    <?php echo get_template_part('custom-style'); ?>

    
</head>
<body <?php if ($boxed_version_select == 'Yes') { ?>id="boxed-style" <?php body_class(); ?>>
     
    <div class="featured-articles">
  <?php echo do_shortcode("[fep_submission_form]"); ?>

<div class="clear"></div>             
</div><!-- end .featured-articles -->
<?php }  ?>
