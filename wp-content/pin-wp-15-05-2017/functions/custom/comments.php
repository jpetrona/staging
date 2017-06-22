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
                        <?php  // echo get_avatar( $comment, 50 ); ?>
                     <!-- <img class="" src="images/profilepic.png" alt="Screen Shot"> -->
                     <?php if(isset($comment) && $comment->user_id != 0){?>
                            <?php echo get_avatar( $comment, 50 ); ?>
                        <?php }else if(isset($comment) && $comment->user_id==0 && $comment->comment_parent==0){?>
                              <img src="/wp-content/uploads/avatar/1.jpg">
                        <?php }else{?>
				<img src="<?php echo get_template_directory_uri();?>/images/default-profile.png">
			<?php } ?>
                </div>
                <div class="avatar-coment">
                  <?php  $id = get_comment(get_comment_ID())->user_id;  ?>
                  <?php  $user_info = get_userdata($id); ?>
                  <?php  $authorusername = $user_info->data->user_nicename; ?>                    
                  <?php   
                   if($id != 0 && $id != '' ){
                       $url = get_site_url().'/'.$authorusername;
                    }else{
                       $url = get_site_url();
                    }  
                   ?>
                 <!-- <p class="avatar-name blu-text-clr 10 "><?php// echo get_comment_author_link(); ?></p>-->
                  <p class="avatar-name blu-text-clr "><a href="<?php  echo $url; ?>"><?php echo get_comment_author_link(); ?></a></p>
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
                                   <input type="hidden" value="<?php echo get_comment_ID();  ?>" class="inner_comment_id"/>  
                                   <?php //comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                                   <span title="Reply" class="comment-reply-link">Reply</span>
                                    <!-- <a href="#">Reply</a>-->
                              </span>
                        </span>
                        <span class="like-section">
                            <?php //if (function_exists('thumbs_rating_getlink')) { echo thumbs_rating_getlink(); } ?>
                            <?php 
                              if(is_user_logged_in ())
                              $user_id = get_current_user_id();
                              else
                              $user_id = 0;
                              $opt =  getPostLikeDislikecount(get_comment_ID(),$user_id);
                              $comment_counter =  (isset($opt['comment_counter']) && $opt['comment_counter'] != '') ? $opt['comment_counter'] : 0;
                              $commenter_status =  (isset($opt['commenter_status']) && $opt['commenter_status'] != '') ? $opt['commenter_status'] : 0;
                            ?>
                            <input type="hidden" value="<?php echo $user_id; ?>" class="is_login"/>
                            <a href="javascript:void(0)" data-items ='<?php echo get_comment_ID(); ?>' data-opt="like" class="common-input <?php echo 'like-'.get_comment_ID(); ?> <?php echo $commenter_status == 1 ? 'likes-green' : 'default-likes' ?>">&nbsp;</a>
                            <span class ='counter-likes-dislikes  <?php echo 'count-'.get_comment_ID(); ?>'><?php echo $comment_counter;?></span>
                            <a href="javascript:void(0)" data-items ='<?php echo get_comment_ID(); ?>' data-opt="dislike" class="common-input <?php echo 'dislike-'.get_comment_ID(); ?> <?php echo $commenter_status == -1 ? 'likes-red' : 'default-dislikes' ?>">&nbsp;</a>
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
