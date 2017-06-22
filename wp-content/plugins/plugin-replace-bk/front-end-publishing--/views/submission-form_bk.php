<?php
  $post     = false;
  $post_id  = -1;
  $featured_img_html = '';
  $field_key = "field_551ce1fde54f2"; // For topic 
  $field_key_source = "field_559cca7f8518f"; // For Source
  // source on server field_559cca7f8518f
  // source on localhost field_559ba98ba64bb

  $field_key_source_link = field_55a8aa3c9b104;
  // source on server    field_55a8aa3c9b104
  // source on localhost field_55a88c28349f4
  $source_link =  false;

  $submit_button_value = "Publish post";

  if( isset($_GET['fep_id']) && isset($_GET['fep_action']) && $_GET['fep_action'] == 'edit' ){
    $submit_button_value = "Save & Publish";
    $post_id      = $_GET['fep_id'];
    $p          = get_post($post_id, 'ARRAY_A');
    $user_id = get_current_user_id();
    
    if($p['post_author'] != $user_id) return 'You don\'t have permission to edit this post';
    $category       = get_the_category($post_id);
    $tags         = wp_get_post_tags( $post_id, array( 'fields' => 'names' ) );
        
    $topic_field = get_field($field_key , $post_id );
    $source_field = get_field($field_key_source , $post_id );
    $graph_value = get_post_meta ( $post_id , 'graph_value', true);

    $featured_img     = get_post_thumbnail_id( $post_id );

    $featured_img_html  = (!empty($featured_img))?wp_get_attachment_image( $featured_img, array(200,200) ):'';
    $filename = basename( get_attached_file( $featured_img ) ); // Just the file name
    $post         = array(
                'title'       => $p['post_title'],
                'content'       => $p['post_content'],
                'about_the_author'  => get_post_meta($post_id, 'about_the_author', true)
              );
      $topic = get_field_object($field_key , $post_id );
      

    if(isset($category[0]) && is_array($category))
      $post['category']   = $category[0]->cat_ID;

    if(isset($tags) && is_array($tags))
    {
    foreach ($tags as $key => $value) {
    $old_post_tags[$key]['id'] = $key;
    $old_post_tags[$key]['symbol'] = $value;
    }
    $post['tags'] = json_encode( $old_post_tags , true );
    } 

    $source = get_field_object($field_key_source , $post_id );
    $source_link = get_post_meta($post_id,"source_link",true );
    $video_source = htmlentities(get_post_meta($post_id,"video_source",true ));
  
  }
?>
<style type="text/css">
.error {
  margin:0px !important;
}
a:hover {
  color:#aaa !important;
}
div#mceu_18{
  position:absolute !important;
  width: 100% !important;
  top: -154px;
}
div.mce-statusbar{
  display: none !important;
}
#editor-tool #mceu_16{
  display: none !important;
}
/* #editor-tool #mceu_10 {
    background-image: url(https://cdn0.iconfinder.com/data/icons/social-media-2098/512/facebook-128.png) !important;
    height: 19px;
    width: 19px;
    background-size: cover;
    top: 5px;
} */
#editor-tool #mceu_10 button i{
  display: none !important;
}
#editor-tool #mceu_12{
  display: none !important;
}
.mce-branding-powered-by{
  display: none !important;
}
/*#editor-tool #mceu_10 {
    background-image: url(../wp-content/plugins/front-end-publishing/static/img/youtube.svg) !important;
        height: 15px;
    width: 15px;
    background-size: cover;
    top: 0px;
    vertical-align: middle;
}

#editor-tool #mceu_11 {
    background-image: url(../wp-content/plugins/front-end-publishing/static/img/twitter.svg) !important;
        height: 15px;
    width: 15px;
    background-size: cover;
    top: 0px;
    vertical-align: middle;
}
#editor-tool #mceu_12 button i{
  display: none !important;
}
#editor-tool #mceu_12 {
    background-image: url(../wp-content/plugins/front-end-publishing/static/img/facebook.svg) !important;
      height: 15px;
    width: 15px;
    background-size: cover;
    top:0px;
    vertical-align: middle;
}
#editor-tool #mceu_13 button i{
  display: none !important;
}
#editor-tool #mceu_13 {
    background-image: url(../wp-content/plugins/front-end-publishing/static/img/google-plus-symbol.svg) !important;
        height: 15px;
    width: 15px;
    background-size: cover;
    top: 0px;
    vertical-align: middle;
}
#editor-tool #mceu_14 button i{
  display: none !important;
} 
#editor-tool #mceu_14 {
     background-image: url(../wp-content/plugins/front-end-publishing/static/img/pinterest.svg) !important;
        height: 15px;
    width: 15px;
    background-size: cover;
    top: 0px;
    vertical-align: middle;
}*/
.mce-btn-group .mce-btn{
  border:0px !important;
}
.add-img-btn {
    float: right;
    position: relative;
    top: -35px;
    z-index: 9;
    transition-duration: 140ms;
}
span#coverimagetoggeled {
    padding: 5px;
}
.add-img-btn:hover {
    *background-color: rgba(3, 3, 130, 0.16);
    transition-duration: 140ms;
    transition-timing-function: cubic-bezier(.4,0,1,1);
}

