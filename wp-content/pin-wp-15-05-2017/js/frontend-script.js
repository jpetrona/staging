function validateComment(formdata){
    if(jQuery(".comment_text_loggedin").val() == ''){
        jQuery(".comment_text_loggedin").addClass('error-required-modal');
        return false;
    }else{
        jQuery(".comment_text_loggedin").removeClass('error-required-modal');
         return true;
    }
} 
jQuery(document).ready(function(){
    /*Like on index page*/
    jQuery(document).on("click", ".jlk-graph-post", function(e){
        e.preventDefault();
        var is_user_logged_in = jQuery("#is_user_logged_in").val();
        if(is_user_logged_in == 0 ){
            jQuery( ".ex1" ).trigger( "click" );
            return false;
        }
        var task = jQuery(this).attr("data-task");
        var inst = this;
        var post_id = jQuery(this).attr("data-post-id");
            jQuery.ajax({
               type : "post",
               async : false,
               dataType : "json",
               url : wtilp.ajax_url,
               data : {action: "add_action_on_post_frontend", task : task, post_id : post_id},
               beforeSend:function() {
                        if(task == 'unlike'){
                        jQuery("#post-egg-"+post_id).hide() ;
                       // jQuery(inst).parents('.article-category').siblings(".thumbnail-blog-link").append('<img class="egg-gif-dislike" src="https://www.retire.ly/wp-content/themes/pin-wp/images/egg_gif.gif" />');
                          jQuery(inst).parents('.article-category').siblings(".thumbnail-blog-link").find('.egg-gif-dislike-span').show();
                          setTimeout(function(){
                             jQuery("#post-egg-"+post_id).prop("src","https://d3aauwrblcdnb4.cloudfront.net/wp-content/uploads/2016/09/21115558/break.png") ;
                             jQuery(inst).addClass('disabled-section');
                             jQuery("#post-egg-"+post_id).show() ; 
                             //jQuery(".egg-gif-dislike").remove();
                             jQuery(inst).parents('.article-category').siblings(".thumbnail-blog-link").find('.egg-gif-dislike-span').hide();
                            },1000);
                    }
                },
               success: function(response) {
                    jQuery(".lc-" + post_id).html(response.post_counter);
                    //jQuery(inst).addClass("disabled_section");
                    //console.log(task);
                    if(task == 'like'){
                       jQuery("#post-egg-"+post_id).prop("src","https://d3aauwrblcdnb4.cloudfront.net/wp-content/uploads/2016/09/21115606/full.png") ;
                       jQuery(inst).parents('.watch-position').find('.action-unlike').find('.jlk-graph-post').removeClass('disabled-section');
                       jQuery(inst).parents('.watch-position').find('.action-unlike').find('.jlk-graph-post').attr('title', 'Dislike');
                    }
               }
            });
    });


    jQuery(document).on("click", ".jlk-graph", function(e){
        e.preventDefault();
        var task = jQuery(this).attr("data-task");
        var post_id = jQuery(this).attr("data-post-id");
        jQuery(".status-" + post_id).html("&nbsp;&nbsp;").addClass("loading-img").show();
            jQuery.ajax({
                type : "post",
                async : false,
                dataType : "json",
                url : wtilp.ajax_url,
                data : {action: "add_action_on_top_gainer", task : task, post_id : post_id},
                success: function(response) {
                    if(response.count > 0){
                      var likes = response.count;
                      var unlikes = 0;
                    } else{
                      var likes = 0;
                      var unlikes = response.count;
                    }
                    likes_count = (task == 'unlike' && response.count < 0) || response.count < 0 ? likes : '+'+likes ;
                    jQuery(".lc-" + post_id).html(likes_count);
                    jQuery(".unlc-" + post_id).html(unlikes);
                    jQuery(".status-" + post_id).removeClass("loading-img").empty().html(response.msg);
                }
            });
    });
   
    jQuery("#embed_video").change(function() {
        if(this.checked) {
            jQuery(".video-filled").show();
            jQuery("#fep-featured-image-id").val('');
            jQuery("#uploader1").val('');
        }else{
            jQuery(".video-filled").hide();

        }
    });
    jQuery('#comment').on('click', function(){
        jQuery('#comment').addClass('commentformfocus');
    });

    jQuery('.cancel-comment-box').on('click',function(){
        jQuery('#comment').removeClass('commentformfocus');
    });

    jQuery('.comment-form').on('submit', function() {
         if(jQuery("#comment").val() == ''){
                jQuery("#comment").addClass('error-required-modal');
                return false;
            }else{
                jQuery("#comment").removeClass('error-required-modal');
                 return true;
            }
    });
    jQuery(".avatar-coment").hover(function(){
        var h = jQuery(this).height() +parseInt('2')+'px';
        jQuery(this).prev(".avatar-block").css({'height':h,"background":"#EEEEFF"});
        jQuery(this).css("background", "#EEEEFF");
        }, function(){
        var h = jQuery(this).height()+parseInt('2')+'px';
        jQuery(this).prev(".avatar-block").css({'height':h,"background":"#F3F4F6"});    
        jQuery(this).css("background", "#F3F4F6");
    });

   var type = window.location.hash.substr(1);
    if(type != undefined && type != '' ){
        var commentPosition =  'li-'+type;
        jQuery('html,body').animate({
              scrollTop: jQuery("#" + commentPosition).offset().top - 50
            },'slow');
        jQuery("#" + commentPosition).addClass('comment-highlights');
        setTimeout(function(){
            jQuery("#" + commentPosition).removeClass('comment-highlights');
        }, 15000);
    }
   /*show ideal media popup*/
   jQuery('.ideal-media').click(function(event) {
      console.log('1');
      jQuery('#popups').modal();
      return false;
   });    
   // jQuery(".comment-reply-link").click(function(e) {
   jQuery( "body" ).on( "click", ".comment-reply-link", function( e ) {
        e.preventDefault();
        var post_id = jQuery("#comment_post_ID").val();
        //post_id = id=post_id.replace("tag-list-price-", "");  
        comment_id = jQuery(this).siblings(".inner_comment_id").val();
        profile_image = jQuery(".codey").attr('src');
        var is_login = jQuery(".is_login").val();
        if(is_login != 0){
            if(comment_id != '' && post_id != ''){
               // var comment_url  = 'http://localhost/retirelynews/wp-comments-post.php'; 
                var comment_url = "https://www.retire.ly/wp-comments-post.php";
                var comment_box_width = jQuery(this).parents('.comment-avatar-block').width()-60;
                jQuery("#inner-comment-box").remove();
                
                var str = "<div id='inner-comment-box'><form class='comment-after-login' id='commentform' method='post' action='"+comment_url+"' onsubmit='return validateComment(this);' ><div class='wrap-comment'>";
                
                str +="<div class='avatar-block-img' style='background-image: none;'><img width='200' height='200' class='codey avatar avatar-200 photo' src='"+profile_image+"' style='height: inherit;'></div>";
                
                str += "<div class=avatar-coment' style='background: rgb(243, 244, 246) none repeat scroll 0% 0%;'> <textarea required='true' style='width:"+comment_box_width+"px'placeholder='Write a Comment.' aria-required='true' aria-describedby='form-allowed-tags' rows='8' cols='45' name='comment' class='comment_text_loggedin'></textarea></div>";
                
                str += "<div class='clear'></div><div class='form-submit-button'><a href='javascript:void(0)' class='cancel-box'>Cancel</a><input type='submit' value='Submit' class='sendmail-modal' name='submit'><input type='hidden' id='comment_post_ID' value='"+post_id+"' name='comment_post_ID'><input type='hidden' value='"+comment_id+"' id='comment_parent' name='comment_parent'></div>";
                str += "<input type='hidden' name='action' value='contact_form'>";

                str += "</div></form></div>";  
                var instance = jQuery(this).parents('.avatar-coment');
                
                jQuery(str).insertAfter(instance);
            }
        }else{
                var comment_url = "https://www.retire.ly/wp-comments-post.php";
                var comment_box_width = jQuery(this).parents('.comment-avatar-block').width()-60;
                jQuery("#inner-comment-box").remove();
                
                var str = "<div id='inner-comment-box'><form class='comment-form' id='commentform' method='post' action='"+comment_url+"'><div class='wrap-comment'>";
                
                str +="<div class='avatar-block-img' style='background-image: none;'><img width='200' height='200' class='codey avatar avatar-200 photo' src='"+profile_image+"' style='height: inherit;'></div>";
                
                str += "<div class=avatar-coment' style='background: rgb(243, 244, 246) none repeat scroll 0% 0%;'> <textarea   style='width:"+comment_box_width+"px' placeholder='Write a Comment.' aria-required='true' aria-describedby='form-allowed-tags' rows='8' cols='45' name='comment' class='comment_text'></textarea></div>";
                
                str += "<div class='clear'></div><div class='form-submit-button'><a href='javascript:void(0)' class='cancel-box'>Cancel</a><input type='submit' value='Submit' id='sendemail' name='submit'><input type='hidden' id='comment_post_ID' value='"+post_id+"' name='comment_post_ID'><input type='hidden' value='"+comment_id+"' id='comment_parent' name='comment_parent'></div>";
                str += "<input type='hidden' name='action' value='contact_form'>";

                str += "</div></form></div>";  
                var instance = jQuery(this).parents('.avatar-coment');
                
                jQuery(str).insertAfter(instance);
        }
     });
    
    jQuery( "body" ).on( "click", ".cancel-box", function( event ) {
        jQuery("#inner-comment-box").remove();
    });
   
    jQuery( "body" ).on( "click", ".comment_text, #comment", function( event ) {
       var is_login = jQuery(".is_login").val();
       if(is_login == 0){
            jQuery( ".ex1" ).trigger( "click" );
       }
    });
    
   jQuery( "body" ).on( "keydown", ".comment_text", function( event ) {
       var is_login = jQuery(".is_login").val();
       if(is_login == 0){
            return false;
       }
    });
    setTimeout(function(){ 
    var is_login = jQuery(".is_login").val();
    if(is_login == 0){
       
        jQuery( "body" ).on( "click", "#sendemail", function( event ) {
         event.preventDefault();
         var is_login = jQuery(".is_login").val();
         var post_id = jQuery("#comment_post_ID").val();
         //post_id = post_id.replace("tag-list-price-", "");  
         comment_id = jQuery(this).siblings(".inner_comment_id").val();
         if(is_login == 0){
             jQuery( ".ex1" ).trigger( "click" );
             // var comment_content =  jQuery(".comment_text").val();
             // jQuery(".comment-modal").val(comment_content);
         }
     });
    }
    }, 500);
    jQuery(".common-input").click(function() {
        var operation = jQuery(this).attr('data-opt');
        var comment_id = jQuery(this).attr('data-items');
        var is_login = jQuery('.is_login').val();
            if (operation != "" && comment_id != '' && is_login != 0 ) {
            //console.log(comment_id,operation);
            jQuery.ajax({
                type: "get",
                dataType: "json",
                url: myAjax.ajaxurl,
                data: {
                    action: "add_action_on_comment",
                    operation: operation,
                    comment_id: comment_id
                },
                beforeSend: function() {},
                success: function(response) {
                   // console.log(response);
                     if (response.res && response.update != undefined &&  response.update) {
                      jQuery(".count-"+comment_id).text(response.comment_counter);
                     } else if(response.res && response.insert != undefined && response.insert){
                        jQuery(".count-"+comment_id).text(response.comment_counter);
                     } else{
                        
                     }
                     if(operation == 'like'){
                        jQuery('.like-'+comment_id).removeClass('default-likes').addClass('likes-green');
                     }else{
                        jQuery('.like-'+comment_id).removeClass('likes-green').addClass('default-likes');
                     }
                     if(operation == 'dislike'){
                        jQuery('.dislike-'+comment_id).removeClass('default-dislikes').addClass('likes-red');
                     }else{
                        jQuery('.dislike-'+comment_id).removeClass('likes-red').addClass('default-dislikes');
                     }
                     jQuery(".count-"+comment_id);
                }
            });
            }else{
               // jQuery(".comment-sectn").before("<span class='login-message-like red-error-like'>Please login to like or dislike comment</span>");
               // jQuery('html,body').animate({
               //   scrollTop: jQuery(".comment-sectn").offset().top - 200
               // },'slow');
               // console.log('login to continue');
               jQuery(".news-container").hide();
               jQuery( ".ex1" ).trigger( "click" );
            }
        });     
    
    jQuery("#modal-login-form").click(function(e){
        e.preventDefault();
        var username = jQuery("#log").val();
        var password = jQuery("#pwd").val();

        if (username =='null' || username =='undefined' || username == '') {
            jQuery('#log').addClass('error-required');
        }else{
            jQuery('#log').removeClass('error-required');
        } 
        if (password =='null' || password =='undefined' || password == '') {
            jQuery('#pwd').addClass('error-required');
        } else {
            jQuery('#pwd').removeClass('error-required');
        }
        if(username == '' || password == ''){
            return false;
        }
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: myAjax.ajaxurl,
            data: { 
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': jQuery('#log').val(), 
                'password': jQuery('#pwd').val(), 
                },
            beforeSend: function() {
                  jQuery('.modal-login-error').hide();
                  //jQuery('#modal-login-form').attr('disabled','disabled');
            },    
            success: function(data){
                console.log(data,'1230');
                if (data.loggedin == false){
                    jQuery('.modal-login-error').show();
                }else{location.reload();
                   // window.location.href = jQuery('.modal_redirect_to').val();
                }
            },
            complete: function(data) {
             var result;    
                 try {
			     result = JSON.parse(data.responseText);
                }
				catch (e) {
                    location.reload();
                }             
                 //jQuery('#modal-login-form').removeAttr('disabled');
            }
        });
    });     

    jQuery(".my-login").click(function(){
    var username = jQuery("#log").val();
    var password = jQuery("#pwd").val();
   // console.log(username+' :username',password+' :password');
    if (username =='null' || username =='undefined' || username == '') {
        $('.username-error').show();
    }else{
        $('.username-error').hide();
    } 
    if (password =='null' || password =='undefined' || password == '') {
        $('.password-error').show();
    } else {
        $('.password-error').hide();
    }
   
    if(username != '' && password != ''){
        $('#login-form').submit();
    }else{
        return false;
    }

   });
  
    jQuery(".reg-btn").click(function(){
    var username = jQuery("#username").val();
    var password = jQuery("#pwd").val();
    var email = jQuery("#useremail").val();
    
    if (username =='null' || username =='undefined' || username == '' || username.length<4) {
        $('.username-error').show();
    }else{
        $('.username-error').hide();
    }
    if (password =='null' || password =='undefined' || password == '') {
        $('.password-error').show();
    } else {
        $('.password-error').hide();
    }
    if (email =='null' || email =='undefined' || email == '') { 
        $('.email-error').show();
    } else {
        $('.email-error').hide();
    }
    
    if(username != '' && password != '' && email != ''){
        if (/\s/g.test(username)) {
            $('.username-error-space').show();
	    return false;
        }else{
            $('#user-registration').submit();
        } 
    }else{
        return false;
    }
   });
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
    
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
    
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

