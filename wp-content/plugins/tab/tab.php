<?php
/*
Plugin Name: TAb
Plugin URI: http://linkites.com
Description: tabs
Author: Amit Sharma
Version: 1.6
Author URI: http://linkites.com
*/


define("URL", "/profile/");
// This just echoes the chosen line, we'll position it later

function SignIn($atts)
{

    $facebook = plugins_url() . '/tab/images/facebook.jpg';
    $linkedin = plugins_url() . "/tab/images/Linkedin.jpg";
    $shadow = plugins_url() . "/tab/images/shadow.png";
    $profile_icon = plugins_url() . "/tab/images/profile_icon.png";
    $link_for_share_and_update = get_option('home') . "/myprofile/?show=1"; //get_the_ID()
    $link_for_add_campaign = site_url() . "/add-campaign"; //get_the_ID()

    $link_1 = plugins_url()."/tab/css/imgareaselect-default.css";
    //$link_2 = plugins_url()."/tab/scripts/jquery.min.js";
    $link_22 = '//code.jquery.com/jquery-migrate-1.0.0.js';
    $link_3 = plugins_url()."/tab/scripts/jquery.imgareaselect.pack.js";

    $user_id_val = isset($atts['val'])?$atts['val']:'';
    if ($user_id_val == "") {
        $user_id_val = get_current_user_id();
    }
    ?>

    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>

    <link rel="stylesheet" type="text/css" href="<?php echo $link_1; ?>" />
    <script type="text/javascript" src="<?php echo $link_22; ?>" ></script>
    <script type="text/javascript" src="<?php echo $link_3; ?>" ></script>
    <style>
        .ui-dialog{
            top:10% !important;
            left:15% !important
        }
        .image-crop-button{
            background: rgba(0, 148, 238, 0.8) none repeat scroll 0 0 !important;
            border: 1px solid rgb(203, 203, 203) !important;
            color: #fff !important;
            cursor: pointer !important;
            font-size: 14px !important;
            font-weight: bold !important;
            height: auto !important;
            margin-bottom: 19px !important;
            margin-left: 0 !important;
            margin-top: 20px !important;
            padding: 6px !important;
            width: auto !important;
        }
        #image-crop-drag-div{
            overflow: hidden;
            position:absolute;
        }
        #image-crop{
            overflow: hidden;
        }
        #image-crop-drag-cor-start{
            overflow:auto;
            display:none;
            position:absolute;
            color:white;
            z-index: 4;
        }
        #image-crop-drag-cor-bottom{
            overflow:auto;
            display:none;
            position:absolute;
            color:white;
            z-index: 4;
        }
        #image-crop-drag{
            display:none;
            width:100%;
        }
        .ui-dialog{
            z-index: 1043;
        }

    </style>
    <?php
    if(is_user_logged_in()){
        $classname="sign-block-profile";
    }else{
        $classname="sign-block";
    }
    ?>
    <div class="<?php echo $classname;?>" style="position:relative;">
        <?php if (!(current_user_can('level_0')) && $atts['val'] == ""){ ?>
        <div class="sign-section clearfix">
            <div class="margin-default-box"></div>
            <div class="sign-box">
                <div class="sign-top">
                    <p class="sign-text mrgn-cls">Sign In or <a href="/user-registration/" style="color:gray">Sign Up</a></p>

                    <form id='login-form'  action="<?php echo get_option('home'); ?>/wp-login.php" method="post">
                        <?php
                        if( $_GET['action'] ){
                            ?><div class="error" style="margin-left:0px;">Incorrect:Login/Password</div><?php
                        } ?>
                        <div class="form-group mrgn-cls">
                            <label class="form-lbl-text">User Name</label>
                            <input  type="text" name="log" id="log" class="form-control inpt" placeholder="Username"
                              value="<?php echo wp_specialchars(stripslashes($user_login), 1) ?>" size="20"
                                   />
                           <span class='username-error state-error' style='display:none'>Please enter username</span>       
                        </div>
                        <div class="form-group mrgn-cls">
                            <label class="form-lbl-text">Password</label>
                            <input type="password" name="pwd" id="pwd" size="20" class="form-control inpt"
                                   placeholder="Password" />
                            <span class='password-error state-error' style='display:none'>Please enter password</span>
                        </div>
                        <input type="submit" name="submit" disabled  value="Sign In" class="btn btn-default my-login sign-btnn mrgn-cls"/>

                        <p class="pwd-block">
                            <label for="rememberme"><input name="rememberme" id="rememberme" type="checkbox"
                                                           checked="checked" value="forever"/> Remember me</label>
                            <?php if(isset($_GET['tx']) && $_GET['tx']=='addfunds'){?>
                            <input type="hidden" name="redirect_to" value="<?php echo get_option('home'); ?>/campaign/?tx=addfunds"/>
                            <?php }else{?>
                            <input type="hidden" name="redirect_to" value="<?php echo get_option('home'); ?>/myprofile/"/>
                            <?php } ?>
                            <a class="forget-pwd" href="<?php echo get_option('home'); ?>/reset-password/">Recover password</a>
                        </p>
                    </form>
                </div>
                <div class="sign-bottom">
                    <?php //echo do_shortcode("[TheChamp-Login]"); ?>
                    <?php do_action( 'wordpress_social_login' ); ?>
                </div>
            </div>

            <!--<div class="img-shadow">
				<img class="logo-shadow" alt="Retirely" src="<?php echo $shadow; ?>">
			</div>-->
            <?php } else { ?>
                <div class="sign-box1">
                    <?php
                    $userData = get_user_meta( $user_id_val );
                    $nickname=$userData['nickname'][0];
                    $first_name=$userData['first_name'][0];
                    $profile_background=$userData['profile_background'][0];
                    if($profile_background==""){
                     $profile_background = $user_id_val . ".jpg";
                    }
                    $profile_background_position=$userData['profile_background_position'][0];
                    $upload_dir = wp_upload_dir();
                    $path = $upload_dir['baseurl'] . "/CoverPage/";
                    ?>
                        <link href="<?php echo plugins_url()?>/tab/css/timeline.css" rel='stylesheet' type='text/css'/>
                        <script src="<?php echo plugins_url()?>/tab/js/jquery.wallform.js"></script>
                        <script>
                        $(document).ready(function()
                        {


                        /* Uploading Profile BackGround Image */
                        $('body').on('change','#bgphotoimg', function()
                        {

                        $("#bgimageform").ajaxForm({target: '#timelineBackground',
                        beforeSubmit:function(){},
                        success:function(){

                        //$("#timelineShade").hide();
                        //$("#bgimageform").hide();
                        },
                        error:function(){

                        } }).submit();
                        });



                        /* Banner position drag */
                        $("body").on('mouseover','.headerimage',function ()
                        {
                        var y1 = $('#timelineBackground').height();
                        var y2 =  $('.headerimage').height();
                        $(this).draggable({
                        scroll: false,
                        axis: "y",
                        drag: function(event, ui) {
                        if(ui.position.top >= 0)
                        {
                        ui.position.top = 0;
                        }
                        else if(ui.position.top <= y1 - y2)
                        {
                        ui.position.top = y1 - y2;
                        }
                        },
                        stop: function(event, ui)
                        {
                        }
                        });
                        });


                        /* Bannert Position Save*/
                        $("body").on('click','.bgSave',function ()
                        {
                        var id = $(this).attr("id");
                        var p = $("#timelineBGload").attr("style");
                        var Y =p.split("top:");
                        var Z=Y[1].split(";");
                        var dataString ='position='+Z[0];
                        $.ajax({
                        type: "POST",
                        url: "https://www.retire.ly/image_saveBG_ajax.php",
                        data: dataString,
                        cache: false,
                        beforeSend: function(){ },
                        success: function(html)
                        {
                        if(html)
                        {
                        $(".bgImage").fadeOut('slow');
                        $(".bgSave").fadeOut('slow');
                        $("#timelineShade").fadeIn("slow");
                        $("#timelineBGload").removeClass("headerimage");
                        $("#timelineBGload").css({'margin-top':html});
                        return false;
                        }
                        }
                        });
                        return false;
                        });

                        });

                    function PreviewImage(id) {
                        var file = document.getElementById(id);

                        /* Create a FormData instance */
                        var formData = new FormData();
                        /* Add the file */
                        formData.append("uid", "<?=$user_id_val;?>");
                        formData.append("upload", file.files[0]);

                        $.ajax({
                           url: "<?=site_url().'/wp-upload.php';?>",
                           type: "POST",
                           data: formData,
                           processData: false,
                           contentType: false,
                           success: function(response) {
                            document.location.reload();
                           },
                           error: function(jqXHR, textStatus, errorMessage) {
                               console.log(errorMessage); // Optional
                           }
                        });
                        /* Send to server */
                        jQuery("#loader").show();

                    };
                        </script>
                    <div class="prfl-box">
                        <div id="timelineContainer">

                        <!-- timeline background -->
                        <div id="timelineBackground"></div>

                        <!-- timeline background -->
			<?php if($user_id_val == get_current_user_id()){?>
                        <form id="bgimageform" method="post" enctype="multipart/form-data" action="<?php echo site_url();?>/image_upload_ajax.php">
                        <!--div class="uploadFile timelineUploadBG">
                        <input type="file" name="photoimg" id="bgphotoimg" class=" custom-file-input" original-title="Change Cover Picture">
                        </div-->
                        </form>
                        </div>
			<?php } ?>
                        <!-- timeline profile picture -->
                        <div id="timelineProfilePic" >
                        <a href="javascript:void(0);"><?php echo get_avatar($user_id_val, 80); ?></a>
			<?php if($user_id_val == get_current_user_id()){?>
                        <div class="profile-imghover" onclick="document.getElementById('fileinput0').click();">
                        <?php if(BROWSER == "safari") {?>
                                <input id="fileinput0" type="file" name="filepath0"
                                       accept="image/*" style="visibility:hidden;"
                                       onchange="PreviewImage(this.id);"/>
                       <?php }else{
                        ?>
                            <input id="fileinput0" type="file" name="filepath0"
                                   accept="image/*" style="display:none;"
                                   onchange="PreviewImage(this.id);"/>
                        <?php
                        } ?>
                        </div>
			<?php } ?>
			</div>
                        <!-- timeline title -->
                        <div id="timelineTitle" class="rtl-timelineTitle">
                            <p class="avatar-name-prfl"><a class="avatar-name-prfl-content"> <?php echo $nickname;?> </a> <?php if ($user_id_val == get_current_user_id()) { ?><a href="#" class="pencl-img-block" id="name_update"> <i class="fa fa-pencil pencl-img" id="name_update1"> </i> </a><?php }else{ ?><a style="visibility:hidden;"> <i class="fa fa-pencil pencl-img" id="name_update1"> </i> </a><?php } ?> </p>
                            <p class="avatar-tag-line"> <span id="firstname"><?php echo $first_name;?></span>  <?php if ($user_id_val == get_current_user_id()) { ?><a href="#" class="pencl-img-block"> <i class="fa fa-pencil pencl-img-smal" id="firstname_edit"></i> </a><?php } ?></p>
                        </div>

                        <!-- timeline nav -->
                        <div id="timelineNav">
                            <div class="profile-menu-block rtl-profile-menu">

                                <div class="profile-menu-left rtl-campain">
                                    <ul class="marketing-list">
                                        <?php if (is_user_logged_in()) { ?>
                                            <script>
                                                function campaign_disable(self){
                                                    console.log("working");
                                                    jQuery(self).hover(function() {
                                                              jQuery(self).css("backgroundColor","transparent");
                                                      });
                                                    self.style.borderColor ="red";
                                                    self.innerHTML = "<a href='javascript:void(0);' title='Contact Administrator' style='color:red !important'>NOT APPROVED</a><i title='Contact Administrator' class='triangle fa fa-exclamation-triangle' ></i>";
                                                }
                                                function campaign_enable(self){
                                                    console.log("working1");
                                                    self.style.borderColor ="#009cde";
                                                    self.innerHTML = "<a >ADD CAMPAIGN</a>";
                                                }
                                            </script>
                                        <?php
                                                global $wpdb;
                                                global $current_user;
                                                get_currentuserinfo();
                                                $userEmail = $current_user->user_email;
                                                $querystr = "select * from advisors where email='".$userEmail."'";
                                                $getadvisor = $wpdb->get_results($querystr, OBJECT);
                                                $advisorId = $getadvisor[0]->advisorid;
                                        ?>
                                         <?php   if( isset($advisorId) && $advisorId != '' && $user_id_val == get_current_user_id()) { ?>
                                           <?php $campaignurl = get_site_url().'/campaign/?id='.$advisorId; ?>
                                            <li><a href="<?php echo $campaignurl; ?>" class='campaign-link'>ADD CAMPAIGN</a></li>
					    <li><a href="<?php echo $link_for_share_and_update; ?>">SHARE AN UPDATE </a>
                                           <?php } ?>
                                        <?php } else { ?>
                                            <li style="border:none;"><a href="#"></a></li>
                                            <li style="border:none;"><a href="#"></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="profile-menu-right">
                                    <ul>
                                        <!--li><a href="<?php echo $link_for_share_and_update; ?>">
                                        <i class="fa fa-pencil-square-o prfl-edit-icons"></i></a></li>
                                        <li><a href="<?php echo get_permalink(1223); ?>"><i class="fa fa-cog prfl-edit-icons"></i></a></li-->
                                    </ul>
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
                <?php if( is_user_logged_in() ){ ?>
                <script type="text/javascript">
                    var count = 1;
                    function fns() {
                        jQuery("#box-fa-angle-up").toggleClass("fa-angle-up", count % 2 === 0);
                        jQuery("#box-fa-angle-up").toggleClass("fa-angle-up-shifter", count % 2 === 0);
                        jQuery("#arrow-wrapper").toggleClass("arrow-wrapper", count % 2 === 0);

                        jQuery(".sign-box1").slideToggle("slow");

                        jQuery("#box-fa-angle-up").toggleClass("fa-angle-down", count % 2 !== 0);
                        jQuery("#box-fa-angle-up").toggleClass("fa-angle-down-shifter", count % 2 !== 0);
                        jQuery("#arrow-wrapper").toggleClass("arrow-wrapper-down", count % 2 !== 0);

                        count++;
                    }
                </script>
                <?php } ?>
                </div>

                <div id="image-crop" >
                    <!--max-height:500px;max-width:500px;-->


                    <div id="image-crop-drag-div">
                        <div id="image-crop-drag-cor-start"></div>
                        <div id="image-crop-drag-cor-bottom" ></div>
                    <img id="image-crop-drag" src="" />
                    </div>
                </div>
              <?php } ?>
        </div>
        <!--div id="arrow-wrapper" class="arrow-wrapper" >
        <i class="fa fa-angle-up fa-angle-up-shifter" id="box-fa-angle-up" style="cursor:pointer;"
           onclick="fns()"></i>
        </div-->
        <?php if (isset($_GET["show"]) && $_GET["show"] == "2") {
            wp_redirect(site_url() . "/add-campaign/");
    //include_once("add-campaign.php");
        } ?>

        <?php if (isset($_GET["show"]) && $_GET["show"] == "1") { ?>
            <div class="post-block-custom">
                <?php echo do_shortcode("[fep_submission_form]"); ?>
            </div>
        <?php } ?>
    </div>

<?php

}

