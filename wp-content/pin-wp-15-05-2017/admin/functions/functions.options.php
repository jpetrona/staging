<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories 		= array();  
		$of_categories_obj 	= get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp 	= array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$of_pages 			= array();
		$of_pages_obj 		= get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp 		= array_unshift($of_pages, "Select a page:");       
	
		//Testing 
		$of_options_select 	= array("one","two","three","four","five"); 
		$of_options_radio 	= array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		
		//Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		( 
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_one"		=> "Block One",
				"block_two"		=> "Block Two",
				"block_three"	=> "Block Three",
			), 
			"enabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_four"	=> "Block Four",
			),
		);


		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets = array();
		
		if ( is_dir($alt_stylesheet_path) ) 
		{
		    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
		    { 
		        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
		        {
		            if(stristr($alt_stylesheet_file, ".css") !== false)
		            {
		                $alt_stylesheets[] = $alt_stylesheet_file;
		            }
		        }    
		    }
		}


		//Background Images Reader
		$bg_images_path = get_stylesheet_directory(). '/images/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri().'/images/bg/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) { 
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		            	natsort($bg_images); //Sorts the array into a natural order
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr 		= wp_upload_dir();
		$all_uploads_path 	= $uploads_arr['path'];
		$all_uploads 		= get_option('of_uploads');
		$other_entries 		= array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat 		= array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos 			= array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		$imgs_url = get_template_directory_uri().'/images/';
		$imgs_url_demo = get_template_directory_uri().'/demo';



// Set the Options Array
global $of_options;
$of_options = array();

/*-----------------------------------------------------------------------------------*/
/* General Settings */
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 	"name" 		=> "General Settings",
						"type" 		=> "heading");

$of_options[] = array( 	"name" 		=> "Custom Logo",
						"desc" 		=> "Upload a custom logo image for your site here. Size for height should be 90px or 180px for a better display, for retina screens. ",
						"id" 		=> "site_logo",
						"std" 		=> $imgs_url.'logo.png',
						"type" 		=> "upload");

					
$of_options[] = array( 	"name" 		=> "Custom Favicon",
						"desc" 		=> "Upload a custom favicon (.ico/.png/.gif) image for your site here. Maximum size should be 32px x 32px.",
						"id" 		=> "custom_favicon",
						"std" 		=> $imgs_url.'web-icon.png',
						"type" 		=> "upload");


$of_options[] = array( 	"name" 		=> "Pagination or Infinite Scroll.",
						"desc" 		=> "",
						"id" 		=> "choose_options_home",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Default Pagination or Infinite Scroll.</h3>
						Choose the option that better fits your needs, default is Infinite Scroll.",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> "Pagination or Infinite Scroll",
						"desc" 		=> "Choose the option that better fits your needs, default is Infinite Scroll.",
						"id" 		=> "home_pag_select",
						"std" 		=> "0",
						"type" 		=> "select",
						"options" 	=> array(
										"Infinite Scroll",
										"Default Pagination"
									),
					);



$of_options[] = array( 	"name" 		=> "Featured Posts.",
						"desc" 		=> "",
						"id" 		=> "introduction_posts",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Featured Posts.</h3>
						<strong>Featured Posts</strong> - Home Page Featured Posts",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> "Featured Posts",
						"desc" 		=> "How many Featured Posts you want to display.",
						"id" 		=> "featured-posts",
						"std" 		=> "12",
						"min"		=> "1",
						"max"		=> "100",						
						"type" 		=> "sliderui");


/*-----------------------------------------------------------------------------------*/
/* Advertisement Settings */
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 	"name" 		=> "Advertisement",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-money.png"
				);

$of_options[] = array( 	"name" 		=> "Advertisement",
						"desc" 		=> "",
						"id" 		=> "introduction_banner",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Advertisement Home Page</h3>
						<strong>Advertisement</strong> - on Home page.<br /><strong style=\"color:#F00;\" font-weight: normal;>Note: The number were you want to be displayed the Advertisement need to be equal or less with the number of posts you are displaying in the first page, otherwise the banner will be hidden.</strong>",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> "300x250 (1) Home",
						"desc" 		=> "Advertisement Home Page. Paste your HTML or JavaScript code here.",
						"id" 		=> "banner_300_1",
						"std" 		=> "<a href=\"#\"><img src=\"http://placehold.it/300x250\" width=\"300\" height=\"250\" alt=\"banner\" /></a>",
						"type" 		=> "textarea");	

