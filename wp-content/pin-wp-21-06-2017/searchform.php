
<!--script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script-->
<script>
$(document).ready(function(){
 $("#close-serch").click(function() {
 	$("#search-btn-for-mobile").show();
    });
 $("#close-search-form").click(function() {
 	$("#search-btn-for-mobile").hide();
    });

	$("#search-box").keyup(function(){
		$.ajax({
		type: "POST",
		url: "/search_data.php",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#search-box").addClass("live-search-loader");
		},
		success: function(data){
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			
                        $("#search-box").removeClass("live-search-loader");
		}
		});
	});
});

function redirectSymbos(val) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
window.location.href="/?symbol="+val;
}
function redirectAuthor(uname,flname) {
$("#search-box").val(flname);
$("#suggesstion-box").hide();
window.location.href="/?auth="+uname;
}

</script>
	<div class="header-search-form" id="search-btn-for-mobile">
		<form id="searchform2" class="header-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		    <input placeholder="<?php esc_html_e('Search...', 'anthemes'); ?>" autocomplete="off" type="text" name="s" id="search-box" />
		    <input type="submit" value="Search" class="buttonicon" />	
			<span class="buttonicon-2" id="close-search-form" /></span>			
            <div id="suggesstion-box"></div>
		</form>
	</div>
	<div class="search-close-btn">
		<div id="close-serch">
		<i class="fa fa-search"></i>
		</div>
	</div>

<div class="clear"></div>
