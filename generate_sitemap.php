<?
include "main-dbcon.php";
$myFile = "sitemap.xml";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = "<?xml version='1.0' encoding='UTF-8'?>
<urlset xmlns='http://www.google.com/schemas/sitemap/0.84'>
<url>  
    <loc>".$conf->site_url."</loc>  
    <changefreq>daily</changefreq>  
    <priority>1</priority>  
</url>";




	$cms=$general->getAll("content_cms where parent_cms=0 and id_cms Not IN(1,12,13,14,15,18,19) and origin_cms = 'menu' order by id_cms ");
    if(is_array($cms)){ 
	
		for($a=0;$a<count($cms);$a++){ 
		
			
		$alink=$general->smartURLnew2('content_cms',$cms[$a]['id_cms']);
			
$stringData.="  
				<url>  
				<loc>".$conf->site_url.$alink."</loc>  
				<changefreq>daily</changefreq>  
				<priority>1</priority>  
				</url>"; 
            $cms1=$general->getAll("content_cms where parent_cms=".$cms[$a]['id_cms']);
            if($cms1!=""){
				
				for($b=0;$b<count($cms1);$b++) { 
				
				
					
				$aalink=$general->smartURLnew2("content_cms",$cms1[$b]['id_cms']);
					
$stringData.="  
						<url>  
						<loc>".$conf->site_url.$aalink."</loc>  
						<changefreq>daily</changefreq>  
						<priority>1</priority>  
						</url>"; 
				
				
				
				
			}
        	} 
		}
	}
  $pcatg = $general->getAll("category_cat where status_cat=1 order by order_cat");
   if($pcatg!=""){
				
				for($pps=0; $pps<count($pcatg); $pps++){  
				
				
					
				$aalink=$general->smartURLnew2("category_cat",$pcatg[$pps]['id_cat']);
					
$stringData.="  
						<url>  
						<loc>".$conf->site_url.$aalink."</loc>  
						<changefreq>daily</changefreq>  
						<priority>1</priority>  
						</url>"; 
				 $prodct=$general->getAll("product_prd where idcat_prd=".$pcatg[$pps]['id_cat']." and status_prd='1' order by order_prd");
            if($prodct!=""){
				
				for($pp=0; $pp<count($prodct); $pp++){  
				
				
					
				$aalink=$general->smartURLnew2("product_prd",$prodct[$pp]['id_prd']);
					
$stringData.="  
						<url>  
						<loc>".$conf->site_url.$aalink."</loc>  
						<changefreq>daily</changefreq>  
						<priority>1</priority>  
						</url>"; 
				
				
				
				
			
        	} 
		}
				
				
				
			
        	} 
		}
					
				
				 
          
	
		
///



$stringData.="</urlset>";
fwrite($fh, $stringData);
//$stringData = "Tracy Tanner\n";
//fwrite($fh, $stringData);
fclose($fh);
?>
<title>Generate Sitemap</title>


<form action="" method="post" enctype="multipart/form-data" name="frm" id="frm" >
  <table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#999999">
    <tr>
      <td><table width="100%" height="180" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#A59C72" class="tableborder">
          <tr>
            <td height="25" colspan="5" align="center" valign="middle" class="TitleBackGroundColor"><strong class="pt12_wht_bold">Generate Site Map</strong></td>
          </tr>
          <tr>
            <td height="25" colspan="5" align="center" valign="middle" bgcolor="#FFFFFF"><strong class="pt12_red"><? echo "Site Map Generated Successfully";?></strong></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
