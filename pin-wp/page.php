<?php 
/* 
Template Name: Template - Default with Sidebar
*/ 
?>
<?php get_header(); // add header ?>  
<?php 
	if( isset( $_GET['key'] ) )
    {
		$user = filter_input( INPUT_GET, 'user', FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1 ) ) );
        if ( $user ) {
            $code = get_user_meta( $user, 'has_to_be_activated', true );
			if ( $code == filter_input( INPUT_GET, 'key' ) ) {
				delete_user_meta( $user, 'has_to_be_activated' );
			}
        }
    }
?>

<!-- Begin Content -->
<div class="wrap-fullwidth">

    <div class="single-content">

        <!-- ads -->
        <?php if (!empty($smof_data['header_728'])) { ?>
        <div class="single-box">
            <div class="single-money">
            <?php echo stripslashes($smof_data['header_728']); ?>
            </div>
        </div><div class="clear"></div>
        <?php } ?>
              
        <article>
            <?php if (have_posts()) : while (have_posts()) : the_post();  ?>
            <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">             

                        <div class="entry">
                          <h1 class="page-title"><?php the_title(); ?></h1>
                          <?php the_content(''); // content ?>
                          <?php wp_link_pages(); // content pagination ?>
                          <div class="clear"></div><br />
                        </div><!-- end #entry -->
            </div><!-- end .post -->
            <?php endwhile; endif; ?>
        </article>
    </div><!-- end .single-content -->

    <!-- Begin Sidebar (right) -->
    <?php  get_sidebar(); // add sidebar ?>
    <!-- end #sidebar  (right) -->    

    <div class="clear"></div>
</div><!-- end .wrap-fullwidth -->

<?php get_footer(); // add footer  ?>