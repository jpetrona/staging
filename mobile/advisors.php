<?php 
session_start();
if($_SESSION["myusername"]=="" && $_SESSION["mypassword"]=="")
{
header("location:index.php");
} 
include('in_header.php');
if(isset($_REQUEST['task']) && $_REQUEST['task']=='delete' && $_REQUEST['id']!='' )
   {
        $sql="DELETE FROM `advisors` WHERE `advisorid`=".$_REQUEST['id'];
if(mysql_query($sql))
   {
	    
	?>
		<script>
		alert("Your user has been successfully Deleted!");
		window.location.href = 'advisors.php';</script>
	 <?php 
   }
 
 }



?>
<div class="right">   
         <div class="center_mess">Manage Advisor</div>
		<?php
           /*$sql = "SELECT  photos.photoid,photos.userid,.photos.photopath,photos.date, users.username, users.userid,friends.friendid,friends.senderid FROM  photos JOIN users   ON users.userid = photos.userid  JOIN friends ON  users.userid=friends.senderid  ORDER BY photos.date DESC";*/
		         $sql="SELECT * From  advisors";
			     $pager = new PS_Pagination($conn, $sql,100, 20, "param1=value1&param2=value2");
                 $pager->setDebug(true);
                 $rs1 = $pager->paginate();			 
         ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
                <td colspan="6" id="user_status_mess"></td>
            </tr>
            <tr class="tr_dis">                
                 <td valign="top" width="200px;"><strong>First Name</strong></td>
				 <td valign="top" width="200px;"><strong>Last Name</strong></td> 
                 <td valign="top" width="200px;"><strong>Email</strong></td>
                 <td valign="top" width="200px;"><strong>Photo</strong></td>                
                 <td valign="top" width="200px;"><strong>Contact No</strong></td>
                 <td valign="top" width="200px;"><strong>Website</strong></td>
                 <td valign="top" width="150px;"></td>
                 <td valign="top" width=""><strong>Action</strong></td>
              
                <td valign="top"></td>
            </tr>
        <?php
        if($rs1)
        {
              $i=0;
                  while($row = mysql_fetch_array($rs1))  
                   {$i=$i+1; ?> 
                   <tr class="tr_dis1">                       
                        <td valign="top" class="td_dis1"><?php echo $row["fname"];?></td>
						<td valign="top" class="td_dis1"><?php echo $row["lname"];?></td>
                        <td valign="top" class="td_dis1"><?php echo $row["email"];?></td>
                        <td valign="top" class="td_dis1"><img src="<?php echo $row["photopath"];?>"  alt=""  style="width: 60px;"/></td>                         
                        <td valign="top" class="td_dis1"><?php echo $row["phone"];?></td>
                        <td valign="top" class="td_dis1"><?php echo $row["website"];?></td>
                        <td valign="top" class="td_dis1">
                        <?php if($row["status"] == '10') {?>
                       <a href="javascript:advisor('<?php echo $row['advisorid'];?>','0');" style="text-decoration:underline; color:#066">Lock User</a>
                       <?php }else if($row["status"] == '0') {?>  
                       	<a href="javascript:advisor('<?php echo $row['advisorid'];?>','10');" style="text-decoration:underline; color:#066">Unlock User</a>   
                        <?php }?>
                        </td>
                        <td valign="top" class="td_dis1"><a href="advisors.php?task=delete&id=<?php echo $row['advisorid']; ?>" onClick="return confirm(\'Are You Sure,Want to Delete?\');">DELETE</a></td>                          
                    </tr>
                <?php }
                }
                else
                {?>
                    <tr class="td_dis">     
                        <td colspan="7" align="center" ><br /><br />No Advisors Found</td>
                     </tr>
                     
            <?php	}?>
            		<tr class="td_dis">     
                        <td colspan="7" align="center"></td>
                     </tr>              		
              		<tr class="td_dis">     
                        <td colspan="7" align="center" style="padding-top:20px;"><?php echo $pager->renderFullNav()?></td>
                     </tr>                              
        	</table>			
		</div><!-- /right -->
<?php include('in_footer.php'); ?>
