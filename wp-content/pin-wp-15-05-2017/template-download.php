<?php
	/*
	Template Name: SignIn Page
	*/
?>
<?php get_header (); // add header  ?>
<?php if(!isset($_REQUEST['show'])){?>
<?php } ?>
<script>
	window.onbeforeunload = null;
	window.onunload = null;
	function changeFunc ( self ) {
		if(self.value>0){
		var redirect_url = "<?php echo site_url().'/myprofile/?cat_id='; ?>" + self.value;
		}else{
		var redirect_url = "<?php echo site_url().'/myprofile/'; ?>";
		}
		window.location.replace ( redirect_url );
		window.location.href = redirect_url;
	}
</script>
<link rel = "stylesheet" type = "text/css"
      href = "<?php echo site_url (); ?>/wp-content/themes/pin-wp/css/custom-pod.css" >
<?php if ( is_user_logged_in () ) {
	echo do_shortcode ( "[SignIn val='']" );
} else {
	echo do_shortcode ( "[SignIn val='" . $user_id_val . "']" );
} ?>
<?php
	global $smof_data;
	if ( empty( $smof_data[ 'banner_p1' ] ) ) {
		$smof_data[ 'banner_p1' ] = '';
	}

	if ( empty( $smof_data[ 'banner_p2' ] ) ) {
		$smof_data[ 'banner_p2' ] = '';
	}

	if ( empty( $smof_data[ 'banner_p3' ] ) ) {
		$smof_data[ 'banner_p3' ] = '';
	}

	if ( empty( $smof_data[ 'banner_p3' ] ) ) {
		$smof_data[ 'banner_p4' ] = '';
	}

	if ( empty( $smof_data[ 'banner_p3' ] ) ) {
		$smof_data[ 'banner_p5' ] = '';
	}
	$home_pag_select = ( isset( $smof_data[ 'home_pag_select' ] ) ) ? $smof_data[ 'home_pag_select' ] : 'Infinite Scroll';
