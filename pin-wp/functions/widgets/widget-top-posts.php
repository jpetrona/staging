<?php
// ------------------------------------------------------
// ------ Popular Posts by comments  --------------------
// ------ by AnThemes.net -------------------------------
//        http://themeforest.net/user/An-Themes/portfolio
//        http://themeforest.net/user/An-Themes/follow 
// ------------------------------------------------------

class anthemes_topposts extends WP_Widget {
     function anthemes_topposts() {
      $widget_ops = array('description' => esc_html__('Popular Posts - Display your Popular / Top Posts by comments.', 'anthemes'));
      parent::WP_Widget(false, $name = ''. esc_html__('Custom: Popular Posts', 'anthemes') .'',$widget_ops); 
    }


    function widget($args, $instance) {
    	global $post;
        extract( $args );
        $number = $instance['number'];
        $title = $instance['title'];
        ?>


<?php echo $before_widget; ?>
<?php if ( $title ) echo $before_title . esc_attr($title) . $after_title; ?>

<ul class="article_list">
<?php $antop = new WP_Query(array('orderby' => 'comment_count', 'ignore_sticky_posts' => 1, 'posts_per_page' => esc_attr($number) )); // number to display more / less ?>
<?php $c=0; while ($antop->have_posts()) : $antop->the_post(); ?> 

  <li><?php if ( has_post_thumbnail()) { ?>
 
        <div class="article-category"><i></i> <?php $category = get_the_category(); if ($category) 
          { echo '<a href="' . get_category_link( $category[0]->term_id ) . '" class="tiptipBlog" title="' . sprintf( esc_html__( "View all posts in %s", "anthemes" ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a> ';}  ?>
        </div><!-- end .article-category -->    
        <a href="<?php the_permalink(); ?>"> <?php echo the_post_thumbnail('thumbnail-widget'); ?> </a> 
      <?php } ?> <div class="clear"></div>  

      <div class="an-widget-title"> 
        <h3 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <?php if(function_exists('taqyeem_get_score')) { ?>
            <?php taqyeem_get_score(); ?>
          <?php } ?>                    
      <span class="vcard author" style="margin-left:5px;">
            <?=acf_context_add($post->ID)?>
      </span>
             <div class="article-comm"><?php comments_popup_link('<i class="fa fa-comments"></i> 0', '<i class="fa fa-comments"></i> 1', '<i class="fa fa-comments"></i> %'); ?></div>
            <div class="source_toppost" style="float:right;padding-right: 17%;">
             <?php        $source = get_post_meta($post->ID, "source",true);

                            if( $source != '' ){
                            $link_for_source_images = get_template_directory_uri()."/images/source/".str_replace('.','',str_replace(' ','', $source )).".png"; 
                            $img_source = "<img src='{$link_for_source_images}' style='height:auto;width:auto;'/>";           
                            echo $img_source;
                            }

             ?>
             </div>       
      </div>  <!-- this is one change for 5/7/2015-->

  </li>

<?php endwhile; wp_reset_query(); ?>
</ul>


<?php echo $after_widget; ?> 


<?php
    }
    function update($new_instance, $old_instance) {       
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['number'] = strip_tags($new_instance['number']);
    return $instance;
    }

  function form( $instance ) {
    $instance = wp_parse_args( (array) $instance );
?>


        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:', 'anthemes' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php if( isset($instance['title']) ) echo esc_attr($instance['title']); ?>" />
        </p>

         <p>
          <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e( 'Number of Posts:', 'anthemes' ); ?></label>      
          <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php if( isset($instance['number']) ) echo esc_attr($instance['number']); ?>" />
         </p> 

<?php  } } 
add_action('widgets_init', create_function('', 'return register_widget("anthemes_topposts");')); // register widget
?>