jQuery('#template-category').ddslick({
        onSelected: function (data) {
            var inputIndex = data.selectedIndex;
            var val = data.selectedData.value;
            var urlVal = getUrlParameter('cat_id');
            var currentUrl = location.protocol + '//' + location.host + location.pathname;
            if(window.pageload=="pageload"){
                if ( urlVal!=val && inputIndex > 0) {
                    if(val > 0 || val=='top-gainer'){
                       window.location=currentUrl + '/?cat_id='+ val;
                    }
                    jQuery('#template-category').find(".dd-select").css({"background":"#ffffff","color":"#2b00f7"});
                    jQuery('#template-category').find("span").css({"border-top":"solid 5px #2b00f7"});
                }
                if(!inputIndex){
                   window.location = location.protocol + '//' + location.host;
                }
            }
            else{
                window.pageload="pageload";
            }
        }
    });
    jQuery("#template-category").on("click",function(){
        if(!jQuery(".dd-select").hasClass("visibleClass")){
            jQuery(".dd-select").addClass("visibleClass");
            if(!jQuery('.dd-options').is(':visible')){
                jQuery(".dd-select").css({"background":"","color":""});
                jQuery(".dd-select").find("span").css({"border-top":"solid 5px #2b00f7 !important"});
            }
            else if(jQuery('.dd-options').is(':visible')){
                jQuery(".dd-select").css({"background":"#2b00f7","color":"#ffffff"});
                jQuery(".dd-select").find("span").css({"border-top":"solid 5px #ffffff !important"});
            }

            jQuery("span").removeClass("open close");
            if(jQuery("span").hasClass("dd-pointer dd-pointer-down dd-pointer-up"))
                jQuery("span").addClass("open");
            else if(jQuery('.dd-select').find("span").hasClass("dd-pointer dd-pointer-down"))
                jQuery("span").addClass("close");
            else if(jQuery('.dd-select').find("span").hasClass("dd-pointer dd-pointer-up"))
                jQuery("span").addClass("close");
        }
        else{
            jQuery(".dd-select").removeClass("visibleClass");
            jQuery(".dd-select").find("span").css({"border-top":"solid 5px #2b00f7 !important"});
            jQuery(".dd-select").find("span").removeClass("open").removeClass("close");
        }
    });

    jQuery(".dd-select").mouseover(function(){  
        if(!jQuery(".dd-select").hasClass("visibleClass")){
            jQuery(".dd-select").css({"background":"#2b00f7","color":"#ffffff"});
            jQuery(".dd-select").find("span").css({"border-top":"solid 5px #ffffff"});              
        }
    });

    jQuery(".dd-select").mouseout(function(){
        if(!jQuery(".dd-select").hasClass("visibleClass")){
            jQuery(".dd-select").css({"background":"#ffffff","color":"#2b00f7"});
            jQuery(".dd-select").find("span").css({"border-top":"solid 5px #2b00f7"});
        }
    })
});    

