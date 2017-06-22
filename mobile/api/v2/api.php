<?php
OnLoad();
class funcs_code 
{
	var $conn="";
   var $dba="db169264_retirelynew"; 
   var $host="internal-db.s169264.gridserver.com";
   var $user="db169264";
   var $pass="Retirely@11";
   /*var $conn="";
   var $dba="db169264_retirely"; 
   var $host="internal-db.s169264.gridserver.com";
   var $user="db169264";
   var $pass="Id6ZpIb9e0oT3Z";*/ 
  
   public function connection()
   {
      $this->conn=mysql_connect($this->host,$this->user,$this->pass) or die(mysql_error());	
      $this->dba=mysql_select_db($this->dba,$this->conn) or die(mysql_error());	
   }
   	
   public function query($sql_q)
   {
      $result=mysql_query($sql_q);
      if(!$result){die(mysql_error());}else{return $result;}
   }  
}
function OnLoad()
{
   $method = $_GET['method'];
   if($method == 'SignIn')
   {
      SignIn();
   }   
   else if ($method == 'SocialSignIn')
   {
      SocialSignIn();
   }
   else if($method == 'SignOut')
   {
      SignOut();
   }
   else if($method == 'UserSignUp')
   {
      UserSignUp();
   }
   else if($method == 'AdvisorSignUp')
   {
      AdvisorSignUp();
   } 
   else if($method == 'ChangePassword')
   {
      ChangePassword();
   } 
   else if($method == 'UpdateUserProfile')
   {
      UpdateUserProfile();
   }
   else if($method == 'UpdateAdvisorProfile')
   {
      UpdateAdvisorProfile();
   }    
   else if($method == 'SendMessage')
   {
      SendMessage();
   }
   else if($method == 'GetMessages')
   {
      GetMessages();
   }
   else if($method == 'SearchAdvisors')
   {
      SearchAdvisors();
   }
   else if($method == 'SearchUsers')
   {
      SearchUsers();
   }
   else if($method == 'AddReviews')
   {
      AddReviews();
   }
   else if($method == 'MarkAsFavorites')
   {
      MarkAsFavorites();
   }
   else if($method == 'MarkAsUnFavorites')
   {
      MarkAsUnFavorites();
   }
   else if($method == 'GetFavorites')
   {
      GetFavorites();
   }
   else if($method == 'ApproveFavoriteRequest')
   {
      ApproveFavoriteRequest();
   }
   else if ($method == 'ForgetPassword')
   {
      ForgetPassword();
   }
   else if ($method == 'GetReviews')
   {
      GetReviews();
   } 
   else if ($method == 'GetUserDetail')
   {
      GetUserDetail();
   }
   else if ($method == 'GetAdvisorDetail')
   {
      GetAdvisorDetail();
   } 
   else if($method == 'UpdateAdvisorStatus')
   {
      UpdateAdvisorStatus();
   }
   else if($method == 'GetPurchaseStatus')
   {
      GetPurchaseStatus();
   }
   else if($method == 'MarkAsBlocked')
   {
      MarkAsBlocked();
   }
   else if($method == 'GetBlockedUsers')
   {
      GetBlockedUsers();
   }
   else if($method == 'iospushnotificationtest')
   {
      iospushnotificationtest();
   }
   else if($method == 'GetChatHistory')
   {
      GetChatHistory();
   }
   else if($method == 'ContactUs')
   {
      ContactUs();
   }
   else if($method == 'UpdatePhoto')
   {
      UpdatePhoto();
   }
   else if($method == 'SearchUsersTest')
   {
      SearchUsersTest();
   }
   else if($method == 'SearchAdvisorsTest')
   {
      SearchAdvisorsTest();
   }
   else if($method == 'sendnotification')
   {
      sendnotification(40);
   }
   else if($method == 'GetAppVersion')
   {
	GetAppVersion();
   }
   else if($method == 'GetAllChatHistory')
   {
	GetAllChatHistory();
   }
   else if($method == 'DeleteChat')
   {
	DeleteChat();
   }
else if($method == 'SignInTest')
   {
	SignInTest();
   }
} 
//For Sign In
function SignIn()
{
    $obj=new funcs_code();
    $obj->connection();			
    $email = '';
    $pwd  = '';
    $usertype = "";
    $devicetoken = "";
    $devicetype = "";
    $lat = 0;
    $lng = 0;
    $output = '';
    if(isset($_POST['email']))
    {
       $email = $_POST['email'];
       $email = mysql_real_escape_string($email);	
    }
    if(isset($_POST['pwd']))
    {
       $pwd= $_POST['pwd'];    
       $pwd = md5(mysql_real_escape_string($pwd));
    }
    if(isset($_POST['usertype']))
    {
        $usertype = $_POST['usertype'];
    }
    if(isset($_POST['devicetoken']))
    {
        $devicetoken = $_POST['devicetoken'];
    }
    if(isset($_POST['devicetype']))
    {
        $devicetype= $_POST['devicetype'];
    }	
    if(isset($_POST['lat']))
    {
        $lat = $_POST['lat'];
    }
    if(isset($_POST['lng']))
    {
        $lng = $_POST['lng'];
    }
    if($usertype == "advisor")
    {
       $q = "SELECT * FROM advisors WHERE email = '$email' AND password = '$pwd'";

       $res=mysql_query($q);
       if(mysql_num_rows($res)>0)
       {
          $row=mysql_fetch_assoc($res);	
          $id = $row["advisorid"];
//GetAdvisorPurchaseStatus($id);
          $q = "UPDATE advisors SET online = '1', devicetoken = '$devicetoken', devicetype = '$devicetype', lat = $lat, lng = $lng  WHERE advisorid = $id";        
          mysql_query($q);       
          $row["usertype"] = $usertype;
          $row["online"] = "1";
          $output = $row;
       }		
       else
       {
          $output = "0";
       }

    }
    else if($usertype == "user")
    {

       $q = "SELECT * FROM users WHERE email = '$email' AND password = '$pwd' AND status = 10";
       $res=mysql_query($q);
       $row=mysql_fetch_assoc($res);

       if(mysql_num_rows($res)>0)
       {	
          $id = $row["userid"];
          $q = "UPDATE users SET online = '1', devicetoken = '$devicetoken', devicetype = '$devicetype', lat = $lat, lng = $lng 
WHERE userid = $id";        
          mysql_query($q);       
          $row["usertype"] = $usertype;
          $row["online"] = "1";
          $output = $row;
       }		
       else
       {
          $output = "0";
       }
    }				
   echo json_encode($output); 
}

//For User Sign Up
function UserSignUp()
{
    $obj=new funcs_code();
    $obj->connection();	
    $output = "";				
    $fname = "";   
    $lname = "";	
    $email = "";
    $pwd = ""; 
    $photo = "";
    $imagepath = "";
    $location = "";
    $age = 0;
    $gender = "";
    $occupation = "";
    $university = "";
    $phone = "";
    $amount = 0;
    $lat = 0;
    $lng = 0;
    $devicetype = "";
    $devicetoken = "";                  
    $date = date('YmdHis');        
    if(isset($_POST["fname"]))
    {
        $fname = $_POST["fname"];
        $fname = mysql_escape_string($fname);
    } 
    if(isset($_POST["lname"]))
    {
        $lname = $_POST["lname"];
        $lname = mysql_escape_string($lname);
    }	
    if(isset($_POST["email"]))
    {
        $email = $_POST["email"];
        $email = mysql_escape_string($email);
    }
    if(isset($_POST["pwd"]))
    {
        $pwd = $_POST["pwd"];
        $pwd = mysql_escape_string(md5($pwd));
    }
    if(isset($_POST["location"]))
    {
        $location = $_POST["location"];
    }
    if(isset($_POST["age"]))
    {
        $age = $_POST["age"];
    }
    if(isset($_POST["gender"]))
    {
        $gender = $_POST["gender"];
    }
    if(isset($_POST["occupation"]))
    {
        $occupation = $_POST["occupation"];
    }
    if(isset($_POST["university"]))
    {
        $university = $_POST["university"];
    }
    if(isset($_POST["phone"]))
    {
        $phone= $_POST["phone"];
    }
    if(isset($_POST["amount"]))
    {
        $amount = $_POST["amount"];
    }
    if(isset($_POST["lat"]))
    {
        $lat = $_POST["lat"];
    }
    if(isset($_POST["lng"]))
    {
        $lng = $_POST["lng"];
    }
    if(isset($_POST['photo']))
    {
        $photo = $_POST['photo'];
    }
    if(isset($_POST['devicetoken']))
    {
        $devicetoken = $_POST['devicetoken'];
    }
    if(isset($_POST['devicetype']))
    {
        $devicetype= $_POST['devicetype'];
    }
    if($imagepath == "")
    {
       if ($photo != "")
       {
           $img = imagecreatefromstring(base64_decode($photo));
	   if($img != false)
	   {
	      $dt = date('YmdHis'); 
 	      $rn = mt_rand();
              $imagepath="upload/photos/user/".$dt.$rn.".jpg";
              $path = '../../'.$imagepath;	      
	      imagejpeg($img, $path);
           }          
       }
     }	
    
    $q = "SELECT * FROM users WHERE email = '$email'";
    $res=mysql_query($q);	
    $row=mysql_fetch_row($res);	
	
    if(mysql_num_rows($res)==0)
    {	
        $q = "INSERT INTO users VALUES ('','$fname','$lname','$email','','','$pwd','$imagepath','$location',$age,'$gender','$occupation','$university','$phone',$amount,$lat,$lng,
'$devicetoken','$devicetype',0,'{$date}',10, '')";

        if(mysql_query($q))
        {
            $id = mysql_insert_id();
            $q = "UPDATE users SET online = '1' WHERE userid = $id";        
            mysql_query($q);
            
            $q = "SELECT * FROM users WHERE userid = $id";
    $resdetail=mysql_query($q);	
    $rowdetail=mysql_fetch_assoc($resdetail);
    
            $rowdetail['usertype'] = "user";
            $output = $rowdetail;
        }
        else
        {
            $output = "0";		
        }
    }
    else
    {
       $output = "-1"; // Email Already Registered		
    }

    echo json_encode($output); 
}

