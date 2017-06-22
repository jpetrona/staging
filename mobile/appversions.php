<?php 
session_start();
if($_SESSION["myusername"]=="" && $_SESSION["mypassword"]=="")
{
header("location:index.php");
} 
include('in_header.php');
	    
	?>
		
	
       <div class="right">   
         <div class="center_mess">Manage App Versions<div style="float:right;margin-right:10px;margin-bottom:10px;">  
         <?php /*?><a href="adduser.php" style="text-decoration:underline; color:#066; white-space:nowrap;">Add User</a> 
&nbsp;|&nbsp;<a href="#" style="text-decoration:underline; color:#066; white-space:nowrap;">Reset</a>
<?php */?>       
   	 	 </div>
       </div>
       <?php
         $sql ="SELECT * FROM appversion";            
         $pager = new PS_Pagination($conn, $sql,100, 20, "param1=value1&param2=value2");
         $pager->setDebug(true);
         $rs1 = $pager->paginate();			 
         ?> 
                 <table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
                <td colspan="6" id="user_status_mess"></td>
            </tr>
            <tr class="tr_dis">                
                <td valign="top" width="250px;"><strong>Version</strong></td> 
                <td valign="top" width="400px;"><strong>Device Type</strong></td>
                <td valign="top" width="200px;"><strong>Action</strong></td>
            </tr>
        <?php
        if($rs1)
        {
              $i=0;
                  while($row = mysql_fetch_array($rs1))   
                   {$i=$i+1; ?> 
                   <tr class="tr_dis1">                       
                        <td  valign="top" class="td_dis1"><?php echo $row["version"]; ?></td>
					    <td  valign="top" class="td_dis1"><?php echo $row["devicetype"]; ?></td>
                        <td valign="top" class="td_dis1">
							<a href="appversion.php?id=<?php echo $row['id']; ?>">Edit</a>
                        </td>            
                   </tr>
                <?php }
                }
                else
                {?>
                    <tr class="td_dis">     
                        <td colspan="7" align="center" ><br /><br />No App Versions Found</td>
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