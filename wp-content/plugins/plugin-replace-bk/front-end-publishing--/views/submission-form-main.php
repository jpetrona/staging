<?php
$post = false;
$post_id = - 1;
$featured_img_html = '';
$field_key = "field_551ce1fde54f2"; // For topic
$field_key_source = "field_559cca7f8518f"; // For Source

// source on server field_559cca7f8518f
// source on localhost field_559ba98ba64bb

$field_key_source_link = field_55a8aa3c9b104;

// source on server    field_55a8aa3c9b104
// source on localhost field_55a88c28349f4

$source_link = false;
$submit_button_value = "Publish post";

if (isset($_GET['fep_id']) && isset($_GET['fep_action']) && $_GET['fep_action'] == 'edit')
  {
  $submit_button_value = "Save & Publish";
  $post_id = $_GET['fep_id'];
  $p = get_post($post_id, 'ARRAY_A');
  $user_id = get_current_user_id();
  if ($p['post_author'] != $user_id) return 'You don\'t have permission to edit this post';
  $category = get_the_category($post_id);
  $tags = wp_get_post_tags($post_id, array(
    'fields' => 'names'
  ));
  $topic_field = get_field($field_key, $post_id);
  $source_field = get_field($field_key_source, $post_id);
  $graph_value = get_post_meta($post_id, 'graph_value', true);
  $featured_img = get_post_thumbnail_id($post_id);
  $featured_img_html = (!empty($featured_img)) ? wp_get_attachment_image($featured_img, array(
    200,
    200
  )) : '';
  $filename = basename(get_attached_file($featured_img)); // Just the file name
  $post = array(
    'title' => $p['post_title'],
    'content' => $p['post_content'],
    'about_the_author' => get_post_meta($post_id, 'about_the_author', true)
  );
  $topic = get_field_object($field_key, $post_id);
  if (isset($category[0]) && is_array($category)) $post['category'] = $category[0]->cat_ID;
  if (isset($tags) && is_array($tags))
    {
    foreach($tags as $key => $value)
      {
      $old_post_tags[$key]['id'] = $key;
      $old_post_tags[$key]['symbol'] = $value;
      }

    $post['tags'] = json_encode($old_post_tags, true);
    }

  $source = get_field_object($field_key_source, $post_id);
  $source_link = get_post_meta($post_id, "source_link", true);
  $video_source = htmlentities(get_post_meta($post_id, "video_source", true));
  }


?>
<style type="text/css">
.prepend-icon{
  display:none;
}
.error {
  margin:0px !important;
}
a:hover {
  color:#aaa !important;
}
div#mceu_18{
  position: absolute !important;
  width: 92% !important;
  top: 0px;
  padding: 4px;
}
div#mceu_19 {
    margin-left: 103px !important;
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
.mce-btn-group .mce-btn{
  border:0px !important;
}
.add-img-btn {
    float: right;
    position: relative;
    top: -40px;
    z-index: 9;
    transition-duration: 140ms;
    right: -28px;
}
.rtl-profile-form-label{
  font-size:16px!important;
}
.rtl-profile-form .headline{
  font-weight:500;
  font-size:28px!important;
}


span#coverimagetoggeled {   
    padding: 5px;
    position: relative;
    top: 8px;
    right: 29px;
}
span#coverimagetoggeled:hover{
/*    background-color: rgba(147, 126, 249, 0.15) !important;*/
    /*  background-color: rgba(23, 152, 208, 0.15) !important;*/
}
span#coverimagetoggeled a{
    padding: 8px;
    background-color: rgba(0, 0, 0, 0.075);
    color: #000;
}

span#coverimagetoggeled a:hover {
    color: #1798D0 !important;
    background-color: rgba(23, 152, 208, 0.15);
}

span#coverimageremove:hover{ 
    color: #fff; 
    text-align: center;
    cursor: pointer;
    background-color: rgb(116, 196, 232);
}
.add-img-btn:hover {
    *background-color: rgba(3, 3, 130, 0.16);
    transition-duration: 140ms;
    transition-timing-function: cubic-bezier(.4,0,1,1);
}

#showfeaturedimage{
     opacity: 0.6; 
}
 
.disable-cover-image{
    font-size: 32px;
    top: 60px !important;
    right: 40px;
    border-radius: 15px;
    position: absolute;
}