//For Advisor Sign Up
function AdvisorSignUp()
{
    $obj=new funcs_code();
    $obj->connection();	
    $output = "";				
    $fname = "";
    $lname = "";    
    $email = "";
    $pwd = ""; 
    $photo = "";
    $imagepath = "";
    $location = "";
    $age = 0;
    $gender = "";
    $firm = "";
    $title = "";
    $university = "";
    $professionalbio = "";
    $phone = "";
    $website = "";
    $currentoffice = "";
    $lat = 0;
    $lng = 0;
    $keywords = "";
    $devicetype = "";
    $devicetoken = "";                  
    $date = date('YmdHis');        
    if(isset($_POST["fname"]))
    {
        $fname = $_POST["fname"];
        $fname = mysql_escape_string($fname);
    }  
    if(isset($_POST["lname"]))
    {
        $lname = $_POST["lname"];
        $lname = mysql_escape_string($lname);
    }	
    if(isset($_POST["email"]))
    {
        $email = $_POST["email"];
        $email = mysql_escape_string($email);
    }
    if(isset($_POST["pwd"]))
    {
        $pwd = $_POST["pwd"];
        $pwd = mysql_escape_string(md5($pwd));
    }
    if(isset($_POST['photo']))
    {
        $photo = $_POST['photo'];
    }
    if(isset($_POST["location"]))
    {
        $location = $_POST["location"];
    }
    if(isset($_POST["age"]))
    {
        $age = $_POST["age"];
    }
    if(isset($_POST["gender"]))
    {
        $gender = $_POST["gender"];
    }
    if(isset($_POST["firm"]))
    {
        $firm = $_POST["firm"];
    }
    if(isset($_POST["title"]))
    {
        $title = $_POST["title"];
    }
    if(isset($_POST["university"]))
    {
        $university = $_POST["university"];
    }
    if(isset($_POST["professionalbio"]))
    {
        $professionalbio = $_POST["professionalbio"];
    }
    if(isset($_POST["phone"]))
    {
        $phone= $_POST["phone"];
    } 
    if(isset($_POST["website"]))
    {
        $website= $_POST["website"];
    }
    if(isset($_POST["currentoffice"]))
    {
        $currentoffice = $_POST["currentoffice"];
    }   
    if(isset($_POST["lat"]))
    {
        $lat = $_POST["lat"];
    }
    if(isset($_POST["lng"]))
    {
        $lng = $_POST["lng"];
    }
    if(isset($_POST["keywords"]))
    {
        $keywords = $_POST["keywords"];
    }
    if(isset($_POST['devicetoken']))
    {
        $devicetoken = $_POST['devicetoken'];
    }
    if(isset($_POST['devicetype']))
    {
        $devicetype= $_POST['devicetype'];
    }
    if($imagepath == "")
    {
       if ($photo != "")
       {
           $img = imagecreatefromstring(base64_decode($photo));
		   if($img != false)
		   {
			  $dt = date('YmdHis'); 
			  $rn = mt_rand();
                          $imagepath ="upload/photos/advisor/".$dt.$rn.".jpg";
                          $path = '../../'.$imagepath;			  
			  imagejpeg($img, $path);
		   }          
	   }
     }	
    
    $q = "SELECT * FROM advisors WHERE email = '$email'";
    $res=mysql_query($q);	
    $row=mysql_fetch_row($res);	
	
    if(mysql_num_rows($res)==0)
    {	
        $q = "INSERT INTO advisors VALUES ('','$fname','$lname','$email','','','$pwd','$imagepath','$location',$age,'$gender','$firm','$title','$university','$professionalbio','$phone',
'$website','$currentoffice',$lat,$lng,'$keywords','$devicetoken','$devicetype',0,'{$date}',10,0,0,'{$date}','')";
        if(mysql_query($q))
        {
            $id = mysql_insert_id();
            $q = "UPDATE advisors SET online = '1' WHERE advisorid = $id";        
            mysql_query($q);
            
            
            $q = "SELECT * FROM advisors WHERE advisorid = $id";
    $resdetail=mysql_query($q);	
    $rowdetail=mysql_fetch_assoc($resdetail);
    
            $rowdetail['usertype'] = "advisor";
            $rowdetail['status'] = 10;
            $output = $rowdetail;
        }
        else         
        {
            $output = "0";		
        }
    }
    else
    {
       $output = "-1"; //Email Already Registered		
    }

    echo json_encode($output); 
}

function SocialSignIn()
{
    $obj=new funcs_code();
   	$obj->connection();	
	$output = "";
	$date = date('YmdHis');
	$fname = "";
	$lname = "";
	$email = "";
	$pwd = "";	
        $imagepath = "";
        $fbid = "";
        $linkedinid = "";
	$devicetoken = "";
	$devicetype = "";
	$usertype = "";
	$lat = 0;
        $lng = 0;
	$age = 0;
	$location = "";
	$gender = "";
	$socialpageurl = "";
	$firm = "";
	if(isset($_POST["fname"]))
	{
	   $fname = $_POST["fname"];	
	}
	if(isset($_POST["lname"]))
	{
	   $lname = $_POST["lname"];	
	}
	if(isset($_POST["email"]))
	{
	   $email = $_POST["email"];
           $email = mysql_escape_string($email);	   
	}
	if(isset($_POST["photopath"]))
	{
	   $imagepath = $_POST["photopath"];	
	}
   if(isset($_POST["fbid"]))
   {
       $fbid = $_POST["fbid"];
       $pwd = mysql_escape_string(md5($fbid));	   
    }
    if(isset($_POST["linkedinid"]))
    {
       $linkedinid = $_POST["linkedinid"];
       $pwd = mysql_escape_string(md5($linkedinid));	   
    }
    if(isset($_POST['devicetoken']))
    {
        $devicetoken = $_POST['devicetoken'];
    }
    if(isset($_POST['devicetype']))
    {
        $devicetype= $_POST['devicetype'];
    }	
    if(isset($_POST["usertype"]))
    {
	   $usertype = $_POST["usertype"];	
    }
    if(isset($_POST["lat"]))
    {
        $lat = $_POST["lat"];
    }
    if(isset($_POST["lng"]))
    {
        $lng = $_POST["lng"];
    }
	if(isset($_POST["age"]))
    {
        $age = $_POST["age"];
    }
	if(isset($_POST["location"]))
    {
        $location = $_POST["location"];
    }
	if(isset($_POST["gender"]))
    {
        $gender = $_POST["gender"];
    }
	if(isset($_POST["socialpageurl"]))
    {
        $socialpageurl = $_POST["socialpageurl"];
    }
	if(isset($_POST["firm"]))
    {
        $firm = $_POST["firm"];
    }
    if($usertype == "user")
	{
		if($fbid != "")
		{
			$q = "SELECT * FROM users WHERE email = '$email' AND fbid = '$fbid'";
		}
		else if($linkedinid != "")
		{
			$q = "SELECT * FROM users WHERE email = '$email' AND linkedinid = '$linkedinid'";
		}
		$res=mysql_query($q);	
		$row=mysql_fetch_row($res);	
		if(mysql_num_rows($res)==0)
		{	
			$q = "INSERT INTO users VALUES ('','$fname','$lname','$email','$fbid','$linkedinid','$pwd','$imagepath','$location',$age,'$gender','$firm','','',0,$lat,$lng,
'$devicetoken','$devicetype',0,'{$date}',10,'$socialpageurl')";
			if(mysql_query($q))
			{
				$contents = array();
				$id = mysql_insert_id();
				$contents['id'] = mysql_insert_id();
				$q = "UPDATE users SET online = '1' WHERE userid = $id";        
                                mysql_query($q);
				$contents['fname'] = $fname; 
		 		$contents['lname'] = $lname;
				$contents['email'] = $email;
                                $contents['photopath'] = $imagepath;
				$contents['location'] = $location;
				$contents['age'] = $age;
				$contents['gender'] = $gender;
				$contents['occupation'] = $firm;
				$contents['university'] = '';
				$contents['phone'] = '';
				$contents['investableamout'] = 0;				
				$contents['usertype'] = "user";
				$contents['status'] = 10;
				$output = $contents;
			}
			else
			{
				$output = "0";		
			}
		}
		else
		{
			$userid = $row["0"];
			$q = "UPDATE users SET online = '1', devicetoken = '$devicetoken', devicetype = '$devicetype', 
			      lat = $lat, lng = $lng, socialpageurl = '$socialpageurl', occupation = '$firm', location = '$location', photopath = '$imagepath', age = $age WHERE userid = $userid";        
                        mysql_query($q);

			$q = "SELECT * FROM users WHERE userid = $userid";
			$resdetail=mysql_query($q);	
			$rowdetail=mysql_fetch_row($resdetail);
			$contents = array(); 
			$contents['id'] = $rowdetail["0"];
			$contents['fname'] = $rowdetail["1"];
			$contents['lname'] = $rowdetail["2"];
			$contents['email'] = $rowdetail["3"];
			$contents['photopath'] = $rowdetail["7"];
			$contents['location'] = $rowdetail["8"];
			$contents['age'] = $rowdetail["9"];
			$contents['gender'] = $rowdetail["10"];
			$contents['occupation'] = $rowdetail["11"];
			$contents['university'] = $rowdetail["12"];
			$contents['phone'] = $rowdetail["13"];
			$contents['investableamout'] = $rowdetail["14"];
            $contents['usertype'] = "user";
			$contents['status'] = $rowdetail["21"];				
			$output = $contents;			
		}
	}
	else if($usertype == "advisor")
	{
		if($fbid != "")
		{
			$q = "SELECT * FROM advisors WHERE email = '$email' AND fbid = '$fbid'";
		}else if($linkedinid != "")
		{
			$q = "SELECT * FROM advisors WHERE email = '$email' AND linkedinid = '$linkedinid'";
		}
		$res=mysql_query($q);	
		$row=mysql_fetch_row($res);	
		if(mysql_num_rows($res)==0)
		{	
			$q = "INSERT INTO advisors VALUES ('','$fname','$lname','$email','$fbid','$linkedinid','$pwd','$imagepath','$location',$age,'$gender','$firm','','','','',
'','',$lat,$lng,'','$devicetoken','$devicetype',0,'{$date}',10,0,0,'{$date}','$socialpageurl')";
			if(mysql_query($q))
			{
				$contents = array(); 
				$id = mysql_insert_id();
				$contents['id'] = mysql_insert_id();
				$q = "UPDATE advisors SET online = '1' WHERE advisorid = $id";        
				mysql_query($q);
				$contents['fname'] = $fname; 
                                $contents['lname'] = $lname;
				$contents['email'] = $email;
                                $contents['photopath'] = $imagepath;
                                $contents['location'] = $location;
				$contents['age'] = $age;
                                $contents['gender'] = $gender;                                
				$contents['firm'] = $firm;
				$contents['registeredtitle'] = '';
				$contents['university'] = '';
				$contents['professionalbio'] = '';
				$contents['phone'] = '';
				$contents['website'] = '';
				$contents['currentoffice'] = '';
				$contents['usertype'] = "advisor";
				$contents['status'] = 10;
				$output = $contents;
			}
			else
			{
				$output = "0";		
			}
		}
		else
		{	
			$advisorid = $row["0"];
			//GetAdvisorPurchaseStatus($advisorid);
			$q = "UPDATE advisors SET online = '1', devicetoken = '$devicetoken', devicetype = '$devicetype', 
			      lat=$lat, lng = $lng, socialpageurl = '$socialpageurl', firm = '$firm', location = '$location',photopath = '$imagepath', age = $age WHERE advisorid = $advisorid";        
            mysql_query($q);
			$q = "SELECT * FROM advisors WHERE advisorid = $advisorid";
			$resdetail=mysql_query($q);	
			$rowdetail=mysql_fetch_row($resdetail);
			$contents = array(); 
			$contents['id'] = $rowdetail["0"];
			$contents['fname'] = $rowdetail["1"];
			$contents['lname'] = $rowdetail["2"];
			$contents['email'] = $rowdetail["3"];
            $contents['photopath'] = $rowdetail["7"];
			$contents['location'] = $rowdetail["8"];
			$contents['age'] = $rowdetail["9"];
			$contents['gender'] = $rowdetail["10"];
			$contents['firm'] = $rowdetail["11"];
            $contents['registeredtitle'] = $rowdetail["12"];
			$contents['university'] = $rowdetail["13"];
			$contents['professionalbio'] = $rowdetail["14"];
			$contents['phone'] = $rowdetail["15"];
			$contents['website'] = $rowdetail["16"];
			$contents['currentoffice'] = $rowdetail["17"];
            $contents['usertype'] = "advisor";
			$contents['status'] = $rowdetail["25"];				
			$output = $contents;			
		}	
	}
	echo json_encode($output);	
}

