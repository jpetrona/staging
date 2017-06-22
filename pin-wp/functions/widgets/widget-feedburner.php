<?php
// ------------------------------------------------------
// ------ Subscribe widget  -----------------------------
// ------ Feedburner subscribe --------------------------
// ------ by AnThemes.net -------------------------------
//        http://themeforest.net/user/An-Themes/portfolio
//        http://themeforest.net/user/An-Themes/follow 
// ------------------------------------------------------

class anthemes_subscribe extends WP_Widget {
     function anthemes_subscribe() {
	    $widget_ops = array('description' => esc_html__('Feedburner subscribe widget.', 'anthemes'));
        parent::WP_Widget(false, $name = ''. esc_html__('Custom: Feedburner Subscribe', 'anthemes') .'',$widget_ops); 
    }

   function widget($args, $instance) {  
		extract( $args );
    $title = $instance['title'];
    $feedid = $instance['feedid'];
    $text = $instance['text'];
?>		
 
<?php echo $before_widget; ?>
<?php if ( $title ) echo $before_title . esc_attr($title) . $after_title; ?>
    
    <div class="feed-info"><?php echo stripslashes_deep($text); ?></div>

    <form action="http://feedburner.google.com/fb/a/mailverify" method="get" target="popupwindow" onsubmit="window.open('<?php echo esc_attr($feedid); ?>', 'popupwindow', 'scrollbars=yes,width=600,height=560');return true" id="newsletter-form">
      <input name="email" class="newsletter" placeholder="<?php esc_html_e('Enter your e-mail address', 'anthemes'); ?>" type="text">
      <input type="hidden" value="<?php echo esc_attr($feedid); ?>" name="uri"/>
      <input class="newsletter-btn" value="<?php esc_html_e('Subscribe', 'anthemes'); ?>" type="submit">
    </form>


  <?php echo $after_widget; ?>
  
<?php
    }

     function update($new_instance, $old_instance) {				
			$instance = $old_instance;
      $instance['title'] = strip_tags($new_instance['title']);
			$instance['feedid'] = strip_tags($new_instance['feedid']);
      $instance['text'] = stripslashes($new_instance['text']);
     return $instance;
    }

 	function form( $instance ) {

  // Set up some default widget settings
  $defaults = array(
    'title' => 'Feedburner',
    'text' => stripslashes('We cover the top <strong>social media</strong> news, you\'ll get Freebies and <strong>Freelance</strong> Jobs.
<i class="fa fa-hand-o-down"></i>'),
  );

  $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Widget Title:', 'anthemes' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php if( isset($instance['title']) ) echo esc_attr($instance['title']); ?>" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id('feedid'); ?>"><?php esc_html_e( 'Feedburner ID:', 'anthemes' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('feedid'); ?>" name="<?php echo $this->get_field_name('feedid'); ?>" type="text" value="<?php if( isset($instance['feedid']) ) echo esc_attr($instance['feedid']); ?>" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id('text'); ?>"><?php esc_html_e( 'Description:', 'anthemes' ); ?></label>      
          <textarea style="height:100px;" class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" ><?php if( isset($instance['text']) ) echo stripslashes($instance['text']); ?></textarea>
        </p> 

<?php  } }
add_action('widgets_init', create_function('', 'return register_widget("anthemes_subscribe");')); // register widget
?>