<?php
/*
Template Name: New Add Campaign
*/
?>
<?php get_header(); // add header  ?>
<?php if ( is_user_logged_in () ) {
	echo do_shortcode ( "[SignIn val='']" );
} else {
	echo do_shortcode ( "[SignIn val='" . $user_id_val . "']" );
}
$request_url = explode('/',$_SERVER['REQUEST_URI']);
if(isset($_GET['tx']) && $_GET['tx']!=""){
$get_url = "https://dashboard.retire.ly/user-campaign".$request_url[2]."#/addFunds";
}else{
$get_url = "https://dashboard.retire.ly/user-campaign".$request_url[2];
}
?>
<!-- Begin Content -->
<div class = "home-fullwidth" >
<span id="iframeloading"></span>
    <div class = "wrap-content" style = "margin-left: 12%;background-color: transparent;" > 
        <?php if(isset($_GET['id']) && $_GET['id'] != ''){
            //  $getId = $_GET['id'];
             // $getUrl ="http://192.168.1.115:3002/user-campaign?id=".$getId;die
            if(isset($_GET['amt']) && $_GET['amt']>0){
         ?>
       <object id="addCampaignIframe"  data="<?php echo $get_url;?>" style="width:83.5%;margin-left:2%;min-height:600px;margin-right:auto;visibility:hidden;">
    <embed src="<?php echo $get_url;?>" style="width:100%;height:100%;margin-left:auto;margin-right:auto;"> </embed>
         Error: Embedded data could not be displayed.
</object>
<?php }else{ ?>
       <object id="addCampaignIframe"  data="<?php echo $get_url;?>" style="width:83.5%;margin-left:2%;min-height:600px;margin-right:auto;">
    <embed src="<?php echo $get_url;?>" style="width:100%;height:100%;margin-left:auto;margin-right:auto;"> </embed>
         Error: Embedded data could not be displayed.
</object>
<?php }}else if(isset($_GET['tx']) && $_GET['tx'] != '' && is_user_logged_in ()){
        global $wpdb;
        global $current_user;
        get_currentuserinfo();
        $userEmail = $current_user->user_email;
    if($userEmail!=""){
        $querystr = "select * from advisors where email='".$userEmail."'";
        $getadvisor = $wpdb->get_results($querystr, OBJECT);
        $advisorId = $getadvisor[0]->advisorid;
        if(isset($_GET['amt']) && $_GET['amt']>0){
            echo "<script>window.location.href='".get_site_url().'/campaign?tx='.$_GET['tx']."&amt=".$_GET['amt']."&id=".$advisorId."'</script>";
        }else{
            echo "<script>window.location.href='".get_site_url().'/campaign?tx='.$_GET['tx']."&id=".$advisorId."'</script>";
        }
    }
    } ?>
    <!-- Begin Sidebar (right) -->
    <?php // get_sidebar(); // add sidebar ?>
    <!-- end #sidebar  (right) --> 
</div>
    <div class="clear"></div>
</div><!-- end .wrap-fullwidth -->
<?php get_footer(); // add footer  ?>
<script type="text/javascript">
/*addCampaignIframe is used to show the iframe loading message*/
function addCampaignIframe() {
    jQuery('#iframeloading').show();
}
jQuery('#addCampaignIframe').load(addCampaignIframe());
/*below code is used to hide the loading message*/
jQuery(window).load(function() {
    jQuery('#iframeloading').hide();
});
</script>
