<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<head>
<?php
global $wpdb;
global $usernm;
?>
<meta name="google-site-verification" content="eaaIKog7C20lQ65dlFEzbC7HWph45TAM0jrRJgq8gh8" />
<?php
    $hosturl = explode('/',$_SERVER['REQUEST_URI']);
    $usernm = $hosturl[1];
    $user_data_arr = $wpdb->get_row($wpdb->prepare("SELECT ID, user_login,display_name FROM $wpdb->users WHERE user_login = %s ", $usernm));
    $user_id_val = $user_data_arr->ID;
if(strpos($_SERVER['HTTP_USER_AGENT'],'Firefox')!=false){
    define("BROWSER","firfox");
}else if(strpos($_SERVER['HTTP_USER_AGENT'],'Chrome')!=false){
    define("BROWSER","chrome");
}else if(strpos($_SERVER['HTTP_USER_AGENT'],'Safari')!=false){
    define("BROWSER","safari");
}else{
    define("BROWSER","ie");
}
?>
<?php
    // Options from admin panel
    global $smof_data;
    $favicon = $smof_data['custom_favicon'];
    if (empty($favicon)) { $favicon = get_template_directory_uri().'/images/web-icon.png'; }
    $site_logo = $smof_data['site_logo'];
    if (empty($site_logo)) { $site_logo = get_template_directory_uri().'/images/logo.png'; }
    if (empty($smof_data['featured-posts'])) { $smof_data['featured-posts'] = '12'; }
    $boxed_version_select = (isset($smof_data['boxed_version_select'])) ? $smof_data['boxed_version_select'] : 'No';
    ?>
