
<!--script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script-->
<script>
$(document).ready(function(){
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
function redirectAuthor(val) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
window.location.href="/?auth="+val;
}

</script>
<form id="searchform2" class="header-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input placeholder="<?php esc_html_e('Search...', 'anthemes'); ?>" type="text" name="s" id="search-box" />
    <input type="submit" value="Search" class="buttonicon" />
	<div id="suggesstion-box"></div>
</form><div class="clear"></div>