//To update password
function ChangePassword()
{
    $obj=new funcs_code();
    $obj->connection();	
    $output = "0";
    $id = 0;				
    $newpassword = "";
    $oldpassword = "";
    $usertype = "";  
	
    if(isset($_POST["id"]))
    {
       $id = $_POST["id"];
    }
    if(isset($_POST["oldpassword"]))
    {
	$oldpassword = $_POST["oldpassword"];
        $oldpassword =  mysql_escape_string(md5($oldpassword));
    }
    if(isset($_POST["newpassword"]))
    {
       $newpassword = $_POST["newpassword"];
       $newpassword = mysql_escape_string(md5($newpassword));
    }
    if(isset($_POST["usertype"]))
    {
       $usertype= $_POST["usertype"];
    }

    if($usertype == "user")
    {
       $sql="SELECT * FROM users WHERE password = '$oldpassword' AND userid = $id";
       $res=mysql_query($sql);
       $result=mysql_fetch_row($res);
       if(mysql_num_rows($res) > 0)
       {
           $pass=$result["6"];
           if($pass == $oldpassword)
           {
              $q = "UPDATE users SET password = '$newpassword' WHERE userid = $id";
              if(mysql_query($q))
              {
	         $output = "1";
              }	
           }           
        }
    }
    else if($usertype == "advisor")
    {
       $sql="SELECT * FROM advisors WHERE password = '$oldpassword' AND advisorid = $id";
       $res=mysql_query($sql);
       $result=mysql_fetch_row($res);
       if(mysql_num_rows($res) > 0)
       {
           $pass=$result["6"];
           if($pass == $oldpassword)
           {
              $q = "UPDATE advisors SET password = '$newpassword' WHERE advisorid = $id";
              if(mysql_query($q))
              {
	         $output = "1";
              }	
           }           
        }
    }
    echo json_encode($output); 
}

function UpdateUserProfile()
{
    $obj=new funcs_code();
    $obj->connection();	
    $output = "";
    $userid = 0;	
    $fname = "";
    $lname = "";    
    $email = "";
    $pwd = ""; 
    $photo = "";
    $imagepath = "";
    $location = "";
    $age = 0;
    $gender = "";
    $occupation = "";
    $university = "";
    $phone = "";
    $amount = 0;
    $lat = 0;
    $lng = 0;	
    $devicetype = "iphone";
    $devicetoken = "";                  
    $date = date('YmdHis'); 
    if(isset($_POST["userid"]))
    {
        $userid = $_POST["userid"];
    }	
    if(isset($_POST["fname"]))
    {
        $fname = $_POST["fname"];
        $fname = mysql_escape_string($fname);
    } 
    if(isset($_POST["lname"]))
    {
        $lname = $_POST["lname"];
        $lname = mysql_escape_string($lname);
    }	
    if(isset($_POST["email"]))
    {
        $email = $_POST["email"];
        $email = mysql_escape_string($email);
    }    
    if(isset($_POST["location"]))
    {
        $location = $_POST["location"];
    }
    if(isset($_POST["age"]))
    {
        $age = $_POST["age"];
    }
    if(isset($_POST["gender"]))
    {
        $gender = $_POST["gender"];
    }
    if(isset($_POST["occupation"]))
    {
        $occupation = $_POST["occupation"];
    }
    if(isset($_POST["university"]))
    {
        $university = $_POST["university"];
    }
    if(isset($_POST["phone"]))
    {
        $phone= $_POST["phone"];
    }
    if(isset($_POST["amount"]))
    {
        $amount = $_POST["amount"];
    }
    if(isset($_POST["lat"]))
    {
        $lat = $_POST["lat"];
    }
    if(isset($_POST["lng"]))
    {
        $lng = $_POST["lng"];
    }
    if(isset($_POST['photo']))
    {
        $photo = $_POST['photo'];
    }    
	if($imagepath == "")
	{
		if ($photo != "")
		{
			$img = imagecreatefromstring(base64_decode($photo));
			if($img != false)
			{
				$dt = date('YmdHis'); 
				$rn = mt_rand();
$imagepath ="upload/photos/user/".$dt.$rn.".jpg";
              $path = '../../'.$imagepath ;
				
				imagejpeg($img, $path);
				$q = "UPDATE users SET photopath = '$imagepath' WHERE userid = $userid";			
				mysql_query($q);
			}
		}
	}	
		
	$q = "SELECT * FROM users WHERE email = '$email' AND userid <> $userid";
	$res=mysql_query($q);
	$row=mysql_fetch_row($res);	
	if(mysql_num_rows($res)==0)
	{	
	   $q = "UPDATE users SET fname = '$fname', lname = '$lname',email = '$email', age = $age, location = '$location', 
                gender = '$gender', occupation = '$occupation',university = '$university', phone = '$phone', 
                investableamout	= $amount, lat = $lat, lng = $lng, status = 10 WHERE userid = $userid";

		if(mysql_query($q))
		{
		   $output = "1";	
		}
		else 
		{
		   $output = "0";		
		}
	}
	else
	{
	   $output = "-1"; // Email already registered.
	}
	echo json_encode($output);
}

function UpdateAdvisorProfile()
{
    $obj=new funcs_code();
    $obj->connection();	
    $output = "";
    $advisorid = 0; 	
    $fname = "";
    $lname = "";    
    $email = "";
    $photo = "";
    $imagepath = "";
    $location = "";
    $age = 0;
    $gender = "";
    $firm = "";
    $title = "";
    $university = "";
    $professionalbio = "";
    $phone = "";
    $website = "";
    $currentoffice = "";
    $lat = 0;
    $lng = 0;
    $keywords = "";
    $devicetype = "iphone";
    $devicetoken = "";                  
    $date = date('YmdHis'); 
	if(isset($_POST["advisorid"]))
    {
        $advisorid = $_POST["advisorid"];
    } 
    if(isset($_POST["fname"]))
    {
        $fname = $_POST["fname"];
        $fname = mysql_escape_string($fname);
    }  
    if(isset($_POST["lname"]))
    {
        $lname = $_POST["lname"];
        $lname = mysql_escape_string($lname);
    }	
    if(isset($_POST["email"]))
    {
        $email = $_POST["email"];
        $email = mysql_escape_string($email);
    }   
    if(isset($_POST['photo']))
    {
        $photo = $_POST['photo'];
    }
    if(isset($_POST["location"]))
    {
        $location = $_POST["location"];
    }
    if(isset($_POST["age"]))
    {
        $age = $_POST["age"];
    }
    if(isset($_POST["gender"]))
    {
        $gender = $_POST["gender"];
    }
    if(isset($_POST["firm"]))
    {
        $firm = $_POST["firm"];
    }
    if(isset($_POST["title"]))
    {
        $title = $_POST["title"];
    }
    if(isset($_POST["university"]))
    {
        $university = $_POST["university"];
    }
    if(isset($_POST["professionalbio"]))
    {
        $professionalbio = $_POST["professionalbio"];
    }
    if(isset($_POST["phone"]))
    {
        $phone= $_POST["phone"];
    } 
    if(isset($_POST["website"]))
    {
        $website= $_POST["website"];
    }
    if(isset($_POST["currentoffice"]))
    {
        $currentoffice = $_POST["currentoffice"];
    }   
    if(isset($_POST["lat"]))
    {
        $lat = $_POST["lat"];
    }
    if(isset($_POST["lng"]))
    {
        $lng = $_POST["lng"];
    }
    if(isset($_POST["keywords"]))
    {
        $keywords = $_POST["keywords"];
    }
     
	if($imagepath == "")
	{
		if ($photo != "")
		{
			$img = imagecreatefromstring(base64_decode($photo));
			if($img != false)
			{
				$dt = date('YmdHis'); 
				$rn = mt_rand();
$imagepath ="upload/photos/advisor/".$dt.$rn.".jpg";
              $path = '../../'.$imagepath;
				
				imagejpeg($img, $path);
				$q = "UPDATE advisors SET photopath = '$imagepath' WHERE advisorid = $advisorid";			
				mysql_query($q);
			}
		}
	}	
		
	$q = "SELECT * FROM advisors WHERE email = '$email' AND advisorid <> $advisorid";
	$res=mysql_query($q);
	$row=mysql_fetch_row($res);	
	if(mysql_num_rows($res)==0)
	{	
		$q = "UPDATE advisors SET fname = '$fname',lname = '$lname', email = '$email', age = $age, location = '$location', gender = '$gender', firm = '$firm', registeredtitle ='$title', university = '$university', professionalbio = '$professionalbio', 
phone = '$phone', website = '$website', currentoffice = '$currentoffice', lat = $lat,lng = $lng, searchkeywords = '$keywords'
WHERE advisorid = $advisorid";	
			
		if(mysql_query($q))
		{
		   $output = "1";	
		}
		else
		{
		   $output = 0;		
		}
	}
	else
	{
	   $output = "-1"; // Email already registered.
	}
	echo json_encode($output);
}

//For Sign Out
function SignOut()
{
    $obj=new funcs_code();
    $obj->connection();	
    $output = "0";
    $id = 0;
    $usertype = ""; 
    if(isset($_POST["id"]))
    {
        $id = $_POST["id"];
    }
    if(isset($_POST["usertype"]))
    {
        $usertype = $_POST["usertype"];
    }
    if($usertype == "user")
    {
       $q = "UPDATE users SET online = '0' WHERE userid = $id";
       mysql_query($q);
       $output = "1";
    }
    else if($usertype == "advisor")
    {
       $q = "UPDATE advisors SET online = '0' WHERE advisorid = $id";
       mysql_query($q);
       $output = "1";
    }
    
    echo json_encode($output);

}

//To send chat message
function SendMessage()
{
    $obj=new funcs_code();
    $obj->connection();	
    $output = "";				
    $message = "";
    $advisorid = 0;
    $userid = 0;
	$usertype = "";
    $date = "";        
    if(isset($_POST["advisorid"]))
    {
        $advisorid= $_POST["advisorid"];
    }
    if(isset($_POST["userid"]))
    {
        $userid = $_POST["userid"];
    }
    if(isset($_POST["usertype"]))
    {
        $usertype = $_POST["usertype"];
    }
    if(isset($_POST["message"]))
    {
        $message = $_POST["message"];
    }
    if(isset($_POST["date"]))
    {
        $date = $_POST["date"];
    }
    $date = date('YmdHis'); 	
    $q = "INSERT INTO messages VALUES ('','$advisorid','$userid','$message','$usertype','{$date}')";
    if(mysql_query($q))
    {
	   if($usertype == "user")
	   {
			$q = "SELECT * FROM users WHERE userid = $userid";
			$result = mysql_query($q);					
			if(mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_assoc($result);
				$fname = $row["fname"];
				$lname = $row["lname"];
			}
	   
			$q = "SELECT * FROM advisors WHERE advisorid = $advisorid";
			$res1 = mysql_query($q);					
			if(mysql_num_rows($res1) > 0)
			{
				$row1 = mysql_fetch_assoc($res1);	
				$devicetoken = $row1["devicetoken"];
				$devicetype = $row1["devicetype"];				
				$name = $fname." ".$lname;
				$message = $name." says: ". $message;
				if(strtolower($devicetype) == "ios")
				{
					iospushnotification($devicetoken, $message, $userid, $usertype,'message',0);
				}
				else if($devicetype == "android")
				{
					androidpushnotification($devicetoken, $message);
				}
			}
		}
		else if($usertype == "advisor")
		{
			$q = "SELECT * FROM advisors WHERE advisorid = $advisorid";
			$result = mysql_query($q);					
			if(mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_assoc($result);
				$fname = $row["fname"];
				$lname = $row["lname"];
			}
			$q = "SELECT * FROM users WHERE userid = $userid";
			$res1 = mysql_query($q);					
			if(mysql_num_rows($res1) > 0)
			{
				$row1 = mysql_fetch_assoc($res1);	
				$devicetoken = $row1["devicetoken"];
				$devicetype = $row1["devicetype"];				
				$name = $fname." ".$lname;
				$message = $name." says: ". $message;
				if(strtolower($devicetype) == "ios")
				{
					iospushnotification($devicetoken, $message, $userid, $usertype,'message',0);
				}
				else if($devicetype == "android")
				{
					androidpushnotification($devicetoken, $message);
				}
			}
		}		
       $output = "1";
    }
    else
    {
       $output = "0";		
    }    
    echo json_encode($output);
}