$of_options[] = array( 	"name" 		=> "Place the 1st Banner",
						"desc" 		=> "Banner placed by default (1st).",
						"id" 		=> "banner_p1",
						"std" 		=> "1",
						"min"		=> "0",
						"max"		=> "20",						
						"type" 		=> "sliderui");


$of_options[] = array( 	"name" 		=> "300x250 (2) Home",
						"desc" 		=> "Advertisement Home Page. Paste your HTML or JavaScript code here.",
						"id" 		=> "banner_300_2",
						"std" 		=> "<a href=\"#\"><img src=\"http://placehold.it/300x250\" width=\"300\" height=\"250\" alt=\"banner\" /></a>",
						"type" 		=> "textarea");	

$of_options[] = array( 	"name" 		=> "Place the 2nd Banner",
						"desc" 		=> "Banner placed by default (5th).",
						"id" 		=> "banner_p2",
						"std" 		=> "5",
						"min"		=> "0",
						"max"		=> "20",						
						"type" 		=> "sliderui");

$of_options[] = array( 	"name" 		=> "300x250 (3) Home",
						"desc" 		=> "Advertisement Home Page. Paste your HTML or JavaScript code here.",
						"id" 		=> "banner_300_3",
						"std" 		=> "<a href=\"#\"><img src=\"http://placehold.it/300x250\" width=\"300\" height=\"250\" alt=\"banner\" /></a>",
						"type" 		=> "textarea");	

$of_options[] = array( 	"name" 		=> "Place the 3rd Banner",
						"desc" 		=> "Banner placed by default (12th).",
						"id" 		=> "banner_p3",
						"std" 		=> "12",
						"min"		=> "0",
						"max"		=> "20",						
						"type" 		=> "sliderui");

$of_options[] = array( 	"name" 		=> "300x250 (4) Home",
						"desc" 		=> "Advertisement Home Page. Paste your HTML or JavaScript code here.",
						"id" 		=> "banner_300_4",
						"std" 		=> "",
						"type" 		=> "textarea");	

$of_options[] = array( 	"name" 		=> "Place the 4th Banner",
						"desc" 		=> "Banner placed by default (12th).",
						"id" 		=> "banner_p4",
						"std" 		=> "12",
						"min"		=> "0",
						"max"		=> "25",						
						"type" 		=> "sliderui");


$of_options[] = array( 	"name" 		=> "300x250 (5) Home",
						"desc" 		=> "Advertisement Home Page. Paste your HTML or JavaScript code here.",
						"id" 		=> "banner_300_5",
						"std" 		=> "",
						"type" 		=> "textarea");	

$of_options[] = array( 	"name" 		=> "Place the 5th Banner",
						"desc" 		=> "Banner placed by default (12th).",
						"id" 		=> "banner_p5",
						"std" 		=> "12",
						"min"		=> "0",
						"max"		=> "30",						
						"type" 		=> "sliderui");


$of_options[] = array( 	"name" 		=> "Advertisement",
						"desc" 		=> "",
						"id" 		=> "introduction_banner",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Advertisement Article Page</h3>
						<strong>Advertisement</strong> - on Article page.",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> "728x90 Article Top",
						"desc" 		=> "The ads will be displayed the Top in the Article page. Paste your HTML or JavaScript code here.",
						"id" 		=> "header_728",
						"std" 		=> "<a href=\"#\"><img src=\"http://placehold.it/728x90/ffd800/FFF&amp;text=AD+BLOCK+728x90+>+Theme+Options+>+Advertisement\" width=\"728\" height=\"90\" alt=\"banner\" /></a>",
						"type" 		=> "textarea");	

$of_options[] = array( 	"name" 		=> "300x250 Article Right",
						"desc" 		=> "Entry Posts (right). Paste your HTML or JavaScript code here.",
						"id" 		=> "ads_entry_top",
						"std" 		=> "<a href=\"#\"><img src=\"http://placehold.it/300x250\" width=\"300\" height=\"250\" alt=\"banner\" /></a>",
						"type" 		=> "textarea");	

$of_options[] = array( 	"name" 		=> "728x90 Article Bottom",
						"desc" 		=> "The ads will be displayed at the bottom in the article page. Paste your HTML or JavaScript code here.",
						"id" 		=> "bottom728",
						"std" 		=> "<a href=\"#\"><img src=\"http://placehold.it/728x90/ffd800/FFF&amp;text=AD+BLOCK+728x90+>+Theme+Options+>+Advertisement\" width=\"728\" height=\"90\" alt=\"banner\" /></a>",
						"type" 		=> "textarea");	



