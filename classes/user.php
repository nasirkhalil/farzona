<?
include_once($conf->absolute_path."classes/DBaccess.php");
class users extends DBAccess 
{
	function __construct()
	{
		$this->connectToDB();
	}
	function destroy_users()
	{
		$this->DBDisconnect();
	}

//////////// user signin func ////////////////////
	function signin(){
		
		if($_POST['email'] == '' || $_POST['password'] == '')
		{
		
			$this->msg= "All fields are required.";
			return false;
		}

		$user=mysqli_real_escape_string($this->DBlink,$_POST['email']);
		$pass=mysqli_real_escape_string($this->DBlink,$_POST['password']);
		
	     $sql = "select * from user_usr where email_usr = '".$user."' and password_usr = '".$this->hashthepass($pass,"lqx1PPUs6KkIC#nvgz@bc&")."' ";
	  //echo $sql; die($_POST['password']);
	   $data = $this->CustomQuery($sql);

	   if($data[0]['email_usr'] ==$user && $data[0]['password_usr'] == $this->hashthepass($pass,"lqx1PPUs6KkIC#nvgz@bc&"))
	   {
		  /* if($data[0]['status_usr']!='1')
		   {
			   $this->msg= "Sorry, You are Inactive";
			   return false;
			   
		   }*/
		  	
		  	$_SESSION['users']['ID'] = $data[0]['id_usr'];
			$_SESSION['users']['login'] = $data[0]['first_name_usr'];
			$_SESSION['users']['loginemail'] = $data[0]['email_usr'];
			//$next=checkout;
//echo $this->site_url."successful".$_SESSION['URL']; die();
				//header("location:".$this->site_url."successful".$_SESSION['URL']);
				return true;	
			
	   }else{
		   $this->msg= "No user found with specified data, Try again.";
			return false;
	   }
	}// end function
	
	//////////// user signin func ajax ////////////////////
	function signinAjax($user,$pass){

		$sql = "select * from user_usr where email_usr = '".$user."' and password_usr = '".$this->hashthepass($pass,"lqx1PPUs6KkIC#nvgz@bc&")."' ";
	  
	   $data = $this->CustomQuery($sql);

	   if($data[0]['email_usr'] ==$user && $data[0]['password_usr'] == $this->hashthepass($pass,"lqx1PPUs6KkIC#nvgz@bc&"))
	   {
		   //if($data[0]['emailconfirm_usr']=='1'){
		  	
		  	$_SESSION['users']['ID'] = $data[0]['id_usr'];
			$_SESSION['users']['fname'] = $data[0]['first_name_usr'];
			$_SESSION['users']['lname'] = $data[0]['lastname_usr'];
			$_SESSION['users']['email'] = $data[0]['email_usr'];
			//$next=checkout;
			return true;
		   /*}else{
			   $this->msg= "Email not verified.";
			   return false;
		   }*/
			
	   }else{
		   $this->msg= "No user found with specified data, Try again.";
			return false;
	   }
	}// end function
	
