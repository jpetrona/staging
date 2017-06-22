<?php get_header(); // add header ?>  

<style type="text/css">
.tag-shifter {
 left: 10px;
 position: relative;
 top: -30px;
}
</style>
<?php 
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}



?>
<?php

    // Options from admin panel

global $smof_data;



?>





<!-- Begin Content -->
<?php if(is_user_logged_in()){
  echo do_shortcode("[SignIn val='']"); 
}
?>

<div class="wrap-fullwidth">

 <div>

    <div class="single-content">

        <!-- ads -->

        <?php if (!empty($smof_data['header_728'])) { ?>

        <div class="single-box">

            <div class="single-money">

                <?php echo stripslashes($smof_data['header_728']); ?>

            </div>

        </div><div class="clear"></div>

        <?php } ?>

      

        <!-- end .single-box -->







        <?php if (have_posts()) : while (have_posts()) : the_post();  ?>
        <div>
            <div class="author-image-single"  >

                            <?php echo get_avatar(  $post->post_author  , 32 ); ?>
            </div>
            <div class="author-display-name-single" >
                <?php  the_author(); ?>
            </div>

            <div class="author-display-time-single" >
                <div>
                    <?php echo time_elapsed_string( $post->post_date ); ?>
                    <?php if( $post->post_author ==  get_current_user_id() ){ ?>
                        <span class="profile-edit-link">
                            <?php $edit_link = site_url()."/myprofile/?fep_id=".get_the_ID()."&fep_action=edit&show=1"; ?>
                            <a href="<?php echo $edit_link; ?>">
                                <span>Edit</span><!--  <i class="fa fa-pencil-square-o prfl-edit-icons edit-pencil"></i> -->
                            </a>
                            </span>
                    <?php }
                    ?>
                </div>

            </div>
            <div class="the_source">
                <?php the_source( $post->ID ); ?>
            </div>
                <div class="post-article-title">
                    <h1 class="article-title entry-title"><?php the_title(); ?>
                    </h1>
                </div>

            </div>



        
        <div class="entry-top" align="center">
            <span class="vcard author">
                  <?=acf_context_add($post->ID)?>


            <!-- <span class="fn"><?php //esc_html_e('Written by', 'anthemes'); ?> <?php //the_author_posts_link(); ?>

        </span> -->


    </span>


           




</div><div class="clear"></div>

<?php endwhile; endif; ?>





<article>

    <?php if (have_posts()) : while (have_posts()) : the_post();  ?>

    <?php setPostViews_anthemes(get_the_ID()); ?>

    <div <?php post_class('post') ?> id="post-<?php the_ID(); ?>">



        <div class="media-single-content">


            <?php if ( function_exists( 'rwmb_meta' ) ) {  

            // If Meta Box plugin is activate ?>

            <?php

            $youtubecode = rwmb_meta('anthemes_youtube', true );

            $vimeocode = rwmb_meta('anthemes_vimeo', true );

            $image = rwmb_meta('anthemes_slider', true );

            $hideimg = rwmb_meta('anthemes_hideimg', true );

            ?> 



            <?php if(!empty($image)) { ?>

            <!-- #### Single Gallery #### -->

            <div class="single-gallery">

                <?php

                $images = rwmb_meta( 'anthemes_slider', 'type=image&size=thumbnail-gallery-single' );

                foreach($images as $key =>$image)

                 { echo wp_kses_post("<a href='{$image['full_url']}' title='{$image['caption']}' rel='mygallery'><img src='{$image['url']}'  alt='{$image['alt']}' width='{$image['width']}' height='{$image['height']}' /></a>");

         } ?>

     </div><!-- end .single-gallery --> 

     <?php } ?>



     <?php if(!empty($youtubecode)) { ?>

     <!-- #### Youtube video #### -->

     <iframe class="single_iframe" width="720" height="420" src="//www.youtube.com/embed/<?php echo esc_html($youtubecode); ?>?wmode=transparent" frameborder="0" allowfullscreen></iframe>

     <?php } ?>



     <?php if(!empty($vimeocode)) { ?>

     <!-- #### Vimeo video #### -->

     <iframe class="single_iframe" src="//player.vimeo.com/video/<?php echo esc_html($vimeocode); ?>?portrait=0" width="720" height="420" frameborder="0" allowFullScreen></iframe>

     <?php } ?>



     <?php if(!empty($image) || !empty($youtubecode) || !empty($vimeocode)) { ?>

     <?php } elseif ( has_post_thumbnail()) { ?>

     <?php if(!empty($hideimg)) { } else { ?>

     <?php the_post_thumbnail('thumbnail-single-image'); ?>

     <?php } // disable featured image ?>

     <?php } ?>



     <?php } else { 

            // Meta Box Plugin ?>

            <?php the_post_thumbnail('thumbnail-single-image'); ?>

            <?php } ?>

        </div><!-- end .media-single-content -->



        <div class="entry">

            <!-- excerpt -->

            <?php if ( !empty( $post->post_excerpt ) ) : ?> <div class="entry-excerpt"><h3> <?php echo the_excerpt(); ?> </h3></div> <?php else : false; endif;  ?> 

            <!-- advertisement -->

            <?php if (!empty($smof_data['ads_entry_top'])) { ?>

            <div class="entry-img-300"><?php echo stripslashes($smof_data['ads_entry_top']); ?></div>

            <?php } ?>

            <!-- entry content -->

            <?php the_content(''); // content ?>

            <?php wp_link_pages(); // content pagination ?>

            <div class="clear"></div>











            <!-- tags -->

            <?php $tags = get_the_tags(); 

            if ($tags): ?>

            <div class="ct-size"><div class="entry-btn"><?php esc_html_e( 'Article Tags:', 'anthemes' ); ?></div> 
 <div class="tag-container" style="margin-left: 95px; margin-top: 5px;" >
             <div name="trig" class="trig-function-php single-trig-function-php tag-shifter">
                <input type="hidden" value='<?php echo Nasdaq_tag_symbol( get_the_ID() ); ?>' class="tag-list"> 
               </div>
              <div class="thumbnail-transparent-bar" style="display:none;background-color:transparent;width:0px;"></div>
          </div>

