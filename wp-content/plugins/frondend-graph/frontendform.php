<?php
function frondend_admin_page()
{
  $flag = false;
  $options = get_option( 'jk_op_array' );
  $field_key = "field_551ce1fde54f2"; // For topic
  $field = get_field_object($field_key);
  global $wpdb;
  $frondendgraph_table = $wpdb->prefix."frondendgraph"; 
  $querystr = "select * from  ".$frondendgraph_table." where status IN (0,1)";
  $allrecords = $wpdb->get_results($querystr, OBJECT);
  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['id']) && $_REQUEST['id'] != 'edit' ){
      $formheading = 'Edit';
      $editquery = "select * from  ".$frondendgraph_table." where id=".$_REQUEST['id'];
      $editrecord = $wpdb->get_results($editquery, OBJECT);
      $flag = true;
  } else {
      $flag = false;
  }
function allCategories($j){
  $args = array('orderby' => 'name','order' => 'ASC');
  $categories = get_categories($args);
  $html = '';
  $html .=  '<select name="post_topic" class="fep_category"   id="fep_category-'.$j.'" data-placeholder="Choose a Context..." required> ';
  $html .= '<option value="">Choose a Category</option>';
  foreach(  $categories as $key => $value ){
    $html .= '<option value="' . $value->term_id . '">' . $value->name . '</option>';
  }
  $html .=  '</select>';
  return $html;
}
function allContext($j){
 $field_key = "field_551ce1fde54f2"; // For topic
 $field = get_field_object($field_key);
 $html = '';
 $html .=  '<select name="post_topic" id="fep_topic-'.$j.'" class="fep_topic"  data-placeholder="Choose a Context..." required> ';
 $html .= '<option value="">Choose a Context</option>';
 foreach( $field['choices'] as $k => $v ){
  $html .= '<option value="' . $k . '">' . $v . '</option>';
 }
 $html .=  '</select>';
 return $html;
}
function allSource($j){
 $field_key_source = "field_559cca7f8518f"; // For Source
 $field_source = get_field_object($field_key_source);
 $html = '';
 $html .=  '<select name="post_source" id="post_source-'.$j.'" class="post_source"  data-placeholder="Choose a Source..." required> ';
 $html .= '<option value="">Choose a Source</option>';
 if( $field_source )
  {
    $temp_field_source = $field_source['choices'];
    $autocomplete_json = array();
    foreach( $field_source['choices'] as $value => $display ) {
      $html .= '<option value="' . $display . '">' . $display . '</option>';
    }
  }
  $html .=  '</select>';
  return $html;
}
?>
<div class="wrap">
  <h2>Frond end graph</h2>
  <?php if(isset($_REQUEST['market']) && $_REQUEST['market'] == 'nyse'){
      $url = get_site_url().'/top-gainer-nyse/';
  }elseif (isset($_REQUEST['market']) && $_REQUEST['market'] == 'amex') { 
      $url = get_site_url().'/top-gainer-amex/';
  }elseif (isset($_REQUEST['market']) && $_REQUEST['market'] == 'tsx') { 
      $url = get_site_url().'/top-gainer-tsx/';
  }elseif (isset($_REQUEST['market']) && $_REQUEST['market'] == 'nasdaq') { 
      $url = get_site_url().'/top-gainer/';
  }else{ 
      $url = get_site_url().'/top-gainer/';
  } ?>
  <?php if(isset($_REQUEST['response']) && $_REQUEST['response'] == 1){ ?>
  <div class="updated below-h2" id="message">
      <p>Post has been saved</p>
  </div>
  <?php } elseif(isset($_REQUEST['response']) && $_REQUEST['response'] == 0) { ?>
  <div class="error below-h2" id="message">
      <p>Error found in submitting post</p>
  </div>
  <?php } else {?>
  <?php } ?>
