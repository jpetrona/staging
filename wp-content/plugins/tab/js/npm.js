// // This file is autogenerated via the `commonjs` Grunt task. You can require() this file in a CommonJS environment.

// require('../../js/transition.js')

// require('../../js/alert.js')

// require('../../js/button.js')

// require('../../js/carousel.js')

// require('../../js/collapse.js')

// require('../../js/dropdown.js')

// require('../../js/modal.js')

// require('../../js/tooltip.js')

// require('../../js/popover.js')

// require('../../js/scrollspy.js')

// require('../../js/tab.js')

// require('../../js/affix.js')
      function press( e ) {

      var evt = e || window.event
      // "e" is the standard behavior (FF, Chrome, Safari, Opera),
      // while "window.event" (or "event") is IE's behavior
      if ( evt.keyCode === 13 ) {
          // Do something
            var fruit = jQuery("#new_profile_name").val() ;
      // This does the ajax request
      jQuery.ajax({
          url: UpdateAjaxObj.ajaxurl,
          data: {
              'action':'example_ajax_request',
              'fruit' : fruit
          },
          success:function(data) {
              // This outputs the result of the ajax request
              jQuery("#new_profile_name").remove();
              
          jQuery("#name_update1").show();
              jQuery(".avatar-name-prfl-content").text( data );
              console.log(data);
          },
          error: function(errorThrown){
              console.log(errorThrown);
          }
      }); 
          // You can disable the form submission this way:
          return false
      }
    }
 
         function press_first_last( e ) {

      var evt = e || window.event
      // "e" is the standard behavior (FF, Chrome, Safari, Opera),
      // while "window.event" (or "event") is IE's behavior
      if ( evt.keyCode === 13 ) {
           var fruit = jQuery("#new_profile_firstname").val();
      var last_name = jQuery("#new_profile_lastname").val()
      // This does the ajax request
      jQuery.ajax({
          url: UpdateAjaxObj.ajaxurl,
          data: {
              'action':'firstname_change_ajax_request',
              'fruit' : fruit ,
              'last_name' : last_name
          },
          success:function(data) {
              // This outputs the result of the ajax request
              jQuery("#new_profile_firstname").remove();
              jQuery("#new_profile_lastname").remove();
              
              jQuery("#firstname_submit").hide();
        jQuery("#firstname_edit").show();
        var str = data.split(",");
              jQuery("#firstname").text( str[0] );
              jQuery("#lastname").text( str[1] );
              console.log(data);
          },
          error: function(errorThrown){
              console.log(errorThrown);
          }
      }); 
   
          // You can disable the form submission this way:
          return false
      }
    }

    jQuery(document).ready(function($) {
  	if (typeof jQuery === 'undefined') {
  	  throw new Error('Bootstrap\'s JavaScript requires jQuery')
  	}
     
  
  		jQuery("#name_update1").show();
  		jQuery("#firstname_submit").hide();
  		jQuery("#firstname_edit").show();


  		 


  	jQuery("#name_update1").click(function(){
  	    var name = jQuery(".avatar-name-prfl-content").text();
        name = jQuery.trim(name); 
  	    jQuery(".avatar-name-prfl-content").empty();
  	    jQuery(".avatar-name-prfl").append('<input type="text" id="new_profile_name" onfocus="this.value = this.value;" value="'+name+'" onkeydown="return press( event );">');
  	    jQuery('#new_profile_name').focus();
  	   
  	    jQuery("#name_update1").hide();
  	});
  	 
  	 jQuery(document).on('blur','#new_profile_name',function(){
        var name;
        var $object = jQuery('#new_profile_name');
        if($object.length) {
          
           name = jQuery('#new_profile_name').val();
           name = jQuery.trim( name);
            
           jQuery( '#new_profile_name' ).remove();
           jQuery(".avatar-name-prfl-content").text(name);
           // there's at least one matching element

            jQuery.ajax({
                url: UpdateAjaxObj.ajaxurl,
                data: {
                    'action':'example_ajax_request',
                    'fruit' : name
                },
                success:function(data) {
                    // This outputs the result of the ajax request
                    jQuery("#new_profile_name").remove();

                    jQuery("#name_update1").show();
                    jQuery(".avatar-name-prfl-content").text( data );
                    console.log(data);
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });
        }
        jQuery("#name_update1").show();
     });//new_profile_firstname

      jQuery(document).on('blur','#new_profile_firstname',function(){
        var name;
        var $object = jQuery('#new_profile_firstname');
        if($object.length) {
          
           name = jQuery('#new_profile_firstname').val();
           name = jQuery.trim( name);
           
           jQuery( '#new_profile_firstname' ).remove();
           jQuery("#firstname").text(name);
           // there's at least one matching element
        }
        jQuery("#firstname_edit").show();


          jQuery.ajax({
              url: UpdateAjaxObj.ajaxurl,
              data: {
                  'action':'firstname_change_ajax_request',
                  'fruit' : name 
              },
              success:function(data) {
                  // This outputs the result of the ajax request
                  jQuery("#new_profile_firstname").remove();
                  jQuery("#new_profile_lastname").remove();

                  jQuery("#firstname_submit").hide();
                  jQuery("#firstname_edit").show();
                  var str = data.split(",");
                  jQuery("#firstname").text( str[0] );
                  jQuery("#lastname").text( str[1] );
                  console.log(data);
              },
              error: function(errorThrown){
                  console.log(errorThrown);
              }
          });
      });//
   	
    	jQuery("#firstname_edit").click(function(){
  	    var name = jQuery("#firstname").text();

        name = jQuery.trim(name);
        
  	    jQuery("#firstname").empty();
  	    jQuery("#firstname").append('<input type="text" id="new_profile_firstname" value="'+name+'" onkeydown="return press_first_last( event );" style="width:316px;">');
  	    jQuery('#new_profile_firstname').focus();
        jQuery("#new_profile_firstname").val(jQuery("#new_profile_firstname").val());
  	    jQuery("#firstname_submit").show();
  	    jQuery("#firstname_edit").hide();

  	    var lastname = jQuery("#lastname").text();
          lastname = jQuery.trim(lastname);
       
  	    jQuery("#lastname").empty();
  	   // jQuery("#lastname").append('<input type="text" id="new_profile_lastname" value="'+lastname+'" onkeydown="return press_first_last( event );" >');
  	 
  	});

        /***************code for croping image  ***********************/

        var client = new XMLHttpRequest();
        var formData = new FormData();
        var file;
        var img = new Image;

        client.onreadystatechange = function () {
            if (client.readyState == 4) {
                console.log(client.responseText);
                var name = jQuery.trim(client.responseText);
                jQuery(".prfl-box").css("background-image", 'url("' + name + '?v=' + jQuery.now() + '")');
                jQuery(".prfl-box").css("background-size", "cover");
                jQuery("#loader_cover").hide();
                try {
                    var resp = client.response;
                    console.log(client.responseText);
                } catch (e) {
                    var resp = {
                        status: 'error',
                        data: 'Unknown error occurred: [' + client.responseText + ']'
                    };
                }
                console.log(resp.status + ': ' + resp.data);
                img.src = name + '?v=' + jQuery.now();

            }
        };
        /***************code for coverimage upload ***********************/


        //jQuery(".coverimage-upload").hide();
        jQuery("#uploadimage").click(function () {
            $(".coverimage-upload").trigger("click");
        });
	    jQuery(document).on('click', '#coverimage', function (event) {
		    this.value = null;
	    });
        jQuery(document).on('change', '#coverimage', function (event) {
            var id = this.id;
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById(id).files[0]);
            oFReader.onload = function (oFREvent) {

                jQuery('#image-crop-drag').attr("src", oFREvent.target.result);

                var image = new Image();
                image.onerror = function(){
                    alert("Unknown file");
                };
                image.onload = function () {
                    if (this.width < 900) {
                        alert("Image width should 900");
                    }
                    else {


                        formData.append("original_width", this.width);
                        formData.append("original_height", this.height);
                        var dialogbox_x = 0;
                        var dialogbox_y = 0;
                        jQuery('#image-crop').dialog({
                            //height: this.height + 200,  //500
                          //  width: this.width + 25, //500
                            height:500,
                            width:900,
                            modal: true,
                            close: function (event) {
                                jQuery(this).parent().parent().parent().find('.ui-dialog-titlebar-close').show();
                                $('#image-crop').html('');
                                $("#image-crop").html('<div id="image-crop-drag-div"><div id="image-crop-drag-cor-start"></div><div id="image-crop-drag-cor-bottom" ></div><img id="image-crop-drag" src=""  /></div>');
                            },
                            open: function (event, ui) {
                                var o = jQuery(this).offset();
                                dialogbox_x = o.left;
                                dialogbox_y = o.top;
                                jQuery(this).parent().parent().parent().find("button").addClass(".image-crop-button");
                                jQuery(this).parent().parent().parent().find('.ui-dialog-titlebar').css("background","transparent");
                                jQuery(this).parent().parent().parent().find('.ui-dialog-titlebar').css("border","none");
                                //jQuery(this).parent().parent().parent().find('.ui-dialog-titlebar').css("background-color","none");
                                jQuery(this).parent().parent().parent().find('.ui-dialog-titlebar-close').hide();
                            },
                            buttons: [
                                {
                                    text:"Crop the Image",
                                    class:"image-crop-button",
                                    click: function () {

                                    client.open("post", jQuery("#siteurl").val(), true);
                                    client.send(formData);
                                    jQuery("#loader_cover").show();

                                    $(".imgareaselect-selection").parent().remove();
                                    $(".imgareaselect-outer").remove();
                                    jQuery('#image-crop').dialog("close");

                                    console.log("create an account");
                                }
                            },
                            {
                                text:"Cancel",
                                class:"image-crop-button",
                                click: function () {
                                    $(".imgareaselect-selection").parent().remove();
                                    $(".imgareaselect-outer").remove();
                                    jQuery('#image-crop').dialog("close");
                                }
                            }]
                        });

                        jQuery('img#image-crop-drag').imgAreaSelect({
                            //  aspectRatio: '3:1',
                            handles: true,
                            maxWidth:934,
                            onSelectStart: function( i , e ){
                            },
                            onSelectChange:function(i, e ){
                                $("#image-crop-drag-cor-bottom").show();
                                $("#image-crop-drag-cor-start").show();
                                var left_bottom =  e.x2 - $("#image-crop-drag-cor-bottom").width();
                                var top =  e.y1  - $("#image-crop-drag-cor-start").height();

                                $("#image-crop-drag-cor-start").css({"top": top,"left": e.x1 });
                                $("#image-crop-drag-cor-bottom").css({"top": e.y2 ,"left": left_bottom });
                                //$("#image-crop-drag-cor-bottom").css({"top": e.y2 ,"left": e.x2 });
                                $("#image-crop-drag-cor-start").html(e.x1 +","+e.y1);
                                $("#image-crop-drag-cor-bottom").html(e.x2 +","+e.y2);
                            },
                            cancelSelection:function(){
                                $("#image-crop-drag-cor-start").hide();
                                $("#image-crop-drag-cor-bottom").hide();
                            },
                            onSelectEnd: function (i, e) {
                                formData.append("x", e.x1);
                                formData.append("y", e.y1);
                                formData.append("w", e.width);
                                formData.append("h", e.height);

                                /* Send to server */
                            },
                            parent: '#image-crop-drag-div'
                        });

                        jQuery("#image-crop-drag").show();
                    }
                    // access image size here & do further implementation
                };
                image.src = oFREvent.target.result;

                //  jQuery('#image-crop').dialog("open");


                document.getElementsByClassName("photo").src = oFREvent.target.result;
                file = document.getElementById(id);


                /* Create a FormData instance */

                /* Add the file */
                formData.append("uid", jQuery("#userid").val());
                formData.append("upload", file.files[0]);


                //client.setRequestHeader("Content-Type", "multipart/form-data");


            };

        });
              

 	});

// left: 37, up: 38, right: 39, down: 40,
// spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
var keys = {37: 1, 38: 1, 39: 1, 40: 1};

function preventDefault(e) {
    e = e || window.event;
    if (e.preventDefault)
        e.preventDefault();
    e.returnValue = false;
}

function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
        preventDefault(e);
        return false;
    }
}

function disableScroll() {
    if (window.addEventListener) // older FF
        window.addEventListener('DOMMouseScroll', preventDefault, false);
    window.onwheel = preventDefault; // modern standard
    window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
    window.ontouchmove  = preventDefault; // mobile
    document.onkeydown  = preventDefaultForScrollKeys;
}

function enableScroll() {
    if (window.removeEventListener)
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
    window.onmousewheel = document.onmousewheel = null;
    window.onwheel = null;
    window.ontouchmove = null;
    document.onkeydown = null;
}