#coverimageremove{
    font-size: 22px;
    width: 30px;
    height: 30px;
    padding: 0px 8px;
    color: #8e8e8e;
    text-align: center;
    cursor: pointer;
    font-weight: 300;
    display: block;
    padding: 1px 7px;
}

#showfeaturedimage:hover{
     opacity: 1; 
}
 
 /*custom material ui*/

/* form starting stylings ------------------------------- */
.myprofile-form .group        { 
  position:relative; 
  margin-bottom:0; 
}
.post-heading-top {
    margin-top: 13px;
}
input#fep-post-title {
    font-size: 24px;
}
.myprofile-form input{
  font-size:14px;
  padding:10px 10px 10px 5px;
  display:block;
  width:100%;
  border:none;
/*  border-bottom:1px solid #757575;*/
  border-bottom: 1px solid #e6e6e6;
}
.myprofile-form input:focus     { outline:none; }

/* LABEL ======================================= */
.myprofile-form label          {
  color:#999; 
  font-size:24px;
  font-weight:normal;
  position:absolute;
  pointer-events:none;
  left:5px;
  top:0px;
  transition:0.2s ease all; 
  -moz-transition:0.2s ease all; 
  -webkit-transition:0.2s ease all;
}

/* active state */
.myprofile-form input:focus ~ label,.myprofile-form input:valid ~ label    {
  top:-19px;
  font-size:14px !important;
  color:#5264AE;
}

.myprofile-form input:focus ~ label.headline,.myprofile-form  input:valid ~ label.headline    {
  top:-19px;
  font-size:18px !important;
  color:#5264AE;
}

/* active state */
.myprofile-form ul li input:focus ~ label,.myprofile-form ul li input:valid ~ label    {
  top:-19px;
  font-size:14px;
  color:#5264AE;
}


.rtl-select:hover{
  border-color:#1798D0!important;
}

/* BOTTOM BARS ================================= */
.myprofile-form .bar  { position:relative; display:block; width:100; }
.myprofile-form .bar:before, .bar:after   {
  content:'';
  height:2px; 
  width:0;
  bottom:1px; 
  position:absolute;
  background:#1798D0; 
  transition:0.2s ease all; 
  -moz-transition:0.2s ease all; 
  -webkit-transition:0.2s ease all;
}
.myprofile-form .bar:before {
  left:50%;
}
.myprofile-form .bar:after {
  right:50%; 
}

/* active state */
.myprofile-form input:focus ~ .bar:before,.myprofile-form input:focus ~ .bar:after {
  width:50%;
}
.myprofile-form ul li input:focus ~ .bar:before,.myprofile-form ul li input:focus ~ .bar:after {
  width:50%;
}

/* HIGHLIGHTER ================================== */
.myprofile-form .highlight {
  position:absolute;
  height:60%; 
  width:100px; 
  top:25%; 
  left:0;
  pointer-events:none;
  opacity:0.5;
}

.cros-tooltip{
    position: absolute;
    width: 135px;
    background:#565556;
    color: #fff;
    font-size: 15px;
    padding: 7px 0;
    border-radius: 2px;
    display: none;
    top: -42px;
    right: 0;
}

.disable-cover-image:hover .cros-tooltip{
  display:block;
} 

.cros-tooltip:before {
    content: ' ';
    position: absolute;
    top: 40px;
    left: 115px;
    width: 0;
    height: 0;
    margin-top: -8px;
    border: 8px solid transparent;
    border-right-color:#565556;
    -ms-transform: rotate(7deg);
    -webkit-transform: rotate(7deg);
    transform: rotate(-90deg);
  }

/* active state */
.myprofile-form input:focus ~ .highlight {
  -webkit-animation:inputHighlighter 0.3s ease;
  -moz-animation:inputHighlighter 0.3s ease;
  animation:inputHighlighter 0.3s ease;
}
/* active state */
.myprofile-form ul li input:focus ~ .highlight {
  -webkit-animation:inputHighlighter 0.3s ease;
  -moz-animation:inputHighlighter 0.3s ease;
  animation:inputHighlighter 0.3s ease;
}
 
.deletefeaurued-icon{
    text-align: center;
    margin-left: 37px;
    position: relative;
    top: 100px;
    display:none;
}

.deletefeaurued-icon .fa{
  
    text-align: center;
    border-radius: 20px;
    height: 40px;
    width:40px;
    line-height: 40px;
    font-size:21px;
/*    color: rgba(0,0,0,.85);*/
    background-color: rgb(255, 255, 255);
}

