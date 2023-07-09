<? 
include "main-dbcon.php";
$pageexpl = explode(".",$page);
$page = $pageexpl[0];
 
if(substr($page, -1)=="/"){
	$page = rtrim($page,"/");
}
//echo $page; die();
//$page=substr($page,3); 

//die($page);
if($page=='' || $page=='index'){
	//include "home.php";
}
elseif($page!=''){
	if(file_exists($general->absolute_path.$page.".php")){
		
		include $page.".php";
		exit();
	}else{
		$pagedetails = $general->getSingdet("link_lk where LOWER(links_lk) = '".$page."'");
        $meta = $general->get_metathings($pagedetails[0]['table_lk'],$pagedetails[0]['idtab_lk']);
		if($pagedetails[0]['table_lk']=="content_cms"){
			if($pagedetails[0]['idtab_lk']==8){
					include "contactus.php";
				exit();
			}elseif($pagedetails[0]['idtab_lk']==4){
					include "category_listing.php";
				exit();
			}elseif($pagedetails[0]['idtab_lk']==7){
					include "client-listing.php";
				exit();
			}elseif($pagedetails[0]['idtab_lk']==34){
					include "user_updprofile.php";
				exit();
			}elseif($pagedetails[0]['idtab_lk']==19){
					include "searchresult.php";
				exit();
			}elseif($pagedetails[0]['idtab_lk']==20){
					include "site-map.php";
				exit();
			}elseif($pagedetails[0]['idtab_lk']==37){
					include "orderdetails.php";
				exit();
			}elseif($pagedetails[0]['idtab_lk']==22){
					include "search_result.php";
				exit();
			}elseif($pagedetails[0]['idtab_lk']==39){
					include "thankyou.php";
				exit();
			}
			else{
				include "content.php";
				exit();
			}			
		}
		
		elseif($pagedetails[0]['table_lk']=="category_cat"){
			
			//if($general->getSingleField("category_cat","id_cat",$pagedetails[0]['idtab_lk'],"parent_cat")==0){
			//die("fdsf");
			//include "listing.php";
			//exit();
			//}else{
				
				
				
				include "zz_module/product/product_listing.php";
				exit();
			//}
			
			
		}
			
	
		elseif($pagedetails[0]['table_lk']=="product_prd"){
			
			include "zz_module/product/product_detail.php";
			exit();
			
		}
		
		else{
			header("Location:".$conf->site_url."404");
			//exit();
		}
	}
}
?>