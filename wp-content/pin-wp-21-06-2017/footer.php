<?php
// Options from admin panel
  global $smof_data;
  $home_pag_select = (isset($smof_data['home_pag_select'])) ? $smof_data['home_pag_select'] : 'Infinite Scroll';
  $home_pag_select1 = (isset($smof_data['home_pag_select1'])) ? $smof_data['home_pag_select1'] : 'Infinite Scroll1';
?>
<!-- Begin Footer -->
<footer>
    <div class="footer-socila-butn">        
        <div class="footer-socila-butn-text">
        <p class="footer-topleft-text" style="line-height: 36px;"> Are you an advisor? Read how we can benefit you <a target="_blank" href="<?php echo get_option('home'); ?>/financialadvisors">here</a></p>
         <ul class="footer-socila-butn-grp">
           <li style="float:left;">
               <a href="https://play.google.com/store/apps/details?id=com.Intlfaces.retire.ly">
                <img src="../wp-content/themes/pin-wp/images/google-play-white.svg" class="img-responsive social-img-icon">       
               </a>
            </li>
            <li style="float:left;margin-left:5px;">
               <a href="https://itunes.apple.com/us/app/retirely/id713998164?ls=1&mt=8">
                <img src="../wp-content/themes/pin-wp/images/apple-button-white.svg" class="img-responsive social-img-icon">       
               </a>
            </li>
        </ul></div>
                
    </div>
    <div class="social-section">
        <div class="social-section-one">
            <ul class="footer-social">
                <li><a href="<?php echo get_option('home'); ?>/about-us">ABOUT US</a></li>
                <li><a href="<?php echo get_option('home'); ?>/financialadvisors/#contactus">CONTACT US</a></li>
            </ul>
        </div>
        <div class="social-section-two">
            <ul class="footer-social">
                <li>
                    <a href="http://www.twitter.com/retirely_">
                    <i class="fa fa-twitter"></i></a>
                </li>
                <li>
                    <a href="http://www.facebook.com/retirely">
                    <i class="fa fa-facebook"></i></a>
                </li>
                <li>
                    <a href="https://www.instagram.com/retirely">
                    <i class="fa fa-instagram"></i></a>
                </li>
                <li>
                    <a href="http://www.linkedin.com/companies/retirely">
                    <i class="fa fa-linkedin"></i></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-rss"></i></a>
                </li>
            </ul>
        </div>
        <div class="social-section-three">
            <ul class="footer-social">
                <li><a href="<?php echo get_option('home'); ?>/privacy-policy">PRIVACY POLICY</a></li>
                <li><a href="<?php echo get_option('home'); ?>/terms-of-service">TERMS</a></li>
            </ul>
        </div>
    </div>


    

     
<!-- Begin random articles on slide -->
<!-- end .featured-articles -->
    <div class="wrap-footer">
        <div class="copyright">
            <?php if (!empty($smof_data['copyright_footer'])) { ?>
                <?php echo wp_kses_post(stripslashes($smof_data['copyright_footer'])); ?>
            <?php } ?>
        </div>
    </div>
    <p id="back-top" style="display: block;"><a href="#top"><span></span></a></p>
