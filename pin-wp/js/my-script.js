jQuery(document).ready(function() {
 /*This script is used for top Gainer start here*/	
 jQuery( '.fep-featured-image-link' ).click ( function ( e ) {
		var myclass = jQuery(this).attr('id');
		e.preventDefault ();
		custom_uploader = wp.media.frames.file_frame = wp.media ( {
			title: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false
		} );
		custom_uploader.on ( 'select', function () {
			attachment = custom_uploader.state ().get ( 'selection' ).first ().toJSON ();
			jQuery ( '#featured-image-'+myclass).val ( attachment.id );
			jQuery ( '#uploader1' ).val ( attachment.filename );
			jQuery ( '#postimage-'+myclass).append('<img src='+attachment.sizes.thumbnail.url+'>');
			/*jQuery.ajax ( {
				type: 'POST',
				url: fepajaxhandler.ajaxurl,
				data: {
					action: 'fep_fetch_featured_image',
					img: attachment.id
				},
				success: function ( data, textStatus, XMLHttpRequest ) {
					
				},
				error: function ( MLHttpRequest, textStatus, errorThrown ) {
					alert ( errorThrown );
				}
			} );*/
		} );
		custom_uploader.open ();
	} ); 
        jQuery( '.expert-button-image-link' ).click ( function ( e ) {
		var myclass = jQuery(this).attr('id').replace("expert-button-", "");
		e.preventDefault ();
		custom_uploader = wp.media.frames.file_frame = wp.media ( {
			title: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false
		} );
		custom_uploader.on ( 'select', function () {
			attachment = custom_uploader.state ().get ( 'selection' ).first ().toJSON ();
			jQuery ( '#expert-image-button-'+myclass).val ( attachment.id );
			jQuery ( '.expertimg').empty();
			jQuery ( '#expertimage-button-'+myclass).append('<img src='+attachment.sizes.thumbnail.url+'>');
		} );
		custom_uploader.open ();
	} );
	jQuery("#post_tags").change(function () {
		var selectedText = jQuery(this).find("option:selected").text();
		var selectedValue = jQuery(this).val();
		jQuery('#stockname').val(selectedText);
	});  
    jQuery("#toplevel_page_frondend-handle").find(".wp-submenu-wrap").hide();
    /*This script is used for top Gainer end here*/

    /*Rss feed script start here*/
    jQuery( '#upload_image_button' ).click ( function ( e ) {
		var myclass = jQuery(this).attr('id');
		e.preventDefault ();
		custom_uploader = wp.media.frames.file_frame = wp.media ( {
			title: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false
		} );
		custom_uploader.on ( 'select', function () {
			attachment = custom_uploader.state ().get ( 'selection' ).first ().toJSON ();
			jQuery ( '#upload_image' ).val ( attachment.id );
			jQuery ( '#uploader1' ).val ( attachment.filename );
			jQuery ( '.thumbnailshow').append('<img src='+attachment.sizes.thumbnail.url+'>');
			/*jQuery.ajax ( {
				type: 'POST',
				url: fepajaxhandler.ajaxurl,
				data: {
					action: 'fep_fetch_featured_image',
					img: attachment.id
				},
				success: function ( data, textStatus, XMLHttpRequest ) {
					
				},
				error: function ( MLHttpRequest, textStatus, errorThrown ) {
					alert ( errorThrown );
				}
			} );*/
		} );
		custom_uploader.open ();
	} );
    /*Rss feed script end here*/

  jQuery(function(){
    	var menu = true;
	    // this will get the full URL at the address bar
	    var getUrlParameter = function getUrlParameter(sParam) {
	    console.log('as');
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
	    var url = window.location.href; 
	    var urlVal = getUrlParameter('market');
	    var urlPage = getUrlParameter('page');
	    // passes on every "a" tag 
	    jQuery(".btn-default").each(function() {
	        // checks if its the same on the address bar
	        if(url == (this.href)) { 
                      jQuery(this).removeClass("btn-default").addClass("btn-primary");
	        }
	        if(urlPage == 'frondend-handle' && urlVal == undefined && menu){
                     jQuery(this).removeClass("btn-default").addClass("btn-primary"); 
	        	menu = false;
	        }
	    });
	});

});
