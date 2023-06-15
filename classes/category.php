	<?
include_once($conf->absolute_path."classes/DBaccess.php");
class category extends DBAccess 
{
	function __construct()
	 {
		$this->connectToDB();
	 }
	
	function insertCategory($urlfield = '')	
	{
		$tab = 'category_cat';
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
		foreach($_FILES as $key=>$value)
		{
			//upload image For time being its for image
			if($value['name'] !="" && $value['error']== 0)
			 {		
				//createthumb($path_product_image,$thumbnil_image,$this->thumbnailWidth,$this->thumbnailHeight);
				//createthumb($path_product_image,$thumbnil_image_,$this->mainImageWidth,$this->mainImageHeight);
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$this->absolute_path.$this->category_dir,$this->upload_size_allowed);
			 }
					
			 //add to insert query
			 $txtname=substr($key,4);
			 $inserts .=$txtname.",";
			 $vals .= "'".mysql_real_escape_string($product_image)."',";
		 }
		//removing last character comma
		  $inserts = rtrim($inserts,",");
		  $vals = rtrim($vals,",");
		//final passing for insertion

		if($recnum=$this->InsertRecord($tab,$inserts,$vals))
		{
			//insert into links table
			$inslink = "INSERT INTO link_lk(links_lk,table_lk) values ('$cmsurl','$tab')";
			$this->CustomModify($inslink);
					
			$this->msg = "Data added successfully.";
			return true;
		 }else{
			$this->msg = "There was some problem in saving data, try again.";
			 return false;
			
		 }
	} // End of Insert Funciton Here
	
	/// get cms by origin without pagination
	function getCatbyOrigin($origin = 'category'){
		
		 $sql = "select * from category_cat where parent_cat = 0 and origin_cat = '".$origin."' ";
		if($data = $this->CustomQuery($sql))
	   		return $data;
		else
		    {
			  $this->msg= "No data found.";
			  return false;
		    }
	  }// end get cms function
	  
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
	  
	  
	  	function updCategory($tab) // This funciton update all the results
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
				$user = "select * from ".$tab." where id_cat = ".mysql_real_escape_string($_GET['id']);
				$userdata = $this->CustomQuery($user);
				
				/*
				createthumb($path_product_image,$thumbnil_image,$this->thumbnailWidth,$this->thumbnailHeight);
				createthumb($path_product_image,$thumbnil_image_,$this->mainImageWidth,$this->mainImageHeight);*/
				if($userdata[0][$txtname] != '' and file_exists("../prod_images/category_images/".$userdata[0][$txtname]))
				{
					@unlink($this->absolute_path.$this->category_dir.$userdata[0][$txtname]);
					
				}
				//upload new image
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$this->absolute_path.$this->category_dir,$this->upload_size_allowed);
				
				//add to insert query
				$inserts .=$txtname."='".mysql_real_escape_string($product_image)."' ,";	
			}
					
		}
		//removing last character comma
		$inserts = rtrim($inserts,",");		
		//final passing for updation
		$query = "update ".$tab." set ".$inserts."  where id_cat=".$_GET['id'];
		if($rid2 = $this->CustomModify($query))
		{
			$recnum=$_GET['id'];
			$this->DeleteSetOfRecords("cat_pricegroup_catprcgrp","idcat_catprcgrp",mysql_real_escape_string($_GET['id']));
			if(is_array($_POST['prcgrp'])){
				foreach($_POST['prcgrp'] as $key=>$value)
				{
					$inserts="";
					$valu="";
					$inserts="id_catprcgrp,idcat_catprcgrp, idprcgrp_catprcgrp";
					$valu="'',".$recnum.",".$value."";
					$this->InsertRecord("cat_pricegroup_catprcgrp",$inserts,$valu);
					
				}
			}
					
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
	
	function delCategory($tab)   // This Function Delete the categorie 
	 {
		if($this->DeleteSetOfRecords($tab,"id_cat",$_GET['id']))
		   {
			   $this->DeleteSetOfRecords("family_faml", "id_cat_faml", $_GET['id']);
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
			
			$userdata = $this->CustomQuery($query);
			return $userdata;
		}
		function updCate($tab) // This funciton update all the results
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
				$user = "select * from ".$tab." where id_cat = ".mysql_real_escape_string($_GET['id']);
				$userdata = $this->CustomQuery($user);
				
				/*
				createthumb($path_product_image,$thumbnil_image,$this->thumbnailWidth,$this->thumbnailHeight);
				createthumb($path_product_image,$thumbnil_image_,$this->mainImageWidth,$this->mainImageHeight);*/
				if($userdata[0][$txtname] != '' and file_exists("../prod_images/category_images/".$userdata[0][$txtname]))
				{
					@unlink($this->absolute_path.$this->category_dir.$userdata[0][$txtname]);
					
				}
				//upload new image
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$this->absolute_path.$this->category_dir,$this->upload_size_allowed);
				
				//add to insert query
				$inserts .=$txtname."='".mysql_real_escape_string($product_image)."' ,";	
			}
					
		}
		//removing last character comma
		$inserts = rtrim($inserts,",");		
		//final passing for updation
		$query = "update ".$tab." set ".$inserts."  where id_cat=".$_GET['id'];
		if($rid2 = $this->CustomModify($query))
		{
			//$recnum=$_GET['id'];
			//$this->DeleteSetOfRecords("cat_pricegroup_catprcgrp","idcat_catprcgrp",mysql_real_escape_string($_GET['id']));
			//if(is_array($_POST['prcgrp'])){
				//foreach($_POST['prcgrp'] as $key=>$value)
				///{
					//$inserts="";
					//$valu="";
					//$inserts="id_catprcgrp,idcat_catprcgrp, idprcgrp_catprcgrp";
					//$valu="'',".$recnum.",".$value."";
					//$this->InsertRecord("cat_pricegroup_catprcgrp",$inserts,$valu);
					
				//}
			//}
					
			$this->msg = "Data updated successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	}// End of Function Update	
	
} // End of categorie Class here
?>