</footer><!-- end #footer -->
<!-- Menu & link arrows -->
<script type="text/javascript">var jquerycssmenu={fadesettings:{overduration:0,outduration:100},buildmenu:function(b,a){jQuery(document).ready(function(e){var c=e("#"+b+">ul");var d=c.find("ul").parent();d.each(function(g){var h=e(this);var f=e(this).find("ul:eq(0)");this._dimensions={w:this.offsetWidth,h:this.offsetHeight,subulw:f.outerWidth(),subulh:f.outerHeight()};this.istopheader=h.parents("ul").length==1?true:false;f.css({top:this.istopheader?this._dimensions.h+"px":0});h.children("a:eq(0)").css(this.istopheader?{paddingRight:a.down[2]}:{}).append('<img src="'+(this.istopheader?a.down[1]:a.right[1])+'" class="'+(this.istopheader?a.down[0]:a.right[0])+'" style="border:0;" />');h.hover(function(j){var i=e(this).children("ul:eq(0)");this._offsets={left:e(this).offset().left,top:e(this).offset().top};var k=this.istopheader?0:this._dimensions.w;k=(this._offsets.left+k+this._dimensions.subulw>e(window).width())?(this.istopheader?-this._dimensions.subulw+this._dimensions.w:-this._dimensions.w):k;i.css({left:k+"px"}).fadeIn(jquerycssmenu.fadesettings.overduration)},function(i){e(this).children("ul:eq(0)").fadeOut(jquerycssmenu.fadesettings.outduration)})});c.find("ul").css({display:"none",visibility:"visible"})})}};var arrowimages={down:['downarrowclass', '<?php echo get_template_directory_uri(); ?>/images/menu/arrow-down.png'], right:['rightarrowclass', '<?php echo get_template_directory_uri(); ?>/images/menu/arrow-right.png']}; jquerycssmenu.buildmenu("myjquerymenu", arrowimages); jquerycssmenu.buildmenu("myjquerymenu-cat", arrowimages);</script>
<?php if ($home_pag_select == 'Infinite Scroll') { ?>
<!-- Infinite scroll (default) -->
<script>
jQuery(function() {
    jQuery(window).on("scroll", function() {
        jQuery('.status-publish').on('mouseenter', function() {
            jQuery(this).find('.home-meta').find('.shortcode-my').addClass('showing-icon');
            jQuery(this).find('.home-meta').find('.shortcode-my').removeClass('hidding-icon');
        });
        jQuery('.status-publish').on('mouseleave', function() {
            jQuery(this).find('.home-meta').find('.shortcode-my').removeClass('showing-icon');
            jQuery(this).find('.home-meta').find('.shortcode-my').addClass('hidding-icon');
        });
        jQuery('.shortcode-my').addClass('hidding-icon');
        if(jQuery(window).scrollTop() > 50) {
            jQuery(".main-header").css('background-color','rgba( 238, 238, 255, 0.6)');
            /* jQuery(".main-header").css('pointer-events','none');*/
        } else {
            //remove the background property so it comes transparent again (defined in your css)
            jQuery(".main-header").css('background-color','RGBA(238, 238, 255,1)');
            /*jQuery(".main-header").css('pointer-events','auto');*/
            jQuery("#websiteloading").hide();
            jQuery(".sign-btnn").removeAttr("disabled");
            jQuery(".video_loader, .video_loader_graph").removeClass('section_show').addClass('section_hide');
            jQuery(".video-container, .video-container-graph").removeClass('section_hide');
        }
    });
});
</script>
<script>jQuery(window).load(function(b){jQuery("#infinite-articles, .sidebar, .sidebar-left").masonry();var a=jQuery("#infinite-articles");a.imagesLoaded(function(){a.masonry({itemSelector:".ex34"})});a.infinitescroll({navSelector:"#nav-below",nextSelector:"#nav-below a",itemSelector:".ex34",loading:{msgText:"",finishedMsg:"<span><i class=\"fa fa-thumbs-up\"></i></span>",img:"<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif"}},function(c){var d=jQuery(c).css({opacity:0});d.imagesLoaded(function(){d.animate({opacity:1});a.masonry("appended",d,true);
    jQuery("#websiteloading").hide();
    jQuery(".sign-btnn").removeAttr("disabled");
    jQuery(".video_loader, .video_loader_graph").removeClass('section_show').addClass('section_hide');
    jQuery(".video-container, .video-container-graph").removeClass('section_hide');
})})});</script>
<?php } else { ?>
<script>jQuery( window ).load( function( $ ) {"use strict"; var $container = jQuery('#infinite-articles, .sidebar, .sidebar-left'); $container.imagesLoaded( function(){ $container.masonry({ itemSelector : '' }); });});</script>
<?php } ?>
<?php if ($home_pag_select1 == 'Infinite Scroll1') { ?>
<!-- Infinite scroll (default) -->
<script>jQuery(window).load(function(b){jQuery("#infinite-articles1, .sidebar, .sidebar-left").masonry();var a=jQuery("#infinite-articles1");a.imagesLoaded(function(){a.masonry({itemSelector:".ex34"})});a.infinitescroll({navSelector:"#nav-below",nextSelector:"#nav-below a",itemSelector:".ex34",loading:{msgText:"",finishedMsg:"<span><i class=\"fa fa-thumbs-up\"></i></span>",img:"<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif"}},function(c){var d=jQuery(c).css({opacity:0});d.imagesLoaded(function(){d.animate({opacity:1});a.masonry("appended",d,true)})})});</script>
<?php } else { ?>
<script>jQuery( window ).load( function( $ ) {"use strict"; var $container = jQuery('#infinite-articles1, .sidebar, .sidebar-left'); $container.imagesLoaded( function(){ $container.masonry({ itemSelector : '' }); });});</script>
<?php } ?>
<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('.status-publish').on('mouseenter', function() {
      jQuery(this).find('.home-meta').find('.shortcode-my').addClass('showing-icon');
      jQuery(this).find('.home-meta').find('.shortcode-my').removeClass('hidding-icon');
    });
    jQuery('.status-publish').on('mouseleave', function() {
      jQuery(this).find('.home-meta').find('.shortcode-my').removeClass('showing-icon');
      jQuery(this).find('.home-meta').find('.shortcode-my').addClass('hidding-icon');
    });
    jQuery('.shortcode-my').addClass('hidding-icon');
  });