/*-----------------------------------------------------------------------------------*/
/* Style Settings */
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 	"name" 		=> "Style Settings",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-paint.png");

$of_options[] = array( 	"name" 		=> "Boxed Version",
						"desc" 		=> "",
						"id" 		=> "introduction_boxedv",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Boxed Version</h3>
						The options control the boxed version",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> "Boxed Version",
						"desc" 		=> "Display Boxed Version (Yes) or the Full Width Version (No).",
						"id" 		=> "boxed_version_select",
						"std" 		=> "No",
						"type" 		=> "select",
						"options" 	=> array(
										"Yes",
										"No"
									),
					);

$of_options[] = array( 	"name" 		=> "Background Image",
						"desc" 		=> "Background Image can have any size, the option is available only if you use the Boxed Version!",
						"id" 		=> "background_img",
						"std" 		=> $imgs_url.'bg.jpg',
						"type" 		=> "upload"
				);

$of_options[] = array( 	"name" 		=> "Style",
						"desc" 		=> "",
						"id" 		=> "introduction_14",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Style Settings.</h3>
						The style options control the main color styling of the site. <br />To change all colors of the site, open <strong>Theme folder / css / colors / default.css</strong> file.",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> "Main Color (red)",
						"desc" 		=> "Use the color picker to change the main color of the site to match your brand color.",
						"id" 		=> "main_color1",
						"std" 		=> "#dd3333",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> "Main Color (black)",
						"desc" 		=> "Use the color picker to change the main color of the site to match your brand color.",
						"id" 		=> "main_color2",
						"std" 		=> "#000000",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> "Footer Background color",
						"desc" 		=> "Use the color picker to change the footer background color to match your brand color.",
						"id" 		=> "footer_bgcolor",
						"std" 		=> "#000000",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> "Header Background color",
						"desc" 		=> "Use the color picker to change the header background color to match your brand color.",
						"id" 		=> "header_color",
						"std" 		=> "#000000",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> "Menu Links color",
						"desc" 		=> "Use the color picker to change the color of the links from the menu.",
						"id" 		=> "header_links_color",
						"std" 		=> "#FFFFFF",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> "Menu text color",
						"desc" 		=> "Use the color picker to change the color of the text/description from the menu.",
						"id" 		=> "header_text_color",
						"std" 		=> "#5a5a5b",
						"type" 		=> "color"
				);


$of_options[] = array( 	"name" 		=> "Style",
						"desc" 		=> "",
						"id" 		=> "introduction_14",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Style Settings.</h3>
						The style options control the main color styling of the site. <br />To change all colors of the site, open <strong>Theme folder / css / colors / default.css</strong> file.",
						"icon" 		=> true,
						"type" 		=> "info");


$of_options[] = array( 	"name" 		=> "Entry Link Background Color",
						"desc" 		=> "Use the color picker to change the entry link background color on article or default / full width pages.",
						"id" 		=> "entry_linkbgcolor",
						"std" 		=> "#dd3333",
						"type" 		=> "color"
				);


$of_options[] = array( 	"name" 		=> "Entry Link Color",
						"desc" 		=> "Use the color picker to change the entry link color on article or default / full width pages.",
						"id" 		=> "entry_linkcolor",
						"std" 		=> "#FFFFFF",
						"type" 		=> "color"
				);


$of_options[] = array( 	"name" 		=> "Thumbs rating up",
						"desc" 		=> "Use the color picker to change the color to match your brand color.",
						"id" 		=> "thumbs_up_color",
						"std" 		=> "#6ecb0a",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> "Thumbs rating down",
						"desc" 		=> "Use the color picker to change the color to match your brand color.",
						"id" 		=> "thumbs_down_color",
						"std" 		=> "#fe6969",
						"type" 		=> "color"
				);


$of_options[] = array( 	"name" 		=> "Style",
						"desc" 		=> "",
						"id" 		=> "introduction_14",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Style Settings.</h3>
						The style options control the main color styling of the site. <br />To change all colors of the site, open <strong>Theme folder / css / colors / default.css</strong> file.",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> "Background Color",
						"desc" 		=> "Pick a background color for the theme.",
						"id" 		=> "color_bg_color",
						"std" 		=> "#f6f5f2",
						"type" 		=> "color"
				);