//To get specific chat by an user
function GetMessages()
{
	$obj=new funcs_code();
	$obj->connection();
	$advisorid= 0;
	$userid = 0;
	if(isset($_GET["advisorid"]))
	{
	  $advisorid = $_GET["advisorid"];
	}
	if(isset($_GET["userid"]))
	{
	  $userid = $_GET["userid"];
	} 
        $q = "SELECT 
			advisors.fname,
			advisors.lname,
			advisors.advisorid as advisorid,
			advisors.photopath as advisorphotopath,
			advisors.online as advisoronlinestatus,
			users.fname,
			users.lname,
			users.userid AS userid,
			users.photopath as usersphotopath,
			users.online as useronlinestatus,
			messages.message,
			messages.sender,
			messages.date
		  FROM messages 
		  INNER JOIN advisors ON advisors.advisorid = messages.advisorid 
		  INNER JOIN users ON users.userid = messages.userid
		  WHERE (messages.advisorid  = $advisorid AND messages.userid = $userid)
		  AND DATE_FORMAT( messages.date, '%Y-%m-%d' ) >= DATE_FORMAT( DATE_ADD( NOW( ) , INTERVAL -7 DAY ) , '%Y-%m-%d') ";

	      $res=mysql_query($q);		
	      if(mysql_num_rows($res) > 0)
	      {
	        $messages = array();
	        while($message = mysql_fetch_assoc($res)) {
	          $messages[] = array('message'=>$message);
	        }
	        header('Content-type: application/json');
	        echo json_encode(array('messages'=>$messages));
	 }		
}

function SearchAdvisors()
{
		$obj=new funcs_code();
   		$obj->connection();		
		$lat = 0;
		$lng = 0;
		$keywords = "";
		$userid = 0;
		$name = "";
		$male = "";
		$female ="";
		$minage = 0;
		$maxage = 0;
		$lat1 = 0;
		$lat2 = 0;
		$lng1 = 0;
		$lng2 = 0;
		$milesDistance = 1000;
		$pageid = 0;
                if(isset($_GET["pageid"]))
		{   
		   $pageid = $_GET["pageid"];
		}
		if(isset($_GET["lat"]))
		{   
		   $lat = $_GET["lat"];
		}
		if(isset($_GET["lng"]))
		{   
		   $lng = $_GET["lng"];
		}
		if(isset($_GET["keywords"]))
		{   
		   $keywords = $_GET["keywords"];
		}
		if(isset($_GET["userid"]))
		{   
		   $userid = $_GET["userid"];
		}
		if(isset($_GET["name"]))
		{   
		   $name = $_GET["name"];
		}
		if(isset($_GET["miles"]))
		{   
		   $milesDistance = $_GET["miles"];
		}
		if(isset($_GET["male"]))
		{   
		   $male = $_GET["male"];
		}
		if(isset($_GET["female"]))
		{                 
		   $female = $_GET["female"];
		}
		if(isset($_GET["minage"]))
		{   
		   $minage = $_GET["minage"];
		}
		if(isset($_GET["maxage"]))
		{   
		   $maxage = $_GET["maxage"];
		}
		$milesPerDegree = 0.868976242 / 60.0 * 1.2;	
		$degrees = $milesPerDegree * $milesDistance;
		$lng1 = $lng - $degrees;
		$lng2 = $lng + $degrees;
		$lat1 = $lat - $degrees;
		$lat2 = $lat + $degrees;
		
		$q = "SELECT 
				advisors.advisorid,
				advisors.fname,
				advisors.lname,
				advisors.email,
				advisors.photopath,
				advisors.location,
				advisors.lat,
				advisors.lng,
				advisors.age,
				advisors.gender,
				advisors.online,
				advisors.overallrating,
                                advisors.firm,
                                advisors.registeredtitle,
				advisors.university,
				advisors.professionalbio,
				advisors.phone,
				advisors.website,
				advisors.currentoffice,
				advisors.socialpageurl,
                                'advisor' AS usertype,
				IFNULL(favorites.favoriteid,0) AS favoriteid,
                                IFNULL(favorites.status,0) AS favoritestatus,
                                IFNULL(reviewcounts.reviewCount, 0) As reviewCount			
			FROM
				advisors
                        LEFT OUTER JOIN
                              (SELECT COUNT(*) AS reviewCount, advisorid FROM reviews GROUP BY advisorid) as reviewcounts
                        ON reviewcounts.advisorid = advisors.advisorid
			LEFT OUTER JOIN
				favorites
			ON
				favorites.advisorid = advisors.advisorid AND favorites.userid = $userid
			WHERE advisors.status <> 0 AND advisors.advisorid NOT IN(SELECT blockeduserid FROM blockedusers WHERE senderid = $userid AND usertype = 'user') 
			AND advisors.advisorid NOT IN(SELECT advisorid FROM favorites WHERE userid = $userid)	";
		 
		if($lat > 0 && $lng > 0)
		{
                $sql = "Update users SET lat = $lat,lng = $lng  WHERE userid = $userid";
	        mysql_query($sql);
		    $q = $q."AND ((lat > $lat1 AND lat < $lat2) AND (lng > $lng1 AND lng < $lng2))";
		}
		if($male != "" && $female == "")
		{
			$q = $q." AND gender = '$male'";
		}
		else if($male == "" && $female != "")
		{
			$q = $q." AND gender = '$female'";
		}
		else if($male != "" && $female != "")
		{
			$q = $q." AND (gender = '$male' OR gender = '$female')";
		}
		if($minage > 0 && $maxage > 0)
		{
		   $q = $q." AND age >= $minage AND age <= $maxage";
		}

		if($name != "")
		{
		    $q = $q." AND name LIKE '%$name%'";
		}
		
		if($keywords == "worldwide")
		{  
			$q = "SELECT 
					advisors.advisorid,
					advisors.fname,
					advisors.lname,
					advisors.email,
					advisors.photopath,
					advisors.location,
					advisors.lat,
					advisors.lng,
					advisors.age,
					advisors.gender,
					advisors.online,
					advisors.overallrating,
					advisors.firm,
					advisors.registeredtitle,
					advisors.university,
					advisors.professionalbio,
					advisors.phone,
					advisors.website,
					advisors.currentoffice,
					advisors.socialpageurl,
                                        'advisor' AS usertype,
					IFNULL(favorites.favoriteid,0) AS favoriteid,
                                IFNULL(favorites.status,0) AS favoritestatus,
                                        IFNULL(reviewcounts.reviewCount, 0) As reviewCount			
			FROM
				advisors
                        LEFT OUTER JOIN
                              (SELECT COUNT(*) AS reviewCount, advisorid FROM reviews GROUP BY advisorid) as reviewcounts
                        ON reviewcounts.advisorid = advisors.advisorid
			LEFT OUTER JOIN
				favorites
			ON
				favorites.advisorid = advisors.advisorid AND favorites.userid = $userid
			WHERE advisors.status <> 0 AND advisors.advisorid NOT IN(SELECT blockeduserid FROM blockedusers WHERE senderid = $userid AND usertype = 'user') 
			AND advisors.advisorid NOT IN(SELECT advisorid FROM favorites WHERE userid = $userid)	";
			 
			if($pageid >= 0)
			{
				$q = $q." AND advisors.advisorid > $pageid ";
			}
			
			$q = $q." ORDER BY advisors.advisorid limit 50";			
		}			
		
		$res=mysql_query($q);		
		if(mysql_num_rows($res) > 0) 
		{		
		 	$advisors = array();
			while($advisor = mysql_fetch_assoc($res)) {
				$advisors[] = array('advisor'=>$advisor);
			}
			header('Content-type: application/json');
			echo json_encode(array('advisors'=>$advisors));
		}			
}

function SearchUsers()
{
       //GetPurchaseStatus();
		$obj=new funcs_code();
   		$obj->connection();		
		$lat = 0;
		$lng = 0;
		$keywords = "";
		$userid = 0;
		$name = "";
		$male = "";
		$female ="";
		$minage = 0;
		$maxage = 0;
		$lat1 = 0;
		$lat2 = 0;
		$lng1 = 0;
		$lng2 = 0;
		$milesDistance = 5000;
		$pageid = 0;
        if(isset($_GET["pageid"]))
		{   
		   $pageid = $_GET["pageid"];
		}
		if(isset($_GET["lat"]))
		{   
		   $lat = $_GET["lat"];
		}
		if(isset($_GET["lng"]))
		{   
		   $lng = $_GET["lng"];
		}
		if(isset($_GET["keywords"]))
		{   
		   $keywords = $_GET["keywords"];
		}
		if(isset($_GET["advisorid"]))
		{   
		   $advisorid = $_GET["advisorid"];
		}
		if(isset($_GET["name"]))
		{   
		   $name = $_GET["name"];
		}
		if(isset($_GET["miles"]))
		{   
		   $milesDistance = $_GET["miles"];
		}
		if(isset($_GET["male"]))
		{   
			$male = $_GET["male"];
		}
		if(isset($_GET["female"]))
		{                 
			$female = $_GET["female"];
		}
		if(isset($_GET["minage"]))
		{   
		   $minage = $_GET["minage"];
		}
		if(isset($_GET["maxage"]))
		{   
		   $maxage = $_GET["maxage"];
		}
		$milesPerDegree = 0.868976242 / 60.0 * 1.2;	
		$degrees = $milesPerDegree * $milesDistance;
		$lng1 = $lng - $degrees;
		$lng2 = $lng + $degrees;
		$lat1 = $lat - $degrees;
		$lat2 = $lat + $degrees;

		
		$q = "SELECT 
				users.userid,
				users.fname,
				users.lname,
				users.email,
				users.photopath,
				users.location,
				users.lat,
				users.lng,
				users.age,
				users.gender,
				users.online,
				users.investableamout,
				users.occupation,
				users.university,
				users.phone,
                                'user' AS usertype,                                                     
				users.socialpageurl,
				IFNULL(favorites.favoriteid,0) AS favoriteid,
                         IFNULL(favorites.status,0) AS favoritestatus 			
			FROM
				users
			LEFT OUTER JOIN
				favorites
			ON
				favorites.userid = users.userid AND favorites.advisorid = $advisorid 
			WHERE users.status <> 0 AND users.userid NOT IN(SELECT blockeduserid FROM blockedusers WHERE senderid = $advisorid AND usertype = 'advisor') 
			AND users.userid NOT IN(SELECT userid FROM favorites WHERE advisorid = $advisorid) ";
      
		if($lat > 0 && $lng > 0)
		{
       $sql = "Update advisors SET lat = $lat,lng = $lng  WHERE advisorid = $advisorid";
	        mysql_query($sql);
		    $q = $q."AND ((lat > $lat1 AND lat < $lat2) AND (lng > $lng1 AND lng < $lng2))";
		}
		if($male != "" && $female == "")
		{
			$q = $q." AND gender = '$male'";
		}
		else if($male == "" && $female != "")
		{
			$q = $q." AND gender = '$female'";
		}
		else if($male != "" && $female != "")
		{
			$q = $q." AND (gender = '$male' OR gender = '$female')";
		}
		if($minage > 0 && $maxage > 0)
		{
		   $q = $q." AND age >= $minage AND age <= $maxage";
		}

		if($name != "")
		{
		    $q = $q." AND name LIKE '%$name%'";
		}	
        if($keywords == "worldwide")
		{
			$q = "SELECT 
				users.userid,
				users.fname,
				users.lname,
				users.email,
				users.photopath,
				users.location,
				users.lat,
				users.lng,
				users.age,
				users.gender,
				users.online,
				users.investableamout,
				users.occupation,
				users.university,
				users.phone,
'user' AS usertype,
				users.socialpageurl,
				IFNULL(favorites.favoriteid,0) AS favoriteid,
                                IFNULL(favorites.status,0) AS favoritestatus
			FROM
				users
			LEFT OUTER JOIN
				favorites
			ON
				favorites.userid = users.userid AND favorites.advisorid = $advisorid 
			WHERE users.status <> 0 AND users.userid NOT IN(SELECT blockeduserid FROM blockedusers WHERE senderid = $advisorid AND usertype = 'advisor') 
			AND users.userid NOT IN(SELECT userid FROM favorites WHERE advisorid = $advisorid) ";
			 
		    if($pageid >= 0)
			{
				$q = $q." AND users.userid > $pageid ";
			}
			
			$q = $q." ORDER BY users.userid limit 50";
		}

		$res=mysql_query($q);		
		if(mysql_num_rows($res) > 0) 
		{		
		 	$users= array();
			while($user = mysql_fetch_assoc($res)) {                            
				$users[] = array('user'=>$user);
			}
			header('Content-type: application/json');
			echo json_encode(array('users'=>$users));
		}			
}