?>
<!-- Begin Home Full width -->
<div class = "home-fullwidth" >
	<!-- Begin Sidebar (left) -->
	<?php // get_template_part('sidebar2'); ?>
	<!-- end #sidebar (left) -->
	<!-- Begin Main Wrap Content -->
	<div class = "wrap-content" style = "margin-left: 12%;background-color: transparent;" >
            <?php if(!isset($_REQUEST['show'])){?>
		<div class = "template-cat" style = "color:white;margin-left:2%;" >
			<?php $cat = get_categories (); ?>
                         <span class="template-cat-getting myposting-cat " style="display:none;" >
			<select id = "template-category" class = "template-category " onchange = "changeFunc(this);" >
						<option value = '0' >Most Recent</option >
				<?php
					foreach ( $cat as $key => $value ) {
						if ( $value->term_id != $_GET[ 'cat_id' ] ) {
							echo "<option value='{$value->term_id}'>{$value->name}</option>";
						} else {
							echo "<option value='{$value->term_id}' selected='selected'>{$value->name}</option>";
						}
					}
				?>
			</select >
    </span>
		</div >
  <script type="text/javascript">
      jQuery(document).ready(function(){
          jQuery('.template-cat-getting').show();
      });
  </script> 
<?php } ?>
        <ul id="infinite-articles" class="rajiv masonry_list js-masonry"  data-masonry-options='{ "columnWidth": 0 }'> 
        <?php
        if ( is_user_logged_in()){
            if ( get_query_var('paged') ) 
            {  
                $paged = get_query_var('paged'); 
            } 
            elseif ( get_query_var('page') ) 
            { 
                $paged = get_query_var('page');
            } else { $paged = 1;  }

            if( $_GET['cat_id'] == '' || is_numeric($_GET['cat_id'] ) != true )
            { 
                query_posts(array( 'post_type' => 'post', 'paged' => $paged ,'author' => get_current_user_id(), 'tag__not_in' => array($tag_id)));
            }
            else
            {
                query_posts(array('post_type' => 'post', 'paged' => $paged , 'cat' => $_GET['cat_id'] , 'tag__not_in' => array($tag_id)));
            }
        ?>
        <?php $num=0; if (have_posts()) : while (have_posts()) : the_post(); $num++; ?>
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
                 <a  href="<?php the_permalink(); ?>"> <?php echo the_post_thumbnail('thumbnail-blog-masonry'); ?> </a> 
                <?php } // Post Thumbnail ?>  <div class="clear"></div>  
                <div class="small-content">
                  <div class="an-widget-title">
                    <h2 class="article-title entry-title"><a class="title-name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <!--  // edited    -->
                      <?php if(function_exists('taqyeem_get_score')) { ?>
                        <?php taqyeem_get_score(); ?>
                      <?php } ?>                                        
                      <span class="vcard author">
                          <?=acf_context_add($post->ID)?>
                      </span>
                       <div class="article-comm"><?php comments_popup_link('<i class="fa fa-comments"></i> 0', '<i class="fa fa-comments"></i> 1', '<i class="fa fa-comments"></i> %'); ?></div>
                       <div class="index-article-source" style="float:right;color:black;font-weight:bold;">
                        <?php the_source($post->ID); ?>
                       </div>
			                 <div class="posting-author-image">
                          <div class="index-article-author posting-author">
                            <span style="font-size:14px;color:blue;font-family: 'Open Sans', Times, serif;"><?php esc_html_e('', 'anthemes'); ?> <?php the_author(); ?>
                            </span>    
                          </div>
	                        <div class = "posting-image" ><?php echo get_avatar ( $post->post_author , 23 ); ?>
                          </div>
                       </div>
                  </div>
		              <br> 
                  <p><?php echo anthemes_excerpt(strip_tags(strip_shortcodes(get_the_excerpt())), 100); ?></p>
                </div><!-- end .small-content -->
                <div class="home-meta">
                    <div class="an-display-time updated"><i class="fa fa-clock-o"></i> <?php echo time_ago_anthemes(); ?> <?php esc_html_e('ago', 'anthemes'); ?>
                    </div>
                    <div class="an-display-view"><i class="fa fa-eye"></i> <?php echo getPostViews_anthemes(get_the_ID()); ?>
                    </div>      
                    <div class="home-data">
                        <?php if (function_exists('thumbs_rating_getlink')) { echo thumbs_rating_getlink(); } ?>
                    </div><!-- end .home-data --> 
			             <?php //echo do_shortcode('[TheChamp-Sharing style="background-color:transparent;"]'); ?>
                    <div class="clear"></div> 
                </div><!-- Meta ( time and comments ) -->  
            </li>
        <?php endwhile; endif; } ?>
        </ul><!-- end .masonry_list -->
		<!-- end .masonry_list -->
		<!-- Pagination -->
		<?php if ( $home_pag_select == 'Infinite Scroll' ) { ?>
			<div id = "nav-below" class = "pagination" style = "display: none;" >
				<div
					class = "nav-previous" ><?php previous_posts_link ( '&lsaquo; ' . esc_html__ ( 'Newer Entries' , 'anthemes' ) . '' ); ?></div >
				<div
					class = "nav-next" ><?php next_posts_link ( '' . esc_html__ ( 'Older Entries' , 'anthemes' ) . ' &rsaquo;' ); ?></div >
			</div >
		<?php } else { // Infinite Scroll ?>
			<div class = "clear" ></div >
			<?php if ( function_exists ( 'wp_pagenavi' ) ) { ?>
				<?php wp_pagenavi (); ?>
			<?php } else { ?>
				<div class = "defaultpag" >
					<div
						class = "sright" ><?php next_posts_link ( '' . esc_html__ ( 'Older Entries' , 'anthemes' ) . ' &rsaquo;' ); ?></div>
					<div
						class = "sleft" ><?php previous_posts_link ( '&lsaquo; ' . esc_html__ ( 'Newer Entries' , 'anthemes' ) . '' ); ?></div>
				</div >
			<?php } ?>
		<?php } // Default Pagination ?>
		<!-- pagination -->
	</div >
	<!-- end .wrap-content -->
	<div class = "clear" ></div >
</div ><!-- end .home-fullwidth -->
<?php get_footer (); // add footer  ?>
