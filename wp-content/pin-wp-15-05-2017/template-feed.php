<?php 
/* 
Template Name: Template - Feed
*/ 
?>
<style>

div#blog { 
  background: url('images/bodycontainer.jpg')  ;
  margin: 0 auto;
  width: 80%;
  padding: 0;
}

#author{
	color:blue;
	font-size:1em;
}
#article{
 border-bottom: 0.1em solid #ccc;
   
	
}
h3#currentFeedContent {
  clear: both;
   
  color: #888;
  border-bottom: 0.1em solid #ccc;
  
}
</style>
<?php global $post; ?> 
<div id="blog" style="width:60%;margin-left:20%;background:"<?php echo $link; ?>" no-repeat center top;" >
<h3 id="currentFeedContent" >
Current Feed Content
</h3>


<?php if(have_posts())
	  { 
	  	while(have_posts())
     	{
     		the_post(); 
     	 
     	}
 ?>
 <div class="post"> 
   
      <?php
            $current_date ="";
            $count_posts = wp_count_posts();
            $nextpost = 0;
            $published_posts = $count_posts->publish;
   
            $myposts = get_posts(array('posts_per_page'=>$published_posts , 'tag__not_in' => array(6) ));
        
            foreach($myposts as $post)
            {
            
            setup_postdata($post);
    ?> 
                         <div id="article" >
                           <div id="title" ><h3><a href = "<?php the_permalink(); ?>"><?php the_title(); ?></a></h3></div>
                           <div id="date" >Posted: <?php the_date('Y-m-d');echo "  "; the_time('g:i a'); ?></div>
                           <?php if(has_post_thumbnail()){?>
                           <div id="featured"><?php the_post_thumbnail('full'); ?></div>
                           <?php }?>
                           
                           <div id="content" ><?php  the_content(); ?></div> 
                           <div id="author">Submitted by <?php the_author();?>,</div> 
  						 </div><Br>
                          
                    
            <?php 
            }
    wp_reset_postdata(); ?>
 </ol>
 </div>
          </div>
     <?php  } ?>
 
</div>
 

<div style = "clear:both"></div>	

  