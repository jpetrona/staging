<?php
/**
* Plugin Name: Rss feed 
* Plugin URI: 
* Description: Post publish
* Version: 1.0
* Author: Linkites
**/
add_action('admin_menu','my_admin_menu');
function my_admin_menu() {
    add_menu_page(__('Rss feed','rss-feed'),__('Rss feed','rss-feed'),'manage_options','rss-top-handle','rssfeed_admin_page');
}
function rssfeed_admin_page(){
    ?>
    <div class="wrap">
        <h2>RSS feed</h2>
    </div>
    <?php 
    $redirectflag = false;
    if(isset($_POST['importRssData'])){
        $title = $_POST['posttitle'];
        $content = $_POST['content'];
        $upload_image = $_REQUEST['upload_image'];
        $topic = $_REQUEST['topic'];
        $source = $_REQUEST['source'];
        $result = addfeedpost($title, $content, $upload_image, $topic, $source);
        if(isset($result) && $result == 1){
            wp_redirect(admin_url('admin.php?page=rss-top-handle'.'&response='.$result, 'http'), 301);
        }
    }
    if (isset($_REQUEST['response']) && $_REQUEST['response'] == 1) {
       if(isset($_REQUEST['addrss']) && $_REQUEST['addrss'] == 1) {
            echo '<div class="updated below-h2" id="message"><p>Your feed has been added successfully!.</p></div>';
       } else {
        $postgridurl = get_admin_url().'edit.php'; 
        echo '<div class="updated below-h2" id="message"><p>Your post has been posted successfully!. <a href='.$postgridurl.'>View All</a></p></div>';
       }
    }
    if(isset($_REQUEST['response']) && $_REQUEST['response'] == 0){
        echo '<div class="deleted below-h2 error"><p>Your submission has errors. Please try again!.</p></div>';
    }
    global $wpdb;
    $feed_table = $wpdb->prefix."rssfeed";
    $allRawFeed = $wpdb->get_results( "SELECT * FROM ".$feed_table);
    ?>
    <div id='response_div'></div>
    <label for="cat" class="cat">Select feed:- </label>
    <select class="selectedfeed" id="selectedfeed" name="selectedfeed">
        <option value="">Select feed</option>
            <?php 
            foreach($allRawFeed as $row){
                $flag = ''; ?>
               <option value="<?php echo $row->rssfeedurl; ?>" <?php if( $row->rssfeedurl == $_REQUEST['selectedfeed'] ) echo 'selected="selected"'; ?> ><?php echo $row->rssfeedname; ?></option>
            <?php }
            ?>
    </select>
    <?php if(isset($_REQUEST['selectedfeed'])) {?>
    <form action="" onsubmit="return checkRss()" id="feedForm" method="POST">
        <div class="alignleft actions">
            <span class="error" id="error_feed"></span>
            <?php if(isset($_REQUEST['selectedfeed'])) {?>
                <div id="rssoperation"> 
                    <input type="hidden" name="importRssData" id="importRssData" value="">
                    <input type="hidden" name="rssFeedContext" id="rssFeedContext" value="">
                    <input type="hidden" name="rssFeedSource" id="rssFeedSource" value="">
                </div>
            <?php } ?>
       </div>
     </form>   
       <?php if(isset($_REQUEST['selectedfeed'])) {?>
      <!-- <input type='submit' value='Import' class='button' id='postquerysubmit' name='filteraction'>-->
        <?php } ?>
        <?php
        if(isset($_REQUEST['selectedfeed'])){
            add_action('admin_print_scripts', 'my_admin_scripts');
            add_action('admin_print_styles', 'my_admin_styles');
            $url = $_REQUEST['selectedfeed'];
            $xml = @simplexml_load_file($url);
            $newsContent = array();
            if(is_object($xml)){
                foreach($xml->channel->item as $news){
                    $description = $news->description;
                    $d['title'] =$news->title;
                    $d['link'] = $news->link;
                    if(isset($news->children('media', true)->group->content)) {
                        $md = $news->children('media', true)->group->content->attributes();
                        $d['media'] =$md->url;
                    }
                    else if(isset($news->children('media', true)->content)) {
                        $md = $news->children('media', true)->content->attributes();
                        $d['media'] = $md->url;
                    }
                    $d['cont'] = $news->description;
                    $d['date'] = $news->pubDate;
                    $newsContent[]=$d;
                }
            }
            if(is_array($newsContent)){
                echo '<table id="feedtable" cellpadding="5" cellspacing="0" style="background-color:white;">';
                echo "<tr><th></th><th>Feed Image</th><th>Feed Content</th><th>Feed Date</th></tr>";
                if(count($newsContent)>0){
                    foreach($newsContent as $key2 => $post){
                        $postArray = array();
                        $image= isset($post["media"]) ? $post["media"] : "";
                        $link = isset($post['link']) ? $post['link'] : ""  ;
                        $content = isset($post['cont']) ? $post['cont']: "";
                        $contentshow = truncate(stripslashes(strip_tags(str_replace("\r\n","",str_replace("'","",$content)))),250);
                        $contentHover =  truncate(stripslashes(strip_tags(str_replace("\r\n","",str_replace("'","",$content)))),300);
                        $title = isset($post['title']) ? $post['title'] : "";
                        $publishDate = isset($post['date']) ? $post['date'] : "";
                        $postArray['title'] = stripslashes(strip_tags(str_replace("\r\n","",str_replace("'","", $title ))));
                        $postArray['content'] = stripslashes(strip_tags(str_replace("\r\n","",str_replace("'","",$content))));
                        $postArray['image'] = stripslashes($image);
                        $postArray['link'] = stripslashes($link);
                        $image = (isset($image) && $image != '') ? $image : wp_get_attachment_url( 3363 );
                       $hoverContent = "<div class='inside-modal'><img src=".$image." style='height:200px;width:242px;padding-bottom: 10px;'><div>".$contentshow."</div></div>";
                            echo '<tr valign="top">';
                            echo "<td><span title='Edit' itemJson='".json_encode($postArray)."' id='feed-".$key2."' data-toggle='modal' href='javascript:void(0)' class='commonpopup dashicons dashicons-edit'></span></td>";
                            echo '<td><img id="img-'.$key2.'" style="height:125px;width:210px;padding-bottom: 10px;" src="'.$image.'"></td>';
                            echo '<td><a class="css-tooltip-right color-orange" id="title-'.$key2.'" target="_blank" href="'.$link.'">'.stripslashes($title).'<span>'.$hoverContent.'</span></a><br />';
                            echo '<span id="content-'.$key2.'">'.$contentHover.'</span></td>';
                            echo '<td>'.$publishDate.'</td>';
                            echo '</tr>'; 
                    }  
                }else{
                    echo '<tr><td></td><td>Sorry unable to process url.</td></tr>';  
                }
                 echo '</table>';
            }
            echo "<div class='modal fade' id='myModal' role='dialog'>
                    <div class='modal-dialog'>
                     <div class='modal-content'>
                        <div class='modal-header'>
                          <button type='button' class='close' data-dismiss='modal'>&times;</button>
                          <h4 class='modal-title'>Edit feed</h4>
                        </div>
                        <div class='modal-body'>
                          <div class='alert' style='display:none;'>
                          </div>
                          <form role='form' id='posteditform' name='posteditform' method='post' >
                              <div class='form-group'>
                                  <label for='usr'>Title:</label>
                                  <input type='text'  class='form-control' name='posttitle' id='posttitle'>
                              </div>
                              <div class='form-group'>
                                  <label for='comment'>Content:</label>
                                  <textarea class='form-control'   rows='8' name='content' id='content' ></textarea>
                              </div>
                              <div class='form-group'>
                                <input id='upload_image_button' class='btn btn-default' type='button' value='Upload Image' /> <span class='thumbnailshow'></span>
                                <input id='upload_image' type='hidden' size='36' name='upload_image' value='' />
                              </div>
                              <div class='row'>
                              <div class='form-group form-group-topic'>";
                        echo context();
                        echo "</div>
                              <div class='form-group form-group-source'>";
                        echo source();           
                        echo "</div>
                        </div>
                              <div class='form-group'>
                                  <input type='hidden' class='feed_id' id='feed_id'>
                                  <input type='hidden' class='feed_image' id='feed_image'>
                                  <input type='hidden' class='feed_image_alternate' id='feed_image_alternate'>
                                  <input type='submit' name='importRssData'  value= 'Submit' class='btn btn-default editbutton'>
                              </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>";
        }
        ?>
    <?php } else { ?>
    <form name="new_rss_feed" method="post" class='new_rss_feed'>
        <h2>Add Rss Feed</h2>
    <table>
        <tbody>
            <tr>
                <td style="width:190px;"><label for="og_blog_title">Title:<span class="custom-error">*</span></label></td>
                <td>
                    <input type="text" size="90" value="" name="title" id="title" style="width:510px;">
                </td>
            </tr>
            <tr>
                <td><label for="og_blog_description">URL:<span class="custom-error">*</span></label></td>
                <td>
                    <input type="text" size="90" value="" name="url" id="url" style="width:510px;">
                </td>
            </tr>
        </tbody>
    </table>
    <p class="submit">
          <input type="submit" name='submitfeed' value="Submit" id="addfeedbtn" class="button-primary">
    </p>
    </form>
    <?php } ?>
    <?php
    if( isset($_POST['title']) && isset($_POST['url']) && $_POST['title'] != '' && $_POST['url'] != '' ){
        $title = $_POST['title'];
        $url = $_POST['url'];
        $option = $_POST['existingOptions'];
        global $wpdb; 
        $feed_table = $wpdb->prefix."rssfeed";
        $result = $wpdb->query( $wpdb->prepare("INSERT INTO ".$feed_table." (rssfeedname,rssfeedurl) VALUES ( %s,%s)",array($title, $url)));
        if($result){
            wp_redirect(  admin_url( 'admin.php?page=rss-top-handle&response=1&addrss=1' ) );
        } else{
            wp_redirect(  admin_url( 'admin.php?page=rss-top-handle&response=0' ) );
        }
    }
}
function context(){
    $html = '';
    $html = '<select name="topic" class="topic form-control" height="100"  data-placeholder="Choose a Context...">
        <option value="">Choose a Context</option><option value="AMUSING">AMUSING</option><option value="INTERESTING">INTERESTING</option>
        <option value="MISC.">MISC.</option><option value="NEWS">NEWS</option><option value="SAD">SAD</option><option value="SAPPY">SAPPY</option>
        <option value="SATIRE">SATIRE</option><option value="SICK">SICK</option><option value="SILLY">SILLY</option><option value="STRANGE">STRANGE</option>
        <option value="STUPID">STUPID</option><option value="SURVEY">SURVEY</option><option value="ASININE">ASININE</option><option value="PSA">PSA</option>
        <option value="OBVIOUS">OBVIOUS</option><option value="SPIFFY">SPIFFY</option><option value="WEIRD">WEIRD</option><option value="COOL">COOL</option>
        <option value="SCARY">SCARY</option><option value="IRONIC">IRONIC</option><option value="BOOBIES">BOOBIES</option><option value="CAPTION">CAPTION</option><option value="PHOTOSHOP">PHOTOSHOP</option><option value="PLUG">PLUG</option>
        <option value="WEENERS">WEENERS</option><option value="FOLLOWUP">FOLLOWUP</option><option value="WALKEN">WALKEN</option>
        <option value="HERO">HERO</option><option value="N">N</option><option value="AUDIO">AUDIO</option><option value="VIDEO">VIDEO</option>
        <option value="WHEATON">WHEATON</option><option value="UNLIKELY">UNLIKELY</option><option value="DUMBASS">DUMBASS</option>
        <option value="FLORIDA">FLORIDA</option><option value="ADVICE">ADVICE</option><option value="AudioEdit">AudioEdit</option>
        <option value="VideoEdit">VideoEdit</option><option value="Farktography">Farktography</option><option value="FARK BLOG">FARK BLOG</option>
        <option value="TRAVEL">TRAVEL</option><option value="FAIL">FAIL</option><option value="FARK PARTY">FARK PARTY</option>
        <option value="CATURDAY">CATURDAY</option><option value="REPEAT">REPEAT</option><option value="CSB">CSB</option>
        <option value="Facepalm">Facepalm</option><option value="Murica">Murica</option>
        <option value="Awkward">Awkward</option></select>';
        return $html;
}
function source(){
    $html = '';
    $html = '<select  class="rsssource form-control" name="source"  height="100" data-placeholder="Choose a Source..."><option value="">Choose a Source</option>
    <option value="bbcus">BBC</option><option value="wral">WARL</option><option value="augustachronicle">Augusta Chronicle</option>
    <option value="boingboing">Boing Boing</option><option value="dailymail">Daily Mail</option>
    <option value="detroitfreepress">DETROIT FREEPRESS</option><option value="austinnewskxan">Austin News</option>
    <option value="cbsphiladelphia">CBS Philadelphia</option><option value="cnbc">CNBC</option>
    <option value="ctvnews">CTV NEWS</option><option value="deviantart">DEVIANT ART</option>
    <option value="fark">FARK</option><option value="fortune">Fortune</option>
    <option value="guardian">THE GUARDIAN</option><option value="huffingtonpost">HUFFINGTON POST</option>
    <option value="HuffPoPartnerBar">HUFF PO POST</option><option value="indystar">INDY STAR</option>
    <option value="jezebel">JEZEBEL</option><option value="journalnews">LOHUD</option><option value="livejournal">
    LIVE JOURNAL</option><option value="mirrorcouk">MIRROR.CO.UK</option><option value="msn">MSN</option>
    <option value="news13orlando">NEWS 13</option><option value="newsbreaker">WT FARK</option>
    <option value="newserlogo-fark">NEWSER</option><option value="newyorkdailynews">New York Daily News</option>
    <option value="norwicheveningnews">Norwich Evening News</option><option value="nytimes">NY TIMES</option>
    <option value="pennlive">PEN LIVE</option><option value="seattlepi">Seattle PI</option><option value="slate">SLATE</option>
    <option value="telegraph">TELEGRAPH</option><option value="thelocal">THE LOCAL</option><option value="theweekuk">THE WEEK</option>
    <option value="timesofisrael">TIMES OF ISRAEL</option><option value="torontosun">TORONTO SUN</option><option value="upi">UPI</option>
    <option value="usatoday">USA TODAY</option><option value="washingtonpost">WashingtonPost</option>
    <option value="wbngbinghamton">12 ACTION NEWS</option><option value="whnsfox21">FOX CAROLINA</option>
    <option value="cbc">CBC</option><option value="seekingalpha">Seeking Alpha</option><option value="1437509619RIABIZ">RIABIZ</option>
    <option value="latimes">Los Angeles Times</option><option value="stuffconz">Stuff</option><option value="msnbc">MSNBC</option><option value="1437926897cbssports-2x">CBS Sports</option><option value="reuters">Reuters</option><option value="businessinsider">Business Insider</option><option value="awfulannouncing">Awful Announcing</option><option value="thedailybeast">The Daily Beast</option><option value="investorsbusinessdaily">Investors</option><option value="marketwatch">MarketWatch</option><option value="economist">The Economist</option><option value="newscomau">News.com.au</option><option value="foxnews">Fox News</option><option value="14391504957727">James Altucher</option><option value="1439155185politico-2x">Politico</option><option value="therawstory">Raw Story</option><option value="1439162094forbes-2x">Forbes</option><option value="buzzfeed-2x">Buzzfeed</option><option value="realtytoday-2x">Realty Today</option><option value="youtube">YouTube</option><option value="66cnn">CNN</option><option value="1439776347gtspirit-2x">GTSpirit</option><option value="calgaryherald">Calgary Herald</option><option value="vox">Vox</option><option value="scotsman">The Scotsman</option><option value="1440262646espn-2x">ESPN</option><option value="physorg2">Phys.org</option><option value="bloomberg">Bloomberg</option><option value="14403842967727">InvestmentNews</option><option value="1440385606edwardjones">Edward Jones</option><option value="Inc">Inc</option><option value="biloxisunherald">SunHerald</option><option value="247wallstreet">247WallSt</option><option value="crooksampliars">Crooks &amp; Liars</option><option value="retirelysource">Retirely</option><option value="1441722313vanityfair-2x">Vanity Fair</option><option value="motherjones">Mother Jones</option><option value="144255862247">Anurag Harsh</option><option value="cleantechnica">Clean Techniqa</option><option value="nypost">NYPost</option><option value="npr">NPR</option></select>';
    return $html;
}
function truncate($text, $length) {
   $length = abs((int)$length);
   $text = substr($text, 0, $length);
   return($text);
}
function addfeedpost($title , $content , $image ,$context ,$source){
    //$image = $image != '' ? $image : $imageUrlAlternate;
    try{
        $_POST['post_category'] = 0;
        $_POST['post_tags'] = 'rssfeed';
        $user_id = get_current_user_id(); 
        $new_post = array(
                'post_title'        => sanitize_text_field( $title ),
                'post_category'     => array( $_POST['post_category'] ),
                'tags_input'        => sanitize_text_field($_POST['post_tags']),
                'post_content'      => wp_kses_post($content),
                'post_author'       => $user_id,
                'post_status'       => 'publish'
        );
        $new_post_id = wp_insert_post($new_post, true);
        add_post_meta($new_post_id, 'hide_featured_image_on_detail_post_page','No');
        add_post_meta($new_post_id, 'label_images',$context );
        add_post_meta($new_post_id, 'source',$source );
        if($image != -1)
            set_post_thumbnail( $new_post_id, $image );
        /*$tmp = download_url(  $image );
        $file_array = array(
            'name' => basename( $image  ),
            'tmp_name' => $tmp
        );
        
        // Check for download errors
        if ( is_wp_error( $tmp ) ) {
            @unlink( $file_array[ 'tmp_name' ] );
            return $tmp;
        }

        $id_image = media_handle_sideload( $file_array, 0 );
        // Check for handle sideload errors.
        if ( is_wp_error( $id_image ) ) {
            @unlink( $file_array['tmp_name'] );
            return $id_image;
        }
        $attachment_url = wp_get_attachment_url( $id_image );
        set_post_thumbnail( $new_post_id, $id_image );*/
        if(is_wp_error($new_post_id))
            throw new Exception($new_post_id->get_error_message(), 1);
            $post_action = 'submitted';
            $data['success'] = true;
            $data['post_id'] = $new_post_id;
            $data['message'] = 'Your post has been'.$post_action.'successfully!<br/>';
    }catch(Exception $ex){
        $data['success'] = false;
        $data['message'] = '<h2>Your submission has errors. Please try again!</h2>'.$ex->getMessage();
    }
    return $data['success'];
}
?>
