<?php
/*
Plugin name: Manage Source
Description:This Plugin Manage Sources 
Url:http://www.linkites.com
Author:Amit Sharma
*/

add_action('admin_menu','mg_profile');
function mg_profile()
{
	add_menu_page(__('Manage Source','menu-test'),__('Manage Source','menu-test'),'manage_options','profile-top-handle','handle_top_page1');
}

function handle_top_page1()
{
	global $wpdb;
	if(isset($_POST['addteamimg']))
	{   
	      $img_arr=explode('.',$_FILES['sourceimg']['name']);
	      $sourcename = str_replace(' ', '', $_POST['sourcename']);
	      $sourcename = strtolower($sourcename);
	      $img=$sourcename.'.'.$img_arr[1];
		$imgpath=ABSPATH.'wp-content/themes/pin-wp/images/source/'.$img; 
		$add=$wpdb->query("INSERT INTO a1_source(sourcename,sourceurl,sourceimg) VALUES('".$_POST['sourcename']."','".$_POST['sourceurl']."','".$img."')");
		move_uploaded_file($_FILES['sourceimg']['tmp_name'],$imgpath);
		if($add)
		{
			
echo'<script type="text/javascript">window.location.href="admin.php?page=profile-top-handle"</script>';
			}
		}
	if(isset($_POST['upteamimg']))
	{   
	     
		$upd=$wpdb->query("UPDATE a1_source SET sourcename='".$_POST['sourcename']."',sourceurl='".$_POST['sourceurl']."' WHERE id='".$_POST['id']."'");
		
		if(!empty($_FILES['sourceimg']['name']))
		{
		$img=time().$_FILES['sourceimg']['name'];
	    $imgpath=ABSPATH.'wp-content/themes/pin-wp/images/source/'.$img;
		$upd=$wpdb->query("UPDATE a1_source  SET sourceimg='".$img."' WHERE id='".$_POST['id']."'");
		move_uploaded_file($_FILES['sourceimg']['tmp_name'],$imgpath);
		
			}
		
			echo'<script type="text/javascript">window.location.href="admin.php?page=profile-top-handle"</script>';

			
		}
	if(isset($_GET['delteam']))
	{
		$getpath=$wpdb->get_results("SELECT * FROM a1_source WHERE id='".$_GET['delteam']."' ");
		
	$imgpath=ABSPATH.'wp-content/themes/pin-wp/images/source/'.$getpath[0]->sourceimg;
		
		if(file_exists($imgpath))
	 {
	  unlink($imgpath);
	 }
		
		$del=$wpdb->query("DELETE FROM a1_source WHERE id='".$_GET['delteam']."'");
		}
	if(!empty($_GET['team']))
	{   $getbgd=$wpdb->get_results("SELECT * FROM a1_source");
		?>
        
        
<script type="text/javascript">
function validate()
{
	 var x=document.forms["thisform"]["sourcename"].value;
            if (x==null || x=="")
            {
            alert( "Please enter name");
            return false;
            }
			
	          var x=document.forms["thisform"]["sourceurl"].value;
            var message;
            var myRegExp =/^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$/i;
            var urlToValidate = x;

            if (x==null || x=="")
            {
            alert("Please enter URL of SOURCE");
            return false;
            } 
            if (!myRegExp.test(urlToValidate)){
            message = "Not a valid URL.";
            alert(message);
            } 
             
            var fup = document.getElementById('sourceimg'); var fileName = fup.value; var ext = fileName.substring(fileName.lastIndexOf('.') + 1); if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "png") { return true; } else { alert("Upload Gif , Jpg or png image only"); fup.focus(); return false; }	
			
			 
}
</script>        
        

<form action="" method="post" enctype="multipart/form-data" onsubmit="return validate()" name="thisform">

<center>
<caption style="color: #3300FF">
    <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Add Source Here</h3>
    </caption>
  <div style="border: 1px solid rgb(204, 204, 204); height: 188px; width: 490px;">    
  <table class="widefat">
    
    <tr>
      <td><label>Name</label><span>*</span></td>
      <td><input type="text" name="sourcename"  size="40" placeholder="Enter name">
        </td>
    </tr>
    <tr>
      <td><label>Source Url</label><span>*</span></td>
      <td><input type="url" name="sourceurl"  size="40" placeholder="Enter source url">
       </td>
    </tr>
    <tr>
      <td><label>Source Image</label><span>*</span></td>
      <td><input type="file" name="sourceimg" id="sourceimg">
       </td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" accesskey="p" value="Save" class="button button-primary button-large" id="addteamimg" name="addteamimg"></td>
    </tr>
  </table>
  </div>
  </center>
  
</form>
<?php }
   elseif(!empty($_GET['upteam']))
        {
			$upd=$wpdb->get_row("SELECT * FROM a1_source WHERE id='".$_GET['upteam']."'");
			$getbgd=$wpdb->get_results("SELECT * FROM a1_source");
		
		?>
        
<script type="text/javascript">
function validate()
{
	 var x=document.forms["thisform"]["sourcename"].value;
            if (x==null || x=="")
            {
            alert( "Please enter name");
            return false;
            }
			
	var x=document.forms["thisform"]["sourceurl"].value;
  var message;
  var myRegExp =/^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$/i;
  var urlToValidate = x;
   if (x==null || x=="")
    {
    alert("Please enter Source");
    return false;
    }

  if (!myRegExp.test(urlToValidate)){
  message = "Not a valid URL.";
  alert(message);
  } 
  
 
	
}  
</script>      
        
 <form action="" method="post" enctype="multipart/form-data" onsubmit="return validate()" name="thisform">
       <input type="hidden" name="id" value="<?php echo $_GET['upteam']?>"/>
 <center>
    <caption style="color: #3300FF">
    <h3> Update Source Data </h3>
    </caption>
 <div style="border: 1px solid rgb(204, 204, 204); height: 188px; width: 490px;">   
  <table >
    
    <tr>
      <td><label>Name</label><span>*</span></td>
      <td><input type="text" name="sourcename" maxlength="30" value="<?php echo $upd->sourcename?>">
       </td>
    </tr>
    <tr>
      <td><label>Source Url</label><span>*</span></td>
      <td><input type="url" name="sourceurl" value="<?php echo $upd->sourceurl?>"/>
        </td>
    </tr>
    <tr>
      <td><label>Source Image</label><span>*</span></td>
      <td><input type="file" name="sourceimg"><br><img src="<?php echo get_template_directory_uri();?>/images/source/<?php echo $upd->sourceimg;?>" height="70" width="70">
        </td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" accesskey="p" value="Edit" class="button button-primary button-large" id="upteamimg" name="upteamimg">&nbsp;&nbsp;<input type="button" accesskey="p" value="Cancel" onclick="window.location.href='admin.php?page=profile-top-handle'" class="button button-primary button-large" id="Cancel" name="Cancel"></td>
    </tr>
  </table>
</form>
</div>

</center>
 
	  <?php }
		else
		{
			$getresult=$wpdb->get_results("SELECT * FROM a1_source order by id desc");
	?>
 </br>
<div class="wrap">
<a href="admin.php?page=profile-top-handle&team=addteam" class="add-new-h2">Add New Source</a>
</div>
 <caption style="color: #0033FF">
  <h3>Source List</h3>
  </caption>
<table class="widefat">
 <thead>
  <tr>
    <th class="manage-column column-cb check-column">Sr. No.</th>
    <th class="manage-column column-cb check-column">Source Name</th>
    <th class="manage-column column-cb check-column">Source Url</th>
    <th class="manage-column column-cb check-column">Image</th>
    <th class="manage-column column-cb check-column">Action</th>
  </tr>
  </thead>
  <tfoot>
  <tr>
    <th class="manage-column column-cb check-column">Sr. No.</th>
    <th class="manage-column column-cb check-column">Source Name</th>
    <th class="manage-column column-cb check-column">Source Url</th>
    <th class="manage-column column-cb check-column">Image</th>
    <th class="manage-column column-cb check-column">Action</th>
  </tr>
  </tfoot>
  <?php $i=1; foreach($getresult as $getval):?>
  <tr>
    <td><?php echo $i;?></td>  
    <td><?php echo $getval->sourcename?></td>
    <td><?php echo $getval->sourceurl?></td>
    <td><img src="<?php echo get_template_directory_uri();?>/images/source/<?php echo $getval->sourceimg;?>" width="80"></td>
    <td> <a href="admin.php?page=profile-top-handle&upteam=<?php echo $getval->id;?>"><img src="<?php echo get_template_directory_uri().'/images/source/images/plus.png';?>"  alt="Edit"  title="Edit"/></a><a href="#" onclick="if(confirm('do you want to delete')==true){window.location.href='admin.php?page=profile-top-handle&delteam=<?php echo $getval->id;?>'}"><img src="<?php echo get_template_directory_uri().'/images/source/images/minus.png';?>"  title="Delete"/></a></td>
  </tr>
 
  <?php $i++; endforeach;?>
</table>
<?php }

	

}
?>
