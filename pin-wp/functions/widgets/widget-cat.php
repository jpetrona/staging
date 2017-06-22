<?php
// ------------------------------------------------------
// ------ Posts by Categories  --------------------------
// ------ by AnThemes.net -------------------------------
//        http://themeforest.net/user/An-Themes/portfolio
//        http://themeforest.net/user/An-Themes/follow 
// ------------------------------------------------------

class anthemes_postcat extends WP_Widget {
     function anthemes_postcat() {
      $widget_ops = array('description' => esc_html__('Posts by Categories', 'anthemes'));
        parent::WP_Widget(false, $name = ''. esc_html__('Custom: Posts by Categories', 'anthemes') .'',$widget_ops);  
    }



    function widget($args, $instance) {   
        extract( $args );
        $number = $instance['number'];
        $title = $instance['title'];
        $artcat = $instance['artcat'];
        ?>



<?php echo $before_widget; ?>
<?php if ( $title ) echo $before_title . esc_attr($title) . $after_title; ?>

<ul class="article_list">
<?php query_posts( array( 'post_type' => 'post' ,  'ignore_sticky_posts' => 1,'category_name' => esc_attr($artcat), 'posts_per_page' => esc_attr($number)) ); ?>
<?php $c=0; if (have_posts()) : while (have_posts()) : the_post(); ?>  

<?php $c++;
if($c == 1) : ?>

  <li><?php if ( has_post_thumbnail()) { ?>
        <div class="article-comm"><?php comments_popup_link('<i class="fa fa-comments"></i> 0', '<i class="fa fa-comments"></i> 1', '<i class="fa fa-comments"></i> %'); ?></div>
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
        <span><?php esc_html_e('Written by', 'anthemes'); ?> <?php the_author_posts_link(); ?></span>
      </div>


  </li>

<?php else : ?> 

  <li>
    <?php if ( has_post_thumbnail()) { ?>
      <div class="article-comm"><?php comments_popup_link('<i class="fa fa-comments"></i> 0', '<i class="fa fa-comments"></i> 1', '<i class="fa fa-comments"></i> %'); ?></div>
      <a href="<?php the_permalink(); ?>"> <?php echo the_post_thumbnail('thumbnail-widget-small'); ?> </a>
    <?php } ?>

      <div class="an-widget-title" <?php if ( has_post_thumbnail()) { ?> style="margin-left:70px;" <?php } ?>>
        <h4 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
          <?php if(function_exists('taqyeem_get_score')) { ?>
            <?php taqyeem_get_score(); ?>
          <?php } ?>                    
        <span><?php esc_html_e('by', 'anthemes'); ?> <?php the_author_posts_link(); ?></span>
      </div>
  </li>

<?php endif;?>
<?php endwhile; endif; wp_reset_query(); ?>
</ul>


<?php echo $after_widget; ?> 


<?php
    }
    function update($new_instance, $old_instance) {       
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['number'] = strip_tags($new_instance['number']);
    $instance['artcat'] = strip_tags($new_instance['artcat']);
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
         
          <p>
          <label for="<?php echo $this->get_field_id('artcat'); ?>"><?php esc_html_e( 'Category:', 'anthemes' ); ?></label>      
          <input class="widefat" id="<?php echo $this->get_field_id('artcat'); ?>" name="<?php echo $this->get_field_name('artcat'); ?>" type="text" value="<?php if( isset($instance['artcat']) ) echo esc_attr($instance['artcat']); ?>" />
         </p> 

<?php  } } 
add_action('widgets_init', create_function('', 'return register_widget("anthemes_postcat");')); // register widget
?>