<?
include_once($conf->absolute_path."classes/DBaccess.php");
class product extends DBAccess 
{
	function __construct()
	{
		$this->connectToDB();
	}
	function insertRecordarray($array,$table)
	{
		$inserts="";
		$vals="";
		 foreach($array as $key=>$value)
	     {
		   $inserts .= $key.",";
		   $vals .= "'".mysqli_real_escape_string($this->DBlink,$value)."',";
	     }
		 $inserts = rtrim($inserts,",");
		$vals = rtrim($vals,",");
		//final passing for insertion
        
		if($recnum=$this->InsertRecord($table,$inserts,$vals))
		{		
			$this->msg = "Data added successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
		}
	}
	function insertProduct($tab,$imgpath)
	{
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
		//checking for files values if anything uploaded
		foreach($_FILES as $key=>$value)
		{
			//upload image For time being its for image
			if($value['name'] !="" && $value['error']== 0)
			{
				
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$this->absolute_path.$imgpath,$this->upload_size_allowed);
					
			//add to insert query
			$txtname=substr($key,4);
			$inserts .=$txtname.",";
			$vals .= "'".mysqli_real_escape_string($this->DBlink,$product_image)."',";
			
			}
		}
		//removing last character comma
		$inserts = rtrim($inserts,",");
		$vals = rtrim($vals,",");
		//final passing for insertion

		if($recnum=$this->InsertRecord($tab,$inserts,$vals))
		{
			$this->msg = "Data added successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	} //end function insert product
	
	function updProduct($tab,$rec,$imgpath)
	{
		if(!isset($_POST['button']))
	   {
		  
		return false;
	   }
		
		$inserts="";
		//arranging values of POST only
		
		foreach($_POST as $key=>$value) {
			$value=stripslashes($value);
			$pos = strpos($key, "upd_");
			
			if(is_int($pos) && $pos == 0){
				
				$key = str_replace("upd_","",$key);
				
				$inserts .= $key."='".$value."' ,";
				
			}
		}
		
		//checking for files values if anything uploaded
		foreach($_FILES as $key=>$value)
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
					
		}
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
		
	}// end function upd product
	
