<?
include_once($conf->absolute_path."classes/DBaccess.php");
class cms extends DBAccess 
{
	function __construct()
	{
		$this->connectToDB();
	}
	function destroy_cms()
	{
		$this->DBDisconnect();
	}
	
	function filterName($name){
		$link = trim(preg_replace('/\s+/', ' ', $name));//trim multiple spaces into one
		$link = str_replace(' ', '-', $link); // Replaces all spaces with hyphens.
   		$link = preg_replace('/[^A-Za-z0-9\-]/', '', $link);
		return strtolower($link);
	}//end function
	
	//generate url function
	function completeURL($tab,$id,$val,$name,$parent){
		$cmsdata = $this->CustomQuery("select * from ".$tab." where " .$id." = '".$val."' ");
		$link = $this->filterName($cmsdata[0][$name]);
	if($cmsdata[0][$parent]!=0){
		$parent1= $this->CustomQuery("select * from $tab where $id = ".$cmsdata[0][$parent]);
		$parlink = $this->filterName($parent1[0][$name]);
		if($parent1[0][$parent]!=0){
		 $parent2= $this->CustomQuery("select * from $tab where $id = ".$parent1[0][$parent]);
		 $par2link = $this->filterName($parent2[0][$name]);
		 if($parent2[0][$parent]!=0){
		  $parent3= $this->CustomQuery("select * from $tab where $id = ".$parent2[0][$parent]);
		  $par3link = $this->filterName($parent3[0][$name]);
		  if($parent3[0][$parent]!=0){
		   $parent4= $this->CustomQuery("select * from $tab where $id = ".$parent3[0][$parent]);
		   $par4link = $this->filterName($parent4[0][$name]);
		   return $par4link."/".$par3link."/".$par2link."/".$parlink."/".$link;
		  }else{
		   return $par3link."/".$par2link."/".$parlink."/".$link; // if 3 level parents
		  }
		 }else{
		  return $par2link."/".$parlink."/".$link; // if 2 level parents
		 }
		}else{
		 return $parlink."/".$link; // if single parent
		}
	   }else{
		return $link; // if parent 0
	   } 
	}//end function
	
	///// function for cms insertion from adminpanel//////////////
	function insertCMS($urlfield='') // if no urlfield then do not create url	
	{
		$tab = 'content_cms';
		$imgpath = $this->absolute_path.$this->general_dir;		
		$inserts="";
		$vals = "";	
		//arranging values of POST only
		foreach($_REQUEST as $key=>$value) {
			
			$pos = strpos($key, "pre_");
			
			if(is_int($pos) && $pos == 0){
				
				$key = str_replace("pre_","",$key);
				
				$inserts .= $key.",";
				$vals .= "'".$value."',"; 
				
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
				$product_image=nowDirectImage($key,$imgpath,$this->upload_size_allowed);
			}
					
			//add to insert query
			$txtname=substr($key,4);
			$inserts .=$txtname.",";
			$vals .= "'".$product_image."',";
		}
		//removing last character comma
		$inserts = rtrim($inserts,",");
		$vals = rtrim($vals,",");
		//final passing for insertion

		if($recnum=$this->InsertRecord($tab,$inserts,$vals))
		{
			//update its url
			//$cmsurl = $this->filterName($_POST['pre_name_cms']);
			if($urlfield!=''){
				$cmsurl = $this->completeURL($tab,"id_cms",$recnum,$urlfield,"parent_cms");
			}
			
			if($cmsurl!=""){
				//insert into links table
				$inslink = "INSERT INTO link_lk(links_lk,table_lk,idtab_lk) values ('$cmsurl','$tab','$recnum')";
				$this->CustomModify($inslink);		
			}
			$this->msg = "Data added successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;			
		}
		
	}// end cms insertion function
	
	////////// function for cms updation from adminpanel//////////
	function updCMS($urlfield = '')
	{
		$tab = 'content_cms';
		$rec = 'id_cms';
		$imgpath = $this->absolute_path.$this->general_dir;
		if(!isset($_POST['button']))
	   {
		  
		return false;
	   }
	   
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
		foreach($_FILES as $key=>$value)
		{
			
			//upload image For time being its for image
			if($value['name'] !="" && $value['error']== 0)
			{
				
				$txtname=substr($key,4);
				//unlink old image
				$user = "select * from ".$tab." where " .$rec." = ".$_GET['id'];
			 
				$userdata = $this->CustomQuery($user);
				
				if($userdata[0][$txtname] != '' and file_exists($imgpath.$userdata[0][$txtname]))
				{
					@unlink($imgpath.$userdata[0][$txtname]);
				}
				
				//upload new image
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$imgpath,$this->upload_size_allowed);
				
				//add to insert query
				$inserts .=$txtname."='".$product_image."' ,";	
			}
					
		}
		//removing last character comma
		$inserts = rtrim($inserts,",");
		//checking and renaming for physical page
		$data = $this->getSingCMS($_GET['id']);
		//echo $this->absolute_path.$data[0]['url_cms'].".php"; die();	
		//final passing for updation
		$query = "update ".$tab." set ".$inserts."  where " .$rec. " =".$_GET['id'];
		