<?php //the_tags('', ' &middot; '); // tags ?></div><div class="clear"></div>

        <?php endif; ?>



        <!-- categories -->

        <?php $categories = get_the_category(); 

        if ($categories): ?>

        <div class="ct-size"><div class="entry-btn"><?php esc_html_e( 'Article Categories:', 'anthemes' ); ?></div> <?php the_category(' &middot; '); // categories ?></div><div class="clear"></div>

    <?php endif; ?>

     

    <div class="clear"></div>     



 <div class="meta-wrap">

            <div class="single-meta">

                <div class="an-display-time updated"><i class="fa fa-clock-o"></i> <?php echo time_ago_anthemes(); ?> <?php esc_html_e('ago', 'anthemes'); ?></div>

                <div class="an-display-view"><i class="fa fa-eye"></i> <?php echo getPostViews_anthemes(get_the_ID()); ?></div>      

                <div class="an-display-comm"><i class="fa fa-comments"></i> <?php comments_popup_link('0 ' . esc_html__('Comments', 'anthemes') . '', '1 ' . esc_html__('Comment', 'anthemes') . '', '% ' . esc_html__('Comments', 'anthemes') . ''); ?></div>       

                <div class="single-data">

                    <?php if (function_exists('thumbs_rating_getlink')) { echo thumbs_rating_getlink(); } ?>

                </div><!-- end .home-data -->                        

                <div class="clear"></div> 

            </div><!-- end .single-meta -->

        </div><!-- Meta ( time and comments ) --> 

        <div class="clear"></div>



    <!-- Comments -->

<div class="comment-sectn">

<div class="entry-bottom">

    <?php if (get_comments_number()==0) {  ?>

        <div class="single-first-comment" > 

        <?php // esc_html_e('Be the first to comment' , 'anthemes'); ?>

        </div>

        <?php



    } else { ?>

     <h3 class="single-title cmnt-text"> <?php  esc_html_e( 'Comments', 'anthemes' ); ?> 

        <span><?php echo get_comments_number();//the_title(); ?></span>

    </h3> 

  <!--   <div class="arrow-down-related"></div><div class="clear"> -->

</div>

<?php } ?>            

<!-- Comments -->

<div id="comments" class="comments">

    <?php comments_template('', true); // comments ?>

</div>



<div class="clear"></div>

</div><!--comment section end-->                   

</div><!-- end .entry -->

<div class="clear"></div> 

</div><!-- end #post -->

<?php endwhile; endif; ?>

</article><!-- end article -->





<!-- ads -->

<?php if (!empty($smof_data['bottom728'])) { ?>

<div class="single-728">

    <div class="img728">

        <?php echo stripslashes($smof_data['bottom728']); ?>

    </div>

</div>

<?php } ?>





<!-- author -->

<?php if(get_the_author_meta('description') ): ?>

    <div class="author-meta" style="display:none;">

        <div class="author-left-meta">

            <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>"><?php echo get_avatar( get_the_author_meta( 'user_email' ), 70 ); ?></a>

            <ul class="author-social-top">

                <?php if(get_the_author_meta('facebook')) { ?><li class="facebook"><a target="_blank" href="//facebook.com/<?php echo esc_html(the_author_meta('facebook')); ?>"><i class="fa fa-facebook"></i></a></li><?php } ?>

                <?php if(get_the_author_meta('twitter')) { ?><li class="twitter"><a target="_blank" href="//twitter.com/<?php echo esc_html(the_author_meta('twitter')); ?>"><i class="fa fa-twitter"></i></a></li><?php } ?>

                <?php if(get_the_author_meta('google')) { ?><li class="google"><a target="_blank" href="//plus.google.com/<?php echo esc_html(the_author_meta('google')); ?>?rel=author"><i class="fa fa-google-plus"></i></a></li><?php } ?>                            

            </ul>

        </div><!-- end .author-left-meta -->

        <div class="author-info">

            <strong><?php the_author_posts_link(); ?></strong> &rsaquo; <a class="author-link" href="<?php the_author_meta('url'); ?>" target="_blank"><?php the_author_meta('url'); ?></a><br />

            <p><?php the_author_meta('description'); ?></p>

        </div><!-- end .autor-info -->

        <div class="clear"></div>

    </div><!-- end .author-meta -->