.disable-cover-image{
    font-size: 38px;
    display: inline;
    top: 25px !important;
    left: -7px;
    position: relative;
}
/*#editor-tool #mceu_11 button{
background-image: url('http://www.asiaoceania.org/aogs2016/img/facebook.png') !important;
}*/

/*#editor-tool #mceu_10 button:before {
    content: "\f082" !important; <--- this is your text. You can also use UTF-8 character codes as I do here
    font-family: FontAwesome !important;
    left:-5px !important;
    position:absolute !important;
    top:5 !important;
 }
*/
/*.wp-editor-tools{
  display: none !important;
}*/
</style>
<noscript>
<div id="no-js" class="warning">This form needs JavaScript to function properly. Please turn on JavaScript and try again!</div>
</noscript>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <!-- <script src='<?php //echo get_template_directory_uri()?>/js/tinymce.min.js'></script> -->
   <script src='//cloud.tinymce.com/stable/tinymce.min.js'></script>   
   <script>
      tinymce.init({
        selector: '#fep-post-content',
        height: 200,
        //theme: 'modern',
        plugins: "media",
        toolbar1: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        content_css: [
          '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
          '//www.tinymce.com/css/codepen.min.css'
        ]
       });
      // tinymce.init({
      //   selector: "#fep-post-content",  // change this value according to your HTML
      //   plugins: "media",
      //   menubar: "insert",
      //   toolbar: "media",
      //   media_scripts: [
      //    {filter: 'http://media1.tinymce.com'},
      //    {filter: 'http://media2.tinymce.com', width: 100, height: 200}
      //  ]
      // });
    //   $(document).ready(function(){
    //     $('.mce-i-media').addClass('asdf');
    // });
  </script>
<!--NEW POST DESIGN -->
<!-- <div class="row">
  <div class="col-md-12">
     <?php
                //$enable_media = (isset($fep_roles['enable_media']) && $fep_roles['enable_media'])?current_user_can($fep_roles['enable_media']):1;
               //wp_editor( $post['content'], 'fep-post-content', $settings = array('textarea' => false,'textarea_name'=>false, 'textarea_rows'=> false,'media_buttons'=> false, 'quicktags' => array("buttons"=>false), 'drag_drop_upload' => true, 'tabindex' => 3, 'tinymce'=> false,) );
            ?>
  </div>
