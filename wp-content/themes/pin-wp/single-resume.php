<?php get_header(); // add header ?>  
<?php
    // Options from admin panel
    global $smof_data;

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
    	
    	<div class="entry">
		<?php echo wp_kses_post(do_shortcode('[rb_resume id="'.$post->ID.'"]')); ?>
		</div><!-- end .entry -->
    </div><!-- end .single-content -->

    <!-- Begin Sidebar (right) -->
    <?php  get_sidebar(); // add sidebar ?>
    <!-- end #sidebar  (right) -->   

    <div class="clear"></div>
</div><!-- end .wrap-fullwidth  -->
<?php get_footer(); // add footer  ?>