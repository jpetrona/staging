jQuery(document).ready(function(){
    jQuery('#postquerysubmit').click( function() {
        jQuery("body").prepend("<div style='display: none;' class='se-pre-con'></div>");
        var values = jQuery('[name="rsscheckbox[]"]:checked').length;
        var action = jQuery(".importrss").is(':checked');
        var ides = jQuery("#importRssData").val();
        var flag = false;
        jQuery('[name="rsscheckbox[]"]:checked').each(function(){
            if(ides==""){
                ides = jQuery(this).attr('itemJson');
            }else{
                ides = ides+'|RSS|'+jQuery(this).attr('itemJson');
            }
            flag = true;
        });
        var idestopic = jQuery("#rssFeedContext").val();
        var xResultString = '';
        jQuery('.topic').each(function(){
            if (jQuery(this).val() != ""){
                if(xResultString == ""){
                    xResultString = jQuery.trim(jQuery(this).val());
                }else{
                    xResultString = xResultString +','+ jQuery.trim(jQuery(this).val());
                }
            }
        });
        var idessource = jQuery("#rssFeedSource").val();
        var xResultSource = '';
        jQuery('.rsssource').each(function(){
            if (jQuery(this).val() != "" ){
                if(xResultSource == ""){
                    xResultSource = jQuery.trim(jQuery(this).val());
                }else{
                    xResultSource = xResultSource +','+ jQuery.trim(jQuery(this).val());
                }
            }
        })
        jQuery("#importRssData").val(ides);
        jQuery("#rssFeedContext").val(xResultString);
        jQuery("#rssFeedSource").val(xResultSource);
        if(!values){
            alert("Please select post to publish");
            return false; 
        }else if(flag){
            jQuery(".se-pre-con").show();
        }
    });
    
    jQuery("#selectedfeed").change(function(){ 
        if(jQuery(this).val() != '')
        window.location.href = 'admin.php?page=rss-top-handle&selectedfeed='+encodeURI(jQuery(this).val()) ;
    });

    jQuery('#addfeedbtn').click( function() {
        var title = jQuery('#title').val();
        var url = jQuery('#url').val();
        var flag = true;
        if(title == '' && url == ''){
            jQuery('#response_div').html('<p>Please enter Title and Url</p>');
        }else if(title == '' ){
            jQuery('#response_div').html('<p>Please enter Title </p>');
        }else if(url == ''){
            jQuery('#response_div').html('<p>Please enter Url</p>');
        } else {
            return true;
        }
        jQuery('#response_div').addClass('error');
        return false;          
    });
    jQuery('.commonpopup').click( function() {
        var data = jQuery(this).attr("itemJson");
        var json = jQuery.parseJSON(data);
        var anchorid = jQuery(this).attr('id');
        jQuery('#postthumbnail').val('');
        jQuery('.alert').removeClass('alert-success').html('').hide();
        jQuery(json).each(function(i,val){
         jQuery.each(val,function(k,v){
          if(k == 'title'){
            jQuery('#posttitle').val(v);
          }
          if(k == 'content'){
            content = v.replace(/(\r\n|\n|\r)/gm,"");
            jQuery('#content').val(content);
          }
          if(k == 'image'){
            jQuery('#feed_image').val(v);
          }
          if(k == 'imageUrlAlternate'){
            jQuery('#feed_image_alternate').val(v);
          }
          jQuery('#feed_id').val(anchorid);
         });
        });
        jQuery('#myModal').modal('show');
    });
    
    jQuery("#posteditform").validate ({
        rules: {
            posttitle: {
                required: true
            },
            content :{
                required: true
            },
            upload_image:{
                required: true
            },
            topic:{
                required:true
            },
            source:{
                required:true
            }
        },
        messages: {
            posttitle:{
               required:"Please enter post title"
            },
            content :{
                required:"Please enter post content"
            },
            upload_image:{
                required:"Please select post image"
            },
            topic:{
                required:"Please select context"
            },
            source:{
                required:"Please select source"
            }
        },
        submitHandler: function ( form ) {
            jQuery("body").prepend("<div style='display: none;' class='se-pre-con'></div>");
            jQuery(".se-pre-con").show();
            form.submit ();
        }
    });
    
    
});

function checkRss(){
    var selectedfeed = jQuery("#selectedfeed option:selected").val();
    var status = true;
    if(selectedfeed==""){
        jQuery('#error_feed').html('Please select an option');
        status = false;
    }else{
        jQuery('#error_feed').html('');
    }
    return status;       
}

