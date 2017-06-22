<?php get_header(); // add header ?>
<style type="text/css">
.tag-shifter {
 left: -5px;
 position: relative;
 top: -30px;
}
.ct-size a{
color:blue!important;
}
.button[data-v-2]{
    background-color:#FFFC00 !important;
}
.button[data-v-2]:hover {
    background-color: #fffad0 !important;
}
.like-unlike-popup-list li a:hover{
    text-decoration: underline !important;
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
<!-- Modal HTML embedded directly into document -->
<div id="ex1" style="display:none;" class="modal_comment">
    <div class="sign-top">
        <p class="sign-text mrgn-cls">Sign In </p>
        <div class="social-sign">         
            <?php do_action( 'wordpress_social_login' ); ?>
        </div>
        <div class="error modal-login-error" style="margin-left:0px; display:none;">Incorrect: Login or Password</div>
        <form method="post">
            <div class="form-group mrgn-cls">
                <!-- <label class="form-lbl-text">User Name</label> -->
                <span class="pull-right" style="color:red;">*</span>
                <input type="text" name="log" id="log" class="form-control inpt" placeholder="Username" value="" size="20"/>
                <span class='username-error state-error' style='display:none'>Please enter username</span>       
            </div>
            <div class="form-group mrgn-cls">
                <!-- <label class="form-lbl-text">Password</label> -->
                <span class="pull-right" style="color:red;">*</span>
                <input type="password" name="pwd" id="pwd" size="20" class="form-control inpt" placeholder="Password" />
                <span class='password-error state-error' style='display:none'>Please enter password</span>
            </div>
            <input type="hidden" name="comment" class="comment-modal"  value="testuio"/>
            <input type="submit" value="Sign In" id="modal-login-form" class="btn btn-default sign-btnn mrgn-cls">
            <p class="pwd-block 11 ">
                <label for="rememberme">
                    <input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever"/> Remember me
                </label>
                <input type="hidden" name="redirect_to" class="modal_redirect_to" value="<?php echo the_permalink();?>"/>
            <!--<a class="forget-pwd" href="<?php //echo get_option('home'); ?>/reset-password/">Recover password</a>-->
           </p>
        </form>
    </div>
</div>
<!-- Link to open the modal -->
<a href="#ex1" class="ex1" rel="modal:open"></a>
<div class="wrap-fullwidth">
    <div>
        <div class="single-content">
        <!-- ads -->
        <?php if (!empty($smof_data['header_728'])) { ?>
            <div class="single-box">
                <div class="single-money">
                    <?php echo stripslashes($smof_data['header_728']); ?>
                </div>
            </div>
            <div class="clear"></div>
        <?php } ?>
        <!-- end .single-box -->
        <?php if (have_posts()) : while (have_posts()) : the_post();  ?>
        <div class="post-detailpage" >
            <div class="author-image-single"  >
            <?php //echo get_avatar(  $post->post_author  , 32 ); ?>
                <?php 
                   /* we are using 989 for Larry Iser */ 
                   if($post->post_author == 989){
                       echo "<a class= 'larry' href='http://www.kwikalaw.com' target='_blank'>".get_avatar(  $post->post_author  , 32 )."</a>"; 
                   }else{
                   //echo get_avatar(  $post->post_author  , 32 ); 
                        $avtar_img = get_avatar(  $post->post_author  , 130 );
                        if (preg_match('/<img(\s+?)([^>]*?)src=(\"|\')([^>\\3]*?)\\3([^>]*?)>/is', $avtar_img, $m) && isset($m[4])){
                            echo '<img  src="'.$m[4].'" class="codey avatar avatar-32 photo" width="32" height="32">';
                        }
                   }
                ?> 
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
                <div class="the_graphdetail"></div>
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
        </div>
        <div class="clear"></div>
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
                        foreach($images as $key =>$image){ 
                            echo wp_kses_post("<a href='{$image['full_url']}' title='{$image['caption']}' rel='mygallery'><img src='{$image['url']}'  alt='{$image['alt']}' width='{$image['width']}' height='{$image['height']}' /></a>");
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
     <?php $value = get_field('hide_featured_image_on_detail_post_page'); ?>
        <?php if(isset($value) && $value != 'Yes' ) { ?>
           <?php the_post_thumbnail('thumbnail-single-image'); ?>
        <?php }?>
     <?php } // disable featured image ?>
     <?php } ?>
    <?php } else { 
        // Meta Box Plugin ?>
         <?php $value = get_field('hide_featured_image_on_detail_post_page'); ?>
            <?php if(isset($value) && $value != 'Yes' ) { ?> 
               <?php the_post_thumbnail('thumbnail-single-image'); ?>
            <?php }?> 
        <?php } ?>
         <!-- script to show video in the place of post image-->
          <?php $video_source =  get_post_meta( get_the_ID(), 'video_source', true ); ?>
            <?php if(isset($video_source) && $video_source != '' && !has_post_thumbnail( get_the_ID() ) ) { ?> 
               <?php echo html_entity_decode($video_source); ?>
            <?php }?> 
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
            <?php  $user_id = get_current_user_id(); 
                  $opt =  getPostsLikeDislikecount(get_the_ID(),$user_id);
                  $post_counter =  (isset($opt['post_counter']) && $opt['post_counter'] != '') ? $opt['post_counter'] : 0;
                  $user_post_status =  (isset($opt['user_post_status']) && $opt['user_post_status'] != '') ? $opt['user_post_status'] : 0;
                  $first_title = $user_post_status == 1 ? 'You have liked this post' : 'Like'; 
                  $second_title = $user_post_status == -1  ? 'You have disliked this post' : 'Dislike'; 
                  $likedislike_count = getSinglePostLikeDislikecount(get_the_ID());
                  $likedislike_users = getSinglePostLikeDislikeUsers(get_the_ID());

            ?>
            <div class="watch-action">
                <div class="watch-position align-right">
                    <div class="action-like">
                        <a rel="nofollow" title="<?php echo $first_title?>" data-post-id="<?php echo get_the_ID() ;?>" data-task="like" href="javascript:void(0)" class="jlk-graph-post lbg-style1 like-<?php echo get_the_ID() ;?> jlk">
                            <i aria-hidden="true" class="fa fa-thumbs-o-up post-like-up"></i>
                            <span class="lc-<?php echo get_the_ID() ;?> lc_new"><?php echo $post_counter;?></span></a>
                    </div>
                    <div class="action-unlike">
                        <a rel="nofollow" title="<?php echo $second_title?>" data-post-id="<?php echo get_the_ID() ;?>" data-task="unlike" href="javascript:void(0)" class="jlk-graph-post unlbg-style1 unlike-<?php echo get_the_ID() ;?> jlk">
                            <i aria-hidden="true" class="fa fa-thumbs-o-down post-like-down"></i>
                            <span style="display:none;" class="unlc-<?php echo get_the_ID() ;?> unlc">0</span></a>
                        </div> 
                </div>
                <div class="status-<?php echo get_the_ID() ;?> status align-right"><?php echo $user_post_status !='' ? 'You have already voted.' : '';?></div>
                <div class="like-unlike-popup-sec" style="display:none;">
                    <!--h3 style="margin:0px;">Rating <strong>0</strong></h3-->
                    <div class="like-unlike-popup-like">
                       <div class="rtl-like rtl-like-rtl-Dislike"> <p class="dynmc-lke" style="padding:0px 15px;">Like <?php echo $likedislike_count['like_counter'];echo "<br>".$likedislike_users['likedislike_time']; ?></p></div>
                        <ul class="like-unlike-popup-list">
                        <?php foreach($likedislike_users['like_users'] as $userlikeval){
                            $users_data = get_userdata( $userlikeval->user_id );
                            $data  = get_the_author_meta( 'user_login' ,$userlikeval->user_id);
                            $current_user = wp_get_current_user();
                            $input = site_url();
                            if($data==$current_user->user_login && is_user_logged_in()){
                                $string = $input."/myprofile";
                            }else{
                                $string = $input."/".$data;
                            }
                        ?>
                        <li><a href="<?php echo $string;?>" alt="<?php print_r($users_data->ID);?>"><?php echo get_avatar($userlikeval->user_id,31);?><?php echo $users_data->display_name;?></a></li>
                        <?php } ?>
                        </ul>
                    </div>
                    <div class="like-unlike-popup-unlike">
                        <div class="rtl-Dislike rtl-like-rtl-Dislike"><p class="dynmc-dslke" style="padding:0px 15px;">Dislike <?php echo $likedislike_count['dislike_counter'];?></p></div>
                        <ul class="like-unlike-popup-list">
                        <?php foreach($likedislike_users['dislike_users'] as $userlikeval){
                            $users_data = get_userdata( $userlikeval->user_id );
                            $data  = get_the_author_meta( 'user_login' ,$userlikeval->user_id);
                            $current_user = wp_get_current_user();
                            $input = site_url();
                            if($data==$current_user->user_login && is_user_logged_in()){
                                $string = $input."/myprofile";
                            }else{
                                $string = $input."/".$data;
                            }
                        ?>
                        <li><a href="<?php echo $string;?>" alt="<?php print_r($users_data->ID);?>" ><?php echo get_avatar($userlikeval->user_id,31);?><?php echo $users_data->display_name;?></a></li>
                        <?php } ?>

                        </ul>
                    </div>
                    <div class="lk-tooltips"></div>
                    <div class="clear"></div>
                </div>

            </div>
            <!-- tags -->
            <?php $tags = get_the_tags(); 
            if ($tags): ?>
                <div class="ct-size">
                    <!--div class="entry-btn"><?php esc_html_e( 'Article Tags:', 'anthemes' ); ?></div --> 
                    <div class="tag-container" style="margin-top: 35px;" >
                        <div name="trig" class="trig-function-php single-trig-function-php tag-shifter">
                            <input type="hidden" value='<?php echo Nasdaq_tag_symbol( get_the_ID() ); ?>' class="tag-list">
                            <input id="tag-list-price-<?php echo get_the_ID();?>" class="tag-list-price" type="hidden" value='<?php echo Graph_price( get_the_ID() ); ?>'>
                            <input class="date-icon" type="hidden" value="<?php the_date('m/d/y'); ?>">  
                        </div>
                        <div class="thumbnail-transparent-bar" style="display:none;background-color:transparent;width:0px;"></div>
                    </div>
                    <?php //the_tags('', ' &middot; '); // tags ?>
                </div>
                <div class="clear"></div>
            <?php endif; ?>
        <!-- categories -->
        <?php $categories = get_the_category(); 
        if ($categories): ?>
            <div class="ct-size"><!--div class="entry-btn"><?php //  esc_html_e('Article Categories:', 'anthemes' ); ?></div--> <?php the_category(' &middot; '); // categories ?></div><div class="clear"></div>
        <?php endif; ?>
        <div class="clear"></div>
            <div class="meta-wrap">
                <div class="single-meta">
                    <div class="an-display-time updated"><i class="fa fa-clock-o"></i> <?php echo time_ago_anthemes(); ?> <?php esc_html_e('ago', 'anthemes'); ?>
                    </div>
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
                    <?php } else { ?>
                        <!--h3 class="single-title cmnt-text"> 
                            <?php if(get_comments_number()>1){esc_html_e( 'Comments', 'anthemes' );}
                            else{esc_html_e( 'Comment', 'anthemes' );} ?>  
                             <span > <?php echo get_comments_number();//the_title(); ?></span>
                        </h3 -->
                   <!--   <div class="arrow-down-related"></div><div class="clear"> -->
                   <?php } ?> 
                </div>
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
            <h3 class="title"><?php esc_html_e( 'Recent Articles', 'anthemes' ); ?></h3>
            <div class="arrow-down-related"></div>
            <div class="clear"></div>
            <ul class="article_list">
                <?php $anposts = new WP_Query(array('post_type' => 'post', 'ignore_sticky_posts' => 1, 'posts_per_page' => 4 )); // number to display more / less ?>
            <?php while ( $anposts->have_posts() ) : $anposts->the_post(); ?>
                <li class="recent-article-list">
                <?php if ( has_post_thumbnail()) {
                    $thumb_id = get_post_thumbnail_id();
                        $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
                        $thumb_url = $thumb_url_array[0];
        ?>
                <a href="<?php the_permalink(); ?>"><img width="70" height="52" src="<?php echo $thumb_url;?>"> </a>
                  <?php } ?>
                <?php
                $video_source = htmlspecialchars_decode(get_field('video_source'),ENT_COMPAT);
                preg_match('/src="([^"]+)"/', $video_source, $match);
                $video_url = $match[1];
                preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video_url, $matches);
                $video_id = $matches[1];
                $youtubeimg = 'https://img.youtube.com/vi/'. $video_id .'/0.jpg';
                ?>
                  <?php if(isset($video_source) && $video_source != '' && !has_post_thumbnail( get_the_ID() ) ) { ?> 
                     <a href="<?php the_permalink(); ?>" style="position: relative"><img class="videoimgmain" height="50px" width="68px" src="<?php echo $youtubeimg ?>"/>
                     <div class="custom_play_icon" style="position: absolute;left: -46px;top: 14px;"></div>
                      </a>
                  <?php }?> 
                  <div class="an-widget-title recent-image-gap">
                   <h4 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <?php if(function_exists('taqyeem_get_score')) { ?>
                        <?php taqyeem_get_score(); ?>
                    <?php } ?>  
                    <!-- edited for  Replacing Writtenby to sprite -->
                    <span class="vcard author article-author-title">
                    <div class="fn <?php echo str_replace('.','',str_replace(' ','', get_post_meta(  $post->ID  , "label_images",true))); ?>">
                       <?=acf_context_add($post->ID)?>
                        <div class="article-comm author-commn" style=""><?php comments_popup_link('<i class="fa fa-comments"></i> 0', '<i class="fa fa-comments"></i> 1', '<i class="fa fa-comments"></i> %'); ?></div>
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
                <h3 class="title"><?php esc_html_e( 'Related Articles', 'anthemes' ); ?></h3>
                <div class="arrow-down-related"></div>
                <div class="clear"></div>
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
                                    <?php if ( has_post_thumbnail()) { 
                                        $thumb_id = get_post_thumbnail_id();
                                        $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
                                        $thumb_url = $thumb_url_array[0];
                    ?>
                                    <a href="<?php the_permalink(); ?>"><img width="70" height="52" src="<?php echo $thumb_url;?>"></a>
                                    <?php } ?>
                            <?php 
                                $video_source = htmlspecialchars_decode(get_field('video_source'),ENT_COMPAT);
                                preg_match('/src="([^"]+)"/', $video_source, $match);
                                $video_url = $match[1];
                                preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video_url, $matches);
                                $video_id = $matches[1];
                                $youtubeimg = 'https://img.youtube.com/vi/'. $video_id .'/0.jpg';
                            ?>
                        <?php if(isset($video_source) && $video_source != '' && !has_post_thumbnail( get_the_ID() ) ) { ?> 
                            <a href="<?php the_permalink(); ?>" style="position: relative"><img height="50px" width="68px" src="<?php echo $youtubeimg ?>"/>
                             <div class="custom_play_icon" style="position: absolute;left: -46px;top: 14px;"></div>
                            </a>
                        <?php }?>
                                    <div class="an-widget-title" style="margin-left:70px;">
                                        <h4 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <?php if(function_exists('taqyeem_get_score')) { ?>
                                        <?php taqyeem_get_score(); ?>
                                        <?php } ?>
                                        <!-- edited for  Replacing Writtenby to sprite -->
                                        <span class="vcard author article-author-title">
                                            <div class="fn <?php echo str_replace('.','',str_replace(' ','', get_post_meta(  $post->ID  , "label_images",true))); ?>" >
                                                <?=acf_context_add($post->ID)?>
                                                <div class="article-comm author-commn" style=""><?php comments_popup_link('<i class="fa fa-comments"></i> 0', '<i class="fa fa-comments"></i> 1', '<i class="fa fa-comments"></i> %'); ?></div>
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