</div>
<?php
$i = 1;
//if(isset($allrecords) && count($allrecords) > 0) {
  echo '<a class="btn btn-default" href="'.get_site_url().'/wp-admin/admin.php?page=frondend-handle&market=nasdaq" title="National Association of Securities Dealers Automated Quotations" >NASDAQ</a> &nbsp;&nbsp;&nbsp;';
  echo '<a class="btn btn-default" href="'.get_site_url().'/wp-admin/admin.php?page=frondend-handle&market=nyse" title="New York Stock Exchange" >NYSE</a> &nbsp;&nbsp;&nbsp;';
  echo '<a class="btn btn-default" href="'.get_site_url().'/wp-admin/admin.php?page=frondend-handle&market=tsx" title="Toronto Stock Exchange">TSX</a> &nbsp;&nbsp;&nbsp;';
  echo '<a class="btn btn-default" href="'.get_site_url().'/wp-admin/admin.php?page=frondend-handle&market=amex" title="American Stock Exchange">AMEX</a> &nbsp;&nbsp;&nbsp;';
  echo '<a class="btn btn-default" href="'.get_site_url().'/wp-admin/admin.php?page=my-custom-submenu-page">Published</a> &nbsp;&nbsp;&nbsp;';	
  echo '<div class="loader" id="my_loader"></div>';
  echo '<table class="front-graph front-graph-gainer " id="front-graph">';
  echo '<thead>';
  echo '<tr>';
 // echo '<td></td>';
  //echo '<td>Symbol</td>';
  echo '<td>Name</td>';
  echo '<td>Percentage</td>';
  echo '<td>Title</td>';
  echo '<td>Content</td>';
  echo '<td>Category</td>';
  echo '<td>Detail Context</td>';
  echo '<td>Source</td>';
  echo '<td>Source link</td>';
  echo '<td>Image</td>';
  echo '<td>Embed video</td>';
  echo '<td>Expert name</td>';
  echo '<td>Comment</td>';
  echo '<td>Expert image</td>';
  echo '<td>Publish</td>';
  echo '</tr>';
  echo '</thead>';
  $j=1;
  echo '<tbody>';
  for ($x = 1; $x <= 10; $x++) {
    echo '<tr>';
    //echo '<td>'.$i.'</td>';
    echo '<input type="hidden" id="symbol-'.$j.'"/>';
    echo '<input type="hidden" id="stockprice-'.$j.'"/>';
    echo '<td id="name-'.$j.'"></td>';
    echo '<td id="percentage-'.$j.'" class="percentage-green"></td>';
    echo '<td><input type="text" id="title-'.$j.'" name="title" class="title-input"></td>';
    echo '<td><textarea  id="content-'.$j.'" rows="4" cols="50" name="content" class="text-content"></textarea></td>';
    echo '<td>'.allCategories($j).'</td>';
    echo '<td>'.allContext($j).'</td>';
    echo '<td>'.allSource($j).'</td>';
    echo '<td><input type="text" id="source-link-'.$j.'" name="source-link" class="source-link"></td>';
    echo '<td class="upload_image_last" ><button class="fep-featured-image-link button" id="button-'.$j.'"> <span class="dashicons dashicons-upload"></span> </button>';
    echo '<input type="hidden" id="featured-image-button-'.$j.'"  name="fep_featured_image_id" value="" />';
    echo '<span class="postimg" id="postimage-button-'.$j.'" ></span>';
    echo '</td>';
    echo '<td><textarea placeholder="Video embed script from youtube and twitter" id="embed-video-'.$j.'" rows="4" cols="50" name="embed-video" class="text-content"></textarea></td>';
    echo '<td><input type="text" id="expert-name-'.$j.'" name="expert-name" class="title-input expert-name"></td>';
    echo '<td><textarea  id="expert-comment-'.$j.'" rows="4" cols="50" name="expert-comment" class="text-content expert-comment"></textarea></td>';
    echo '<td class="upload_image_last" ><button class="expert-button-image-link button" id="expert-button-'.$j.'"> <span class="dashicons dashicons-upload"></span> </button>';
    echo '<input type="hidden" id="expert-image-button-'.$j.'"  name="expert_image_id" value="" />';
    echo '<span class="expertimg" id="expertimage-button-'.$j.'" ></span>';
    echo '</td>';
    echo '<td><input type="button" class="button cnfm-btnn" name="submitpublish" value="Publish" id="publish-'.$j.'"  onclick="addPost('.$j.')"/></td>';
    echo '</tr>';
    $i++;
    $j++;
  }
   echo '</tbody>';
   echo '</table>';