	function delcartlist()
	{
		$table="order_temp_ordtem";
		$frn="session_id_ordtem";
		$fval=session_id();
		if($this->DeleteSetOfRecords($table, $frn, $fval))
		{
			$this->msg = "";
			return true;
		}else{
			$this->msg = "";
			return false;
		}	
	}
	function delsingcart()
	{
		$table="order_temp_ordtem";
		$frn="idprd_ordtem";
		$fval=mysqli_real_escape_string($this->DBlink,$_GET['id']);
		if($this->DeleteSetOfRecords($table, $frn, $fval))
		{
			$this->msg = "";
			return true;
		}else{
			$this->msg = "";
			return false;
		}	
	}
	function delcart($tab,$id,$d)
	{
	if($this->DeleteSetOfRecords($tab,$id,$d))
		{
			$this->msg = "";
			return true;
		}else{
			$this->msg = "";
			return false;
		}	
	}
	 function updatesingcart($tab) // This funciton update all the results
		{
		if(isset($_POST['quantity']))
			{
				$quantity=mysqli_real_escape_string($this->DBlink,$_POST['quantity']);
				$id=mysqli_real_escape_string($this->DBlink,$_POST['product_id']);
				
				//$price =$this->getSingdet("product_prd where id_prd=".$id);

			$new_price = $quantity * $price[0]['adult_price_prd'];				
							
			$query = "update ".$tab." set quantity_ordtem=".$quantity."  where idprd_ordtem=".$id." and session_id_ordtem='".session_id()."'";
			
     if($rid2 = $this->CustomModify($query))
		{		
			$this->msg = "Data updated successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
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
	  
	
	function getSingdet($query)   // This function extract single row
	{
		$user = "select * from ".$query;
		//echo $user."<br />";
		$userdata = $this->CustomQuery($user);
		return $userdata;
	} // End of getSingdet Here
	
	function delGeneral($tab,$id,$req)   // This Function Delete the categorie 
	 {
		if($this->DeleteSetOfRecords($tab,$id,$req))
		   {
			 $this->msg = "Record Deleted Successfully.";
			 return true;
		   } 
	    else
		   {
			 $this->msg = "Problem in deleting record, try again.";
			 return false;
		   }
	  }
	
function delProduct($tab)   // This Function Delete the categorie 
 {
	 $prd=$this->getSingdet("product_prd where id_prd =".$_GET['id']);
  if($this->DeleteSetOfRecords($tab,"id_prd",mysqli_real_escape_string($this->DBlink,$_GET['id'])))
   {
	   if($this->DeleteSetOfRecords("product_prices_prdprice","idprd_prdprice",mysqli_real_escape_string($this->DBlink,$_GET['id'])))
	   {
		  $family = $this->getSingdet("family_faml where id_faml=".$prd[0]['id_faml_prd']);
		  $fprods = $this->getall("product_prd where id_faml_prd=".$family[0]['id_faml']);
		  if($fprods!=""){

			$price='';
			for($j=0; $j<count($fprods); $j++)
			{
				$price.=$fprods[$j]['id_prd'].",";
			}

			$price = rtrim($price,",");
			$minprice =$this->CustomQuery( "select min(price_prdprice) from product_prices_prdprice where 	      idprd_prdprice in( ".$price." ) ");
			}else{
			$minprice[0]['min(price_prdprice)']=0;	
			}
			$this->CustomModify("update family_faml set price_faml = ".$minprice[0]['min(price_prdprice)']." where id_faml=".$family[0]['id_faml']);
		  
	 $this->msg = "Record Deleted Successfully.";
	 return true;
	   
	} 
  else
   {
	 $this->msg = "Problem in deleting record, try again.";
	 return false;
	}
   }
 }
  function delmulti($tab,$id) 
   {
	 if(isset($_POST['delete']))
	  {			
	   foreach($_POST['checkbox'] as $key=>$value)
		{
		 	$this->DeleteSetOfRecords($tab,$id,$value);
		}
		  $this->msg="Record Deleted Successfully";
	   }
	 else
		{
			$this->msg = "Problem in deleting record, try again.";
			return false;
		}
	}//
	function GetDataPaginate($query) // This Functio get the paginated data
	{ 
     if (isset($_REQUEST['page']))
	    {
	      $page = $_REQUEST['page'];  
	    }
	 else 
	    $page="";
	
	
			$limit = 24;
			
			$total = $this->RecordsInQuery($query);
			
			// work out the pager values  
			
			$pager  = Pager::getPagerData($total, $limit, $page);  
			
			$offset = $pager->offset;  
			
			$limit  = $pager->limit;  
			
			$page   = $pager->page;
			
			$this->total_pages=$pager->numPages;
			
			$query=$query." limit $offset, $limit ";
			
			$userdata = $this->CustomQuery($query);
			return $userdata;
		}	

function test_input($data)
{
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
}	

	function validateFields($key,$value){
		//echo $key." = ".$value;
		if(strstr($key,"email")){
						if (empty($value))
						{$_SESSION['not_valid']['msg'] = $key." is required";
							return false;
						}
						else
						{
							$email = $this->test_input($value);
							// check if e-mail address syntax is valid
							if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
							{
								$_SESSION['not_valid']['msg'] = "Invalid ".$key." format";
								return false;
							}
						}
					}elseif(strstr($key,"subject")){
						if (empty($value))
						{$_SESSION['not_valid']['msg'] = $key." is Required";
							return false;
						}
					}elseif(strstr($key,"details")){
						if (empty($value))
						{$_SESSION['not_valid']['msg'] = $key." is Required";
							return false;
						}
					}else{
						if (empty($value))
						{
							$_SESSION['not_valid']['msg'] = $key." is Required";
							return false;
						}
						else
						{
							$name = $this->test_input($value);
							// check if name only contains letters and whitespace
							if (!preg_match("/^[a-zA-Z0-9 ]*$/",$name))
							{
								$_SESSION['not_valid']['msg'] = "Only letters and white spaces allowed in ".$key;
								return false;
							}
						}
					}
					return true;
	}
	
	function finalizeOrder()
	{
		$values = array();
		foreach($_REQUEST as $key=>$value) {
			
			$pos = strpos($key, "pre_");
			
			if(is_int($pos) && $pos == 0){
				
				$key = str_replace("pre_","",$key);
				
				$keypos = strpos($key, "1");
				if(is_int($keypos) && $keypos == 0){
					$key = str_replace("1","",$key);
					$field = str_replace("_enq","",$key);
					$valid = $this->validateFields($field,$value);
					if(!$valid){
						return false;
					}
				}
				$values[] = $value;
			}
		}
		//print_r($values);
		//$date = date("Y-m-d H:i:s",strtotime("+10 hour"));
//				$localdate =  date( 'Y-m-d H:i:s',strtotime($date));
		
		$recs = $this->getAll("order_temp_ordtem where session_id_ordtem = '".session_id()."'");
		//$userdets = $this->getSingdet(" user_usr where id_usr = ".$_SESSION['users']['ID']);
		$inserts = "shipment_name_ord,email_ord,phone_ord,country_ord,shipment_address_ord,details_ord,date_ord";
		  $vals = "'".$values[0].
		  "','".$values[1].
		  "','".$values[2].
		  "','".$values[3].
		  "','".$values[4].
		  "','".$values[5].
		  "','".date("Y-m-d")."'";
		
		
		$recnum = $this->InsertRecord("order_ord",$inserts,$vals);
		
			if(strlen($recnum)==1){
			$tracking_no = "KHU-00000".$recnum;
		}elseif(strlen($recnum)==2){
			$tracking_no = "KHU-0000".$recnum;
		}elseif(strlen($recnum)==3){
			$tracking_no = "KHU-000".$recnum;
		}elseif(strlen($recnum)==4){
			$tracking_no = "KHU-00".$recnum;
		}elseif(strlen($recnum)==5){
			$tracking_no = "KHU-0".$recnum;
		}elseif(strlen($recnum)==6){
			$tracking_no = "KHU-".$recnum;
		}
		$query = "update order_ord set tracking_number_ord='".$tracking_no."' where id_ord=".$recnum;
		$this->CustomModify($query);
		
			
		//order_detail_orddet

		for($d=0;$d<count($recs);$d++)
		{
			$prod = $this->getSingdet("content_cms where id_cms = ".$recs[$d]['idprd_ordtem']);
			$inserts = "idord_orddet,idprd_orddet,name_orddet,date_orddet,brand_orddet,model_orddet";
			
			 $vals = "'".$tracking_no
			."',".$recs[$d]['idprd_ordtem']
			.",'".$recs[$d]['name_ordtem']
			."','".date("Y-m-d")
			."','".$recs[$d]['brand_ordtem']
			."','".$recs[$d]['model_ordtem']."'";
			
			$recnum1 = $this->InsertRecord("order_detail_orddet",$inserts,$vals);
			}
		
		
		//updating amount in main table
//deleting all the records from temporary order table
		$this->DeleteSetOfRecords("order_temp_ordtem", "session_id_ordtem",session_id());
		session_regenerate_id();
		return $tracking_no;
		}
		
}
?>