<?php 
session_start();
if($_SESSION["myusername"]=="" && $_SESSION["mypassword"]=="")
{
header("location:index.php");
} 
include('in_header.php');
if(isset($_REQUEST['task']) && $_REQUEST['task']=='delete' && $_REQUEST['id']!='' )
   {
        $sql="DELETE FROM `users` WHERE `userid`=".$_REQUEST['id'];
if(mysql_query($sql))
   {
	    
	?>
		<script>
		alert("Your user has been successfully Deleted!");
		window.location.href = 'users.php';</script>
	 <?php 
   }
 
 }
?>
	
       <div class="right">   
         <div class="center_mess">Manage Users<div style="float:right;margin-right:10px;margin-bottom:10px;">  
         <?php /*?><a href="adduser.php" style="text-decoration:underline; color:#066; white-space:nowrap;">Add User</a> 
&nbsp;|&nbsp;<a href="#" style="text-decoration:underline; color:#066; white-space:nowrap;">Reset</a>
<?php */?>       
   	 	 </div>
       </div>
       <?php
         $sql ="SELECT * FROM users";            
         $pager = new PS_Pagination($conn, $sql,100, 20, "param1=value1&param2=value2");
         $pager->setDebug(true);
         $rs1 = $pager->paginate();			 
         ?> 
                 <table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
                <td colspan="6" id="user_status_mess"></td>
            </tr>
            <tr class="tr_dis">                
                <td valign="top" width="250px;"><strong>First Name</strong></td> 
				<td valign="top" width="250px;"><strong>Last Name</strong></td>
                <td valign="top" width="400px;"><strong>Email</strong></td>
                <td valign="top" width="200px;"></td>
                <td valign="top" width="200px;"><strong>Action</strong></td>
            </tr>
        <?php
        if($rs1)
        {
              $i=0;
                  while($row = mysql_fetch_array($rs1))   
                   {$i=$i+1; ?> 
                   <tr class="tr_dis1">                       
  						<!--<td valign="top" class="td_dis1">
		<?php // echo $row["firstname"]." " .$row["lastname"];?></td>  -->
                       <td  valign="top" class="td_dis1"><?php echo $row["fname"]; ?></td>
					   <td  valign="top" class="td_dis1"><?php echo $row["lname"]; ?></td>
                       <td valign="top" class="td_dis1"><?php echo $row["email"];?></td>
                       <td valign="top" class="td_dis1">
                        <?php if($row["status"] == '10') {?>
                       <a href="javascript:suspend_user('<?php echo $row['userid'];?>','0');" style="text-decoration:underline; color:#066">Lock User</a>
                       <?php }else if($row["status"] == '0') {?>  
                       	<a href="javascript:suspend_user('<?php echo $row['userid'];?>','10');" style="text-decoration:underline; color:#066">Unlock User</a>   
                        <?php }?>
                        </td>
                        <td valign="top" class="td_dis1"><a href="users.php?task=delete&id=<?php echo $row['userid']; ?>" onClick="return confirm(\'Are You Sure,Want to Delete?\');">DELETE</a></td>            
                   </tr>
                <?php }
                }
                else
                {?>
                    <tr class="td_dis">     
                        <td colspan="7" align="center" ><br /><br />No Users Found</td>
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