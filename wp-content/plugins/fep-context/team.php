<?php
/*
Plugin name: Manage context
Description:This Plugin Manage contexts 
Url:http://www.linkites.com
Author:Amit Sharma
*/

add_action('admin_menu','fep_context');
function fep_context()
{
	add_menu_page(__('Manage context'),__('Manage context'),'manage_options','profile-top-handle-context','handle_top_page2','',8);
}

function handle_top_page2()
{
	global $wpdb;
	if(isset($_POST['addteamimg']))
	{   
	    $img=$_FILES['contextimg']['name'];
	    $imgpath=ABSPATH.'wp-content/themes/pin-wp/images/context/'.$img; 
		$add=$wpdb->query("INSERT INTO a1_context(contextname,contextimg) VALUES('".$_POST['contextname']."','".$img."')");
		move_uploaded_file($_FILES['contextimg']['tmp_name'],$imgpath);
		if($add)
		{
			
echo'<script type="text/javascript">window.location.href="admin.php?page=profile-top-handle-context"</script>';
			}
		}
	if(isset($_POST['upteamimg']))
	{   
	     
		$upd=$wpdb->query("UPDATE a1_context SET contextname='".$_POST['contextname']."' WHERE id='".$_POST['id']."'");
		
		if(!empty($_FILES['contextimg']['name']))
		{
		$img=time().$_FILES['contextimg']['name'];
	    $imgpath=ABSPATH.'wp-content/themes/pin-wp/images/context/'.$img;
		$upd=$wpdb->query("UPDATE a1_context  SET contextimg='".$img."' WHERE id='".$_POST['id']."'");
		move_uploaded_file($_FILES['contextimg']['tmp_name'],$imgpath);
		
			}
		
			echo'<script type="text/javascript">window.location.href="admin.php?page=profile-top-handle-context"</script>';

			
		}
	if(isset($_GET['delteam']))
	{
		$getpath=$wpdb->get_results("SELECT * FROM a1_context WHERE id='".$_GET['delteam']."' ");
		
	$imgpath=ABSPATH.'wp-content/themes/pin-wp/images/context/'.$getpath[0]->contextimg;
		
		if(file_exists($imgpath))
	 {
	  unlink($imgpath);
	 }
		
		$del=$wpdb->query("DELETE FROM a1_context WHERE id='".$_GET['delteam']."'");
		}
	if(!empty($_GET['team']))
	{   $getbgd=$wpdb->get_results("SELECT * FROM a1_context");
		?>
        
        
<script type="text/javascript">
function validate()
{
	 var x=document.forms["thisform"]["contextname"].value;
            if (x==null || x=="")
            {
            alert( "Please enter name");
            return false;
            }
			
	        /*  var x=document.forms["thisform"]["contexturl"].value;
            var message;
            var myRegExp =/^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$/i;
            var urlToValidate = x;

            if (x==null || x=="")
            {
            alert("Please enter URL of context");
            return false;
            } 
            if (!myRegExp.test(urlToValidate)){
            message = "Not a valid URL.";
            alert(message);
            }    */
             
            var fup = document.getElementById('contextimg'); var fileName = fup.value; var ext = fileName.substring(fileName.lastIndexOf('.') + 1); if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "png") { return true; } else { alert("Upload Gif , Jpg or png image only"); fup.focus(); return false; }	
			
			 
}


</script>        
        

<form action="" method="post" enctype="multipart/form-data" onsubmit="return validate()" name="thisform">

<center>
<caption style="color: #3300FF">
    <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Add context Here</h3>
    </caption>
  <div style="border: 1px solid rgb(204, 204, 204); height: 188px; width: 490px;">    
  <table class="widefat">
    
    <tr>
      <td><label>Name</label><span>*</span></td>
      <td><input type="text" name="contextname"  size="40" placeholder="Enter name">
        </td>
    </tr>
    <tr>
      <td><label>context Image</label><span>*</span></td>
      <td><input type="file" name="contextimg" id="contextimg">
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
			$upd=$wpdb->get_row("SELECT * FROM a1_context WHERE id='".$_GET['upteam']."'");
			$getbgd=$wpdb->get_results("SELECT * FROM a1_context");
		
		?>
        
<script type="text/javascript">
function validate()
{
	 var x=document.forms["thisform"]["contextname"].value;
            if (x==null || x=="")
            {
            alert( "Please enter name");
            return false;
            }
			
	/*var x=document.forms["thisform"]["contexturl"].value;
  var message;
  var myRegExp =/^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$/i;
  var urlToValidate = x;
   if (x==null || x=="")
    {
    alert("Please enter context");
    return false;
    }

  if (!myRegExp.test(urlToValidate)){
  message = "Not a valid URL.";
  alert(message);
  } */
  
 
	
}  
</script>      
        
 <form action="" method="post" enctype="multipart/form-data" onsubmit="return validate()" name="thisform">
       <input type="hidden" name="id" value="<?php echo $_GET['upteam']?>"/>
 <center>
    <caption style="color: #3300FF">
    <h3> Update context Data </h3>
    </caption>
 <div style="border: 1px solid rgb(204, 204, 204); height: 188px; width: 490px;">   
  <table >
    
    <tr>
      <td><label>Name</label><span>*</span></td>
      <td><input type="text" name="contextname" maxlength="30" value="<?php echo $upd->contextname?>">
       </td>
    </tr>
      <tr>
      <td><label>context Image</label><span>*</span></td>
      <script>

</script>
      <td><input type="file" name="contextimg"  ><br>
      <img id="imageupload" src="<?php echo get_template_directory_uri();?>/images/context/<?php echo $upd->contextimg;?>" height="70" width="70">
        </td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" accesskey="p" value="Edit" class="button button-primary button-large" id="upteamimg" name="upteamimg">&nbsp;&nbsp;<input type="button" accesskey="p" value="Cancel" onclick="window.location.href='admin.php?page=profile-top-handle-context'" class="button button-primary button-large" id="Cancel" name="Cancel"></td>
    </tr>
  </table>
</form>
</div>

</center>
 
	  <?php }
		else
		{
			$getresult=$wpdb->get_results("SELECT * FROM a1_context order by id desc");
	?>
 </br>
<div class="wrap">
<a href="admin.php?page=profile-top-handle-context&team=addteam" class="add-new-h2">Add New context</a>
</div>
 <caption style="color: #0033FF">
  <h3>context List</h3>
  </caption>
<table class="widefat">
 <thead>
  <tr>
    <th class="manage-column column-cb check-column">Sr. No.</th>
    <th class="manage-column column-cb check-column">Context Name</th>
    <th class="manage-column column-cb check-column">Image</th>
    <th class="manage-column column-cb check-column">Action</th>
  </tr>
  </thead>
  <tfoot>
  <tr>
    <th class="manage-column column-cb check-column">Sr. No.</th>
    <th class="manage-column column-cb check-column">Context Name</th>
    <th class="manage-column column-cb check-column">Image</th>
    <th class="manage-column column-cb check-column">Action</th>
  </tr>
  </tfoot>
  <?php $i=1; foreach($getresult as $getval):?>
  <tr>
    <td><?php echo $i;?></td>  
    <td><?php echo $getval->contextname?></td>
    <td><img src="<?php echo get_template_directory_uri();?>/images/context/<?php echo $getval->contextimg;?>" width="80"></td>
    <td> <a href="admin.php?page=profile-top-handle-context&upteam=<?php echo $getval->id;?>"><img src="<?php echo get_template_directory_uri().'/images/context/images/plus.png';?>"  alt="Edit"  title="Edit"/></a><a href="#" onclick="if(confirm('do you want to delete')==true){window.location.href='admin.php?page=profile-top-handle-context&delteam=<?php echo $getval->id;?>'}"><img src="<?php echo get_template_directory_uri().'/images/context/images/minus.png';?>"  title="Delete"/></a></td>
  </tr>
 
  <?php $i++; endforeach;?>
</table>
<?php }

	

}
?>
