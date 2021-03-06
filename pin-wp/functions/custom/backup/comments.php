<?php
// ------------------------------------------------------
// ------ Comments --------------------------------------
// ------ by AnThemes.net -------------------------------
//        http://themeforest.net/user/An-Themes/portfolio
// ------------------------------------------------------

if ( ! function_exists( 'anthemes_comment' ) ) :
      function anthemes_comment( $comment, $args, $depth ) {
            $GLOBALS['comment'] = $comment;
            switch ( $comment->comment_type ) :
            case '' :
            ?>
            <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                 <?php if ( $comment->comment_approved == '0' ) : ?>
                 <div class="comments-moderation-wait">
                  <?php esc_html_e('Your comment is awaiting moderation.', 'anthemes'); ?>
            </div> 
      <?php endif; ?>


      <div id="<?php comment_ID(); ?>"> 
            <div class="comment-body">


               <div class="single-coment-block clearfix">
                  <div class="avatar-block">
                        <?php echo get_avatar( $comment, 50 ); ?>
                      <!-- <img class="" src="images/profilepic.png" alt="Screen Shot"> -->
                </div>
                <div class="avatar-coment">
                  <p class="avatar-name blu-text-clr"><?php echo get_comment_author_link(); ?></p>
                  <p class="avatar-cmnts gry-text-clr"> 
                       <?php comment_text(); ?>
                         </p>
                  <div class="comment-avatar-block">
                        <span class="avatar-block-spn">
                              <?php echo get_comment_date(); ?> &nbsp; &nbsp;  &nbsp;<?php echo get_comment_time(); ?>
                             <!-- <span class="gry-text-clr">April</span>
                              <span class="gry-text-clr">30</span>-->
                        </span>
                        
                        <span class="avatar-block-spn">
                              <span class="blu-text-clr">
                                     <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                                   <!-- <a href="#">Reply</a>-->
                              </span>
                        </span>
                        <span class="like-section">
                            <?php if (function_exists('thumbs_rating_getlink')) { echo thumbs_rating_getlink(); } ?>
                        </span>
                  </div>
            </div>
      </div>

 


      <div class="clear"></div>            
      <!-- #comment- -->

      <?php break; 
      case 'pingback':case 'trackback':
      ?>
      <li class="post pingback"> 
            <p><?php esc_html_e('Pingback:', 'anthemes'); ?> <?php comment_author_link(); ?>
            </p> 
      </li>
      <?php break; 
      endswitch; } 
      endif; 
      ?>