jQuery(document).click(function(event) { 
    if(!jQuery(event.target).closest('#template-category').length &&
       !jQuery(event.target).is('#template-category')) {
        if(jQuery('#template-category').find(".dd-options").is(':visible')) {
            jQuery('.dd-selected').trigger("click");
            jQuery('#template-category').find(".dd-select").css({"background":"#ffffff","color":"#2b00f7"});
            jQuery('#template-category').find("span").css({"border-top":"solid 5px #2b00f7"});
        }
    }        
});
var resetChat;
function checkSubmit(e, param) {
    if (e && e.keyCode == 13) {
        if (param == 'start_chat') {
            jQuery('.user_vote').trigger('click');
        } else {
            jQuery('.send_msg').trigger('click');
        }
    }
}
var formatDate = (function() {
    function addZero(num) {
        return (num >= 0 && num < 10) ? "0" + num : num + "";
    }

    return function(dt, withTime) {

        var monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];

        var formatted = '';

        if (dt) {
            formatted = [monthShortNames[dt.getMonth()], addZero(dt.getDate()), dt.getFullYear()].join("-");
            if (withTime) {
                var hours24 = dt.getHours();
                var hours = ((hours24 + 11) % 12) + 1;
                formatted = [formatted, [addZero(hours), addZero(dt.getMinutes())].join(":"), hours24 > 11 ? "pm" : "am"].join(" ");
            }
        }
        return formatted;
    }
})();
(function($) {
    jQuery(document).ready(function($) {
      // window.newsfeed.init('.news-container',{domain:'social.retire.ly'}); 
       jQuery("#close-btn").click(function() {
            jQuery(".news-container").hide('slide', {
                direction: 'right'
            }, 500);
        });
        jQuery("#up-btn").click(function() {
            $(".pl-newsfeed__wrapper").animate({
                scrollTop: 0
            });
        });
        jQuery("#show-btn").click(function() {
            jQuery(".news-container").show('slide', {
                direction: 'right'
            }, 500);
            //jQuery(".pl-newsfeed__wrapper").css("height", jQuery(window).height() - 40);
           //jQuery(".pl-newsfeed__wrapper").css("height", 800);
        });

        jQuery(".chat-action").click(function() {
            jQuery(".chat-window").toggle();
            scTop();
        });

        jQuery(".user_vote").click(function() {
            var chaterName = jQuery('#name').val();
            var inputDate = formatDate(new Date(), true);
            if (chaterName != "") {
                jQuery.ajax({
                    type: "get",
                    dataType: "json",
                    url: myAjax.ajaxurl,
                    data: {
                        action: "add_guest_user",
                        chaterName: chaterName,
                        inputDate: inputDate
                    },
                    beforeSend: function() {},
                    success: function(response) {
                        //console.log(response.chatterName);
                        if (response.res) {
                            jQuery(".chat-form").hide();
                            jQuery("#msg_form").show();
                            jQuery("#response-div").show().html("Welcome to chat <span class='chatter-name'>" + response.chatterName + "</span>");
                            jQuery("#msg").focus();
                            jQuery("#sendername").val(response.chatterName);
                            setTimeout(function() {
                                jQuery("#response-div").fadeOut("normal", function() {});
                            }, 5000);
                        } else {
                            //alert("Your vote could not be added")
                        }
                    }
                });
            }
        });
        //Quick Campaign End
        function scTop() {
            jQuery(".msgs").animate({
                scrollTop: $(".msgs")[0].scrollHeight
            });
        }
        resetChat =  setInterval(function() {
            load_new_stuff();
        }, 3000);

        function load_new_stuff() {
            localStorage['lpid'] = jQuery(".msgs .msg:last").attr("title");
            var lastChatID = jQuery('#lastChatID').val();
            jQuery.ajax({
                type: "get",
                dataType: "json",
                crossDomain: true,
                url: myAjax.ajaxurl,
                data: {
                    action: "get_chat",
                    lastChatID: lastChatID
                },
                success: function(response) {
                    jQuery('.msg_loader').hide();
                    if (response.last_id != '') {
                        jQuery('#lastChatID').val(response.last_id);
                        if (jQuery('.msg').length) {
                            jQuery(".msg").last().after(response.msgs);
                        } else {
                            jQuery(".msgs").html(response.msgs);
                        }
                        scTop();
                    } else {
                        if (lastChatID == 0) {
                            jQuery(".old_msg").show();
                        } else {

                        }
                    }
                }
            })
        }
        jQuery(".send_msg").on("click", function() {
            t = jQuery(this);
            msg = jQuery("#msg").val();
            senderID = jQuery("#senderID").val();
            senderName = jQuery("#sendername").val();
            var inputDate = formatDate(new Date(), true);
            if (msg != "") {
                t.after("<span id='send_status'>Sending.....</span>");
                jQuery.ajax({
                    type: "get",
                    dataType: "json",
                    url: myAjax.ajaxurl,
                    data: {
                        action: "submit_message",
                        senderID: senderID,
                        senderName: senderName,
                        msg: msg,
                        inputDate: inputDate
                    },
                    success: function(response) {
                        load_new_stuff();
                        clearTimeout(resetChat);
                        resetChat =  setInterval(function() {
                            load_new_stuff();
                        }, 3000);
                        jQuery("#send_status").remove();
                        if (response.res) {
                            jQuery("#msg").val('');
                        } else {}
                    },
                });
            }
            return false;
        });
    });
})(jQuery);