function AddReviews()
{
    $obj=new funcs_code();
    $obj->connection();	
    $output = "";
    $advisorid = 0;
    $userid = 0;
    $comment= "";
    $rating = 0;                   
    $date = date('YmdHis');      
    if(isset($_POST["advisorid"]))
    {
        $advisorid= $_POST["advisorid"];
    }
    if(isset($_POST["userid"]))
    {
        $userid = $_POST["userid"];
    }
    if(isset($_POST["comment"]))
    {
        $comment= $_POST["comment"];
    }
    if(isset($_POST["rating"]))
    {
        $rating = $_POST["rating"];
    }
    	
    $q = "INSERT INTO reviews VALUES ('','$advisorid','$userid','$comment',$rating,'{$date}',10)";
    
    if(mysql_query($q))
    {
       $q = "UPDATE advisors SET overallrating = (((overallrating * ratingcount) + $rating)/(ratingcount + 1)), ratingcount = ratingcount + 1 
             WHERE advisorid = $advisorid";
       mysql_query($q);
       $q = "SELECT overallrating FROM advisors WHERE advisorid = $advisorid";
       $res=mysql_query($q);	
       $row=mysql_fetch_row($res);	
       if(mysql_num_rows($res) > 0)
       {
           $output = $row["0"];
       }
    }
    else
    {
       $output = "0";		
    }    
    echo json_encode($output);
}

function MarkAsFavorites()
	{
		$obj=new funcs_code();
   		$obj->connection();
		$output = "0";
		$date = date('YmdHis');	
		$userid = 0;
        $advisorid = 0; 
	    $usertype = "";	
		if(isset($_POST["advisorid"]))
		{
			$advisorid= $_POST["advisorid"];
		}
		if(isset($_POST["userid"]))
		{
			$userid = $_POST["userid"];
		}
		if(isset($_POST["usertype"]))
		{
			$usertype = $_POST["usertype"];
		}
		$q = "SELECT * FROM favorites WHERE userid = $userid AND advisorid = $advisorid";		
		$res = mysql_query($q);				
		if(mysql_num_rows($res) == 0)
		{	
			$q= "INSERT INTO favorites VALUES ('',$userid,$advisorid,'$usertype','{$date}',0)";
			if(mysql_query($q))
			{
				$output = mysql_insert_id();				
				if($usertype == "user")
				{
					$q = "SELECT * FROM users WHERE userid = $userid";
					$result = mysql_query($q);					
					if(mysql_num_rows($result) > 0)
					{
						$row = mysql_fetch_assoc($result);
						$fname = $row["fname"];
						$lname = $row["lname"];
					}
					
					$q = "SELECT * FROM advisors WHERE advisorid = $advisorid";
					$res1 = mysql_query($q);					
					if(mysql_num_rows($res1) > 0)
					{
						$row1 = mysql_fetch_assoc($res1);	
						$devicetoken = $row1["devicetoken"];
						$devicetype = $row1["devicetype"];
						$name = $fname." ".$lname;
						$message = $name." marked you as favorite.";
						if(strtolower($devicetype) == "ios")
						{
							iospushnotification($devicetoken, $message, $userid,"user", 'friendrequest',$output);
						}
						else if($devicetype == "android")
						{							androidpushnotification($devicetoken, $message);
						}
					}
				}
				else if($usertype == "advisor")
				{
					$q = "SELECT * FROM advisors WHERE advisorid = $advisorid";
					$result = mysql_query($q);					
					if(mysql_num_rows($result) > 0)
					{
						$row = mysql_fetch_assoc($result);
						$fname = $row["fname"];
						$lname = $row["lname"];
					}
					
					$q = "SELECT * FROM users WHERE userid = $userid";
					$res1 = mysql_query($q);					
					if(mysql_num_rows($res1) > 0)
					{
						$row1 = mysql_fetch_assoc($res1);	
						$devicetoken = $row1["devicetoken"];
						$devicetype = $row1["devicetype"];
						$name = $fname." ".$lname;
						$message = $name." marked you as favorite.";
						if(strtolower($devicetype) == "ios")
						{
							iospushnotification($devicetoken, $message,$advisorid,"advisor",'friendrequest',$output);
						}
						else if($devicetype == "android")
						{
							androidpushnotification($devicetoken, $message);
						}
					}
				}		
			} 			
		 } 
		 else 
		 {
			$output = "-1";
		 }
		echo json_encode($output); 
}

	function MarkAsUnFavorites()
	{
		$obj=new funcs_code();
   		$obj->connection();
		$output = "";		
		$favoriteid= $_POST["favoriteid"];
		$q= "DELETE FROM favorites WHERE favoriteid = $favoriteid";
 		if(mysql_query($q))
		{			
		   $output = "1";		
		}
		else
		{
		   $output = "0";		
		}
			
		echo json_encode($output); 
	}
	function ApproveFavoriteRequest()
    {
        $obj=new funcs_code();
   		$obj->connection();
		$output = "";
        $date = date('YmdHis');                 		
		$favoriteid = $_POST["favoriteid"];
		$q= "UPDATE favorites SET status = 10, date = '{$date}' WHERE favoriteid = $favoriteid";
 		if(mysql_query($q))
		{			
		    $output = "1";
            sendnotification($favoriteid);	   
		}
		else
		{
		   $output = "0";		
		}
			
		echo json_encode($output); 

    }
	function GetFavorites()
	{
		$obj=new funcs_code();
   		$obj->connection();
		$userid = 0; 
		$advisorid = 0;
		if(isset($_GET["userid"]))
		{
			 $userid = $_GET["userid"];
		}
		if(isset($_GET["advisorid"]))
		{
			 $advisorid = $_GET["advisorid"];
		}

		$favorites = array();
		if($userid > 0)
		{				
		   $q = "SELECT 
				 advisors.advisorid,
				 advisors.fname,
				 advisors.lname,
				 advisors.email,
				 advisors.photopath,
				 advisors.location,
				 advisors.lat,
				 advisors.lng,
				 advisors.age,
				 advisors.gender,
				 advisors.online,
				 advisors.overallrating,
                'advisor' As usertype,
				 favorites.favoriteid,
				favorites.status as favoritestatus,
				favorites.date as favoritedate,
				IFNULL(reviewcounts.reviewCount, 0) As reviewCount  
            FROM favorites
			INNER JOIN advisors ON advisors.advisorid = favorites.advisorid
			LEFT OUTER JOIN
				 (SELECT COUNT(*) AS reviewCount, advisorid FROM reviews GROUP BY advisorid) as reviewcounts
			ON reviewcounts.advisorid = advisors.advisorid 
			WHERE favorites.userid = $userid AND advisors.advisorid NOT IN(SELECT blockeduserid FROM blockedusers WHERE senderid = $userid AND usertype = 'user') AND (favorites.status = 10 OR(favorites.sender = 'advisor' AND favorites.status = 0)) ";	
		   $res = mysql_query($q);
		   if(mysql_num_rows($res) > 0)
		   {	
		      while($favorite = mysql_fetch_assoc($res)) {
                            $q = "SELECT reviews.*, users.fname, users.lname, users.photopath FROM reviews 
                            INNER JOIN users ON users.userid = reviews.userid 
                            WHERE reviews.advisorid =".$favorite["advisorid"];
			    $res1=mysql_query($q);				
			    if(mysql_num_rows($res1) > 0)
			    {
                                   $reviews = array();
                                   while($review = mysql_fetch_assoc($res1)) {
                                      $reviews[] = array('review'=>$review );
                                   }				    
				   $favorite["reviews"] = $reviews;
			    }
      		            $favorites[] = array('favorite'=>$favorite);
    		      } 
                  }
                }
                else if($advisorid > 0)
                {
                   //GetPurchaseStatus();
                   $q = "SELECT 
						 users.userid,
						 users.fname,
						 users.lname,
						 users.email,
						 users.photopath,
						 users.location,
						 users.lat,
						 users.lng,
						 users.age,
						 users.gender,
						 users.online,
						 users.investableamout,
						 users.occupation,
				         users.university,
				         users.phone,
				         users.socialpageurl,
                                         'user' As usertype,
						 favorites.favoriteid,
favorites.date as favoritedate,
                                        favorites.status as favoritestatus  FROM favorites 
                      INNER JOIN users ON users.userid = favorites.userid
                      WHERE favorites.advisorid = $advisorid AND users.userid NOT IN(SELECT blockeduserid FROM blockedusers WHERE senderid = $advisorid AND usertype = 'advisor') AND (favorites.status = 10 OR(favorites.sender = 'user' AND favorites.status = 0)) ";	
                   $res = mysql_query($q);
		   if(mysql_num_rows($res) > 0)
		   {	
		      while($favorite = mysql_fetch_assoc($res)) {
      		        $favorites[] = array('favorite'=>$favorite);
    		      } 
                  }   
                }	        
		            
header('Content-type: application/json');     
echo json_encode(array('favorites'=>$favorites));
}

function ForgetPassword()
{
        $obj=new funcs_code();
       	$obj->connection();		  
		$pwd = mt_rand(99999,9999999);
		$output = "0";	
		$userid = 0;
		$usertype = "";
		$email = "";
		$ency_pwd = "";	
$usertype = "";
		$ency_pwd = mysql_escape_string(md5($pwd));
        if(isset($_POST["email"]))
        {
            $email = $_POST["email"];
            $email = mysql_escape_string($email);
        }
        if(isset($_POST["usertype"]))
        {
            $usertype = $_POST["usertype"];
        }
        if($email != "")
        {
           if($usertype == "user")
	   {
	     $q ="SELECT * FROM users WHERE email = '$email'";
           }
	   else if($usertype == "advisor")
	   {
	     $q ="SELECT * FROM advisors WHERE email = '$email'";
	   }
	   $result =  mysql_query($q);					
	   if(mysql_num_rows($result) > 0)
	   {
              if($usertype == "user")
              {
                  $q = "UPDATE users SET password = '$ency_pwd' WHERE email = '$email'";
              }
              else if($usertype == "advisor")
              {
              $q = "UPDATE advisors SET password = '$ency_pwd' WHERE email = '$email'";
              }

                 if(mysql_query($q))
    	         {
    			$output = "1";
    			$message = "<b>Your new password is: ".$pwd."</b><br /><br />";
    		    $message = $message."Your password has been changed. You don't need to do anything, this message is simply a notification to protect the security of your account. Your new password has been activated. If it does not work on your first try, please try again later. "."<br /><br />";
                $message = $message."The Retirely Team";
    			$to = $email;
    			$subject = "Your Retirely password has been changed";
    			$from ="info@linkites.com";    			
                        $headers .= ' MIME-Version: 1.0'. "\r\n";
                        $headers .= 'Content-Type: text/html; charset=ISO-8859-1'. "\r\n"; 
                        $headers .= 'From:Retirely App<' . $from.'>';
    			@mail($to,$subject,$message,$headers);
    		 }
    		 else
    		 {
    		    $output = "0";		
    		 }
             }
             else
             {
                $output = "-2";	
             }
        }
        else
        {
           $output = "-1";	
        }
echo json_encode($output); 
}

