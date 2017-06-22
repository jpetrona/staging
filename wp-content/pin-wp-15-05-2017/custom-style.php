<style type="text/css"><?php



    // Options from admin panel



global $smof_data;







if (empty($smof_data['custom_css_style'])) { $smof_data['custom_css_style'] = ''; }



if (empty($smof_data['header_color'])) { $smof_data['header_color'] = ''; }



if (empty($smof_data['entry_linkcolor'])) { $smof_data['entry_linkcolor'] = ''; }



if (empty($smof_data['entry_linkbgcolor'])) { $smof_data['entry_linkbgcolor'] = ''; }



if (empty($smof_data['header_links_color'])) { $smof_data['header_links_color'] = ''; }



if (empty($smof_data['header_text_color'])) { $smof_data['header_text_color'] = ''; }



if (empty($smof_data['footer_bgcolor'])) { $smof_data['footer_bgcolor'] = ''; }



if (empty($smof_data['main_color1'])) { $smof_data['main_color1'] = ''; }



if (empty($smof_data['main_color2'])) { $smof_data['main_color2'] = ''; }



if (empty($smof_data['thumbs_up_color'])) { $smof_data['thumbs_up_color'] = ''; }



if (empty($smof_data['thumbs_down_color'])) { $smof_data['thumbs_down_color'] = ''; }



if (empty($smof_data['color_bg_color'])) { $smof_data['color_bg_color'] = ''; }



?>



<?php



if($smof_data['custom_css_style']) {



    echo esc_html($smof_data['custom_css_style']); //Custom CSS 



}



if($smof_data['header_color']) {// header bg



    //echo esc_html('header, .sticky, .jquerycssmenu ul li ul { background-color: '. $smof_data['header_color'] .' !important; }');



}



if($smof_data['header_links_color']) {// color menu link



    echo esc_html('.jquerycssmenu ul li a  { color: '. $smof_data['header_links_color'] .' !important;}');



}



if($smof_data['header_text_color']) {// color menu text



    echo esc_html('.jquerycssmenu ul li span  { color: '. $smof_data['header_text_color'] .' !important;}');



}



if($smof_data['entry_linkcolor']) {// color link



    echo esc_html('.entry p a  { color: '. $smof_data['entry_linkcolor'] .' !important;}');



}



if($smof_data['entry_linkbgcolor']) {// bg color link



    echo esc_html('.entry p a  { background-color: '. $smof_data['entry_linkbgcolor'] .' !important;}');



}



if($smof_data['footer_bgcolor']) {// footer bg



    echo esc_html('footer .wrap-footer, .social-section { background-color: '. $smof_data['footer_bgcolor'] .' !important; }');



}



if($smof_data['main_color1']) {// 1st main color.



    echo esc_html('a:hover, .review-box-nr i, .review-box-nr, ul.aut-meta li.name a, div.feed-info i, .article_list li .an-display-author a, .widget_anthemes_categories li, div.tagcloud span, .widget_archive li, .widget_meta li, #mcTagMap .tagindex h4, #sc_mcTagMap .tagindex h4, ul.masonry_list .an-widget-title , #infscr-loading span, .rb-experience-rating, ul.article_list .an-widget-title  { color: '. $smof_data['main_color1'] .' !important;}'); //Main color = color



    echo esc_html('.bar-header, .menu-categories .jquerycssmenu ul li ul, #searchform2 .buttonicon, header .stickytop #searchform2 .buttonicon, .featured-articles .article-category, ul.masonry_list .article-category, .entry-btn, .my-paginated-posts span, #newsletter-form input.newsletter-btn, ul.article_list .article-category, #contactform .sendemail, #back-top span, .wp-pagenavi span.current, .wp-pagenavi a:hover { background-color: '. $smof_data['main_color1'] .' !important;}'); //Main bg color



    echo esc_html('.archive-header h3:after, div.entry-excerpt:after, h3.widget-title:after, .rb-resume-block .rb-experience .rb-section-title:after, .rb-resume-block .rb-experience-item .rb-right p:after, .widget h3.title:after, h3.top-title:after  { background: none repeat scroll 0% 0% '. $smof_data['main_color1'] .' !important; }'); //Main bg color



    echo esc_html('#mcTagMap .tagindex h4, #sc_mcTagMap .tagindex h4 { border-bottom: 5px solid '. $smof_data['main_color1'] .' !important;}');



    //echo esc_html('.featured-articles .title-box span a, ul.masonry_list .an-widget-title span a, .entry-top span a, div.feed-info strong, ul.article_list .an-widget-title span a, .copyright a  { border-bottom: 1px solid '. $smof_data['main_color1'] .' !important;}');



    echo esc_html('.menu-categories .jquerycssmenu ul li ul { border-top: 3px solid '. $smof_data['main_color1'] .' !important;}');



    echo esc_html('.featured-articles .article-category i, ul.masonry_list .article-category i, ul.article_list .article-category i   { border-color: '. $smof_data['main_color1'] .' transparent '. $smof_data['main_color1'] .' '. $smof_data['main_color1'] .' !important;}');



}



if($smof_data['main_color2']) {// 2nd main color.



    echo esc_html('.featured-title, .article-comm, .wp-pagenavi a, .wp-pagenavi span, .single-content h3.title, .my-paginated-posts p a, #wp-calendar tbody td#today, .comments h3.comment-reply-title, form.wpcf7-form input.wpcf7-submit { background-color: '. $smof_data['main_color2'] .' !important; }');



    echo esc_html('.single-content h3.title i, .comments h3.comment-reply-title i { border-color: '. $smof_data['main_color2'] .' transparent '. $smof_data['main_color2'] .' '. $smof_data['main_color2'] .' !important;}');



    echo esc_html('.arrow-down-related  { border-top: 10px solid '. $smof_data['main_color2'] .'!important; }');



}



if($smof_data['thumbs_up_color']) {// Thumbs color



    echo esc_html('.thumbs-rating-container .thumbs-rating-up    { color: '. $smof_data['thumbs_up_color'] .' !important; }');



}



if($smof_data['thumbs_down_color']) {// Thumbs color



    echo esc_html('.thumbs-rating-container .thumbs-rating-down    { color: '. $smof_data['thumbs_down_color'] .' !important; }');



}



if($smof_data['color_bg_color']) {



    echo esc_html('html body  { background-color: '. $smof_data['color_bg_color'] .'!important; }');



}



?>



</style>



