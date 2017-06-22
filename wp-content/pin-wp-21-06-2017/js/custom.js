function slide( self ){
    window.location.href = self.href;
//    console.log(self);
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
                  var html = "<div  class='content  "+ read_class +"' ><a style='width:93%;' href='"+arr_data[index]['link']+"'  onClick='slide(this); return false;' ><div class='notificationimage'>"+arr_data[index]['avatar']+"</div><div class='notifyuser'>"+arr_data[index]['name']+"</div><div style='clear:both'></div><div class='notificationcontent'>commented on your post &#171; " + arr_data[index]["comments_in_short"] + " &#187;</div></a></div>";       
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

                        var html = "<div  class='content  "+ read_class +"' ><a style='width:93%;' href='"+arr_data[index]['link']+"'  onClick='slide(this); return false;' ><div class='notificationimage'>"+arr_data[index]['avatar']+"</div><div class='notifyuser'>"+arr_data[index]['name']+"</div><div style='clear:both'></div><div class='notificationcontent'>commented on your post &#171; " + arr_data[index]["comments_in_short"] + " &#187;</div></a></div>";

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
function numberDiff (a, b)
 {
  return eval(a - b) 
 }

/*Start Insutument graph for featured post*/
(function($){

    $.fn.featuredajax = function(){
     $('div[name="trig_featured"]').each(function(){
        var self = this;
        var tags = $(this).find("input").val();
        var featured_post_id = $(this).find(".featured_post_id").val();
        tags = tags.replace(/['"]+/g, '');
        var url = 'https://finance.google.com/finance/info?client=ig&q='+tags;
        var request = jQuery.ajax({
          url: url,
          type:'GET',
          dataType: 'jsonp',
          success: function(data) {
                if( data[0].t != null &&  data[0].l_fix != null ){
                    var stock_cp_fix = data[0].cp_fix != '' ? data[0].cp_fix : '0.00' ;
                    var stock_c = data[0].c != '' ? data[0].c : '0.00' ; 
                    if( data[0].c.indexOf("+") > -1  ){
                        string = "<span class='lastpriceh'>"+data[0].l_fix+"</span>&nbsp;&nbsp;<span class='percentageh'>"+stock_cp_fix+"%</span>";
                        class_hover = "tag-format-green-hover";
                        arrowimage = '<img src="wp-content/themes/pin-wp/images/arrow_green.png" style="width:16px; margin-left: 30px;">';
                    }else{
                        string = "<span class='lastpriceh'>"+data[0].l_fix+"</span>&nbsp;&nbsp;<span class='percentageh'>"+stock_cp_fix+"%</span>";
                        class_hover = "tag-format-red-hover";
                        arrowimage = '<img src="wp-content/themes/pin-wp/images/arrow_red.png" style="width:16px; margin-left:30px;">';
                    }
                    jQuery('.custom-instrument').addClass('instrument-container');
                    jQuery('.instrument-'+featured_post_id).html('<button class="tag-format '+class_hover+'" title="'+data[0].t+'" >&nbsp;'+ data[0].t +" "+ string +'&nbsp;</button>'+arrowimage);
                    //jQuery('#'+stockpricecontainer).text(data[0].l);
                    //jQuery('#'+percentagechangecontainer).text(data[0].cp+'%');
                    jQuery('#'+called_by).addClass('testing').val('google-finance');
                    jQuery('.'+rightsidesecond+'_featured_post_id').val(stock_c);
                    //jQuery('#'+rightsidethird).text(x.YearLow);
                    diff = numberDiff(data[0].l_fix,stockpostedprice);
                    var sign = diff > 0 ? 1 : -1;
                    if(posted_date != undefined && stockpostedprice != undefined ){
                        if(sign > 0 && diff != 0 ){ 
                          var percentageChange = ((parseFloat(data[0].l_fix)-parseFloat(stockpostedprice))*100)/parseFloat(stockpostedprice); 
                          jQuery('.'+performanceContainer).append('<div class="main-tooltip safa" style="position: relative;margin-top: -72px;margin-left: 28px;"><span class="point1-green"><div class="tooltip">Real time stock price<br/>$'+data[0].l_fix+'</div></span><div class="line-green graph-green"><div class="graph-tooltip"><span class="graph-performance">Performance</span>'+' (+)'+percentageChange.toFixed(2)+'%</div></div><span class="point2-green"><div class="tooltip">Price of Stock on '+posted_date+'<br/>$'+stockpostedprice+'</div></span></div>');
                        } else if(diff==0){
                        } else { 
                          var percentageChange = ((parseFloat(stockpostedprice)-parseFloat(data[0].l_fix))*100)/parseFloat(stockpostedprice);  
                          jQuery('.'+performanceContainer).append('<div class="main-tooltip safa" style="position: relative;margin-top: -72px;margin-left: 28px;"><span class="point1-red"><div class="tooltip">Price of Stock on '+posted_date+'<br/>$'+stockpostedprice+'</div></span><div class="line-red graph-red"><div class="graph-tooltip"><span class="graph-performance">Performance</span>'+' (-)'+percentageChange.toFixed(2)+'%</div></div><span class="point2-red"><div class="tooltip">Real time stock price<br/>$'+data[0].l_fix+'</div></span></div>'); 
                        } 
                        }
                }
          }
        });
     });
   }
})(jQuery);
/*End Insutument graph for featured post*/

(function($){
    $.fn.myajax = function(){
     $('div[name="trig"]').each(function(){ //input[class=tag-list]
            var self = this;
            var tags = $(this).find("input").val(); 
            var string;
            var button_border_color; 
            var class_hover;
        // console.log(tags);          
        if( $(this).next(".thumbnail-transparent-bar").is(":hidden") )
            {
           if( tags.length > 0 && !cmp ( tags , "business" ) && !cmp ( tags ,"World") && !cmp ( tags , "AppConomy") && !cmp ( tags , "Politics") && !cmp ( tags , "finTech") && !cmp ( tags , "Financial") && !cmp( tags ,"Advisor") && !cmp( tags ,"Seeking") && !cmp( tags ,"Retirement")  && !cmp( tags ,"Investing")  && !cmp( tags ,"International") && !cmp( tags , "FinSports") )
            {
             
          // var url = '//query.yahooapis.com/v1/public/yql?q=select * from yahoo.finance.quotes where symbol in ('+tags+')&env=http://datatables.org/alltables.env&format=json';
          var url = '//query.yahooapis.com/v1/public/yql?q=select * from yahoo.finance.quotes where symbol in ('+tags+')&env=store://datatables.org/alltableswithkeys&format=json';  
         // var url = '//finance.google.com/finance/info?client=ig&q='+tags;
             $.get(url, function(data){
             //       console.log(data,'data');
                     var x = data['query']['results'].quote;
                     if(Array.isArray(x))
                     {
                        var x =data['query']['results']['quote']; 
                        var count  = 0; flagr = true;
                        x.forEach(function logArrayElements(element, index, array) {
                            if( count < 2 )
                            {
                                if( array[index].LastTradePriceOnly != null && array[index].PercentChange !=  null )
                                {
                                    count++;
                                  if($("#is_singlepage").val()>0){
                                    if( array[index].PercentChange.indexOf("+") > -1  )
                                    {
                                        var percentval = array[index].PercentChange.split('+');
                                        string = array[index].LastTradePriceOnly+"&nbsp;&nbsp;<span><i class='fa fa-caret-up' aria-hidden='true'></i>&nbsp;"+percentval[1]+"</span>";
                                        class_hover = "tag-format-green-hover";
                                    }
                                    else
                                    {
                                        var percentval = array[index].PercentChange.split('-');
                                        string = array[index].LastTradePriceOnly+"&nbsp;&nbsp;<span><i class='fa fa-caret-down' aria-hidden='true'></i>&nbsp;"+percentval[1]+"</span>";
                                        class_hover = "tag-format-red-hover";                                       
                                    }
                                  }else{
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
                                  }

                                    $(self).next(".thumbnail-transparent-bar").show();
                                   // $(self).find('.tag-format').remove();
                                    $(self).parents('.thumbnail-blog-link').siblings('.small-content').find('.an-widget-title').find('.posting-image').find('.main-tooltip').remove();
                                    $(self).append('<button class="tag-format aboveclass '+class_hover+'" title="'+array[index].Name+'" >&nbsp;'+ array[index].symbol +" "+ string +'&nbsp;</button>');
                                    //console.log(self);
                                    if($('.tag-list-price').length){
                                        var array1 = $(self).find('.tag-list-price').val().split(':'); 
                                        diff = numberDiff(array[index].LastTradePriceOnly,array1[1]);
                                       divpos =  $(self).parents('.thumbnail-blog-link').siblings('.small-content').find('.an-widget-title').find('.posting-image').find('.avatar');   
                                       var sign = diff > 0 ? 1 : -1;
                                       // console.log('Current price:'+array[index].LastTradePriceOnly,'Stored Price:'+array1[1],'Stored Symbol:'+array1[0],'Current Symbol:'+array[index].symbol,'Checking:'+flagr,'Variation:'+sign,'Diff:'+diff);
                                          if(array1[1] != 'undefined' && array1[0] == array[index].symbol){//console.log('1');
                                            var posted_date = $(self).find('.date-icon').val(); 
                                            if(flagr){//console.log('2');
                                                if(sign < 0 && diff != 0){//console.log('3','count',count);
                                                    var percentageChange = ((parseFloat(array1[1])-parseFloat(array[index].LastTradePriceOnly))*100)/parseFloat(array1[1]);   
                                                    //divpos =  $(self).parents('.thumbnail-blog-link').siblings('.small-content').find('.an-widget-title').find('.posting-image').find('.avatar');
                                                   // console.log(divpos);
                                                    $('<div style="position: relative;margin-top: -72px;margin-left: 28px;"><span class="point1-red"><div class="tooltip">Price of Stock on '+posted_date+'<br/>$'+array1[1]+'</div></span><div class="line-red graph-red"><div class="graph-tooltip"><span class="graph-performance">Performance</span>'+' (-)'+percentageChange.toFixed(2)+'%</div></div><span class="point2-red"><div class="tooltip">Real time stock price<br/>$'+array[index].LastTradePriceOnly+'</div></span></div>').insertAfter(divpos);
                                                } else if (diff==0) {//console.log('4');
                                                }else{//console.log('5');$(self).parents('thumbnail-blog-link').siblings('.small-content').find('.an-widget-title').find('.posting-image').addClass('green-today');
                                                    var percentageChange = ((parseFloat(array[index].LastTradePriceOnly)-parseFloat(array1[1]))*100)/parseFloat(array1[1]); 
                                                    $('<div class="main-tooltip safa" style="position: relative;margin-top: -72px;margin-left: 28px;"><span class="point1-green"><div class="tooltip">Real time stock price<br>$'+array[index].LastTradePriceOnly+'</div></span><div class="line-green graph-green"><div class="graph-tooltip"><span class="graph-performance">Performance</span>'+' (+)'+percentageChange.toFixed(2)+'%</div></div><span class="point2-green"><div class="tooltip">Price of Stock on '+posted_date+'<br>$'+array1[1]+'</div></span></div>').insertAfter(divpos);
                                                }
                                                flagr = false;
                                            }
                                        }
                                    }    
                                }
                            }                            
                        });
                    }
                    else
                    {
                        $(self).find('.tag-format').remove();$(self).parents('.thumbnail-blog-link').siblings('.small-content').find('.an-widget-title').find('.posting-image').find('.main-tooltip').remove();
                        if( x.LastTradePriceOnly != null && x.PercentChange != null )
                        {
                            
                          if($("#is_singlepage").val()>0){
                            if( x.PercentChange.indexOf("+") > -1  ){
                                var percentval = x.PercentChange.split('+');
                                string = x.LastTradePriceOnly+"&nbsp;&nbsp;<span><i class='fa fa-caret-up' aria-hidden='true'></i>&nbsp;"+percentval[1]+"</span>";
                                class_hover = "tag-format-green-hover";
                            }else{
                                var percentval = x.PercentChange.split('-');
                                string = x.LastTradePriceOnly+"&nbsp;&nbsp;<span><i class='fa fa-caret-down' aria-hidden='true'></i>&nbsp;"+percentval[1]+"</span>";
                                class_hover = "tag-format-red-hover";
                            }
                          }else{
                            if( x.PercentChange.indexOf("+") > -1  ){
                                string = x.LastTradePriceOnly+"&nbsp;&nbsp;<span>"+x.PercentChange+"</span>";
                                class_hover = "tag-format-green-hover";
                            }else{
                                var percentval = x.PercentChange.split('-');
                                string = x.LastTradePriceOnly+"&nbsp;&nbsp;<span>"+x.PercentChange+"</span>";
                                class_hover = "tag-format-red-hover";
                            }
                          }

                            $(self).next(".thumbnail-transparent-bar").show();
                                      
                            $(self).append('<button class="tag-format '+class_hover+'" title="'+x.Name+'" >&nbsp;'+ x.symbol +" "+ string +'&nbsp;</button>');
                               
                            if($('.tag-list-price').length){
                              var array1 = $(self).find('.tag-list-price').val().split(':'); 
                              diff = numberDiff(x.LastTradePriceOnly,array1[1]);
                              var sign = diff > 0 ? 1 : -1;
                              var posted_date = $(self).find('.date-icon').val();
                              if(array1[1] != undefined && array1[1] != 'undefined'){
                                if(sign > 0 && diff != 0 ){ 
                                  var percentageChange = ((parseFloat(x.LastTradePriceOnly)-parseFloat(array1[1]))*100)/parseFloat(array1[1]); 
                                  $(self).parents('.thumbnail-blog-link').siblings('.small-content').find('.an-widget-title').find('.posting-image').append('<div class="main-tooltip safa" style="position: relative;margin-top: -72px;margin-left: 28px;"><span class="point1-green"><div class="tooltip">Real time stock price<br/>$'+x.LastTradePriceOnly+'</div></span><div class="line-green graph-green"><div class="graph-tooltip"><span class="graph-performance">Performance</span>'+' (+)'+percentageChange.toFixed(2)+'%</div></div><span class="point2-green"><div class="tooltip">Price of Stock on '+posted_date+'<br/>$'+array1[1]+'</div></span></div>');
                                } else if(diff==0){
                                } else { 
                                  var percentageChange = ((parseFloat(array1[1])-parseFloat(x.LastTradePriceOnly))*100)/parseFloat(array1[1]);  
                                  $(self).parents('.thumbnail-blog-link').siblings('.small-content').find('.an-widget-title').find('.posting-image').append('<div class="main-tooltip safa" style="position: relative;margin-top: -72px;margin-left: 28px;"><span class="point1-red"><div class="tooltip">Price of Stock on '+posted_date+'<br/>$'+array1[1]+'</div></span><div class="line-red graph-red"><div class="graph-tooltip"><span class="graph-performance">Performance</span>'+' (-)'+percentageChange.toFixed(2)+'%</div></div><span class="point2-red"><div class="tooltip">Real time stock price<br/>$'+x.LastTradePriceOnly+'</div></span></div>'); 
                                }
                              }
                            }
                        }
                    }
             }).fail(function() {
                googleStockPrice(tags,self);
             });
          }
       }
      });
   }
})(jQuery);

function googleStockPrice(tags,self){
    tags = tags.replace(/['"]+/g, '');
    var url = 'https://finance.google.com/finance/info?client=ig&q='+tags;
    var request = jQuery.ajax({
      url: url,
      type:'GET',
      dataType: 'jsonp',
      success: function(data) {
        if(data.length>1){
            var count  = 0; flagr = true;
            data.forEach(function logArrayElements(element, index, array) {
                if( count < 2 ){
                    if( data[index].t != null &&  data[index].l_fix != null ){
                       count++;
                       if( data[index].c.indexOf("+") > -1  ){
                            string = data[index].l_fix+"&nbsp;&nbsp;<span>"+data[index].cp_fix+"</span>";
                            class_hover = "tag-format-green-hover";
                        }else{
                            string = data[index].l_fix+"&nbsp;&nbsp;<span>"+data[index].cp_fix+"</span>";
                            class_hover = "tag-format-red-hover";
                        }
                        jQuery(self).next(".thumbnail-transparent-bar").show();
                        jQuery(self).find('.tag-format').remove();
                        jQuery(self).parents('.thumbnail-blog-link').siblings('.small-content').find('.an-widget-title').find('.posting-image').find('.main-tooltip').remove();
                        jQuery(self).append('<button class="tag-format aboveclass '+class_hover+'" title="'+data[index].t+'" >&nbsp;'+ data[index].t +" "+ string +'&nbsp;</button>');
                        if(jQuery('.tag-list-price').length){
                            var array1 = jQuery(self).find('.tag-list-price').val().split(':'); 
                            diff = numberDiff(data[index].l_fix,array1[1]);
                              var sign = diff > 0 ? 1 : -1;
                              if(array1[1] != undefined && array1[1] != 'undefined' && array1[0] == data[index].t){
                                var posted_date = jQuery(self).find('.date-icon').val(); 
                                if(flagr){
                                    if(sign < 0 && diff != 0){
                                        var percentageChange = ((parseFloat(array1[1])-parseFloat(data[index].l_fix))*100)/parseFloat(array1[1]);   
                                        if( data[0].t != null &&  data[0].l_fix != null ){
                                            count++;
                                            if( data[index].c.indexOf("+") > -1  ){
                                                string = data[index].l_fix+"&nbsp;&nbsp;<span>"+data[index].c+"</span>";
                                                class_hover = "tag-format-green-hover";
                                                jQuery(self).next(".thumbnail-transparent-bar").show();
                                                jQuery(self).find('.tag-format').remove();
                                                jQuery(self).parents('.thumbnail-blog-link').siblings('.small-content').find('.an-widget-title').find('.posting-image').find('.main-tooltip').remove();
                                                jQuery(self).append('<button class="tag-format aboveclass '+class_hover+'" title="'+data[index].t+'" >&nbsp;'+ data[index].t +" "+ string +'&nbsp;</button>');
                                            }
                                        }    
                                    }    
                                }
                              }
                        }
                    }
                }
            });
        }else{
            jQuery(self).find('.tag-format').remove();
            jQuery(self).parents('.thumbnail-blog-link').siblings('.small-content').find('.an-widget-title').find('.posting-image').find('.main-tooltip').remove();
            if( data[0].t != null &&  data[0].l_fix != null ){
                if(  data[0].c.indexOf("+") > -1  ){
                    string = data[0].l_fix+"&nbsp;&nbsp;<span>"+data[0].cp_fix+"%</span>";
                    class_hover = "tag-format-green-hover";
                }else{
                    string = data[0].l_fix+"&nbsp;&nbsp;<span>"+data[0].cp_fix+"%</span>";
                    class_hover = "tag-format-red-hover";
                }
                jQuery(self).next(".thumbnail-transparent-bar").show();
                jQuery(self).append('<button class="tag-format '+class_hover+'" title="'+data[0].t+'" >&nbsp;'+ data[0].t +" "+ string +'&nbsp;</button>');  
                if(jQuery('.tag-list-price').length){
                    var array1 = jQuery(self).find('.tag-list-price').val().split(':'); 
                    diff = numberDiff(data[0].l_fix,array1[1]);
                    var sign = diff > 0 ? 1 : -1;
                    var posted_date = jQuery(self).find('.date-icon').val();
                    if(array1[1] != undefined && array1[1] != 'undefined'){
                      if(sign > 0 && diff != 0 ){ 
                        var percentageChange = ((parseFloat(data[0].l_fix)-parseFloat(array1[1]))*100)/parseFloat(array1[1]); 
                        jQuery(self).parents('.thumbnail-blog-link').siblings('.small-content').find('.an-widget-title').find('.posting-image').append('<div class="main-tooltip safa" style="position: relative;margin-top: -72px;margin-left: 28px;"><span class="point1-green"><div class="tooltip">Real time stock price<br/>$'+data[0].l_cur+'</div></span><div class="line-green graph-green"><div class="graph-tooltip"><span class="graph-performance">Performance</span>'+' (+)'+percentageChange.toFixed(2)+'%</div></div><span class="point2-green"><div class="tooltip">Price of Stock on '+posted_date+'<br/>$'+array1[1]+'</div></span></div>');
                      } else if(diff==0){
                      } else { 
                        var percentageChange = ((parseFloat(array1[1])-parseFloat(data[0].l_fix))*100)/parseFloat(array1[1]);  
                        jQuery(self).parents('.thumbnail-blog-link').siblings('.small-content').find('.an-widget-title').find('.posting-image').append('<div class="main-tooltip safa" style="position: relative;margin-top: -72px;margin-left: 28px;"><span class="point1-red"><div class="tooltip">Price of Stock on '+posted_date+'<br/>$'+array1[1]+'</div></span><div class="line-red graph-red"><div class="graph-tooltip"><span class="graph-performance">Performance</span>'+' (-)'+percentageChange.toFixed(2)+'%</div></div><span class="point2-red"><div class="tooltip">Real time stock price<br/>$'+data[0].l_cur+'</div></span></div>'); 
                      }
                    }
                }
            }
        }
      },
      complete: function (data) {
        
      }
    });
}

(function($){
$('.graph_instrument').each(function(){ 
 var numItems = jQuery('.graph_instrument').length;
 var tags = jQuery(this).find('.instrument').val();
  var selected_id = $(this).attr('id');
  var res = selected_id.replace("graphdetail", "instrument"); 
  var stockpricecontainer = selected_id.replace("graphdetail", "stockpriceheader");
  var percentagechangecontainer = selected_id.replace("graphdetail", "changepercentageheader"); 
  var stockpostedprice = jQuery(this).find('.stockpostedprice').val();
  var performanceContainer = selected_id.replace("graphdetail", "container-performance-graph");
  
  var called_by = selected_id.replace("graphdetail-", "called_by_");
  var rightsidesecond = selected_id.replace("graphdetail-", "rightsidesecond_");
  var rightsidethird = selected_id.replace("graphdetail-", "rightsidethird_");
  
 
  var posted_date = jQuery(this).find('.post_date').val();
  if( tags.length > 0){
    // var url = '//query.1yahooapis.com/v1/public/yql?q=select * from yahoo.finance.quotes where symbol in ("'+tags+'")&env=http://datatables.org/alltables.env&format=json';
    // jQuery.get(url, function(data){
    //   var x = data['query']['results'].quote;
    //   if( x.LastTradePriceOnly != null && x.PercentChange != null ){  
    //     if( x.PercentChange.indexOf("+") > -1  ){
    //         string = "<span class='lastpriceh'>"+x.LastTradePriceOnly+"</span>&nbsp;&nbsp;<span class='percentageh'>"+x.PercentChange+"</span>";
    //         class_hover = "tag-format-green-hover";
    //     }else{
    //         string = "<span class='lastpriceh'>"+x.LastTradePriceOnly+"</span>&nbsp;&nbsp;<span class='percentageh'>"+x.PercentChange+"</span>";
    //         class_hover = "tag-format-red-hover";
    //     }
    //     $('.custom-instrument').addClass('instrument-container');
    //     //console.log(res,'testing');
    //     $('.'+res).append('<button class="tag-format '+class_hover+'" title="'+x.Name+'" >&nbsp;'+ x.symbol +" "+ string +'&nbsp;</button>'); 
    //     jQuery('.'+called_by).text('yahoo-finance');
    //     jQuery('.'+rightsidesecond).text(x.YearHigh);
    //     jQuery('.'+rightsidethird).text(x.YearLow);
    //     diff = numberDiff(x.LastTradePriceOnly,stockpostedprice);
    //     var sign = diff > 0 ? 1 : -1;
    //     if(posted_date != undefined && stockpostedprice != undefined ){
    //     if(sign > 0 && diff != 0 ){ 
    //       var percentageChange = ((parseFloat(x.LastTradePriceOnly)-parseFloat(stockpostedprice))*100)/parseFloat(stockpostedprice); 
    //       $('.'+performanceContainer).append('<div class="main-tooltip safa" style="position: relative;margin-top: -72px;margin-left: 28px;"><span class="point1-green"><div class="tooltip">Real time stock price<br/>$'+x.LastTradePriceOnly+'</div></span><div class="line-green graph-green"><div class="graph-tooltip"><span class="graph-performance">Performance</span>'+' (+)'+percentageChange.toFixed(2)+'%</div></div><span class="point2-green"><div class="tooltip">Price of Stock on '+posted_date+'<br/>$'+stockpostedprice+'</div></span></div>');
    //     } else if(diff==0){
    //     } else { 
    //       var percentageChange = ((parseFloat(stockpostedprice)-parseFloat(x.LastTradePriceOnly))*100)/parseFloat(stockpostedprice);  
    //       $('.'+performanceContainer).append('<div class="main-tooltip safa" style="position: relative;margin-top: -72px;margin-left: 28px;"><span class="point1-red"><div class="tooltip">Price of Stock on '+posted_date+'<br/>$'+stockpostedprice+'</div></span><div class="line-red graph-red"><div class="graph-tooltip"><span class="graph-performance">Performance</span>'+' (-)'+percentageChange.toFixed(2)+'%</div></div><span class="point2-red"><div class="tooltip">Real time stock price<br/>$'+x.LastTradePriceOnly+'</div></span></div>'); 
    //     } 
    //     } 
    //   }
    // }).fail(function() {
            googleStockPriceGraph(tags,res,stockpricecontainer,percentagechangecontainer,performanceContainer,stockpostedprice,posted_date,called_by,rightsidesecond,rightsidethird);
    // });
  }
});
})(jQuery);

function googleStockPriceGraph(tags,res,stockpricecontainer,percentagechangecontainer,performanceContainer,stockpostedprice,posted_date,called_by,rightsidesecond,rightsidethird){
    var url = 'https://finance.google.com/finance/info?client=ig&q='+tags;
    var request = jQuery.ajax({
      url: url,
      type:'GET',
      dataType: 'jsonp',
      success: function(data) {
            if( data[0].t != null &&  data[0].l_fix != null ){
                var stock_cp_fix = data[0].cp_fix != '' ? data[0].cp_fix : '0.00' ;
                var stock_c = data[0].c != '' ? data[0].c : '0.00' ; 
                if( data[0].c.indexOf("+") > -1  ){
                    string = "<span class='lastpriceh'>"+data[0].l_fix+"</span>&nbsp;&nbsp;<span class='percentageh'>"+stock_cp_fix+"%</span>";
                    class_hover = "tag-format-green-hover";
		    arrowimage = '<img src="wp-content/themes/pin-wp/images/arrow_green.png" style="width:16px; margin-left: 30px;">';
                }else{
                    string = "<span class='lastpriceh'>"+data[0].l_fix+"</span>&nbsp;&nbsp;<span class='percentageh'>"+stock_cp_fix+"%</span>";
                    class_hover = "tag-format-red-hover";
		    arrowimage = '<img src="wp-content/themes/pin-wp/images/arrow_red.png" style="width:16px; margin-left:30px;">';
                }
                jQuery('.custom-instrument').addClass('instrument-container');
                jQuery('.'+res).append('<button class="tag-format '+class_hover+'" title="'+data[0].t+'" >&nbsp;'+ data[0].t +" "+ string +'&nbsp;</button>'+arrowimage);
                //jQuery('#'+stockpricecontainer).text(data[0].l);
                //jQuery('#'+percentagechangecontainer).text(data[0].cp+'%');
                jQuery('#'+called_by).addClass('testing').val('google-finance');
                jQuery('.'+rightsidesecond).val(stock_c);
                //jQuery('#'+rightsidethird).text(x.YearLow);
                diff = numberDiff(data[0].l_fix,stockpostedprice);
                var sign = diff > 0 ? 1 : -1;
                if(posted_date != undefined && stockpostedprice != undefined ){
                    if(sign > 0 && diff != 0 ){ 
                      var percentageChange = ((parseFloat(data[0].l_fix)-parseFloat(stockpostedprice))*100)/parseFloat(stockpostedprice); 
                      jQuery('.'+performanceContainer).append('<div class="main-tooltip safa" style="position: relative;margin-top: -72px;margin-left: 28px;"><span class="point1-green"><div class="tooltip">Real time stock price<br/>$'+data[0].l_fix+'</div></span><div class="line-green graph-green"><div class="graph-tooltip"><span class="graph-performance">Performance</span>'+' (+)'+percentageChange.toFixed(2)+'%</div></div><span class="point2-green"><div class="tooltip">Price of Stock on '+posted_date+'<br/>$'+stockpostedprice+'</div></span></div>');
                    } else if(diff==0){
                    } else { 
                      var percentageChange = ((parseFloat(stockpostedprice)-parseFloat(data[0].l_fix))*100)/parseFloat(stockpostedprice);  
                      jQuery('.'+performanceContainer).append('<div class="main-tooltip safa" style="position: relative;margin-top: -72px;margin-left: 28px;"><span class="point1-red"><div class="tooltip">Price of Stock on '+posted_date+'<br/>$'+stockpostedprice+'</div></span><div class="line-red graph-red"><div class="graph-tooltip"><span class="graph-performance">Performance</span>'+' (-)'+percentageChange.toFixed(2)+'%</div></div><span class="point2-red"><div class="tooltip">Real time stock price<br/>$'+data[0].l_fix+'</div></span></div>'); 
                    } 
                }
            }
      }
    });
}
(function($){
$('.tag-shifter').each(function(){
var tags = jQuery(this).find('.tag-list-price').val();
var posted_date = jQuery(this).find('.date-icon').val();
 if( tags.length > 0){ 
    var array1 = tags.split(':');
    var url = '//query.yahooapis.com/v1/public/yql?q=select * from yahoo.finance.quotes where symbol in ("'+array1[0]+'")&env=store://datatables.org/alltableswithkeys&format=json';
    jQuery.get(url, function(data){
      var x = data['query']['results'].quote;
      diff = numberDiff(x.LastTradePriceOnly,array1[1]);
      var sign = diff > 0 ? 1 : -1;
    // console.log(x.LastTradePriceOnly,array1[0],array1[1],'detail page');
      if(array1[0] != undefined && array1[1] != undefined){
        if(sign > 0 && diff != 0 ){ 
          var percentageChange = ((parseFloat(x.LastTradePriceOnly)-parseFloat(array1[1]))*100)/parseFloat(array1[1]); 
          $('.the_graphdetail').append('<div class="main-tooltip" ><span class="point1-green"><div class="tooltip">Real time stock price<br/>$'+x.LastTradePriceOnly+'</div></span><div class="line-green graph-green"><div class="graph-detail-tooltip"><span class="graph-performance">Performance</span>'+' (+)'+percentageChange.toFixed(2)+'%</div></div><span class="point2-green"><div class="tooltip">Price of Stock on '+posted_date+'<br/>$'+array1[1]+'</div></span></div>');
        }  else if(diff==0){
        }else{
           var percentageChange = ((parseFloat(array1[1])-parseFloat(x.LastTradePriceOnly))*100)/parseFloat(array1[1]); 
           $('.the_graphdetail').append('<div class="main-tooltip" ><span class="point1-red"><div class="tooltip">Price of Stock on '+posted_date+'<br/>$'+array1[1]+'</div></span><div class="line-red graph-red"><div class="graph-detail-tooltip"><span class="graph-performance">Performance</span>'+' (-)'+percentageChange.toFixed(2)+'%</div></div><span class="point2-red"><div class="tooltip">Real time stock price<br/>$'+x.LastTradePriceOnly+'</div></span></div>'); 
        }
      }
    });
  }
});
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
   /* jQuery(".featured-articles-slider").show();
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
       moveSlides:1,
            controls: true,
            autoControls: true
          });*/ 
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