// Now we set that function up to execute when the admin_notices action is called
add_shortcode('SignIn', 'SignIn');
//adding css scripts for profiles
function my_scripts_method()
{
    if (is_page_template('add-campaign.php') || is_page_template('template-editprofile.php') || is_page_template('template-download.php') || is_page_template('template-downloads.php') || is_page_template('template-frontendeditor.php') || is_page_template('settingpage.php') || is_page_template('template-myposting.php') || is_single())
     {
//		wp_enqueue_style('tabs-style1' ,	 plugins_url(). '/tab/css/bootstrap.css' );
//		wp_enqueue_style('tabs-style2' ,	 plugins_url(). '/tab/css/bootstrap.min.css' );

        wp_enqueue_style('tabs-style3', plugins_url() . '/tab/css/font-awesome.min.css');
        wp_enqueue_style('tabs-style5', plugins_url() . '/tab/css/style.css');
        wp_enqueue_style('tabs-style4', plugins_url() . '/tab/css/default.css');


        //	wp_enqueue_script('tabscripts1',  plugins_url(). '/tab/js/bootstrap.js',array( 'jquery' ) );
        //	wp_enqueue_script('tabscripts2',  plugins_url(). '/tab/js/bootstrap.min.js',array( 'jquery' ) );
        wp_enqueue_script('tabscripts3', plugins_url() . '/tab/js/npm.js', array('jquery'), "1.0", true);
        wp_localize_script('tabscripts3', 'UpdateAjaxObj', array('ajaxurl' => admin_url('admin-ajax.php')));
    }
}

