<?php
/*
Template Name: Stock Graph Post Status Template 
*/
global $wpdb, $user_ID;

if(isset($_REQUEST["post_id"]) && isset($_REQUEST["action"]) && $_REQUEST["action"] == 'edit' && isset($_REQUEST["content"]) && isset($_REQUEST["posttitle"]) ){
	$pid = $_REQUEST["post_id"];
	$posttitle  = $_REQUEST["posttitle"];
    $content  = $_REQUEST["content"];
	$frondendgraph_table = $wpdb->prefix."frondendgraph";
	$sql = "UPDATE ".$frondendgraph_table." SET title = '".$posttitle."',content = '".$content."'  where id = ".$pid.";";
	$res = $wpdb->query($sql);
	if($res > 0 || $res == 0){
		echo 'success';
	} else{
	    echo 'error';
	}
	exit;
}
if(isset($_REQUEST["post_id"]) && isset($_REQUEST["status"])){
	$pid = $_REQUEST["post_id"];
	$status  = $_REQUEST["status"];
	$frondendgraph_table = $wpdb->prefix."frondendgraph";
	$sql = "UPDATE ".$frondendgraph_table." SET status = ".$status." where id = ".$pid.";";
	$res = $wpdb->query($sql);
	if($res){
		echo 'success';
	} else{
	    echo 'error';
	}
	exit;
}
if(isset($_REQUEST["title"]) && isset($_REQUEST["image"]) && isset($_REQUEST["category"]) && isset($_REQUEST["topic"]) && isset($_REQUEST["stockname"]) && isset($_REQUEST["percentage"]) && isset($_REQUEST["content"]) ){
	$post_title = $_REQUEST["title"];
	$image_id  = $_REQUEST["image"];
	$embed_video  = $_REQUEST["embed_video"];
	$post_tags = $_REQUEST["symbol"];
	$post_category  = $_REQUEST["category"];
	$post_topic = $_REQUEST["topic"];
	$stockname = $_REQUEST["stockname"];
	$percentage  = $_REQUEST["percentage"];
	$content = stripslashes($_REQUEST["content"]);
	$status = 1;
	$user_ID = get_current_user_id();
	$time = date('Y-m-d g:i:s'); 
	$post_tags_graph = $stockname."<br><strong class='percentagegreen'>Stock price:</strong>".$percentage;	
	$frondendgraph_table = $wpdb->prefix."frondendgraph";

	$stockprice  = $_REQUEST["stockprice"];
	$expertname = $_REQUEST["expertname"];
	$expertcomment = $_REQUEST["expertcomment"];
	$expertimage  = $_REQUEST["expertimage"];
    $source = $_REQUEST["source"];
	$sourcelink  = $_REQUEST["sourcelink"];

	$result = $wpdb->query($wpdb->prepare("INSERT INTO ".$frondendgraph_table." (title,image,embed_video,category,content,post_date,post_author,context,instrument,stockprice,stockpostedprice,expertname,expertcomment,expertimage,source,sourcelink,status) 
		VALUES ( %s,%d,%s,%s,%s,%s,%d,%s,%s,%s,%f,%s,%s,%d,%s,%s,%d)",array($post_title,$image_id,$embed_video,$post_category,$content,$time,$user_ID,$post_topic, $post_tags,$post_tags_graph,$stockprice,$expertname,$expertcomment,$expertimage,$source,$sourcelink,$status)));
 //       if(false === $result){
   //      echo 'error';   
//	}else{
       echo 'success';
//	}	
	exit;
}?>