//}
?>
<script type="text/javascript">
jQuery(".title-input").blur(function(){
    if(jQuery(this).val != ''){
      jQuery(this).removeClass('frontenderror');
    }
});
jQuery(".fep_category").change(function(){
    if(jQuery(this).val != ''){
      jQuery(this).removeClass('frontenderror');
    }
});
jQuery(".fep_topic").change(function(){
    if(jQuery(this).val != ''){
      jQuery(this).removeClass('frontenderror');
    }
});
function addPost(id){
  var symbol = jQuery('#symbol-'+id).text();
  var name = jQuery('#name-'+id).text();
  var percentage = jQuery('#percentage-'+id).text();
  var title = jQuery('#title-'+id).val();
  var category = jQuery('#fep_category-'+id).val();
  var topic = jQuery('#fep_topic-'+id).val();
  var image = jQuery('#featured-image-button-'+id).val();
  var embed_video = jQuery('#embed-video-'+id).val();
  var content = jQuery('#content-'+id).val();
  var stockprice = jQuery('#stockprice-'+id).val();
  var expertname = jQuery('#expert-name-'+id).val();
  var expertcomment = jQuery('#expert-comment-'+id).val();
  var expertimage = jQuery('#expert-image-button-'+id).val();
  var source = jQuery('#post_source-'+id).val();
  var sourcelink = jQuery('#source-link-'+id).val();
  if(title == '' ){
     jQuery('#title-'+id).addClass('frontenderror');
     return false;
  }else if(category == ''){
      jQuery('#fep_category-'+id).addClass('frontenderror');
      return false;
  }else if(topic == ''){
       jQuery('#fep_topic-'+id).addClass('frontenderror');
       return false;
  }else if(image == '' && embed_video == ''){
       jQuery('#button-'+id).addClass('frontenderror');
       return false;
  }
  else if(content == ''){
      jQuery('#content-'+id).addClass('frontenderror');
      return false;
  }else if(source == ''){
      jQuery('#post_source-'+id).addClass('frontenderror');
      return false;
  }else{

  }
  jQuery('#publish-'+id).attr('disabled', true); 
  jQuery.ajax({
	//url : "<?php echo get_site_url();?>/stock-graph/?dt="+new Date(),
  url : "<?php echo get_site_url();?>/stock-graph/",
	type : 'get',
	data : {
		symbol : symbol,
    stockname: name,
    percentage:percentage,
    title:title,
    category:category,
    topic:topic,
    image:image,
    embed_video: embed_video,
    content:content,
    stockprice:stockprice,
    expertname:expertname,
    expertcomment:expertcomment,
    expertimage:expertimage,
    source:source,
    sourcelink:sourcelink
	},
	success : function( response ) {
	  if(response=='success'){
        window.location = "<?php echo get_site_url();?>/wp-admin/admin.php?page=my-custom-submenu-page&response=1";
    }else{
        window.location = "<?php echo get_site_url();?>/wp-admin/admin.php?page=my-custom-submenu-page&response=1";
    }
  }
});
}
jQuery.ajax({
        url: "<?php echo $url;?>",
        type: "GET",
        crossDomain : true,
        success: function (datahtml) {
            var i = 1;
            var flag = true;
            jQuery(datahtml).find("#yfitp tr").each(function(){
                var shortname = jQuery(this).find('td:eq(0)').text();
                var fullname = jQuery(this).find('td:eq(1)').text();
                var stocklastprice = jQuery(this).find('td:eq(2)').find('b').text();
                var percentage = jQuery(this).find('td:eq(3)').text();
                if(shortname != '' && shortname !='' && flag){
                  jQuery("#symbol-"+i).text(shortname);
                  jQuery("#stockprice-"+i).val(stocklastprice);
                  jQuery("#name-"+i).text(fullname+'('+shortname+')');
                  jQuery("#percentage-"+i).html('<span class="dashicons dashicons-arrow-up-alt green-arrow"></span>'+percentage);
                  jQuery("#post_tags").append('<option value="'+shortname+'">'+fullname+'|'+percentage+'</option>');
                  jQuery('#post_tags').prop("disabled", false);
                  jQuery('.loading').hide();
                  i++;
                  if(i == 11){ flag = false;}
                }
            })
        },
        error: function (xhr, status) {
            //alert("Sorry, there was a problem!");
        },
        beforeSend: function( xhr ) {
            //jQuery("body").addClass('loader');
        },
        complete: function (xhr, status) {
           jQuery('#my_loader').removeClass('loader');
        }
    });
</script>
<?php } ?>
