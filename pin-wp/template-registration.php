<?php 

/* 

Template Name: Registration

*/ 

?>
<?php
 if ( is_user_logged_in()){
     wp_redirect(site_url('/myprofile/')); 
	 exit;
    }
?>	
<?php get_header();?>
<?php 
	 echo do_shortcode("[custom_registration]");	 
	
    // Options from admin panel

    global $smof_data;



    if (empty($smof_data['banner_p1'])) { $smof_data['banner_p1'] = ''; }

    if (empty($smof_data['banner_p2'])) { $smof_data['banner_p2'] = ''; }

    if (empty($smof_data['banner_p3'])) { $smof_data['banner_p3'] = ''; }

    if (empty($smof_data['banner_p3'])) { $smof_data['banner_p4'] = ''; }

    if (empty($smof_data['banner_p3'])) { $smof_data['banner_p5'] = ''; }

    $home_pag_select = (isset($smof_data['home_pag_select'])) ? $smof_data['home_pag_select'] : 'Infinite Scroll';

?>



<!-- Begin Home Full width -->

<div class="home-fullwidth">



    <!-- Begin Sidebar (left) -->

    <?php //get_template_part('sidebar2'); ?>

    <!-- end #sidebar (left) --> 



    <!-- Begin Main Wrap Content -->

    <div class="wrap-content" style="margin-left: 12%;background-color: transparent;">



        <ul id="infinite-articles" class="7 masonry_list js-masonry" data-masonry-options='{ "columnWidth": 0 }'>

        <?php

            if ( get_query_var('paged') )  {  $paged = get_query_var('paged'); 

            } elseif ( get_query_var('page') ) { $paged = get_query_var('page');

            } else { $paged = 1;  }

            query_posts( array( 'post_type' => 'post', 'paged' => $paged  ) );

            $num=0; if (have_posts()) : while (have_posts()) : the_post(); $num++;

        ?>



            <?php if (!empty($smof_data['banner_300_1'])) { ?>

                <?php if ($num==$smof_data['banner_p1']) { echo '<li class="ex34 homeadv">'. stripslashes($smof_data['banner_300_1']) .' <span> '. esc_html__('Advertisement', 'anthemes') .'</span></li>';} ?>

            <?php } ?>

            <?php if (!empty($smof_data['banner_300_2'])) { ?>

                <?php if ($num==$smof_data['banner_p2']) { echo '<li class="ex34 homeadv">'. stripslashes($smof_data['banner_300_2']) .' <span> '. esc_html__('Advertisement', 'anthemes') .'</span></li>';} ?>

            <?php } ?>    

            <?php if (!empty($smof_data['banner_300_3'])) { ?>

                <?php if ($num==$smof_data['banner_p3']) { echo '<li class="ex34 homeadv">'. stripslashes($smof_data['banner_300_3']) .' <span> '. esc_html__('Advertisement', 'anthemes') .'</span></li>';} ?>

            <?php } ?>      

            <?php if (!empty($smof_data['banner_300_4'])) { ?>

                <?php if ($num==$smof_data['banner_p4']) { echo '<li class="ex34 homeadv">'. stripslashes($smof_data['banner_300_4']) .' <span> '. esc_html__('Advertisement', 'anthemes') .'</span></li>';} ?>

            <?php } ?>   

            <?php if (!empty($smof_data['banner_300_5'])) { ?>

                <?php if ($num==$smof_data['banner_p5']) { echo '<li class="ex34 homeadv">'. stripslashes($smof_data['banner_300_5']) .' <span> '. esc_html__('Advertisement', 'anthemes') .'</span></li>';} ?>

            <?php } ?> 



            <li <?php post_class('ex34') ?> id="post-<?php the_ID(); ?>">



                <?php if ( has_post_thumbnail()) { ?>
                   <a class="thumbnail-blog-link"  href="<?php the_permalink(); ?>"> <?php echo the_post_thumbnail('thumbnail-blog-masonry'); ?> </a> 
                <?php } else {?>
                <?php  $video_source =  get_post_meta( get_the_ID(), 'video_source', true );  ?>
                <?php if(isset($video_source) && $video_source != '' && !has_post_thumbnail( get_the_ID() ) ) { ?> 
                    <?php echo html_entity_decode($video_source); ?>
                <?php }?> 
                <?php }// Post Thumbnail ?>  

                <div class="clear"></div>
	            <?php get_template_part("card","tags");?>
                <div class="home-meta">

                    <div class="an-display-time updated"><i class="fa fa-clock-o"></i> <?php echo time_ago_anthemes(); ?> <?php esc_html_e('ago', 'anthemes'); ?></div>

                    <div class="an-display-view"><i class="fa fa-eye"></i> <?php echo getPostViews_anthemes(get_the_ID()); ?></div>      

                        <div class="home-data">

                            <?php if (function_exists('thumbs_rating_getlink')) { echo thumbs_rating_getlink(); } ?>

                        </div><!-- end .home-data -->                        

			<div class="shortcode-my">
                        <?php  $post_url = get_permalink ($post->ID); ?>
       	                 <?php echo do_shortcode('[ssba url='.$post_url.']'); ?> 
			</div>

                    <div class="clear"></div> 

                </div><!-- Meta ( time and comments ) --> 



            </li>

        <?php endwhile; endif; ?>

        </ul><!-- end .masonry_list --> 



         <!-- Pagination -->

        <?php if ($home_pag_select == 'Infinite Scroll') { ?>

            <div id="nav-below" class="pagination" style="display: none;">

                    <div class="nav-previous"><?php previous_posts_link('&lsaquo; ' . esc_html__('Newer Entries', 'anthemes') . ''); ?></div>

                    <div class="nav-next"><?php next_posts_link('' . esc_html__('Older Entries', 'anthemes') . ' &rsaquo;'); ?></div>

            </div>

        <?php } else { // Infinite Scroll ?>

            <div class="clear"></div>

            <?php if(function_exists('wp_pagenavi')) { ?>

            <?php wp_pagenavi(); ?>

            <?php } else { ?>

            <div class="defaultpag">

                <div class="sright"><?php next_posts_link('' . esc_html__('Older Entries', 'anthemes') . ' &rsaquo;'); ?></div>

                <div class="sleft"><?php previous_posts_link('&lsaquo; ' . esc_html__('Newer Entries', 'anthemes') . ''); ?></div>

            </div>

            <?php } ?>

        <?php } // Default Pagination ?>

        <!-- pagination -->



    </div><!-- end .wrap-content -->



        

<div class="clear"></div>

</div><!-- end .home-fullwidth -->

<?php get_footer(); // add footer  ?>