function GetReviews()
{
//GetPurchaseStatus();
$obj=new funcs_code();
$obj->connection();	
$output = "";
$advisorid = 0;
if(isset($_GET["advisorid"]))
    {
        $advisorid= $_GET["advisorid"];
    }
$q = "SELECT reviews.*, users.fname, users.lname, users.photopath FROM reviews 
      INNER JOIN users ON users.userid = reviews.userid 
      WHERE reviews.advisorid =$advisorid Order By date desc";
$res1=mysql_query($q);	
$reviews = array();			
if(mysql_num_rows($res1) > 0)
{
     while($review = mysql_fetch_assoc($res1)) {
         $reviews[] = array('review'=>$review );
     }				    			   
}
header('Content-type: application/json');     
echo json_encode(array('reviews'=>$reviews));
}

function GetUserDetail()
{
$obj=new funcs_code();
$obj->connection();	
$output = "";
$userid = 0;
if(isset($_GET["userid"]))
    {
        $userid = $_GET["userid"];
    }
$q = "SELECT * FROM users WHERE users.userid =$userid";
$res1=mysql_query($q);	
$users = array();			
if(mysql_num_rows($res1) > 0)
{
     while($user = mysql_fetch_assoc($res1)) {
         $users[] = array('user'=>$user);
     }				    			   
}
header('Content-type: application/json');     
echo json_encode(array('users'=>$users));
}

function GetAdvisorDetail()
{
//GetPurchaseStatus();
$obj=new funcs_code();
$obj->connection();	
$output = "";
$advisorid = 0;
if(isset($_GET["advisorid"]))
    {
        $advisorid = $_GET["advisorid"];
    }
$q = "SELECT 
             advisors.*,
             IFNULL(reviewcounts.reviewCount, 0) As reviewCount 
      FROM 
             advisors
      LEFT OUTER JOIN
          (SELECT COUNT(*) AS reviewCount, advisorid FROM reviews GROUP BY advisorid) as reviewcounts
      ON reviewcounts.advisorid = advisors.advisorid 
      WHERE 
             advisors.advisorid = $advisorid";
$res1=mysql_query($q);	
$advisors = array();			
if(mysql_num_rows($res1) > 0)
{
     while($advisor = mysql_fetch_assoc($res1)) {
         $advisors[] = array('advisor'=>$advisor);
     }				    			   
}
header('Content-type: application/json');     
echo json_encode(array('advisors'=>$advisors));
}

function UpdateAdvisorStatus()
{
     $obj=new funcs_code();
     $obj->connection();
     $output = "0";
     $advisorid = 0;
     $promocode = "";
     $date = date('YmdHis');
     if(isset($_POST["advisorid"]))
     {
       $advisorid = $_POST["advisorid"];
     }
     if(isset($_POST["promocode"]))
     {
       $promocode = $_POST["promocode"];
     }
     if($promocode == "")
     {
        $q = "UPDATE advisors SET status = 10, purchasedate = '{$date}' WHERE advisorid = $advisorid";
        if(mysql_query($q))
        {
           $output = "1";
        }
     }
     else
     {
        $q = "SELECT * FROM promocodes WHERE code = '$promocode'";
        $res = mysql_query($q);          
        if(mysql_num_rows($res) > 0)
        {
           $q = "UPDATE advisors SET status = 10, purchasedate = '{$date}' WHERE advisorid = $advisorid";
           if(mysql_query($q))
           {
              $output = "1";
              $q = "DELETE FROM promocodes WHERE code = '$promocode'";
              mysql_query($q);          
           }  
        }
     }
     echo json_encode($output); 
}

function GetPurchaseStatus()
{
     $obj=new funcs_code();
     $obj->connection();
     $output = "0";
     $advisorid = 0;
     if(isset($_GET["advisorid"]))
     {
       $advisorid = $_GET["advisorid"];
     }
     $nowdate = date("Y-m-d", time()); 
     $date = date('YmdHis');
     $q = "SELECT * FROM advisors WHERE advisorid = $advisorid";
     $res = mysql_query($q);		
     if(mysql_num_rows($res) > 0)
     {
	$row = mysql_fetch_row($res);
        $purchasedate = $row["28"];        
        $before1month = date('Y-m-d H:i:s',strtotime("-1 month"));
	if(strtotime($purchasedate) <= strtotime($before1month))
	{           
		$q = "UPDATE advisors SET status = 0 WHERE advisorid = $advisorid";
		mysql_query($q);
		$contents = array();
		$contents['advisorid'] = $advisorid;
		$contents['status'] = 0;
		$alert = "";
		$renewurl = "";
		$q = "SELECT * FROM alerts WHERE type = 1";
		$res1 = mysql_query($q);		
		if(mysql_num_rows($res1) > 0)
		{
			$row1 = mysql_fetch_assoc($res1);
			$alert = $row1["alert"];
			$renewurl = $row1["url"];
		}
		$contents['message'] = $alert;
		$contents['renewurl'] = $renewurl;
		$output = $contents;
		echo json_encode($output);
		die; 
	}
  }     
}

function GetAdvisorPurchaseStatus($advisorid)
{
     $obj=new funcs_code();
     $obj->connection();
     $output = "0";     
     $nowdate = date("Y-m-d", time()); 
     $date = date('YmdHis');
     $q = "SELECT * FROM advisors WHERE advisorid = $advisorid";
     $res = mysql_query($q);		
     if(mysql_num_rows($res) > 0)
     {
	    $row = mysql_fetch_row($res);
        $purchasedate = $row["28"];        
        $before1month = date('Y-m-d H:i:s',strtotime("-1 month"));
	if(strtotime($purchasedate) <= strtotime($before1month))
	{           
		$q = "UPDATE advisors SET status = 0 WHERE advisorid = $advisorid";
		mysql_query($q);
		$contents = array();
		$contents['advisorid'] = $advisorid;
		$contents['status'] = 0;
		$alert = "";
		$renewurl = "";
		$q = "SELECT * FROM alerts WHERE type = 1";
		$res1 = mysql_query($q);		
		if(mysql_num_rows($res1) > 0)
		{
			$row1 = mysql_fetch_assoc($res1);
			$alert = $row1["alert"];
			$renewurl = $row1["url"];
		}
		$contents['message'] = $alert;
		$contents['renewurl'] = $renewurl;
                $contents['usertype'] = 'advisor';
		$output = $contents;
		echo json_encode($output);
		die; 
	}
  }     
}

function MarkAsBlocked()
{
	$obj=new funcs_code();
   	$obj->connection();
	$date = date('YmdHis');
	$output = "0";
	$senderid = 0; 
    $senderusertype = "";
	$blockeduserid = "";
	if(isset($_POST["senderid"]))
	{
		$senderid = $_POST["senderid"];
	}
	if(isset($_POST["senderusertype"]))
	{
		$senderusertype = $_POST["senderusertype"];
	}
	if(isset($_POST["blockeduserid"]))
	{
		 $blockeduserid = $_POST["blockeduserid"];
	}
	
	$q = "SELECT * FROM blockedusers WHERE senderid = $senderid AND usertype = '$senderusertype' AND blockeduserid = $blockeduserid";
	$res = mysql_query($q);          
	if(mysql_num_rows($res) == 0)
	{
		$q= "INSERT INTO blockedusers VALUES ('',$senderid,'$senderusertype',$blockeduserid,'{$date}',10)";
		if(mysql_query($q))
		{
			$output = "1";
		}
	}
	echo json_encode($output);
}

function GetBlockedUsers()
{
    $obj=new funcs_code();
    $obj->connection();
    $output = "0";
    $senderid = 0;
    if(isset($_GET["senderid"]))
    {
       $senderid = $_GET["senderid"];
    }
	if(isset($_GET["senderusertype"]))
	{
		$senderusertype = $_GET["senderusertype"];
	}
    
	$q = "SELECT * FROM blockedusers WHERE senderid = $senderid AND usertype = '$senderusertype'";
	$res = mysql_query($q);			
	if(mysql_num_rows($res) > 0)
	{
		while($result = mysql_fetch_assoc($res)) {
			$output = $output.$result["blockeduserid"].",";
		}
		$output = substr($output, 0, -1);		
	} 
	echo $output;
}

function iospushnotification($deviceToken ,$msg, $id, $usertype, $action, $favid)
{
    $deviceToken = str_replace("<","",$deviceToken);
    $deviceToken = str_replace(">","",$deviceToken);
    $deviceToken = str_replace(" ","",$deviceToken);
    $deviceToken = $deviceToken; 
	$payload['aps'] = array(
	'alert' => $msg,
	'badge' => 1, 
	'sound' => 'default'
	);
	if($action == "friendrequest")
        {
           $payload['friendrequest'] = $id."|".$usertype."|".$favid; 
        }
        else if($action == "approvedfriendrequest")
        {
           $payload['approvedfriendrequest'] = $id."|".$usertype."|".$favid;
        }
$passphrase = 'linkites';
	$payload = json_encode($payload);
	$apnsHost = 'gateway.push.apple.com';
	$apnsPort = 2195;
	$apnsCert = 'RetirelyCertificates_Dec_12_2013Pro.pem';
	$streamContext = stream_context_create();
	stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
stream_context_set_option($streamContext, 'ssl', 'passphrase', $passphrase);
	$apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error,$errorString,60,STREAM_CLIENT_CONNECT,$streamContext); 
	$apnsMessage	 = chr(0) . chr(0) . chr(32) . pack('H*', $deviceToken) . chr(0) . chr(strlen($payload)) . $payload;
	fwrite($apns, $apnsMessage);
	@socket_close($apns);
	fclose($apns);  
}

function iospushnotificationtest()
{
$deviceToken = '2da0fe6e3e386945287a18a7608295751164ac417e9a7b3fe49886853e885e26';
$deviceToken = str_replace("<","",$deviceToken);
    $deviceToken = str_replace(">","",$deviceToken);
    $deviceToken = str_replace(" ","",$deviceToken);
    $deviceToken = $deviceToken; 
	$msg = "Hello Mr. Granade";
	$payload['aps'] = array(
	'alert' => $msg,
	'badge' => 1, 
	'sound' => 'default'
	);
$passphrase = 'linkites';
	$payload = json_encode($payload);
	$apnsHost = 'gateway.push.apple.com'; 
	$apnsPort = 2195;
	$apnsCert = 'RetirelyCertificates_Dec_12_2013Pro.pem';
	$streamContext = stream_context_create();
	stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
        stream_context_set_option($streamContext, 'ssl', 'passphrase', $passphrase);
	$apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error,$errorString,60,STREAM_CLIENT_CONNECT,$streamContext); 
	$apnsMessage	 = chr(0) . chr(0) . chr(32) . pack('H*', $deviceToken) . chr(0) . chr(strlen($payload)) . $payload;
	fwrite($apns, $apnsMessage);
	@socket_close($apns);
	fclose($apns); 

}

