<?php
function process_jk_youtube_options(){
// Check that nonce field
  check_admin_referer( 'jk_op_verify' );
  $options = get_option( 'jk_op_array' );
  $post_title = sanitize_text_field( $_POST['post_title'] ); 
  $post_category = sanitize_text_field( $_POST['post_category'] );
  $post_topic = sanitize_text_field( $_POST['post_topic'] );
  $fep_featured_image_id = sanitize_text_field( $_POST['fep_featured_image_id'] );
  $post_tags = $_POST['post_tags'] ;
  $post_tags_graph = $_POST['stockname'] ;
  $status = sanitize_text_field( $_POST['status'] );
  $post_id = $_POST['post_id'] ;
  $result = explode("|",$post_tags_graph);
  $stockprice = $result[0].'<br/><strong>Stock price:</strong>'.'<span class="green">'.$result[1].'</span>';
  
  global $wpdb; 
  $frondendgraph_table = $wpdb->prefix."frondendgraph"; 
  if($post_id != '' && $post_id > 0 ){
      $result = $wpdb->query( 
        $wpdb->prepare("UPDATE ".$frondendgraph_table." SET title =%s, image = %s, category = %s, 
          context = %s , instrument = %s ,stockprice = %s , status = %d WHERE id = %d  ", 
          $post_title, $fep_featured_image_id,$post_category, $post_topic,$post_tags, $stockprice,$status,$post_id )
        );
  }
  /*else{
      $result = $wpdb->query( $wpdb->prepare("INSERT INTO ".$frondendgraph_table." (title,image,category,context,instrument,stockprice,status)
      VALUES ( %s,%d,%s,%s,%s,%s,%d)",array($post_title,$fep_featured_image_id,$post_category,$post_topic, $post_tags,$post_tags_graph, $status)));
  }*/
  if($result){
       wp_redirect(  admin_url( 'admin.php?page=frondend-handle&response=1' ) );
   } else{
       wp_redirect(  admin_url( 'admin.php?page=frondend-handle&response=0' ) );
   } 
   exit;
}
?>