</script>
<!-- Footer Theme output -->
<?php wp_footer();?>
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/js/highstock.js" ></script>
<!--script type="text/javascript" src="//code.highcharts.com/modules/exporting.js"></script-->
<script type="text/javascript">
var sflag=false;
/*function is used to create graph on detail page*/
function creategraphdetail(symbol, x) {
    var stockname = x.Name;
    var url = "//quotes.stocktwits.com/chart?symbol=" + symbol + "&zoom=all";
    jQuery.getJSON(url, function(data) {
        // split the data set into ohlc and volume
        var ohlc = [],
            volume = [],
            dataLength = data.length,
            // set the allowed units for data grouping
            groupingUnits = [
                ['week', // unit name
                    [4] // allowed multiples
                ],
                ['month', [1, 2, 3, 4, 6]]
            ],
            i = 0;
        for (i; i < dataLength; i += 1) {
            ohlc.push([
                data[i].Date, // the date
                data[i].Open, // open
                data[i].High, // high
                data[i].Low, // low
                data[i].Last // close
            ]);
            volume.push([
                data[i].Date, // the date
                data[i].Volume // the volume
            ]);
        }
        jQuery('#graph-detail-page').highcharts('StockChart', {
            chart: {
                className: 'dark-container',
            },
            subtitle: {
                text: stockname,
                style: {
                    color: '#000',
                    font: 'bold 20px "Trebuchet MS", Verdana, sans-serif'
                }
            },
            rangeSelector: {
                enabled: !1,
                inputEnabled: false,
                selected: 1
            },
            plotOptions: {
                candlestick: {
                    color: "#ED3B3B",
                    upColor: "#8ECF61",
                    lineColor: "#ED3B3B",
                    upLineColor: "#8ECF61"
                },
                area: {
                    stacking: "percent",
                    lineColor: "#ffffff",
                    lineWidth: 1,
                    marker: {
                        enabled: !1
                    },
                    fillOpacity: .7
                },
                spline: {
                    marker: {
                        enabled: !1
                    }
                },
                series: {
                    states: {
                        hover: {
                            marker: {
                                enabled: !1
                            }
                        }
                    }
                }
            },
            credits: {
                text: "",
                href: ""
            },
            title: {
                text: ''
            },
            tooltip: {
                color: "#10F80B",
                borderColor: "#10F80B"
            },
            exporting: {
                chartOptions: {
                    rangeSelector: {
                        enabled: false
                    }
                }
            },
            navigator: {
                enabled: !1
            },
            scrollbar: {
                enabled: !1
            },
            navigation: {
                buttonOptions: {
                    enabled: !1
                }
            },
            xAxis: [{
                labels: {
                    enabled: false
                }
            }, {
                labels: {
                    enabled: false
                }
            }],
            yAxis: [{
                labels: {
                    align: 'right',
                    x: -3
                },
                title: {
                    text: ''
                },
                height: '60%',
                lineWidth: 1
            }, {
                labels: {
                    align: 'right',
                    x: -3
                },
                title: {
                    text: ''
                },
                top: '65%',
                height: '35%',
                offset: 0,
                lineWidth: 1
            }],
            series: [{
                type: 'candlestick',
                name: symbol,
                //color: "#ED3B3B",
                data: ohlc,
                dataGrouping: {
                    units: [groupingUnits]
                }
            }, {
                type: 'column',
                name: 'Volume',
                data: volume,
                color: "#DDD",
                yAxis: 1,
                dataGrouping: {
                    units: groupingUnits
                }
            }]
        });
    });
}
jQuery(document).ready(function() {
    /////////////////////////////////
    // Slider Featured Articles
    /////////////////////////////////
    jQuery(".featured-articles-slider").show();
    jQuery(".featured-articles-slider").hide().css({
        'left': "0px"
    }).fadeIn(1000); // fade effect for images, lovely.
    var myslider = jQuery('.featured-articles-slider').bxSlider({
        slideWidth: 300,
        minSlides: 1,
        infiniteLoop: true,
        randomStart: true,
        maxSlides: 10,
        auto: true,
        autoHover: true,
        nextSelector: '#slider-next',
        prevSelector: '#slider-prev',
        nextText: '<i class="fa fa-chevron-right"></i>',
        prevText: '<i class="fa fa-chevron-left"></i>',
        slideMargin: 0,
        moveSlides: 1,
        controls: true,
        autoControls: true,

        //speed: 3000,
        onSlideBefore:function(){
            //jQuery('.graph-section').hide();
            sflag=false;
        },
        onSlideAfter:function(){
            //jQuery('.graph-section').hide();
            sflag=false;
        },
        onSlideNext: function() {
            jQuery('.graph-section').hide();
            sflag=true;
        },
        onSlidePrev: function() {
            jQuery('.graph-section').hide();
            sflag=true;
        }

    });
    myslider.startAuto();

    var currentView = false;
    jQuery.ajaxQ = (function() {
        var id = 0,
            Q = {};
        jQuery(document).ajaxSend(function(e, jqx) {
            jqx._id = ++id;
            Q[jqx._id] = jqx;
        });
        jQuery(document).ajaxComplete(function(e, jqx) {
            delete Q[jqx._id];
        });
        return {
            abortAll: function() {
                var r = [];
                jQuery.each(Q, function(i, jqx) {
                    r.push(jqx._id);
                    jqx.abort();
                });
                return r;
            }
        };
    })();

    jQuery('body').on('mouseover', '.frondendgraph, .frondendgraph1', function(e,index) {
        var selectorClass = jQuery(this).attr('class');
        var innerClass = e.target.className;
        var selectorclassname = innerClass.trim();
        var tagclass_arr = selectorclassname.split('-');
        if(tagclass_arr[0] == "tag" || tagclass_arr[0] == "green" || tagclass_arr[0] == "lastpriceh" || tagclass_arr[0] == "percentageh" || tagclass_arr == "" || tagclass_arr[0] == 'graph' || tagclass_arr[0] == 'instrument' ){
         jQuery(".graph-section").hide();
         return false;
         }
        var reference = jQuery(this);
       // console.log(selectorClass,'selectorClass');
        if ( selectorClass.indexOf("frondendgraph1") >= 0 ) {
            var stockname = jQuery(this).siblings('.stockname_heading').text();
            var selected_id = jQuery(this).closest('.frondendgraphvideo').find('.called_by').attr('id');
            var Id = selected_id.replace("called_by_", "");
            var stockpriceheader = jQuery(this).closest('.frondendgraphvideo').find('.title-box').find('.instrument-' + Id).find('.lastpriceh').text();
            var changepercentageheader = jQuery(this).closest('.frondendgraphvideo').find('.instrument-' + Id).find('.tag-format').find('.percentageh').text();
            var called_by = jQuery(this).closest('.frondendgraphvideo').find('#called_by_' + Id).val();
            var rightsidesecond = jQuery(this).closest('.frondendgraphvideo').find('.rightsidesecond_' + Id).val();
            var rightsidethird = jQuery(this).closest('.frondendgraphvideo').find('.rightsidethird_' + Id).val();
            var tags = jQuery(this).closest('.frondendgraphvideo').find('.instrument').val();
            var expertprofileimage = jQuery(this).closest('.frondendgraphvideo').find('.expertprofileimage').val();
            var expertname = jQuery(this).closest('.frondendgraphvideo').find('.expertname').val();
            var expertcomment = jQuery(this).closest('.frondendgraphvideo').find('.expertcomment').val();
        } else {
            var stockname = jQuery(this).find('.title-box').find('.stockname').text();
            var selected_id = jQuery(this).find('.called_by').attr('id');
            var Id = selected_id.replace("called_by_", "");
            var stockpriceheader = jQuery(this).find('.title-box').find('.instrument-' + Id).find('.lastpriceh').text();
            var changepercentageheader = jQuery(this).find('.title-box').find('.instrument-' + Id).find('.percentageh').text();
            var called_by = jQuery(this).find('#called_by_' + Id).val();
            var rightsidesecond = jQuery(this).find('.rightsidesecond_' + Id).val();
            var rightsidethird = jQuery(this).find('.rightsidethird_' + Id).val();
            var tags = jQuery(this).find('.instrument').val();
            var expertprofileimage = jQuery(this).find('.expertprofileimage').val();
        var authusername = jQuery(this).find('.authusername').val();
            var expertname = jQuery(this).find('.expertname').val();
            var expertcomment = jQuery(this).find('.expertcomment').val();
        }
        var posttitle = '';
        var expert = [];
        expert.push(expertprofileimage);
        expert.push(expertname);
        expert.push(expertcomment);
        expert.push(authusername);
        if (tags.length > 0 && called_by != null && called_by != '') {
            generategraph(posttitle, tags, stockname, stockpriceheader, changepercentageheader, rightsidesecond, rightsidethird, expert, called_by, reference);
        }
    });

    function googleStockPriceFrontGraph(posttitle, tags, stockpriceheader, changepercentageheader, stockname, expert) {
        var url = 'https://finance.google.com/finance/info?client=ig&q=' + tags;
        var request = jQuery.ajax({
            url: url,
            type: 'GET',
            dataType: 'jsonp',
            beforeSend: function(jqXHR, opts) {
                jQuery.ajaxQ.abortAll();
            },
            success: function(data) {
                if (data[0].t != null && data[0].l_cur != null) {
                    var checkparam = 'google';
                    //generategraph(posttitle,data[0].t,stockname,data[0].l_cur,data[0].cp_fix+'%',data[0].c,0,expert,checkparam);
                    generategraph(posttitle, data[0].t, stockname, stockpriceheader, changepercentageheader, x.YearLow, x.YearHigh, expert);
                }
            }
        });
        //generategraph(posttitle,tags,stockname,stockpriceheader,changepercentageheader,0,0,expert);
    }
    /*check is stock price*/
    function stockDiff(a, b) {
        return eval(a - b)
    }
    /*function is used to create graph*/
    function creategraph(symbol) {
        var url = "//ql.stocktwits.com/chart?symbol=" + symbol + "&zoom=1m";
        jQuery.getJSON(url, function(data) {
            // split the data set into ohlc and volume
            var ohlc = [],
                volume = [],
                dataLength = data.length,
                // set the allowed units for data grouping
                groupingUnits = [
                    ['week', // unit name
                        [4] // allowed multiples
                    ],
                    ['month', [1, 2, 3, 4, 6]]
                ],
                i = 0;
            for (i; i < dataLength; i += 1) {
                if (i != 0) {
                    ohlc.push([
                        data[i].Date, // the date
                        data[i].Open, // open
                        data[i].High, // high
                        data[i].Low, // low
                        data[i].Last // close
                    ]);
                    volume.push([
                        data[i].Date, // the date
                        data[i].Volume // the volume
                    ]);
                }
            }
            // jQquery('.containerchart').empty();  
            jQuery('.containerchart').highcharts('StockChart', {
                rangeSelector: {
                    enabled: !1,
                    inputEnabled: false,
                    selected: 1
                },
                plotOptions: {
                    candlestick: {
                        color: "#ED3B3B",
                        upColor: "#8ECF61",
                        lineColor: "#ED3B3B",
                        upLineColor: "#8ECF61"
                    },
                    area: {
                        stacking: "percent",
                        lineColor: "#ffffff",
                        lineWidth: 1,
                        marker: {
                            enabled: !1
                        },
                        fillOpacity: .7
                    },
                    spline: {
                        marker: {
                            enabled: !1
                        }
                    },
                    series: {
                        states: {
                            hover: {
                                marker: {
                                    enabled: !1
                                }
                            }
                        }
                    }
                },
                credits: {
                    text: "",
                    href: ""
                },
                title: {
                    text: ''
                },
                tooltip: {
                    color: "#10F80B",
                    borderColor: "#10F80B"
                },
                exporting: {
                    chartOptions: {
                        rangeSelector: {
                            enabled: false
                        }
                    }
                },
                navigator: {
                    enabled: !1
                },
                scrollbar: {
                    enabled: !1
                },
                navigation: {
                    buttonOptions: {
                        enabled: !1
                    }
                },
                xAxis: [{
                    labels: {
                        enabled: false
                    }
                }, {
                    labels: {
                        enabled: false
                    }
                }],
                yAxis: [{
                    labels: {
                        align: 'right',
                        x: -3
                    },
                    title: {
                        text: ''
                    },
                    height: '60%',
                    lineWidth: 1
                }, {
                    labels: {
                        align: 'right',
                        x: -3
                    },
                    title: {
                        text: ''
                    },
                    top: '65%',
                    height: '35%',
                    offset: 0,
                    lineWidth: 1
                }],
                series: [{
                    type: 'candlestick',
                    name: symbol,
                    //color: "#ED3B3B",
                    data: ohlc,
                    dataGrouping: {
                        units: [groupingUnits]
                    }
                }, {
                    type: 'column',
                    name: 'Volume',
                    data: volume,
                    color: "#DDD",
                    yAxis: 1,
                    dataGrouping: {
                        units: groupingUnits
                    }
                }]
            });
        });
    }
    /*function is used to create entire div of graph*/
    function generategraph(posttitle, symbol, name, price, percent, yearhigh, yearlow, expert, called_by, reference) {
        //console.log(called_by,price,yearlow,'---'); 
        var expertimage = (expert[0] != undefined && expert[0] != '') ? expert[0] : "";
        var expertname = (expert[1] != undefined && expert[1] != '') ? expert[1] : "";
        var expertcomment = (expert[2] != undefined && expert[2] != '') ? expert[2] : "";
    var authusername = (expert[3] != undefined && expert[3] != '') ? expert[3] : "";
        //console.log(price,percent);
        jQuery('.stock_title').text(symbol + name);
        jQuery('.symbol').text(symbol);
        jQuery('.name').text(name);
        jQuery('.expert-image').empty();
        jQuery('.expert-name,.expert-advice').text('');
        if (expertimage != '' && expertname != '' && expertcomment != '') {
            jQuery('.expert-advice').text('Expert');
            jQuery('.expert-name').text(expertname);
            jQuery('.expert-comment').text(expertcomment);
            //jQuery('.expert-image').append('<img src=' + expertimage + '>');
        jQuery('.expert-image').append('<img onclick="window.location.href=\'https://www.retire.ly/'+authusername+'\'" src=' + expertimage + '>');
        }
        /*check for green icon*/
        if (percent.indexOf('-') === -1) {
            jQuery('.graph-left-side-price').removeClass('mygraph-red');
            jQuery('.graph-left-side-price').addClass('mygraph-green');
        } else {
            jQuery('.graph-left-side-price').removeClass('mygraph-green');
            jQuery('.graph-left-side-price').addClass('mygraph-red');
        }
        jQuery('.percentchange').text('');
        jQuery('.stockprice').text(parseFloat(price).toFixed(2));
        jQuery('.percentchange').text(percent);
        jQuery('.mygraph-green-high,.mygraph-red-low').remove();
        if (called_by === 'google-finance') {
            if (yearhigh.indexOf('-') === -1) {
                // for gainer stock
                var perviousPrice = parseFloat(price) - parseFloat(yearhigh);
                jQuery(".graph-left-year-low,.graph-left-year-high").before("<span class='mygraph-green-high'></span>");
            } else {
                // for loose stock
                var perviousPrice = parseFloat(price) + parseFloat(yearhigh);
                jQuery(".graph-left-year-low,.graph-left-year-high").before("<span class='mygraph-red-low'></span>");
            }
            jQuery('.graph-left-year-low').html(perviousPrice.toFixed(2) + '<span class="year-high-text-google" title="Previous Price">Pre. Price</span>');
            jQuery('.graph-left-year-high').html(yearhigh + '<span class="year-low-text-google" title="Price Change">Change($)</span>');
        } else {
            jQuery(".graph-left-year-high").before("<span class='mygraph-green-high'></span>");
            jQuery(".graph-left-year-low").before("<span class='mygraph-red-low'></span>");
            jQuery('.graph-left-year-high').html(yearhigh + '<span class="year-high-text" title="Year high" >Year high</span>');
            jQuery('.graph-left-year-low').html(yearlow + '<span class="year-low-text" title="Year low">Year low</span>');
        }
        jQuery('#mygraph-green-high').addClass('mygraph-green-high');
        jQuery('#mygraph-red-low').addClass('mygraph-red-low');
        currentView = true;
        creategraph(symbol);
        showingGraph(reference);
        jQuery('.loading-graph').hide();
    }
    /*script when we mouse hover on heading*/
    // jQuery('.frondendgraph').on('mouseenter', function(event) {
    function showingGraph(reference) {
        if(sflag==false){
            jQuery('#loading-graph').show();
            var parents = jQuery(reference).closest('li');
            //var devicewidth = $(window).width();
            var headerWidth = jQuery(".bx-viewport").position();
            var position = jQuery('.title-box').position();
            var pos = parents.offset().left - parseInt(headerWidth.left) - 9;
            jQuery('.graph-section').show();
            jQuery('.graphdynamic').css('margin-left', pos);
            jQuery('.graphdynamic').css('margin-top', '-23px');
            myslider.stopAuto();
        }
    }
    //});
    /*script when we mouse leave on heading*/
    jQuery('.tag-featured').on('mouseover', function(e) {
        jQuery('.graph-section').hide();
    });
    jQuery('.frondendgraph1').on('mouseleave', function(e) {
        jQuery('.graph-section').hide();
    });
    jQuery('.containerchart, .header-section, .graph-left-side, .graph-right-side').on('mouseenter', function(event) {
        event.preventDefault();
        currentView = true;
        jQuery(this).parents('.graph-section').show();
        myslider.stopAuto();
    });
    jQuery('.graph-section').on('mouseleave', function(event) {
        event.preventDefault();
        currentView = false;
        jQuery(this).hide();
        myslider.startAuto();
    });
    jQuery('.featured-articles,.wrap-content,.sidebar-left').on('mouseleave', function(e) {
        jQuery('.graph-section').hide();
    });
    jQuery(window).load(function() {
        jQuery("#websiteloading").hide();
        jQuery(".sign-btnn").removeAttr("disabled");
        jQuery(".video_loader, .video_loader_graph").removeClass('section_show').addClass('section_hide');
        jQuery(".video-container, .video-container-graph").removeClass('section_hide');
    });
    //Quick Campaign Start    
    jQuery('.camp-btn').click(function() {
        if (jQuery('.add-camp').hasClass('noView')) {
            jQuery('.add-camp').animate({
                'left': 0
            }, 300).removeClass('noView');
            $("object").focus();
        } else {
            jQuery('.add-camp').animate({
                'left': '-317px'
            }, 300).addClass('noView');
        };
    });
    jQuery('.sbSelector, .sbToggle').on('mouseenter', function(event) {
        event.preventDefault();
        jQuery('.fa-common').removeClass('fa-sort-desc');
        jQuery('.fa-common').addClass('fa-angle-right');
    });
    jQuery('.sbSelector, .sbToggle').on('mouseleave', function(event) {
        event.preventDefault();
        jQuery('.fa-common').removeClass('fa-angle-right fa-sort-right fa-sort-asc');
        jQuery('.fa-common').addClass('fa-sort-desc');
    });
    jQuery('.sbOptions').on('mouseenter', function(event) {
        event.preventDefault();
        jQuery('.fa-common').removeClass('fa-sort-desc');
        jQuery('.fa-common').addClass('fa-sort-asc');
    });
    jQuery('.sbOptions').on('mouseleave', function(event) {
        event.preventDefault();
        jQuery('.fa-common').removeClass('fa-angle-right fa-sort-right fa-sort-asc');
        jQuery('.fa-common').addClass('fa-sort-asc');
        jQuery('.fa-common').addClass('fa-sort-desc');
    });
    //Quick Campaign End
});
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.12/jquery.bxslider.min.js"></script>
</body>
</html>