<?php endif; ?>











        <!-- Recent and related Articles -->



        <div class="related-box">



            <!-- Recent -->



            <div class="one_half">



            <h3 class="title"><?php esc_html_e( 'Recent Articles', 'anthemes' ); ?></h3><div class="arrow-down-related"></div><div class="clear"></div>



            <ul class="article_list">



            <?php $anposts = new WP_Query(array('post_type' => 'post', 'ignore_sticky_posts' => 1, 'posts_per_page' => 4 )); // number to display more / less ?>



            <?php while ( $anposts->have_posts() ) : $anposts->the_post(); ?>







              <li>



                <?php if ( has_post_thumbnail()) { ?>



                  



                  <a href="<?php the_permalink(); ?>"> <?php echo the_post_thumbnail('thumbnail-widget-small'); ?> </a>



                <?php } ?>



                  <div class="an-widget-title" <?php if ( has_post_thumbnail()) { ?> style="margin-left:70px;" <?php } ?>>



                    <h4 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>



                      <?php if(function_exists('taqyeem_get_score')) { ?>



                        <?php taqyeem_get_score(); ?>



                      <?php } ?>  







                    <!-- edited for  Replacing Writtenby to sprite -->





                    <span class="vcard author">



                    <div class="fn <?php echo str_replace('.','',str_replace(' ','', get_post_meta(  $post->ID  , "label_images",true))); ?>" >

                        <?=acf_context_add($post->ID)?>

<div class="article-comm" style="float:right; margin-right:-51px;"><?php comments_popup_link('<i class="fa fa-comments"></i> 0', '<i class="fa fa-comments"></i> 1', '<i class="fa fa-comments"></i> %'); ?></div>

                    </div>

                    



                    <!--   -->



                    </span>                  



                    



                  </div>



              </li>







            <?php endwhile; wp_reset_query(); ?>



            </ul>



            </div><!-- end .one_half Recent -->







            <!-- Related -->



            <div class="one_half_last">



            <h3 class="title"><?php esc_html_e( 'Related Articles', 'anthemes' ); ?></h3><div class="arrow-down-related"></div><div class="clear"></div>



            <ul class="article_list">



                <?php  



                    $orig_post = $post;  



                    global $post;  



                    $tags = get_the_category($post->ID);



                    if ($tags) {  



                    $tag_ids = array();  



                    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;  



                    $args=array(  


                    'category__in' => $tag_ids,  
                    //'tag__in' => $tag_ids,  



                    'post__not_in' => array($post->ID),  



                    'posts_per_page'=>4, // Number of related posts to display.  



                    'ignore_sticky_posts'=>1  



                    );  



                    $my_query = new wp_query( $args );  



                    while( $my_query->have_posts() ) {  



                    $my_query->the_post();  



                ?> 







              <li>



                <?php if ( has_post_thumbnail()) { ?>



                 



                  <a href="<?php the_permalink(); ?>"> <?php echo the_post_thumbnail('thumbnail-widget-small'); ?> </a>



                <?php } ?>



                  <div class="an-widget-title" <?php if ( has_post_thumbnail()) { ?> style="margin-left:70px;" <?php } ?>>



                    <h4 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>



                      <?php if(function_exists('taqyeem_get_score')) { ?>



                        <?php taqyeem_get_score(); ?>



                      <?php } ?>  







                    <!-- edited for  Replacing Writtenby to sprite -->



                    <span class="vcard author">



                    <div class="fn <?php echo str_replace('.','',str_replace(' ','', get_post_meta(  $post->ID  , "label_images",true))); ?>" >

                        <?=acf_context_add($post->ID)?>

                     <div class="article-comm" style="float:right; margin-right:-51px;"><?php comments_popup_link('<i class="fa fa-comments"></i> 0', '<i class="fa fa-comments"></i> 1', '<i class="fa fa-comments"></i> %'); ?></div>

                    </div>



                    



                    </span>  



                    <!--  end of edit -->











                  </div>



              </li>







            <?php } } $post = $orig_post; wp_reset_query(); ?>



            </ul>



            </div><!-- end .one_half_last Related -->



            <div class="clear"></div>



        </div><!-- end .related-box -->    





</div><!-- end .single-content -->





<!-- Begin Sidebar (right) -->

<?php  get_sidebar(); // add sidebar ?>

<!-- end #sidebar  (right) -->    





<div class="clear"></div>

</div><!-- end .wrap-fullwidth  -->
<?php $tag = get_avatar( get_current_user_id() , 200 );?>
<script>
    jQuery(document).ready(function($){
        var dom = "<?=$tag ?>";
        jQuery(".avatar-block-img").append( dom );
        jQuery(".avatar-block-img").children('img').css({"height":"inherit"});
        jQuery(".avatar-block-img").css({"background-image":"none"});
    });
</script>

<?php get_footer(); // add footer  ?>

 