.deletefeaurued-icon .fa:hover {
    height: 40px;
    width: 40px;
    line-height: 30px;
    font-size:21px;
    text-align: center;
    border-radius: 20px; 
    color: white;
    cursor: pointer;
    background-color: rgb(116, 196, 232);
    vertical-align: middle;
    line-height: 40px;
    display: inline-block;
}
.cover-icon-grn,.cover-icon-red{
  position: absolute;
  right: 10px;
  top: 12px;
  font-size: 18px;
}

.cover-icon-grn{
  color:green  
}
.cover-icon-red{
    color: rgba(255, 0, 0, 0.68);
}
.mce-panel{
   border: 1px solid #c2c2c2;
}
.mce-panel:hover{
  border: 1px solid #1798D0;   
}
.rtl-numbe-list{
    position: absolute;
    left: -21px;
    top: 10px;
}
.numbe-list-text-aria{
    position: relative;
    left: -21px;
    top: 30px;
}
/* ANIMATIONS ================ */
@-webkit-keyframes inputHighlighter {
  from { background:#5264AE; }
  to  { width:0; background:transparent; }
}
@-moz-keyframes inputHighlighter {
  from { background:#5264AE; }
  to  { width:0; background:transparent; }
}
@keyframes inputHighlighter {
  from { background:#5264AE; }
  to  { width:0; background:transparent; }
}
 /*custome material ui end*/
</style>
<noscript>
<div id="no-js" class="warning">This form needs JavaScript to function properly. Please turn on JavaScript and try again!</div>
</noscript>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <!-- <script src='<?php //echo get_template_directory_uri()
 ?>/js/tinymce.min.js'></script> -->
   <script src='//cloud.tinymce.com/stable/tinymce.min.js'></script>   
   <script>
      tinymce.init({
        selector: '#fep-post-content',
        height: 200,

        // theme: 'modern',

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

// $enable_media = (isset($fep_roles['enable_media']) && $fep_roles['enable_media'])?current_user_can($fep_roles['enable_media']):1;
// wp_editor( $post['content'], 'fep-post-content', $settings = array('textarea' => false,'textarea_name'=>false, 'textarea_rows'=> false,'media_buttons'=> false, 'quicktags' => array("buttons"=>false), 'drag_drop_upload' => true, 'tabindex' => 3, 'tinymce'=> false,) );

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
            <span id="coverimagetoggeled" class="enable-cover-image"><a href="javascript:void(0)">Add cover image
            </a>
            </span>
            <span id="coverimageremove" style="display: none" class="disable-cover-image">
            <i class="fa fa-times" aria-hidden="true"></i>
            <div class="cros-tooltip">Remove cover</div>
            </span>
            </div>
            <div class="section" id="showfeaturedimage" style="display: none">
            <label for="file1" class="field file" id="filebgcolor"> <a id ="fep-featured-image-link" class="new-featured-image" href="#"><img class="featurimg-upld" src="<?php
echo esc_url(get_template_directory_uri()); ?>/images/img-upload-icon.svg"></a>
              <input class="gui-input pad-lft" id="uploader1" style="visibility:hidden;" readonly="" type="text" value="<?php
echo (!empty($filename)) ? $filename : ''; ?>">
              <input type="hidden" id="fep-featured-image-id" name="fep_featured_image_id" value="<?php
echo (!empty($featured_img)) ? $featured_img : ''; ?>"/>
            <!-- <span class="fa fa-upload upload-icon"></span> -->
            <input id="fepupload" name="fepupload" accept="image/*" style="display:none;" onchange="PreviewfeaturedImage(this.id,'<?php
echo site_url() ?>/wp-upload-featured.php');" type="file">
              <div class="deletefeaurued-icon">
                <i class="fa fa-trash deletefeauruedimg" aria-hidden="true"></i>
              </div>
            </label>
            </div>
         
            <div class="rtl-profile-form myprofile-form post-heading-top">
              <div class="group">
                <span class="rtl-numbe-list"><strong>1.</strong></span>
                <input type="text" name="post_title" class="posttitle chemarkisvalid" id="fep-post-title" value="<?php echo ($post) ? $post['title']:''; ?>" required>
                <i class="fa fa-check icon-green cover-icon-grn" style="display: none;" aria-hidden="true"></i>
                <i class="fa fa-close icon-red cover-icon-red" style="display: none;" aria-hidden="true"></i>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label class="rtl-profile-form-label headline">Headline</label>
              </div>
            </div>
      <!--       <hr> -->
            <br />
            <div class="section" id="editor-tool">
            <span class="numbe-list-text-aria"><strong>2.</strong></span>
            <textarea class="fep-post-content" name="post_content" id="fep-post-content" ><?php
echo ($post) ? $post['content'] : ''; ?></textarea>
            <?php

// $enable_media = (isset($fep_roles['enable_media']) && $fep_roles['enable_media'])?current_user_can($fep_roles['enable_media']):1;
// wp_editor( $post['content'], 'fep-post-content', $settings = array('textarea_name'=>'post_content', 'textarea_rows'=> 6,'media_buttons'=> true, 'quicktags' => array("buttons"=>false), 'drag_drop_upload' => true, 'tabindex' => 3, 'tinymce'=> true,) );
// wp_nonce_field('fepnonce_action','fepnonce');

?>
            </div>
            <?php /*************************************************/ ?>

            <div class="section">
                <label class="field select">
            <?php
$field = get_field_object($field_key);

if ($field)
  {
  echo '<select name="topic" id="fep-topic"  class="rtl-select chemarkisvalid" data-placeholder="Choose a Context...">';
  echo '<option value="">Choose a Context</option>';
  foreach($field['choices'] as $k => $v)
    {
    if ($k != "None")
      {
      if ($k == $topic_field || $v == $topic_field)
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
            <span class="rtl-numbe-list"><strong>3.</strong></span>
            <i class="arrow double"></i> </label>
            <input type="hidden" id="topic_field_key" value="<?php
echo $field_key; ?>" >
            <label id="fep-post-topic" class="error valid" generated="true" for="fep-post-topic" style="display:none;top:-21px"></label>
            </div>
               <!--  <div class="section">
                <label for="source_link" class="field prepend-icon">
                <input type="text" class="gui-input" name="source_link" placeholder="Source Link" id="fep-source-link" value="<?php
echo ($source_link) ? $source_link : ''; ?>">
                <input type="hidden" id="source_link_key" value="<?php
echo $field_key_source_link; ?>" >
                </label>
            </div> -->

          <!-- <div class="section">

              <label for="source_link" class="field prepend-icon source_link_container">
              <input type="text" class="gui-input" name="source_link" placeholder="Source Link" id="fep-source-link" value="<?php echo ($source_link) ? $source_link : ''; ?>">
               <span class="highlight"></span>
                    <span class="bar"></span>
               <label class="rtl-profile-form-label">Source Link</label>
               <div style="display: none;" class="ajax-loading" ></div> 
              
               <img style="display: none;" src=""  id="retina1"/>
            
              <input type="hidden" id="source_link_key" value="<?php echo $field_key_source_link; ?>" >
              </label>
              <button type="button" id="check-link" class="button btn-primary active-btn">Check Link</button></br>
          </div> -->

            <div class="section">
                <div class="rtl-profile-form myprofile-form post-heading-top">
                  <div class="group">      
                    <input type="text" name="source_link" class="posttitle chemarkisvalid" id="fep-source-link" value="<?php echo ($source_link) ? $source_link : ''; ?>" required>
                    <i class="fa fa-check icon-green cover-icon-grn" style="display: none;" aria-hidden="true"></i>
                    <i class="fa fa-close icon-red cover-icon-red" style="display: none;" aria-hidden="true"></i>
                    <div style="display: none;" class="ajax-loading" ></div> 
                    <input type="hidden" id="source_link_key" value="<?php echo $field_key_source_link; ?>" >
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label class="rtl-profile-form-label">Source Link</label>
                    <span class="rtl-numbe-list"><strong>4.</strong></span>
                    <img style="display: none;" src="" id="retina1" height="38px" width="80px"/>
            
                  </div>
                </div>
            </div>
          <!-- end section -->
            <div class="section">
                <label for="post_source" class="field prepend-icon">
              <?php
              $field_source = array();
              $field_source = get_field_object($field_key_source);

              if ($field_source)
                {
                $temp_field_source = $field_source['choices'];
                $autocomplete_json = array();
                $i = 0;
                foreach($temp_field_source as $value => $display)
                  {
                  array_push($autocomplete_json, array(
                    'id' => $i,
                    'value' => $value,
                    'name' => $display
                  ));
                  $i++;
                  }

                $autocomplete_json = json_encode($autocomplete_json);
                }

              ?>
            
         <!-- <div id="fep-source-container" class="myprofile-form">
              <div class="group">      
                <input type="text" name="post_source" id="fep-source" value='' required>
                <input type="hidden" name="old_post_source" id="old-fep-source" value='<?php
echo ($source_field) ? $source_field : ''; ?>'  >
                <input type="hidden" name="source_json" id="source_json" value='<?php
echo $autocomplete_json; ?>' >
                <span class="highlight"></span>
                <span class="bar"></span>
                <label style="font-size:14px">Choose a Source</label>
              </div>
            </div> -->
             <div id="fep-source-container" class="rtl-profile-form myprofile-form post-heading-top">
              <div class="group">
                <input type="hidden" name="fep-source_val" id="fep-source_val">
                <input type="text" name="post_source" id="fep-source" class="posttitle chemarkisvalid" value="<?php echo ($source_field) ? $source_field:''; ?>" required>
                <i class="fa fa-check icon-green cover-icon-grn" style="display: none;" aria-hidden="true"></i>
                <i class="fa fa-close icon-red cover-icon-red" style="display: none" aria-hidden="true"></i>
                 <input type="hidden" name="old_post_source" id="old-fep-source" value='<?php echo ($source_field) ? $source_field:''; ?>'  >
                 <input type="hidden" name="source_json" id="source_json" value='<?php echo $autocomplete_json; ?>' >
                <span class="highlight"></span>
                <span class="bar"></span>
                <!-- <label class="rtl-profile-form-label">Choose a Source</label> -->
              </div>
              <span class="rtl-numbe-list"><strong>5.</strong></span>
            </div>
              <input type="hidden" id="source_field_key" value="<?php
echo $field_key_source; ?>" >
            </label>
            </div>

            <div class="section">
                <input type="hidden" name="author_ide" id="author_ide" value="<?php echo get_current_user_id(); ?>">
                <?php /***************************************/ ?>
                <?php

if (!$fep_misc['disable_author_bio']): ?>
                <label for="fep-about">Author Bio</label>
                <br/>
                <textarea name="about_the_author" id="fep-about" rows="5"><?php
  echo ($post) ? $post['about_the_author'] : ''; ?></textarea>
                <br/>
                <?php
else: ?>
                <input type="hidden" name="about_the_author" id="fep-about" value="-1">
                <?php
endif; ?>
            </div>

            <div class="section">
              <label class="field select">
                  <select  id="fep-category"  class="rtl-select chemarkisvalid" name="post_category">
                    <?php
$args = array(
  'orderby' => 'name',
  'order' => 'ASC'
);
$categories = get_categories($args);
echo '<option value="">Choose a Category</option>';

foreach($categories as $key => $value)
  {
  if ($post['category'] == $value->term_id)
    {
    echo '<option selected="selected" value="' . $value->term_id . '">' . $value->name . '</option>';
    }
    else
    {
    echo '<option value="' . $value->term_id . '">' . $value->name . '</option>';
    }
  }

?>
                  </select>
                 <i class="arrow double"></i>
                 <span class="rtl-numbe-list"><strong>6.</strong></span>
              </label>
            </div>

          <div class="section">
            <label class="field select">
            <div id="fep-tag-container">
              <input class="chemarkisvalid" type="hidden" name="post_tags" id="fep-tags" value='<?php echo ($post) ? $post['tags']:''; ?>'  >
               <i class="fa fa-check icon-green cover-icon-grn" style="display:none;color:green"></i>
                <i class="fa fa-close icon-red cover-icon-red" style="display: none;color:red"></i>
              <input type="hidden" name="post_tags_graph" id="fep-tags_graph" value='<?php echo ($graph_value) ? $graph_value:''; ?>'  >
              <input type="hidden" name="old_post_tags" id="old-fep-tags" value='<?php echo ($post) ? $post['tags']:''; ?>'  >
            </div>
            <span class="rtl-numbe-list"><strong>7.</strong></span>
            </label>
          </div>
          
         <!--  <div class="section">
              <label for="source_link" class="field prepend-icon source_link_container">
              <input type="text" class="gui-input" name="source_link" placeholder="Source Link" id="fep-source-link" value="<?php
echo ($source_link) ? $source_link : ''; ?>">
               -->

          <!-- end section -->
        
          <div class="section">
             <span class="demo-checkbox-btn">
                <input  type="checkbox" name="embed_video" id="embed_video" value="" <?php

if ($video_source != '')
  {
  echo 'checked="checked"';
  } ?>/>

                <label for="embed_video"><span></span>Embed video </label>
              </span>
              <span class="video-filled <?php
echo $video_source != '' ? 'section_show' : 'section_hide'; ?>">
                  <label for="source_link" class="field prepend-icon">
                  <textarea placeholder="Text area" row="10" name="video_source" id="video_source" class="gui-textarea" ><?php
echo $video_source; ?></textarea>
                  </label>
                </span>  
            </div>
          </div>
        <!-- end .form-body section -->
        <div class="form-footer">
            <input type="hidden" name="post_id" id="fep-post-id" value="<?php
echo $post_id ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo get_current_user_id() ?>">
            <button type="button" id="fep-submit-post" disabled class="button btn-primary active-btn"><?php
echo $submit_button_value; ?></button>
            <img class="fep-loading-img" src="<?php
echo plugins_url('static/img/ajax-loading.gif', dirname(__FILE__)); ?>"/>
            <button type="button" class="button" onclick="location.href = '<?php
echo site_url() . "/myprofile/"; ?>';">Cancel</button>
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
  var el = document.getElementById('showfeaturedimage');
  var post_image= el.style.background;
  console.log(post_image, 'post_image');

  jQuery(document).ready(function(){

    jQuery('#fep-source-link').on("blur", function(){
          var submittedURL = $("#fep-source-link").val();
          var checksource = $('#fep-source').val();
          if (submittedURL !='' && checksource=='') {
           ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>"
          // var  ajaxURL = "https://www.fark.com/api/v1/submission_info/";
          // var encodedURL = encodeURIComponent(encodeURIComponent(submittedURL));
          // var fullUrl = ajaxURL + encodedURL + "?app_id=web";
          jQuery.ajax({
              type: "get",
              dataType: "json",
              url: myAjax.ajaxurl,
              data: {
                  action: "get_website_image",
                  source_link: submittedURL
              },
              beforeSend: function() {
                 jQuery('.ajax-loading').addClass('active');
                 $('#retina1').attr("src", "");
                 $('#fep-source').attr("value", "");
              },
              success: function(response) {
              if(response != false){
                console.log(response[0]," asas")
                $('#retina1').attr("src", response[0].sourceimg);
                $('#retina1').show();
                $('#fep-source').attr("value",response[1]);
                // $('#retina1').replaceWith(function(){
                //    return $('<img src="'+ response[0].sourceimg +'" id="retina1" height="38px" width="80px" />');
                // });
                // $('#token-input-fep-source').replaceWith(function(){
                //     return $('<input id="token-input-fep-source" type="text" value="' +response[0].sourcename +'" autocomplete="off" style="">');
                //   });
                   // if(response != false){

                   //       // var output = jQuery(response).filter("img").map(function() {return this.src}).get();
                   //     // console.log(output,'123');
                   //   //  testImage(output, record);
                   //    console.log(response);

                   //    record(response,'success');
                   //    jQuery('.ajax-loading').removeClass('active');  
                   // } 
                 }else{

                   $('#retina1').replaceWith(function(){
                   return $('<span id="retina1"> Invalid request</span>');
                });
                 }

              }
          });
        }else{
          return false;
        }
    });

          // Script for tick mark validations //



          $(".chemarkisvalid").on("blur", function(){
            if ($(this).val().length > 0){

                // $(this).next("i").hide();

                $(this).next().next().hide();
                $(this).next("i").show();
            }
            else{

                // $(this).next(".icon-green").hide();

                $(this).next("i").hide();
                $(this).next().next().show();
            }
           }); 

          $('#coverimagetoggeled').on('click', function(){
            $('#showfeaturedimage').slideDown("fast").delay(1);

            // $('#showfeaturedimage').effect('slide', { direction: 'up', mode: 'show' }, 500);

            $('#coverimagetoggeled').hide();

           // $('#mceu_18').css('top','-354px');
            // $('#coverimageremove').show()

          });
          $('#coverimageremove').on('click', function(){
            $('#showfeaturedimage').slideUp('fast').delay(1);
            $('#coverimagetoggeled').show();

           // / $('#mceu_18').css('top','-122px');

            $('#coverimageremove').css('display', 'none');
          });
            $('#showfeaturedimage, #coverimageremove, #uploader1, #filebgcolor, .featurimg-upld').on('mouseover', function(){
            $('#coverimageremove').css('display', 'block');
          });
            $('#filebgcolor').on('mouseout', function(){
            $('#coverimageremove').css('display', 'none');
          });



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