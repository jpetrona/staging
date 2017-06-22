<div class="small-content">
                  <div class="an-widget-title">
                     <h2 class="article-title entry-title"><a class="title-name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <!--  // edited    -->
                        <div class="home-source-left">                         
                     <?php if(function_exists('taqyeem_get_score')) { ?>
                        <?php taqyeem_get_score(); ?>
                      <?php } ?> 
                      <span class="vcard author">  <?=acf_context_add($post->ID)?></span>
                       <div class="article-comm"><?php comments_popup_link('<i class="fa fa-comments"></i> 0', '<i class="fa fa-comments"></i> 1', '<i class="fa fa-comments"></i> %'); ?></div>
                       <div class="posting-author-image">
                       <div class="posting-author">
                         <span style="font-size:14px;color:blue;font-family: 'Open Sans', Times, serif;"><?php esc_html_e('', 'anthemes'); ?> <?php the_author(); ?></span>    
                       </div>
                      <div class = "posting-image" ><?php echo get_avatar ( $post->post_author , 23 ); ?></div >
                        </div>
                        </div>
                       <div class="index-article-source home-source-image" >
                        <?php the_source($post->ID); ?>
                       </div>
      
                  </div> 
    <br>
                  <p><?php echo anthemes_excerpt(strip_tags(strip_shortcodes(get_the_excerpt())), 100); ?></p>
                </div>
<!-- end .small-content -->