function androidpushnotification($deviceToken ,$msg) 
{ 
        $registatoin_ids[0] = $deviceToken;                        
        $GOOGLE_API_KEY = "AIzaSyAZNPIhO5xv7ULaFoJ9OtGD8Ung4SevAQ4"; 
       
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';
 
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => array( "message" => $msg ),
         );
 
        $headers = array(
            'Authorization: key=' . $GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
        echo $result;
}

function GetChatHistory()
{  
   $obj=new funcs_code();
   $obj->connection();	
   $output = "";
   $advisorid = 0;
   $userid = 0;
   if(isset($_GET["userid"]))
   {
      $userid = $_GET["userid"];
   }
   if(isset($_GET["advisorid"]))
   {
      $advisorid = $_GET["advisorid"];
   }
   $q = "SELECT * FROM chats WHERE advisorid = $advisorid AND userid = $userid";
   $res1=mysql_query($q);	
   $chats = array();			
   if(mysql_num_rows($res1) > 0)
   {
      while($chat = mysql_fetch_assoc($res1)) {
         $msg = $chat["message"];
         $msg = stripslashes($msg);
         $chat["message"] = $msg;
         $chats[] = array('chat'=>$chat);
      }				    			   
   }
   header('Content-type: application/json');     
   echo json_encode(array('chats'=>$chats));
}

function GetAllChatHistory()
{  
    $obj=new funcs_code();
    $obj->connection();	
    $output = "";
    $id = 0;
	$usertype = "";
    if(isset($_GET["id"]))
    {
      $id = $_GET["id"];
    }    
	if(isset($_GET["usertype"]))
    {
      $usertype = $_GET["usertype"];
    }
	if($usertype == "user")
	{
		$q = "SELECT DISTINCT advisorid FROM chats WHERE userid = $id";
	}
	else if($usertype == "advisor")
	{
		$q = "SELECT DISTINCT userid FROM chats WHERE advisorid = $id";
	}
    $res1=mysql_query($q);	
    $chats = array();			
    if(mysql_num_rows($res1) > 0)
    {
      while($chat = mysql_fetch_assoc($res1)) {
		//$msg = explode("\n",$chat["message"]); 
		//$chat["message"] = end($msg);
		if($usertype == "user")
		{
			$aid = $chat["advisorid"];
			$q = "SELECT * FROM chats WHERE advisorid = $aid AND userid = $id ORDER BY date DESC LIMIT 1";
			$res2=mysql_query($q);
			if(mysql_num_rows($res2) > 0)
			{
				$row2 = mysql_fetch_assoc($res2);
				$msg = explode("\n",$row2["message"]);
				$chat["message"] = end($msg);
				$chat["id"] = $row2["id"];
				$chat["advisorid"] = $row2["advisorid"];
				$chat["userid"] = $row2["userid"];
				$chat["date"] = $row2["chatdate"];
			}
			$q = "SELECT 
					advisors.fname,
					advisors.lname,
					advisors.email,
					advisors.photopath,
					advisors.location,
					advisors.lat,
					advisors.lng,
					advisors.age,
					advisors.gender,
					advisors.online,
					advisors.overallrating,
					advisors.firm,
					advisors.registeredtitle,
					advisors.university,
					advisors.professionalbio,
					advisors.phone,
					advisors.website,
					advisors.currentoffice,
					advisors.socialpageurl,
					'advisor' AS usertype 
				FROM 
					advisors
				WHERE
					advisorid = $aid";
					
		}
		else
		{
			$uid = $chat["userid"];
			$q = "SELECT * FROM chats WHERE advisorid = $id AND userid = $uid ORDER BY date DESC LIMIT 1";
			$res2=mysql_query($q);
			if(mysql_num_rows($res2) > 0)
			{
				$row2 = mysql_fetch_assoc($res2);
				$msg = explode("\n",$row2["message"]);				
				$chat["message"] = end($msg);
				$chat["id"] = $row2["id"];
				$chat["advisorid"] = $row2["advisorid"];
				$chat["userid"] = $row2["userid"];
				$chat["date"] = $row2["chatdate"];
			}
			$q = "SELECT 
				users.fname,
				users.lname,
				users.email,
				users.photopath,
				users.location,
				users.lat,
				users.lng,
				users.age,
				users.gender,
				users.online,
				users.investableamout,
				users.occupation,
				users.university,
				users.phone,
				users.socialpageurl,
				'user' AS usertype
				FROM users WHERE userid = $uid";			
		}
		$resuserdetails = mysql_query($q);
		if(mysql_num_rows($resuserdetails) > 0)
		{
			$row = mysql_fetch_assoc($resuserdetails);
			$chat["userdetail"] = $row;
		}
        $chats[] = array('chat'=>$chat);
      }				    			   
    }
    //header('Content-type: application/json');     
    echo json_encode(array('chats'=>$chats));
}

function ContactUs()
{
        $email = '';
        $subject = '';
        $message = '';
        if(isset($_POST["email"]))
        {
            $email = $_POST["email"];
            $email = mysql_escape_string($email);
        }
        if(isset($_POST["subject"]))
        {
            $subject = $_POST["subject"];
        }
        if(isset($_POST["message"]))
        {
            $message = $_POST["message"];
        }
        if($email != "")
        {           
    	    $output = "1";
            $to = 'alex@intlfaces.com';
            $from = $email;    			
            //$headers .= ' MIME-Version: 1.0'. "\r\n";
            $headers .= 'Content-Type: text/html; charset=ISO-8859-1'. "\r\n"; 
            $headers .= 'From:<' . $from.'>';
            @mail($to,$subject,$message,$headers);    		 
        }
        else
        {
           $output = "-1";	
        }
        echo json_encode($output); 
}

function UpdatePhoto()
{
    $obj=new funcs_code();
    $obj->connection();	
    $output = "0";
    $advisorid = 0;
    $userid = 0;
    $photo = "";
    $imagepath = "";
    $usertype = "";

    if(isset($_POST['photo']))
    {
        $photo = $_POST['photo'];
    }
    if(isset($_POST['usertype']))
    {
        $usertype = $_POST['usertype'];
    }
    if(isset($_POST['advisorid']))
    {
        $advisorid = $_POST['advisorid'];
    }
    if(isset($_POST['userid']))
    {
        $userid = $_POST['userid'];
    }
    if($imagepath == "")
    {
	if ($photo != "")
	{            
	    $img = imagecreatefromstring(base64_decode($photo));
	    if($img != false)
	    {                
		$dt = date('YmdHis'); 
		$rn = mt_rand();
                if($usertype == "advisor")
                {
$imagepath ="upload/photos/advisor/".$dt.$rn.".jpg";
              $path = '../../'.$imagepath;
		    
		    imagejpeg($img, $path);
		    $q = "UPDATE advisors SET photopath = '$imagepath' WHERE advisorid = $advisorid";
                    mysql_query($q);
                    $output = "1";
                }			
		else if($usertype == "user")
                {
$imagepath ="upload/photos/user/".$dt.$rn.".jpg";
              $path = '../../'.$imagepath;
                    
		    imagejpeg($img, $path);
		    $q = "UPDATE users SET photopath = '$imagepath' WHERE userid = $userid";
                    mysql_query($q);
                    $output = "1";
                }
	    }
        }
    }
    echo json_encode($output); 	
}

function SearchUsersTest()
{
      
		$obj=new funcs_code();
   		$obj->connection();		
		$lat = 0;
		$lng = 0;
		$keywords = "";
		$userid = 0;
		$name = "";
		$male = "";
		$female ="";
		$minage = 0;
		$maxage = 0;
		$lat1 = 0;
		$lat2 = 0;
		$lng1 = 0;
		$lng2 = 0;
		$milesDistance = 5000;
		$pageid = 0;
        if(isset($_GET["pageid"]))
		{   
		   $pageid = $_GET["pageid"];
		}
		if(isset($_GET["lat"]))
		{   
		   $lat = $_GET["lat"];
		}
		if(isset($_GET["lng"]))
		{   
		   $lng = $_GET["lng"];
		}
		if(isset($_GET["keywords"]))
		{   
		   $keywords = $_GET["keywords"];
		}
		if(isset($_GET["advisorid"]))
		{   
		   $advisorid = $_GET["advisorid"];
		}
		if(isset($_GET["name"]))
		{   
		   $name = $_GET["name"];
		}
		if(isset($_GET["miles"]))
		{   
		   $milesDistance = $_GET["miles"];
		}
		if(isset($_GET["male"]))
		{   
			$male = $_GET["male"];
		}
		if(isset($_GET["female"]))
		{                 
			$female = $_GET["female"];
		}
		if(isset($_GET["minage"]))
		{   
		   $minage = $_GET["minage"];
		}
		if(isset($_GET["maxage"]))
		{   
		   $maxage = $_GET["maxage"];
		}
		$milesPerDegree = 0.868976242 / 60.0 * 1.2;	
		$degrees = $milesPerDegree * $milesDistance;
		$lng1 = $lng - $degrees;
		$lng2 = $lng + $degrees;
		$lat1 = $lat - $degrees;
		$lat2 = $lat + $degrees;

		
		$q = "SELECT 
				users.userid,
				users.fname,
				users.lname,
				users.email,
				users.photopath,
				users.location,
				users.lat,
				users.lng,
				users.age,
				users.gender,
				users.online,
				users.investableamout,
				users.occupation,
				users.university,
				users.phone,
				users.socialpageurl,
				IFNULL(favorites.favoriteid,0) AS favoriteid			
			FROM
				users
			LEFT OUTER JOIN
				favorites
			ON
				favorites.userid = users.userid AND favorites.advisorid = $advisorid 
			WHERE users.status <> 0 AND users.userid NOT IN(SELECT blockeduserid FROM blockedusers WHERE senderid = $advisorid AND usertype = 'advisor') 
			AND users.userid NOT IN(SELECT userid FROM favorites WHERE advisorid = $advisorid) ";
      
		if($lat > 0 && $lng > 0)
		{

        $sql = "Update advisors SET lat = $lat,lng = $lng  WHERE advisorid = $advisorid";
	       mysql_query($sql);
		    $q = $q."AND ((lat > $lat1 AND lat < $lat2) AND (lng > $lng1 AND lng < $lng2))";
		}
		if($male != "" && $female == "")
		{
			$q = $q." AND gender = '$male'";
		}
		else if($male == "" && $female != "")
		{
			$q = $q." AND gender = '$female'";
		}
		else if($male != "" && $female != "")
		{
			$q = $q." AND (gender = '$male' OR gender = '$female')";
		}
		if($minage > 0 && $maxage > 0)
		{
		   $q = $q." AND age >= $minage AND age <= $maxage";
		}

		if($name != "")
		{
		    $q = $q." AND name LIKE '%$name%'";
		}	
        if($keywords == "worldwide")
		{
			$q = "SELECT 
				users.userid,
				users.fname,
				users.lname,
				users.email,
				users.photopath,
				users.location,
				users.lat,
				users.lng,
				users.age,
				users.gender,
				users.online,
				users.investableamout,
				users.occupation,
				users.university,
				users.phone,
				users.socialpageurl,
				IFNULL(favorites.favoriteid,0) AS favoriteid			
			FROM
				users
			LEFT OUTER JOIN
				favorites
			ON
				favorites.userid = users.userid AND favorites.advisorid = $advisorid 
			WHERE users.status <> 0 AND users.userid NOT IN(SELECT blockeduserid FROM blockedusers WHERE senderid = $advisorid AND usertype = 'advisor') 
			AND users.userid NOT IN(SELECT userid FROM favorites WHERE advisorid = $advisorid) ";
			 
		    if($pageid >= 0)
			{
				$q = $q." AND users.userid > $pageid ";
			}
			
			$q = $q." ORDER BY users.userid limit 50";
		}

		$res=mysql_query($q);		
		if(mysql_num_rows($res) > 0) 
		{		
		 	$users= array();
			while($user = mysql_fetch_assoc($res)) {                            
				$users[] = array('user'=>$user);
			}
			header('Content-type: application/json');
			echo json_encode(array('users'=>$users));
		}			
}

