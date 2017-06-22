	<?php
	/*
	Template Name: Add Campaign
	*/

	include( ABSPATH.'/config.php'); 
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	get_header(); // add header
	
	?>
	<style type="text/css">
		.inner-prfl-page{
			box-sizing:unset;
		}
		.prfl-avtar-img{
			box-sizing:unset;
		}
		.profile-menu{
			margin-top: -102px;
		}


		.avatar-tag-line{
			top:-32px !important;
		}
		.avatar-name-prfl-content{
			color:#fff;
		}
	</style>
	<?php echo do_shortcode("[SignIn]"); ?>
 	         
	<?php session_start();
	$user_id = get_current_user_id();
	$password1 = get_user_meta( $user_id, 'userpassword', true);
	$current_user = wp_get_current_user();
	$email1 = $current_user->data->user_email;
	$result1=mysql_query("select * from retire_db.advisors where email='$email1' and password='$password1'") or die(mysql_error());
	$row_count=mysql_num_rows($result1);
	if($row_count > 0){
		session_start();
		$row = mysql_fetch_array($result1);
		$_SESSION['advisorid'] = $row['advisorid'];
		$_SESSION['name'] = $row['fname']." ".$row['lname'];
		$result = "1";
	}
	else{
		$result = "Invalid Email or Password.";
	} 	

	$wp_upload_folder =  wp_upload_dir();

	if($_SESSION["advisorid"]=="")
	{
	header("location:".site_url());
	} 
	if(isset($_POST['signup'])){

		$email = $_POST['email'];	

		$pwd = $_POST['password'];

		$pwd = mysql_escape_string(md5($pwd));

		$fname = $_POST['firstname'];

		$lname = $_POST['lastname'];

		$location = $_POST['city'];

		$phone = $_POST['phone'];

		$terms = $_POST['terms'];

		$name = $fname." ".$lname;

		$date = date('YmdHis');  

		$auth ="SELECT * FROM `advisors` where email ='$email'";

		$result =  mysql_query($auth);

		$row = mysql_num_rows($result);	

		if($row == 0)

		{

			$q = "INSERT INTO advisors VALUES ('','$fname','$lname','$email','','','$pwd','','$location',0,'','','','','','$phone',

	'','',0,0,'','','',0,'{$date}',10,0,0,'{$date}','','$terms')";

			if(mysql_query($q))

			{

				$id = mysql_insert_id(); 

				session_start();

				$row = mysql_fetch_array($result);

				$_SESSION['advisorid'] = $id;

				$_SESSION['name'] = $name;

				$result = "1";

			}

			else

			{

				$result  = "Error in processing your request.";

			}

		}

		else

		{

			$result  = "Email already register. Please use another email.";

		}

	}
	?>
	<?php 
	if(isset($_POST['submit']) || isset($_POST['password'])){
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		
		$myusername = stripslashes($username);
		$mypassword = stripslashes($password);
		$myemail = stripslashes($email);
		$myusername = mysql_real_escape_string($myusername);
		$mypassword = mysql_real_escape_string($mypassword);
		$myemail = mysql_real_escape_string($myemail);
		$password = md5($mypassword);
		$sdkadminid = $_SESSION["advisorid"];
		$sql = mysql_query("INSERT INTO `adminusers`(`adminuserid`, username, `email`, `password`, `status`, `role`,`advisorid`) VALUES (NULL,'".$username."','".$email."','".$password."',10,'manageruser','".$sdkadminid."')") or die(mysql_error());
	$subject = 'Thank You';
	$headers = "MIME-Version: 1.0" . "\r\n";
	$message = '<b>Hi '.$myusername.'</b>,<br />
	<br />
	Thanks for the Registration !<br /><br />


	You can now Add app and integrate Intlfaces SDK here...<br /><br />

	http://me.intlfaces.com/campaign.php<br /><br />


	For Support :<br /><br />

	http://me.intlfaces.com/support.php<br /><br />

	You can also mail us directly at admin@intlfaces.com, or call us at 805-284-9336.<br /><br /><br />Support Team,<br /><b>Intlfaces </b>';
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	$headers .= 'From: Intlfaces <admin@intlfaces.com>' . "\r\n";
	mail($email,$subject,$message,$headers);
		}
	?>
	<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=='delete' && $_REQUEST['id']!='' )
	{
		/*$sql="DELETE FROM `offers` WHERE `offerid`=".$_REQUEST['id'];
		if(mysql_query($sql))
	    {	  */
        $sql="DELETE FROM ".RETIRELY_DB.".offers WHERE `offerid`=".$_REQUEST['id'];
        $sql1="DELETE FROM ".RETIRELY_DB_OFFERWALL.".offers WHERE `extofferid`=".$_REQUEST['id'];
        mysql_query($sql1);
        if(mysql_query($sql))
        {
	?>
	<script>
			window.location.href = "<?php echo get_option('home');?>/add-campaign";</script>
	<?php 
	   }
	}
	?>
	<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=='acnt_delete' && $_REQUEST['id']!='' )
	{
		$sql="DELETE FROM `adminusers` WHERE `adminuserid`=".$_REQUEST['id'];
		if(mysql_query($sql))
	    {	    
		?>
	<script>
			window.location.href =  "<?php bloginfo('siteurl');?>/add-campaign";</script>
	<?php 
	   }
	}?>
	<?php
	if(isset($_GET['report_submit'])){
	$id = $_GET["id"];
	$from = $_GET["from"];
	$to = $_GET["to"];
	$q=mysql_query("select * from offers where advisorid = '$id'");
	if(mysql_num_rows($q) > 0)
	{	
		$row = mysql_fetch_assoc($q);
		echo "<select id='offer_name'>
		<option value=".$row["offerid"].">".$row['title']."</option>
		</select>";
		$appname = $row["title"];
		$date = $row["date"];
	}

	 $q = "SELECT DATE_FORMAT( date, '%m/%d/%Y' ) as dt FROM `offers` WHERE offerid = '$id' AND date BETWEEN '$from'
	AND '$to' GROUP BY MONTH( date )ORDER BY MONTH( date ) ASC ";
			   $res = mysql_query($q) or die(mysql_error());
			   $dates;
			  if(mysql_num_rows($res) > 0)
			  {	
				  while($row = mysql_fetch_assoc($res))
				  {
					   $dates[] = $row['dt'];
				  } 
			  } 
	}
	?>
	<?php 
	$fund=0.00;
	$admin_id = $_SESSION["advisorid"];
	if($admin_id == 172 ){
			$q = "SELECT sum(amount) as fund FROM adminfund WHERE status='Complete'";
			$res =  mysql_query($q) or die(mysql_error());
			if(mysql_num_rows($res) > 0)
			{
			  $row = mysql_fetch_assoc($res);
			  $fund = $row["fund"];
			}
		}
		else{
			$q = "SELECT sum(amount) as fund FROM adminfund WHERE advisorid = $admin_id and status='Complete'";
			$res =  mysql_query($q) or die(mysql_error());
			if(mysql_num_rows($res) > 0)
			{
			  $row = mysql_fetch_assoc($res);
			  $fund = $row["fund"];
			}
		}
	if(!$fund){
		$fund=0;
	}
	?>
	                <!doctype html>
	                <html lang="en">
								<head>
								<meta charset="utf-8">
								<meta name="viewport" content="width=device-width, initial-scale=1.0">
								<meta name="author" content="retirely">
								<meta name="description" content="">
								<meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT"/>
								<meta http-equiv="pragma" content="no-cache" />
								<title>Retire.ly</title>
								<!--favicon-->
								<link href="<?php bloginfo('template_directory'); ?>/images/favicon.png" rel="shortcut icon">
								<!--fonts-->
								<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700,800,600,300' rel='stylesheet' type='text/css'>
								<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
								<!--css-->
								<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/ajax/bootstrap.css">
								<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/ajax/style.css">
								<link href="<?php bloginfo('template_directory'); ?>/css/jquery.selectbox.css" type="text/css" rel="stylesheet" />
								<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/css/ajax/jsDatePick_ltr.min.css" />
								 <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
 								<script src="<?php bloginfo('template_directory'); ?>/js/jquery-1.7.2.min.js"></script>
								<style type="text/css">
	.onoffswitch {
		position: relative;
		width: 90px;
		-webkit-user-select:none;
		-moz-user-select:none;
		-ms-user-select: none;
		float: left;
	}
	.onoffswitch-checkbox {
		display: none;
	}
	.onoffswitch-label {
		display: block;
		overflow: hidden;
		cursor: pointer;
		border: 2px solid #999999;
		border-radius: 20px;
	}
	.onoffswitch-inner {
		width: 200%;
		margin-left: -100%;
		-moz-transition: margin 0.3s ease-in 0s;
		-webkit-transition: margin 0.3s ease-in 0s;
		-o-transition: margin 0.3s ease-in 0s;
		transition: margin 0.3s ease-in 0s;
	}
	.onoffswitch-inner:before, .onoffswitch-inner:after {
		float: left;
		width: 50%;
		height: 30px;
		padding: 0;
		line-height: 30px;
		font-size: 14px;
		color: white;
		font-family: Trebuchet, Arial, sans-serif;
		font-weight: bold;
		-moz-box-sizing: border-box;
		-webkit-box-sizing: border-box;
		box-sizing: border-box;
	}
	.onoffswitch-inner:after {
		content: "ON";
		padding-left: 10px;
		background-color: #2FCCFF;
		color: #FFFFFF;
	}
	.onoffswitch-inner:before {
		content: "OFF";
		padding-right: 10px;
		background-color: #EEEEEE;
		color: #999999;
		text-align: right;
	}
	.onoffswitch-switch {
		width: 18px;
		margin: 6px;
		background: #FFFFFF;
		border: 2px solid #999999;
		border-radius: 20px;
		position: absolute;
		top: 0;
		bottom: 5px;
		right: 56px;
		-moz-transition: all 0.3s ease-in 0s;
		-webkit-transition: all 0.3s ease-in 0s;
		-o-transition: all 0.3s ease-in 0s;
		transition: all 0.3s ease-in 0s;
	}
	.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
		margin-left: 0;
	}
	.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
		right: 0px;
	}
	#display {
		text-align:center;
		font-size:14px;
		font-weight:bold;
		margin-top:5px;
	}
	</style>
	

	<script type="text/javascript">
		window.onload = function(){
			new JsDatePick({
				useMode:2,
				target:"inputField",
				dateFormat:"%Y-%m-%d",
				yearsRange:[2012,2020],
				limitToToday:true
			});
			
			new JsDatePick({
				useMode:2,
				target:"inputField1",
				dateFormat:"%Y-%m-%d",
				yearsRange:[2012,2020],
				limitToToday:true
			});
			
			new JsDatePick({
				useMode:2,
				target:"view_app",
				dateFormat:"%Y-%m-%d",
				yearsRange:[2012,2020],
				limitToToday:true
			});
			new JsDatePick({
				useMode:2,
				target:"view_app1",
				dateFormat:"%Y-%m-%d",
				yearsRange:[2012,2020],
				limitToToday:true
			});
		};
	</script> 
	<script type="text/javascript">
		function toggle(id){
			var id= $("#id"+id).val();
			var ctv= $("#hfonoff"+id).val();//current toggle
			console.log(ctv);
			if (ctv == 10)
			{
				var a=0;
				var b = id; 
			 
				$("#hfonoff"+id).val("0");
			}
			else
			{
				var a=10;
				var b = id; 
				 
				$("#hfonoff"+id).val("10");
			}
	 
			$.ajax({
				type: "POST",
				url: "<?php bloginfo('siteurl');?>/ajax/ajax.php",
				data: "value="+a+"&id="+b,
				success: function(html){
					$("#running_campaign").html(html);
					$("#display").html(html).show();
				}
			});
			if(a == 0){
				$('#oson'+id).css({"margin-left":"0px"});
				$('#osoff'+id).css({"right":"56px"});
			}
			else{
				$('#oson'+id).css({"margin-left":"-100%"});
				$('#osoff'+id).css({"right":"0"});
			}
		}
		function addCommas(nStr)
		{
			nStr += '';
			x = nStr.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + ',' + '$2');
			}
			return x1 + x2;
		}
		function edit_bid(offerid){	
		var offerid1 = offerid;
		var total_fund = $('#total_fund').val();
		var bid = $('#bid'+offerid).val();
		var bid = parseFloat(bid);
		var total_fund =  parseFloat(total_fund);
		if(bid > total_fund){
			  $("#total_budget").val(""); 
			  $("#budget_errorbid").show();
			  return false;
			}
			else{
				$("#budget_errorbid").hide();
				$.ajax({
					type: "POST",
					url: "<?php bloginfo('siteurl');?>/ajax/status.php",
					data: "offerid="+offerid1+"&bid="+bid,
					success: function(html){
						alert('Bid Amount is updated Successfully!');
					}
					});
			}
		}
	</script>
	<script type="text/javascript">
	jQuery(document).ready( function($){
	//set all toggle values
	$("#view-all-app").hide();
	$('#graph_data').hide();
	$('#chng-detl').hide();
	$('#done').hide();
	$('.scheme').hide();
	$('#setting_data').hide();
	$('#four_submit').attr("disabled", false);
	$(".step1").addClass("active");
		 $( ".onoffswitch" ).each(function( index, element ) {
			 var offerid= $(this).data('loop');
			 console.log(offerid);
			 var val = $("#hfonoff"+offerid).val();
				if(val == "0"){
					$('#oson'+offerid).css({"margin-left":"0px"});
					$('#osoff'+offerid).css({"right":"56px"});
				}
				else{
					$('#oson'+offerid).css({"margin-left":"-100%"});
					$('#osoff'+offerid).css({"right":"0"});
				}
		});
		
		$(".cb-enable").click(function(){
		var parent = $(this).parents('.switch');
		$('.cb-disable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', true);
		});
		$(".cb-disable").click(function(){
		var parent = $(this).parents('.switch');
		$('.cb-enable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', false);
		});
	});
	</script>

	<script>
	jQuery(document).ready(function($){
			//$(".analytic-wrapper").show();
			//$("#iframe").attr('src',url);
			//return false;
			//
			//alert(url);
			// error code
	/*		$('#report').submit(function (e) {
				e.preventDefault();
				$.ajax({
					type: 'get',
					url: url,
					data: {},
					success: function (data) {
						$("#iframe").attr('src',url);
						$(".analytic-wrapper").show();
					}
				});
			});*/
		$.ajax({
			type: "POST",
			url: "<?php bloginfo('siteurl');?>/ajax/getfund.php",
			data: "",
			success: function(html){
				var getfund = $('#getfund').val();
				var availablebal = parseFloat(getfund) - parseFloat(html);
				//availablebal = parseFloat(html);
				availablebal = availablebal.toFixed(2);
				//cosole.log(addCommas(availablebal));	
				//alert(availablebal);
				if( isNaN(availablebal) )
				{
					availablebal = 0;
				}

				availablebal = availablebal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				$('.abal').html('$'+availablebal);
				 
			}
			});
			/*$(document).ajaxComplete(function(){ 
				$("#response").css("display","none");
				});*/
			$(".check-live").hide();
			$(".show_link").show();
			$("#results").hide();
			$('#cbislive').attr('checked',false); 
			$("#showmsg").hide();
			  $("#text_box_url").blur(function() {
				var input = $(this);
				var val = input.val();
				if (val && !val.match(/^http([s]?):\/\/.*/)) {
					input.val('http://' + val);
				}
			  });
				$('.side-nav').hide();
				$('ul.side-nav.first').show();
				$('.side-nav-title').on('click', function (e) {
					e.preventDefault();
					var elem = $(this).next('.side-nav')
					$('.side-nav').not(elem).hide('slow');
					elem.toggle('slow');
				});			
				
			$('#all').click(function(){
				$('.all-cntry').addClass('active');
				$('.slectd-cntry').removeClass('active');
				$('.add-country-block').css({'display': 'none'})
			});

			$('#selected').click(function(){
				$('.slectd-cntry').addClass('active');
				$('.all-cntry').removeClass('active');
				$('.add-country-block').css({'display': 'block'})
			});
			
		$('#first_submit').click( function(){
			$('#step1').submit(function (e) {
				e.preventDefault();
				/*$('#img_response1').css("display","block");
				$('#img_response1').text('Loading...');*/
				$('.loader').fadeIn(2000);
				//$('#img_response').html('<img src="<?php //bloginfo('template_directory'); ?>/images/loading.gif">')
				$.ajax({
					type: 'post',
					url: '<?php bloginfo("siteurl");?>/ajax/step1.php',
					data: $(this).serialize(),
					success: function () {
						$(".product-form").hide();
						$(".brand-form").show();
						$(".track-form").hide();
						$(".bid-form").hide();
						$(".get-link").hide();			
						$(".step1").removeClass("completed");
						$(".step2").addClass("completed");
						$(".step3").removeClass("completed");
						$(".step4").removeClass("completed");
						$(".show_hide").hide();
						$("#view-all-app").hide();
						$('.loader').fadeOut(2000);
						//$("#img_response1").css("display","none");
						
						if($('#url').val()!==""){
							$('.divituneimage').show();
							$('#image_to_upload').hide();
							$('#image_to_upload').removeAttr( 'required' );
							$('.select_icon').hide();
							}
						else {
							$('.divituneimage').hide();
							}
					}
				});
			});
		});
		
		
		$('#second_submit').click( function(){	
			$('#step2').submit(function (e) {
				e.preventDefault();
				$('.loader').fadeIn(2000);
				/*$('#img_response2').css("display","block");
				$('#img_response2').text('Loading...');*/
				$.ajax({
					type: 'post',
					url: "<?php bloginfo('siteurl');?>/ajax/step1.php",
					data: $(this).serialize(),
					success: function () {
						$(".product-form").hide();
						$(".brand-form").hide();
						$(".track-form").show();
						$(".bid-form").hide();
						$(".step3").addClass("completed");
						$(".step1").removeClass("completed");
						$(".step2").removeClass("completed");
						$(".step4").removeClass("completed");
						$("#view-all-app").hide();
						$('.loader').fadeOut(2000);
						//$("#img_response2").css("display","none");
					}
				});
			});
		});
		
		$('#third_submit').click( function(){	
			$('#step3').submit(function (e) {
				e.preventDefault();
				$('.loader').fadeIn(2000);
				/*$('#img_response3').css("display","block");
				$('#img_response3').text('Loading...');*/
				$.ajax({
					type: 'post',
					url: "<?php bloginfo('siteurl');?>/ajax/step1.php",
					data: $(this).serialize(),
					success: function () {
						$(".product-form").hide();
						$(".brand-form").hide();
						$(".track-form").hide();
						$(".bid-form").show();
						$(".step4").addClass("completed");
						$(".step2").removeClass("completed");
						$(".step1").removeClass("completed");
						$(".step3").removeClass("completed");
						$("#view-all-app").hide();
						$('.loader').fadeOut(2000);
						//$('#img_response3').css("display","none");
					}
				});
			});
		});
		
		$('#four_submit').click( function(){	
			$('#step4').submit(function (e) {
				e.preventDefault();
				$('.loader').fadeIn(2000);
				/*$('#img_response4').css("display","block");
				$('#img_response4').text('Loading...');*/
				$('#four_submit').attr("disabled", true);
				$.ajax({
					type: 'post',
					url: "<?php bloginfo('siteurl');?>/ajax/step1.php",
					data: $(this).serialize(),
					success: function (data1) {
						$(".product-form").hide();
						$(".brand-form").hide();
						$(".track-form").hide();
						$(".bid-form").hide();
						$(".get-link").show();
						$("#trackurl").val(data1);
						$(".show_link").show();
						$(".show_hide").show();
						$('#done').show();
						$("#view-all-app").hide();
						$(".step4").addClass("completed");
						$(".step2").removeClass("completed");
						$(".step3").removeClass("completed");
						$(".step1").removeClass("completed");
						$('.loader').fadeOut(2000);
						//$('#img_response4').css("display","none");
					}
				});
			});
		});

	$('#report_submit').click( function(){	
			var  id = $("#offer_name").val();
			var  from = $("#inputField").val();
			var  to = $("#inputField1").val();
			id = encodeURIComponent(id);
			var x = Math.floor((Math.random() * 1000) + 1);
			var xurl = '<?php bloginfo("siteurl");?>/ajax/report_new.php?id='+id+'&from='+from+'&to='+to+"&rand="+x;
			//$(".analytic-wrapper").show();
			//$("#iframe").attr('src',url);
			//return false;
			
			$('#report').submit(function (e) {
				e.preventDefault();
				$.ajax({
					type: 'get',
					url: xurl,
					data: {},
					success: function (data) {
						$("#iframe").attr('src',xurl);
						$(".analytic-wrapper").show();
					}
				});
			});
		});
		
		$('#view_app_report_submit').click( function(){	
			var  id = $("#app_name").val();
			var  from = $("#view_app").val();
			var  to = $("#view_app1").val();
			id = encodeURIComponent(id);
			var xurl = '<?php bloginfo("siteurl");?>/ajax/report_new.php?id='+id+'&from='+from+'&to='+to;
			//$(".analytic-wrapper").show();
			//$("#iframe").attr('src',url);
			//return false;
			$('#app_report').submit(function (e) {
				e.preventDefault();
				$.ajax({
					type: 'get',
					url: xurl,
					data: {},
					success: function (data) {
						$("#view_app_iframe").attr('src',xurl);
						$(".analytic-wrapper").show();
					}
				});
			});
		});
		
	$('#update_detail').click( function(){	
			$('#update_user_info').submit(function (e) {
				e.preventDefault();
				/*$('#img_response4').css("display","block");
				$('#img_response4').text('Loading...');
				$('#four_submit').attr("disabled", true);*/
				$.ajax({
					type: 'post',
					url: '<?php bloginfo("siteurl");?>/ajax/update_user.php',
					data: $(this).serialize(),
					success: function (data1) {
						alert(data1);
					}
				});
			});
		});
		//jQuery.noConflict(); 
			/*jQuery(document).ajaxComplete(function(){
				jQuery("#img_response").css("display","none");
			}); */ 
		formdata = new FormData();     
		jQuery("#image_to_upload").on("change", function() {
			
			var file = this.files[0];
			if (formdata) {
				formdata.append("image", file);
				$('.loader').fadeIn(2000);
				//$('#img_response').text('Loading...');
				//$('#img_response').html('<img src="<?php //bloginfo('template_directory'); ?>/images/loading.gif">')
				jQuery.ajax({
					url: "<?php bloginfo('siteurl');?>/ajax/showpic.php",
					type: "POST",
					data: formdata,
					processData: false,
					contentType: false,
					success:function(data){				
						//if(data=='File size must be 6kb and diamention must be 50 x 50')
						//{
						//	$("#image_to_upload").val(null);
						//}
						//else {
							$("#icon").attr('src', $.trim(data ) );
							$("#icon_pic").val($.trim(data ));
							$("#results").attr('src' , $.trim(data ) );
							$("#results").show();
							$('.loader').fadeOut(2000);
							//document.getElementById("icon").innerHTML = data;
						//}
					}
				});
			}                      
		});
		/*$('#selected').click( function(){
			$('.add-country-block').show();
			$("#showmsg").hide();
		});*/
	});

	function remove_live(val){
			if( val=='android' || val=='web' || val=='' ){
				$(".check-live").hide();
				$('#cbislive').attr('checked',false); 
				$(".all_app1").hide();
				$("#primaryGenreName").val(""); 
				$("#version").val(""); 
				$("#trackId").val(""); 
				$("#Rating").val(""); 
				$("#trackName").val("");
				$("#text_box_url").val(""); 
				$("#url").val("");
				$(".scheme").hide();
				$('#scheme').removeAttr('required');
				$("#divituneimageimg").attr('src', '<?php bloginfo('template_directory'); ?>/images/default.png');
				}
			else{
				$(".scheme").show();
				$(".check-live").show();
				$(".all_app1").hide();
				$("#divituneimageimg").show();
				}
				
				if(val=='android' || val=='ios'){
					$(".wbtype").hide();
					$(".wbtype").hide();
					}else{
						$( ".wbtype" ).show();
						$( ".wbtype" ).show();
						$( ".smtype" ).hide();
						$( "#wbtype" ).show();
						}
			}
	function check_app(val){
		if(val){	
		var appname = $("#txtappname").val();
		var app_category = $('#app_category').val();
		$.ajax({
			type: "POST",
			url: "<?php bloginfo('siteurl');?>/ajax/check_app.php",
			data: "appname="+appname+"&app_category="+app_category,
			success: function(html){
				if(html =='fail'){
					alert('This app is alreay added in your account!');
					$("#txtappname").val("");
					$('#app_category').val("");
					$('#cbislive').attr('checked',false); 
					$(".all_app1").hide();
					}
					else{
						getAppData(val);
						}
				
				}	
			});
		}
	}

	function getAppData(val){
		if(val){
			
				$("#divituneimageimg").attr('src', "<?php bloginfo('template_directory'); ?>/images/default.png");
				$("#divituneimageimg").hide();
				//$(".all_app1").html("");
				$('.del').remove();
				$(document).ajaxComplete(function(){
				//$("#response").css("display","none");
				$('.loader').fadeOut(2000);
				});
				var appname = $("#txtappname").val();
				var url = "http://itunes.apple.com/search?term="+appname+"&media=software";
				//$("#response").css("display","block");
				$('.loader').fadeIn(2000);
				//$('#response').html('<img src="<?php bloginfo('template_directory'); ?>/images/loading.gif">')
				$.ajax({
						url : url,
						type : 'GET',
						dataType: 'jsonp',
						data: {},
						xhrFields: {
						   withCredentials: false
						},
						crossDomain: true,
						success: function(result) {
							if(result && result.resultCount == 1){
								var obj = result.results;
								JSON.parse(JSON.stringify(obj), function (key, value) {
									var type;							
										if(key == "primaryGenreName"){
										var cat = value;
										$("#primaryGenreName").val(cat);
										$("#lstCategory").val($("#primaryGenreName").val());
										$("#lstCategory").val(value);
										}
											
										if(key == "version"){
										var vcat = value;
										$("#version").val(vcat);
										}
										
										if(key == "trackId"){
										var tcat = value;
										$("#trackId").val(value);
										}
										
										if(key == "contentAdvisoryRating"){
										var rcat = value;
										$("#Rating").val(value);
										}
										
										if(key == "sellerName"){
										var scat = value;
										$("#sellerName").val(scat);
										}
										
										if(key == "trackName"){
										$("#trackName").val(value);
										$("#txtappname").val(value);
										}
										if(key == "artworkUrl60"){
											$("#url").val(value);
											$("#divituneimageimg").show();
											$("#divituneimageimg").attr('src', value);
											$("#img").attr('src', value);
										}
										if(key == "trackViewUrl"){
										var res = value.split("/");
										var str = res[6].toString();
										var new_res = str.split("&")[0];
										var track_url = 'http:/'+res[1]+'/'+res[2]+'/'+res[4]+'//'+new_res;
										$("#text_box_url").val(track_url);
										}	
										if(key == "formattedPrice"){
											$("#formattedPrice").val(formattedPrice);
											}							
								});
							}else if(result && result.resultCount > 1){
								
								for(var i=0; i < result.results.length; i++)
								{
									var track = result.results[i].trackName;
									var url = result.results[i].trackViewUrl;
									var formattedPrice = result.results[i].formattedPrice;	
									var track_name = track.replace("'","");	

									$( ".all_app1" ).append( "<tr class='del'><td><span class='icn-img'><img src="+result.results[i].artworkUrl60+" alt='photo'></span></td><td>"+result.results[i].primaryGenreName+"</td><td>"+result.results[i].version+"</td><td>"+result.results[i].trackId+"</td><td>"+result.results[i].contentAdvisoryRating+"</td><td>"+result.results[i].sellerName+"</td><td>"+result.results[i].trackName+"</td><td><a href='javascript:void(0)' onclick=\"select_aap('"+result.results[i].artworkUrl60+"','"+result.results[i].primaryGenreName+"','"+result.results[i].version+"','"+result.results[i].trackId+"','"+result.results[i].contentAdvisoryRating+"','"+result.results[i].sellerName+"','"+track_name+"','"+url+"','"+formattedPrice+"');\">Select</a></td><tr>");
								}
								$(".all_app1").show();
							}
						},
						error: function (xhr, ajaxOptions, thrownError) {
							alert('Oops! Some thing wrong with the request'); 
						}
						});
			
		}
		else{
			$(".all_app1").hide();
			$('#cbislive').attr('checked',false); 
			$("#primaryGenreName").val(""); 
			$("#version").val(""); 
			$("#trackId").val(""); 
			$("#Rating").val(""); 
			$("#trackName").val(""); 
			$("#url").val("");
			$("#app_category").val("");
			$("#divituneimageimg").attr('src', '<?php bloginfo('template_directory'); ?>/images/default.png');
			$(".check-live").hide();
		}
			}
			
	function select_aap(img,name,ver,id,rate,sname,trackName,url,formattedPrice){
		$("#primaryGenreName").val(name);
		$("#lstCategory").val($("#primaryGenreName").val());
		$("#lstCategory").val(name);
		
		$("#version").val(ver);
		
		$("#trackId").val(id);
		
		$("#Rating").val(rate);
		
		$("#sellerName").val(sname);
		
		$("#trackName").val(trackName);
		$("#txtappname").val(trackName);
		$("#formattedPrice").val(formattedPrice);
		var res = url.split("/");
		var str = res[6].toString();
		var new_res = str.split("&")[0];
		var track_url = res[0]+'/'+res[1]+'/'+res[2]+'/'+res[4]+'/'+new_res;
		$("#text_box_url").val(track_url);
		$("#url").val(img);
		$("#divituneimageimg").show();
		$("#divituneimageimg").attr('src', img);
		$("#img").attr('src', img);
		$(".all_app1").hide();
		$('.del').remove();
		}

	function clearcb(){
		$("#cbislive").attr("checked", false);
		$("#divituneimageimg").attr('src', '<?php bloginfo('template_directory'); ?>/images/default.png');
		$("#divituneimageimg").hide();
		$("#lstCategory").val("");
	}


	function all_country(){
		var text = 'all country';
		$("#add_country").val(text);
		$('.add-country-block').hide();
		$('#country').removeAttr('required');
		$("#all_cnt").addClass('active');
		$("#showmsg").show();
		}
	function close_this(val, index){
		var count = parseInt($("#hfIndex").val());
		var country = $("#add_country").val();
		$(".count"+index).remove();
		count--;
		$("#add_country").val(country);
		country = country.replace(country.split(",")[index]+",","");
		$("#add_country").val(country);
		
	}
	function select_country(contry){
		var country = $("#add_country").val();
		var cont = $("#country").val();
		if(country.trim()==""){
			country += cont;
			}
			else{
				country +=  "," + cont ; 
				}
		
		var count = parseInt($("#hfIndex").val());
		$( ".added-country" ).append( "<span class='country-box count"+count+"'' onclick='close_this(this, " +count+ ")';><a href='#' class='fa fa-times remv-cuntry count"+count+"'></a><span class='cuntry-nme'>"+cont+"</span></span>" );
		count++;
		$("#add_country").val(country);
		$("#hfIndex").val(count);
		
	}


	function reloadPage()
	  {
	  location.reload(true);
	  $(".show_hide").show();
	  alert('Your campaign has been added successfully!');
	  }
	  
	  function check_fund(){
		  var total_budget = $('#total_budget').val();
		  var total_fund = $('#total_fund').val();
		  var total_budget = parseFloat(total_budget);
		  var total_fund =  parseFloat(total_fund);
		  
		  if( total_budget > total_fund){
			  $("#total_budget").val(""); 
			  $("#budget_error1").show();
			  return false;
			  }
			  else{
				  $("#budget_error1").hide();
				  }
		  
		  }
	  function validate(){
		   var daily_budget = $('#daily_budget').val();
		   var total_budget = $('#total_budget').val();
		   var daily_budget = parseFloat(daily_budget);
		   var total_budget =  parseFloat(total_budget);
		  
		  if( daily_budget > total_budget){
			  $("#daily_budget").val(""); 
			  $("#budget_error").show();
			  return false;
			  }
			  else{
				  $("#budget_error").hide();
				  }
		  }
		  
		 function password_validate(){
		   var update_password = $('#update_password').val();
		   var update_confirm_password = $('#update_confirm_password').val();
		  
		  if( update_password != update_confirm_password){
			  $("#update_confirm_password").val("");
			  $("#password_error").show();
			  return false;
			  }
			  else{
				  $("#password_error").hide();
				  }
		  }
		function step1(){
			$(".product-form").show();
			$(".brand-form").hide();
			$(".track-form").hide();
			$(".bid-form").hide();
			$("#prev-camp-data").show();
			$("#billing-summary").hide();
			$("#payment-history").hide();
			$("#reporting-data").hide();
			$("#adduser").hide();
			$("#addfund").hide();
			$("#chng-detl").hide();
			$("#advertise-data").hide();
			$("#view-all-app").hide();
			}
		function step2(){
			$(".product-form").hide();
			$(".brand-form").show();
			$(".track-form").hide();
			$(".bid-form").hide();
			}
		function step3(){
			$(".product-form").hide();
			$(".brand-form").hide();
			$(".track-form").show();
			$(".bid-form").hide();
			}
		function step4(){
			$(".product-form").hide();
			$(".brand-form").hide();
			$(".track-form").hide();
			$(".bid-form").show();
			}
			
		function step5(){
			$(".product-form").hide();
			$(".track-form").hide();
			$(".bid-form").hide();
			$(".brand-form").hide();
			$("#prev-camp-data").hide();
			$("#billing-summary").show();
			$("#payment-history").hide();
			$("#reporting-data").hide();
			$("#adduser").hide();
			$("#addfund").hide();
			$("#chng-detl").hide();
			$("#advertise-data").hide();
			$("#view-all-app").hide();
			$("#bill_nav").show();
			$("#ana_nav").hide();
			$("#app_nav").hide();
			$("#acnt_nav").hide();
			$(".step5").addClass("active");
			$(".step7").removeClass("active");
			$(".step11").removeClass("active");

			}
		function step6(){
			$(".product-form").hide();
			$(".brand-form").hide();
			$(".track-form").hide();
			$(".bid-form").hide();
			$("#prev-camp-data").hide();
			
			$("#addfund").show();
			$("#billing-summary").hide();
			$("#payment-history").hide();
			$("#reporting-data").hide();
			$("#adduser").hide();
			$("#chng-detl").hide();
			$("#advertise-data").hide();
			$("#view-all-app").hide();
			}
		function step7(){
			$(".product-form").hide();
			$(".brand-form").hide();
			$(".track-form").hide();
			$(".bid-form").hide();
			$("#prev-camp-data").hide();
			$("#payment-history").show();
			$("#billing-summary").hide();
			$("#reporting-data").hide();
			$("#adduser").hide();
			$("#addfund").hide();
			$("#chng-detl").hide();
			$("#advertise-data").hide();
			$("#view-all-app").hide();
			$("#bill_nav").show();
			$("#ana_nav").hide();
			$("#app_nav").hide();
			$("#acnt_nav").hide();
			$(".step7").addClass("active");
			$(".step5").removeClass("active");
			$(".step11").removeClass("active");

			}
		function step8(){
			$(".product-form").hide();
			$(".brand-form").hide();
			$(".track-form").hide();
			$(".bid-form").hide();
			$("#prev-camp-data").hide();
			$("#adduser").show();
			$("#billing-summary").hide();
			$("#payment-history").hide();
			$("#reporting-data").hide();
			$("#addfund").hide();
			$("#chng-detl").hide();
			$("#advertise-data").hide();
			$("#view-all-app").hide();
			}
		function step9(){
			$(".product-form").hide();
			$(".brand-form").hide();
			$(".track-form").hide();
			$(".bid-form").hide();
			$("#prev-camp-data").hide();
			$("#reporting-data").hide();
			$("#billing-summary").hide();
			$("#payment-history").hide();
			$("#adduser").hide();
			$("#addfund").hide();
			$("#chng-detl").show();
			$("#advertise-data").hide();
			$("#view-all-app").hide();
			}
		function step10(){
			$(".product-form").hide();
			$(".brand-form").hide();
			$(".track-form").hide();
			$(".bid-form").hide();
			$("#prev-camp-data").hide();
			$("#advertise-data").hide();
			$("#billing-summary").hide();
			$("#payment-history").hide();
			$("#reporting-data").show();
			$("#adduser").hide();
			$("#addfund").hide();
			$("#chng-detl").hide();
			$("#view-all-app").hide();
			$(".step11").removeClass("active");
			$(".step10").addClass("active");
			
			}
		function step11(){
			$(".product-form").hide();
			$(".brand-form").hide();
			$(".track-form").hide();
			$(".bid-form").hide();
			$("#prev-camp-data").hide();
			$("#view-all-app").hide();
			$("#billing-summary").hide();
			$("#payment-history").hide();
			$("#reporting-data").hide();
			$("#adduser").hide();
			$("#addfund").hide();
			$("#chng-detl").hide();
			$("#advertise-data").show();
			$("#ana_nav").show();
			$("#app_nav").hide();
			$("#bill_nav").hide();
			$("#acnt_nav").hide();
			$(".analytic-wrapper").show();
			
			$(".step11").addClass("active");
			$(".step7").removeClass("active");
			$(".step5").removeClass("active");

			}
		function step12(){
			$(".product-form").hide();
			$(".brand-form").hide();
			$(".track-form").hide();
			$(".bid-form").hide();
			$("#prev-camp-data").hide();
			$("#view-all-app").show();
			$("#billing-summary").hide();
			$("#payment-history").hide();
			$("#reporting-data").hide();
			$("#adduser").hide();
			$("#addfund").hide();
			$("#chng-detl").hide();
			$("#advertise-data").hide();
			$(".step11").removeClass("active");
			}
	function getstats(){
	         var element = $("#offer_name option:selected");
	         var offerid = element.attr("offerid");
		var offer_name = $("#offer_name").val();
		$.ajax({
			type: "POST",
			url: "<?php bloginfo('siteurl');?>/ajax/getstats.php",
			data: "offer_name="+offer_name+"&offerid="+offerid,
			success: function(html){
				
				var result = JSON.parse(html);
				var fund = result.fund;
				var spends = result.spends;
				var num = parseFloat(fund) - parseFloat(spends);
				var abl = parseFloat(num).toFixed(2);
				var runningcamp = result.runningcamp;
				console.log("fund", fund);
				console.log("spends", spends);
				console.log("runningcamp",runningcamp);
				$("#stats_running_campaign").html(runningcamp);
				$("#stats_abal").html('$'+abl);
				$("#stats_fund").html('$'+fund);
				//alert($("#stats_abal").html());
				$("#report_stats").show();
				$("#defaultcamp").hide();
				//if(html =='fail'){
					//alert(html);
					 
					/*$("#txtappname").val("");
					$('#app_category').val("");
					$('#cbislive').attr('checked',false); 
					$(".all_app1").hide();
					}
					else{
						getAppData(val);
						}*/
				
				}	
			});
	}
	jQuery(document).ready(function(){
	var date = new Date();
	var curr_date = date.getDate() ;
	if (curr_date < 10) { curr_date = '0' + curr_date;}

	var month = (date.getMonth() + 1);
	if (month < 10) { month = '0' + month;}

	var year = date.getFullYear();

	var yesterdaydate = (date.getDate() - 1);
	if (yesterdaydate < 10) { yesterdaydate = '0' + yesterdaydate;}
	var current_date = year + '-' + month  + '-' + curr_date;
	var yesterday_date = year + '-' + month  + '-' + yesterdaydate;
	document.getElementById('inputField1').value = current_date;
	document.getElementById('inputField').value = yesterday_date;
	/*document.getElementById('view_app1').value = current_date;
	document.getElementById('view_app').value = yesterday_date;*/
	jQuery('#submit').click(function(){
	if(document.getElementById('email').value=='' || document.getElementById('password').value==''){

		$("#someElement").html("Please Enter Email and Password");
		
		} else {
		
		var srt = $("#loginForm").serialize();
		
		// alert is working perfect
		
		$.ajax({
		
			type: 'POST',
		
			url: '<?php echo get_bloginfo("url"); ?>/ajax/action.php',
		
			data: srt,
		
			success: function(response) {
		
				//alert(response);
		
				if(parseInt(response) == 1) 
		
				{
		
					window.location.href="<?php get_bloginfo('url');?>/add-campaign";
		
				} else {
		
					$("#someElement").text(response).fadeIn("slow");
		
				}
		
			}
		
		});
		
		}
		
		 return false;
		
		});
		
		
		
		});
		
		
		
		function SignUp(){	
		
		var query = $('#createAccountForm').serialize();
		
		var url = '<?php echo get_bloginfo("url"); ?>/action.php';					                                
		$.post(url, query, function (response) {
		
			if(parseInt(response) == 1) 
		
			{
		
				location.reload();
		
			}
		
			else if(response != 0) 
		
			{
		
				$("#respSignUp").text(response).fadeIn("slow");
		
			}
		
		});								
		
		}
		
		function advisorSignOut(){
		
		var url = '<?php echo get_bloginfo("url"); ?>/logout.php';                    
		
		var query="data=advisor";                     
		
		$.post(url, query, function (response) { 
		
		//alert(response);                                  
		
			window.location.href="<?php get_bloginfo('url');?>";                                 
		
		});
		
		}
		
		function isSignIn()
		
		{
		
		var result = false;
		
		var id = '<?php echo $_SESSION['advisorid']; ?>';	
		
		if(id == "")
		
		{
		
			showSignIn();
		
			window.scrollTo(0,0);
		
			result = false;
		
		}
		
		else {
		
			result = true;
		
		} return result;
		
		}

	</script>
	</head>

	<body class="ad-cmpgn-pg">

	<section class="content responsive-section-add-campaign" style="background-color:#fff;">
	    <div class="container responsive-cont-add-campaign">
	       <div class="row">
	          <div class="col-md-3">
	              <div id="side-bar-nav" class="side-bar">
	           <div>
	              <div class="side-nav-title">Apps</div>
	                 <ul class="nav side-nav first" id="app_nav">
	                       <li><a class="step1" href="javascript:void(0);" tgt="#add-product" onClick="step1()">Add Product<span class="fa fa-check-circle active"></span></a></li>
	                       <li><a class="step2" href="javascript:void(0);" tgt="#brand-form">Brand Icon<span class="fa fa-check-circle"></span></a></li>
	                       <li><a class="step3" href="javascript:void(0);" tgt="#track-form">Tracking & Targeting<span class="fa fa-check-circle"></span></a></li>
	                       <li><a class="step4" href="javascript:void(0);" tgt="#bid-form">Bids & Budget<span class="fa fa-check-circle"></span></a></li>
	                 </ul>
	              </div>
	          <div>
	            <div class="side-nav-title">Billing</div>
	                       <ul class="nav side-nav" id="bill_nav">
	                          <li><a class="step5" href="javascript:void(0);" tgt="#billing-summary" onClick="step5()">Summary</a></li>
	                          <li><a class="step6" href="javascript:void(0);" tgt="#addfund" onClick="step6()">Add Funds</a></li>
	                          <li><a class="step7" href="javascript:void(0);" tgt="#payment-history" onClick="step7()">Payment History</a></li>
	                        </ul>
	             </div>
	       <div>
	          <div class="side-nav-title">Account</div>
	                <ul class="nav side-nav" id="acnt_nav">
	                      <li><a class="step8" href="javascript:void(0);" tgt="#adduser" onClick="step8()">Add New User</a></li>
	                      <li><a class="step9" href="javascript:void(0);" tgt="#chng-detl" onClick="step9()">Change Account Details</a></li>
	                </ul>
	          </div>
	<div>
	   <div class="side-nav-title">Analytics</div>
	         <ul class="nav side-nav" id="ana_nav">
	                  <li><a class="step10" href="javascript:void(0);" tgt="#reporting-data" onClick="step10()">Reporting</a></li>
	                  <li><a class="step11" href="javascript:void(0);" tgt="#advertise-data" onClick="step11()">Running Campaign</a></li>
	                  <!-- <li><a class="step12" href="javascript:void(0);" tgt="#view-all-app" onClick="step12()">View All Apps</a></li>-->
	            </ul>
	    </div>
	</div>
	<!--side-bar--> 
	</div>
	<!--col-->
	                                  
	<div class="col-md-9">
	    <div class="sidebar-content">
	      <div class="campaign-stats" id="defaultcamp">
	         <ul>
	              <li><a class="step5" href="javascript:void(0);" tgt="#billing-summary" onClick="step5()">Total Funded
	                 <br> <span class="figure"> $<?php echo number_format($fund); ?> </span></a></li>
	              <li><a class="step11" href="javascript:void(0);" tgt="#advertise-data" onClick="step11()">Running Campaign
	               <br> <span class="figure" id="running_campaign">
						<?php 
	                        $admin_id = $_SESSION["advisorid"];
	                        if($admin_id == 172 ){
	                        $qc = "SELECT count(*) as count FROM `offers` WHERE status = '10'";
	                        $resc =  mysql_query($qc) or die(mysql_error());
	                        while($totalc=mysql_fetch_array($resc))
	                        { 
	                        echo $totalc['count'];
	                        } 
	                        }else{
	                        $sum11 = 'SELECT count(*) as count FROM `offers` WHERE `advisorid` = '.$admin_id;	 
	                        $select_sum11=mysql_query($sum11) or die(mysql_error());
	                        while($total11=mysql_fetch_array($select_sum11))
	                        { 
								echo $total11['count'];
	                        } 
	                        }?>
	                      </span></a></li>
						<li><a class="step7" href="javascript:void(0);" tgt="#payment-history" onClick="step7()">Balance Amount
					    <br><span class="figure abal">&nbsp;</span></a>
						<input type="hidden" id="aid" value="<?php echo $admin_id; ?>">
						<input type="hidden" id="getfund" value="<?php echo $fund; ?>">
						</li>
	        </ul>
	</div>
	          
	          
	<div class="campaign-stats" id="report_stats" style="display:none">
	    <ul>
	        <li><a class="step5" href="javascript:void(0);" tgt="#billing-summary" onClick="step5()">Total Funded
	        <span class="figure" id="stats_fund"> </span></a></li>
	        <li><a class="step11" href="javascript:void(0);" tgt="#advertise-data" onClick="step11()">Running Campaign
	        <span class="figure" id="stats_running_campaign">
	        </span></a></li>
	        <li><a class="step7" href="javascript:void(0);" tgt="#payment-history" onClick="step7()">Balance Amount
	        <span class="figure" id="stats_abal">&nbsp;</span></a>
	        </li>
	    </ul>
	</div>
	 <!--campaign-stats--> 
	                                      <!-- ### APPS CONTENT ###-->
	<div class="apps-content">
	   <div class="loader" style="display:none">
	         <img src="<?php echo $wp_upload_folder['baseurl']; ?>/loader/loader1.gif" id="dvLoading">
	     </div>
	            <div id="add-product">
	                <form method="POST" id="step1" class="form">
	                   <div class="product-form">
	                       <div class="in-content">
	                          <div class="block">
	                             <div class="form-group">
	                                <label for="cmpgn-name">App/Website Name:</label>
	                                <input type="text" id="txtappname" onKeyUp="clearcb();" name="app_name" required placeholder="Enter Your Website Name">
	                              </div>
	                              <!--form-group-->
	                             <div class="form-group">
	                               <label for="app-category">Platform:</label>
	                                  <div class="a-group">
	                                       <div class="select-element"> <span class="ic-drop">
	                                            <select name="app-category" required onChange="remove_live(this.value);" id="app_category">
	                                            <option value="">---select---</option>
	                                            <option value="ios">iOS</option>
	                                            <option value="android">Android</option>
	                                            <option value="web">Web</option>
	                                          </select>
	                                                        </span> </div>
	                                                      <!--select-element-->
	                                                <div class="check-live">
	                                                    <div class="clearfix form-group">
	                                                          <input type="checkbox" onClick="check_app(this.checked);" id="cbislive" name="islive" value="yes"/>
	                                                          <label>Is Live?</label>
	                                                         <div class="divituneimage"> <!--<span id="response" class="response"></span>--><img id="divituneimageimg" src="<?php bloginfo('template_directory'); ?>/images/default.png" alt="ITune Icon"> </div>
	                                                     </div>
	                                                 <!--form-group--> 
	                                               </div>
	                                                <!--check-live--> 
	                                            </div>
	                                            <!--a-group--> 
	                                       </div>
	                                      <!--form-group-->
	                                      <!--form-group-->
	                                                 
	                                                  
	<div class="table-responsive">
	   <table class="table table-bordered table-hover table-condensed all_app1" style="display: none">
	         <thead>
	               <tr>
	                 <th class="table-intro" colspan="8">Below is the table of live apps with your given name. Please select your app.</th>
	               </tr>
	               <tr>
	                  <th>Icon</th>
	                  <th>Name</th>
	                  <th>Version</th>
	                  <th>Tracking ID</th>
	                  <th>Rating</th>
	                  <th>Vendor Name</th>
	                  <th>Tracking Name</th>
	                  <th>Action</th>
	                </tr>
	           </thead>
	      </table>
	 </div>
	<div class="block scheme">
	  <div class="form-group">
	    <label for="invok-url">App URL Scheme:</label>
	    <input type="text" name="scheme-url" id="scheme" required class="extended" />
	    <a href="<?php bloginfo('template_directory'); ?>/images/Screen Shot 2014-01-23 at 1.28.00 PM.png" title="add a caption to title attribute / or leave blank" class="thickbox">
	<img src="<?php bloginfo('template_directory'); ?>/images/Screen Shot.png" alt="Single Image" border="0" width="50"/></a>
	  </div> <!--form-group-->
	</div> <!--block-->
	<div class="block">
	    <div class="form-group">
	            <label for="invok-url">App/Website URL:</label>
	            <input type="text" name="invok-url" id="text_box_url" required class="extended" placeholder="https://www.yourdomain.com"/>
	       </div>
	      <div class="form-group">
	           <label for="app-category">Campaign Type:</label>
	              <div class="a-group">
	                 <div class="select-element"> <span class="ic-drop">
	                    <select name="campaign_type" id="campaign_type" required >
	                    <option value="">---select---</option>
	                    <option id="wbtype" class="smtype" value="Paid per click">Paid per click  </option>
	                    <option class="smtype" value="Paid per installs ">Paid per installs </option>
	                    <option class="wbtype" value="Paid per watching the video ">Paid per watching the video </option>
	                    <option class="wbtype" value="Paid per registration ">Paid per registration </option>
	                   </select>
	                    </span> </div></div>
	                 <!--form-group--> 
	               </div>
	                  <!--block-->
	                <div class="register-btn">
	                      <input type="hidden" name="action" value="step1">
	                      <!--<a href="javascript:void(0);" class="btn btn-default btn-main" onclick="switchSteps(2);">Save</a>-->
	                      <button name="submit" id="first_submit" type="submit" class="btn btn-primary btn-sml">Next</button>
	                      <span id="img_response1"></span> </div>
	                 <!--register-btn--> 
	                    </div> <!--in-content-->
	          			</div> <!--product-form-->
	                  </div>
	                 <!--in-content--> 
	                </div>
	                <!--product-form-->
	                <input type="hidden" name="primaryGenreName" id="primaryGenreName" value="">
	                <input type="hidden" name="version" id="version" value="">
	                <input type="hidden" name="trackId" id="trackId" value="">
	                <input type="hidden" name="Rating" id="Rating" value="">
	                <input type="hidden" name="trackName" id="trackName" value="">
	                <input type="hidden" name="url" id="url" value="">
	                <input type="hidden" name="formattedPrice" id="formattedPrice" value="">
	              </form>
	              </div>
	            <!--add-product--> 
	            
	            <!--## brand form ##-->
	            <div id="brand-form" class="brand-form">
	               <form method="post" id="step2" enctype="multipart/form-data" class="form">
	                <p class="select_icon">Select an app icon or favicon. App icon must be no larger than 50 x 50 pixels. At least one logo is required.</p>
	                <div class="form-block add-padding-bottom">
	                   <div class="clearfix form-group add-icon">
	                    <div class="divituneimage"> <img id="img" src="<?php bloginfo('template_directory'); ?>/images/default.png" alt="ITune Icon"> </div>
	                          <input type="file" id="image_to_upload" name="file" required>
	                     </div>
	                     <!--form-group-->
	                    <div> <span class="ic-brand" id="results" style="display: none;"><img src="<?php bloginfo('template_directory'); ?>/images/default.png" width="50px" height="50px" name="icon" id="icon"></span><!--<span id="img_response" class="response"></span>--></div>
	                     </div>
	                <!--form-block-->
	                
	                <div class="form-block">
	                <div class="form-group">
	                	<label for="ad-copy">Ad Headline:</label>
	                	<input type="text" id="headline" name="headline" required>
	              	</div>
	              	<!--form-group-->
	                 <div class="form-group">
	                    <label for="ad-copy">Add copy:</label>
	                    <textarea name="ad-copy" required class="extended"></textarea>
	                    <p class="note">(max 150 characters)</p>
	                  </div>
	                <!--form-group--> 
	                 </div>
	                <!--form-block-->
	                
	                <div class="register-btn">
	                  <input type="hidden" name="action" value="step2">
	                  <input type="hidden" name="icon_pic" id="icon_pic" value="">
	                  <button type="submit" id="second_submit" class="btn btn-primary btn-sml" name="submit">Next</button>
	                 <span id="img_response2"></span> </div>
	                <!--register-btn-->
	              </form>
	           </div>
	            <!--Brand form--> 
	            
	            <!--## Tracking & Targeting form ##-->
	            <div id="track-form" class="track-form">
	              <form method="post" id="step3" class="form">
	                <div class="form-block">
	                   <div class="country-block">
	                     <div class="form-group">
	                           <label for="country-targt">Country Targeting:</label>
	                              <ul class="clearfix country-toggle">
	                                <li id="all_cnt"><span class="fa fa-check-circle all-cntry"></span><a href="javascript:void(0)" id='all' onClick="all_country();">Available To All
	                                </a></li>
	                                <li><span class="fa fa-check-circle slectd-cntry"></span><a href="javascript:void(0)" id="selected">Selected</a></li>
	                              </ul>
	                  <!--<div id="showmsg">You have choosen All Countries!</div>--> 
	                </div>
	                    <!--form-group--> 
	                  </div>
	                  <!--country-block-->
	                   <div class="add-country-block">
	                    <div class="form-group">
	                       <select name="add-country" required onChange="select_country(this.value);" id="country">
	                        <option value="" selected="selected" disabled>Select Country</option>
	                        <option value="United States">United States</option>
	                        <option value="United Kingdom">United Kingdom</option>
	                        <option value="Afghanistan">Afghanistan</option>
	                        <option value="Albania">Albania</option>
	                        <option value="Algeria">Algeria</option>
	                        <option value="American Samoa">American Samoa</option>
	                        <option value="Andorra">Andorra</option>
	                        <option value="Angola">Angola</option>
	                        <option value="Anguilla">Anguilla</option>
	                        <option value="Antarctica">Antarctica</option>
	                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
	                        <option value="Argentina">Argentina</option>
	                        <option value="Armenia">Armenia</option>
	                        <option value="Aruba">Aruba</option>
	                        <option value="Australia">Australia</option>
	                        <option value="Austria">Austria</option>
	                        <option value="Azerbaijan">Azerbaijan</option>
	                        <option value="Bahamas">Bahamas</option>
	                        <option value="Bahrain">Bahrain</option>
	                        <option value="Bangladesh">Bangladesh</option>
	                        <option value="Barbados">Barbados</option>
	                        <option value="Belarus">Belarus</option>
	                        <option value="Belgium">Belgium</option>
	                        <option value="Belize">Belize</option>
	                        <option value="Benin">Benin</option>
	                        <option value="Bermuda">Bermuda</option>
	                        <option value="Bhutan">Bhutan</option>
	                        <option value="Bolivia">Bolivia</option>
	                        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
	                        <option value="Botswana">Botswana</option>
	                        <option value="Bouvet Island">Bouvet Island</option>
	                        <option value="Brazil">Brazil</option>
	                        <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
	                        <option value="Brunei Darussalam">Brunei Darussalam</option>
	                        <option value="Bulgaria">Bulgaria</option>
	                        <option value="Burkina Faso">Burkina Faso</option>
	                        <option value="Burundi">Burundi</option>
	                        <option value="Cambodia">Cambodia</option>
	                        <option value="Cameroon">Cameroon</option>
	                        <option value="Canada">Canada</option>
	                        <option value="Cape Verde">Cape Verde</option>
	                        <option value="Cayman Islands">Cayman Islands</option>
	                        <option value="Central African Republic">Central African Republic</option>
	                        <option value="Chad">Chad</option>
	                        <option value="Chile">Chile</option>
	                        <option value="China">China</option>
	                        <option value="Christmas Island">Christmas Island</option>
	                        <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
	                        <option value="Colombia">Colombia</option>
	                        <option value="Comoros">Comoros</option>
	                        <option value="Congo">Congo</option>
	                        <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
	                        <option value="Cook Islands">Cook Islands</option>
	                        <option value="Costa Rica">Costa Rica</option>
	                        <option value="Cote D'ivoire">Cote D'ivoire</option>
	                        <option value="Croatia">Croatia</option>
	                        <option value="Cuba">Cuba</option>
	                        <option value="Cyprus">Cyprus</option>
	                        <option value="Czech Republic">Czech Republic</option>
	                        <option value="Denmark">Denmark</option>
	                        <option value="Djibouti">Djibouti</option>
	                        <option value="Dominica">Dominica</option>
	                        <option value="Dominican Republic">Dominican Republic</option>
	                        <option value="Ecuador">Ecuador</option>
	                        <option value="Egypt">Egypt</option>
	                        <option value="El Salvador">El Salvador</option>
	                        <option value="Equatorial Guinea">Equatorial Guinea</option>
	                        <option value="Eritrea">Eritrea</option>
	                        <option value="Estonia">Estonia</option>
	                        <option value="Ethiopia">Ethiopia</option>
	                        <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
	                        <option value="Faroe Islands">Faroe Islands</option>
	                        <option value="Fiji">Fiji</option>
	                        <option value="Finland">Finland</option>
	                        <option value="France">France</option>
	                        <option value="French Guiana">French Guiana</option>
	                        <option value="French Polynesia">French Polynesia</option>
	                        <option value="French Southern Territories">French Southern Territories</option>
	                        <option value="Gabon">Gabon</option>
	                        <option value="Gambia">Gambia</option>
	                        <option value="Georgia">Georgia</option>
	                        <option value="Germany">Germany</option>
	                        <option value="Ghana">Ghana</option>
	                        <option value="Gibraltar">Gibraltar</option>
	                        <option value="Greece">Greece</option>
	                        <option value="Greenland">Greenland</option>
	                        <option value="Grenada">Grenada</option>
	                        <option value="Guadeloupe">Guadeloupe</option>
	                        <option value="Guam">Guam</option>
	                        <option value="Guatemala">Guatemala</option>
	                        <option value="Guinea">Guinea</option>
	                        <option value="Guinea-bissau">Guinea-bissau</option>
	                        <option value="Guyana">Guyana</option>
	                        <option value="Haiti">Haiti</option>
	                        <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
	                        <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
	                        <option value="Honduras">Honduras</option>
	                        <option value="Hong Kong">Hong Kong</option>
	                        <option value="Hungary">Hungary</option>
	                        <option value="Iceland">Iceland</option>
	                        <option value="India">India</option>
	                        <option value="Indonesia">Indonesia</option>
	                        <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
	                        <option value="Iraq">Iraq</option>
	                        <option value="Ireland">Ireland</option>
	                        <option value="Israel">Israel</option>
	                        <option value="Italy">Italy</option>
	                        <option value="Jamaica">Jamaica</option>
	                        <option value="Japan">Japan</option>
	                        <option value="Jordan">Jordan</option>
	                        <option value="Kazakhstan">Kazakhstan</option>
	                        <option value="Kenya">Kenya</option>
	                        <option value="Kiribati">Kiribati</option>
	                        <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
	                        <option value="Korea, Republic of">Korea, Republic of</option>
	                        <option value="Kuwait">Kuwait</option>
	                        <option value="Kyrgyzstan">Kyrgyzstan</option>
	                        <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
	                        <option value="Latvia">Latvia</option>
	                        <option value="Lebanon">Lebanon</option>
	                        <option value="Lesotho">Lesotho</option>
	                        <option value="Liberia">Liberia</option>
	                        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
	                        <option value="Liechtenstein">Liechtenstein</option>
	                        <option value="Lithuania">Lithuania</option>
	                        <option value="Luxembourg">Luxembourg</option>
	                        <option value="Macao">Macao</option>
	                        <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
	                        <option value="Madagascar">Madagascar</option>
	                        <option value="Malawi">Malawi</option>
	                        <option value="Malaysia">Malaysia</option>
	                        <option value="Maldives">Maldives</option>
	                        <option value="Mali">Mali</option>
	                        <option value="Malta">Malta</option>
	                        <option value="Marshall Islands">Marshall Islands</option>
	                        <option value="Martinique">Martinique</option>
	                        <option value="Mauritania">Mauritania</option>
	                        <option value="Mauritius">Mauritius</option>
	                        <option value="Mayotte">Mayotte</option>
	                        <option value="Mexico">Mexico</option>
	                        <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
	                        <option value="Moldova, Republic of">Moldova, Republic of</option>
	                        <option value="Monaco">Monaco</option>
	                        <option value="Mongolia">Mongolia</option>
	                        <option value="Montserrat">Montserrat</option>
	                        <option value="Morocco">Morocco</option>
	                        <option value="Mozambique">Mozambique</option>
	                        <option value="Myanmar">Myanmar</option>
	                        <option value="Namibia">Namibia</option>
	                        <option value="Nauru">Nauru</option>
	                        <option value="Nepal">Nepal</option>
	                        <option value="Netherlands">Netherlands</option>
	                        <option value="Netherlands Antilles">Netherlands Antilles</option>
	                        <option value="New Caledonia">New Caledonia</option>
	                        <option value="New Zealand">New Zealand</option>
	                        <option value="Nicaragua">Nicaragua</option>
	                        <option value="Niger">Niger</option>
	                        <option value="Nigeria">Nigeria</option>
	                        <option value="Niue">Niue</option>
	                        <option value="Norfolk Island">Norfolk Island</option>
	                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
	                        <option value="Norway">Norway</option>
	                        <option value="Oman">Oman</option>
	                        <option value="Pakistan">Pakistan</option>
	                        <option value="Palau">Palau</option>
	                        <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
	                        <option value="Panama">Panama</option>
	                        <option value="Papua New Guinea">Papua New Guinea</option>
	                        <option value="Paraguay">Paraguay</option>
	                        <option value="Peru">Peru</option>
	                        <option value="Philippines">Philippines</option>
	                        <option value="Pitcairn">Pitcairn</option>
	                        <option value="Poland">Poland</option>
	                        <option value="Portugal">Portugal</option>
	                        <option value="Puerto Rico">Puerto Rico</option>
	                        <option value="Qatar">Qatar</option>
	                        <option value="Reunion">Reunion</option>
	                        <option value="Romania">Romania</option>
	                        <option value="Russian Federation">Russian Federation</option>
	                        <option value="Rwanda">Rwanda</option>
	                        <option value="Saint Helena">Saint Helena</option>
	                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
	                        <option value="Saint Lucia">Saint Lucia</option>
	                        <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
	                        <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
	                        <option value="Samoa">Samoa</option>
	                        <option value="San Marino">San Marino</option>
	                        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
	                        <option value="Saudi Arabia">Saudi Arabia</option>
	                        <option value="Senegal">Senegal</option>
	                        <option value="Serbia and Montenegro">Serbia and Montenegro</option>
	                        <option value="Seychelles">Seychelles</option>
	                        <option value="Sierra Leone">Sierra Leone</option>
	                        <option value="Singapore">Singapore</option>
	                        <option value="Slovakia">Slovakia</option>
	                        <option value="Slovenia">Slovenia</option>
	                        <option value="Solomon Islands">Solomon Islands</option>
	                        <option value="Somalia">Somalia</option>
	                        <option value="South Africa">South Africa</option>
	                        <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
	                        <option value="Spain">Spain</option>
	                        <option value="Sri Lanka">Sri Lanka</option>
	                        <option value="Sudan">Sudan</option>
	                        <option value="Suriname">Suriname</option>
	                        <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
	                        <option value="Swaziland">Swaziland</option>
	                        <option value="Sweden">Sweden</option>
	                        <option value="Switzerland">Switzerland</option>
	                        <option value="Syrian Arab Republic">Syrian Arab Republic</option>
	                        <option value="Taiwan, Province of China">Taiwan, Province of China</option>
	                        <option value="Tajikistan">Tajikistan</option>
	                        <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
	                        <option value="Thailand">Thailand</option>
	                        <option value="Timor-leste">Timor-leste</option>
	                        <option value="Togo">Togo</option>
	                        <option value="Tokelau">Tokelau</option>
	                        <option value="Tonga">Tonga</option>
	                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
	                        <option value="Tunisia">Tunisia</option>
	                        <option value="Turkey">Turkey</option>
	                        <option value="Turkmenistan">Turkmenistan</option>
	                        <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
	                        <option value="Tuvalu">Tuvalu</option>
	                        <option value="Uganda">Uganda</option>
	                        <option value="Ukraine">Ukraine</option>
	                        <option value="United Arab Emirates">United Arab Emirates</option>
	                        <option value="United Kingdom">United Kingdom</option>
	                        <option value="United States">United States</option>
	                        <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
	                        <option value="Uruguay">Uruguay</option>
	                        <option value="Uzbekistan">Uzbekistan</option>
	                        <option value="Vanuatu">Vanuatu</option>
	                        <option value="Venezuela">Venezuela</option>
	                        <option value="Viet Nam">Viet Nam</option>
	                        <option value="Virgin Islands, British">Virgin Islands, British</option>
	                        <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
	                        <option value="Wallis and Futuna">Wallis and Futuna</option>
	                        <option value="Western Sahara">Western Sahara</option>
	                        <option value="Yemen">Yemen</option>
	                        <option value="Zambia">Zambia</option>
	                        <option value="Zimbabwe">Zimbabwe</option>
	                      </select>
	                     </span> </div>
	                    <!--form-group-->
	                    <div> 
	                      <!--<div class="clearfix added-country"><span class="country-box"><a href="#" class="fa fa-times remv-cuntry count0"></a><span class="cuntry-nme">Azerbaijan</span></span></div>-->
	                                                  <div class="clearfix added-country"></div>
	                                                  <!--added-country-->
	                                                  <input type="hidden" name="country" id="add_country">
	                                                </div>
	                    <!--div--> 
	                  </div>
	                  <!--add-country-block--> 
	                   </div>
	                <!--form-block-->
	                <div class="register-btn">
	                                              <input type="hidden" name="action" value="step3">
	                                              <button type="submit" id="third_submit" class="btn btn-primary btn-sml" name="submit">Next</button>
	                                              <span id="img_response3"></span> </div>
	                <!--register-btn-->
	              </form>
	              </div>
	            <!--track-form--> 
	            
	            <!--## Tracking & Targeting form ##-->
	            <div id="bid-form" class="bid-form">
	                                          <form method="post" id="step4" class="form">
	                <div class="form-block">
	                                              <ul class="bid-group">
	                    <li class="form-group">
	                                                  <label for="rewrd-bid" class="rewards">Bid:</label>
	                                                  <div class="clearfix iconic-field"> <span class="fa fa-usd currncy-icon"></span>
	                        <input type="text" name="rewrd-bid" required maxlength="10" pattern="\d+(\.\d{2})?">
	                      </div>
	                                                  <!--iconic-field--> 
	                                                </li>
	                    <!--form-group-->
	                    <li class="form-group">
	                                                  <label for="rewrd-budgt" class="rewards">Total Budget <span class="note">(Ex: 150.00)</span>:</label>
	                                                  <div class="clearfix iconic-field"> <span class="fa fa-usd currncy-icon"></span>
	                        <input type="text" id="total_budget"  onChange="check_fund();" name="amount" required maxlength="10" pattern="\d+(\.\d{2})?">
	                        <input type="hidden" id="total_fund" name="total_fund" value="<?php echo $fund-$spentamount; ?>">
	                      </div>
	                                                  
	                                                  <!--iconic-field--> 
	                                                </li>
	                    <!--form-group-->
	                  </ul>
	                                              <span id="budget_error1" class="err-messg" style="display:none;">&nbsp;&nbsp;Your Total Available Balance is <?php echo '$'.$fund-$spentamount; ?> and this is lesser than your campaign Total Budget, Please add fund..!!</span> 
	                                              </div>
	                <!--form-block-->
	               
	                <div class="form-block daily">
	                                              <ul class="bid-group">
	                    <li class="form-group">
	                                                  <label>Daily Budget:</label>
	                                                  <div class="clearfix iconic-field"> <span class="fa fa-usd currncy-icon"></span>
	                        <input type="text" id="daily_budget" name="custom" required maxlength="10" pattern="\d+(\.\d{2})?" onBlur="validate();">
	                      </div>
	                                                  <!--iconic-field--> 
	                                                </li>
	                    <!--form-group-->
	                  </ul>
	                                              <span id="budget_error" class="err-messg" style="display:none;">&nbsp;&nbsp;Daily budget should be less than Your total budgets.</span> </div>
	                <!--form-block-->
	                <div class="register-btn btn-paypal">
	                                              <input type="hidden" name="action" value="step4">
	                                              <button type="submit" id="four_submit" class="btn btn-primary btn-sml" name="submit">Finish</button>
	                                              <span id="img_response4"></span> </div>
	                <!--register-btn-->
	              </form>
	                                        </div>
	            <!--bid-form-->
	            
	            <div id="prev-camp-data">
	                                          <div class="table-responsive">
	                <table class="table table-bordered table-hover table-condensed prev-campaign show_hide">
	                                              <thead>
	                    <tr>
	                                                  <th class="table-intro" colspan="8">Below is the table of previously added campaigns by you.</th>
	                                                </tr>
	                    <tr>
	                                                  <th>Icon</th>
	                                                  <th>Name</th>
	                                                  <th>Category</th>
	                                                  <th>Download URL</th>
	                                                  <th>Rewards</th>
	                                                  <th>Analytics</th>
	                                                  <?php if($admin_id == 172)
	                                    				{ ?>
	                                                  <th>Added By</th>
	                                                  <?php }?>
	                                                  <th>Action</th>
	                                                </tr>
	                  </thead>
	                                              <tbody>
	                  
	                    <?php

						$admin_id = $_SESSION["advisorid"];
							if($admin_id == 172)
							{
								$admin_id = $_SESSION["advisorid"];
								$select_add=mysql_query("select * from offers") or die(mysql_error());
										while($add=mysql_fetch_array($select_add))
													{?>
	                    
	                                                  <td id="app-icon"><span class="icn-img"><img src="<?php echo $add['photopath'];?>" alt=""></span></td>
	                                                  <td id="app-name"><?php echo $add['title'];?></td>
	                                                  <td id="app-category"><?php echo $add['platform'];?></td>
	                                                  <td id="app-version"><?php if($add['downloadurl']!=='' && $add['androiddownloadurl']=='' && $add['websiteurl']==''){echo $add['downloadurl'];} else if($add['downloadurl']=='' && $add['androiddownloadurl']!=='' && $add['websiteurl']==''){echo $add['androiddownloadurl'];} else {echo $add['websiteurl'];} ?></td>
	                                                  <td id="app-rating"><?php echo $add['rewardedbid'];?></td>
	                                                  <td id="app-analytic"><a href="javascript:void(0);" onClick="step10()" title="View">View</a></td>
	                                                  <td><?php 
											$advisor = $add['advisorid'];
	                                        $queryuser = 'select fname,lname from advisors where advisorid ='.$advisor;
	                                        $select_adduser=mysql_query($queryuser) or die(mysql_error());
	                                        while($adduser=mysql_fetch_array($select_adduser))
												{
													echo $adduser['fname']." ".$adduser['lname'];
												}?></td>
	                                                  <td><a href="<?php echo  get_bloginfo('url'); ?>/add-campaign?action=delete&id=<?php echo $add['offerid']; ?>" onClick="return confirm('Are You Sure? You want to delete this campaign.');" title="Delete">Del</a></td>
	                                                </tr>
	                    <?php }
						}  else{
							/*$queryadv = 'select role from advisors where advisorid ='.$admin_id;
							$selectrole=mysql_query($queryadv) or die(mysql_error());
							$role=mysql_fetch_assoc($selectrole);
							$role = $role['role'];
								if($role == 'publisher'){	
								}*/
									$select_add11=mysql_query("SELECT * FROM `offers` where advisorid = '$admin_id'") or die(mysql_error());
										while($add=mysql_fetch_array($select_add11))
													{?>
	                    <tr>
	                                                  <td id="app-icon"><span class="icn-img"><img src="<?php echo $add['photopath'];?>" alt=""></span></td>
	                                                  <td id="app-name"><?php echo $add['title'];?></td>
	                                                  <td id="app-category"><?php echo $add['platform'];?></td>
	                                                  <td id="app-version"><?php if($add['downloadurl']!=='' && $add['androiddownloadurl']=='' && $add['websiteurl']==''){echo $add['downloadurl'];} else if($add['downloadurl']=='' && $add['androiddownloadurl']!=='' && $add['websiteurl']==''){echo $add['androiddownloadurl'];} else {echo $add['websiteurl'];} ?></td>
	                                                  <td id="app-rating"><?php echo $add['rewardedbid'];?></td>
	                                                  <td id="app-type">Success</td>
	                                                  <td id="app-analytic"><a href="javascript:void(0);" onClick="step10()" title="View">View</a></td>
	                                                  <td><a href="<?php echo  get_bloginfo('url'); ?>/add-campaign?action=delete&id=<?php echo $add['offerid']; ?>" onClick="return confirm('Are You Sure? You want to delete this campaign.');" title="Delete">Del</a></td>
	                                                </tr>
	                    <?php }
					} ?>
	                  </tbody>
	                                            </table>
	              </div>
	                                          <!--table-responsive-->
	                                          <div class="get-link block add-padding-bottom remove-margin-top">
	                <div class="form-group show_link">
	                                              <button type="button" id="done" class="btn btn-primary btn-sml" onClick="reloadPage();">Click here to add your campaign in your campaign list!!</button>
	                                            </div>
	                <!--form-group-->
	                <div class="register-btn">
	                <p>Your Script:</p>
	                <code><br />
	                <span><</span>?php <br />$userid = $_GET['userid'];<br />
	                $offerid = $_GET['offerid'];<br />
	                $apikey = $_GET['apikey'];<br />
	                $url = "http://me.intlfaces.com/intlfaceshits.php?userid=".$userid."&offerid=".$offerid."&apikey=".$apikey;    <br />            
	                $ch = curl_init();<br />
	                curl_setopt($ch, CURLOPT_URL, $url);<br />
	                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);<br />
	                $output = curl_exec($ch);<br />
	                curl_close($ch);<br />
	                ?<span>></span></code> </div>
	                <!--get-link--> 
	              </div>
	                                        </div>
	            <!--prev-camp-data--> 
	            
	          </div>
	                                      <!--apps-content--> 
	                   
	                                      <!-- ### BILLING CONTENT ###-->

	            <div class="billing-content">
	            <div id="billing-summary">
	                                          <div class="form-block">
					<!--
	                <ul class="fund-details">
					  <li>Total Funded: <?php //echo number_format($fund); ?></li>
					  <li>Available Balance: <span class="abal"></span></li>
					</ul>
					-->

	                <div class="table-responsive">
						<table class="table table-bordered table-hover table-condensed prev-campaign show_hide">
							<thead>
							<tr>
								<th>Campaign Title</th>
								<th>Campaign Cost</th>
							</tr>
							</thead>
	                    <tbody>

						<?php if($_SESSION["advisorid"]!="")
						{
							$totalspend = 0;
							$offerspend = 0;
							$admin_id = $_SESSION["advisorid"];
							if($admin_id != 172)
							{
								$admin_id = $_SESSION["advisorid"];
								$select_camp=mysql_query("select * from offers where status = '10' and advisorid = '$admin_id'");
								while($camp=mysql_fetch_array($select_camp))
								{?>
									<tr>
										<td><?php echo $camp['title'];?></td>
										<td>
								<?php 
									$url = $camp["websiteurl"];
									if($camp["platform"] == "ios")
									{
										$url = $camp["downloadurl"];
									}
									else if($camp["platform"] == "android")
									{
										$url = $camp["androiddownloadurl"];
									}
									$q="SELECT sum( conversions * rewardbid) AS spend	FROM ".RETIRELY_DB.".hasofferstats 
									WHERE `offerurl` = '".$url."'";
									 
									$re = mysql_query($q);
									if(mysql_num_rows($re) > 0)
									{
										$r = mysql_fetch_assoc($re);
										$offerspend = $r["spend"];
										$totalspend .= $offerspend.',';	
									}
										echo '$'.number_format($offerspend,2);
									?>										
								</td>
							</tr>
						<?php } } else{
							$select_camp=mysql_query("select * from offers where status = '10'");
							while($camp=mysql_fetch_array($select_camp))
							{?>
								<tr>
								<td><?php echo $camp['title'];?></td>
								<td>
									<?php 
										$url = $camp["websiteurl"];
										if($camp["platform"] == "ios")
										{
											$url = $camp["downloadurl"];
										}
										else if($camp["platform"] == "android")
										{
											$url = $camp["androiddownloadurl"];
										}
										$q="SELECT sum( conversions * rewardbid) AS spend	FROM ".RETIRELY_DB.".hasofferstats 	WHERE `offerurl` = '".$url."'";
										
										$re = mysql_query($q);
										if(mysql_num_rows($re) > 0)
										{
											$r = mysql_fetch_assoc($re);
											$offerspend = $r["spend"];
											$totalspend .= $offerspend.',';	
										}
										echo '$'.number_format($offerspend,2);
									?>
								</td>
							</tr>
						<?php } } } ?>
							<tr>
								<td><strong>Total</strong></td>
								<td><strong>
								$<?php 
									$s  = rtrim($totalspend,',');
									$s = explode(",",$s);
									$s = array_sum ($s);
									$s = number_format($s,2);
									echo $s;
								?></strong></td>
							</tr>
						</tbody>
	                  </table>
					</div>
	                <!--table-responsive--> 
	              </div>
				<!--form-block--> 
				</div>
	            <!--billing-summary-->
	            
	            <div id="addfund">
				<form method="POST" id="cform" class="in-content sdk" action="<?php echo  get_bloginfo('url'); ?>/payment-fund">
	                <input type="hidden" name="cmd" value="_xclick" />
	                <input type="hidden" name="no_note" value="1" />
	                <input type="hidden" name="lc" value="UK" />
	                <input type="hidden" name="currency_code" value="USD" />
	                <input type="hidden" name="amount" value="3000" />
	                <input type="hidden" name="login_email" value="v_j_s@gmail.com"  />
	                <input type="hidden" name="custom" value="0" />
	                <div class="form">
						<div class="form-block">
						<!--
	                    <ul class="fund-details">
						  <li>Total Funded: <?php echo number_format($fund); ?></li>
						  <li>Available Balance: <span class="abal"></span></li>
						</ul>
						-->
	                    <div class="add-fund-form">
						  <div class="form-group">
	                        <label for="app-category">Amount:</label>
	                        <input type="text" name="amount" pattern="\d+(\.\d{2})?" required>
	                      </div>
						<!--form-group-->
						<div class="form-group">
	                        <label for="app-category">Your Paypal Email:</label>
	                        <input type="text" name="payeremail"  pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" value="" required>
	                      </div>
	                                                  <!--form-group--> 
	                                                </div>
	                    <!--add-fund-form-->
	                    <div class="register-btn to-left">
						
						<button type="submit" class="btn" name="submit"><img src="https://www.paypalobjects.com/webstatic/mktg/logo/bdg_secured_by_pp_2line.png" align="left" style="margin-right:7px;"></button>					
					</div>
	                    <!--register-btn--> 
					</div>
					<!--form-block--> 
					</div>
	                <!--form-->
	              </form>
				</div>
	            <!--add-fund-->
	            
	            <div id="payment-history">
					<div class="form-block">
					<!--
	                <ul class="fund-details">
					  <li>Total Funded: <?php echo number_format($fund); ?></li>
					  <li>Available Balance: <span class="abal"></span></li>
					</ul>
					-->
	                <div class="table-responsive">
						<table class="table table-bordered table-hover table-condensed prev-campaign show_hide">
						<thead>
							<tr>
								<th>Date</th>
								<th>Amount</th>
								<th>Payment Method</th>
							</tr>
						</thead>
	                    <tbody>
							<?php 
							$fund=0.00;
							$admin_id = $_SESSION["advisorid"];
							 
							if($admin_id == 172 ){
								$q = "SELECT *, DATE_FORMAT(datetime,'%Y-%m-%d') AS date FROM adminfund WHERE status='Complete' AND amount != 0 ORDER BY datetime DESC";
							}
							else{
								$q = "SELECT *, DATE_FORMAT(datetime,'%Y-%m-%d') AS date FROM adminfund WHERE advisorid = $admin_id AND status='Complete' AND amount != 0 ORDER BY datetime DESC";
							}
							$res = mysql_query($q);
							if(mysql_num_rows($res) > 0)
							{
								while($row = mysql_fetch_assoc($res))
								{
							?>
								<tr>
									<td><?php echo $row["date"]?></td>
									<td><?php echo '$'.$row["amount"];?></td>
									<td><?php if(strtolower($row["transactionid"]) == "manual payment"){echo "Manual Payment";}else{echo "Online";}?></td>
								</tr>
							<?php									
								}
							}
						?>
						</tbody>
	                  </table>
					</div>
	                <!--table-responsive--> 
	              </div>
				<!--form-block--> 
				</div>
	            <!--payment-history--> 
			</div>
			<!--billing-content--> 
			  
			<!--## ACCOUNT CONTENT ##-->
			<div class="account-content">
			<div id="adduser">
				<div class="form">
	                <div class="form-block">
						<form class="in-content" method="post">
	                    <div class="form-group">
							<label for="username">Username:</label>
							<input type="text" name="username" required pattern="[A-Za-z]+">
						</div>
	                    <!--form-group-->
	                    <div class="form-group">
						  <label for="password">Password:</label>
						  <input type="password" name="password" required>
						</div>
	                    <!--form-group-->
	                    <div class="form-group">
						  <label for="email">Email:</label>
						  <input type="email" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
						</div>
	                    <!--form-group-->
	                    
	                    <div class="register-btn to-left">
	                                                  <button name="submit" type="submit" class="btn btn-primary btn-sml">Add New User</button>
	                                                </div>
	                    <!--register-ntm-->
	                  </form>
	                                              <div class="table-responsive">
	                    <table class="table table-bordered table-hover table-condensed">
	                                                  <thead>
	                        <tr>
	                                                      <th class="table-intro" colspan="4">Current Users</th>
	                                                    </tr>
	                        <tr>
	                                                      <th>Login</th>
	                                                      <th>Username</th>
	                                                      <th>Email</th>
	                                                      <th>Action</th>
	                                                    </tr>
	                      </thead>
	                                                  <?php if($_SESSION["advisorid"]!="")
													{
													$admin_id = $_SESSION["advisorid"];
													$select_add=mysql_query("select * from adminusers where advisorid = '$admin_id'") or die(mysql_error());
													while($add=mysql_fetch_array($select_add))
													{?>
	                                                  <tr>
	                        <td id="app-name"><?php echo $add['email'];?></td>
	                        <td id="app-category"><?php echo $add['username'];?></td>
	                        <td id="app-rating"><?php echo $add['email'];?></td>
	                        <td id="app-analytic"><a href="<?php echo  get_bloginfo('url'); ?>/add-campaign?action=acnt_delete&id=<?php echo $add['adminuserid']; ?>" onClick="return confirm('Are You Sure? You want to delete this user.');" title="Delete">Del</a></td>
	                      </tr>
	                                                  <?php }
													}?>
	                                                </table>
	                  </div>
	                                              <!--table-responsive--> 
	                                            </div>
	                <!--form-block--> 
	              </div>
	                                          <!--form--> 
	                                        </div>
	            <!--adduser-->
	            
	            <div id="chng-detl">
	            <div class="form">

	            <?php $query = 'SELECT * FROM `advisors` WHERE `advisorid` = '.$admin_id;
				$update_user=mysql_query($query) or die(mysql_error());
					while($add=mysql_fetch_array($update_user))
					{?>
	                                          <form class="in-content" method="post" id="update_user_info">
	            <div class="form-block">
	                <div class="form-group">
	                                              <label for="email">Email:</label>
	                                              <input type="email" name="update_email" value="<?php echo $add['email'];?>" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
	                                            </div>
	                <!--form-group-->
	                <div class="form-group">
	                                              <label for="password">Enter New Password:</label>
	                                              <input type="password" name="update_password" id="update_password" value="" required>
	                                            </div>
	                <div class="form-group">
	                  <label for="password">Confirm New Password:</label>
	                  <input type="password" name="update_confirm_password" id="update_confirm_password" required onChange="password_validate();">
	                  <span id="password_error" style="color:red; font-size:12px; display:none">Not Matched</span>
	                </div>
	                <!--form-group-->
	                
	                <div class="register-btn to-left">
	                                              <button name="update_detail" id="update_detail" type="submit" class="btn btn-primary btn-sml">Update User</button>
	                                            </div>
	                <!--register-ntm-->
	                </div>
	              </form>
	              <?php }?>
	              </div>
	                                          <!--<form>
											<div class="form-block">
												<p>To be added...</p>
											</div> <!--form-block->
										</form>--> 
	                                        </div>
	            <!--chng-detl--> 
	          </div>
	                                      <!--account-content--> 
	                                      
	                                      <!--## ANALYTICS CONTENT ##-->
	                                      <div class="analytics-content">
	            <div id="reporting-data">
	                                          <form method="GET" class="form" id="report">
	                <div class="form-block">
	                                              <div class="form-group">
	                    <select name="offer" id="offer_name" onChange="getstats();">
	                    <option value="">---Select---</option>
	                                                  <?php if($_SESSION["advisorid"]!="")
														{	
															$admin_id = $_SESSION["advisorid"];
															if($admin_id != 172)
															{
																$admin_id = $_SESSION["advisorid"];
																$select_add=mysql_query("select * from offers where advisorid = '$admin_id'");
																while($add=mysql_fetch_array($select_add))
																	{?>
																  <option offerid="<?php echo $add['offerid'];?>" style="background-image: url(<?php echo $add['photopath'];?>); background-size:30px 30px; background-repeat:no-repeat; background-position: left; padding-left:50px; margin-bottom:5px;" value="<?php if($add['downloadurl']!=='' && $add['androiddownloadurl']=='' && $add['websiteurl']==''){echo $add['downloadurl'];} else if($add['downloadurl']=='' && $add['androiddownloadurl']!=='' && $add['websiteurl']==''){echo $add['androiddownloadurl'];} else {echo $add['websiteurl'];} ?>"><?php echo $add['title'];?></option>
																  <?php
																	}
															} else 
															{
																$select_add_offer=mysql_query("select * from offers");
																while($add_offer=mysql_fetch_array($select_add_offer))
																{?>
																	 <option offerid="<?php echo $add_offer['offerid'];?>" style="background-image: url(<?php echo $add_offer['photopath'];?>); background-size:30px 30px; background-repeat:no-repeat; background-position: left; padding-left:50px; margin-bottom:5px;" value="<?php if($add_offer['downloadurl']!=='' && $add_offer['androiddownloadurl']=='' && $add_offer['websiteurl']==''){echo $add_offer['downloadurl'];} else if($add_offer['downloadurl']=='' && $add_offer['androiddownloadurl']!=='' && $add_offer['websiteurl']==''){echo $add_offer['androiddownloadurl'];} else {echo $add_offer['websiteurl'];} ?>"><?php echo $add_offer['title'];?></option>
																<?php }
																$select_add1=mysql_query("select * from reporting_cart GROUP BY name");
																while($add1=mysql_fetch_array($select_add1))
																{
																?>
															  <option offerid="<?php echo $add1['id'];?>" value="<?php echo $add1['url']; ?>"><?php echo $add1['name'];?></option>
															  <?php
																}
															}
														}?>
	                                                </select>   
	                  </div>
	                                              <!--form-group-->
	                                              
					  <div class="form-group">
	                    <input type="text" size="12" id="inputField" value='' />
	                    to
	                    <input type="text" size="12" id="inputField1" value=''/>
	                  </div>
	                                              <!--form-group-->
	                                              
	                                              <div class="register-btn to-left">
	                    <button type="submit" name="report_submit" id="report_submit" class="btn btn-primary btn-sml">Update</button>
	                  </div>
	                                              <!--register-btn--> 
	                                            </div>
	                <!--form-block-->
	              </form>
					<div class="analytic-wrapper">
	                <div class="chart-wrapper">
					             
	                </div>
	                <!--chart-wrapper--> 
	                
	              </div>
	                                          <input type="hidden" id="hfIndex" value="0"/>
	                                          <div class="analytic-wrapper">
	                <div class="chart-wrapper"> </div>
	                <!--chart-wrapper--> 
	              </div>
	                                          <!--analytic-wrapper--> 
	                                        </div>
	            <!--reporting-data-->
	      
	            <div id="advertise-data">
					<div>
						<div class="chart-wrapper">
							<div class="table-responsive ">
							<span id="budget_errorbid" class="err-messg" style="display:none;">Your Total Available Balance is <?php echo '$'.$fund-$spentamount; ?>, Please add fund..!!</span>
							<table class="table table-bordered table-hover table-condensed desc show_hide">
								<thead>
									<tr>
									<th class="table-intro" colspan="8">Below is the table of previously added campaigns by you.</th>
									</tr>
									<tr>
									  <th>Icon</th>
									  <th>Name</th>
									  <th>Spend</th>
									  <th>Status</th>
									  <th>Bid</th>
									  <th>Action</th>
									</tr>
							</thead>
							<tbody>
	                        <?php
							$admin_id = $_SESSION["advisorid"];
							if($admin_id != 172)
							{			
								$admin_id = $_SESSION["advisorid"];
								$select_add=mysql_query("select * from offers where advisorid = '$admin_id'");
								while($add=mysql_fetch_array($select_add))
								{?>
								<tr>
						<td id="app-icon"><span class="icn-img"><img src="<?php echo $add['photopath'];?>" alt=""></span></td>
						<td id="app-name"><a href="javascript: void(0);" id="data"><?php echo $add['title'];?></a></td>
						<?php 
							$id = $add['offerid'];
							$app_name = $add['title'];
							$url = $add["websiteurl"];
							if($add["platform"] == "ios")
							{
								$url = $add["downloadurl"];
							}
							else if($add["platform"] == "android")
							{
								$url = $add["androiddownloadurl"];
							}
							$spentamount = 0;
						 
							$q = "SELECT  sum( conversions ) AS paidInstalls, sum( clicks ) AS paidclicks,
							sum(conversions * rewardbid) AS spends FROM ". RETIRELY_DB .".hasofferstats WHERE `offerurl` = '$url'";

							 
							$resoffer = mysql_query($q) or die(mysql_error());
							if(mysql_num_rows($resoffer) > 0)
							{
								while($row = mysql_fetch_assoc($resoffer))
								{
									$spends .= $row["spends"].',';				   
								} 
							}
							$string  = rtrim($spends,',');
							$string = explode(",",$string);
							$spentamount = array_sum ($string);	
						?>
						<td id="app-version" class="test"><?php  echo '$'.number_format($spentamount,2);?></td>
						
						<td id="app-category"><?php if($add['status']==0 && $add['profit']=='' && $add['publisher_bid']=='' ){?>
						<span class="approv-messg">Not Approved</span>
						<?php }else{?>
						<div class="onoffswitch" onClick="toggle(<?php echo $add['offerid'];?>);" data-loop="<?php echo $add['offerid'];?>">
							  <input type="hidden" name="hfonoff" id="hfonoff<?php echo $add['offerid'];?>" value="<?php echo $add['status'];?>">
							  <input type="hidden" name="offerid" id="id<?php echo $add['offerid'];?>" value="<?php echo $add['offerid'];?>">
							  <label class="onoffswitch-label" for="myonoffswitch">
							  <div class="onoffswitch-inner" id="oson<?php echo $add['offerid'];?>"></div>
							  <div class="onoffswitch-switch" id="osoff<?php echo $add['offerid'];?>"></div>
							  </label>
							</div>
						<?php }?></td>
						  <form method="post" id="bid_form">
	                            <input type="hidden" name="id" id="offerid" value="<?php echo $add['offerid'];?>">
	                            <input type="hidden" id="total_fund" name="total_fund" value="<?php echo $fund-$spentamount; ?>">
	                            <td id="app-analytic">$&nbsp;
	                           <input type="text" name="bid" id="bid<?php echo $add['offerid'];?>" value="<?php echo $add['rewardedbid'];?>" style="width:100px;" required>
								</td>
	                            <td><a href="<?php echo  get_bloginfo('url'); ?>/add-campaign?action=delete&id=<?php echo $add['offerid']; ?>" onClick="return confirm('Are You Sure? You want to delete this campaign.');" title="Delete">Delete</a>&nbsp;|&nbsp;<a href="javascript: void(0);" id="update" title="Update" onClick="edit_bid(<?php echo $add['offerid'];?>);">Update</a></td>
	                          </form>
							</tr>
	                        <?php
					}
			} 
			else
			{			
				$admin_id = $_SESSION["advisorid"];
				$select_add=mysql_query("select * from offers");
				while($add=mysql_fetch_array($select_add))
				{?>
					<tr>
						  <td id="app-icon"><span class="icn-img"><img src="<?php echo $add['photopath'];?>" alt=""></span></td>
						  <td id="app-name"><a href="javascript: void(0);" id="data"><?php echo $add['title'];?></a></td>
						  <?php 
							$id = $add['offerid'];
							$app_name = $add['title'];
							$url = $add["websiteurl"];
							if($add["platform"] == "ios")
							{
								$url = $add["downloadurl"];
							}
							else if($add["platform"] == "android")
							{
								$url = $add["androiddownloadurl"];
							}
							$spentamount = 0;
							$spends = 0;
							$q = "SELECT  sum( conversions ) AS paidInstalls, sum( clicks ) AS paidclicks,sum(conversions * rewardbid) AS spends FROM ".RETIRELY_DB.".hasofferstats WHERE `offerurl` = '$url'";

							$resoffer = mysql_query($q) or die(mysql_error());
							if(mysql_num_rows($resoffer) > 0)
							{
								while($row = mysql_fetch_assoc($resoffer))
								{
									$spends .= $row["spends"].',';				   
								} 
							}
							else
							{
								$spentamount = 0;
							}
							$string  = rtrim($spends,',');
							$string = explode(",",$string);
							$spentamount = array_sum ($string);						
						?>
						<td id="app-version"><?php  echo '$'.$spentamount;?></td>
						<td id="app-category"><?php if($add['status']==0 && $add['profit']=='' && $add['publisher_bid']=='' ){?>
	                            <span class="approv-messg">Not Approved</span>
	                            <?php }else{?>
	                            <div class="onoffswitch" onClick="toggle(<?php echo $add['offerid'];?>);" data-loop="<?php echo $add['offerid'];?>">
						  <input type="hidden" name="hfonoff" id="hfonoff<?php echo $add['offerid'];?>" value="<?php echo $add['status'];?>">
						  <input type="hidden" name="offerid" id="id<?php echo $add['offerid'];?>" value="<?php echo $add['offerid'];?>">
						  <label class="onoffswitch-label" for="myonoffswitch">
						  <div class="onoffswitch-inner" id="oson<?php echo $add['offerid'];?>"></div>
						  <div class="onoffswitch-switch" id="osoff<?php echo $add['offerid'];?>"></div>
						  </label>
						</div>
						<?php }?></td>
							<form method="post" id="bid_form">
	                            <input type="hidden" name="id" id="offerid" value="<?php echo $add['offerid'];?>">
	                            <input type="hidden" id="total_fund" name="total_fund" value="<?php echo $fund-$spentamount; ?>">
	                            <td id="app-analytic">$&nbsp;
							  <input type="text" name="bid" id="bid<?php echo $add['offerid'];?>" value="<?php echo $add['rewardedbid'];?>" required>
							  </td>
	                            <td><a href="<?php echo  get_bloginfo('url'); ?>/add-campaign?action=delete&id=<?php echo $add['offerid']; ?>" onClick="return confirm('Are You Sure? You want to delete this campaign.');" title="Delete">Del</a> <a href="javascript: void(0);" id="update" title="Update" onClick="edit_bid(<?php echo $add['offerid'];?>);">Update</a></td>
	                          </form>
							</tr>
	                        <?php }
			}?>
	                      </tbody>
	                                                </table>
	                    <!--table-head--> 
	                  </div>
	                                            </div>
	                <!--chart-wrapper--> 
	              </div>
				<!--advertise-wrapper--> 
				</div>
	            <div id="view-all-app">
	                                          <form method="GET" class="form" id="app_report">
	                <div class="form-block">
	                                              <div class="form-group">
	                    <select name="app_offer" id="app_name">
	                                                  <option value="">---Select---</option>
	                                                  <?php if($_SESSION["advisorid"]!="")
														{	
														$admin_id_app = $_SESSION["advisorid"];
														if($admin_id_app != 172)
														{
														$admin_id_app = $_SESSION["advisorid"];
														$select_add_app=mysql_query("SELECT * FROM `reporting_cart` WHERE `name` IN (select title from offers where advisorid = '$admin_id_app')  GROUP BY `reporting_cart`.name ORDER BY `reporting_cart`.name");
														
														while($add_app=mysql_fetch_array($select_add_app))
														{
															?>
	                                                  <option value="<?php echo $add_app['url']; ?>"><?php echo $add_app['name'];?></option>
	                                                  <?php
														}
														} else {
														$select_add1_app=mysql_query("SELECT * FROM `reporting_cart` WHERE `name` IN (select title from offers)  GROUP BY `reporting_cart`.name ORDER BY `reporting_cart`.name");
														while($add1_app=mysql_fetch_array($select_add1_app))
														{?>
	                                                  <option value="<?php echo $add1_app['url']; ?>"><?php echo $add1_app['name'];?></option>
	                                                  <?php
														}
														}
														}?>
	                                                </select>
	                  </div>
	                                              <!--form-group-->
	                                              
	                                              <div class="form-group">
	                    <input type="text" size="12" id="view_app"  />
	                    to
	                    <input type="text" size="12" id="view_app1" />
	                  </div>
	                                              <!--form-group-->
	                                              
	                                              <div class="register-btn to-left">
	                    <button type="submit" name="view_app_report_submit" id="view_app_report_submit" class="btn btn-primary btn-sml">Update</button>
	                  </div>
	                                              <!--register-btn--> 
	                                            </div>
	                <!--form-block-->
	              </form>
	                                          <div class="analytic-wrapper">
	                <div class="chart-wrapper">
	                                        
	                                            </div>
	                <!--chart-wrapper--> 
	                
	              </div>
	                                          <div class="analytic-wrapper">
	                <div class="chart-wrapper"> </div>
	                <!--chart-wrapper--> 
	              </div>
	                                          <!--analytic-wrapper--> 
	                                        </div>
	            <!--reporting-data--> 
	          </div>
	                                      <!--analytics-content--> 
	                                    </div>
	        <!--sidebar-content--> 
	      </div>
	                                  <!--col--> 
	                                  
	                                </div>
	    <!--row--> 
	  </div> 

	      <!--container--> 
 
	                             </section>

  
 

	       


	<div class="popup-wrapper">
	                              <div class="container">
	    <div class="row">
	                                  <div class="col-md-12 center">
	        <div class="clearfix login-popup">
	                                      <div class="close-popup"><a href="javascript:void(0)" onClick="hideSignIn()"></a></div>
	                                      <div class="create-account">
	            <h1>New User - Create Account</h1>
	            <form method="post" id="createAccountForm">
	                                          <input type="text" name="firstname" placeholder="*First Name" required='required'  pattern="[A-Za-z]+">
	                                          <input type="text" name="lastname"  placeholder="*Last Name" required='required'  pattern="[A-Za-z]+">
	                                          <input type="email" name="email"  placeholder="*Email ID" required='required' pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
	                                          <input type="password" name="password"  placeholder="*Password" required='required'>
	                                          <input type="password" name="cpassword"  placeholder="*Confirm Password" required='required'>
	                                          <input type="number" name="phone"  placeholder="*Phone Number" required='required'>
	                                          <input type="text" name="city"  placeholder="*Pin Code" required >
	                                          <div class="clearfix">
	                <input type="checkbox" name="terms" required='required'>
	                <label for="terms">By signing up, I agree to the Retirely terms/conditions and privacy policy.</label>
	              </div>
	                                          <div>
	                <input name="action" type="hidden" value="signup"/>
	                <button type="submit" class="btn btn-primary" name="signup">Create Account</button>
	              </div>
	                                          <br/>
	                                          <!--right-->
	                                          
	                                          <label style="color:red;" id="respSignUp"></label>
	                                        </form>
	          </div>
	                                      <!--create-account-->
	                                      
	                                      <div class="sep"></div>
	                                      <div class="sign-in">
	            <h1>Already a User - Sign In</h1>
	            <form id="loginForm" method="post">
	                                          <input type="text" name="email" required placeholder="Email ID" id="email">
	                                          <input type="password" name="password" required placeholder="Password" id="password">
	                                          <div class="clearfix">
	                <input type="checkbox" name="remember">
	                <label for="remember">Remember me!</label>
	              </div>
	                                          <div>
	                <input name="action" type="hidden" value="signin" id="signin"/>
	                <button type="submit" class="btn btn-primary" name="signin" id="submit">Sign Me In</button>
	              </div>
	                                          <br/>
	                                          <!--right-->
	                                          
	                                          <div id="someElement" style="color:red;"></div>
	                                        </form>
	            
	            <script>

	                            jQuery(document).ready(function($){

	                  $('#submit').click(function(){

	                  if(document.getElementById('email').value=='' || document.getElementById('password').value==''){

	                                $("#someElement").html("Please Enter Email and Password");

	                                } else {

	                                var srt = $("#loginForm").serialize();

	                                // alert is working perfect

	                                $.ajax({

	                                    type: 'POST',

	                                    url: '<?php echo get_bloginfo("url"); ?>/ajax/action.php',

	                                    data: srt,

	                                    success: function(response) {

	                                        //alert(response);

	                                        if(parseInt(response) == 1) 

											{

												window.location.href="<?php get_bloginfo('url');?>";

											} else {

												$("#someElement").text(response).fadeIn("slow");

											}

	                                    }

	                            });

	                                }

	                                 return false;

	                            });

	                            

	                            });

	    

								function SignUp(){	

									var query = $('#createAccountForm').serialize();

									var url = '<?php echo get_bloginfo("url"); ?>/action.php';					                                $.post(url, query, function (response) {

										if(parseInt(response) == 1) 

										{

											location.reload();

										}

										else if(response != 0) 

										{

											$("#respSignUp").text(response).fadeIn("slow");

										}

									});								

								}

	                            function advisorSignOut(){

	                                var url = '<?php echo get_bloginfo("url"); ?>/logout.php';                    

	                                var query="data=advisor";                     

	                                $.post(url, query, function (response) { 

									//alert(response);                                  

	                                    window.location.href="<?php get_bloginfo('url');?>";                                 

									});

								}

								function isSignIn()

								{

									var result = false;

									var id = '<?php echo $_SESSION['advisorid']; ?>';	

									if(id == "")

									{

										showSignIn();

										window.scrollTo(0,0);

										result = false;

									}

									else {

										result = true;

									} return result;

								}

								</script> 
	          </div>
	                                      <!--sign-in--> 
	                                      
	                                    </div>
	        <!--login-popup--> 
	        
	      </div>
	                                  <!--col-md-12--> 
	                                  
	                                </div>
	    <!--row--> 
	    
	  </div>
	                              <!--container--> 
	                 </div>             

	
	                        </body>
	<script type="text/javascript">
	window.jQuery(function($){
	$(".search").keyup(function() 
	{ 
	var searchid = $(this).val();
	var dataString = 'search='+ searchid;
	if(searchid!='')
	{
		$.ajax({
		type: "POST",
		url: "search.php",
		data: dataString,
		cache: false,
		success: function(html)
		{
		$("#result").html(html).show();
		}
		});
	}return false;    
	});

	/*jQuery("#result").live("click",function(e){ 
		var $clicked = $(e.target);
		var $name = $clicked.find('.name').html();
		var decoded = $("<div/>").html($name).text();
		$('#offer_name').val(decoded);
	});
	jQuery(document).live("click", function(e) { 
		var $clicked = $(e.target);
		if (! $clicked.hasClass("search")){
		jQuery("#result").fadeOut(); 
		}
	});*/
	$('#offer_name').click(function(){
		jQuery("#result").fadeIn(); 
	});
	});
		jQuery(document).ready(function($){
			$(".analytic-wrapper").hide();
			//alert($(".analytic-wrapper").html());
			Date.prototype.yyyymmdd = function() {
			   var yyyy = this.getFullYear().toString();
			   var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
			   var dd  = this.getDate().toString();
			   return yyyy +"-" +(mm[1]?mm:"0"+mm[0]) +"-"+(dd[1]?dd:"0"+dd[0]); // padding
			  };
			/*
			d = new Date();
			var dt =d.yyyymmdd();
			$.ajax({
				type: 'get',
				url: '<?php bloginfo('siteurl');?>/getdailytapjoydata.php?dt='+dt,
				data: {},
				success: function (data) {
					//$("#iframe").attr('src',url);
					//$(".analytic-wrapper").show();
					console.log(escape(data));
				}
			});
			*/
		});
		if(document.getElementById("campaign"))
		{
	        document.getElementById("campaign").className = 'active';
		}
		
		
	</script> 
	<!--JS, placed here for faster page loading--> 
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.selectbox/0.2/css/jquery.selectbox.css">
   <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
   <script type='text/javascript' src="//cdn.jsdelivr.net/jquery.selectbox/0.2/js/jquery.selectbox-0.2.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/js/jquery-1.7.2.min.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/js/ajax/bootstrap.min.js"></script> 
	<script src="<?php bloginfo('template_directory'); ?>/js/ajax/jquery.js"></script> 
	<script src="<?php bloginfo('template_directory'); ?>/js/masonry.pkgd.min.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/js/modernizr.custom.63321.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/js/custom.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/js/html5.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/js/jquery.dropdown.js"></script> 
	

	<script src="<?php bloginfo('template_directory'); ?>/js/ajax/jquery.carouFredSel-6.2.1.js"></script> 
	<script src="<?php bloginfo('template_directory'); ?>/js/ajax/smooth-scroll.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/js/ajax/jsDatePick.min.1.3.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/js/jquery.selectbox-0.2.min.js"></script>
 
<!-- start if infinite Scroll -->

 

<div class="clear"></div>
</div><!-- end .home-fullwidth -->
<?php	  get_footer(); ?>
		                </html>