add_action('wp_enqueue_scripts', 'my_scripts_method');

add_shortcode('DownloadPage', 'DownloadPage');
function DownloadPage()
{
    $download2 = plugins_url() . "/tab/images/download2.png";
    $download1 = plugins_url() . "/tab/images/download1.png";
    ?>
    <div class="download-sectn">
        <div class="download-block">
            <p class="downld-text">Download the App to Discover The Best Financial Advisors</p>
            <ul class="scl-botns">
                <li>
                    <a href="https://play.google.com/store/apps/details?id=com.Intlfaces.retire.ly">
                        <img class="scl-img img-responsive social-img-icon" alt="Retirely" src="<?php echo

                        $download2; ?>">
                    </a>
                </li>
                <li>
                    <a href="https://itunes.apple.com/us/app/retirely/id713998164?ls=1&mt=8">
                        <img class="scl-img img-responsive social-img-icon" alt="Retirely" src="<?php echo

                        $download1; ?>">
                    </a>
                </li>
            </ul>
        </div>
    </div>
<?php
}

function SignInButton()
{
    if (!is_user_logged_in()) {
        ?>

        <a href="<?php echo get_option('home') . '/sign-in/'?>"> <span class="tab-span">Sign In</span> </a>            or            <a
            href="<?php echo get_option('home') . '/user-registration/'?>"> <span class="tab-span">Sign Up</span> </a>

    <?php
    } else {
    ?>
        <div class="prfl-tab">
            <a href="#">
                <span class="tab-span"><?php echo get_avatar(get_current_user_id(), 32); ?></span>
            </a>
            <ul class="my-setting-block">
                <li class="profile-list"><a class="prfl-anchr" href="<?php echo get_option('home') . '/myprofile/'?>">My
                        Profile</a></li>
                <li class="profile-list"><a class="prfl-anchr" href="<?php echo get_option('home') . '/myprofile/?show=1'?>">Write a
                        Post</a></li>
                <li class="profile-list"><a class="prfl-anchr"
                                            href="<?php echo get_option('home') . '/setting-page/'?>">My Settings</a>
                </li>
                <li class="profile-list"><a class="prfl-anchr"
                                            href="<?php echo get_option('home') . '?action=logout&redirect_to=' .get_option('home').'?auth='.microtime()?>">Signout</a>
                </li>
            </ul>
        </div>
        <div>
            <input type="hidden" id="user_for_notification" value="<?php echo get_current_user_id(); ?>">
            <ul id="nav">
                <li id="notification_li"><span id="notification_count"></span><a href="#" id="notificationLink"><i class="fa fa-bell-o"></i></a>
                </li>
            </ul>
        </div>

    <?php
    }
}