	// This is the admin authentication of user name and password
	function authenticate(){
		if($_POST['user'] == '' || $_POST['pass'] == '')
		{
		
			$this->msg= "All fields are required.";
			return false;
		}
		$username=mysqli_real_escape_string($this->DBlink,$_POST['user']);
		$password=mysqli_real_escape_string($this->DBlink,$_POST['pass']);
     	$security="select * from admin_adm where username_adm='".$username."'";
		 $dataa = $this->CustomQuery($security);
	     $ss  = $dataa[0]["admin_salt_adm"];
		 //echo $result=$this->hashthepass($password,$ss);
		 //die();
		
	   $sql = "select * from admin_adm where username_adm = '".$username."' and password_adm = '".$this->hashthepass($password,$ss)."' ";
	   $data = $this->CustomQuery($sql);
	    
	   if($data[0]['username_adm'] == $username && $data[0]['password_adm'] == $this->hashthepass($password,$ss))
	   {
		   /*if($data[0]['status_adm']!='1')
		   {
			   $this->msg= "Sorry, You are blocked";
			   return false;
			   
		   }*/
			
			$_SESSION['admins']['ID'] = $data[0]['id_adm'];
			$_SESSION['admins']['user'] = $data[0]['username_adm'];
			$_SESSION['admins']['timeout'] = time();
			header("Location: dashboard.php");
			exit();
	   }
		$this->msg= "No user found with specified data, Try again.";
		return false;
	}
	
	
	function hashthepass($pass,$salt) // This is for the password encryption
	{
		return sha1($salt.$pass);
	}
	// This function update the admin password
	function updPass()
	{
		if(!isset($_POST['button']))
			return false;
         $old=mysqli_real_escape_string($this->DBlink,$_POST['op']);
		 $new=mysqli_real_escape_string($this->DBlink,$_POST['np']);
		 $confirm=mysqli_real_escape_string($this->DBlink,$_POST['cp']);
		 $check="select * from admin_adm where username_adm='".$_SESSION['admins']['user']."'";
$checked= $this->CustomQuery($check);
	     $ss  = $checked[0]["admin_salt_adm"];
 if($checked[0]['password_adm'] == $this->hashthepass($old,$ss))
	{	
	  if($new=$confirm)
	   {	 
		$password=mysqli_real_escape_string($this->DBlink,$_POST['np']);
     	$security="select * from admin_adm where username_adm='".$_SESSION['admins']['user']."'";
		 $dataa = $this->CustomQuery($security);
	     $ss  = $dataa[0]["admin_salt_adm"];
		 //echo $result=$this->hashthepass($password,$ss);
		 //die();
		 
		$query="update admin_adm set password_adm='".$this->hashthepass($password,$ss)."' where username_adm= '".$_SESSION['admins']['user']."' limit 1";
		//$query="update admin set password='".$_POST['np']."' limit 1";
		if($rid2 = $this->CustomModify($query))
		{
			$this->msg = "Password udpated successfully.";
			return true;
		}else{
			$this->msg = "Problem in updation, try again.";
			return true;
		} // Else ends here
	  }// This is the check for whether new and confirm new matches or not
	else
		{
		 $this->msg="New password and Confirm password does not match"; return false;	
		}
	 }// First if chech whether old password is there
else{ $this->msg="Old Password does not match"; return false; } //This else belongs to the first if of confirming the old passwords	 
	} // Function Ends here
	
	
function delUser($tab) // This function delete the single user
 {
   $ord=$this->getall("order_ord where iduser_ord=".mysqli_real_escape_string($this->DBlink,$_GET['id']));
   for($i=0;$i<count($ord);$i++)
   {
    $ord_det=$this->getall("order_detail_orddet where idord_orddet='".$ord[$i][   		'tracking_number_ord']."'");
     for($k=0;$k<count($ord_det);$k++)
	  {
	   $this->DeleteSetOfRecords("order_detail_orddet","idord_orddet",$ord_det[$k]['idord_orddet']); 
	  }
	  $this->DeleteSetOfRecords("order_ord","iduser_ord",$ord[$i]['iduser_ord']);
   }
   if($this->DeleteSetOfRecords($tab,"id_usr",mysqli_real_escape_string($this->DBlink,$_GET['id'])))
	{
	  $this->msg = "Record Deleted Successfully.";
		return true;
	}else{
	  $this->msg = "Problem in deleting record, try again.";
	  return false;
	}
}
	
function delmulti($tab,$id)   // This Function Delete  Multiple Records
 {
  if(isset($_POST['delete']))
  {	
	foreach($_POST['checkbox'] as $key=>$value)
	 {
	  $ord=$this->getall("order_ord where iduser_ord=".mysqli_real_escape_string($this->DBlink,$value));       for($i=0;$i<count($ord);$i++)
  		 {
    		$ord_det=$this->getall("order_detail_orddet where idord_orddet='".$ord[$i][   		'tracking_number_ord']."'");
     		for($k=0;$k<count($ord_det);$k++)
	  			{
	   				$this->DeleteSetOfRecords("order_detail_orddet","idord_orddet",$ord_det[$k]['idord_orddet']); 
	  			}
	  		$this->DeleteSetOfRecords("order_ord","iduser_ord",$ord[$i]['iduser_ord']);
   		}
   
	  $this->DeleteSetOfRecords($tab,$id,$value);	
	 }
	  $this->msg="Record Deleted Successfully";
  }
  else
  {
	 $this->msg = "Problem in deleting record, try again.";
	 return false;
  }
}
	
function GetDataPaginate($query) // This Functio get the paginated data
 { 
  if (isset($_REQUEST['page']))
	{
	  $page = $_REQUEST['page'];  
	}
  else 
	  $page="";
	
	
			$limit = 15;
			
			$total = $this->RecordsInQuery($query);
			
			// work out the pager values  
			
			$pager  = Pager::getPagerData($total, $limit, $page);  
			
			$offset = $pager->offset;  
			
			$limit  = $pager->limit;  
			
			$page   = $pager->page;
			
			$this->total_pages=$pager->numPages;
			
			$query=$query." limit $offset, $limit ";
			
			if($userdata = $this->CustomQuery($query))
			return $userdata;
			else
			{
				$this->msg="No Data Found";
				
			}
			
}
			
