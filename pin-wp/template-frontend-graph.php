<?php
/*
Template Name: Template - Frontend graph front page
*/
?>
<?php get_header(); // add header  ?>
<?php $graph_id = $_GET['getid'];?>
<!-- Begin Content -->
<div class="wrap-fullwidth graph-detail">
      <div><!--First div-->
          <div class="single-content">
              <?php $getresult = frontend_graph($graph_id,'graph'); ?>
              <?php $sourcelink = (isset($getresult[0]->sourcelink) && $getresult[0]->sourcelink != '') ? $getresult[0]->sourcelink : ''; ?>
              <?php $instrument = (isset($getresult[0]->instrument) && $getresult[0]->instrument != '') ? $getresult[0]->instrument : ''; ?>
              <?php $category = (isset($getresult[0]->category) && $getresult[0]->category != '') ? $getresult[0]->category : ''; ?>
              <?php $source = (isset($getresult[0]->source) && $getresult[0]->source != '') ? $getresult[0]->source : ''; ?>
              <?php $title = (isset($getresult[0]->title) && $getresult[0]->title != '') ? $getresult[0]->title : ''; ?>
              <?php $post_detail_content = (isset($getresult[0]->content) && $getresult[0]->content != '') ? $getresult[0]->content : ''; ?>
              <?php $context = (isset($getresult[0]->title) && $getresult[0]->title != '') ? frontend_graph($getresult[0]->title,'context',$getresult[0]->context) : '';?>
              <?php $post_image = (isset($getresult[0]->image) && $getresult[0]->image != '') ? frontend_graph($getresult[0]->image,'image') : '' ; ?>
              <?php $votes = (isset($getresult[0]->votes) && $getresult[0]->votes != '') ? $getresult[0]->votes : ''; ?>
              <?php $embed_video = (isset($getresult[0]->embed_video) && $getresult[0]->embed_video != '') ? $getresult[0]->embed_video : ''; ?>
              <?php $user_ID = get_current_user_id();
                    if(isset($getresult[0]->post_author) && $getresult[0]->post_author == $user_ID ){
                       $profile_url = get_site_url().'/myprofile';
                    }else{
                       $profile_url = 'javascript:void(0)';
                    }
                    if(isset($getresult[0]->post_author) && $getresult[0]->post_author != 0) {
                      $author_name = get_userdata($getresult[0]->post_author)->display_name;
                      $author_id = $getresult[0]->post_author;
                      $post_date = $getresult[0]->post_date;
                      $performance_posted_date =  date('m-d-Y', strtotime($getresult[0]->post_date));
                    }else{
                      $author_name = 'Retirely';
                      $author_id = 1;
                      $post_date = '2016-02-01 15:23:21';
                      $performance_posted_date = '';
                    }
                    $expertimage = (isset($getresult[0]->expertimage) && $getresult[0]->expertimage != 0) ? $getresult[0]->expertimage : '';
                    $expertname = (isset($getresult[0]->expertname) && $getresult[0]->expertname != '') ? $getresult[0]->expertname : '';
                    $expertcomment = (isset($getresult[0]->expertcomment) && $getresult[0]->expertcomment != '') ? $getresult[0]->expertcomment : '';
                    $expertimagesize = array(55,55);
                    $profileimage = wp_get_attachment_image_src( $expertimage , $expertimagesize);
                    $stockpostedprice = (isset($getresult[0]->stockpostedprice) && $getresult[0]->stockpostedprice != 0) ? $getresult[0]->stockpostedprice : '';
              ?>
            <input type="hidden" id="detail-instrument" val="<?php echo $getresult[0]->instrument; ?>"/>
            <div class="post-detailpage">
                  <div class="author-image-single">
                      <?php echo isset($author_id) ? get_avatar(  $author_id   , 32 ) : '' ; ?>
                  </div>
              </div>
              <div class="author-display-name-single">
                <input type="hidden" value="//localhost"><a href="<?php echo $profile_url; ?>" style="color:blue;border-bottom:none;" class="the_author_link"><?php echo $author_name; ?></a>            
              </div>
              <div class="author-display-time-single">
                <div><?php echo  graph_human_time_diff( strtotime($post_date) ) . ' ago';?> </div>
              </div>
               <div class="the_source">
                  <?php $getresult = frontend_graph($graph_id,'source',$getresult[0]->source);
                      if(isset($getresult) && $getresult['source'] != '' ){
                        $imageUrl = get_template_directory_uri()."/images/source/".$getresult['source'];
                        ?>
                        <a href="<?php echo $sourcelink; ?>"><img style="" src="<?php echo $imageUrl; ?>"></a>
                  <?php } ?>
              </div>

              <div class="the_graphdetail"></div>

              <div class="post-article-title">
                    <h1 class="article-title entry-title"><?php echo $title; ?></h1>
              </div>

              <div align="center" class="entry-top">
                <span class="vcard author">
                  <div><img style="max-width:60px;" src="<?php echo get_template_directory_uri().'/images/context/'.$context['context-image'] ;?>"></div>
                </span>
              </div>
              <div class="clear"></div>

              <article>
                  <div class="frontend-post post type-post status-publish format-standard has-post-thumbnail hentry category-business">
                    <div class="media-single-content">
                    <?php if(isset($post_image['0']) != '' ){ ?>
                      <img width="950" height="534" src="<?php echo $post_image['0']; ?> " class="attachment-thumbnail-single-image wp-post-image" >
                    <?php } else { ?>
                      <?php echo stripslashes($embed_video);  ?>
                    <?php } ?>
                    </div>
                    <div class="entry">
                        <?php echo isset($post_detail_content) ? $post_detail_content : '' ;?>
                        <?php if($expertname != '' && $expertcomment != '') {?>
                          <div class="expert-comment">
                          <div class="image-section">
                              <div class="image">
                                   <img src="<?php echo $profileimage[0];?>" alt="">
                              </div>
                              <div class="info">
                                   <?php echo $expertname;?>
                              </div>
                          </div>
                          <div class="content-section">
                               <?php echo stripslashes($expertcomment);?>
                          </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div id="graph-detail-page" style="margin-left:31px; height:250px; max-width: 540px;width:540px;"></div>
                    <div class="watch-action">
                      <div class="watch-position align-right">
                        <div class="action-like">
                          <a rel="nofollow" data-post-id="<?php echo $graph_id;?>" data-task="like" href="javascript:void(0)" class="jlk-graph">
                              <i aria-hidden="true" class="fa fa-thumbs-o-up post-like-up"></i>
                              <span class="lc-<?php echo $graph_id?> lc"><?php echo $votes > 0 ? '+'.$votes : 0 ; ?></span>
                          </a>
                        </div>
                        <div class="action-unlike">
                          <a rel="nofollow" data-post-id="<?php echo $graph_id?>" data-task="unlike" href="javascript:void(0)" class="jlk-graph">
                            <i aria-hidden="true" class="fa fa-thumbs-o-down post-like-down"></i>
                            <span class="unlc-<?php echo $graph_id?> unlc"> <?php echo $votes < 0 ? $votes : 0 ; ?></span>
                          </a>
                        </div> 
                      </div> 
                      <div class="status-<?php echo $graph_id?> status align-right"></div>
                    </div>
                    <div class="ct-size graph-ct-size">
                        <div class="entry-btn">Article Tags:</div>
                        <div class="tag-container">
                          <input type="hidden" value="<?php echo $performance_posted_date;?>" class="date-icon">
                          <div class="instrument-<?php echo $getresult[0]->id; ?>" ></div>
                        </div>
                        <div class="ct-size"><div class="entry-btn">Article Categories:</div> <a rel="category tag" href="<?php echo get_category_link( $category ); ?>"><?php echo get_cat_name( $category ) ?></a></div>
                    </div>
                  </div>
              </article>
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
                              <div class="article-comm" style="float:right; margin-right:-51px;"><?php comments_popup_link('<i class="fa fa-comments"></i> 0', '<i class="fa fa-comments"></i> 1', '<i class="fa fa-comments"></i> %'); ?>
                              </div>
                                  </div>
                                  </span>
                              </div>
                            </li>
                            <?php endwhile; wp_reset_query(); ?>
                          </ul>
                  </div><!-- end .one_half Recent -->
          </div><!--single-content div end-->
      </div> <!--First div end-->
  <!-- Begin Sidebar (right) -->
    <?php  get_sidebar(); // add sidebar ?>
    <!-- end #sidebar  (right) -->
    <div class="clear"></div>
</div><!-- end .wrap-fullwidth -->
<?php get_footer(); // add footer  ?>
<script type="text/javascript">
  jQuery( document ).ready(function() {
    var shortname = '<?php echo $instrument; ?>';
    var stockpostedprice = '<?php echo $stockpostedprice; ?>';
    var id = '<?php echo $getresult[0]->id; ?>';
    var posted_date = '<?php echo $performance_posted_date; ?>';
    var source = '<?php echo $source; ?>';
    //console.log(source);
    if( shortname.length > 0){
      var url = '//query.yahooapis.com/v1/public/yql?q=select * from yahoo.finance.quotes where symbol in ("'+shortname+'")&env=http://datatables.org/alltables.env&format=json';
        jQuery.get(url, function(data){
        var x = data['query']['results'].quote;
        if( x.LastTradePriceOnly != undefined){
          creategraphdetail(shortname,x);
          if( x.PercentChange.indexOf("+") > -1  ){
            string = x.LastTradePriceOnly+"&nbsp;&nbsp;<span>"+x.PercentChange+"</span>";
            class_hover = "tag-format-green-hover";
          }else{
            string = x.LastTradePriceOnly+"&nbsp;&nbsp;<span>"+x.PercentChange+"</span>";
            class_hover = "tag-format-red-hover";
          }
          jQuery('.instrument-'+id).append('<button class="tag-format '+class_hover+'" title="'+x.Name+'" >&nbsp;'+ x.symbol +" "+ string +'&nbsp;</button>');
         if( stockpostedprice  != null && stockpostedprice.length > 0){
          diff = numberDiff(x.LastTradePriceOnly,stockpostedprice);
          var sign = diff > 0 ? 1 : -1;
          if(sign > 0 && diff != 0 ){
            var percentageChange = ((parseFloat(x.LastTradePriceOnly)-parseFloat(stockpostedprice))*100)/parseFloat(stockpostedprice);
                jQuery('.the_graphdetail').append('<div class="main-tooltip" ><span class="point1-green"><div class="tooltip">Real time stock price<br/>$'+x.LastTradePriceOnly+'</div></span><div class="line-green graph-green"><div class="graph-detail-tooltip"><span class="graph-performance">Performance</span>'+' (+)'+percentageChange.toFixed(2)+'%</div></div><span class="point2-green"><div class="tooltip">Price of Stock on '+posted_date+'<br/>$'+stockpostedprice+'</div></span></div>');
          }  else if(diff==0){
          }else{
                 var percentageChange = ((parseFloat(stockpostedprice)-parseFloat(x.LastTradePriceOnly))*100)/parseFloat(stockpostedprice);
                 jQuery('.the_graphdetail').append('<div class="main-tooltip" ><span class="point1-red"><div class="tooltip">Price of Stock on '+posted_date+'<br/>$'+stockpostedprice+'</div></span><div class="line-red graph-red"><div class="graph-detail-tooltip"><span class="graph-performance">Performance</span>'+' (-)'+percentageChange.toFixed(2)+'%</div></div><span class="point2-red"><div class="tooltip">Real time stock price<br/>$'+x.LastTradePriceOnly+'</div></span></div>');
          }
         }
        }
      });
    }
  });
</script>
