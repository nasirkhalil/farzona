<?
include_once($conf->absolute_path."classes/DBaccess.php");
class general extends DBAccess 
{
	function __construct()
	{
		$this->connectToDB();
	}
	
	function destroy_product()
	{
		$this->DBDisconnect();
	}

	function getAll($query)
	  { 
		 $sql = "select * from ".$query." ";
		if($data = $this->CustomQuery($sql))
	   		return $data;
		else
		    {
			  $this->msg= "No data found.";
			  return false;
		    }
	  }
	  public function test(){
		die("<h1>testabc</h1>");
	}
	
	function getChildDet() 
	{
		$sear="";
		if($_POST['cat'] != '')
			$sear=  " and parent = ".$_POST['cat']." ";
		
		$user = "select * from cmschild where 1  $sear order by name asc ";
		$userdata = $this->CustomQuery($user);
		return $userdata;
	}
	
	function getParentDet() 
	{
		$user = "select * from cmschild where parent=0  order by name asc ";
		$userdata = $this->CustomQuery($user);
		return $userdata;
	}
	
	
	
	function getSingdet($query) 
	{
		$user = "select * from ".$query." ";
		$userdata = $this->CustomQuery($user);
		return $userdata;
	}
	
	
	
	function updProduct($tab,$id,$name,$parent,$imgpath)
	{
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
				$user = "select * from ".$tab." where " .$id." = ".$_GET['id'];
			 
				$userdata = $this->CustomQuery($user);
				
				
				
				if($userdata[0][$txtname] != '' and file_exists($imgpath.$userdata[0][$txtname]))
				{
					@unlink($imgpath.$userdata[0][$txtname]);
				
				}
				
				//upload new image
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$imgpath,$this->upload_size_allowed);
				$path_product_image = $imgpath.$product_image;
				$thumbnil_image =$imgpath."_".$product_image;
				createsmallthumb($path_product_image,$thumbnil_image,$this->smallThumbnailWidth,$this->smallThumbnailHeight);
				$thumbnil_image1 =$imgpath."__".$product_image;
				createsmallthumb($path_product_image,$thumbnil_image1,$this->ThumbnailWidth,$this->ThumbnailHeight);
				$thumbnil_image2 =$imgpath."___".$product_image;
				createsmallthumb($path_product_image,$thumbnil_image2,$this->mediumThumbnailWidth,$this->mediumThumbnailHeight);
				//add to insert query
				$inserts .=$txtname."='".$product_image."' ,";		
			}
					
		}
		
		
		//removing last character comma
		$inserts = rtrim($inserts,",");
		$data = $this->getSingdet("link_lk where idtab_lk = ".$_GET['id']." and table_lk = '$tab'");		
		//final passing for updation
		$query = "update ".$tab." set ".$inserts."  where " .$id. " =".$_GET['id'];
		//echo $_GET['id']; die();
		
		
		if($rid2 = $this->CustomModify($query))
		{
			//echo $query; die();
			//$this->DeleteSetofRecords("product_images_prdimg","idprd_prdimg",$_GET['id']);
			//$dq="delete from product_images_prdimg where idprd_prdimg=".$_GET['id'];
			//$this->CustomModify($dq);
			$inserts2 = "";
			$vals2 = "";
			
					//insert images
		/*for($i=0;$i<count($_POST['modpics']);$i++)
			   
	   {
				 //$key = str_replace("pre2_","",$key);
			$inserts2 .= "idprd_prdimg,";
			$vals2 .= $_GET['id'];
			$inserts2 .= "name_prdimg,";
			$vals2 .= ",'".$_POST['modpics'][$i]."',";
			$inserts2 .= "alt_prdimg,";
			$vals2 .= "'".$_POST['alt'][$i]."',";
			$inserts2 .= "title_prdimg,";
			$vals2 .= "'".$_POST['title'][$i]."',";
			$inserts2 .= "order_prdimg,";
			$vals2 .= "'".$_POST['order'][$i]."',";
			//removing last character comma
			$inserts2 = rtrim($inserts2,",");
			$vals2 = rtrim($vals2,",");
			$recnum12=$this->InsertRecord("product_images_prdimg",$inserts2,$vals2); 
			$inserts2 = "";
			$vals2 = "";
			}
			*/
			
			
			//$this->msg = "Data updated successfully.";
			//return true;
		
			
			//update its url
			
			//$cmsurl = $this->filterName($_POST['pre_name_cms']);
			$cmsurl = $this->completeURL($tab,$id,$_GET['id'],$name,$parent);
			
			if($tab=="product_prd"){
				
				//echo " link_lk where idtab_lk = ".$_POST['upd_idcat_prd']." and table_lk = 'category_cat'";
				$caturl = $this->getSingdet(" link_lk where idtab_lk = 3 and table_lk = 'content_cms'");	
				$caturl2=$caturl[0]['links_lk'];
			
				$cmsurl = $caturl2."/".$cmsurl;
			}
			//echo $cmsurl; die();
			 // $cmsurl = $this->completeURL("category_cat","id_cat",$_POST['upd_idcat_prd'],"name_cat","parent_cat");
			 // $cmsurl.="/".$this->filterName($_POST['upd_name_prd']);
			//$updqry = $this->CustomModify("update $tab set $url = '".$cmsurl."' where $id = '".$recnum."'");
			//links table updation	
			 $this->CustomModify("UPDATE link_lk SET  links_lk = '$cmsurl' where id_lk = '".$data[0]['id_lk']."'"); 
					
			$this->msg = "Data updated successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}	
	}
	function getSubCats($cat_id)
	{
		$user="select * from category_cat where parent_cat='".$cat_id."'";
		$userdata= $this-> CustomQuery($user);
		return $userdata;
	}// end function
	
	///insert news
	function insertNews($tab,$id,$name,$parent,$imgpath)
	{
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
				$path_product_image = $imgpath.$product_image;
				$thumbnil_image =$imgpath."_".$product_image;
				createsmallthumb($path_product_image,$thumbnil_image,$this->largeThumbnailWidth,$this->largeThumbnailHeight);
				$thumbnil_image1 =$imgpath."__".$product_image;
				createsmallthumb($path_product_image,$thumbnil_image1,$this->smallThumbnailWidth,$this->smallThumbnailHeight);
					
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
			
			$cmsurl = $this->completeURL($tab,$id,$recnum,$name,$parent);
			if($tab=="news_nws"){
				$plink=$this->getAll("content_cms where id_cms=11");
				$cmsurl = $this->filterName($plink[0]['name_cms'])."/".$cmsurl;
			}
			//$updqry = $this->CustomModify("update $tab set $url = '".$cmsurl."' where $id = '".$recnum."'");
			//$cmsurl="news-listing/".$temp;
			//insert into links table
			if($cmsurl!=""){
				
			$inslink = "INSERT INTO link_lk(links_lk,table_lk,idtab_lk) values ('$cmsurl','$tab','$recnum')";
			$this->CustomModify($inslink);
			}
			$this->msg = "Data added successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	}
	//update news
	function updNews($tab,$id,$name,$parent,$imgpath)
	{
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
				$user = "select * from ".$tab." where " .$id." = ".$_GET['id'];
			 
				$userdata = $this->CustomQuery($user);
				
				
				
				if($userdata[0][$txtname] != '' and file_exists($imgpath.$userdata[0][$txtname]))
				{
					@unlink($imgpath.$userdata[0][$txtname]);
				
				}
				
				//upload new image
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$imgpath,$this->upload_size_allowed);
				$path_product_image = $imgpath.$product_image;
				$thumbnil_image =$imgpath."_".$product_image;
				createsmallthumb($path_product_image,$thumbnil_image,$this->largeThumbnailWidth,$this->largeThumbnailHeight);
				$thumbnil_image1 =$imgpath."__".$product_image;
				createsmallthumb($path_product_image,$thumbnil_image1,$this->smallThumbnailWidth,$this->smallThumbnailHeight);
				//add to insert query
				$inserts .=$txtname."='".$product_image."' ,";	
			}
					
		}
		//removing last character comma
		$inserts = rtrim($inserts,",");
		$data = $this->getSingdet(" link_lk where idtab_lk = ".$_GET['id']." and table_lk = '$tab'");		
		//final passing for updation
	$query = "update ".$tab." set ".$inserts."  where " .$id. " =".$_GET['id'];
	//die();
		
		if($rid2 = $this->CustomModify($query))
		{
			//update its url
			//$cmsurl = $this->filterName($_POST['pre_name_cms']);
			
			$cmsurl = $this->completeURL($tab,$id,$_GET['id'],$name,$parent);
			
			if($tab=="news_nws"){
				$plink=$this->getAll("content_cms where id_cms=11");
				$cmsurl = $this->filterName($plink[0]['name_cms'])."/".$cmsurl;
			}
			//links table updation	
			$this->CustomModify("UPDATE link_lk SET  links_lk = '$cmsurl' where id_lk = '".$data[0]['id_lk']."'");
					
			$this->msg = "Data updated successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}	
	}
	
	
	// adminpanel insertion function
	function insertDetailsAdmin($params)
	{  
		foreach($params as $k=>$v){
			 $$k = $v;
		}
		
		//die($parent);
		$inserts="";
		$vals = "";	
		//arranging values of POST only
		foreach($_REQUEST as $key=>$value) {
			if(strstr($key,'_details')==""){
			$value = addslashes($value);
			}
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
				
				//if(strstr($key,"image_name")!=""){
					if($thumb!=0){
						$path_product_image = $imgpath.$product_image;
						$thumbnail_image = $imgpath."_".$product_image;
						
							// Resize image (options: exact, portrait, landscape, auto, crop)
						resizeImage($path_product_image,$thumbWidth, $thumbHeight, 'crop');
							// Save image
						saveImage($thumbnail_image, 100);
						
					}
				//}
				if($thumb2!=0){
					$path_product_image = $imgpath.$product_image;
					$thumbnail_image = $imgpath."_".$product_image;
					
					// Resize image (options: exact, portrait, landscape, auto, crop)
			 		resizeImage($path_product_image,$thumb2Width, $thumb2Height, 'crop');
					// Save image
					saveImage($thumbnail_image, 100);
				}
					
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
			$cmsurl = $this->filterName($_POST['pre_'.$urlfield]);
	 
			//echo $tab.$id.$recnum.$urlfield.$parent;die();
			if($parenttab==""){
			$cmsurl = $this->completeURL($tab,$id,$recnum,$urlfield,$parent);
			//echo $cmsurl; 
			}
			 //die($cmsurl);
			if($parenttab!=''){
				if($parenttabid!=0){
					$condition = " idtab_lk = $parenttabid ";
				}else{
					$condition = " idtab_lk = ".$_POST['pre_'.$parent];
				}
				$parlink = $this->getSingdet("link_lk where table_lk = '$parenttab' and $condition ");
				$cmsurl = $parlink[0]['links_lk']."/".$cmsurl;
			}
			//echo $cmsurl; die();
				$cmsurl = str_replace("//","/",$cmsurl);
			//insert into links table
			if($cmsurl!=""){
				$inslink = "INSERT INTO link_lk(links_lk,table_lk,idtab_lk) values ('$cmsurl','$tab','$recnum')";
				$this->CustomModify($inslink);
			}
			if( $tab == "product_prd" && $_REQUEST['pre_size_id'] > 0 ){
				$this->addProductSize($recnum,$_REQUEST['pre_size_id']);
			}
			$this->msg = "Data added successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	}
	function addProductSize($product_id,$size_id){
		$post_size = $_POST['product_qty'];
		// echo "<pre>"; print_r($post_size); die;
		$data = $this->getAll("size_details WHERE size_id =".$size_id);
		if( is_array($data) && count($data) > 0 ){
			foreach($data as $key => $row){
				$quantity = ($post_size[$row['id']]) ? $post_size[$row['id']] : 0;
			   $q = "INSERT INTO product_sizes(product_id,size_id,size_detail_id,available_quantity) VALUES($product_id,$size_id,".$row['id'].",$quantity)";
			   $this->CustomModify($q);
			}
		}
	}
	
	// adminpanel updation function
	function updDetailsAdmin($params)
	{
		// print_r($_POST); die("after die");
		if(!isset($_POST['button']))
	   {
		  
		return false;
	   }
	   foreach($params as $k=>$v){
			 $$k = $v;
		}
		//die($parent);
		$inserts="";
		//arranging values of POST only
		
		foreach($_POST as $key=>$value) {
			if(strstr($key,'_details')=="" && strstr($key,'_email_header')=="" ){
			$value = addslashes($value);
			}
			//$value = mysqli_real_escape_string($this->DBlink,$value);

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
				$user = "select * from ".$tab." where " .$id." = ".$_GET['id'];
			 
				$userdata = $this->CustomQuery($user);
				
				
				
				if($userdata[0][$txtname] != '' and file_exists($imgpath.$userdata[0][$txtname]))
				{
					@unlink($imgpath.$userdata[0][$txtname]);
					if(file_exists($imgpath."_".$userdata[0][$txtname])){
						@unlink($imgpath."_".$userdata[0][$txtname]);
					}
					if(file_exists($imgpath."__".$userdata[0][$txtname])){
						@unlink($imgpath."__".$userdata[0][$txtname]);
					}					
				
				}
				
				//upload new image
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$imgpath,$this->upload_size_allowed);
				//if(strstr($key,"image_name")!=""){
					if($thumb!=0){
						$path_product_image = $imgpath.$product_image;
						$thumbnail_image = $imgpath."_".$product_image;
						
							// Resize image (options: exact, portrait, landscape, auto, crop)
						resizeImage($path_product_image,$thumbWidth, $thumbHeight, 'crop');
								// Save image
						saveImage($thumbnail_image, 100);
					
					}
				//}
				
				if($thumb2!=0){
					$path_product_image = $imgpath.$product_image;
					$thumbnail_image = $imgpath."_".$product_image;
					// Resize image (options: exact, portrait, landscape, auto, crop)
			 		resizeImage($path_product_image,$thumb2Width, $thumb2Height, 'crop');
					// Save image
					saveImage($thumbnail_image, 100);
				}
				
				$inserts .=$txtname."='".$product_image."' ,";	
			}
					
		}
		//removing last character comma
		$inserts = rtrim($inserts,",");
		$data = $this->getSingdet(" link_lk where idtab_lk = ".$_GET['id']." and table_lk = '$tab'");		
		//final passing for updation
		 $query = "update ".$tab." set ".$inserts."  where " .$id. " =".$_GET['id'];
		
		// die($query);
		
		if($rid2 = $this->CustomModify($query))
		{
			
			
			
			
			
			
			//update its url
			$cmsurl = $this->filterName($_POST['upd_'.$urlfield]);
			//echo $parent; die();
			if($parenttab==""){
			$cmsurl = $this->completeURL($tab,$id,$_GET['id'],$urlfield,$parent);
			}
			if($parenttab!=''){
				
				if($parenttabid!=0){
					$condition = " idtab_lk = $parenttabid ";
				}else{
					$condition = " idtab_lk = ".$_POST['upd_'.$parent];
				}
				$parlink = $this->getSingdet("link_lk where table_lk = '$parenttab' and $condition ");
				$cmsurl = $parlink[0]['links_lk']."/".$cmsurl;
			}
			
				$cmsurl = str_replace("//","/",$cmsurl);
			//echo $cmsurl; die();
			
			//links table updation
			// first check in database if there is same link as that new generated	
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
			if($cmsurl!=""){	
				if(is_array($linkexists)){
					$this->CustomModify(" UPDATE link_lk SET  links_lk = '$cmsurl' where id_lk = '".$linkexists[0]['id_lk']."'");					
				}else{
					
					$inslink = "INSERT INTO link_lk(links_lk,table_lk,idtab_lk) values ('$cmsurl','$tab','".$_GET['id']."')";
					$this->CustomModify($inslink);
				}
			}
				
			$this->msg = "Data updated successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}	
	}
	
	function updtyrename($params)
	{
		//print_r($_POST); die();
		if(!isset($_POST['button']))
	   {
		  
		return false;
	   }
	   foreach($params as $k=>$v){
			 $$k = $v;
		}
		//die($parent);
		$inserts="";
		//arranging values of POST only
		
		foreach($_POST as $key=>$value) {
			if(strstr($key,'_details')=="" && strstr($key,'_email_header')=="" ){
			$value = addslashes($value);
			}
			//$value = mysqli_real_escape_string($this->DBlink,$value);

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
				$user = "select * from ".$tab." where " .$id." = ".$_GET['id'];
			 
				$userdata = $this->CustomQuery($user);
				
				
				
				if($userdata[0][$txtname] != '' and file_exists($imgpath.$userdata[0][$txtname]))
				{
					@unlink($imgpath.$userdata[0][$txtname]);
					if(file_exists($imgpath."_".$userdata[0][$txtname])){
						@unlink($imgpath."_".$userdata[0][$txtname]);
					}
					if(file_exists($imgpath."__".$userdata[0][$txtname])){
						@unlink($imgpath."__".$userdata[0][$txtname]);
					}					
				
				}
				
				//upload new image
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$imgpath,$this->upload_size_allowed);
				
					if($thumb!=0){
						$path_product_image = $imgpath.$product_image;
						$thumbnail_image = $imgpath."_".$product_image;
						
							// Resize image (options: exact, portrait, landscape, auto, crop)
						resizeImage($path_product_image,$thumbWidth, $thumbHeight, 'crop');
								// Save image
						saveImage($thumbnail_image, 100);
					
					}
				
				
				$inserts .=$txtname."='".$product_image."' ,";	
			}
					
		}
		//removing last character comma
		$inserts = rtrim($inserts,",");
		//$data = $this->getSingdet(" link_lk where idtab_lk = ".$_GET['id']." and table_lk = '$tab'");		
		//final passing for updation
		 $query = "update ".$tab." set ".$inserts."  where " .$id. " =".$_GET['id'];
	 
		//die($query);
		
		if($rid2 = $this->CustomModify($query))
		{
			
				
			$this->msg = "Data updated successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}	
	}
	
	function insertProductAdmin($params)
	{
		foreach($params as $k=>$v){
			 $$k = $v;
		}
		
		//die($parent);
		$inserts="";
		$vals = "";	
		//arranging values of POST only
		foreach($_REQUEST as $key=>$value) {
			if(strstr($key,'_details')==""){
			$value = addslashes($value);
			}
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
				
				if(strstr($key,"image_name")!=""){
					if($thumb!=0){
						$path_product_image = $imgpath.$product_image;
						$thumbnail_image = $imgpath."_".$product_image;
						
							// Resize image (options: exact, portrait, landscape, auto, crop)
						resizeImage($path_product_image,$thumbWidth, $thumbHeight, 'crop');
							// Save image
						saveImage($thumbnail_image, 100);
						
					}
				}
				if($thumb2!=0){
					$path_product_image = $imgpath.$product_image;
					$thumbnail_image = $imgpath."_".$product_image;
					
					// Resize image (options: exact, portrait, landscape, auto, crop)
			 		resizeImage($path_product_image,$thumb2Width, $thumb2Height, 'crop');
					// Save image
					saveImage($thumbnail_image, 100);
				}
					
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
			for($k1=0; $k1<$_POST['countforphp']; $k1++){
					if($_POST['lowerprice'][$k1]=='' && $_POST['higherprice'][$k1]=='' && $_POST['pricevalue'][$k1]=='' )
					continue;
					//main table entry
					$inserts1="";
					$valu1="";
					$inserts1="idprd_prdprice, lower_range_prdprice, higher_range_prdprice, price_prdprice";
					$valu1=$recnum.", '".$_POST['lowerprice'][$k1]."', '".$_POST['higherprice'][$k1]."', '".$_POST['pricevalue'][$k1]."'";
					$sizenum=$this->InsertRecord("product_prices_prdprice",$inserts1,$valu1);
					
			}
			
			if($_POST['pre_id_faml_prd']!='' || $_POST['pre_id_faml_prd']!=0)
			{
				$fprods=$this->getall("product_prd where id_faml_prd = ".$_POST['pre_id_faml_prd']);
				//print_r($fprods); die();
				if($fprods!=""){
	
				$price='';
				for($j=0; $j<count($fprods); $j++)
				{
					$price.=$fprods[$j]['id_prd'].",";
				}
	
				$price = rtrim($price,",");
				$minprice =$this->CustomQuery( "select min(price_prd) from product_prd where id_prd in( ".$price." ) ");
				$this->CustomModify("update family_faml set price_faml = ".$minprice[0]['min(price_prd)']." where id_faml=".$_POST['pre_id_faml_prd']);
				}else{
				$minprice[0]['min(price_prd)']=0;	
				}
			}
		
			//update its url
			$cmsurl = $this->filterName($_POST['pre_'.$urlfield]);
	 
			//echo $tab.$id.$recnum.$urlfield.$parent;die();
			if($parenttab==""){
			$cmsurl = $this->completeURL($tab,$id,$recnum,$urlfield,$parent);
			//echo $cmsurl; 
			}
			 //die($cmsurl);
			if($parenttab!=''){
				if($parenttabid!=0){
					$condition = " idtab_lk = $parenttabid ";
				}else{
					$condition = " idtab_lk = ".$_POST['pre_'.$parent];
				}
				$parlink = $this->getSingdet("link_lk where table_lk = '$parenttab' and $condition ");
				$cmsurl = $parlink[0]['links_lk']."/".$cmsurl;
			}
			//echo $cmsurl; die();
				$cmsurl = str_replace("//","/",$cmsurl);
			//insert into links table
			if($cmsurl!=""){
				$inslink = "INSERT INTO link_lk(links_lk,table_lk,idtab_lk) values ('$cmsurl','$tab','$recnum')";
				$this->CustomModify($inslink);
			}
			
			
			
			$this->msg = "Data added successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	}
	
	// adminpanel updation function
	function updProductAdmin($params)
	{
		//print_r($_POST); die();
		if(!isset($_POST['button']))
	   {
		  
		return false;
	   }
	   foreach($params as $k=>$v){
			 $$k = $v;
		}
		//die($parent);
		$inserts="";
		//arranging values of POST only
		
		foreach($_POST as $key=>$value) {
			if(strstr($key,'_details')=="" && strstr($key,'_email_header')=="" ){
			$value = addslashes($value);
			}
			//$value = mysqli_real_escape_string($this->DBlink,$value);

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
				$user = "select * from ".$tab." where " .$id." = ".$_GET['id'];
			 
				$userdata = $this->CustomQuery($user);
				
				
				
				if($userdata[0][$txtname] != '' and file_exists($imgpath.$userdata[0][$txtname]))
				{
					@unlink($imgpath.$userdata[0][$txtname]);
					if(file_exists($imgpath."_".$userdata[0][$txtname])){
						@unlink($imgpath."_".$userdata[0][$txtname]);
					}
					if(file_exists($imgpath."__".$userdata[0][$txtname])){
						@unlink($imgpath."__".$userdata[0][$txtname]);
					}					
				
				}
				
				//upload new image
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$imgpath,$this->upload_size_allowed);
				if(strstr($key,"image_name")!=""){
					if($thumb!=0){
						$path_product_image = $imgpath.$product_image;
						$thumbnail_image = $imgpath."_".$product_image;
						
							// Resize image (options: exact, portrait, landscape, auto, crop)
						resizeImage($path_product_image,$thumbWidth, $thumbHeight, 'crop');
								// Save image
						saveImage($thumbnail_image, 100);
					
					}
				}
				
				if($thumb2!=0){
					$path_product_image = $imgpath.$product_image;
					$thumbnail_image = $imgpath."_".$product_image;
					// Resize image (options: exact, portrait, landscape, auto, crop)
			 		resizeImage($path_product_image,$thumb2Width, $thumb2Height, 'crop');
					// Save image
					saveImage($thumbnail_image, 100);
				}
				
				$inserts .=$txtname."='".$product_image."' ,";	
			}
					
		}
		//removing last character comma
		$inserts = rtrim($inserts,",");
		$data = $this->getSingdet(" link_lk where idtab_lk = ".$_GET['id']." and table_lk = '$tab'");		
		//final passing for updation
		 $query = "update ".$tab." set ".$inserts."  where " .$id. " =".$_GET['id'];
	 
		//die($query);
		
		if($rid2 = $this->CustomModify($query))
		{
			
			if(isset($_POST['countforphp'])){
			$recnum=$_GET['id'];
		   $this->DeleteSetOfRecords("product_prices_prdprice","idprd_prdprice",$_GET['id']);

			for($k1=0; $k1<$_POST['countforphp']; $k1++){
				if($_POST['lowerprice'][$k1]=='' || $_POST['higherprice'][$k1]=='' || $_POST['pricevalue'][$k1]=='' )
					continue;	
					//main table entry
					$inserts1="";
					$valu1="";
					$inserts1="idprd_prdprice, lower_range_prdprice, higher_range_prdprice, price_prdprice";
					$valu1=$recnum.", '".$_POST['lowerprice'][$k1]."', '".$_POST['higherprice'][$k1]."', '".$_POST['pricevalue'][$k1]."'";
					$sizenum=$this->InsertRecord("product_prices_prdprice",$inserts1,$valu1);
					
			}
		}
		if($_POST['upd_id_faml_prd']!='' || $_POST['upd_id_faml_prd']!=0)
			{
				$fprods=$this->getall("product_prd where id_faml_prd = ".$_POST['upd_id_faml_prd']);
				//print_r($fprods); die();
				if($fprods!=""){
	
				$price='';
				for($j=0; $j<count($fprods); $j++)
				{
					$price.=$fprods[$j]['id_prd'].",";
				}
	
				$price = rtrim($price,",");
				$minprice =$this->CustomQuery( "select min(price_prd) from product_prd where id_prd in( ".$price." ) ");
				$this->CustomModify("update family_faml set price_faml = ".$minprice[0]['min(price_prd)']." where id_faml=".$_POST['upd_id_faml_prd']);
				}else{
				$minprice[0]['min(price_prd)']=0;	
				}
			}
			
			
			
			
			//update its url
			$cmsurl = $this->filterName($_POST['upd_'.$urlfield]);
			//echo $parent; die();
			if($parenttab==""){
			$cmsurl = $this->completeURL($tab,$id,$_GET['id'],$urlfield,$parent);
			}
			if($parenttab!=''){
				
				if($parenttabid!=0){
					$condition = " idtab_lk = $parenttabid ";
				}else{
					$condition = " idtab_lk = ".$_POST['upd_'.$parent];
				}
				$parlink = $this->getSingdet("link_lk where table_lk = '$parenttab' and $condition ");
				$cmsurl = $parlink[0]['links_lk']."/".$cmsurl;
			}
			
				$cmsurl = str_replace("//","/",$cmsurl);
			//echo $cmsurl; die();
			
			//links table updation
			// first check in database if there is same link as that new generated	
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
			if($cmsurl!=""){	
				if(is_array($linkexists)){
					$this->CustomModify(" UPDATE link_lk SET  links_lk = '$cmsurl' where id_lk = '".$linkexists[0]['id_lk']."'");					
				}else{
					
					$inslink = "INSERT INTO link_lk(links_lk,table_lk,idtab_lk) values ('$cmsurl','$tab','".$_GET['id']."')";
					$this->CustomModify($inslink);
				}
			}
				
			$this->msg = "Data updated successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}	
	}
	
	
	
	//name filter function
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
	
	function emailvalidate($email) {

	list($local, $domain) = explode("@", $email);
	
	$pattern_local = '^([0-9a-z]*([-|_]?[0-9a-z]+)*)(([-|_]?)\.([-|_]?)[0-9a-z]*([-|_]?[0-9a-z]+)+)*([-|_]?)$';
	
	$pattern_domain = '^([0-9a-z]+([-]?[0-9a-z]+)*)(([-]?)\.([-]?)[0-9a-z]*([-]?[0-9a-z]+)+)*\.[a-z]{2,4}$';
	
	$match_local = eregi($pattern_local, $local);
	
	$match_domain = eregi($pattern_domain, $domain);
	
	if ($match_local && $match_domain) {
		
		//if valid email then
		return 1;
	} else {
	//if not valid email
		return 0;
	}
	
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
						}/*elseif(strstr($key,"contact")){
						if (empty($value))
						{
							$_SESSION['not_valid']['msg'] = $key." is Required";
							return false;
						}
						else
						{
							$name = $this->test_input($value);
							// check if name only contains letters and whitespace
							if (!preg_match("/^[0-9]*$/",$name))
							{
								$_SESSION['not_valid']['msg'] = "Only Numbers are allowed in ".$key;
								return false;
							}
						}
						}*/
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
							if (!preg_match("/^[a-zA-Z0-9+-@_ ]*$/",$name))
							{
								$_SESSION['not_valid']['msg'] = "Only letters,+,-,_,@ sign and white spaces allowed in ".$key;
								return false;
							}
						}
					}
					return true;
	}
	
	
	
		function insertDetails2($tab)
	{ 
		$inserts="";
		$vals = "";	
		//arranging values of POST only
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
				$product_image=nowDirectImage($key,$this->absolute_path.$this->general_dir,$this->upload_size_allowed);
					
			}
					
			//add to insert query
			$txtname=substr($key,4);
			$inserts .=$txtname.",";
			$vals .= "'".mysqli_real_escape_string($this->DBlink,$product_image)."',";
		}
		//removing last character comma
		$inserts = rtrim($inserts,",");
		$vals = rtrim($vals,",");
		//final passing for insertion