$of_options[] = array( 	"name" 		=> "Custom CSS.",
						"desc" 		=> "",
						"id" 		=> "introduction_customcss",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Custom CSS.</h3>
						Enter your custom CSS code. It will be included in the head section of the page.",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> "Custom CSS",
						"desc" 		=> "Enter your custom CSS code. It will be included in the head section of the page.",
						"id" 		=> "custom_css_style",
						"std" 		=> "",
						"type" 		=> "textarea");



/*-----------------------------------------------------------------------------------*/
/* Contact Settings */
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 	"name" 		=> "Contact Settings",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-info.png");

$of_options[] = array( 	"name" 		=> "Email address.",
						"desc" 		=> "",
						"id" 		=> "introduction_7",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Email address.</h3>
						<strong>Contact form</strong> - add your email address.",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> "Contact Form Email",
						"desc" 		=> "Enter the email address where you'd like to receive emails from the Contact form, or leave this field blank to use admin email.",
						"id" 		=> "contact_email",
						"std" 		=> "",
						"type" 		=> "text"); 

$of_options[] = array( 	"name" 		=> "Confirmation message",
						"desc" 		=> "",
						"id" 		=> "introduction_8",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Confirmation message</h3>
						<strong>Confirmation message</strong> - add your message.",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> "Confirmation message",
						"desc" 		=> "Add a confirmation message.",
						"id" 		=> "contact_confirmation",
						"std" 		=> "Thanks, your email was sent successfully.",
						"type" 		=> "textarea");	




/*-----------------------------------------------------------------------------------*/
/* Footer Settings */
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 	"name" 		=> "Footer Settings",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-settings.png");



$of_options[] = array( 	"name" 		=> "Social Icons.",
						"desc" 		=> "",
						"id" 		=> "introduction_social",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Social Icons.</h3>
						<strong>Social Icons</strong> - for footer.",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> "Social Icons",
						"desc" 		=> "You can use HTML code.<br /> For more social icons go to <a href=\"http://fontawesome.io/icons/\" target=\"_blank\">fontawesome</a> and at the bottom you have Brand Icons!",
						"id" 		=> "bottom_icons",
						"std" 		=> "<ul class=\"footer-social\">
<li><a href=\"#\"><i class=\"fa fa-twitter\"></i></a></li>
<li><a href=\"#\"><i class=\"fa fa-facebook\"></i></a></li>
<li><a href=\"#\"><i class=\"fa fa-google-plus\"></i></a></li>
<li><a href=\"#\"><i class=\"fa fa-youtube\"></i></a></li>
<li><a href=\"#\"><i class=\"fa fa-vimeo-square\"></i></a></li>
<li><a href=\"#\"><i class=\"fa fa-tumblr\"></i></a></li>
<li><a href=\"#\"><i class=\"fa fa-dribbble\"></i></a></li>
<li><a href=\"#\"><i class=\"fa fa-pinterest\"></i></a></li>
<li><a href=\"#\"><i class=\"fa fa-linkedin\"></i></a></li>
<li><a href=\"#\"><i class=\"fa fa-flickr\"></i></a></li>
<li><a href=\"#\"><i class=\"fa fa-rss\"></i></a></li>
</ul>",
						"type" 		=> "textarea");	

$of_options[] = array( 	"name" 		=> "Copyright",
						"desc" 		=> "You can use HTML code.",
						"id" 		=> "copyright_footer",
						"std" 		=> "Pin is a Stylish and Responsive Pinterest-style Theme for Bloggers.<br /> Copyright &copy; 2015 - Theme by <a href=\"http://themeforest.net/user/An-Themes/portfolio?ref=An-Themes\">An-Themes</a>",
						"type" 		=> "textarea");	


/*-----------------------------------------------------------------------------------*/
/* Backup Options */
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 	"name" 		=> "Backup Options",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-slider.png"
				);
				
$of_options[] = array( 	"name" 		=> "Backup and Restore Options",
						"id" 		=> "of_backup",
						"std" 		=> "",
						"type" 		=> "backup",
						"desc" 		=> 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
				);
				
$of_options[] = array( 	"name" 		=> "Transfer Theme Options Data",
						"id" 		=> "of_transfer",
						"std" 		=> "",
						"type" 		=> "transfer",
						"desc" 		=> 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',
				);




				
	}//End function: of_options()
}//End chack if function exists: of_options()
?>
