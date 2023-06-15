<?
include_once($conf->absolute_path."classes/DBaccess.php");
class banner extends DBAccess 
{
	function banner()
	{
		$this->connectToDB();
	}
	function destroy_banner()
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
		$bannerdata = $this->CustomQuery("select * from ".$tab." where " .$id." = '".$val."' ");
		$link = $this->filterName($bannerdata[0][$name]);
	if($bannerdata[0][$parent]!=0){
		$parent1= $this->CustomQuery("select * from $tab where $id = ".$bannerdata[0][$parent]);
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
	
	///// function for banner insertion from adminpanel//////////////
	function insertBanner($urlfield='') // if no urlfield then do not create url	
	{
		$tab = 'banner_ban';
		$imgpath = $this->absolute_path.$this->banner_dir;		
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
			//$cmsurl = $this->filterName($_POST['pre_name_ban']);
			if($urlfield!=''){
				$bannerurl = $this->completeURL($tab,"id_ban",$recnum,$urlfield,"parent_ban");
			}
			
			if($bannerurl!=""){
				//insert into links table
				$inslink = "INSERT INTO link_lk(links_lk,table_lk,idtab_lk) values ('$bannerurl','$tab','$recnum')";
				$this->CustomModify($inslink);		
			}
			$this->msg = "Data added successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;			
		}
		
	}// end banner insertion function
	
	////////// function for banner updation from adminpanel//////////
	function updBanner($urlfield = '')
	{
		$tab = 'banner_ban';
		$rec = 'id_ban';
		$imgpath = $this->absolute_path.$this->banner_dir;
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
		$data = $this->getSingBanner($_GET['id']);
		//echo $this->absolute_path.$data[0]['url_ban'].".php"; die();	
		//final passing for updation
		$query = "update ".$tab." set ".$inserts."  where " .$rec. " =".$_GET['id'];
		
		if($rid2 = $this->CustomModify($query))
		{	
			//$bannerurl = $this->filterName($_POST['upd_name_ban']);
			if($urlfield!=''){
			$bannerurl = $this->completeURL($tab,"id_ban",$_GET['id'],$urlfield,"parent_ban");
			}
			if($bannerurl!=""){
				//links table updation
				// check in database if there is same link as that new generated	
				$linkcheck = $this->getSingdet(" link_lk where links_lk = '$bannerurl' and table_lk = '$tab' and idtab_lk != ".$_GET['id']);
				if(is_array($linkcheck)){
					$bannerurl = $bannerurl.rand(1,10);
					$newlinkcheck = $this->getSingdet(" link_lk where links_lk = '$bannerurl' ");
					if(is_array($newlinkcheck)){
						$bannerurl = $bannerurl.rand(10,20);
					}
				}
				
				// now look for url of current banner
				$linkexists = $this->getSingdet(" link_lk where idtab_lk = ".$_GET['id']." and table_lk = '$tab'");
				
				if(is_array($linkexists)){
					$this->CustomModify(" UPDATE link_lk SET  links_lk = '$bannerurl' where id_lk = '".$linkexists[0]['id_lk']."'");					
				}else{
					$inslink = "INSERT INTO link_lk(links_lk,table_lk,idtab_lk) values ('$bannerurl','$tab','".$_GET['id']."')";
					$this->CustomModify($inslink);
				}
			}
			
			/*if(file_exists($this->absolute_path.$data[0]['url_ban'].".php")){
				rename($this->absolute_path.$data[0]['url_ban'].".php", $this->absolute_path.$cmsurl.".php");
			}*/
			
			$this->msg = "Data updated successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	}// end update banner function
	
	// banner sorting function //
	function sortBanners($table = 'banner_ban',$ordcol = 'order_ban',$idcol = 'id_ban')
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
	
	function BannerStatus($status,$bannerid){
		$qry= "UPDATE banner_ban set status_ban='$status' where id_ban = '$bannerid'";
		$this->CustomModify($qry);
	}
	
	
	/// get banner by origin without pagination
	function getBannerbyOrigin($origin = 'banner')
	  {
		 $sql = "select * from banner_ban where origin_ban = '".$origin."' ";
		if($data = $this->CustomQuery($sql))
	   		return $data;
		else
		    {
			  $this->msg= "No data found.";
			  return false;
		    }
	  }// end get banner function
	
	
	/// get banner without pagination
	function getbanner($query)
	  {
		 $sql = "select * from ".$query." ";
		if($data = $this->CustomQuery($sql))
	   		return $data;
		else
		    {
			  $this->msg= "No data found.";
			  return false;
		    }
	  }// end get banner function
	  
	  /// get banner without pagination
	function getSingBanner($bannerid)
	  {
		 $sql = " select * from banner_ban where id_ban = '$bannerid'";
		if($data = $this->CustomQuery($sql))
	   		return $data;
		else
		    {
			  $this->msg= "No data found.";
			  return false;
		    }
	  }// end get banner function
	
	///// get banner with pagination 15 per page ////////////
	function Getbannerpaginate($query) // This Functio get the paginated data
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
	
	//this function delete single record banner only with image unlink///
	function delBanner($tab = 'banner_ban') 
	{
		$data = $this->getbanner(" banner_ban where id_ban = ".$_GET['id']);
		if($this->DeleteSetOfRecords($tab,"id_ban",$_GET['id']))
		{
			// link deletion
			$this->CustomModify("delete from link_lk where idtab_lk='".$_GET['id']."' and table_lk='".$tab."'");
			
			@unlink($this->absolute_path.$this->banner_dir.$data[0]['image_name_ban']);
			$this->msg = "Record Deleted Successfully.";
			return true;
		}else{
			$this->msg = "Problem in deleting record, try again.";
			return false;
		}
	}// end function
	
	
	//  This function will delete multiple records banner with image unlink and link deletion
	function delmultiBanners($tab = 'banner_ban') 
	{
		$data = $this->getbanner(" $tab where id_ban = ".$_REQUEST['checkbox']);
		$childs = $this->getbanner(" $tab where parent_ban = ".$_REQUEST['checkbox']);
		if(is_array($childs)){
			$this->msg = "Can not delete, Please Delete its child records first.";
			return 2;
		}else{			
			if($this->DeleteSetOfRecords($tab,"id_ban",$_REQUEST['checkbox']))
			{			
				// link deletion
				$this->CustomModify("delete from link_lk where idtab_lk='".$_REQUEST['checkbox']."' and table_lk='".$tab."'");
				
				@unlink($this->absolute_path.$this->banner_dir.$data[0]['image_name_ban']);
				$this->msg = "Record Deleted Successfully.";
				return true;
			}else{
				$this->msg = "Problem in deleting record, try again.";
				return false;
			}
		}
	}
	  /*function delmultiBanners($tab = 'banner_ban',$id = 'id_ban') 
	  {
		if(isset($_POST['delete']))
		{
			
			foreach($_POST['checkbox'] as $key=>$value)
			{
				$data = $this->getbanner(" banner_ban where id_ban = ".$value);
				//echo $key.":".$value ."<br />";
			   	if($this->DeleteSetOfRecords($tab,$id,$value)){
					// link deletion
					$this->CustomModify("delete from link_lk where idtab_lk='".$value."' and table_lk='".$tab."'");
					
					@unlink($this->absolute_path.$this->banner_dir.$data[0]['image_name_ban']);
				}
				
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