</div> -->
<div class="row">
<div class="col-md-12">
  <div class="user-post-section" id="fep-new-post-submit">
    <div class="smart-forms smart-container wrap-2">
      <div class="form-header header-primary" style="display:none;">
        <h4><i class="fa fa-pencil-square"></i>Add New Post</h4>
      </div>
      <!-- end .form-header section -->
      
      <form id="fep-submission-form" method="post" class="smart-form">
        <div class="form-body">
            <div class="add-img-btn">
            <span id="coverimagetoggeled" class="enable-cover-image">Add cover image
            </span>
            <span id="coverimageremove" class="disable-cover-image">x
            </span>
            </div>
            <div class="section" id="showfeaturedimage" style="display: none">
            <label for="file1" class="field file" id="filebgcolor"> <a id ="fep-featured-image-link" class="new-featured-image" href="#"><img  src="<?php echo esc_url(get_template_directory_uri()); ?>/images/img-upload-icon.svg"></a>
              <input class="gui-input pad-lft" id="uploader1" style="visibility:hidden;" readonly="" type="text" value="<?php echo (!empty($filename))?$filename:''; ?>">
              <input type="hidden" id="fep-featured-image-id" name="fep_featured_image_id" value="<?php echo (!empty($featured_img))?$featured_img:''; ?>"/>
            <!-- <span class="fa fa-upload upload-icon"></span> -->
            <input id="fepupload" name="fepupload" accept="image/*" style="display:none;" onchange="PreviewfeaturedImage(this.id,'<?php echo site_url()?>/wp-upload-featured.php');" type="file">
            </label>
            </div>
          
            <div class="section headline">
            <label for="useremail" class="field prepend-icon">
                <input type="text" placeholder="Headline" class="gui-input gui-input-title" name="post_title" id="fep-post-title" value="<?php echo ($post) ? $post['title']:''; ?>">
            </label>
            </div>
            <hr>
            <br>
            <div class="section" id="editor-tool">
            <textarea class="fep-post-content" name="post_content" id="fep-post-content"></textarea>
            <?php
                //$enable_media = (isset($fep_roles['enable_media']) && $fep_roles['enable_media'])?current_user_can($fep_roles['enable_media']):1;
               //wp_editor( $post['content'], 'fep-post-content', $settings = array('textarea_name'=>'post_content', 'textarea_rows'=> 6,'media_buttons'=> true, 'quicktags' => array("buttons"=>false), 'drag_drop_upload' => true, 'tabindex' => 3, 'tinymce'=> true,) );
               //wp_nonce_field('fepnonce_action','fepnonce');
            ?>
            </div>
            <?php /*************************************************/ ?>

            <div class="section">
                <label class="field select">
            <?php                    
                $field = get_field_object($field_key);
     
                if( $field )
                {
                echo '<select name="topic" id="fep-topic" data-placeholder="Choose a Context...">';
                echo '<option value="">Choose a Context</option>';
               foreach( $field['choices'] as $k => $v )
                {
                    if($k!="None"){
                        if( $k == $topic_field || $v == $topic_field )
                        {
                            echo '<option value="' . $k . '" selected="selected" >' . $v . '</option>';
                        }
                        else
                        {
                            echo '<option value="' . $k . '">' . $v . '</option>';
                        }
                    }                
                }
                    echo '</select>';
                }
                
            ?>
            <i class="arrow double"></i> </label>
            <input type="hidden" id="topic_field_key" value="<?php echo $field_key ; ?>" >
            <label id="fep-post-topic" class="error valid" generated="true" for="fep-post-topic" style="display:none;top:-21px"></label>
            </div>
            <div class="section">
                <label for="post_source" class="field prepend-icon">
              <?php
                    $field_source = array();
                    $field_source = get_field_object($field_key_source);
                    if( $field_source )
                    { 
                        $temp_field_source = $field_source['choices'];
                        $autocomplete_json = array();
                        $i = 0;  
                        foreach( $field_source['choices'] as $value => $display ) {
                             array_push($autocomplete_json,array( 'id'=> $i,'value'=>$value ,'name' =>$display) );
                             $i++;
                        }
                        $autocomplete_json = json_encode( $autocomplete_json );
                    }
                        ?>
              <div id="fep-source-container">
                <input type="text" name="post_source" class="gui-input" id="fep-source" value='' placeholder="Choose a Source"  >
                <input type="hidden" name="old_post_source" id="old-fep-source" value='<?php echo ($source_field) ? $source_field:''; ?>'  >
                <input type="hidden" name="source_json" id="source_json" value='<?php echo $autocomplete_json; ?>' >
              </div>
              <input type="hidden" id="source_field_key" value="<?php echo $field_key_source ; ?>" >
            </label>
            </div>

            <div class="section">
                <label for="source_link" class="field prepend-icon">
                <input type="text" class="gui-input" name="source_link" placeholder="Source Link" id="fep-source-link" value="<?php echo ($source_link) ? $source_link:''; ?>">
                <input type="hidden" id="source_link_key" value="<?php echo $field_key_source_link ; ?>" >
                </label>
            </div>
          <!-- end section -->
            <div class="section">
                <input type="hidden" name="author_ide" id="author_ide" value="<?php echo get_current_user_id(); ?>">
                <?php /***************************************/ ?>
                <?php if(!$fep_misc['disable_author_bio']): ?>
                <label for="fep-about">Author Bio</label>
                <br/>
                <textarea name="about_the_author" id="fep-about" rows="5"><?php echo ($post) ? $post['about_the_author']:''; ?></textarea>
                <br/>
                <?php else: ?>
                <input type="hidden" name="about_the_author" id="fep-about" value="-1">
                <?php endif; ?>
            </div>

            <div class="section">
              <label class="field select">
                  <select id="fep-category"  name="post_category">
                    <?php  
                    $args = array('orderby' => 'name','order' => 'ASC');
                    $categories = get_categories($args);
                    echo '<option value="">Choose a Category</option>';
                    foreach(  $categories as $key => $value ){
                    if($post['category']==$value->term_id){
                     echo '<option selected="selected" value="' . $value->term_id . '">' . $value->name . '</option>';
                    }else{
                     echo '<option value="' . $value->term_id . '">' . $value->name . '</option>';
                    }
                    }
                    ?>
                  </select>
                 <i class="arrow double"></i>
              </label>
            </div>

          <div class="section">
            <label class="field select">
            <div id="fep-tag-container">
              <input type="hidden" name="post_tags" id="fep-tags" value='<?php echo ($post) ? $post['tags']:''; ?>'  >
              <input type="hidden" name="post_tags_graph" id="fep-tags_graph" value='<?php echo ($graph_value) ? $graph_value:''; ?>'  >
              <input type="hidden" name="old_post_tags" id="old-fep-tags" value='<?php echo ($post) ? $post['tags']:''; ?>'  >
            </div>
            </label>
          </div>

          <!-- end section -->
        
          <div class="section">
             <span class="demo-checkbox-btn">
                <input  type="checkbox" name="embed_video" id="embed_video" value="" <?php if($video_source != ''){ echo 'checked="checked"'; }?>/>
                <label for="embed_video"><span></span>Embed video </label>
              </span>
              <span class="video-filled <?php echo $video_source != '' ? 'section_show': 'section_hide'; ?>">
                  <label for="source_link" class="field prepend-icon">
                  <textarea placeholder="Text area" row="10" name="video_source" id="video_source" class="gui-textarea" ><?php echo $video_source ; ?></textarea>
                  </label>
                </span>  
            </div>
          </div>
        <!-- end .form-body section -->
        <div class="form-footer">
            <input type="hidden" name="post_id" id="fep-post-id" value="<?php echo $post_id ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?=get_current_user_id() ?>">
            <button type="button" id="fep-submit-post" disabled class="button btn-primary active-btn"><?php echo $submit_button_value;?></button>
            <img class="fep-loading-img" src="<?php echo plugins_url( 'static/img/ajax-loading.gif', dirname(__FILE__) ); ?>"/>
            <button type="button" class="button" onclick="location.href = '<?php echo site_url()."/myprofile/"; ?>';">Cancel</button>
        </div>
        <!-- end .form-footer section -->
        <!-- end .form-footer section -->
      </form>
    </div>
  </div>
