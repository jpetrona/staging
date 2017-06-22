<style type="text/css">
    .myTab {
        float: right !important;
    }

    .ui-widget-header {
        background: none !important;
        border-top: none !important;
        border-left: none !important;
        border-right: none !important;
    }
</style>
<script type="text/javascript">
    jQuery(function () {
        jQuery("#tabs").tabs({ active: 2});
    });
</script>
<div class="fep">

    <div class="message-delete" id="message-delete" style="display: none;" >Do you really want to delete image ?</div>
    <form id="your-profile" action="#fep-message" enctype="multipart/form-data" method="post"<?php do_action('user_edit_form_tag'); ?> >
        <?php wp_nonce_field('update-user_' . $user_id) ?>
        <?php if ($wp_http_referer) : ?>
            <input type="hidden" name="wp_http_referer" value="<?php echo esc_url($wp_http_referer); ?>"/>
        <?php endif; ?>
        <p>
            <input type="hidden" name="delete" id="delete" value=""/>
            <input type="hidden" name="from" value="profile"/>
            <input type="hidden" name="checkuser_id" value="<?php echo $user_ID ?>"/>
        </p>

        <div id="main_tab101">
            <div id="tabs">
                <div class="border_bt59">
                    <div id="general_forem81">
                        <div class="general_det">
                            <div class="hd56">
                                <h1>Settings</h1>

                            </div>
                        </div>
                    </div>
                    <ul id="top_tab84">
                        <li class="myTab" id="list1001"><a href="#tabs-1">
                                <?php _e('Password Manager'); ?>
                            </a></li>
                        <li class="myTab" id="list1001"><a href="#tabs-2">
                                <?php _e('General Settings') ?>
                            </a></li>
                        <li class="myTab" id="list1001"><a href="#tabs-3">
                                <?php _e('My Profile') ?>
                            </a></li>
                    </ul>
                    <div style="clear:both"></div>
                </div>
                <div style="clear:both"></div>
                <div id="tabs-3">
                  <input type="hidden" id="image-object" value="" />

                    <script>
                        function PreviewImage_settingpage(id) {

                            if(document.getElementById(id).files[0]){
                                console.log( document.getElementById(id).files[0].name );
                                var x  = document.getElementById(id).files[0].name;
                                var p = x.lastIndexOf(".");
                                var e = x.length;
                                var res = x.substring( p+1 , e );
                                if( res == "jpg" || res == "jpeg" || res == "png")
                                {
                                    var oFReader = new FileReader();
                                    oFReader.readAsDataURL(document.getElementById(id).files[0]);
                                    oFReader.onload = function (oFREvent) {
                                        jQuery(".user_img > img:first").attr("src" , oFREvent.target.result );
                                    };
                                }else{
                                    console.log( document.getElementById(id).files[0] );
                                    alert('Invalid Image Format needed JPG/PNG');
                                  //  jQuery("#message").html('')
                                  //  jQuery("#message").dialog({modal:true,title:'Error',width:400,buttons:{"OK":function(){ $(this).dialog("close");}}});
                                    jQuery('#filepath0').val('');
                                }

                            }
                        }
                    </script>
                    <?php
                    if(isset($_POST["delete"]) && $_POST["delete"] == '1'){

                        $upload_dir = wp_upload_dir();
                        $image_path = get_template_directory()."/images/front-end-setting/use_img.png";
                        $image_path = str_replace("\\","/",$image_path);
                        $extention = explode(".", $image_path );
                        $ext = $extention[count($extention) - 1];
                        $link = $upload_dir['basedir']."/avatar/" .get_current_user_id().".jpg";
                        $link = str_replace("\\","/",$link);
                        if(file_exists($link)){
                            unlink($link);
                        } 
                        copy( $image_path ,  $link );
                        ?>
                        <script>
                            jQuery(document).ready(function(){
                                jQuery(".tab-span img").attr('src', "<?php echo site_url()."/wp-content/uploads/avatar/".get_current_user_id().".jpg?v=".rand();?>" );
                                jQuery(".comm-avatar img").attr('src', "<?php echo site_url()."/wp-content/uploads/avatar/".get_current_user_id().".jpg?v=".rand();?>" );
                                jQuery(".user_img > img:first").attr('src', "<?php echo site_url()."/wp-content/uploads/avatar/".get_current_user_id().".jpg?v=".rand();?>" );
                            });

                        </script>
                    <?php
                    }
                    if(isset($_FILES["filepath0"]) && $_FILES["filepath0"]["name"] != ''){
                    //    require( dirname(__FILE__) . '/wp-load.php' );
                            $name = $_FILES["filepath0"]["name"];
                            $upload_dir = wp_upload_dir();
                            $extention = explode(".", $_FILES['filepath0']['name'] );
                            $ext = $extention[count($extention) - 1];
                            $link = $upload_dir['basedir']."/avatar/" .get_current_user_id().".jpg";
                            $link = str_replace("\\","/",$link);
                            if(file_exists($link)){
                                unlink($link);
                            }
                            move_uploaded_file( $_FILES["filepath0"]["tmp_name"],  $link );
                            ?>
                            <script>
                                jQuery(document).ready(function(){
                                    jQuery(".tab-span img").attr('src', "<?php echo site_url()."/wp-content/uploads/avatar/".get_current_user_id().".jpg?v=".rand();?>" );
                                    jQuery(".comm-avatar img").attr('src', "<?php echo site_url()."/wp-content/uploads/avatar/".get_current_user_id().".jpg?v=".rand();?>" );
                                    jQuery(".user_img > img:first").attr('src', "<?php echo site_url()."/wp-content/uploads/avatar/".get_current_user_id().".jpg?v=".rand();?>" );
                                });

                            </script>
                            <?php
                    }
                    if( $_POST['action'] == "update" )
                    {
                        $profileuser->Birthday = "{$_POST['Birthday_day']}/{$_POST['Birthday_month']}/{$_POST['Birthday_year']}" ;
                        do_action('personal_options', $profileuser);
                        do_action('profile_personal_options', $profileuser);                         

                        if(BROWSER=="safari"){
                            wp_redirect(esc_url(home_url( '/' ))."setting-page/#fep-message");
                        }
                        ?>
                            <script>
                                jQuery(document).ready(function(){
                                    jQuery(".avatar-name-prfl-content").html(jQuery("#last_name").val());
                                    jQuery("#firstname").html(jQuery("#first_name").val());
                                });
                            </script> 
                            <?php
                    }
             
                    ?>
                    <h3>My profile information</h3>

                    <div id="form_des89">
                        <form role="form" class="form-horizontal">
                            <div class="form_des89_left">
                                <div class="form-group">
                                    <label class="control-label">Tag Line:</label>

                                    <div class="">
                                        <input type="text" name="first_name" id="first_name"
                                               value="<?php echo esc_attr($profileuser->first_name) ?>"
                                               class="form-control"  pattern="[A-Za-z].{2,}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Name:</label>

                                    <div class="">
                                        <input type="text" name="last_name" id="last_name"
                                               value="<?php echo esc_attr($profileuser->last_name) ?>"
                                               class="form-control" pattern="[A-Za-z].{2,}" required>
                                    </div>
                                </div>
                                <?php
                                $a = explode("/", $profileuser->Birthday );
                                ?>
                                <div class="form-group">
                                    <label class="control-label">Birthday:</label>
                                    <select class="selectpicker birth" name="Birthday_day">
                                        <?php $arr = array('1' => "Janaury", '2' => "February", '3' => "March", '4' => "April", '5' => "May", '6' => "June",
                                            '7' => "July", '8' => "August", '9' => "September", '10' => "October", '11' => "November", '12' => "December");
                                        for ($i = 1; $i <= 12; $i++) {
                                            if (intval($a[0]) == intval($i)) { ?>
                                                <option value='<?php echo $i ?>'
                                                        selected><?php echo $arr[$i] ?></option><?php } else { ?>
                                                <option value='<?php echo $i ?>'><?php echo $arr[$i] ?></option><?php }
                                        } ?>
                                    </select>
                                    <select class="selectpicker month5" name="Birthday_month">
                                        <?php for ($i = 1; $i <= 31; $i++) {
                                            if (intval($a[1]) == intval($i)) { ?>
                                                <option value='<?php echo $i ?>'
                                                        selected><?php echo sprintf("%02d", $i) ?></option><?php } else { ?>
                                                <option
                                                value='<?php echo $i ?>'><?php echo sprintf("%02d", $i) ?></option><?php }
                                        } ?>
                                    </select>
                                    <select class="selectpicker year5" name="Birthday_year">
                                        <?php $year = intval(date("Y"));
                                        for ($i = ($year - 1); $i >= $year - 40; $i--) {
                                            if (intval($a[2]) == intval($i)) { ?>
                                                <option value='<?php echo $i ?>'
                                                        selected><?php echo $i ?></option><?php } else { ?>
                                                <option value='<?php echo $i ?>'><?php echo $i ?></option><?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group" style="margin:0;">
                                    <label class="control-label">Male:</label>

                                    <div class="radio56">
                                        <input type="radio" name="Gender"
                                               value="M"  <?php if (esc_attr($profileuser->Gender) == "M") {
                                            echo checked;
                                        } ?>/>
                                        <span> Male </span></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label label5">&nbsp;</label>

                                    <div class="radio56">
                                        <input type="radio" name="Gender"
                                               value="F" <?php if (esc_attr($profileuser->Gender) == "F") {
                                            echo checked;
                                        } ?> />
                                        <span> Female </span></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Country:</label>

                                    <div class="radio56">
                                        <select class="selectpicker state" name="Country">
                                            <?php global $wpdb;
                                            $country_list = $wpdb->get_results("SELECT * FROM a1_country");
                                            for ($i = 0; $i < count($country_list) - 1; $i++) {
                                                if (esc_attr($profileuser->Country) == $country_list[$i]->country_code) { ?>
                                                    <option value='<?php echo $country_list[$i]->country_code ?>'
                                                            selected><?php echo $country_list[$i]->country_name ?></option><?php } else { ?>
                                                    <option
                                                    value='<?php echo $country_list[$i]->country_code ?>'><?php echo $country_list[$i]->country_name ?></option><?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form_des89_right">
                                <div class="form-group">
                                    <label class="control-label">Job title:</label>

                                    <div class="">
                                        <input type="text" name="JobTitle" id="JobTitle"
                                               value="<?php echo esc_attr($profileuser->JobTitle) ?>"
                                               class="form-control" pattern="[A-Za-z].{2,}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Bio:</label>

                                    <div class="">
                                        <textarea class="form-control" style="border:1px solid #b7b7b7;" name="description" id="description"><?php echo esc_html($profileuser->description); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div style="clear:both"></div>
                    </div>
                    <div id="form_des89">
                        <div class="form_des89_left bt_desc56">
                            <div class="form-group">
                                <label class="control-label">First name:</label>

                                <div class="user_img">
                                        <?php
                                        echo get_avatar(get_current_user_id(), 130); ?>
                                        <!--<img src="<?php /*bloginfo('template_url'); */?>/images/front-end-setting/use_img.png">-->

                                 <button id="delete-button" value="1" class="btn98" ><img
                                            src="<?php bloginfo('template_url'); ?>/images/front-end-setting/delet_btn.png">
                                    </button>
                                </div>



                                <div class="right_fm_dec"> Upload photo
                                    <div class="des_detail">
                                        <p>1. Add photo with your personality on it only.</p>

                                        <p>2. You must be easily identified and your face
                                            must be clearly visible on the photo.</p>

                                        <p>3. Any photo containing erotic or inappropriate
                                            content is not permitted.</p>

                                        <p>If you don't follow these rules, your account
                                            may be disabled or blocked.</p>
                                    </div>
                                    <div class="upload_file">
                                        <input type="file" id="filepath0" name="filepath0" accept="image/*" onchange="PreviewImage_settingpage(this.id);"/>
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                        </div>
                    </div>
                    <div id="form_des89">
                        <div class="form_des89_left bt_desc56">
                            <div class="form-group">
                                <label class="control-label label6">&nbsp;</label>

                                <div class="user_img1">
                                    <button class="btn98" type="submit"><img
                                            src="<?php bloginfo('template_url'); ?>/images/front-end-setting/save_btn.png">
                                    </button>
                                </div>
                                <div class="user_img1">
                                    <button class="btn99" type="submit">Cancel</button>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tabs-2">
                    <h3>General settings</h3>

                    <div id="setting_email">


                            <div class="setting_main">
                                <div class="email_des">
                                    <div class="form-group">
                                        <label class="control-label">*Email:</label>
                                        <div class="label_right">
                       <input type="text" name="email" id="email" value="<?php echo esc_attr($profileuser->user_email) ?>" class="regular-text" pattern="[A-Za-z].{2,}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="email_des">
                                    <div class="form-group">
                                       <!--  <label class="control-label">Rating:</label>

                                        <div class="label_right"><input type="checkbox" name="rating" id="rating" value="true" class="" <?php //if( esc_attr($profileuser->rating) == "true"){echo "checked='checked'";}?>> <span class="chek56">Participate in the TOP chart</span>
                                        </div> -->
                                    </div>
                                </div>


                            </div>

                            <div class="setting_main stettin_56">
                                <h3>Notifications</h3>

                                <div class="email_des">
                                    <div class="form-group">
                                        <label class="control-label">About new private messages</label>

                                        <div class="label_right">
                                            <input type="checkbox" name="private_messages" id="private_messages" value="true" class="" <?php if( esc_attr($profileuser->private_messages ) == "true"){echo "checked='checked'";}?>><span class="chek56"> About new private messages </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="email_des">
                                    <div class="form-group">
                                        <label class="control-label">&nbsp;</label>
                                 <div class="label_right"><input type="checkbox" name="subscription" id="subscription" value="true" class="" <?php if( esc_attr($profileuser->subscription ) == "true"){echo "checked='checked'";}?>> <span class="chek56">Events (new friends, signal subscription, etc.)</span>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        <!--  <div class="setting_main stettin_56 settin_bt5">
                                <h3>Accounts are available for viewing by other users</h3>

                                <div class="email_des">
                                    <div class="form-group">
                                        <label class="control-label">My live accounts:</label>
                                        <div class="label_right">
                                           <input type="checkbox" class="check57" name="AccountName" id="AccountName" value="true" <?php //if( esc_attr($profileuser->AccountName ) == "true"){echo "checked='checked'";}?>>
                                           <span class="chek56"> You have no account yet </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="email_des">
                                    <div class="form-group">
                                        <label class="control-label">Generate signals for these accounts:</label>

                                        <div class="label_right">
                                            <input type="checkbox" class="check57" name="demo" id="demo"
                                                                        value="true" <?php //if( esc_attr($profileuser->demo ) == "true"){echo "checked='checked'";}?>>
                                            <span
                                                class="chek56">MMA demo</span></div>
                                    </div>
                                </div>


                            </div> -->
                            <div class="form_des891">
                                <div class="setting_email_btn">
                                    <div class="user_img1">
                                        <button type="submit" class="btn98"><img
                                                src="<?php bloginfo('template_url'); ?>/images/front-end-setting/save_btn.png">
                                        </button>
                                    </div>
                                    <div class="user_img1">
                                        <button type="submit" class="btn99">Cancel</button>
                                    </div>
                                </div>
                            </div>

                            <div style="clear:both"></div>




                    </div>

                </div>
                <div id="tabs-1">

                    <div id="password_setting">
                        <div class="main_pass_setting">
                            <div class="text_right45">
                                <p>You are changing the password for your account’s access on the website
                                    retire.ly</p>

                                <p>Passwords to your account’s access and for your Private Office must be different</p>
                            </div>
                            <div style="clear:both"></div>

                            <div class="password_form">
                                <?php
                                //$show_password_fields = apply_filters('show_password_fields', true, $profileuser);
                                //if($show_password_fields) : ?>
                                    <div class="form-group">
                                        <label class="control-label">Current password<span
                                                style="color:#ff0000">*</span></label>

                                        <div class="">
                                            <input type="password" name="old-pass" id="old-pass"
                                                   class="form-control" value=""  > <span class="mini8">Minimum 6 characters</span>
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <label class="control-label">New password<span
                                                style="color:#ff0000">*</span></label>

                                        <div class="">
                                            <input type="password"
                                                   name="pass1" id="pass1"  class="form-control" value="" >
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <label class="control-label">Confirm new password<span
                                                style="color:#ff0000">*</span></label>

                                        <div class="">
                                            <input type="password" name="pass2" id="pass2" class="form-control" value="" >
                                        </div>
                                    </div>



                                <div style="clear:both"></div>
                            </div>


                        </div>
                        <div class="password_main">
                            <div class="change_password">

                                <button type="submit" class="btn_pass" id="change-password" value="1"><img
                                        src="<?php bloginfo('template_url'); ?>/images/front-end-setting/change_password_btn.png">
                                </button>


                            </div>

                        </div>

                    </div>

                    <?php
                    do_action('show_user_profile', $profileuser);
                    ?>
                    <?php if (count($profileuser->caps) > count($profileuser->roles) && apply_filters('additional_capabilities_display', true, $profileuser)) { ?>
                        <br class="clear"/>
                        <table width="99%" style="border: none;" cellspacing="2" cellpadding="3" class="editform">
                            <tr>
                                <th scope="row"><?php _e('Additional Capabilities') ?></th>
                                <td><?php
                                    $output = '';
                                    foreach ($profileuser->caps as $cap => $value) {
                                        if (!$wp_roles->is_role($cap)) {
                                            if ($output != '')
                                                $output .= ', ';
                                            $output .= $value ? $cap : "Denied: {$cap}";
                                        }
                                    }
                                    echo $output;
                                    ?></td>
                            </tr>
                        </table>
                    <?php } ?>
                </div>
                <p class="submit">
                    <input type="hidden" name="action" value="update"/>
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr($user_id); ?>"/>
                    <!--<input type="submit" class="button-primary btn-update feprofile-update-button" value="<?php _e('Update Profile'); ?>"
                       name="submit"/>-->
                </p>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" charset="utf-8">
    if (window.location.hash == '#password') {
        document.getElementById('pass1').focus();
    }
</script>