//
		if($recnum=$this->InsertRecord($tab,$inserts,$vals))
		{ //echo "sareer1"; die();
			
			//$this->CustomModify(" update $tab set contactyou_enq = '$interested' where id_enq = ".$recnum);		
			$this->msg = "Data added successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	}
	
	
	
	//This function insert Details
	function insertDetails($tab,$imgpath)
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
				$product_image=nowDirectImage($key,$imgpath,$this->upload_size_allowed);
				$path_product_image = $imgpath.$product_image;
				$thumbnil_image =$imgpath."_".$product_image;
				createsmallthumb($path_product_image,$thumbnil_image,133,73);
				//$thumbnil_image1 =$imgpath."__".$product_image;
				//createsmallthumb($path_product_image,$thumbnil_image1,$this->smallThumbnailWidth,$this->smallThumbnailHeight);
					
			}
					
			//add to insert query
			$txtname=substr($key,4);
			$inserts .=$txtname.",";
			$vals .= "'".mysqli_real_escape_string($this->DBlink,$product_image)."',";
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
		
	}
	
	function updDetails($tab,$rec,$imgpath)
	{
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
				$user = "select * from ".$tab." where " .$rec." = ".mysqli_real_escape_string($this->DBlink,$_GET['id']);
			 
				$userdata = $this->CustomQuery($user);
				
				
				/*		
				createthumb($path_product_image,$thumbnil_image,$this->thumbnailWidth,$this->thumbnailHeight);
				createthumb($path_product_image,$thumbnil_image_,$this->mainImageWidth,$this->mainImageHeight);*/
				if($userdata[0][$txtname] != '' and file_exists($imgpath.$userdata[0][$txtname]))
				{
					@unlink($this->absolute_path.$this->general_dir.$userdata[0][$txtname]);
					@unlink($this->absolute_path.$this->general_dir."_".$userdata[0][$txtname]);
					@unlink($this->absolute_path.$this->general_dir."__".$userdata[0][$txtname]);
					
				}
				
				//upload new image
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$imgpath,$this->upload_size_allowed);
				$path_product_image = $imgpath.$product_image;
				$thumbnil_image =$imgpath."_".$product_image;
				createsmallthumb($path_product_image,$thumbnil_image,133,73);
				//add to insert query
				$inserts .=$txtname."='".mysqli_real_escape_string($this->DBlink,$product_image)."' ,";	
			}
					
		}
		//removing last character comma
		$inserts = rtrim($inserts,",");		
		//final passing for updation
		 $query = "update ".$tab." set ".$inserts."  where " .$rec. " =".mysqli_real_escape_string($this->DBlink,$_GET['id']);
		
		if($rid2 = $this->CustomModify($query))
		{		
			$this->msg = "Data updated successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	}
	
	///update file
	function updFile($tab,$rec,$imgpath)
	{
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
				$user = "select * from ".$tab." where " .$rec." = ".mysqli_real_escape_string($this->DBlink,$_GET['id']);
			 
				$userdata = $this->CustomQuery($user);
				
				
				/*		
				createthumb($path_product_image,$thumbnil_image,$this->thumbnailWidth,$this->thumbnailHeight);
				createthumb($path_product_image,$thumbnil_image_,$this->mainImageWidth,$this->mainImageHeight);*/
				if($userdata[0][$txtname] != '' and file_exists($imgpath.$userdata[0][$txtname]))
				{
					@unlink($this->absolute_path.$this->general_dir.$userdata[0][$txtname]);
					@unlink($this->absolute_path.$this->general_dir."_".$userdata[0][$txtname]);
					@unlink($this->absolute_path.$this->general_dir."__".$userdata[0][$txtname]);
					
				}
				
				//upload new image
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$imgpath,$this->upload_size_allowed);
				
				//add to insert query
				$inserts .=$txtname."='".mysqli_real_escape_string($this->DBlink,$product_image)."' ,";	
			}
					
		}
		//removing last character comma
		$inserts = rtrim($inserts,",");		
		//final passing for updation
		 $query = "update ".$tab." set ".$inserts."  where " .$rec. " =".mysqli_real_escape_string($this->DBlink,$_GET['id']);
		
		if($rid2 = $this->CustomModify($query))
		{		
			$this->msg = "Data updated successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	}
	
	//general deletion function with image unlink///
	function delGenDetails($tab,$colid,$imgpath,$fieldsarr) 
	{
		$data = $this->getSingdet($tab." where ".$colid." = ".$_GET['id']);
		if($this->DeleteSetOfRecords($tab,$colid,$_GET['id']))
		{
			// link deletion
			$this->CustomModify("delete from link_lk where idtab_lk='".$_GET['id']."'  and table_lk='".$tab."'");
			
			for($i=0; $i<count($fieldsarr); $i++){
				@unlink($imgpath.$data[0][$fieldsarr[$i]]);
				@unlink($imgpath."_".$data[0][$fieldsarr[$i]]);
				@unlink($imgpath."__".$data[0][$fieldsarr[$i]]);
			}
			
			if($tab=="product_prd"){
				$prdgal = $this->getAll(" prdimages_img where idprd_img = ".$_GET['id']);
				if(is_array($prdgal)){
					for($j=0; $j<count($prdgal); $j++){
						$thisgal = $this->getSingdet(" prdimages_img where id_img = ".$prdgal[$j]['id_img']);
						// Gallery deletion
						if($this->CustomModify("delete from prdimages_img where idprd_img='".$_GET['id']."' ")){
							@unlink($this->absolute_path.$this->gallery_dir.$thisgal[0]['name_img']);
							@unlink($this->absolute_path.$this->gallery_dir."_".$thisgal[0]['name_img']);
							@unlink($this->absolute_path.$this->gallery_dir."__".$thisgal[0]['name_img']);
						}
						
					}
				}
				// delete its prices
				$this->CustomModify("delete from product_sizes where product_id='".$_GET['id']."' ");
			}
			
			if($tab=="order_ord"){
				// delete from order details also
				$this->CustomModify("delete from orderdetail_orddet where idord_orddet = '".$_GET['id']."' ");
			}
			
			$this->msg = "Record Deleted Successfully.";
			return true;
		}else{
			$this->msg = "Problem in deleting record, try again.";
			return false;
		}
	}
	
	
	//  This function will delete multiple records with image unlink
	  function delmulti($tab,$idcol,$imgpath,$fieldsarr,$parentcol="") 
	  {
		$data = $this->getSingdet(" $tab where $idcol = ".$_REQUEST['checkbox']);
		if($parentcol!=""){
			$childs = $this->getSingdet(" $tab where $parentcol = ".$_REQUEST['checkbox']);
		}
		if(is_array($childs)){
			$this->msg = "Can not delete, Please Delete its child records first.";
			return 2;
		}else{			
			if($this->DeleteSetOfRecords($tab,$idcol,$_REQUEST['checkbox']))
			{			
				// link deletion
				$this->CustomModify("delete from link_lk where idtab_lk='".$_REQUEST['checkbox']."' and table_lk='".$tab."'");
				
				for($i=0; $i<count($fieldsarr); $i++){
					@unlink($imgpath.$data[0][$fieldsarr[$i]]);
					@unlink($imgpath."_".$data[0][$fieldsarr[$i]]);
					@unlink($imgpath."__".$data[0][$fieldsarr[$i]]);
				}
				
				if($tab=="product_prd"){
				$prdgal = $this->getAll(" prdimages_img where idprd_img = ".$_REQUEST['checkbox']);
				if(is_array($prdgal)){
					for($j=0; $j<count($prdgal); $j++){
						$thisgal = $this->getSingdet(" prdimages_img where id_img = ".$prdgal[$j]['id_img']);
						// Gallery deletion
						if($this->CustomModify("delete from prdimages_img where idprd_img='".$_REQUEST['checkbox']."' ")){
							@unlink($this->absolute_path.$this->gallery_dir.$thisgal[0]['name_img']);
							@unlink($this->absolute_path.$this->gallery_dir."_".$thisgal[0]['name_img']);
							@unlink($this->absolute_path.$this->gallery_dir."__".$thisgal[0]['name_img']);
						}
						
					}
				}
				// delete its colors
				$this->CustomModify("delete from prdcolor_pc where idprd_pc='".$_REQUEST['checkbox']."' ");
				// delete its sizes
				$this->CustomModify("delete from prdsize_ps where idprd_ps='".$_REQUEST['checkbox']."' ");
				// delete its events
				$this->CustomModify("delete from prdevent_pe where idprd_pe='".$_REQUEST['checkbox']."' ");
				
				// delete its prices
				$this->CustomModify("delete from prdprices_pp where idprd_pp='".$_REQUEST['checkbox']."' ");
			}
			
				if($tab=="order_ord"){
					// delete from order details also
					$this->CustomModify("delete from orderdetail_orddet where idord_orddet = '".$_REQUEST['checkbox']."' ");
				}
			
				$this->msg = "Record Deleted Successfully.";
				return true;
			}else{
				$this->msg = "Problem in deleting record, try again.";
				return false;
			}
		}
	}
	
	//general deletion function with image unlink///
	function delPhotographer($tab,$colid,$imgpath,$fieldsarr) 
	{
		$data = $this->getSingdet($tab." where ".$colid." = ".$_GET['id']);
		if($this->DeleteSetOfRecords($tab,$colid,$_GET['id']))
		{
			// link deletion
			$this->CustomModify("delete from link_lk where idtab_lk='".$_GET['id']."'  and table_lk='".$tab."'");
			
			for($i=0; $i<count($fieldsarr); $i++){
				@unlink($imgpath.$data[0][$fieldsarr[$i]]);
				@unlink($imgpath."_".$data[0][$fieldsarr[$i]]);
				@unlink($imgpath."__".$data[0][$fieldsarr[$i]]);
			}
			// delete expertise of that photographer
			$phexpert = $this->getAll(" photographerexpertise_pe where idph_pe = ".$_GET['id']);
			if(is_array($phexpert)){
				$this->DeleteSetOfRecords("photographerexpertise_pe","idph_pe",$_GET['id']);
				
			}
			// delete images of that photographer
			$gal = $this->getAll(" gallery_gal where photographer_gal = ".$_GET['id']);
			if(is_array($gal)){
				for($j=0; $j<count($gal); $j++){
					if($this->DeleteSetOfRecords("gallery_gal","id_gal",$gal[$j]['id_gal'])){
						@unlink($this->absolute_path.$this->gallery_dir.$gal[$j]['image_gal']);
						@unlink($this->absolute_path.$this->gallery_dir."_".$gal[$j]['image_gal']);
					}
				}
			}
			
			$this->msg = "Record Deleted Successfully.";
			return true;
		}else{
			$this->msg = "Problem in deleting record, try again.";
			return false;
		}
	}
	
	
	//  This function will delete multiple records with image unlink
	  function delmultiPhotographer($tab,$idcol,$imgpath,$fieldsarr,$parentcol="") 
	  {
		$data = $this->getSingdet(" $tab where $idcol = ".$_REQUEST['checkbox']);
		if($parentcol!=""){
			$childs = $this->getSingdet(" $tab where $parentcol = ".$_REQUEST['checkbox']);
		}
		if(is_array($childs)){
			$this->msg = "Can not delete, Please Delete its child records first.";
			return 2;
		}else{			
			if($this->DeleteSetOfRecords($tab,$idcol,$_REQUEST['checkbox']))
			{			
				// link deletion
				$this->CustomModify("delete from link_lk where idtab_lk='".$_REQUEST['checkbox']."' and table_lk='".$tab."'");
				
				for($i=0; $i<count($fieldsarr); $i++){
					@unlink($imgpath.$data[0][$fieldsarr[$i]]);
					@unlink($imgpath."_".$data[0][$fieldsarr[$i]]);
					@unlink($imgpath."__".$data[0][$fieldsarr[$i]]);
				}
				// delete expertise of that photographer
				$phexpert = $this->getAll(" photographerexpertise_pe where idph_pe = ".$_REQUEST['checkbox']);
				if(is_array($phexpert)){
					$this->DeleteSetOfRecords("photographerexpertise_pe","idph_pe",$_REQUEST['checkbox']);
					
				}
				// delete images of that photographer
				$gal = $this->getAll(" gallery_gal where photographer_gal = ".$_REQUEST['checkbox']);
				if(is_array($gal)){
					for($j=0; $j<count($gal); $j++){
						if($this->DeleteSetOfRecords("gallery_gal","id_gal",$gal[$j]['id_gal'])){
							@unlink($this->absolute_path.$this->gallery_dir.$gal[$j]['image_gal']);
							@unlink($this->absolute_path.$this->gallery_dir."_".$gal[$j]['image_gal']);
						}
					}
				}
				$this->msg = "Record Deleted Successfully.";
				return true;
			}else{
				$this->msg = "Problem in deleting record, try again.";
				return false;
			}
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
	
	
			$limit = 9;
			
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
	
	///////////////////// generate password /////////////////////
	function genpassword($length){

    srand((double)microtime()*1000000);

    $vowels = array("a", "e", "i", "o", "u");

    $cons = array("b", "c", "d", "g", "h", "j", "k", "l", "m", "n", "p", "r", "s", "t", "u", "v", "w", "tr",

    "cr", "br", "fr", "th", "dr", "ch", "ph", "wr", "st", "sp", "sw", "pr", "sl", "cl");

    $num_vowels = count($vowels);

    $num_cons = count($cons);

    for($i = 0; $i < $length; $i++){

        $password .= $cons[rand(0, $num_cons - 1)] . $vowels[rand(0, $num_vowels - 1)];

    }

    return substr($password, 0, $length);

}// end generate password function //

	// GENERAL STATUS UPDATE FROM MANAGE PAGE
	function UpdStatus($table,$idcol,$statuscol,$status,$stid){
		$qry= "UPDATE $table set $statuscol='$status' where $idcol = '$stid'";
		$this->CustomModify($qry);
	}// END FUNCTION
	
	// general sorting function //
	
	function sortDataGeneral($table,$col,$idcol)
	{
		if(isset($_POST['sortion']))
		 {

			
	foreach($_POST as $key=>$value) {
			
			$pos = strpos($key, "ordsort_");
			
			if(is_int($pos) && $pos == 0){
				  $id = explode("_",$key);
		     
		 	$query="update ".$table." set ".$col." = ".$value."  where ".$idcol." = ".$id[1];
		   // echo "<br />";
			$rid2 = $this->CustomModify($query);
		  //echo "<br />";
			  }
		  }
	  }
	  
		$this->msg = "Sequence updated.";
		return true;
	}//end function
	
	
	function sortDataGeneral1($table,$col,$idcol)
	{
		if(isset($_POST['sortion']))
		 {

			
	foreach($_POST as $key=>$value) {
			
			$pos = strpos($key, "ordsort_");
			
			if(is_int($pos) && $pos == 0){
				  $id = explode("_",$key);
		     
		 	$query="update ".$table." set ".$col." = ".$value."  where ".$idcol." = ".$id[1];
		   // echo "<br />";
			$rid2 = $this->CustomModify($query);
		  //echo "<br />";
			  }
			  $pos = strpos($key, "caption_");
			
			if(is_int($pos) && $pos == 0){
				  $id = explode("_",$key);
		     
		 	$query="update ".$table." set caption_prdimg = '".$value."'  where ".$idcol." = ".$id[1];
		   // echo "<br />";
			$rid2 = $this->CustomModify($query);
		  //echo "<br />";
			  } 
			  
			   $pos = strpos($key, "alt_");
			
			if(is_int($pos) && $pos == 0){
				  $id = explode("_",$key);
		     
		 $query="update ".$table." set  alt_prdimg = '".$value."'  where ".$idcol." = ".$id[1];
			
		   // echo "<br />";
			$rid2 = $this->CustomModify($query);
		  //echo "<br />";
			  } 
			  
			   $pos = strpos($key, "title_");
			
			if(is_int($pos) && $pos == 0){
				  $id = explode("_",$key);
		     
		 	$query="update ".$table." set title_prdimg = '".$value."'  where ".$idcol." = ".$id[1];
			
		   //echo "<br />";
			$rid2 = $this->CustomModify($query);
		  //echo "<br />";
			  }
			  
			   
			  
		  }
	  }
	  
		$this->msg = "Sequence updated.";
		return true;
	}//end function
	
	//////////// listing page pagination ///////////////
	function GetDataPaginatelisting($query,$limit) // This Functio get the paginated data
	{ 
     if (isset($_REQUEST['page']))
	    {
	      $page = $_REQUEST['page'];  
	    }
	 else 
	    $page="";
	
	
			$limit = $limit;
			
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
	
	// pagination function for adminpanel
	function GetDataPaginateAdmin($query) // This Functio get the paginated data
	{ 
     if (isset($_REQUEST['page']))
	    {
	      $page = $_REQUEST['page'];  
	    }
	 else 
	    $page="";
	
	
			$limit = 80;
			
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
		
	function smartURLnew2($tab,$id){
		$data = $this->getSingdet("link_lk where idtab_lk = '$id' and table_lk = '$tab'");
		if($_SESSION['urltype']==1){
			return $data[0]['links_lk'];
	    }
	  	if($_SESSION['urltype']==2){
		  	return $data[0]['links_lk'].".html";
	  	}
	  	if($_SESSION['urltype']==3){
			return $data[0]['links_lk'].".php";
	  	}
	  	if($_SESSION['urltype']==4){
		  	return $data[0]['links_lk']."/";
	  	}
	}
	
	function get_metathings($table,$id){
		if($table!="")
		$metaarray = array();
		if($table == "content_cms"){
			$idcol = "id_cms";
			$metatitle = "metatitle_cms";
			$metatag = "metatag_cms";
			$metadesc = "metadescription_cms";
		}elseif($table == "category_cat"){
			$idcol = "id_cat";
			$metatitle = "metatitle_cat";
			$metatag = "metatag_cat";
			$metadesc = "metadescription_cat";
		}elseif($table == "banner_ban"){
			$idcol = "id_ban";
			$metatitle = "metatitle_ban";
			$metatag = "metatag_ban";
			$metadesc = "metadescription_ban";
		}elseif($table == "news_nws"){
			$idcol = "id_nws";
			$metatitle = "metatitle_nws";
			$metatag = "metaname_nws";
			$metadesc = "metadescription_nws";
		}elseif($table == "product_prd"){
			$idcol = "id_prd";
			$metatitle = "metatitle_prd";
			$metatag = "metatag_prd";
			$metadesc = "metadescription_prd";
			
		}elseif($table == "blog_b"){
			$idcol = "id_b";
			$metatitle = "metatitle_b";
			$metatag = "metatag_b";
			$metadesc = "metadescription_b";
			
		}elseif($table == "family_faml"){
			$idcol = "id_faml";
			$metatitle = "metatitle_faml";
			$metatag = "metatag_faml";
			$metadesc = "metadescription_faml";
			
		}
		elseif($table == "ourservices_os"){
			$idcol = "id_os";
			$metatitle = "metatitle_os";
			$metatag = "metatag_os";
			$metadesc = "metadescription_os";
			
		}
		elseif($table == "event_ev"){
			$idcol = "id_ev";
			$metatitle = "metatitle_ev";
			$metatag = "metatag_ev";
			$metadesc = "metadescription_ev";
			
		}
		$metaarray[0] = $this->getSingleField($table,$idcol,$id,$metatitle);
		$metaarray[1] = $this->getSingleField($table,$idcol,$id,$metatag);
		$metaarray[2] = $this->getSingleField($table,$idcol,$id,$metadesc);
		
		return $metaarray;
	}
	
	
	function get_metathingsArabic($table,$id){
		if($table!="")
		$metaarray = array();
		if($table == "content_cms"){
			$idcol = "id_cms";
			$metatitle = "metatitlear_cms";
			$metatag = "metatagar_cms";
			$metadesc = "metadescriptionar_cms";
		}elseif($table == "category_cat"){
			$idcol = "id_cat";
			$metatitle = "metatitlear_cat";
			$metatag = "metatagar_cat";
			$metadesc = "metadescriptionar_cat";
		}elseif($table == "banner_ban"){
			$idcol = "id_ban";
			$metatitle = "metatitlear_ban";
			$metatag = "metatagar_ban";
			$metadesc = "metadescriptionar_ban";
		}elseif($table == "news_nws"){
			$idcol = "id_nws";
			$metatitle = "metatitlear_nws";
			$metatag = "metanamear_nws";
			$metadesc = "metadescriptionar_nws";
		}elseif($table == "product_prd"){
			$idcol = "id_prd";
			$metatitle = "metatitlear_prd";
			$metatag = "metatagar_prd";
			$metadesc = "metadescriptionar_prd";
		}
		$metaarray[0] = $this->getSingleField($table,$idcol,$id,$metatitle);
		$metaarray[1] = $this->getSingleField($table,$idcol,$id,$metatag);
		$metaarray[2] = $this->getSingleField($table,$idcol,$id,$metadesc);
		
		return $metaarray;
	}
	
	function draw_pull_down_tree($name, $values, $first_caption = '',$default = '', $parameters = '', $required = false, $id='')
	{ //die("saaa");
		
		//echo " name= ".$name.", values= ". $values.", default= ". $default.", parameters= ". $parameters;	die();
	
		$id = ($id=='') ? $name : $id; 
			//$GLOBALS[$name];
	// '<option value="">-- No Parent --</option>';
		$field = '<select name="' . $this->output_string($name) . '" id="' . $this->output_string($id) . '"';
		if ($this->not_null($parameters)) $field .= ' ' . $parameters;
		$field .= '>';
		
		if (empty($default) && isset($GLOBALS[$name])) $default = stripslashes($GLOBALS[$name]);
		if($first_caption!="")
			$field .= '<option value="0">-- No Parent --</option>';
		for ($i=0, $n=sizeof($values); $i<$n; $i++)
		{
			$field .= '<option value="' . $this->output_string($values[$i]['id']) . '"';				
			$selected_trades = explode(",", $default);
			if (in_array($values[$i]['id'], $selected_trades))
			{
				$field .= ' selected="selected"';
			}
			
			$field .= '>' . $this->output_string($values[$i]['text'], array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;')) . '</option>';
		}
		$field .= '</select>';
		//if ($required == true) $field .= TEXT_FIELD_REQUIRED;
		return $field;
	}
	
	
	
	function get_category_tree($table, $parent_id_field, $value_field, $caption_field, $condition, $parent_cat_id = '', $spacing = '', $exclude = '', $category_tree_array = '', $include_itself = false)
	{
		//echo $parent_cat_id."<br />";
			
		global $languages_id;
	//aecho "11111" . $caption_field;	
	$caption_field=$caption_field .$lang;
		if (!is_array($category_tree_array)) $category_tree_array = array();
		//if ( (sizeof($category_tree_array) < 1) && ($exclude != '0') ) $category_tree_array[] = array('id' => '0', 'text' => "All Categories");
	
		if ($include_itself)
		{ 
			$category_query = mysqli_query($this->DBlink ,"SELECT * FROM $table WHERE $value_field = '" . (int)$parent_cat_id . "'");
			$category = mysqli_fetch_array($category_query);
			$category_tree_array[] = array('id' => $parent_cat_id, 'text' => $category[$caption_field]);
		}
	
		$sql = "SELECT * FROM $table WHERE  $parent_id_field = '". (int)$parent_cat_id . "'"; 
		if($condition!="")
			$sql .= " AND $condition ";
		$sql .= " ORDER BY ".$value_field;
		//echo "<br />".$sql;
		$categories_query = mysqli_query($this->DBlink ,$sql) or die(mysqli_error());
		
	/*	if($lang='en')
		$caption_field=$caption_field .$lang;
		else if($lang='ar')
		$caption_field=$caption_field .$lang;
		else
		$caption_field=$caption_field ."en";*/
		//echo "Total categories : " . mysql_num_rows($categories_query);
		while ($categories = mysqli_fetch_array($categories_query))
		{
			//echo "$value_field = ".$categories[$value_field]."<br />";
			if ($exclude != $categories[$value_field])
				$category_tree_array[] = array('id' => $categories[$value_field], 'text' => $spacing . $categories[$caption_field]);
			$category_tree_array = $this->get_category_tree($table, $parent_id_field, $value_field, $caption_field, $condition, $categories[$value_field], $spacing . '&raquo;', $exclude, $category_tree_array);
		}
		//print_r($category_tree_array);
		return $category_tree_array;
	}
	
	function output_string($string, $translate = false, $protected = false)
	{
		
		if ($protected == true)
			return htmlspecialchars($string);
		else
		{
			if ($translate == false)
				return $this->parse_input_field_data($string, array('"' => '&quot;'));
			else
				return $this->parse_input_field_data($string, $translate);
		}
	}
	function parse_input_field_data($data, $parse)
	{
		return strtr(trim($data), $parse);
	}
	function not_null($value)
{
	if (is_array($value))
	{
		if (($value) > 0)
			return true;
		else
			return false;
	}
	else
	{
		if ( (is_string($value) || is_int($value)) && ($value != '') && ($value != 'NULL') && (strlen(trim($value)) > 0))
			return true;
		else
			return false;
	}
}// end function
	
	function get_category_tree2($table, $parent_id_field, $value_field, $caption_field, $condition, $parent_cat_id = '', $spacing = '', $exclude = '', $category_tree_array = '', $include_itself = false)
	{
		//echo $parent_cat_id."<br />";
			
		global $languages_id;
	//aecho "11111" . $caption_field;	
	$caption_field=$caption_field .$lang;
		if (!is_array($category_tree_array)) $category_tree_array = array();
		//if ( (sizeof($category_tree_array) < 1) && ($exclude != '0') ) $category_tree_array[] = array('id' => '0', 'text' => "All Categories");
	
		if ($include_itself)
		{
			$category_query = mysqli_query ($this->DBlink ,"SELECT * FROM $table WHERE $value_field = '" . (int)$parent_cat_id . "'");
			$category = mysqli_fetch_array($category_query);
			$category_tree_array[] = array('id' => $parent_cat_id, 'text' => $category[$caption_field], 'parent'=>$category[$parent_id_field]);
		}
	
		$sql = "SELECT * FROM $table WHERE  $parent_id_field = '". (int)$parent_cat_id . "'"; 
		if($condition!="")
			$sql .= " AND $condition ";
		$sql .= " ORDER BY ".$value_field;
		//echo "<br />".$sql;
		$categories_query = mysqli_query ($this->DBlink ,$sql) or die(mysql_error());
		
	/*	if($lang='en')
		$caption_field=$caption_field .$lang;
		else if($lang='ar')
		$caption_field=$caption_field .$lang;
		else
		$caption_field=$caption_field ."en";*/
		//echo "Total categories : " . mysql_num_rows($categories_query);
		while ($categories = mysqli_fetch_array($categories_query))
		{
			//echo "$value_field = ".$categories[$value_field]."<br />";
			if ($exclude != $categories[$value_field])
				$category_tree_array[] = array('id' => $categories[$value_field], 'text' =>  $categories[$caption_field], 'parent'=>$categories[$parent_id_field]);
			$category_tree_array = $this->get_category_tree2($table, $parent_id_field, $value_field, $caption_field, $condition, $categories[$value_field], '' , $exclude, $category_tree_array);
		}
		//print_r($category_tree_array);
		return $category_tree_array;
	}
	
	function get_parents ($tab,$idfield,$idval,$parentfield, $found = array()) {
		
		array_push ($found, $idval);
	
		$sql = "SELECT * FROM $tab WHERE $idfield = '$idval'";
		$result = mysqli_query ($this->DBlink ,$sql) or die ($sql);
	
		if(mysqli_num_rows($result)){
			while($row = mysql_fetch_assoc($result)){
				$found = $this->get_parents($tab,$idfield,$row[$parentfield],$parentfield, $found);				
			}
		}
		return array_reverse($found);
	}
	
	////// function get parent categories ////
	function getParents($tab,$idfield,$parentfield,$id){
		$parent = $id;
		//$stack = array();
		while($parent != 0){
			$data = $this->getSingdet("$tab where $idfield = ".$parent);
			$parent = $data[0][$parentfield];
			$stack[] = $data;
		}
		return $stack = array_reverse($stack);
	}
	//// //////// //////
	
	function insertRecordarray($array,$table)
	{
		$inserts="";
		$vals="";
		 foreach($array as $key=>$value)
	     {
		   $inserts .= $key.",";
		   $vals .= "'".mysql_real_escape_string($value)."',";
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
	}// end function
	
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
	}//end function
	
	
	function insertClientsMulti($tab)
	{
		$inserts = "";
		$vals = "";
					//insert images
		for($i=0;$i<count($_POST['modpics']);$i++)
			   
	   {
				 //$key = str_replace("pre2_","",$key);
			$inserts .= "image_name_clt,";
			$vals .= "'".$_POST['modpics'][$i]."',";
			
			$inserts .= "image_alt_clt,";
			$vals .= "'".$_POST['alt'][$i]."',";
			
			$inserts .= "image_title_clt,";
			$vals .= "'".$_POST['title'][$i]."',";
			
			$inserts .= "status_clt,";
			$vals .= "'1',";
			
			$inserts .= "order_clt,";
			$vals .= "'".$_POST['order'][$i]."',";
			//removing last character comma
			$inserts = rtrim($inserts,",");
			$vals = rtrim($vals,",");
			//echo " insert into $tab ($inserts) values ($vals)"; die();
			$recnum12=$this->InsertRecord($tab,$inserts,$vals); 
			$inserts = "";
			$vals = "";
			}
			$this->msg = "Images Added Successfully";
			return true;
	}// end Gallery images function
	
	
	function insertGalleryDetails($tab,$imgpath)
	{
		$inserts="";
		$vals = "";	
		//arranging values of POST only
		foreach($_REQUEST as $key=>$value) {
			
			$pos = strpos($key, "pre_");
			
			if(is_int($pos) && $pos == 0){
				
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
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$imgpath,$this->upload_size_allowed);
				$path_product_image = $imgpath.$product_image;
				$thumbnil_image =$imgpath."_".$product_image;
				createsmallthumbHSSG($path_product_image,$thumbnil_image,$this->galleryThumbnailWidth,$this->galleryThumbnailHeight);
				
					
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
			$this->msg = "Data added successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	}
	
	//////////// insert Gallery multiple images /////////////////////////////
	function insertGalleryImages($tab)
	{
		$inserts = "";
		$vals = "";
		//insert images
		
		for($i=0;$i<count($_POST['modpics']);$i++){
				 //$key = str_replace("pre2_","",$key);
			/*$inserts .= "idcat_gal,";
			$vals .= "'".$_POST['idcat']."',";*/
						
			
			$inserts .= "image_gal,";
			$vals .= "'".$_POST['modpics'][$i]."',";
			
			
			$inserts .= "image_alt_gal,";
			$vals .= "'".$_POST['alt'][$i]."',";
			
			$inserts .= "image_title_gal,";
			$vals .= "'".$_POST['title'][$i]."',";
			
			$inserts .= "caption_gal,";
			$vals .= "'".$_POST['caption'][$i]."',";
			
			$inserts .= "location_gal,";
			$vals .= "'".$_POST['location'][$i]."',";
			
			
			$inserts .= "order_gal,";
			$vals .= "'".$_POST['order'][$i]."',";
			/*$inserts .= "link_gal,";
			$vals .= "'".$_POST['link'][$i]."',";*/
			
			//removing last character comma
			$inserts = rtrim($inserts,",");
			$vals = rtrim($vals,",");
			if($recnum12=$this->InsertRecord($tab,$inserts,$vals)){
				if(is_array($_POST['idcat'])){
					$inserts2 = "";
					$vals2 = "";
					for($a=0; $a<count($_POST['idcat']); $a++){
						$inserts2 .= "idgal_gc,";
						$vals2 .= "'".$recnum12."',";
						
						$inserts2 .= "idcat_gc,";
						$vals2 .= "'".$_POST['idcat'][$a]."',";			
						
						$inserts2 .= "idph_gc,";
						$vals2 .= "'".$_POST['photographer']."',";
						
						$inserts2 = rtrim($inserts2,",");
						$vals2 = rtrim($vals2,",");
						
						$recnum13=$this->InsertRecord("gallerycat_gc",$inserts2,$vals2);
						$inserts2 = "";
						$vals2 = "";
						
					}
				}
			}
			$inserts = "";
			$vals = "";
			}
			
			$this->msg = "Images Added Successfully";
			return true;
	}// end Gallery images function
	
	// Gallery updation function
	function updGallery($params)
	{
		if(!isset($_POST['button']))
	   {
		  
		return false;
	   }
	   foreach($params as $k=>$v){
			 $$k = $v;
		}
		//die($parent);
		$inserts="";
		//arranging values of POST only
		
		foreach($_POST as $key=>$value) {
			$value = addslashes($value);
			//$value = mysql_real_escape_string($value);

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
				$user = "select * from ".$tab." where " .$id." = ".$_GET['id'];
			 
				$userdata = $this->CustomQuery($user);
				
				
				
				if($userdata[0][$txtname] != '' and file_exists($imgpath.$userdata[0][$txtname]))
				{
					@unlink($imgpath.$userdata[0][$txtname]);
					if(file_exists($imgpath."_".$userdata[0][$txtname])){
						@unlink($imgpath."_".$userdata[0][$txtname]);
					}
					if(file_exists($imgpath."__".$userdata[0][$txtname])){
						@unlink($imgpath."__".$userdata[0][$txtname]);
					}					
				
				}
				
				//upload new image
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$imgpath,$this->upload_size_allowed);
				if($thumb!=0){
					$path_product_image = $imgpath.$product_image;
					$thumbnail_image = $imgpath."_".$product_image;
					// Resize image (options: exact, portrait, landscape, auto, crop)
			 		resizeImage($path_product_image,$thumbWidth, $thumbHeight, 'exact');
					// Save image
					saveImage($thumbnail_image, 100);
				}
				// large thumbnail
				if($thumb2!=0){
					$path_product_image = $imgpath.$product_image;
					$thumbnail_image = $imgpath."__".$product_image;
					// Resize image (options: exact, portrait, landscape, auto, crop)
					resizeImage($path_product_image,$thumb2Width, $thumb2Height, 'exact');
					// Save image
					saveImage($thumbnail_image, 100);
			 		//createthumb($path_product_image,$thumbnail_image,$thumb2Width, $thumb2Height);					
				}
				$inserts .=$txtname."='".$product_image."' ,";	
			}
					
		}
		//removing last character comma
		$inserts = rtrim($inserts,",");
		$data = $this->getSingdet(" link_lk where idtab_lk = ".$_GET['id']." and table_lk = '$tab'");		
		//final passing for updation
		 $query = "update ".$tab." set ".$inserts."  where " .$id. " =".$_GET['id'];
	 
	
		
		if($rid2 = $this->CustomModify($query))
		{
			$this->DeleteSetOfRecords("gallerycat_gc","idgal_gc",$_GET['id']);
			$inserts2 = "";
			$vals2 = "";
			if(count($_POST['category'])>0){
				for($j=0; $j<count($_POST['category']); $j++){
					$inserts2.="idcat_gc,";
					$vals2.="'".$_POST['category'][$j]."',";
								
					$inserts2.="idgal_gc,";
					$vals2.="'".$_GET['id']."',";
					
					$inserts2.="idph_gc,";
					$vals2.="'".$_POST['upd_photographer_gal']."',";
								
					$inserts2 = rtrim($inserts2,",");
					$vals2 = rtrim($vals2,",");
								
					$recnum13=$this->InsertRecord("gallerycat_gc",$inserts2,$vals2);
					$inserts2 = "";
					$vals2 = "";
				}// end for loop
			}// end if condition
				
			$this->msg = "Data updated successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}	
	}
	
	function insertProductGallery($tab)
	{
		$inserts = "";
		$vals = "";
					//insert images
		for($i=0;$i<count($_POST['modpics']);$i++)
			   
	   {
				 //$key = str_replace("pre2_","",$key);
			$inserts .= "idprd_img,";
			$vals .= "'".$_GET['cid']."',";
			
			$inserts .= "name_img,";
			$vals .= "'".$_POST['modpics'][$i]."',";
			
			
			/*$inserts .= "thumb_title,";
			$vals .= "'".$_POST['thumb_title'][$i]."',";
			
			$inserts .= "thumb_alt,";
			$vals .= "'".$_POST['thumb_alt'][$i]."',";*/
			
			$inserts .= "alt_img,";
			$vals .= "'".$_POST['alt'][$i]."',";
			
			$inserts .= "title_img,";
			$vals .= "'".$_POST['title'][$i]."',";
			
			$inserts .= "status_img,";
			$vals .= "'1',";
			
			$inserts .= "order_img,";
			$vals .= "'".$_POST['order'][$i]."',";
			
			
			
			//removing last character comma
			$inserts = rtrim($inserts,",");
			$vals = rtrim($vals,",");
			$recnum12=$this->InsertRecord($tab,$inserts,$vals); 
			$inserts = "";
			$vals = "";
			}
			$this->msg = "Images Added Successfully";
			return true;
	}// end Gallery images function
	
	//general deletion function with image unlink///
	function delGalleryImage($tab,$colid,$colname,$imgpath) 
	{
		$data = $this->getSingdet($tab." where ".$colid." = ".$_GET['mid']);
		if($this->DeleteSetOfRecords($tab,$colid,$_GET['mid']))
		{
			@unlink($imgpath.$data[0][$colname]);
			@unlink($imgpath."_".$data[0][$colname]);
			$this->msg = "Record Deleted Successfully.";
			return true;
		}else{
			$this->msg = "Problem in deleting record, try again.";
			return false;
		}
	}//end function
	
	//////////// insert Gallery multiple images from profile page/////////////////////////////
	function insertGalleryProfile($tab)
	{
		$inserts = "";
		$vals = "";
					//insert images
		for($i=0;$i<count($_POST['modpics']);$i++)
			   
	   {
				 //$key = str_replace("pre2_","",$key);
			$inserts .= "photographer_gal,";
			$vals .= "'".$_SESSION['users']['ID']."',";			
			
			$inserts .= "image_gal,";
			$vals .= "'".$_POST['modpics'][$i]."',";
			
			
			$inserts .= "image_alt_gal,";
			$vals .= "'".$_POST['caption'][$i]."',";
			
			$inserts .= "image_title_gal,";
			$vals .= "'".$_POST['caption'][$i]."',";
			
			$inserts .= "caption_gal,";
			$vals .= "'".$_POST['caption'][$i]."',";
			
			/*$inserts .= "link_gal,";
			$vals .= "'".$_POST['link'][$i]."',";*/
			
			//removing last character comma
			$inserts = rtrim($inserts,",");
			$vals = rtrim($vals,",");
				if($recnum12=$this->InsertRecord($tab,$inserts,$vals)){
					$imgname = $_POST['modpics'][$i];
					$imgname = str_replace(".","_",$imgname);
					if(isset($_POST['category_'.$imgname])){
						$inserts2 = "";
						$vals2 = "";
						for($j=0; $j<count($_POST['category_'.$imgname]); $j++){
							$inserts2.="idcat_gc,";
							$vals2.="'".$_POST['category_'.$imgname][$j]."',";
							
							$inserts2.="idgal_gc,";
							$vals2.="'".$recnum12."',";
							
							$inserts2.="idph_gc,";
							$vals2.="'".$_SESSION['users']['ID']."',";
							
							$inserts2 = rtrim($inserts2,",");
							$vals2 = rtrim($vals2,",");
							
							$recnum13=$this->InsertRecord("gallerycat_gc",$inserts2,$vals2);
							$inserts2 = "";
							$vals2 = "";
						}// end inner for loop
					}// end inner if condition
					$inserts = "";
					$vals = "";
				}// end outer for loop
			}// end outer if condition
			$this->msg = "Images Added Successfully";
			return true;
	}// end Gallery images function from profile page
	
	//////////// update profile picture ///////////////
	function UpdGalleryImg($tab,$imgpath="")
	{		
		$inserts = "image_gal = '".$_POST['modpics']."', image_title_gal = '".$_POST['caption']."', image_alt_gal = '".$_POST['caption']."', caption_gal = '".$_POST['caption']."' ";
		$query = "update ".$tab." set ".$inserts."  where id_gal = ".$_POST['editid'];
	 
		if($rid2 = $this->CustomModify($query)){
			$this->DeleteSetOfRecords("gallerycat_gc","idgal_gc",$_POST['editid']);
			$inserts2 = "";
			$vals2 = "";
			for($j=0; $j<count($_POST['category']); $j++){
				$inserts2.="idcat_gc,";
				$vals2.="'".$_POST['category'][$j]."',";
							
				$inserts2.="idgal_gc,";
				$vals2.="'".$_POST['editid']."',";
				
				$inserts2.="idph_gc,";
				$vals2.="'".$_SESSION['users']['ID']."',";
							
				$inserts2 = rtrim($inserts2,",");
				$vals2 = rtrim($vals2,",");
							
				$recnum13=$this->InsertRecord("gallerycat_gc",$inserts2,$vals2);
				$inserts2 = "";
				$vals2 = "";
			}// end inner for loop
			return true;
		}else{
			$this->msg = "There was some problem while saving.";
			return false;
		}
	}// end updateprofile picture
		
	function checkURL($uri){
		$illegal = "\#@$%^&*()+=[]';,{}|:<>?~";
		$chk = strpbrk($uri, $illegal);
		if($chk){
			header("location: ".$this->site_url."access-denied".$_SESSION['URL']);
		}else{
			return false;
		}
	}//end function
	
	function BlockIP(){
		session_register('deny');
		$_SESSION['deny']['IP']= $_SERVER['REMOTE_ADDR'];
		
		if($_SESSION['deny']['try'] ==""){
			$_SESSION['deny']['firsttime'] = time();
		}
		$_SESSION['deny']['try'] = $_SESSION['deny']['try']+1;
		if($_SESSION['deny']['try']>2){
			if($_SESSION['deny']['firsttime']+ 3 * 60 > time()){
				$ins = "ip_ipblk,datetime_ipblk";
				$vals = "'".$_SERVER['REMOTE_ADDR']."', '".date('Y-m-d G:i:s')."'";
				if($this->InsertRecord("ip_block_ipblk",$ins,$vals)){
					session_unregister("deny");
					header("location:restricted".$_SESSION['URL']);
				}
				}else{
					$_SESSION['deny']['try'] = 1;
					$_SESSION['deny']['firsttime'] = time();
			}
		}
	$_SESSION['deny']['time'] = time();
	}//end function
	
	//////////////// Currency Functions /////////////////
	function setCurrency()
	{
		/*$_SESSION['currencyarr']['ID'] = "";
		$_SESSION['currencyarr']['curr_name'] = "";
		$_SESSION['currencyarr']['curr_sname'] = "";
		$_SESSION['currencyarr']['curr_symbol'] = "";
		$_SESSION['currencyarr']['curr_rate'] = "";*/
		$prevcurr = $_SESSION['currencyarr']['curr_sname'];
		if(isset($_POST['currencyname']) && $_POST['currencyname']!="")
		{	
			$curr_details = $this->getAll(" currency_curr where id_curr = ".$_POST['currencyname']);
			//session_register('currency');
			$_SESSION['currencyarr']['ID'] = $curr_details[0]['id_curr'];
			$_SESSION['currencyarr']['curr_name'] = $curr_details[0]['fullname_curr'];
			$_SESSION['currencyarr']['curr_sname'] = $curr_details[0]['shortname_curr'];
			$_SESSION['currencyarr']['curr_symbol'] = $curr_details[0]['symbol_curr'];
			$_SESSION['currencyarr']['curr_rate'] = $curr_details[0]['rate_curr'];
			// update items in cart if there are any
			$cartitems = $this->getAll(" ordertemp_ordtem where sessionid_ordtem = '".session_id()."' ");
			if(is_array($cartitems)){
				for($c=0; $c<count($cartitems); $c++){
					$price = 0;
					$totprice = 0;
					$oldprice = $this->CurrencyPrice($cartitems[$c]['idprd_ordtem'],$_SESSION['currencyarr']['ID']);
					if($cartitems[$c]['percentdiscount_ordtem']!=0){
						$price = ($oldprice/100)*$cartitems[$c]['percentdiscount_ordtem'];						
					}else{
						$price = $oldprice;						
					}
					$totprice = $price*$cartitems[$c]['quantity_ordtem'];
					$this->CustomModify(" update ordertemp_ordtem set idcurr_ordtem = ".$_SESSION['currencyarr']['ID'].", currname_ordtem = '".$_SESSION['currencyarr']['curr_sname']."', price_ordtem = '".$price."', oldprice_ordtem = '".$oldprice."', total_ordtem = '".$totprice."' where id_ordtem = ".$cartitems[$c]['id_ordtem']);
				}
			}
			
		}elseif($_SESSION['currencyarr']['ID']!="")
		{
			//do nothing
		}
		elseif($_POST['currencyname']=="" && $_SESSION['currencyarr']['ID']=="")
		{
			
			$curr_details = $this->getAll(" currency_curr where id_curr = 1");
			
			//session_register('currency');
			$_SESSION['currencyarr']['ID'] = $curr_details[0]['id_curr'];
			$_SESSION['currencyarr']['curr_name'] = $curr_details[0]['fullname_curr'];
			$_SESSION['currencyarr']['curr_sname'] = $curr_details[0]['shortname_curr'];
			$_SESSION['currencyarr']['curr_symbol'] = $curr_details[0]['symbol_curr'];
			$_SESSION['currencyarr']['curr_rate'] = $curr_details[0]['rate_curr'];
		}
		
	}/// end set currency function /////////////
	
	function CurrencyPrice($idprd,$idcurr){
		$price = $this->getSingdet(" prdprices_pp where idprd_pp = $idprd and idcurr_pp = $idcurr");
		return $price[0]['price_pp'];
	}
	
	/// CURRENCY CONVERSION FROM GOOGLE
	function CurrencyConvertGoogle($from,$to,$amount){
	 $url = "http://www.google.com/finance/converter?a=$amount&from=$from&to=$to"; 
	 $request = curl_init(); 
	 $timeOut = 0; 
	 curl_setopt ($request, CURLOPT_URL, $url); 
	 curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1); 
	 curl_setopt ($request, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)"); 
	 curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut); 
	 $response = curl_exec($request); 
	 curl_close($request);
	 $regularExpression     = '#\<span class=bld\>(.+?)\<\/span\>#s';
    preg_match($regularExpression, $response, $finalData);
    $usdamount = strip_tags($finalData[0]);
	$usdamount = rtrim($usdamount," USD");
	 
	 return round($usdamount,2);
	}
	
	function checkIP(){
		$deny = "";
		$ip = $_SERVER['REMOTE_ADDR'];
		$datetime = date("Y-m-d H:i:s",strtotime("-6 hour"));
		$allowedtime =  date( 'Y-m-d H:i:s',strtotime($datetime));
		$this->CustomModify(" update ip_block_ipblk set status_ipblk = '0' where datetime_ipblk<'".$allowedtime."'");
		//echo " ip_block_ipblk where ip_ipblk = '".$ip."' and status_ipblk = '1' order by datetime_ipblk desc";
		$denied = $this->getAll(" ip_block_ipblk where ip_ipblk = '".$ip."' and status_ipblk = '1' order by datetime_ipblk desc");
		if(is_array($denied)){
			return true;
		}else{
			return false;
		}
	}// end function
	
	function setURLtype(){
		$urltype = $this->getSingdet(" setting_set where id_set = 1 ");
		$_SESSION['urltype'] = $urltype[0]['url_select_set'];
		if($_SESSION['urltype']==1){
			$_SESSION['URL'] = "";
		}elseif($_SESSION['urltype']==2){
			$_SESSION['URL'] = ".html";
		}elseif($_SESSION['urltype']==3){
			$_SESSION['URL'] = ".php";
		}elseif($_SESSION['urltype']==4){
			$_SESSION['URL'] = "/";
		}
	}
	
	function chkpopup(){
		$closed = $this->getAll("popupclose_pc where sessionid_pc = '".session_id()."'");
		if(is_array($closed)){
			return true;
		}else{
			return false;
		}		
	}// end function
	
	function insertnewsletter($tab)
	{
		$emailchk = $this->getSingdet($tab." where email_newl = '".$_POST['pre_email_newl']."'");
		if(is_array($emailchk)){
			// update date and session id
			$this->CustomModify(" update $tab set date_newl = '".$_POST['pre_date_newl']."', sessionid_newl = '".$_POST['pre_sessionid_newl']."'");
			return true;
		}
		$inserts="";
		$vals = "";	
		//arranging values of POST only
		foreach($_REQUEST as $key=>$value) {
			
			$pos = strpos($key, "pre_");
			
			if(is_int($pos) && $pos == 0){
				
				$key = str_replace("pre_","",$key);
				
				$keypos = strpos($key, "1");
				if(is_int($keypos) && $keypos == 0){
					$key = str_replace("1","",$key);
					$field = str_replace("_newl","",$key);
					$valid = $this->validateFields($field,$value);
					if(!$valid){
						return false;
					}
				}
				
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
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$this->absolute_path.$this->general_dir,$this->upload_size_allowed);
					
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
			$this->msg2 = "Data added successfully.";
			return true;
		}else{
			$this->msg2 = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	}
	
	function insertCareer($tab)
	{
		$inserts="";
		$vals = "";	
		//arranging values of POST only
		foreach($_REQUEST as $key=>$value) {
			
			$pos = strpos($key, "pre_");
			
			if(is_int($pos) && $pos == 0){
				
				$key = str_replace("pre_","",$key);
				
				$keypos = strpos($key, "1");
				if(is_int($keypos) && $keypos == 0){
					$key = str_replace("1","",$key);
					$field = str_replace("_cr","",$key);
					$valid = $this->validateFields($field,$value);
					if(!$valid){
						return false;
					}
				}
				
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
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$this->absolute_path.$this->files_dir,$this->upload_size_allowed);
					
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
			$this->msg = "Data added successfully.";
			return true."/".$product_image;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	}
function ProductNew($tab,$id,$name,$parent,$imgpath)
	{ 
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
				$path_product_image = $imgpath.$product_image;
			/*	$thumbnil_image =$imgpath."_".$product_image;
				createsmallthumb($path_product_image,$thumbnil_image,$this->largeThumbnailWidth,$this->largeThumbnailHeight);
				$thumbnil_image1 =$imgpath."__".$product_image;
				createsmallthumb($path_product_image,$thumbnil_image1,$this->smallThumbnailWidth,$this->smallThumbnailHeight);*/
					
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
			$cmsurl="our-products/";
			$cmsurl.= $this->completeURL($tab,$id,$recnum,$name,$parent);
			//$updqry = $this->CustomModify("update $tab set $url = '".$cmsurl."' where $id = '".$recnum."'");
			//insert into links table
			if($cmsurl!=""){
				
			$inslink = "INSERT INTO link_lk(links_lk,table_lk,idtab_lk) values ('$cmsurl','$tab','$recnum')";
			$this->CustomModify($inslink);
			}
			///insert colors
				for($j=0; $j<count($_POST['colors']); $j++){
				      $c="insert into prodcolors_pc(idprd_pc,idc_pc) values('".$recnum."','".$_POST['colors'][$j]."')";
					$this->CustomModify($c);	
				}
			//end insert colors
			$this->msg = "Data added successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	}

///update new prodcts
function updProductNew($tab,$id,$name,$parent,$imgpath)
	{
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
				$user = "select * from ".$tab." where " .$id." = ".$_GET['id'];
			 
				$userdata = $this->CustomQuery($user);
				
				
				
				if($userdata[0][$txtname] != '' and file_exists($imgpath.$userdata[0][$txtname]))
				{
					@unlink($imgpath.$userdata[0][$txtname]);
				
				}
				
				//upload new image
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$imgpath,$this->upload_size_allowed);
				$path_product_image = $imgpath.$product_image;
				/*$thumbnil_image =$imgpath."_".$product_image;
				createsmallthumb($path_product_image,$thumbnil_image,$this->largeThumbnailWidth,$this->largeThumbnailHeight);
				$thumbnil_image1 =$imgpath."__".$product_image;
				createsmallthumb($path_product_image,$thumbnil_image1,$this->smallThumbnailWidth,$this->smallThumbnailHeight);
*/				//add to insert query
				$inserts .=$txtname."='".$product_image."' ,";	
			}
					
		}
		//removing last character comma
		$inserts = rtrim($inserts,",");
		$data = $this->getSingdet(" link_lk where idtab_lk = ".$_GET['id']." and table_lk = '$tab'");		
		//final passing for updation
	$query = "update ".$tab." set ".$inserts."  where " .$id. " =".$_GET['id'];
	//die();
		
		if($rid2 = $this->CustomModify($query))
		{
			//update its url
			//$cmsurl = $this->filterName($_POST['pre_name_cms']);
			$cmsurl="our-products/";
		 $cmsurl.= $this->completeURL($tab,$id,$_GET['id'],$name,$parent);
			
			//$updqry = $this->CustomModify("update $tab set $url = '".$cmsurl."' where $id = '".$recnum."'");
			//links table updation	
			$this->CustomModify("UPDATE link_lk SET  links_lk = '$cmsurl' where id_lk = '".$data[0]['id_lk']."'");
					
			///insert colors
				//first delete existing
					$d="delete from prodcolors_pc where idprd_pc=".$_GET['id'];
					$this->CustomModify($d);
				for($j=0; $j<count($_POST['colors']); $j++){
					$c="insert into prodcolors_pc(idprd_pc,idc_pc) values('".$_GET['id']."','".$_POST['colors'][$j]."')";
					$this->CustomModify($c);	
				}
			//end insert colors
			
			$this->msg = "Data updated successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}	
	}
	
	function updatesingcart($tab) // This funciton update all the results
		{
		if(isset($_POST['quantity']))
			{
				//echo $_POST['product_id']; die();
				$quantity=$_POST['quantity'];
				$id=$_POST['product_id'];
				$item_price=$_POST['item_price'];
				
				
				//$price =$this->getSingdet("product_prd where id_prd=".$id);

			$new_price = $quantity * $item_price;
			//echo $new_price; die();				
							
			$query = "update ".$tab." set quantity_ordtem=".$quantity.", totprice_ordtem=".$new_price."  where idprd_ordtem=".$id." and session_id_ordtem='".session_id()."'";
			
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
	function updCart(){
		print_r($_POST); die();
		foreach($_POST as $key=>$val){
			$pos = strpos($key, "totprice-");
			
			if(is_int($pos) && $pos == 0){
				
				$expl = explode("-",$key);
				$id = $expl[1];
				//echo " Update order_temp_ordtem set totprice_ordtem = '$val' where id_ordtem = '$id'"; die(); 	
				$this->CustomModify(" Update order_temp_ordtem set totprice_ordtem = '$val' where id_ordtem = '$id'");	
			}
			$pos = strpos($key, "pprice-");
			if(is_int($pos) && $pos == 0){
				
				$expl = explode("-",$key);
				$id = $expl[1]; 	
				$this->CustomModify(" Update order_temp_ordtem set price_ordtem = '$val' where id_ordtem = '$id'");	
			}
		}
		
		/*$imgdir = $this->order_dir;
		$imgpath=$this->createFolders($this->absolute_path.$imgdir);
		foreach($_FILES as $key=>$value)
		{
			//upload image For time being its for image
			//$imgpath=$this->createFolders($imgpath);
			if($value['name'] !="" && $value['error']== 0)
			{	
				//upload new image
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage2($key,$imgpath,$this->upload_size_allowed);
				
				$product_image =  $imgdir.date('Y/m/d').'/'.$product_image;		
			}
			$pos = strpos($key, "printingfile_");
			
			if(is_int($pos) && $pos == 0){
				
				$expl = explode("_",$key);
				$id = $expl[1]; 	
				$this->CustomModify(" Update order_temp_ordtem set file_ordtem = '$product_image' where id_ordtem = '$id'");	
			}	
		}*/
		return true;
	}// end function
	
	function sendMail($fromname,$fromemail,$toemail,$subject,$message,$attach='',$mailer=0){
		if($mailer==0){
			$headers  = "MIME-Version:1.0\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8\r\n";
			$headers .= "From:$fromname<$fromemail>\r\nReply-To:$fromemail\r\n ";
			$headers .= "X-Priority: 3\r\n";
  			$headers .= "X-Mailer: PHP". phpversion() ."\r\n";
			
			@mail($toemail, $subject, $message, $headers);
		}elseif($mailer==1){
			
			
			
			require_once $this->absolute_path.'phpmailer/class.phpmailer.php';
			$mail1 = new PHPMailer;
			$mail1->CharSet = 'UTF-8';

			$mail1->IsSMTP();                                      // Set mailer to use SMTP
			$mail1->Host = $this->smtphost;  // Specify main and backup server
			$mail1->SMTPAuth = true;
			$mail1->SMTPKeepAlive = true; // Enable SMTP authentication
			$mail1->Username = $this->smtpuser;                            // SMTP username
			$mail1->Password = $this->smtppass;                          // SMTP password
			$mail1->SMTPSecure = 'SSL';
			$mail1->Port = 465;                            // Enable encryption, 'ssl' also accepted
			
			$mail1->From = $fromemail;
			$mail1->FromName = $fromname;
			$mail1->AddAddress($toemail);  // Add a recipient
						   // Name is optional
			
			//$mail->AddCC('nomi737@gmail.com');
			//$mail->AddBCC('uredens01@gmail.com');
			
			$mail1->WordWrap = 50;
	       if($attach!=''){ 
		   //echo "dfsf";                           // Set word wrap to 50 characters
				$mail1->AddAttachment($attach);         // Add attachments
			}                                 // Set word wrap to 50 characters
			//$mail->AddAttachment('/var/tmp/file.tar.gz');         // Add attachments
			//$mail->AddAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
			$mail1->IsHTML(true);                                  // Set email format to HTML
			
			$mail1->Subject = $subject;
			$mail1->Body    = $message;
			if(!$mail1->Send()) {
				
			    'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail1->ErrorInfo;
			   exit;
			}else{
				 "Mail sent Successfully";
			}	
		}
	
	}
	// canonical function ////
	function checkCanonical($page = ""){		
		if($_SESSION['urltype']==1){
			if (preg_match("/.php/i", $page)){
				$page = substr($page,0,-4);
				header("Location:".$this->site_url.$page);			
			}else
			if (preg_match("/.html/i", $page)){
				$page = substr($page,0,-5);
				header("Location:".$this->site_url.$page);			
			}else
			if (substr($page,-1)=="/"){
				$page = substr($page,0,-1);	
				header("Location:".$this->site_url.$page);					
			}
		}else
		if($_SESSION['urltype']==2){
			if ($page!="" && substr($page,-5)!=".html"){
				if (substr($page,-1)=="/"){			
					$page = substr($page,0,-1);							
				}
				$pageexpl = explode(".",$page);
				$page = $pageexpl[0];
				$page = $page.".html";
				header("Location:".$this->site_url.$page);			
			}
			
		}else
		if($_SESSION['urltype']==3){
			if ($page!="" && substr($page,-4)!=".php"){
				if (substr($page,-1)=="/"){			
					$page = substr($page,0,-1);							
				}
				$pageexpl = explode(".",$page);
				$page = $pageexpl[0];
				$page = $page.".php";
				header("Location:".$this->site_url.$page);			
			}
			
		}else
		if($_SESSION['urltype']==4){			
			if ($page!="" && substr($page,-1)!="/"){				
				$pageexpl = explode(".",$page);
				$page = $pageexpl[0];			
				$page = $page."/";
				header("Location:".$this->site_url.$page);	
			}	
		}
	}// end function
	function DeleteDir($path)
	{
		if (is_dir($path) === true)
		{
			$files = array_diff(scandir($path), array('.', '..'));
	
			foreach ($files as $file)
			{
				$this->DeleteDir(realpath($path) . '/' . $file);
			}
	
			return rmdir($path);
		}
	
		else if (is_file($path) === true)
		{
			return unlink($path);
		}
	
		return false;
	}
	
	function insertmechanics($tab,$id,$name,$parent,$imgpath){
		
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
				$path_product_image = $imgpath.$product_image;
				
					
			}
				
			//add to insert query
			$txtname=substr($key,4);
			$inserts .=$txtname.",";
			$vals .= "'".$product_image."',";
		}
		
		//remonvig last characther
		$inserts = rtrim($inserts,",");
		$vals = rtrim($vals,",");
		
		
		
		if($recnum=$this->InsertRecord($tab,$inserts,$vals))
		{
			$cmsurl = $this->completeURL($tab,$id,$recnum,$name,$parent);
			if($tab=="product_prd"){
				
				$caturl = $this->getSingdet("link_lk where idtab_lk = 3 and table_lk = 'content_cms'");	
				$caturl2=$caturl[0]['links_lk'];
			
				$cmsurl = $caturl2."/".$cmsurl;
			}
			
			if($cmsurl!=""){
				
			$inslink = "INSERT INTO link_lk(links_lk,table_lk,idtab_lk) values ('$cmsurl','$tab','$recnum')";
			$this->CustomModify($inslink);
			//echo $cmsurl.$inslink; die();
			if(isset($_POST['location'])){
				$inserts = "";
				$vals = "";
				if(count($_POST['location'])>0){
					for($i=0; $i<count($_POST['location']); $i++){
						$inserts .= "idprd_pc,";
						$vals .= "'".$recnum."',";
						$inserts .= "idcty_pc,";
						$vals .= "'".$_POST['location'][$i]."',";
						
						//removing last character comma
						$inserts = rtrim($inserts,",");
						$vals = rtrim($vals,",");
						$recnum12=$this->InsertRecord("prodcity_pc",$inserts,$vals); 
						$inserts = "";
						$vals = "";
					}
				}
			}
			
			if(isset($_POST['services'])){
				$inserts = "";
				$vals = "";
				if(count($_POST['services'])>0){
					for($i=0; $i<count($_POST['services']); $i++){
						$inserts .= "idprd_ps,";
						$vals .= "'".$recnum."',";
						$inserts .= "ids_ps,";
						$vals .= "'".$_POST['services'][$i]."',";
						
						//removing last character comma
						$inserts = rtrim($inserts,",");
						$vals = rtrim($vals,",");
						$recnum12=$this->InsertRecord("prodservice_ps",$inserts,$vals); 
						$inserts = "";
						$vals = "";
					}
				}
			}
			
			if(isset($_POST['brands'])){
				$inserts = "";
				$vals = "";
				if(count($_POST['brands'])>0){
					for($i=0; $i<count($_POST['brands']); $i++){
						$inserts .= "idprd_pb,";
						$vals .= "'".$recnum."',";
						$inserts .= "idbrand_pb,";
						$vals .= "'".$_POST['brands'][$i]."',";
						
						//removing last character comma
						$inserts = rtrim($inserts,",");
						$vals = rtrim($vals,",");
						$recnum12=$this->InsertRecord("prodbrand_pb",$inserts,$vals); 
						$inserts = "";
						$vals = "";
					}
				}
			}
			
			}
			
			
			$password=$this->hashthepass($_POST['pre_password_prd'],"lqx1PPUs6KkIC#nvgz@bc&");
			$q="update product_prd set password_prd='".$password."' where id_prd=".$recnum; 
			
			$this->CustomModify($q);
			//session code start
			
			$_SESSION['ID'] = $recnum;
			$_SESSION['login'] = $_POST['pre_name_prd'];
			$_SESSION['loginemail'] = $_POST['pre_email_prd'];
			
			//header('location:'.$this->site_url.'revieworder'.$_SESSION['URL']);
			//header('location:'.$this->site_url);	
			
			$this->msg = "Data added successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	
}

function updatemechanics($tab,$id,$name,$parent,$imgpath){
		
		
		if(!isset($_POST['button']))
	   {
		  
		return false;
	   }
		
		$inserts="";
		//arranging values of POST only
		
		foreach($_POST as $key=>$value) {
			$value = addslashes($value);
			//$value = mysql_real_escape_string($value);

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
				$user = "select * from ".$tab." where " .$id." = ".$_SESSION['ID'];
			 
				$userdata = $this->CustomQuery($user);
				
				
				
				if($userdata[0][$txtname] != '' and file_exists($imgpath.$userdata[0][$txtname]))
				{
					@unlink($imgpath.$userdata[0][$txtname]);
				
				}
				
				//upload new image
				$product_image=null;
				$product_image=strtolower($value['name']);
				$product_image=nowDirectImage($key,$imgpath,$this->upload_size_allowed);
				$path_product_image = $imgpath.$product_image;
				
				$inserts .=$txtname."='".$product_image."' ,";	
			}
					
		}
		//removing last character comma
		$inserts = rtrim($inserts,",");
		$data = $this->getSingdet(" link_lk where idtab_lk = ".$_SESSION['ID']." and table_lk = '$tab'");		
		//final passing for updation
		 $query = "update ".$tab." set ".$inserts."  where " .$id. " =".$_SESSION['ID'];
		
		
		
		
		if($rid2 = $this->CustomModify($query))
		{
			//update its url
			//$cmsurl = $this->filterName($_POST['pre_name_cms']);
			
			$cmsurl = $this->completeURL($tab,$id,$_SESSION['ID'],$name,$parent);
			
			if($tab=="product_prd"){
				
				$caturl = $this->getSingdet(" link_lk where idtab_lk = 3 and table_lk = 'content_cms'");	
				$caturl2=$caturl[0]['links_lk'];
			
				$cmsurl = $caturl2."/".$cmsurl;
			}
			
			$this->CustomModify("UPDATE link_lk SET  links_lk = '$cmsurl' where id_lk = '".$data[0]['id_lk']."' and table_lk = '$tab'");
			
			
			if(isset($_POST['location'])){
				$inserts = "";
				$vals = "";
				if(count($_POST['location'])>0){
					$del = $this->DeleteSetOfRecords("prodcity_pc","idprd_pc",$_SESSION['ID']);
					for($i=0; $i<count($_POST['location']); $i++){
						$inserts .= "idprd_pc,";
						$vals .= "'".$_SESSION['ID']."',";
						$inserts .= "idcty_pc,";
						$vals .= "'".$_POST['location'][$i]."',";
						//removing last character comma
						$inserts = rtrim($inserts,",");
						$vals = rtrim($vals,",");
						$recnum12=$this->InsertRecord("prodcity_pc",$inserts,$vals); 
						$inserts = "";
						$vals = "";
					}
				}
			}
			
			if(isset($_POST['services'])){
				$inserts = "";
				$vals = "";
				if(count($_POST['services'])>0){
					$del = $this->DeleteSetOfRecords("prodservice_ps","idprd_ps",$_SESSION['ID']);
					for($i=0; $i<count($_POST['services']); $i++){
						$inserts .= "idprd_ps,";
						$vals .= "'".$_SESSION['ID']."',";
						$inserts .= "ids_ps,";
						$vals .= "'".$_POST['services'][$i]."',";
						//removing last character comma
						$inserts = rtrim($inserts,",");
						$vals = rtrim($vals,",");
						$recnum12=$this->InsertRecord("prodservice_ps",$inserts,$vals); 
						$inserts = "";
						$vals = "";
					}
				}
			}
			if(isset($_POST['brands'])){
				$inserts = "";
				$vals = "";
				if(count($_POST['brands'])>0){
					$del = $this->DeleteSetOfRecords("prodbrand_pb","idprd_pb",$_SESSION['ID']);
					for($i=0; $i<count($_POST['brands']); $i++){
						$inserts .= "idprd_pb,";
						$vals .= "'".$_SESSION['ID']."',";
						$inserts .= "idbrand_pb,";
						$vals .= "'".$_POST['brands'][$i]."',";
						//removing last character comma
						$inserts = rtrim($inserts,",");
						$vals = rtrim($vals,",");
						$recnum12=$this->InsertRecord("prodbrand_pb",$inserts,$vals); 
						$inserts = "";
						$vals = "";
					}
				}
			}
			
			$this->msg = "Data added successfully.";
			return true;
		}else{
			$this->msg = "There was some problem in saving data, try again.";
			return false;
			
		}
		
	
}
	
    function showImage($image,$folder)
	{
		if($image<>'' && file_exists($this->absolute_path.$folder.$image))
		return $this->site_url.$folder.$image;
		else
		return $this->site_url."images/1.jpg";
	}
	////// PRE DEFINED WORDS //////
	function ConstantWords(){
		$allwords = $this->getAll(" words_w where status_w = '1' ");
		for($w=0; $w<count($allwords); $w++){
			define($allwords[$w]['constant_w'],$allwords[$w]['word_w']);
		}			
	}
function hashthepass($pass,$salt) // This is for the password encryption
	{
		return sha1($salt.$pass);
	}// end funcion
	
	// adminpanel page type return
	function PageType($pname){
		$pname = str_replace("_"," ",$pname);
		return ucfirst($pname);
	}// end function	
	
	function FileSizeConvert($bytes){
		
    $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

    foreach($arBytes as $arItem)
    {
        if($bytes >= $arItem["VALUE"])
        {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "." , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        }
    }
    return $result;
	}// end function
	function chkSize($type,$val,$parent){
		$q ="SELECT * FROM size_details WHERE size_type_id=".$type." AND value ='".$val."' AND parent_id=".$parent;
		$qry = $this->CustomQuery($q);
		if(count($qry)>0){
			return $qry[0]['id'];
		}
	}
	function insSize($type,$val,$parent){
		$exist = $this->chkSize($type,$val,$parent);
		if($exist > 0) return $exist; 
		$q = "insert into size_details(size_type_id,value,parent_id,status) values('".$type."','".$val."',".$parent.",1)";
		$chk=$this->CustomQuery($q);
		return mysqli_insert_id($this->DBlink); 
	}
	
	function slugify($text)
    {
     return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text)));
    }

}  // End of class
?>