add_shortcode('SignInButton', 'SignInButton');


function ajax_for_notification_comments()
{
    if (is_null($_REQUEST['offset']) || empty($_REQUEST['offset'])) {
        $offset = 0;
    } else {
        $offset = $_REQUEST['offset'];
    }

    $output = array();
    $userid = $_REQUEST['user'];
    $ans = get_user_meta($userid, "last_read_notification", true);
    $ans = date('Y-m-d H:i:s', strtotime($ans));

    $args = array(
        'post_author' => $userid,
        'status' => 'approve',
        'number' => 5,
        'offset' => $offset);


    /*
          ,

                'date_query'  => array(
                                          array(   'after' => date('Y-m-d H:i:s', strtotime( $ans ))  , 'inclusive' => true
                                              )
                                      )


                                       array(
                                                                        'year'  => 2015,
                                                                        'month' => 5,
                                                                        'day'   => 28,
                                                                     )   array(
                                                                       'year' => date('Y', $ans ), //'year'  => 2015,
                                                                       'month'=> date('m', $ans ), //'month' => 5,
                                                                       'day'  => date('d', $ans ) //'day'   => 28,
                                                                     ), 'inclusive' => true
    date('Y-m-d H:i:s', strtotime( $ans ))
                                                                     */

    $comments = get_comments($args);

    if ($comments) {

        $count_overall = count($comments);
        // $result = json_encode( $comments , true );
        $count_read_notifications = 0;
        $output = array();
        foreach ($comments as $key => $c) {
            $output[$key]["comments_in_short"] = substr(strip_tags($c->comment_content), 0, 100);  //get_the_title($c->comment_post_ID)
            //$arr = json_decode($str, true);
            // $arrne['name'] = "dsds";
            // array_push( $arr['players'], $arrne );
            // print_r($arr);
            $str = get_comment_link($c->comment_ID);
            $str = str_replace("#", "#li-", $str);
            $output[$key]["link"] = $str;
            $output[$key]["avatar"] = get_avatar($c->user_id, 24);

            $output[$key]["name"] = $c->comment_author;

            $output[$key]["date_of_comment"] = $c->comment_date;

            if (strtotime($c->comment_date) > strtotime($ans)) {
                $output[$key]["read"] = "1";
                $count_read_notifications++;
            } else {
                $output[$key]["read"] = "0";
            }

            $output[$key]["date_in_string"] = date("F j, g:i a", strtotime($c->comment_date));

            //array_push( $outputs[$key] , $output  );
        }
        // $outputs["co unt"] = $coun;
        foreach ($output as $key => $value) {
            $output[$key]['count'] = $count_read_notifications;
        }
        $result = json_encode($output, true);
    } else {
        $output[0]['avatar'] = "";
        $output[0]['date_in_string'] = $ans;
        $output[0]['comments_in_short'] = "No New Notifications";
        $result = json_encode($output, true);
    }
    if (intval($_REQUEST['save']) != 0) {
        $update = update_user_meta($userid, "last_read_notification", date("Y-m-d h:i:sa"));
        if ($update == false) {
            $add = add_user_meta($userid, "last_read_notification", date("Y-m-d h:i:sa"), true);
        }
    }


    echo $result;
    //return  '{"stage":"success","data":'.date("Y-m-d h:i:sa").'}';
    exit();
}

add_action('wp_ajax_ajax_for_notification_comments', 'ajax_for_notification_comments');
add_action('wp_ajax_nopriv_ajax_for_notification_comments', 'ajax_for_notification_comments');

add_action('wp_head', 'pluginname_ajaxurl');
function pluginname_ajaxurl()
{ ?>
    <script type="text/javascript">
        var ajaxurls = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
<?php
}
?>


