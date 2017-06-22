<?php
$fark_flag = true;
$fark_data = file_get_contents("http://news.fark.com/data/js/84115.js");
$fark_data = json_decode($fark_data);
get_header(); // add header 
?>
<style type="text/css">
     .marquee-main {
        width: 100%;
        margin-top: 17px;
        height: 45px;
        background: #2C01F5;
        background: -owg-linear-gradient(to right,#FB8E1E,#2B00F7);
        background: -webkit-linear-gradient(to right,#FB8E1E,#2B00F7);
        background: -moz-linear-gradient(to right,#FB8E1E,#2B00F7);
        background: -o-linear-gradient(to right,#FB8E1E,#2B00F7);
        background: linear-gradient(to right,#FB8E1E,#2B00F7);
    }
    .marquee-title{
        text-align: center;
        min-width: 150px;
        height: 45px;
        line-height: 15px;
        float: left;
    }
    .marquee-title h2 {
        font-size: 18px;
        font-weight: bold;
        color: #fff;
        margin: 6px 0;
        border-right: 1px solid rgba(255,255,255,.35);
        padding: 4px 0;
    }
      .marquee {
        overflow: hidden;
        white-space: nowrap;
        height: 45px;
    }
    .marquee li a {
        display: inline-block;
        color: rgba(255,255,255,.7);
        font-size: 15px;
        font-weight: bold;
        border-right: 1px solid rgba(255,255,255,.35);
        padding: 2px 15px;
        margin-top: 6px;
        cursor: pointer;
    }
     .marquee li a:hover {
        color: #fff !important;
        text-decoration: none;
    }
     .tickercontainer{
        height: 45px !important;
     }
   /* .content{
            margin-left: -1090px;
        }*/
</style>
<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/jquery.webticker.min.js"></script>
<script type="text/javascript">
   $(document).ready(function(){
        $('#webTicker').webTicker({
            speed: 100, //pixels per second
            direction: "left", //if to move left or right
            moving: true, //weather to start the ticker in a moving or static position
            startEmpty:false, //weather to start with an empty or full ticker
            duplicate: true, //if there is less items then visible on the ticker you can duplicate the items to make it continuous
            rssurl: false, //only set if you want to get data from rss
            rssfrequency: 0, //the frequency of up<a href="http://www.jqueryscript.net/time-clock/">date</a>s in minutes. 0 means do not refresh
            updatetype: "reset" //how the update would occur options are "reset" or "swap"
        });
     });
</script>
<?php
$hosturl = explode('/',$_SERVER['REQUEST_URI']);
$usernm = $hosturl[1];
$user_data_arr = $wpdb->get_row($wpdb->prepare("SELECT ID, user_login,display_name FROM $wpdb->users WHERE user_login = %s ", $usernm));
$user_id_val = $user_data_arr->ID;

if($user_id_val>0){
echo do_shortcode ( "[SignIn val='" . $user_id_val . "']" );
}

$tag = get_term_by('slug', 'rssfeed', 'post_tag');
$tag_id = $tag->term_id;
$tag_id = (isset($tag_id) && $tag_id != '') ? $tag_id : '' ;
?>
<script>
window.onbeforeunload = null;
window.onunload = null;
 function changeFunc(self){
    if(self.value>0){
    var redirect_url = "<?php echo site_url().'/?cat_id='; ?>"+self.value;
    }else if(self.value == 'top-gainer'){
    var redirect_url = "<?php echo site_url().'/?gainer='; ?>"+self.value;    
    }else{
    var redirect_url = "<?php echo site_url(); ?>";
    }
  window.location.replace(redirect_url);
  window.location.href = redirect_url;
 }
</script>
	<script>
		function display_popup(self){
			jQuery(".popups" ).show();
             $(this).animate({

                height: "3000"});
		}
		function close_popup(self){
		 	jQuery(".popups").hide();
		}
	</script>

	<div style="position: relative;">

		</div>
<?php if($user_id_val==""){?>
	<div class="arrow-logo"   >
		<img class="arrow-logo-img" title="Ideal Media"  onclick="display_popup(this)"  src="<?php echo get_template_directory_uri().'/images/Ideal-new.svg';  ?>"  >
		<div class="popups pullDown" id="popups" >
			<div class="arrow-up"></div>
			<div id="close-popups" onclick="close_popup(this)">
				<i class="popups-close fa fa-close" ></i>
			</div>
			<a href="http://www.idealmedia.com">
				<img class="popups-image" src="<?php echo get_template_directory_uri().'/images/popupimage.png';  ?>">
			</a>
		</div>
	</div>
<?php
}
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
<div class="home-fullwidth" style="display:inline;">
<?php if($user_id_val==""){?>
    <div class="marquee-main">
        <div class="marquee-title"><h2>The Latest</h2></div>
        <div class="marquee">
          <div class="marquee-box">
              <ul id="webTicker">
		<?php query_posts( array( 'post_type' => 'post','post_status' => 'publish'));  ?>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?> <span style="font-size:10px"><?php echo time_ago_anthemes(); ?> <?php esc_html_e('ago', 'anthemes'); ?></span></a></li>
                <?php endwhile; endif; wp_reset_query(); ?>
            </ul>
          </div>
        </div>
    </div>
<?php } ?>
    <!-- Begin Sidebar (left) -->
    <?php if($user_id_val==""){ get_template_part('sidebar2');?> 
    <!-- end #sidebar (left) --> 

    <!-- Begin Main Wrap Content -->
    <div class="wrap-content" style="background-color: transparent;">
    <?php }else{?>    
    <div class="wrap-content" style="margin-left: 12%;background-color: transparent;">
    <?php } ?>

        <!-- edited -->
    <div class="template-cat" style="min-height:27px;" >
      <span class="template-cat-getting" style="display:none;" >
        <?php $cat = get_categories(); ?>
       <!-- <span class="cat">All posts in:</span>-->
        <div class="all-post-category">  
        <select id="template-category" class="template-category" onchange="changeFunc(this);">
            <option value='0'>Most Recent</option>
        <?php 
            foreach($cat as $key => $value) {
            if( $value->term_id != $_GET['cat_id'] )
            {
                echo "<option value='{$value->term_id}'>{$value->name}</option>";
            }
            else
            {
                 echo "<option value='{$value->term_id}' selected='selected'>{$value->name}</option>";
            }
            }
            if( isset($_GET['cat_id']) && $_GET['cat_id'] == "top-gainer"){
                echo "<option value='top-gainer' selected='selected'>Top Gainers</option>";
            }else{
                echo "<option value='top-gainer' >Top Gainers</option>";
            }
        ?>
     </select>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.template-cat-getting').show();
    });
</script> 
<?php if($user_id_val==""){?>
  <div class="addonhome">
	<div id="unit_82534"><a href="http://idealmedia.com/"></a></div>
	<script type="text/javascript" charset="utf-8">
	 (function() {
	   var sc = document.createElement('script'); sc.type = 'text/javascript'; sc.async = true;
	   sc.src = '//news.fark.com/data/js/82534.js'; sc.charset = 'utf-8';
	   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sc, s);
	 }());
	</script>
   </div></span>
<?php } ?>
   </div>
        <?php if (is_category()) { ?> 
            <div class="archive-header"><h3><?php esc_html_e( 'All posts in:', 'anthemes' ); ?> <strong><?php single_cat_title(''); ?></strong></h3></div>
        <?php } elseif (is_tag()) { ?>
            <div class="archive-header"><h3><?php esc_html_e( 'All posts tagged in:', 'anthemes' ); ?> <strong><?php single_tag_title(''); ?></strong></h3></div>
        <?php } elseif (is_search()) { ?>
            <div class="archive-header"><h3><?php printf( esc_html__( 'Search Results for: %s', 'anthemes' ), '<strong>' . get_search_query() . '</strong>' ); ?></h3></div>
        <?php } elseif (is_author()) { ?> 
                <div class="archive-header"><h3><?php esc_html_e( 'All posts by:', 'anthemes' ); ?> <strong><?php the_author(); ?></strong></h3></div>
        <?php } elseif (is_404() && $user_id_val=="") { ?> 
            <div class="archive-header"><h3><?php esc_html_e('Error 404 - Not Found', 'anthemes'); ?> <br /> <?php esc_html_e('Sorry, but you are looking for something that isn\'t here.', 'anthemes'); ?></h3></div>
        <?php } ?> 


        <ul id="infinite-articles" class="masonry_list js-masonry"  data-masonry-options='{ "columnWidth": 0 }'> 

        <?php
        $u_id = "";
        if(isset($_GET['auth']) && $_GET['auth']!=""){
            $user = get_user_by( 'login', $_GET['auth'] );
            $u_id = $user->ID;
        }else if($user_id_val!=""){
	    $u_id = $user_id_val;
	}

                if ( get_query_var('paged') ) 
                {  
                    $paged = get_query_var('paged'); 
                    if($paged == 2 ){
                        $n = 4;
                    }elseif($paged == 3){
                        $n = 7;
                    }elseif($paged == 4){
                        $n = 10;
                    }elseif($paged == 5){
                        $n = 13;
                    }else{
                        $n = -1;
                    } 
                } 
                elseif ( get_query_var('page') ) 
                { 
                    $paged = get_query_var('page');
                } else { $paged = 1; $n=0;  }

                if( $_GET['cat_id'] != '' && is_numeric($_GET['cat_id'] ) == true )
                {   
                    query_posts( array( 'post_type' => 'post', 'paged' => $paged , 'cat' => $_GET['cat_id'] , 'tag__not_in' => array($tag_id) ) );
                }
                else if( isset($_GET['symbol']) && $_GET['symbol'] != '' )
                { 
                    query_posts( array( 'post_type' => 'post', 'paged' => $paged ,'tag'=>$_GET['symbol'], 'tag__not_in' => array($tag_id)));
                }
                else if( $u_id != "" )
                { 
                    query_posts( array( 'post_type' => 'post', 'paged' => $paged , 'author' => $u_id , 'tag__not_in' => array($tag_id)));
                }
                else if( isset($_GET['cat_id']) && $_GET['cat_id'] == "top-gainer")
                { 
                   $allrecords = graph_container($paged);
                }
                else
                {  
                    query_posts( array( 'post_type' => 'post', 'paged' => $paged , 'tag__not_in' => array($tag_id)));
                }
        ?>    
        <?php if(isset($_GET['cat_id']) && $_GET['cat_id'] == "top-gainer"){ 
            $expertimagesize = array(55,55); 
            $size = array(300,165);  
            foreach($allrecords  as $key => $value ){ 
               $profileimage = wp_get_attachment_image_src( $value->expertimage , $expertimagesize);
               $image_attributes = wp_get_attachment_image_src(  $value->image , $size);
               $expertname = (isset($value->expertname) && $value->expertname != '') ? $value->expertname : '';
               $getexpertcomment = (isset($value->expertcomment) && $value->expertcomment != '') ? $value->expertcomment : '';
               $expertcomment = (strlen($getexpertcomment) < 100) ? $getexpertcomment : substr(stripslashes($getexpertcomment), 0, 100).' ...';
               $context = (isset($value->context) && $value->context != '') ? frontend_graph($value->id,'context',$value->context) : '';
                if( isset($value->content) && strlen($value->content) > 0  ){
                    $graph_url = get_site_url().'/frontend-graph/?getid='.$value->id;
                }else{
                    $graph_url = "javascript:void(0)";
                }
                if(isset($value->post_author) && $value->post_author != 0) { 
                      $author_name = get_userdata($value->post_author)->display_name;
                      $author_id = $value->post_author;
                      $performance_posted_date =  date('m-d-Y', strtotime($value->post_author));
                }else{
                      $author_name = 'Retirely';
                      $author_id = 1;
                      $post_date = '2016-02-01 15:23:21';
                      $performance_posted_date = '';
                }
                $user_ID = get_current_user_id();
                    if(isset($value->post_author) && $value->post_author == $user_ID ){
                       $profile_url = get_site_url().'/myprofile';
                    }else{
                       $profile_url = 'javascript:void(0)';
                    }
                ?>
                <li class='container-top-gainer'>
                <div class="article-category"><i></i> 
                    <a title='View all posts in <?php echo get_cat_name( $value->category ) ;?>'  class="tiptipBlog" href="<?php echo get_category_link( $value->category ); ?>"><?php echo get_cat_name( $value->category );?></a>
                </div>
                <a href="<?php echo $graph_url; ?>" class="thumbnail-blog-link">
                    <div class="thumbnail-function-php">
                        <img width="300" height="175" alt="" class="attachment-thumbnail-blog-masonry wp-post-image" src="<?php echo (isset($image_attributes[0]) && $image_attributes[0] != '') ? $image_attributes[0]  : ''  ; ?>">
                           <div class="custom-instrument instrument-<?php echo $key; ?>" ></div>
                    </div> 
                </a>
                <div class="clear"></div>
                <div class="small-content">
                    <div class="an-widget-title">
                        <h2 class="article-title entry-title">
                            <a href="<?php echo $graph_url; ?>" class="title-name">
                                <?php echo $value->title ?> 
                            </a>
                        </h2> 
                        <div class='container-inner-left'>
                        <span class="vcard author">
                            <div>
                                <img style="max-width:60px;" src="<?php echo get_template_directory_uri().'/images/context/'.$context['context-image'] ;?>">
                            </div>
                        </span>
                        <div class="posting-author"> 
                            <span> 
                                <a href="<?php echo $profile_url;?>"  class="the_author_link"><?php echo $author_name; ?></a>
                            </span>
                        </div>
                        <div class="posting-image">
                            <?php echo isset($author_id) ? get_avatar(  $author_id   , 23 ) : '' ; ?>
                            <div class="container-performance-graph-<?php echo $key; ?>">
                            </div>
                        </div>
                        </div>
                        <div class="index-article-source">
                           <img src="<?php echo $profileimage[0];?>" alt="">
                            <span class='expert-view'>Expert view</span>
                           <div class="expert-content-container"><h6 class="expert-name-container"><?php echo $expertname; ?></h6><p class="expert-comment-container"><?php echo $expertcomment;?></p></div> 
                        </div>
                    </div>
                </div>
             </li>
            <?php   } ?>
        <?php }else{ ?>
        <?php $num=0;  if (have_posts()) : while (have_posts()) : the_post(); $num++; ?>

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
                <!-- this shift <div class="article-comm"><?php comments_popup_link('<i class="fa fa-comments"></i> 0', '<i class="fa fa-comments"></i> 1', '<i class="fa fa-comments"></i> %'); ?></div> -->
                 <div class="article-category"><i></i> <?php $category = get_the_category(); if ($category) 
                    { echo wp_kses_post('<a href="' . get_category_link( $category[0]->term_id ) . '" class="tiptipBlog" title="' . sprintf( esc_html__( "View all posts in %s", "anthemes" ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a> ');}  ?>
                 </div><!-- end .article-category -->    
                 <a class="thumbnail-blog-link" href="<?php the_permalink(); ?>"> <?php echo the_post_thumbnail('thumbnail-blog-masonry'); ?> </a> 
                <?php } else{ $video_source =  get_post_meta( get_the_ID(), 'video_source', true ); 
                                $video = htmlentities($video_source);
                                if (strpos($video,'twitter') != false || strpos($video,'instagram') != false || strpos($video,'youtube') != false ) {
                                    $twiter_flag = 1;
                                }
                     ?>
                    <div class="video_loader <?php echo $twiter_flag == 1 ? 'section_show': 'section_hide'; ?>"> Loading, please wait ...</div> 
                    <div class="video-container <?php echo $twiter_flag == 1 ? 'section_hide': ''; ?>">
                        <?php  if( isset($video_source) && $video_source != '' && !has_post_thumbnail( get_the_ID() )){
                                echo html_entity_decode($video_source); 
                             } ?>
                    </div>
                <?php  }  $twiter_flag = 0;?>
                <div class="clear"></div>  
                 <div class="small-content">
                  <div class="an-widget-title">
                    <h2 class="article-title entry-title"><a class="title-name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <!--  // edited    -->
                     <?php if(function_exists('taqyeem_get_score')) { ?>
                        <?php taqyeem_get_score(); ?>
                      <?php } ?> 
                      <span class="vcard author">  <?=acf_context_add($post->ID)?></span>
                       <div class="article-comm"><?php comments_popup_link('<i class="fa fa-comments"></i> 0', '<i class="fa fa-comments"></i> 1', '<i class="fa fa-comments"></i> %'); ?></div>
                       <div class="index-article-source" style="float:right;color:black;font-weight:bold;">
                        <?php the_source($post->ID); ?>
                       </div>
			<div class="posting-author-image">
                       <div class="posting-author">
                         <span style="font-size:14px;color:blue;font-family: 'Open Sans', Times, serif;"><?php esc_html_e('', 'anthemes'); ?> <?php the_author(); ?></span>    
                       </div>
	                  <div class = "posting-image" ><?php echo get_avatar ( $post->post_author , 23 ); ?></div >
			</div>
                  </div> 
		<br>
                  <p><?php echo anthemes_excerpt(strip_tags(strip_shortcodes(get_the_excerpt())), 100); ?></p>
                </div><!-- end .small-content -->

                <div class="home-meta">
                    <div class="an-display-time updated"><i class="fa fa-clock-o"></i> <?php echo time_ago_anthemes(); ?> <?php esc_html_e('ago', 'anthemes'); ?></div>
                    <div class="an-display-view"><i class="fa fa-eye"></i> <?php echo getPostViews_anthemes(get_the_ID()); ?></div>      
                        <div class="home-data">
                            <?php if (function_exists('thumbs_rating_getlink')) { echo thumbs_rating_getlink(); } ?>
                        </div><!-- end .home-data --> 
			<?php //echo do_shortcode('[TheChamp-Sharing style="background-color:transparent;"]'); ?>
			<div class="shortcode-my">
                        <?php  $post_url = get_permalink ($post->ID); ?>
                         <?php echo do_shortcode('[ssba url='.$post_url.']'); ?> 
			</div>
                    <div class="clear"></div> 
                </div><!-- Meta ( time and comments ) -->  

            </li>
            <?php  if(($num==1 || ($num%3)==0) && $fark_flag == true && $n != -1 && isset($fark_data->news[$n]->url) &&  $fark_data->news[$n]->url != '') {  ?>
            <li class="status-publish ex34 fark_post" >
                <a href="<?php echo $fark_data->news[$n]->url ?>"><img width="300" height="200" src="<?php echo $fark_data->news[$n]->img?>">
               <div class="overlay-mask"></div></a>
                <div class="clear"></div>
                <div class="small-content">
                  <div class="an-widget-title">
                    <h2 class="article-title entry-title"><a href="<?php echo $fark_data->news[$n]->url ?>" class="title-name"><?php echo $fark_data->news[$n]->title;?></a></h2>
                    <span class="vcard author"><div></div></span>
                    <div class="article-comm"></div>
                    <div class="index-article-source" style="float:right;color:black;font-weight:bold;"></div>
                    <div class="posting-author"><span style="font-size:14px;color:blue;font-family: 'Open Sans', Times, serif;"></span></div>
                    <div class="posting-image"></div>
                  </div> 
                </div>
            </li> 
            <?php $n++;  if($n >= 14) { $fark_flag = false; } } ?>
        <?php endwhile; endif; ?>
       <?php } ?>  
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
<!-- onmouseout="close_popup(this)"*/-->