<!-- Meta Tags 42-->
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<!-- Title -->
<?php if($user_id_val>0){
        echo "<title>".$user_data_arr->display_name." | Retirely</title>";
    }else if ( ! function_exists( '_wp_render_title_tag' ) ) { function theme_slug_render_title() { ?>
<title>
<?php wp_title( '|', true, 'right' ); ?>
</title>
<?php } add_action( 'wp_head', 'theme_slug_render_title' ); } // Backwards compatibility for older versions. ?>
<!-- Mobile Device Meta -->
<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui' />
<!-- The HTML5 Shim for older browsers (mostly older versions of IE). -->
<!--[if IE]> <script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/html5.js"></script> <![endif]-->
<!-- Favicons and rss / pingback -->
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php esc_url(bloginfo('rss2_url')); ?>" />
<link rel="pingback" href="<?php esc_url(bloginfo('pingback_url')); ?>" />
<link rel="shortcut icon" type="image/png" href="<?php echo esc_url($favicon); ?>"/>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()); ?>/css/font-awesome.min.css">
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php echo plugins_url();?>/tab/css/default.css?ver=4.1.5">
<!-- Custom style -->
<?php echo get_template_part('custom-style'); ?>
<!-- Theme output -->
<?php wp_head(); ?>
</head>
<!--<span id="websiteloading"></span>-->
<body <?php if ($boxed_version_select == 'Yes') { ?>id="boxed-style" <?php body_class(); ?>>
<?php if (!empty($smof_data['background_img'])) {
    if(is_single()){ ?>
<img id="background" style="z-index:-1;" src="<?php echo esc_url($smof_data['background_img']); ?>" alt="background img" />
<?php }else{ ?>
<img id="background" src="<?php echo esc_url($smof_data['background_img']); ?>" alt="background img" />
<?php } ?>
<?php }} else { ?>
<?php body_class(); ?>
<?php } // background image ?>
<?php if(BROWSER == "chrome") {?>
<style>
.tag-format{
  background-color: rgba(255, 219, 212, 0.4);
}
</style>
<?php } ?>
<?php if(BROWSER == "safari") {?>
<style>
.profile-block-right{
    width: 84% !important;
}
.cat{
    position: absolute !important;
}
.tab-span > .avatar.avatar-32 {
    margin-top:4%;
}
/*.sbHolder {
display: inline-block;
margin-left: 102px !important;
margin-top: -10px;
margin-bottom: 0 !important;
}*/
.sbHolder {
  left: 0px;
  top: 0px;
}
.tag-format{
    background-color: rgba(255, 219, 212, 0.4);
}
/*.template-cat {
    margin-bottom: 0.6%;
    margin-top: 1%;
}*/
</style>
<?php } ?>
<!-- Begin Header -->
<?php
if(is_user_logged_in()){
  global $wpdb;
  global $current_user;
  get_currentuserinfo();
  $userEmail = $current_user->user_email;
  $querystr = "select * from advisors where email='".$userEmail."'";
  $getadvisor = $wpdb->get_results($querystr, OBJECT);
  $advisorId = $getadvisor[0]->advisorid;
  if($advisorId==""){
    $userEmail = $current_user->user_email;
    $display_name = $current_user->display_name;
    $password = md5("123456");
    $sql = $wpdb->query("INSERT INTO advisors(fname,email,password)values('".$display_name."','".$userEmail."','".$password."')");
    $querystr = "select * from advisors where email='".$userEmail."'";
    $getadvisor = $wpdb->get_results($querystr, OBJECT);
    $advisorId = $getadvisor[0]->advisorid;
  }
?>
<?php   if( isset($advisorId) && $advisorId != '') { ?>
  <!--Quick Campaign Start-->
<div class="add-camp noView">
    <div class="camp-btn">Add Campaign</div>
    <object id="add-campaign-iframe" data="https://dashboard.retire.ly/iframe-addcampaign?id=<?php echo $advisorId;?>" style="width:100%;min-height:100%;margin-right:auto;">
    <embed src="https://dashboard.retire.ly/iframe-addcampaign?id=<?php echo $advisorId;?>" style="width:100%;height:100%;margin-left:auto;margin-right:auto;"> </embed>
         Error: Embedded data could not be displayed.
    </object>
  </div>
<?php }} ?>
<header>
  <div class="main-header">
    <div class="sticky-on">
      <?php //$dt = date(); ?>
    <!--Logo-->
       <div class="logo-section">
         <a href="<?php echo esc_url(home_url( '/' )); ?>?auth=true&d=<?php echo microtime(); ?>"><img class="logo" src="<?php echo esc_url(($site_logo)); ?>" alt="" /></a>
        </div>
        <!--Logo-->
    <!--Donwload Btn link-->
     <div class="download-store-btn">
          <ul>
          <li><span class="go-mb-text">Go mobile</span></li>
            <li><a href="https://play.google.com/store/apps/details?id=com.Intlfaces.retire.ly"><img src="<?php $upload_dir = wp_upload_dir(); echo $upload_dir['baseurl'] . '/'; ?>2015/03/google-btn.png" class="img-responsive social-img-icon"></a></li>
            <li><a href="https://itunes.apple.com/us/app/retirely/id713998164?ls=1&mt=8"><img src="<?php $upload_dir = wp_upload_dir(); echo $upload_dir['baseurl'] . '/'; ?>2015/03/appstore.png" class="img-responsive social-img-icon"></a></li>
      </ul>
        </div>
    <nav id="myjquerymenu" class="jquerycssmenu header-menu">
       <?php  wp_nav_menu( array( 'container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'theme_location' =>   'primary-menu' ) ); ?>
      <div class="header-SignInButton" <?php if(!is_user_logged_in()){?>style="margin-top:10px;" <?php } ?>> <?php echo do_shortcode("[SignInButton]"); ?> </div>
        </nav>
      <?php //if( is_front_page() ) : ?>
       <!--<a hrer="javascript:void(0)" id='show-btn' title='Actionable News' >
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 307.5 307.5" xml:space="preserve"><path d="M241.2 200.5c0 2.7-2.2 4.9-4.9 4.9H71.2c-2.7 0-4.9-2.2-4.9-4.9v-3.3c0-2.7 2.2-4.9 4.9-4.9h165.1c2.7 0 4.9 2.2 4.9 4.9L241.2 200.5 241.2 200.5z"/><path d="M140.2 65c0 2.7-2.2 4.9-4.9 4.9H71.2c-2.7 0-4.9-2.2-4.9-4.9v-3.3c0-2.7 2.2-4.9 4.9-4.9h64.2c2.7 0 4.9 2.2 4.9 4.9V65z"/><path d="M238.7 245.7c0 2.7-2.2 4.9-4.9 4.9H169.7c-2.7 0-4.9-2.2-4.9-4.9v-3.3c0-2.7 2.2-4.9 4.9-4.9h64.2c2.7 0 4.9 2.2 4.9 4.9V245.7z"/><path d="M174.2 110.2c0 2.7-2.2 4.9-4.9 4.9H71.2c-2.7 0-4.9-2.2-4.9-4.9v-3.3c0-2.7 2.2-4.9 4.9-4.9h98.2c2.7 0 4.9 2.2 4.9 4.9V110.2z"/><path d="M241.2 155.4c0 2.7-2.2 4.9-4.9 4.9H71.2c-2.7 0-4.9-2.2-4.9-4.9v-3.3c0-2.7 2.2-4.9 4.9-4.9h165.1c2.7 0 4.9 2.2 4.9 4.9L241.2 155.4 241.2 155.4z"/><path d="M272.4 74.5L193.3 9.5C186.7 4.1 175.4 0 166.9 0H42.4c-10.8 0-19.5 8.8-19.5 19.5 0 0 0 210 0 267.8 0 20.1 19 20.1 19.5 20.1 48.3 0 222.6 0 222.6 0 10.8 0 19.5-8.8 19.5-19.5V100.2C284.5 91.2 279.3 80.2 272.4 74.5zM187.9 29.5c0-4.8 4-1.1 4-1.1l62.7 53.6c0 0 4 3.9-2.9 3.9 -14.7 0-58.7 0-58.7 0 -2.8 0-5.1-2.3-5.1-5.1C187.9 80.8 187.9 42.3 187.9 29.5zM265 293c0 0-179.1 0-224 0 -0.8 0-3.6-0.2-3.6-4.2 0-54.4 0-269.3 0-269.3 0-2.7 2.3-5.1 5.1-5.1h124.5c2.1 0 6.5 1.1 6.5 7.1v59.2c0 10.8 8.8 19.5 19.5 19.5h73.5c1.3 0 3.6 0.9 3.6 4.2 0 0.1 0 183.4 0 183.4C270.1 290.7 267.8 293 265 293z"/></svg>
      </a>-->
     <?php// endif; ?>
     <?php get_search_form(); ?>
      <?php //if( is_front_page() ) : ?>
     <!-- <div class="news-container" style="display:block;" >
        <span id='up-btn' class="page__panel-up" title='Move up'  ><i class="fa fa-arrow-up"></i> </span>
        <span id='close-btn' class="page__panel-close"></span>
      </div>-->
       <?php //endif; ?>
 </div>
    <div class="clear"></div>
 </div>
  <div id="notificationContainer">
   <div id="notificationTitle">
      <h5 style="float:left;margin-left:60px;margin-top:5px">NOTIFICATIONS</h5>
     <img src="<?php site_url();?>/wp-content/themes/pin-wp/images/close.png"></div>
  <div id="notificationsBody" class="notifications"></div>
   <div id="notificationFooter"><a href="#"></a></div>
 </div>
  <div class="bar-header" style="padding-top:0px;visibility:hidden;">
  <?php
     if(  !is_user_logged_in()  )
     {
        ?>
   <div class="wrap-center">
  <div class="menu-categories">
       <nav id="myjquerymenu-cat" class="jquerycssmenu">
          <?php  wp_nav_menu( array( 'container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'theme_location' =>   'secondary-menu' ) ); ?>
       </nav>
      </div>
    </div>
    <?php }else if(is_home()){ ?>
   <div class="wrap-center">
      <div class="menu-categories">
       <nav id="myjquerymenu-cat" class="jquerycssmenu">
         <?php  wp_nav_menu( array( 'container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'theme_location' =>   'secondary-menu' ) ); ?>
      </nav>
     </div>
   </div>
    <?php } ?>
  </div>
</header>
<div class="chatbox">
  <div class="chat-action">
        <div class='online-advisor'>
        <div class="online-chat"></div>  
      <?php $userCount = loggedInUserCount(); ?>
      <?php if($userCount) {?>
      <span title="<?php echo $userCount > 1 ? 'Online Advisors': 'Online Advisor'; ?>" class='advisor-text'>
        <?php echo $userCount > 1 ? 'Chat': 'Chat'; ?>
      </span>
      <?php }else{ ?>
      <span  class='advisor-text'>
          <?php echo 'Chat'; ?>
      </span>
      <?php } ?>
      <strong><?php echo $userCount; ?></strong>
      
    </div>
        <div class="icons-right minimax" title="open or minimize" >+</div>
    </div>
  <div class="chat-window" style="display:none" >
    <input type="hidden" id="lastChatID" value="0">
    <div class="msgs">
      <div class='msg_loader'>Please wait chat is loading...</div>
      <div class='old_msg' style="display:none">No Previous chat found.</div>
    </div>
   <?php
      include("login.php");
     ?>
   </div>
</div>
<!-- end #header -->
<?php //if ( term_exists( 'featured', 'post_tag' ) ) { ?>
<?php if( is_front_page() ) { ?>
<!-- Begin Featured articles on slide -->
<div  class="featured-articles" style="height:159px;">
  <div class="featured-title">
    <h3>
      <?php esc_html_e('Featured Articles', 'anthemes'); ?>
    </h3>
    <div class="slide-nav"> <span id="slider-prev"></span> <span id="slider-next"></span> </div>
  </div>
  <?php $tag = get_term_by('slug', 'rssfeed', 'post_tag');
    $tag_id_rss =  $tag->term_id;
    $tag_id_rss = (isset($tag->term_id) && $tag->term_id != '') ? $tag->term_id : '' ;
    $tag = get_term_by('slug', 'featured', 'post_tag');
    $tag_id_featured =  $tag->term_id;
    $tag_id_featured = (isset($tag_id_featured) && $tag_id_featured != '') ? $tag_id_featured : '' ;?>
  <?php
    $frondendgraph_table = $wpdb->prefix."frondendgraph";
    $context_table = $wpdb->prefix."context";
    $querystr = "select * from  ".$frondendgraph_table." where status=1 order by id Desc";
    $querystrcontext = "select * from  ".$context_table;
    $allcontext = $wpdb->get_results($querystrcontext, OBJECT);
    $context = array();
    foreach($allcontext as $key => $value ){
        $context[$value->contextname] = $value->contextimg;
    }
    $allrecords = $wpdb->get_results($querystr, OBJECT);?>
  <ul class="featured-articles-slider">
    <?php  foreach($allrecords  as $key => $value ){ ?>
    <?php  $getcontext = $value->context; ?>
    <?php if( isset($value->content) && strlen($value->content) > 0  ){
               $graph_url = get_site_url().'/frontend-graph/?getid='.$value->id;
           }else{
                $graph_url = "javascript:void(0)";
            }
         $video_flag =  isset($value->embed_video) && $value->embed_video != '' ? 1 : 0; 
    ?>
     <li class='<?php echo $video_flag == 1 ? 'frondendgraph frondendgraphvideo' : 'frondendgraph'?>'>
     <input type="hidden" value='<?php echo $value->instrument; ?>' class="instrument">
      <?php $expertimagesize = array(55,55);
         $profileimage = wp_get_attachment_image_src( $value->expertimage , $expertimagesize);
         $comment = (isset($value->expertcomment) && $value->expertcomment != '') ? $value->expertcomment  : ''  ;
         $rawexpertcomment = (strlen($comment) < 100) ? $comment : substr($comment, 0, 100).'...';
        $expertcomment = stripslashes($rawexpertcomment);
         $stockpostedprice = (isset($value->stockpostedprice) && $value->stockpostedprice != '') ? $value->stockpostedprice  : ''  ;
        if(isset($value->post_author) && $value->post_author != 0) { 
           $performance_posted_date =  date('m/d/Y', strtotime($value->post_date));
      }else{
            $performance_posted_date = 0;
       } 
        ?>
        <input type="hidden" value='<?php echo (isset($profileimage[0]) && $profileimage[0] != '') ? $profileimage[0]  : ''  ; ?>' class="expertprofileimage">
        <input type="hidden" value='<?php echo (isset($value->expertname) && $value->expertname != '') ? $value->expertname  : ''  ; ?>' class="expertname">
        <input type="hidden" value="<?php echo htmlentities($expertcomment); ?>"  class="expertcomment">
        <input type="hidden"  class="called_by" id="called_by_<?php echo $key; ?>" value="google-finance">
        <input type="hidden"  class="rightsidesecond_<?php echo $key; ?>"  >
        <input type="hidden"  class="rightsidethird_<?php echo $key; ?>" >
        <div class="article-category"> <i></i> 
          <a href="<?php echo get_category_link( $value->category ); ?>">
            <?php  echo get_cat_name( $value->category ) ;?>
          </a> 
        </div>
        <?php $size = array(300,165);
         $image_attributes = wp_get_attachment_image_src(  $value->image , $size);
        ?>
        <?php if( (isset($image_attributes[0]) && $image_attributes[0] != '' && $value->embed_video == '' )){ ?> 
            <div class="video-container-graph"><a href="<?php echo $graph_url; ?>"><img class="attachment-thumbnail-blog-featured wp-post-image" width="300" height="165" title=""
                alt="" src="<?php echo (isset($image_attributes[0]) && $image_attributes[0] != '') ? $image_attributes[0]  : ''  ; ?>" /></a></div>
                <?php } ?>
        <?php if( (isset($value->embed_video) && $value->embed_video != '')){ ?>
          <?php if (strpos($value->embed_video,'twitter') != false || strpos($video,'instagram') != false ) {
                                      $twiter_flag = 1;
                } ?>
            <div class="video_loader_graph <?php echo $twiter_flag == 1 ? 'section_show': 'section_hide'; ?>"> Loading, please wait ...</div> 
              <div class="video-container-graph <?php echo $twiter_flag == 1 ? 'section_hide': ''; ?>">
              <?php echo stripslashes($value->embed_video);  ?>
              </div>
        <?php } ?>
      <div class="title-box frontend-title"> 
        <h2 class="stockname_heading"><a class="stockname" href="<?php echo $graph_url; ?>"><?php echo $value->title; ?></a></h2>
        <div class="graph-strip <?php echo $video_flag == 1 ? 'frondendgraph1' : ''?> ">  <span class="vcard author">
        <div>
          <img style="max-width:60px;" src="<?php echo get_template_directory_uri().'/images/context/'.$context[$getcontext] ;?>" alt="ASININE"> 
        </div>
        </span>
        <div class="instrument-<?php echo $key; ?>" ></div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="graph_instrument trig-function-php " id="graphdetail-<?php echo $key; ?>" >
        <input type="hidden" value='<?php echo $value->instrument; ?>' class="instrument">
        <input type="hidden" value='<?php echo $stockpostedprice; ?>' class="stockpostedprice">
        <input type="hidden" value='<?php echo $performance_posted_date; ?>' class="post_date">
        <div class='container frondendgraphhide' id="<?php echo 'container-'.$key; ?>" ></div>
      </div>
    </li>
    <?php  } ?>
    <?php  //query_posts( array( 'post_type' => array('exchange','post'),'posts_per_page' => esc_attr($smof_data['featured-posts']) , 'tag__in' => array($tag_id_rss,$tag_id_featured)  ) );  ?>
    <?php query_posts( array( 'post_type' => 'post', 'tag' => 'featured', 'posts_per_page' => esc_attr($smof_data['featured-posts']) ) );  ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php $temp= get_post_custom_values('exchange_url',$post->ID); if($temp[0] == ''){$redirect_link = get_permalink($post->ID);}else{$redirect_link=$temp[0];}?>
	<li class="frondendgraph" style="cursor: pointer;" onclick="window.location.href='<?=$redirect_link?>'">
      <?php
        if(isset($value->post_author) && $value->post_author != 0) { 
              $author_name = get_userdata($value->post_author)->display_name;
              $user_description = get_user_meta($value->post_author);
              $user_description = $user_description['description'];
              if($user_description==""){
                $user_description = $author_name;
              }
        }else{
              $author_name = 'Retirely';
              $user_description = 'Retirely';
        }
        $avtar_img = get_avatar(  $post->post_author  , 130 );
        if (preg_match('/<img(\s+?)([^>]*?)src=(\"|\')([^>\\3]*?)\\3([^>]*?)>/is', $avtar_img, $m) && isset($m[4])){
            $avtar_img = $m[4];
        }
      ?>
        <input type="hidden" class="expertprofileimage" value="<?php echo $avtar_img;?>">
        <input type="hidden" class="expertname" value="<?php echo $author_name;?>">
        <input type="hidden" value="<?php echo $user_description[0];?>"  class="expertcomment">
        <input type="hidden" class="called_by" id="called_by_<?php echo $post->ID; ?>" value="google-finance">
        <input type="hidden" class="rightsidesecond_<?php echo $post->ID; ?>"  >
        <input type="hidden" class="rightsidethird_<?php echo $post->ID; ?>" >
     <?php if ( has_post_thumbnail()) { ?>
      <div class="article-category"><i></i>
        <?php $category = get_the_category(); if ($category)
            { echo wp_kses_post('<a href="' . get_category_link( $category[0]->term_id ) . '" class="tiptipBlog" title="' . sprintf( esc_html__( "View all posts in %s", "anthemes" ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a> ');}  ?>
      </div>
      <!-- end .article-category -->
      <?php the_post_thumbnail('thumbnail-blog-featured', array('title' => "")); ?>
      <?php } // Post Thumbnail ?>
      <div class="title-box frontend-title">
        <h2 class="stockname_heading"><a class="stockname" href="<?=$redirect_link?>">
          <?php if ( strlen(get_the_title()) > 70 ) { echo substr(get_the_title(), 0, 70)." ..."; } else { the_title(''); } ?>
          </a></h2>
        <?php
        global $post;
        ?>
        <div class="graph-strip">
          <span class="vcard author">
          <?=acf_context_add($post->ID)?>
          </span>
          <div class="instrument-<?php echo $post->ID; ?>"></div>
        </div>
        <div class="article-comm header-comment">
          <?php comments_popup_link('<i class="fa fa-comments"></i> 0', '<i class="fa fa-comments"></i> 1', '<i class="fa fa-comments"></i> %'); ?>
        </div>
        <!--span class="header-author"><?php esc_html_e('By', 'anthemes'); ?><?php the_author(); ?></span-->
        <?php /*   <span><?php echo "this".the_author_posts_link(); ?></span> */ ?>
        <?php if(function_exists('taqyeem_get_score')) { ?>
        <?php taqyeem_get_score(); ?>
        <?php } ?>
        <div class="clear"></div>
        
      </div>
    </li>
    <!-- end .post-slide -->
    <?php endwhile; endif; wp_reset_query(); ?>
  </ul>
  <!-- end .featured-articles-slider -->
  <div class="clear"></div>
</div>
<!-- end .featured-articles -->
<?php }
// }
 ?>
<div class='graphdynamic'>
 <div class='loading-graph' id="loading-graph" style='display:none;'></div>
  <div class="graph-section" style='display:none;'>
    <div class="header-section ">
      <h4 class='symbol'> </h4>
      <p class='name'> </p>
    </div>
    <div class="graph-left-side"> <span class='graph-left-side-first'> </span> <span class='stockprice'></span> <span class='graph-left-side-price'></span> <span class='percentchange'></span>
      <div class='containerchart' style="height:200px; max-width: 240px;width:240px; "></div>
    </div>
    <div class="graph-right-side">
     <div class="graph-right-inside"> <span class='graph-left-side-price'></span> <span class='percentchange'></span> </div>
     <div class="graph-right-inside"> <span class='graph-left-year-high'></span> </div>
     <div class="graph-right-inside"> <span class='graph-left-year-low'></span> </div>
   <!--<div class="graph-right-inside"> <span id='mygraph-green-high'></span><span class='graph-left-year-high'></span> </div>
     <div class="graph-right-inside"> <span id='mygraph-red-low'></span><span class='graph-left-year-low'></span> </div>-->
       <div class="graph-expert">
         <p class='inside-expert' ><span class='expert-advice'></span></p>
          <span class='expert-image'></span>
          <div class='expert-content-tooltip'><h6 class='expert-name'></h6>
               <p class='expert-comment'></p>
          </div>
      </div>
    </div>
  </div>
</div>
<?php  
$check = is_user_logged_in() ? 1 : 0 ;
?>
<input type="hidden" id="is_user_logged_in" value="<?php echo $check;?>">