  function getall($query)  // This function Extract all the data and return in the form of array
	  {
		  $sql = "select * from ".$query." ";
	   
		if($data = $this->CustomQuery($sql))
	   		return $data;
		else
		    {
			  $this->msg= "No data found.";
			  return false;
		    }
	  }  // End of Function Here
	  			
	/////////////// insert user function /////////////  
	function insertuser($tab){
		$emailexist = $this->getall($tab." where email_usr = '".$_REQUEST['pre_email_usr']."'");
		if(is_array($emailexist)){
			$this->msg = "Email already exists.";
			return false;
		}
	    $inserts="";
		$vals = "";	
		//arranging values of POST only
		foreach($_REQUEST as $key=>$value) {
			
			$pos = strpos($key, "pre_");
			
			if(is_int($pos) && $pos == 0){
				
				$key = str_replace("pre_","",$key);
				
				$inserts .= $key.",";
				$vals .= "'".mysqli_real_escape_string($this->DBlink,$value)."',"; 
				
			}
		}
		//remonvig last characther
		$inserts = rtrim($inserts,",");
		$vals = rtrim($vals,",");
		
		if($recnum=$this->InsertRecord($tab,$inserts,$vals))
		{
			$yr = $_POST['year'];
			$mn = $_POST['month'];
			$dt = $_POST['day'];
			$dob = "$yr-$mn-$dt";
			
			$password=$this->hashthepass($_POST['password'],"lqx1PPUs6KkIC#nvgz@bc&");
			 $q="update user_usr set password_usr='".$password."', dob_usr = '$dob' where id_usr=".$recnum; 
			
			$this->CustomModify($q);
			//session code start
			
			$_SESSION['users']['ID'] = $recnum;
			$_SESSION['users']['fname'] = $_POST['pre_first_name_usr'];
			$_SESSION['users']['lname'] = $_POST['pre_lastname_usr'];
			$_SESSION['users']['email'] = $_POST['pre_email_usr'];
			
			
			$this->msg = "Data added successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}	
	
	}// End of Insert Funciton Here
	
	/////////////// insert user function /////////////  
	function InsertUserMob($tab){
		$emailexist = $this->getall($tab." where email_usr = '".$_REQUEST['user_email']."'");
		if(is_array($emailexist)){
			$this->msg = "Email already exists.";
			return "Email already exists.";
		}
	    $inserts="";
		$vals = "";	
		//arranging values of POST only
		foreach($_REQUEST as $key=>$value) {
			
			$pos = strpos($key, "user_");
			
			if(is_int($pos) && $pos == 0){
				
				$key = str_replace("user_","",$key);
				
				$inserts .= $key."_usr,";
				$vals .= "'".mysqli_real_escape_string($this->DBlink,$value)."',"; 
				
			}
		}
		//remonvig last characther
		$inserts = rtrim($inserts,",");
		$vals = rtrim($vals,",");
		//echo " insert into $tab $inserts values $vals"; die();
		if($recnum=$this->InsertRecord($tab,$inserts,$vals))
		{
			$password=$this->hashthepass($_REQUEST['user_password'],"lqx1PPUs6KkIC#nvgz@bc&");
			$q="update user_usr set password_usr='".$password."', dob_usr = '$dob' where id_usr=".$recnum; 
			
			$this->CustomModify($q);
			$data = $this->getall("$tab where id_usr = '$recnum'");
			//session code start
			$_SESSION['users']['ID'] = $data[0]['id_usr'];
			$_SESSION['users']['fname'] = $data[0]['first_name_usr'];
			$_SESSION['users']['lname'] = $data[0]['lastname_usr'];
			$_SESSION['users']['email'] = $data[0]['email_usr'];
			
			$this->msg = "Data added successfully.";
			return $_REQUEST['user_firstname'].' '.$_REQUEST['user_lastname'];
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}	
	
	}// End of Insert Funciton Here
	
///////////////////////////////////////////////// Insert Admin User functions we Add/Edit code start...
	function insertusrAdm($tab){	
	$email=mysqli_real_escape_string($this->DBlink,$_POST['pre_email_adm']);
	
	$availability="SELECT * FROM admin_adm where email_adm='".$email."'";	
		  if($data = $this->CustomQuery($availability))
		{
			$this->msg="Username already registered";
			return false;
		}
	$inserts="";
	$values = "";	
	$inserts = "password_adm,username_adm,email_adm,status_adm,type_adm,admin_salt_adm";
	$pass=mysqli_real_escape_string($this->DBlink,$_POST['pre_password_adm']);
	$password=$this->hashthepass($pass,"lqx1PPUs6KkIC#nvgz@bc&");
	$admin_salt="lqx1PPUs6KkIC#nvgz@bc&";
	$name=mysqli_real_escape_string($this->DBlink,$_POST['pre_username_adm']);
	$email=mysqli_real_escape_string($this->DBlink,$_POST['pre_email_adm']);
	$status = mysqli_real_escape_string($this->DBlink,$_POST['pre_status_adm']);
	$type = mysqli_real_escape_string($this->DBlink,$_POST['pre_type_adm']);
	$values="'".$password."'
			 ,'".$name."'
			 ,'".$email."'
			  ,'".$status."'
			  ,'".$type."'
			 ,'".$admin_salt."'";
			// echo $inserts."<br />";
			 //echo $values;
			 //die();
			if($recnum=$this->InsertRecord($tab,$inserts,$values))
			{
				$this->msg = "User Added Successfully.";		
				return true;
			 }else{
				$this->msg = "There was some problem in saving data, try again.";
				 return false;
				
			 }
	} // End of Insert user from adminpanel Funciton Here
	
	//////////// update user from adminpanel/////////////////////
	// adminpanel updation function
	function updusrAdm($tab,$rec)
	{
		
		$inserts="";
		//arranging values of POST only
		
		foreach($_POST as $key=>$value) {
			
			$pos = strpos($key, "upd_");
			
			if(is_int($pos) && $pos == 0){
				
				$key = str_replace("upd_","",$key);
				
				$inserts .= $key."='".$value."' ,";
				
			}
		}
		
		//checking for files values if anything uploaded
		/*foreach($_FILES as $key=>$value)
		{
			
			//upload image For time being its for image
			if($value['name'] !="" && $value['error']== 0)
			{
				
				$txtname=substr($key,4);
				//unlink old image
				$user = "select * from ".$tab." where " .$rec." = ".$_GET['id'];
			 
				$userdata = $this->CustomQuery($user);
				
				
				
				if($userdata[0][$txtname] != '' and file_exists($this->absolute_path.$imgpath.$userdata[0][$txtname]))
				{
					@unlink($this->absolute_path.$imgpath.$userdata[0][$txtname]);
				
				}
				
				//upload new image
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$this->absolute_path.$imgpath,$this->upload_size_allowed);
				
				//add to insert query
				$inserts .=$txtname."='".$product_image."' ,";	
			}
					
		}*/
		//removing last character comma
		$inserts = rtrim($inserts,",");		
		//final passing for updation
		$query = "update ".$tab." set ".$inserts."  where " .$rec. " =".$_GET['id'];
		
		if($rid2 = $this->CustomModify($query))
		{		
			$this->msg = "Data updated successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	}// end updation function	
	
//////////////////////////////////////////////// Insert Admin User functions we Add/Edit Code End...
	
	////////////////////// insert user from adminpanel////////////////////
function insertuserAdmin($tab){	
	$email=mysqli_real_escape_string($this->DBlink,$_POST['pre_email_usr']);
	
	$availability="SELECT * FROM user_usr where email_usr='".$email."'";	
		  if($data = $this->CustomQuery($availability))
		{
			$this->msg="Username already registered";
			return false;
		}
	$inserts="";
	$values = "";	
	$inserts = "login_usr,password_usr,first_name_usr,mobile_usr,email_usr,country_usr,city_usr,address_usr,status_usr";
	$login=mysqli_real_escape_string($this->DBlink,$_POST['pre_login_usr']);
	$pass=mysqli_real_escape_string($this->DBlink,$_POST['pre_password_usr']);
	$password=$this->hashthepass($pass,"lqx1PPUs6KkIC#nvgz@bc&");
	$name=mysqli_real_escape_string($this->DBlink,$_POST['pre_first_name_usr']);
	$mobile=mysqli_real_escape_string($this->DBlink,$_POST['pre_mobile_usr']);
	$email=mysqli_real_escape_string($this->DBlink,$_POST['pre_email_usr']);
	$country=mysqli_real_escape_string($this->DBlink,$_POST['pre_country_usr']);
	$city=mysqli_real_escape_string($this->DBlink,$_POST['pre_city_usr']);
	$address=mysqli_real_escape_string($this->DBlink,$_POST['pre_address_usr']);
	$status = mysqli_real_escape_string($this->DBlink,$_POST['pre_status_usr']);
	$values="'".$login."'
			 ,'".$password."'
			 ,'".$name."'
			 ,'".$mobile."'
			 ,'".$email."'
			 ,'".$country."'
			 ,'".$city."'
			 ,'".$address."'
			 ,'".$status."'";
			// echo $inserts."<br />";
			 //echo $values;
			 //die();
			if($recnum=$this->InsertRecord($tab,$inserts,$values))
			{
				$this->msg = "User Added Successfully.";		
				return true;
			 }else{
				$this->msg = "There was some problem in saving data, try again.";
				 return false;
				
			 }
} // End of Insert user from adminpanel Funciton Here
	
	//////////// update user from adminpanel/////////////////////
// adminpanel updation function
	function upduserAdmin($tab,$rec)
	{
		
		$inserts="";
		//arranging values of POST only
		
		foreach($_POST as $key=>$value) {
			
			$pos = strpos($key, "upd_");
			
			if(is_int($pos) && $pos == 0){
				
				$key = str_replace("upd_","",$key);
				
				$inserts .= $key."='".$value."' ,";
				
			}
		}
		
		//checking for files values if anything uploaded
		/*foreach($_FILES as $key=>$value)
		{
			
			//upload image For time being its for image
			if($value['name'] !="" && $value['error']== 0)
			{
				
				$txtname=substr($key,4);
				//unlink old image
				$user = "select * from ".$tab." where " .$rec." = ".$_GET['id'];
			 
				$userdata = $this->CustomQuery($user);
				
				
				
				if($userdata[0][$txtname] != '' and file_exists($this->absolute_path.$imgpath.$userdata[0][$txtname]))
				{
					@unlink($this->absolute_path.$imgpath.$userdata[0][$txtname]);
				
				}
				
				//upload new image
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$this->absolute_path.$imgpath,$this->upload_size_allowed);
				
				//add to insert query
				$inserts .=$txtname."='".$product_image."' ,";	
			}
					
		}*/
		//removing last character comma
		$inserts = rtrim($inserts,",");		
		//final passing for updation
		$query = "update ".$tab." set ".$inserts."  where " .$rec. " =".$_GET['id'];
		
		if($rid2 = $this->CustomModify($query))
		{		
			$this->msg = "Data updated successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	}// end updation function	
	
	///////// 
	function delGenDetails($tab,$colid) 
	{
		
		if($this->DeleteSetOfRecords($tab,$colid,$_GET['id']))
		{
			$this->msg = "Record Deleted Successfully.";
			return true;
		}else{
			$this->msg = "Problem in deleting record, try again.";
			return false;
		}
	}// end delGenDetails
	
	///////// user permissions function ////////
	function assignpermissions()
	{
		if(isset($_POST['button']))
		{
		$mainlinks=$this->getAll("links_lnk WHERE parent_lnk = 0");
	//print_r($mainlinks); die();
		for($i=0; $i<count($mainlinks); $i++)
		{
			$sublinks = $this->getAll("links_lnk where parent_lnk = ".$mainlinks[$i]['id_lnk']);
		
			for($j=0; $j<count($sublinks); $j++)
			{
				$userlinks = $this->getAll(" user_link_usrlnk where idparent_usrlnk = ".$mainlinks[$i]['id_lnk']." and idsub_usrlnk = ".$sublinks[$j]['id_lnk']." and iduser_usrlnk = ".$_GET['id']);
			
				if(array_key_exists("chk".$sublinks[$j]['id_lnk'],$_POST))
				{
					//echo $sublinks[$j]['id_lnk'];
					if($userlinks[0]['idsub_usrlnk'] != $sublinks[$j]['id_lnk'])
					{
						$inserts = "iduser_usrlnk, idparent_usrlnk, idsub_usrlnk";
						$vals = $_GET['id'].", ".$mainlinks[$i]['id_lnk'].", ".$sublinks[$j]['id_lnk'];
						$this->InsertRecord("user_link_usrlnk", $inserts, $vals);
				//echo	$insertqry = "insert into user_link_usrlnk set iduser_usrlnk=".$_GET['id']." , idparent_usrlnk=".$mainlinks[$i]['id_lnk']." , idsub_usrlnk=".$sublinks[$j]['id_lnk']." ";
					//$general->CustomQuery($insertqry);
					}// end inner if
				}// end if(array_key_exists)
					else
					{
						if($userlinks[0]['idsub_usrlnk'] == $sublinks[$j]['id_lnk'])
						{	
							$deletewhere=" where iduser_usrlnk=".$_GET['id']." and idparent_usrlnk=".$mainlinks{$i}['id_lnk']." and idsub_usrlnk=".$sublinks[$j]['id_lnk']." ";
							$this->DeleteAllRecordsNew("user_link_usrlnk",$deletewhere);
						}// end  if
					} // end else 	
				}// end inner for loop
			}// end outer for loop
	
		$this->msg="Successfully updated the permissions";
		}// end main if
		
	}/// end permissions function ////
	
	function deladminDetails($tab,$colid) 
	{
		
		if($this->DeleteSetOfRecords($tab,$colid,$_GET['id']))
		{
			$this->DeleteSetOfRecords("user_link_usrlnk", "iduser_usrlnk", $_GET['id']);
			
			$this->msg = "Record Deleted Successfully.";
			return true;
		}else{
			$this->msg = "Problem in deleting record, try again.";
			return false;
		}
	}// end delGenDetails
	
	function updProfile($tab) // This funciton update all the results
		{
		$inserts="";
		//arranging values of POST only
		
		foreach($_POST as $key=>$value) {
			
			$pos = strpos($key, "upd_");
			
			if(is_int($pos) && $pos == 0){
				
			$key = str_replace("upd_","",$key);
		$inserts .= $key."='".mysqli_real_escape_string($this->DBlink,$value)."' ,";
				
			}
		}
		
		//removing last character comma
		$inserts = rtrim($inserts,",");		
		//final passing for updation
		$query = "update ".$tab." set ".$inserts."  where id_usr=".$_SESSION['users']['ID'];
		
		if($rid2 = $this->CustomModify($query))
		{			
			$this->msg = "Profile updated successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	}// End of Function Update
	
	function updProfilePic($tab,$rec,$imgpath){
	foreach($_FILES as $key=>$value)
		{
			
			//upload image For time being its for image
			if($value['name'] !="" && $value['error']== 0)
			{
				
				$txtname=substr($key,4);
				//unlink old image
				$user = "select * from ".$tab." where " .$rec." = ".$_SESSION['users']['ID'];
			 
				$userdata = $this->CustomQuery($user);
				
				
				
				if($userdata[0][$txtname] != '' and file_exists($this->absolute_path.$imgpath.$userdata[0][$txtname]))
				{
					@unlink($this->absolute_path.$imgpath.$userdata[0][$txtname]);
				
				}
				
				//upload new image
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$this->absolute_path.$imgpath,$this->upload_size_allowed);
				
				//add to insert query
				$inserts .=$txtname."='".$product_image."' ,";	
			}
			//removing last character comma
			$inserts = rtrim($inserts,",");		
			//final passing for updation
			$query = "update ".$tab." set ".$inserts."  where id_ph=".$_SESSION['users']['ID'];
			
			if($rid2 = $this->CustomModify($query))
			{
				return true;
			}else{
				return false;
			}
					
		}
	}
	
	////// FORGOT FRONT USER PASSWORD /////
	function forgotUserPass(){
		$pass = genpassword(6);
		
		$security="select * from photographer_ph where email_ph='".$_POST['email']."'";
		$dataa = $this->CustomQuery($security);
		if($dataa!=''){
			$ss  = "lqx1PPUs6KkIC#nvgz@bc&";
		
			$query = "UPDATE photographer_ph set password_ph='".$this->hashthepass($pass, "lqx1PPUs6KkIC#nvgz@bc&")."' where email_ph='".$_POST['email']."'"; 
			if($change=$this->CustomModify($query)){
				return $pass;
			}else{
				return false;
			}
		
		 }else{
			 return false;
		 }
	}
	
	
	function forgotUserPassAjax($username){
		$pass = genpassword(6);
		
		$security="select * from user_usr where email_usr='".$username."'";
		$dataa = $this->CustomQuery($security);
		if($dataa!=''){
			$ss  = "lqx1PPUs6KkIC#nvgz@bc&";
		
			$query = "UPDATE user_usr set password_usr='".$this->hashthepass($pass, "lqx1PPUs6KkIC#nvgz@bc&")."' where email_usr='".$username."'"; 
			if($change=$this->CustomModify($query)){
				return $pass;
			}else{
				return false;
			}
		
		 }else{
			 
			 return false;
		 }
	}
	function ResetUserPass($pass,$username){
		//$pass = genpassword(6);
		
		$security="select * from user_usr where email_usr='".$username."'";
		$dataa = $this->CustomQuery($security);
		if($dataa!=''){
			$ss  = "lqx1PPUs6KkIC#nvgz@bc&";
		
			$query = "UPDATE user_usr set password_usr='".$this->hashthepass($pass, "lqx1PPUs6KkIC#nvgz@bc&")."' where email_usr='".$username."'"; 
			if($change=$this->CustomModify($query)){
				return true;
			}else{
				return false;
			}
		
		 }else{
			 
			 return false;
		 }
	}
	
	/////////// update front user password //////////////////////
	function updUserPass()
	{
		if(!isset($_POST['Submit']))
			return false;
         $old=$_POST['op'];
		 $new=$_POST['np'];
		 $confirm=$_POST['cp'];
		 //echo "select * from user_usr where id_usr='".$_SESSION['users']['ID']."'"; die();
		 $check="select * from user_usr where id_usr='".$_SESSION['users']['ID']."'";
		 $checked= $this->CustomQuery($check);
	     $ss  = "lqx1PPUs6KkIC#nvgz@bc&";
 		if($checked[0]['password_usr'] == $this->hashthepass($old,$ss))
		{	
	  		if($new==$confirm)
	   		{	 
				$password=$_POST['np'];
     			
		 $query="update user_usr set password_usr='".$this->hashthepass($password,$ss)."' where id_usr= '".$_SESSION['users']['ID']."' limit 1";
		//die();//$query="update admin set password='".$_POST['np']."' limit 1";
		if($rid2 = $this->CustomModify($query))
		{
			$this->msg = "Password udpated successfully.";
			return true;
		}else{
			$this->msg = "Problem in updation, try again.";
			return true;
		} // Else ends here
	  }// This is the check for whether new and confirm new matches or not
	else
		{
		 $this->msg="New password and Confirm password does not match"; return false;	
		}
	 }// First if chech whether old password is there
else{ $this->msg="Old Password does not match"; return false; } //This else belongs to the first if of confirming the old passwords	 
	} // Function Ends here
	
	/////////// update front user password //////////////////////
	function updUserPassAjax($tab)
	{
		//if(!isset($_REQUEST['Submit']))
			//return false;
         $emailchk = $this->getUserdets(" $tab where email_usr = '".$_REQUEST['email_usr']."' and id_usr != ".$_SESSION['users']['ID']);
		 if(is_array($emailchk)){
			 $this->msg = "Email already exists. Plz try another email.";
			 return 2;
		 }
		 
		 $old=mysqli_real_escape_string($this->DBlink,$_REQUEST['op']);
		 $new=mysqli_real_escape_string($this->DBlink,$_REQUEST['np']);
		 $confirm=mysqli_real_escape_string($this->DBlink,$_REQUEST['cp']);
		 $check="select * from $tab where id_usr='".$_SESSION['users']['ID']."'";
		 $checked= $this->CustomQuery($check);
	     $ss  = "lqx1PPUs6KkIC#nvgz@bc&";
 		if($checked[0]['password_usr'] == $this->hashthepass($old,$ss))
		{	
	  		if($new==$confirm)
	   		{	 
				$password=mysqli_real_escape_string($this->DBlink,$_REQUEST['np']);
     			
				$query="update $tab set email_usr = '".$_REQUEST['email_usr']."', password_usr='".$this->hashthepass($password,$ss)."' where id_usr= '".$_SESSION['users']['ID']."' limit 1";
		//$query="update admin set password='".$_REQUEST['np']."' limit 1";
		if($rid2 = $this->CustomModify($query))
		{
			$this->msg = "Password udpated successfully.";
			return true;
		}else{
			$this->msg = "Problem in updation, try again.";
			return false;
		} // Else ends here
	  }// This is the check for whether new and confirm new matches or not
	else
		{
		 $this->msg="New password and Confirm password does not match"; return 4;	
		}
	 }// First if chech whether old password is there
else{ $this->msg="Old Password does not match"; return 3; } //This else belongs to the first if of confirming the old passwords	 
	} // Function Ends here
	
	function getUserdets($query) 
	{
		$user = "select * from ".$query." ";
		$userdata = $this->CustomQuery($user);
		return $userdata;
	}
	
	function insertUser2($tab){
		$emailexist = $this->getall($tab." where email_usr = '".$_POST['pre_email_usr']."'");
		if(is_array($emailexist)){
			$this->msg = "Email already exists.";
			return false;
		}
	    $inserts="";
		$vals = "";	
		//arranging values of POST only
		foreach($_REQUEST as $key=>$value) {
			
			$pos = strpos($key, "pre_");
			
			if(is_int($pos) && $pos == 0){
				
				$key = str_replace("pre_","",$key);
				
				$inserts .= $key.",";
				$vals .= "'".mysqli_real_escape_string($this->DBlink,$value)."',"; 
				
			}
		}
		//remonvig last characther
		$inserts = rtrim($inserts,",");
		$vals = rtrim($vals,",");
		
		if($recnum=$this->InsertRecord($tab,$inserts,$vals))
		{ 
			$password=$this->hashthepass($_POST['pre_password_usr'],"lqx1PPUs6KkIC#nvgz@bc&");
			 $q="update user_usr set password_usr='".$password."' where id_usr=".$recnum; 
			
			$this->CustomModify($q);
			//session code start
			
			$_SESSION['users']['ID'] = $recnum;
			$_SESSION['users']['login'] = $_POST['pre_first_name_usr'];
			$_SESSION['users']['loginemail'] = $_POST['pre_email_usr'];
			//include"registermails.php";
			//header("location:".$this->site_url."successful".$_SESSION['URL']);
			
			$this->msg = "Data added successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}	
	
}// end function
	
	function insertPhotographer($tab){
		$emailexist = $this->getall($tab." where email_ph = '".$_POST['pre_email_ph']."'");
		if(is_array($emailexist)){
			$this->msg = "Email already exists.";
			return false;
		}
	    $inserts="";
		$vals = "";	
		//arranging values of POST only
		foreach($_REQUEST as $key=>$value) {
			
			$pos = strpos($key, "pre_");
			
			if(is_int($pos) && $pos == 0){
				
				$key = str_replace("pre_","",$key);
				
				$inserts .= $key.",";
				$vals .= "'".mysqli_real_escape_string($this->DBlink,$value)."',"; 
				
			}
		}
		$inserts .= "metatitle_ph,metatag_ph,metadescription_ph,registerdate_ph";
		$vals .= "'".$_POST['pre_name_ph']."','".$_POST['pre_name_ph']."','".$_POST['pre_name_ph']."','".date('Y-m-d')."'";
		
		//remonvig last characther
		$inserts = rtrim($inserts,",");
		$vals = rtrim($vals,",");
		if($recnum=$this->InsertRecord($tab,$inserts,$vals))
		{
			if(isset($_POST['password']) && $_POST['password']!=""){
				$password=$this->hashthepass($_POST['password'],"lqx1PPUs6KkIC#nvgz@bc&");
				$q="update $tab set password_ph='".$password."' where id_ph=".$recnum;
			}
			
			$this->CustomModify($q);
			/////// INSERT EXPERTISE
			if(isset($_POST['expertise'])){				
				$ins3 = "";
				$val3 = "";
				
				for($j=0; $j<count($_POST['expertise']); $j++){
										
					$ins3.="idph_pe,";
					$val3.=$recnum.",";
					
					$ins3.="idcat_pe,";
					$val3.=$_POST['expertise'][$j].",";
					
					$ins3 = rtrim($ins3,",");
					$val3 = rtrim($val3,",");
					
					$recnum12=$this->InsertRecord("photographerexpertise_pe",$ins3,$val3); 
					$ins3 = "";
					$val3 = "";					
					
				}
			}
			
			$this->msg = "Data added successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}	
	
	}// end function
	
} // Class Ends here
?>