</div>
<!-- <script>
$(function(){

    $("#fep-post-title").typed({
        // strings: ["Typed.js is a <strong>jQuery</strong> plugin.", "It <em>types</em> out sentences.", "And then deletes them.", "Try it out!"],
        strings: ["Please enter post title"],
        typeSpeed: 30,
        backDelay: 500,
        loop: true,
        contentType: 'html', // or text
        // defaults to false for infinite loop
        loopCount: false,
        callback: function(){ foo(); },
        resetCallback: function() { newTyped(); }
    });

    $("#fep-post-title").click(function(){
      var str = "Please enter post title";
      var n = str.match($(this).val()); 
      $(this).attr('placeholder','Enter Post Title');
      if(n!=null){
        $(this).val("");
      }
        $(this).typed('reset');
    });

    $("#fep-post-title").blur(function(){
        $(this).attr('placeholder','');
        if($(this).val()==""){
            $("#fep-post-title").typed({
                // strings: ["Typed.js is a <strong>jQuery</strong> plugin.", "It <em>types</em> out sentences.", "And then deletes them.", "Try it out!"],
                strings: ["Please enter post title"],
                typeSpeed: 30,
                backDelay: 500,
                loop: true,
                contentType: 'html', // or text
                // defaults to false for infinite loop
                loopCount: false,
                callback: function(){ foo(); },
                resetCallback: function() { newTyped(); }
            });
        }
    });
});