function SearchAdvisorsTest()
{
		$obj=new funcs_code();
   		$obj->connection();		
		$lat = 0;
		$lng = 0;
		$keywords = "";
		$userid = 0;
		$name = "";
		$male = "";
		$female ="";
		$minage = 0;
		$maxage = 0;
		$lat1 = 0;
		$lat2 = 0;
		$lng1 = 0;
		$lng2 = 0;
		$milesDistance = 1000;
		$pageid = 0;
        if(isset($_GET["pageid"]))
		{   
		   $pageid = $_GET["pageid"];
		}
		if(isset($_GET["lat"]))
		{   
		   $lat = $_GET["lat"];
		}
		if(isset($_GET["lng"]))
		{   
		   $lng = $_GET["lng"];
		}
		if(isset($_GET["keywords"]))
		{   
		   $keywords = $_GET["keywords"];
		}
		if(isset($_GET["userid"]))
		{   
		   $userid = $_GET["userid"];
		}
		if(isset($_GET["name"]))
		{   
		   $name = $_GET["name"];
		}
		if(isset($_GET["miles"]))
		{   
		   $milesDistance = $_GET["miles"];
		}
		if(isset($_GET["male"]))
		{   
		   $male = $_GET["male"];
		}
		if(isset($_GET["female"]))
		{                 
		   $female = $_GET["female"];
		}
		if(isset($_GET["minage"]))
		{   
		   $minage = $_GET["minage"];
		}
		if(isset($_GET["maxage"]))
		{   
		   $maxage = $_GET["maxage"];
		}
		$milesPerDegree = 0.868976242 / 60.0 * 1.2;	
		$degrees = $milesPerDegree * $milesDistance;
		$lng1 = $lng - $degrees;
		$lng2 = $lng + $degrees;
		$lat1 = $lat - $degrees;
		$lat2 = $lat + $degrees;

                
		
		$q = "SELECT 
				advisors.advisorid,
				advisors.fname,
				advisors.lname,
				advisors.email,
				advisors.photopath,
				advisors.location,
				advisors.lat,
				advisors.lng,
				advisors.age,
				advisors.gender,
				advisors.online,
				advisors.overallrating,
                                advisors.firm,
                                advisors.registeredtitle,
				advisors.university,
				advisors.professionalbio,
				advisors.phone,
				advisors.website,
				advisors.currentoffice,
				advisors.socialpageurl,
                                'advisor' AS usertype,
				IFNULL(favorites.favoriteid,0) AS favoriteid,
                                IFNULL(reviewcounts.reviewCount, 0) As reviewCount			
			FROM
				advisors
                        LEFT OUTER JOIN
                              (SELECT COUNT(*) AS reviewCount, advisorid FROM reviews GROUP BY advisorid) as reviewcounts
                        ON reviewcounts.advisorid = advisors.advisorid
			LEFT OUTER JOIN
				favorites
			ON
				favorites.advisorid = advisors.advisorid AND favorites.userid = $userid
			WHERE advisors.status <> 0 AND advisors.advisorid NOT IN(SELECT blockeduserid FROM blockedusers WHERE senderid = $userid AND usertype = 'user') 
			AND advisors.advisorid NOT IN(SELECT advisorid FROM favorites WHERE userid = $userid)	";
		 
		if($lat > 0 && $lng > 0)
		{

$sql = "Update users SET lat = $lat,lng = $lng  WHERE userid = $userid";
	       mysql_query($sql);
$q = $q."AND ((lat > $lat1 AND lat < $lat2) AND (lng > $lng1 AND lng < $lng2))";
		}
		if($male != "" && $female == "")
		{
			$q = $q." AND gender = '$male'";
		}
		else if($male == "" && $female != "")
		{
			$q = $q." AND gender = '$female'";
		}
		else if($male != "" && $female != "")
		{
			$q = $q." AND (gender = '$male' OR gender = '$female')";
		}
		if($minage > 0 && $maxage > 0)
		{
		   $q = $q." AND age >= $minage AND age <= $maxage";
		}

		if($name != "")
		{
		    $q = $q." AND name LIKE '%$name%'";
		}
		
		if($keywords == "worldwide")
		{  
			$q = "SELECT 
					advisors.advisorid,
					advisors.fname,
					advisors.lname,
					advisors.email,
					advisors.photopath,
					advisors.location,
					advisors.lat,
					advisors.lng,
					advisors.age,
					advisors.gender,
					advisors.online,
					advisors.overallrating,
					advisors.firm,
					advisors.registeredtitle,
					advisors.university,
					advisors.professionalbio,
					advisors.phone,
					advisors.website,
					advisors.currentoffice,
					advisors.socialpageurl,
                                        'advisor' AS usertype,
					IFNULL(favorites.favoriteid,0) AS favoriteid,
                                        IFNULL(reviewcounts.reviewCount, 0) As reviewCount			
			FROM
				advisors
                        LEFT OUTER JOIN
                              (SELECT COUNT(*) AS reviewCount, advisorid FROM reviews GROUP BY advisorid) as reviewcounts
                        ON reviewcounts.advisorid = advisors.advisorid
			LEFT OUTER JOIN
				favorites
			ON
				favorites.advisorid = advisors.advisorid AND favorites.userid = $userid
			WHERE advisors.status <> 0 AND advisors.advisorid NOT IN(SELECT blockeduserid FROM blockedusers WHERE senderid = $userid AND usertype = 'user') 
			AND advisors.advisorid NOT IN(SELECT advisorid FROM favorites WHERE userid = $userid)	";
			 
			if($pageid >= 0)
			{
				$q = $q." AND advisors.advisorid > $pageid ";
			}
			
			$q = $q." ORDER BY advisors.advisorid limit 50";			
		}			
	
		$res=mysql_query($q);		
		if(mysql_num_rows($res) > 0) 
		{		
		 	$advisors = array();
			while($advisor = mysql_fetch_assoc($res)) {
				
				$advisors[] = array('advisor'=>$advisor);
			}
			header('Content-type: application/json');
			echo json_encode(array('advisors'=>$advisors));
		}			
}

function sendnotification($favid)
{
     $obj=new funcs_code();
     $obj->connection();
     $q = "SELECT * FROM favorites WHERE favoriteid = $favid";		 
     $res = mysql_query($q);				
     if(mysql_num_rows($res) > 0)
     {
        $rowfav = mysql_fetch_assoc($res);
        $sender = $rowfav["sender"];
		$advisorid = $rowfav["advisorid"];
		$userid = $rowfav["userid"];
        if($sender == "advisor")
		{
			$q = "SELECT * FROM users WHERE userid = $userid";
			$result = mysql_query($q);					
			if(mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_assoc($result);
				$fname = $row["fname"];
				$lname = $row["lname"];
			}
					
			$q = "SELECT * FROM advisors WHERE advisorid = $advisorid";
			$res1 = mysql_query($q);					
			if(mysql_num_rows($res1) > 0)
			{
		        $row1 = mysql_fetch_assoc($res1);	
		        $devicetoken = $row1["devicetoken"];
			    $devicetype = $row1["devicetype"];
				$name = $fname." ".$lname;
				$message = $name." approved your friend request.";
				if(strtolower($devicetype) == "ios")
				{
					iospushnotification($devicetoken, $message, $userid, 'user','approvedfriendrequest',$favid);
				}
				else if($devicetype == "android")
				{
					androidpushnotification($devicetoken, $message);
				}
			}
		}
		else if($sender == "user")
		{
			$q = "SELECT * FROM advisors WHERE advisorid = $advisorid";
			$result = mysql_query($q);					
			if(mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_assoc($result);
				$fname = $row["fname"];
				$lname = $row["lname"];
			}
			
			$q = "SELECT * FROM users WHERE userid = $userid";
			$res1 = mysql_query($q);					
			if(mysql_num_rows($res1) > 0)
			{
				$row1 = mysql_fetch_assoc($res1);	
				$devicetoken = $row1["devicetoken"];
				$devicetype = $row1["devicetype"];
				$name = $fname." ".$lname;
				$message = $name." approved your friend request.";
				if(strtolower($devicetype) == "ios")
				{
					iospushnotification($devicetoken, $message, $advisorid, 'advisor','approvedfriendrequest',$favid);
				}
				else if($devicetype == "android")
				{
					androidpushnotification($devicetoken, $message);
				}
			}
		}
	}
}

function GetAppVersion()
{
    $obj=new funcs_code();
    $obj->connection();	
    $output = "";
    $version = "";
    $devicetype = "ios";
    $response = array();	
    if(isset($_GET["version"]))
    {   
       $version = $_GET["version"];
    } 
    if(isset($_GET["devicetype"]))
    {   
       $devicetype = $_GET["devicetype"];
    }
    $q = "SELECT * FROM appversion WHERE devicetype = '$devicetype' order by id desc limit 1";
    $res=mysql_query($q);    		
    if(mysql_num_rows($res) > 0)
    {
        $row = mysql_fetch_assoc($res);
        if($row["version"] <= $version)
        {
           $response["valid"] = "true";	
           $response["url"] = $row["url"];
           $response["message"] = $row["message"];
        }	
        else
        {
           $response["valid"] = "false";	
           $response["url"] = $row["url"];
           $response["message"] = $row["message"];
        }		    			   
    }    
    $output = $response;  
    echo json_encode($output);
}

function DeleteChat()
{
	$obj=new funcs_code();
	$obj->connection();
	$output = "";		
	$id = $_POST["id"];
	$q= "DELETE FROM chats WHERE id = $id";
	if(mysql_query($q))
	{			
	   $output = "1";		
	}
	else
	{
	   $output = "0";		
	}
		
	echo json_encode($output); 
}

function SignInTest()
{
    $obj=new funcs_code();
    $obj->connection();			
    $email = '';
    $pwd  = '';
    $usertype = "";    
    $output = '';    
    $email = $_GET['email'];
    $email = mysql_real_escape_string($email);	
    $pwd= $_GET['pwd'];    
    $pwd = md5(mysql_real_escape_string($pwd));
    $usertype = $_GET['usertype'];   
    
    if($usertype == "advisor")
    {
       $q = "SELECT * FROM advisors WHERE email = '$email' AND password = '$pwd' AND status = 10";

       $res=mysql_query($q);
       if(mysql_num_rows($res)>0)
       {
          $row=mysql_fetch_assoc($res);	
          $id = $row["advisorid"];
//GetAdvisorPurchaseStatus($id);
          $q = "UPDATE advisors SET online = '1' WHERE advisorid = $id";        
          mysql_query($q);       
          $row["usertype"] = $usertype;
          $row["online"] = "1";
          $output = $row;
       }		
       else
       {
          $output = "0";
       }
    }
    else if($usertype == "user")
    {
       $q = "SELECT * FROM users WHERE email = '$email' AND password = '$pwd' AND status = 10";
       $res=mysql_query($q);
       $row=mysql_fetch_assoc($res);

       if(mysql_num_rows($res)>0)
       {	
          $id = $row["userid"];
          $q = "UPDATE users SET online = '1' WHERE userid = $id";        
          mysql_query($q);       
          $row["usertype"] = $usertype;
          $row["online"] = "1";
          $output = $row;
       }		
       else
       {
          $output = "0";
       }
    }	
echo $q;			
   echo json_encode($output); 
}