<?
include_once($conf->absolute_path."classes/DBaccess.php");
class order extends DBAccess 
{
	function order()
	{
		$this->connectToDB();
	}
	
function insertordertemp()
 {
  $last="delivery";
   if(strpos($_SERVER['HTTP_REFERER'],$last)==true ){
	
session_register('orders');
$_SESSION['orders']['name']=mysql_real_escape_string($_POST['pre_shipment_name_ord']);
$_SESSION['orders']['phone']=mysql_real_escape_string($_POST['pre_phone_ord']);
$_SESSION['orders']['email']=mysql_real_escape_string($_POST['pre_email_ord']);
$_SESSION['orders']['country']=mysql_real_escape_string($_POST['pre_country_ord']);
$_SESSION['orders']['city']=mysql_real_escape_string($_POST['pre_city_ord']);
$_SESSION['orders']['address1']=mysql_real_escape_string($_POST['pre_shipment_address_ord']);
$_SESSION['orders']['address2']=mysql_real_escape_string($_POST['pre_shipment_address2_ord']);
	
	if(isset($_POST['order'])){
			$updqry = "UPDATE user_usr SET mobile_usr = '".$_POST['pre_phone_ord']."', country_usr = '".$_POST['pre_country_ord']."', city_usr = '".$_POST['pre_city_ord']."', address_usr = '".$_POST['pre_shipment_address_ord']."' where email_usr = '".$_SESSION['users']['loginemail']."'";
			$this->CustomModify($updqry);
	}
	
	header('location:vieworder.php');
		}
	}
function insertOrder($tab)
 {
	$inserts="";
	$vals = "";	
		//arranging values of POST only
	foreach($_REQUEST as $key=>$value) 
	 {
		$pos = strpos($key, "pre_");
		if(is_int($pos) && $pos == 0)
		 {
		  $key = str_replace("pre_","",$key);
		  $inserts .= $key.",";
		  $vals .= "'".mysql_real_escape_string($value)."',"; 
	     }
	}
		//checking for files values if anything uploaded
	/*foreach($_FILES as $key=>$value)
	{
			//upload image For time being its for image
	   if($value['name'] !="" && $value['error']== 0)
		{		
				//createthumb($path_product_image,$thumbnil_image,$this->thumbnailWidth,$this->thumbnailHeight);
				//createthumb($path_product_image,$thumbnil_image_,$this->mainImageWidth,$this->mainImageHeight);
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$this->absolute_path.$this->product_dir,$this->upload_size_allowed);
			 }
					
			 //add to insert query
			 $txtname=substr($key,4);
			 $inserts .=$txtname.",";
			 $vals .= "'".$product_image."',";
		 }*/
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
	} // End of Insert Funciton Here
	
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
	  
	  
	  	function updOrder($tab) // This funciton update all the results
	{
		if(!isset($_POST['button']))
			return false;
		
		$inserts="";
		//arranging values of POST only
		
		foreach($_POST as $key=>$value) {
			
			$pos = strpos($key, "upd_");
			
		if(is_int($pos) && $pos == 0){
		 $key = str_replace("upd_","",$key);
		 $inserts .= $key."='".mysql_real_escape_string($value)."' ,";
				
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
				$user = "select * from ".$tab." where id_ord= ".$_GET['id'];
				$userdata = $this->CustomQuery($user);
				
				/*
				createthumb($path_product_image,$thumbnil_image,$this->thumbnailWidth,$this->thumbnailHeight);
				createthumb($path_product_image,$thumbnil_image_,$this->mainImageWidth,$this->mainImageHeight);*/
				if($userdata[0][$txtname] != '' and file_exists("product_images/".$userdata[0][$txtname]))
				{
					@unlink($this->absolute_path.$this->product_dir.$userdata[0][$txtname]);
					
				}
				//upload new image
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$this->absolute_path.$this->product_dir,$this->upload_size_allowed);
				
				//add to insert query
				$inserts .=$txtname."='".$product_image."' ,";	
			}
					
		}
		//removing last character comma
		$inserts = rtrim($inserts,",");		
		//final passing for updation
		$query = "update ".$tab." set ".$inserts."  where id_ord=".mysql_real_escape_string($_GET['id']);
		if($rid2 = $this->CustomModify($query))
		{		
			$this->msg = "Data updated successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	}// End of Function Update
	
	function getSingdet($query)   // This function extract single row
	{
		$user = "select * from ".$query." ";
		$userdata = $this->CustomQuery($user);
		return $userdata;
	} // End of getSingdet Here
	
	function delOrder($tab)   // This Function Delete the categorie 
	 {
		 $ord=$this->getSingdet("order_ord where id_ord=".mysql_real_escape_string($_GET['id']));
		 $ord_det=$this->getall("order_detail_orddet where idord_orddet='".$ord[0]['tracking_number_ord']."'");		 
		if($this->DeleteSetOfRecords($tab,"id_ord",mysql_real_escape_string($_GET['id'])))
		   {
			   for($i=0;$i<count($ord_det);$i++)
			   {
				   $this->DeleteSetOfRecords("order_detail_orddet","idord_orddet",$ord_det[$i]['idord_orddet']); 
			   }
			 $this->msg = "Record Deleted Successfully.";
			 return true;
		   } 
	    else
		   {
			 $this->msg = "Problem in deleting record, try again.";
			 return false;
		   }
	  }
	  function delmulti($tab,$id) 
	  {
		if(isset($_POST['delete']))
		{
			foreach($_POST['checkbox'] as $key=>$value)
			{
			  $ord=$this->getSingdet("order_ord where id_ord=".mysql_real_escape_string($value)); // Get the specific order
		 $ord_det=$this->getall("order_detail_orddet where idord_orddet='".$ord[0]['tracking_number_ord']."'"); // Get all the details of the specific order
		 for($i=0;$i<count($ord_det);$i++)
		   {
			   $this->DeleteSetOfRecords("order_detail_orddet","idord_orddet",$ord_det[$i]['idord_orddet']); // now deleted the specific order details
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
	}//
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
			$this->msg="No Data Found";
		}	
}
?>