function newTyped(){ /* A new typed object */ }

function foo(){ console.log("Callback"); }

</script> -->
<script>
        jQuery(document).ready(function(){
          $('#coverimageremove').hide();
          $('#coverimagetoggeled').on('click', function(){
            $('#mceu_18').css('top','-388px');
            $('#showfeaturedimage').slideDown('slow');
            $('#coverimagetoggeled').hide();
            $('#coverimageremove').show()
          });
          $('#coverimageremove').on('click', function(){
            $('#mceu_18').css('top','-154px');
            $('#showfeaturedimage').slideUp('slow');
            $('#coverimagetoggeled').show();
            $('#coverimageremove').hide();
          });
           // $("#coverimagetoggeled").click(function(){
           //    $("#showfeaturedimage").slideToggle("slow");
           // });
            

            jQuery.validator.setDefaults ( {
                debug: true,
                success: "valid"
            } );
            $("#fep-submission-form1").validate ( {
                ignore: "",
                errorClass:"state-error",
                validClass:"state-success",
                errorElement:"em",
                rules: {
                    post_title: {
                        required: true
                    },
                    post_content: {
                        required: true
                    },
                    post_category: {
                        required: true
                    },
                    fep_featured_image_id: {
                        required: {
                          depends: function () {
                              if(jQuery('#embed_video').is(':checked')){
                                  return false;
                              } else {
                                  return true;
                              }
                          }
                        } 
                    },
                    video_source: {
                        required: {
                          depends: function () {
                              if(jQuery('#embed_video').is(':checked')){
                                  return true;
                              } else { 
                                  jQuery(".video-filled").hide();
                                  return false;
                              }
                          }
                        } 
                    }
                },
                messages: {
                    post_title:{
                       required:"Please enter post title"
                    },
                    post_content:{
                        required:"Please enter content."
                    },
                    post_category: {
                        required: "Please select category.",
                    },
                    fep_featured_image_id:{
                         required: "Please select image.",
                    },
                    video_source:{
                         required: "Please enter embed video script.",
                    }
                },
                highlight: function(element, errorClass, validClass) {
                            jQuery(element).closest('.field').addClass(errorClass).removeClass(validClass);
                    },
                    unhighlight: function(element, errorClass, validClass) {
                            jQuery(element).closest('.field').removeClass(errorClass).addClass(validClass);
                    },
                    errorPlacement: function(error, element) {
                       if (element.is(":radio") || element.is(":checkbox")) {
                                element.closest('.option-group').after(error);
                       } else {
                                error.insertAfter(element.parent());
                       }
                    },
                submitHandler: function ( form ) {
                    form.submit();
                }
            } );
        } );
    </script>
