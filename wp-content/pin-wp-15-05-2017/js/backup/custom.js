function slide( self ){
    window.location.href = self.href;
    console.log(self);
}


(function($){
    /*  for all post Facebook and linkedin */
     $.fn.iconhover = function(){
                         $("#boxed-style ul.masonry_list li").on({
                                mouseenter: function () { 
                                   
                                      $(this).find(".the_champ_sharing_container.the_champ_horizontal_sharing").show();
                                },
                                mouseleave: function () {
                                   $( this ).find(".the_champ_sharing_container.the_champ_horizontal_sharing").hide();
                                }
                          });
                       }
})(jQuery);


jQuery(document).ready(function( $ )
{
    

        jQuery.ajax({
          url: ajaxurls,
          data: {
              'action':'ajax_for_notification_comments',
              'user' :  $("#user_for_notification").val(),
              'save': 0
          },
          success:function(data) {
                var arr_data = jQuery.parseJSON(data);
                if( arr_data.length == 1 || typeof arr_data[0]['link'] == 'undefined' || parseInt(arr_data[0]['count']) == 0 )
                {
                    $("#notification_count").hide();
                      jQuery("#notificationsBody").html(''); 
                }
                else
                {

                    $("#notification_count").text( arr_data[0]['count'] ); 
                    $("#notification_count").show();    

                }
          },
          error: function(errorThrown){
              console.log(errorThrown);
          }
      });    

    var offset = 0;
$("#notificationLink").click(function(){
        if( $("#notificationContainer").css("display") == "none" ){
        //  var src = $("#loader_cover").attr("src");
    //   $("#notificationsBody").html('<div id="notificationsBody-loader" ><img id="loader_cover" title="Loading...." alt="Loading...." src="'+src+'"></div>');
      }
        
        jQuery.ajax({
          url: ajaxurls,
          data: {
              'action':'ajax_for_notification_comments',
              'user' :  $("#user_for_notification").val(),
              save: 1
          },
          success:function(data) {
                var arr_data = jQuery.parseJSON(data);
                 if( arr_data.length == 1 || typeof arr_data[0]['link'] == 'undefined' )
                {
                    jQuery("#notificationsBody").html(''); 
                    $("#notification_count").hide();
                    jQuery("#notificationFooter").html(arr_data[0]["comments_in_short"]);
                }
                else
                {
                  if( parseInt(arr_data[0]['count']) != 0 )
                 { $("#notification_count").text( arr_data[0]['count'] );
                   $("#notification_count").show();
                 }
                 else{
                  $("#notification_count").text('');
                  $("#notification_count").hide();
                 }
                jQuery("#notificationsBody").html(''); 
                var read_class;
                arr_data.forEach(function( element , index , value ){ //<div class='comment-title'>"+ arr_data[index]['name']+" commented on your post</div>
                  if( parseInt( arr_data[index]['read'] ) )
                  {
                       read_class = "comment-read";
                  }
                  else{
                       read_class = "comment-unread";
                  }
                   
                  var html = "<div  class='content  "+ read_class +"' ><a style='width:93%;' href='"+arr_data[index]['link']+"'  onClick='slide(this); return false;' ><div class='notificationimage'>"+arr_data[index]['avatar']+"</div><div class='notifyuser'>"+arr_data[index]['name']+"</div><div style='clear:both'></div><div class='notificationcontent'>commented on your post «" + arr_data[index]["comments_in_short"] + "»</div></a></div>";
                  
                jQuery("#notificationsBody").append( html );
                });
            }
          },
          error: function(errorThrown){
              console.log(errorThrown);
          }
      });
  $("#notificationContainer").fadeToggle(300);
  $("#notification_count").fadeOut("slow");
return false;
});
 
$("#notificationFooter").click(function(){
    $("#notificationContainer").show();
        offset += 5;
        if( $("#notificationContainer").css("display") == "none" ){
            //  var src = $("#loader_cover").attr("src");
            //   $("#notificationsBody").html('<div id="notificationsBody-loader" ><img id="loader_cover" title="Loading...." alt="Loading...." src="'+src+'"></div>');
        }

        jQuery.ajax({
            url: ajaxurls,
            data: {
                'action':'ajax_for_notification_comments',
                'user' :  $("#user_for_notification").val(),
                'save': 1,
                'offset':offset
            },
            success:function(data) {
                var arr_data = jQuery.parseJSON(data);
                if( arr_data.length == 1 || typeof arr_data[0]['link'] == 'undefined' )
                {
                    jQuery("#notificationsBody").html('');
                    $("#notification_count").hide();
                    jQuery("#notificationFooter").html(arr_data[0]["comments_in_short"]);
                }
                else
                {
                    if( parseInt(arr_data[0]['count']) != 0 )
                    { $("#notification_count").text( arr_data[0]['count'] );
                        $("#notification_count").show();
                    }
                    else{
                        $("#notification_count").text('');
                        $("#notification_count").hide();
                    }
                    jQuery("#notificationsBody").html('');
                    var read_class;
                    arr_data.forEach(function( element , index , value ){ //<div class='comment-title'>"+ arr_data[index]['name']+" commented on your post</div>
                        if( parseInt( arr_data[index]['read'] ) )
                        {
                            read_class = "comment-read";
                        }
                        else{
                            read_class = "comment-unread";
                        }

                        var html = "<div  class='content  "+ read_class +"' ><a style='width:93%;' href='"+arr_data[index]['link']+"'  onClick='slide(this); return false;' ><div class='notificationimage'>"+arr_data[index]['avatar']+"</div><div class='notifyuser'>"+arr_data[index]['name']+"</div><div style='clear:both'></div><div class='notificationcontent'>commented on your post «" + arr_data[index]["comments_in_short"] + "»</div></a></div>";

                        jQuery("#notificationsBody").append( html );
                    });
                }
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
        return false;
    });


$("#notificationFooter").find('a').html('Click to see more comments');




$(document).click(function()
{
    offset = 0;
jQuery("#notificationsBody").html('');    

if( $("#notificationContainer").css('display') != 'none' )
{ 
  $("#notification_count").hide();
  $("#notificationContainer").hide(); 
}
 
});

$("#notificationTitle").click(function()
{
jQuery("#notificationsBody").html('');    

if( $("#notificationContainer").css('display') != 'none' )
{ 
  $("#notification_count").hide();
  $("#notificationContainer").hide(); 
}
});

/*
$("#notificationContainer").click(function()
{
return false;
});*/

});




function cmp(s, word){
  return new RegExp( '\\b' + word + '\\b', 'i').test(s);
}



(function($){

    $.fn.myajax = function(){
     $('div[name="trig"]').each(function(){ //input[class=tag-list]
            var self = this;
            var tags = $(this).find("input").val(); 
            var string;
            var button_border_color; 
            var class_hover;
        if( $(this).next(".thumbnail-transparent-bar").is(":hidden") )
            {
           if( tags.length > 0 && !cmp ( tags , "business" ) && !cmp ( tags ,"World") && !cmp ( tags , "AppConomy") && !cmp ( tags , "Politics") && !cmp ( tags , "finTech") && !cmp ( tags , "Financial") && !cmp ( tags , "featured") && !cmp( tags ,"Advisor") && !cmp( tags ,"Seeking") && !cmp( tags ,"Retirement")  && !cmp( tags ,"Investing")  && !cmp( tags ,"International") && !cmp( tags , "FinSports") )
            {
            var url = 'http://query.yahooapis.com/v1/public/yql?q=select * from yahoo.finance.quotes where symbol in ('+tags+')&env=http://datatables.org/alltables.env&format=json';
              $.get(url, function(data){
                     var x = data['query']['results'].quote;
                     if(Array.isArray(x))
                     {
                        var x =data['query']['results']['quote']; 
                        var count  = 0;
                        x.forEach(function logArrayElements(element, index, array) {
                            if( count < 2 )
                            {
                                 
                                if( array[index].LastTradePriceOnly != null && array[index].PercentChange !=  null )
                                {
                                    count++;
                                   
                                    if( array[index].PercentChange.indexOf("+") > -1  )
                                    {
                                        string = array[index].LastTradePriceOnly+"&nbsp;&nbsp;<span>"+array[index].PercentChange+"</span>";
                                        class_hover = "tag-format-green-hover";
                                     
                                    }
                                    else
                                    {
                                        string = array[index].LastTradePriceOnly+"&nbsp;&nbsp;<span>"+array[index].PercentChange+"</span>";
                                        class_hover = "tag-format-red-hover";
                                       
                                    }
                                    $(self).next(".thumbnail-transparent-bar").show();
                                    
                                    $(self).append('<button class="tag-format '+class_hover+'" title="'+array[index].Name+'" >&nbsp;'+ array[index].symbol +" "+ string +'&nbsp;</button>');
                                }
                            }                            
                        });
                    }
                    else
                    {
                           
                        if( x.LastTradePriceOnly != null && x.PercentChange != null )
                        {
                            
                            if( x.PercentChange.indexOf("+") > -1  )
                            {
                                string = x.LastTradePriceOnly+"&nbsp;&nbsp;<span>"+x.PercentChange+"</span>";
                                class_hover = "tag-format-green-hover";
                            }
                            else
                            {
                                string = x.LastTradePriceOnly+"&nbsp;&nbsp;<span>"+x.PercentChange+"</span>";
                                class_hover = "tag-format-red-hover";
                            }
                            $(self).next(".thumbnail-transparent-bar").show();
                            $(self).append('<button class="tag-format '+class_hover+'" title="'+x.Name+'" >&nbsp;'+ x.symbol +" "+ string +'&nbsp;</button>');
                        }
                       
                    }
             });
          }
       }
      });
   }
})(jQuery);



  jQuery( document ).ajaxComplete(function( event, request, settings  ){

  if( settings.url.indexOf("page") > -1 )
  {
      $ = jQuery;
        $(document).myajax();
      
        $(document).iconhover();


  }
  
});




jQuery( document ).ready( function( $ ) {
"use strict";


     $(document).myajax();  
     $(document).iconhover(); 
      
    /////////////////////////////////
    // Slider Featured Articles
    /////////////////////////////////
    jQuery(".featured-articles-slider").hide().css({'left' : "0px"}).fadeIn(1000); // fade effect for images, lovely.
    jQuery('.featured-articles-slider').bxSlider({
            slideWidth: 300,
            minSlides: 1,
            maxSlides: 10,
            auto: true,
            autoHover: true,
            nextSelector: '#slider-next',
            prevSelector: '#slider-prev',
            nextText: '<i class="fa fa-chevron-right"></i>',
            prevText: '<i class="fa fa-chevron-left"></i>',
            slideMargin: 0,
            controls: true,
            autoControls: true
          }); 

    /////////////////////////////////
    // Slider Random Articles Footer
    /////////////////////////////////
    jQuery(".random-articles-slider").hide().css({'left' : "0px"}).fadeIn(1000); // fade effect for images, lovely.
    jQuery('.random-articles-slider').bxSlider({
            slideWidth: 300,
            minSlides: 1,
            maxSlides: 10,
            auto: true,
            autoHover: true,
            nextSelector: '#slider-next2',
            prevSelector: '#slider-prev2',
            nextText: '<i class="fa fa-chevron-right"></i>',
            prevText: '<i class="fa fa-chevron-left"></i>',
            slideMargin: 0,
            controls: true,
            autoControls: true
          }); 

    /////////////////////////////////
    // Accordion 
    /////////////////////////////////       
    jQuery(".accordionButton").click(function(){jQuery(".accordionButton").removeClass("on");jQuery(".accordionContent").slideUp("normal");if(jQuery(this).next().is(":hidden")==true){jQuery(this).addClass("on");jQuery(this).next().slideDown("normal")}});jQuery(".accordionButton").mouseover(function(){jQuery(this).addClass("over")}).mouseout(function(){jQuery(this).removeClass("over")});jQuery(".accordionContent").hide(); 

    /////////////////////////////////
    // Go to TOP
    /////////////////////////////////
    // hide #back-top first
    jQuery("#back-top, .prev-articles").hide();
    
    // fade in #back-top
    jQuery(function () {
        jQuery(window).scroll(function () {
            if (jQuery(this).scrollTop() > 100) {
                jQuery('#back-top, .prev-articles').fadeIn();
            } else {
                jQuery('#back-top, .prev-articles').fadeOut();
            }
        });

        // scroll body to 0px on click
        jQuery('#back-top a').click(function () {
            jQuery('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });

    /////////////////////////////////
    // Sticky Header
    /////////////////////////////////
    /*var stickyNavTop = jQuery('.sticky-on').offset().top;
    var stickyNav = function(){  
    var scrollTop = jQuery(window).scrollTop() > 300;  
           
    if (scrollTop > stickyNavTop) {   
        jQuery('.sticky-on').addClass('stickytop');  
    } else {  
        jQuery('.sticky-on').removeClass('stickytop');   
    }  
    };  
    stickyNav();  
    jQuery(window).scroll(function() { stickyNav(); });
    $(document).ready(function(){
	$(window).scroll(function(){
		if($(window).scrollTop() > 1){
			//$('.jumbotron').css('padding-top', '106px');
			
			$('.sticky-on').addClass('stickytop') ;
			
			
		}else if($(window).scrollTop() < 1){
			//$('.jumbotron').css('padding-top', '55px');
			
			$('.sticky-on').removeClass('stickytop');
			
		};
	});
	
	});*/
}); // jQuery(document).