		if($rid2 = $this->CustomModify($query))
		{	
			//$cmsurl = $this->filterName($_POST['upd_name_cms']);
			if($urlfield!=''){
			$cmsurl = $this->completeURL($tab,"id_cms",$_GET['id'],$urlfield,"parent_cms");
			}
			if($cmsurl!=""){
				//links table updation
				// check in database if there is same link as that new generated	
				$linkcheck = $this->getSingdet(" link_lk where links_lk = '$cmsurl' and table_lk = '$tab' and idtab_lk != ".$_GET['id']);
				if(is_array($linkcheck)){
					$cmsurl = $cmsurl.rand(1,10);
					$newlinkcheck = $this->getSingdet(" link_lk where links_lk = '$cmsurl' ");
					if(is_array($newlinkcheck)){
						$cmsurl = $cmsurl.rand(10,20);
					}
				}
				
				// now look for url of current cms
				$linkexists = $this->getSingdet(" link_lk where idtab_lk = ".$_GET['id']." and table_lk = '$tab'");
				
				if(is_array($linkexists)){
					$this->CustomModify(" UPDATE link_lk SET  links_lk = '$cmsurl' where id_lk = '".$linkexists[0]['id_lk']."'");					
				}else{
					$inslink = "INSERT INTO link_lk(links_lk,table_lk,idtab_lk) values ('$cmsurl','$tab','".$_GET['id']."')";
					$this->CustomModify($inslink);
				}
			}
			
			/*if(file_exists($this->absolute_path.$data[0]['url_cms'].".php")){
				rename($this->absolute_path.$data[0]['url_cms'].".php", $this->absolute_path.$cmsurl.".php");
			}*/
			
			$this->msg = "Data updated successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	}// end update cms function
	
	// cms sorting function //
	function sortCMS($table = 'content_cms',$ordcol = 'order_cms',$idcol = 'id_cms')
	{
		if(isset($_POST['sortion']))
		 {

			
	foreach($_POST as $key=>$value) {
			
			$pos = strpos($key, "ordsort_");
			
			if(is_int($pos) && $pos == 0){
				  $id = explode("_",$key);
		     
		 	$query="update ".$table." set ".$ordcol." = ".$value."  where ".$idcol." = ".$id[1];
		   // echo "<br />";
			$rid2 = $this->CustomModify($query);
		  //echo "<br />";
			  }
		  }
	  }
	  
		$this->msg = "Sequence updated.";
		return true;
	}//end function
	
	function CMSstatus($status,$cmsid){
		$qry= "UPDATE content_cms set status_cms='$status' where id_cms = '$cmsid'";
		$this->CustomModify($qry);
	}
	
	
	/// get cms by origin without pagination
	function getCMSbyOrigin($origin = 'menu')
	  {
		 $sql = "select * from content_cms where parent_cms = 0 and origin_cms = '".$origin."' ";
		if($data = $this->CustomQuery($sql))
	   		return $data;
		else
		    {
			  $this->msg= "No data found.";
			  return false;
		    }
	  }// end get cms function
	
	/// get cms without pagination
	function getSubCMS($parent)
	  {
		 $sql = "select * from content_cms where parent_cms =  '$parent'";
		if($data = $this->CustomQuery($sql))
	   		return $data;
		else
		    {
			  $this->msg= "No data found.";
			  return false;
		    }
	  }// end get cms function
	
	/// get cms without pagination
	function getCMS($query)
	  {
		 $sql = "select * from ".$query." ";
		if($data = $this->CustomQuery($sql))
	   		return $data;
		else
		    {
			  $this->msg= "No data found.";
			  return false;
		    }
	  }// end get cms function
	  
	  /// get cms without pagination
	function getSingCMS($cmsid)
	  {
		 $sql = " select * from content_cms where id_cms = '$cmsid'";
		if($data = $this->CustomQuery($sql))
	   		return $data;
		else
		    {
			  $this->msg= "No data found.";
			  return false;
		    }
	  }// end get cms function
	
	///// get cms with pagination 15 per page ////////////
	function GetCMSpaginate($query) // This Functio get the paginated data
	{ 
     if (isset($_REQUEST['page']))
	    {
	      $page = $_REQUEST['page'];  
	    }
	 else 
	    $page="";
	
	
			$limit = 1000;
			
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
		}	// End of Function 
	
	//this function delete single record cms only with image unlink///
	function delCMS($tab = 'content_cms') 
	{
		$data = $this->getCMS(" content_cms where id_cms = ".$_GET['id']);
		$childs = $this->getCMS(" content_cms where parent_cms = ".$_GET['id']);
		if(is_array($childs)){
			$this->msg = "Can not delete, Please Delete its child records first.";
			return 2;
		}else{			
			if($this->DeleteSetOfRecords($tab,"id_cms",$_GET['id']))
			{			
				// link deletion
				$this->CustomModify("delete from link_lk where idtab_lk='".$_GET['id']."' and table_lk='".$tab."'");
				
				@unlink($this->absolute_path.$this->general_dir.$data[0]['image_name_cms']);
				// deleting thumbnail
				if(file_exists($this->absolute_path.$this->general_dir."_".$data[0]['image_name_cms'])){
					@unlink($this->absolute_path.$this->general_dir."_".$data[0]['image_name_cms']);
				}
				// deleting thumbnail
				if(file_exists($this->absolute_path.$this->general_dir."__".$data[0]['image_name_cms'])){
					@unlink($this->absolute_path.$this->general_dir."__".$data[0]['image_name_cms']);
				}
				
				$this->msg = "Record Deleted Successfully.";
				return true;
			}else{
				$this->msg = "Problem in deleting record, try again.";
				return false;
			}
		}
	}// end function
	
	function delmultiCMS($tab = 'content_cms') 
	{
		$data = $this->getCMS(" content_cms where id_cms = ".$_REQUEST['checkbox']);
		$childs = $this->getCMS(" content_cms where parent_cms = ".$_REQUEST['checkbox']);
		if(is_array($childs)){
			$this->msg = "Can not delete, Please Delete its child records first.";
			return 2;
		}else{			
			if($this->DeleteSetOfRecords($tab,"id_cms",$_REQUEST['checkbox']))
			{			
				// link deletion
				$this->CustomModify("delete from link_lk where idtab_lk='".$_REQUEST['checkbox']."' and table_lk='".$tab."'");
				
				@unlink($this->absolute_path.$this->general_dir.$data[0]['image_name_cms']);
				if(file_exists($this->absolute_path.$this->general_dir."_".$data[0]['image_name_cms'])){
					@unlink($this->absolute_path.$this->general_dir."_".$data[0]['image_name_cms']);
				}
				if(file_exists($this->absolute_path.$this->general_dir."__".$data[0]['image_name_cms'])){
					@unlink($this->absolute_path.$this->general_dir."__".$data[0]['image_name_cms']);
				}
				$this->msg = "Record Deleted Successfully.";
				return true;
			}else{
				$this->msg = "Problem in deleting record, try again.";
				return false;
			}
		}
	}
	
	//  This function will delete multiple records cms only with image unlink
	  /*function delmultiCMS($tab = 'content_cms',$id = 'id_cms') 
	  {
		if(isset($_REQUEST['delet']))
		{
			
			foreach($_REQUEST['checkbox'] as $key=>$value)
			{
				$data = $this->getCMS(" content_cms where id_cms = ".$value);
				$childs = $this->getCMS(" content_cms where parent_cms = ".$value);
				if(is_array($childs)){
					return 2;
				}else{
				//echo $key.":".$value ."<br />";
					if($this->DeleteSetOfRecords($tab,$id,$value)){
						// link deletion
						$this->CustomModify("delete from link_lk where idtab_lk='".$value."' and table_lk='".$tab."'");
						
						@unlink($this->absolute_path.$this->general_dir.$data[0]['image_name_cms']);
					}
					return true;
				}// end if else
				
			}
			
			$this->msg="Record Deleted Successfully";
		}
		
		else
		{
			$this->msg = "Problem in deleting record, try again.";
			return false;
		}
	}// end function*/
	/////// some other general functions /////
	function getSingdet($query) 
	{
		$user = "select * from ".$query." ";
		$userdata = $this->CustomQuery($user);
		return $userdata;
	}
}
?>