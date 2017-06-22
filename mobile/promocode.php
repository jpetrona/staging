<?php 
session_start();
if($_SESSION["myusername"]=="" && $_SESSION["mypassword"]=="")
{
header("location:index.php");
} 
include('in_header.php');
include("config.php");
if(isset($_POST['submit'])) {      
   $no_of_code=$_POST['no_of_codes'];
   $currdate=date('y-m-d');
   $status=10;
   for($i=1;$i<=$no_of_code; $i++) {
	  $codes=strtolower(substr(md5(uniqid(mt_rand(), true)), 0, 4));
          $q = "SELECT * FROM promocodes WHERE code = '$codes'";
          $res=mysql_query($q);          
          if(mysql_num_rows($res) == 0)
          {	         
	      $results=mysql_query("INSERT into promocodes(`code`,`date`,`status`) values('$codes','$currdate','$status')");
          }
    }	   
 }
?>
<div class="right">   
         <div class="center_mess">Manage Promo Codes</div>
<table>
  <form name="myform" method="post" actio="">
	<tr>
	     <td> No. of Codes to be generate </td>
             <td> <input type="text" name="no_of_codes" class=""  >  </td>	
              <td> <input type="submit" name="submit" value="Generate">  </td>				 
	</tr>
	</form>
		   </table>
		   
		   
		    <table width="100%" border="0" cellspacing="0" cellpadding="5">
			<?php
		         $sql="SELECT * From  promocodes ORDER BY date DESC";
			 $pager = new PS_Pagination($conn, $sql,100, 20, "param1=value1&param2=value2");
                         $pager->setDebug(true);
                         $rs1 = $pager->paginate();			 
                        ?>
			
            <tr>
                <td colspan="6" id="user_status_mess"></td>
            </tr>
            <tr class="tr_dis">                
                 <td valign="top" width="200px;"><strong>Code</strong></td>             
                 <td valign="top" width="200px;"></td>
                 <td valign="top" width="200px;"></td>
                 <td valign="top"></td>
            </tr>
        <?php
        if($rs1)
        {
              $i=0;
                  while($row = mysql_fetch_array($rs1))  
                   {$i=$i+1; ?> 
                   <tr class="tr_dis1">                       
                        <td valign="top" class="td_dis1"><?php echo $row["code"];?></td>
                        <td valign="top" class="td_dis1"></td>
			            <td valign="top" class="td_dis1"></td> 
                        <td valign="top" class="td_dis1">&nbsp;</td>                        
                    </tr>
                <?php }
                }
                else
                {?>
                    <tr class="td_dis">     
                        <td colspan="7" align="center" ><br /><br />No Promo codes Found</td>
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