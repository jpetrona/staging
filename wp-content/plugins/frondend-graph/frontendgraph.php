<?php
/**
* Plugin Name: Frond end graph. 
* Plugin URI: 
* Description: Frond end graph.
* Version: 1.0
* Author: Linkites
**/
include('frontendform.php');
include('process.php');
// create table on plugin activation.
function plugin_installed() {
    global $wpdb;
    global $your_db_name;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $sql="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."frondendgraph`(
             `id` int(11) NOT NULL AUTO_INCREMENT,
                      `title` varchar(200) NOT NULL,
                      `image` varchar(200) NOT NULL,
                      `category` varchar(100) NOT NULL,
                      `context` varchar(100) NOT NULL,
                      `instrument` varchar(100) NOT NULL,
                      `stockprice` varchar(100) NOT NULL,
                      `status` int(11) NOT NULL,
                      PRIMARY KEY (`id`)
         );";
    dbDelta($sql);
}
// run the install scripts upon plugin activation
register_activation_hook(__FILE__,'plugin_installed');
add_action('admin_menu','frondendgraph_menu');
function frondendgraph_menu() {
    add_menu_page(__('Front end graph','frondend-graph'),__('Front end graph','frondend-graph'),'manage_options','frondend-handle','frondend_admin_page');
}
add_action( 'admin_post_jk_save_youtube_option', 'process_jk_youtube_options' );
add_action('admin_menu', 'register_my_custom_submenu_page');
function register_my_custom_submenu_page() {
  add_submenu_page( 'frondend-handle', 'Published graph', 'My Custom Submenu Page', 'manage_options', 'my-custom-submenu-page', 'my_custom_submenu_page_callback' );
}
function my_custom_submenu_page_callback() {
  global $wpdb;
  $frondendgraph_table = $wpdb->prefix."frondendgraph";
  if(isset($_GET['search']) && $_GET['search'] != ''){
    $s = $_GET['search'];
    $querystr ="SELECT a1_frondendgraph.*, a1_terms.* FROM a1_frondendgraph INNER JOIN a1_terms ON a1_frondendgraph.category=a1_terms.term_id where a1_frondendgraph.status IN (0,1) and (stockprice LIKE '%$s%' or a1_terms.name LIKE '%$s%' or context LIKE '%$s%' or instrument LIKE '%$s%' or title LIKE '%$s%')order by id Desc"; 
  }else{
    $querystr = "select * from ".$frondendgraph_table." where status IN (0,1) order by id Desc";
  }
  $allrecords = $wpdb->get_results($querystr, OBJECT);
  echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
  echo '<h2>Published Graph Page </h2>';
  if(isset($_REQUEST['response']) && $_REQUEST['response'] == 1){ ?>
  <div class="updated below-h2" id="message">
      <p>Post has been Saved successfully</p>
  </div>
  <?php } elseif(isset($_REQUEST['response']) && $_REQUEST['response'] == 0) { ?>
  <div class="error below-h2" id="message">
      <p>Error found in submitting post</p>
  </div>
  <?php } else {?>
  <?php }
  echo '</div>';
  $i = 1;
  //if(isset($allrecords) && count($allrecords) > 0) {
	  echo '<div class="wrap">';
    echo '<a class="btn btn-default" href="'.get_site_url().'/wp-admin/admin.php?page=frondend-handle&market=nasdaq" title="National Association of Securities Dealers Automated Quotations">NASDAQ</a> &nbsp;&nbsp;&nbsp;';
    echo '<a class="btn btn-default" href="'.get_site_url().'/wp-admin/admin.php?page=frondend-handle&market=nyse" title="New York Stock Exchange">NYSE</a> &nbsp;&nbsp;&nbsp;';
    echo '<a class="btn btn-default" href="'.get_site_url().'/wp-admin/admin.php?page=frondend-handle&market=tsx" title="Toronto Stock Exchange">TSX</a> &nbsp;&nbsp;&nbsp;';
    echo '<a class="btn btn-default" href="'.get_site_url().'/wp-admin/admin.php?page=frondend-handle&market=amex" title="American Stock Exchange">AMEX</a> &nbsp;&nbsp;&nbsp;';
    echo '<a class="btn btn-default" href="'.get_site_url().'/wp-admin/admin.php?page=my-custom-submenu-page">Published</a> &nbsp;&nbsp;&nbsp;';
    echo "<p class='search-box'>";
    echo "<label for='post-search-input' class='screen-reader-text'>Search Posts:</label>";
    echo "<input type='search' value='$s' name='s' placeholder='Search by name,category ...' id='post-search-input'>";
    echo "<input type='submit' value='Search Posts' onclick='searchPost()' class='button graph-search' id='search-submit'></p>";
    echo "</div>";
    echo '<table class="front-graph" id="front-graph">';
    echo '<thead>';
    echo '<tr>';
    echo '<td>Edit</td>';
    echo '<td>Title</td>';
    echo '<td>Content</td>';
    echo '<td>Category</td>';
    echo '<td>Context</td>';
    //echo '<td>Stock name</td>';
    echo '<td>Instrument</td>';
    echo '<td>Publish</td>';
    echo '<td>Delete</td>';
    echo '<td>Image</td>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    if(isset($allrecords) && count($allrecords) > 0) {
    foreach ($allrecords as $key => $record) {
      echo '<tr>';
      echo "<td><span title='Edit' class='edit-graph'  onclick='editgraph(".$record->id.")'>Edit</span></td>";
      echo '<td id="title-'.$record->id.'">'.$record->title.'</td>';
      echo '<input type="hidden" id="content-'.$record->id.'" value="'.stripslashes(htmlentities($record->content)).'" />';
      echo '<td>'.substr(stripslashes(htmlentities($record->content)),0,150).'</td>';
      echo '<td>'.get_cat_name( $record->category ).'</td>';
      echo '<td>'.$record->context.'</td>';
      echo '<td>'.$record->stockprice.'</td>';
      if($record->status == 0){
       echo '<td><input type="button" class="cnfm-btnn button" name="submitpublish" value="Publish" onclick="updateStatus('.$record->id.',1)"/></td>';
       echo '<td></td>';
      } else {
       echo '<td>Yes</td>';
       echo '<td><input type="button" class="cnfm-btnn button" name="submitdelete" value="Delete" onclick="updateStatus('.$record->id.',0)"/></td>';
      }
      echo '<td><span class="published_thumb">'.wp_get_attachment_image( $record->image).'</span></td>';
      echo '</tr>';
      $i++;
    }
  }else{
     echo '<tr>'; echo '<td>No result found</td>'; echo '</tr>';
  }
    echo '</tbody>';
    echo '</table>';
    echo "<div class='modal fade' id='myModal' role='dialog'>
          <div class='modal-dialog'>
           <div class='modal-content'>
              <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <h4 class='modal-title'>Edit</h4>
              </div>
              <div class='modal-body'>
                <div class='alert' style='display:none;'>
                </div>
                 <div class='form-group'>
                        <label for='usr'>Title:</label>
                        <input type='text'  class='form-control' required name='posttitle' id='posttitle'>
                    </div>
                    <div class='form-group'>
                        <label for='comment'>Content:</label>
                        <textarea class='form-control'   rows='8' required name='content' id='content' ></textarea>
                    </div>
                    <div class='form-group'>
                        <input type='hidden' class='post_id' id='post_id'>
                        <input type='hidden' name='action'  value='edit'>
                        <input type='submit' name='importRssData'  value= 'Submit' onclick='updatePost()' class='btn btn-default'>
                    </div>
                </div>
            </div>
          </div>
        </div>";
 // }
?>
<script type="text/javascript">
  function searchPost(){
    var search = jQuery('#post-search-input').val();
    if(search != undefined && search != ''){
      window.location = "<?php echo get_site_url();?>/wp-admin/admin.php?page=my-custom-submenu-page&search="+search;
    }
  }
  function editgraph(id){
    jQuery('#posttitle').val(jQuery('#title-'+id).text());
    jQuery('#content').val(jQuery('#content-'+id).val());
    jQuery('#post_id').val(id);
    jQuery('#myModal').modal('show');
  }
  function updatePost(){
    var posttitle = jQuery('#posttitle').val();
    var content = jQuery('#content').val();
    var id = jQuery('#post_id').val();
    if(posttitle == '' ){
       jQuery('#posttitle').addClass('frontenderror');
       return false;
    }else if(content == ''){
        jQuery('#content').addClass('frontenderror');
        return false;
    }else{

    }
    jQuery.ajax({
    url : "<?php echo get_site_url().'/stock-graph/';?>",
    type : 'get',
    data : {
      post_id : id,
      posttitle : posttitle,
      action : 'edit',
      content: content
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
  function updateStatus(id, status){
    jQuery.ajax({
    url : "<?php echo get_site_url();?>/stock-graph/?dt="+new Date(),
    type : 'post',
    data : {
      post_id : id,
      status: status
    },
    success : function( response ) {
      if(response=='success'){
          window.location = "<?php echo get_site_url();?>/wp-admin/admin.php?page=my-custom-submenu-page&response=1";
      }else{
          window.location = "<?php echo get_site_url();?>/wp-admin/admin.php?page=my-custom-submenu-page&response=0";
      }
    }
    });
   }
</script>
<?php } ?>
