<?php
	/*
	Template Name: Data Manupulation
	*/
     get_header(); // add header



	query_posts( array( 'post_type' => 'post', 'tag' => 'featured' ) );
	if (have_posts()) : while (have_posts()) : the_post();

		global $post;

		var_dump( $post->ID );
		var_dump( $post->post_type );
		$post->post_type = 'exchange';
		wp_update_post( $post );



	endwhile;
	endif;
?>
<?php get_footer(); // add footer  ?>
