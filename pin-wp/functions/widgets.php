<?php 
// Register widgetized areas
function theme_widgets_init() {

    register_sidebar( array (
		'name' => esc_html__( 'Home Sidebar (Left)', 'anthemes' ),
		'id' => 'sidebar-left-home',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3><div class="clear"></div>',
	) );

    register_sidebar( array (
		'name' => esc_html__( 'Default Sidebar (Right)', 'anthemes' ),
		'id' => 'sidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3><div class="clear"></div>',
	) );
}

add_action( 'init', 'theme_widgets_init' );
?>