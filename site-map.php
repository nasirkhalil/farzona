<? $content = $general->getSingdet(" content_cms where id_cms = ".$pagedetails[0]['idtab_lk']);?>
<? include"inc_head.php";?>

<body>
<div class="se-pre-con"></div>
<? include"inc_header.php";?><!--END OF HEADER--->

<div class="banner">
				<div id="carousel" class="carousel slide h-100 carousel-fade" data-ride="carousel">
				  <div class="carousel-inner h-100">
					<div class="carousel-item active h-100">
					  <!--<img class="d-block w-100 img-fluid h-100" src="images/banner1.jpg" alt="">-->
                      <img src="<? if($content[0]['image_name_cms']!="" && file_exists($conf->absolute_path.$conf->general_dir.$content[0]['image_name_cms'])){echo $conf->site_url.$conf->general_dir.$content[0]['image_name_cms'];}else{ echo $conf->site_url."images/about.jpg"; }?>" alt="<?=$content[0]['image_alt_cms']?>" title="<?=$content[0]['image_title_cms']?>" class="d-block w-100 img-fluid h-100">
					</div><!--END OF CAROUSEL ITEM-->
					<!--END OF CAROUSEL ITEM-->
				  </div><!--END OF CAROUSEL INNER-->
				</div><!--END OF CAROUSEL-->
</div><!--END OF BANNER-->

<div class="content">
<div class="container">
	<div class="col-md-8 offset-md-4 bg_white">
		<div class="breds">
		<!--<ul class="list-unstyled">
			<li><a href="#">Home</a></li>
			<li>About Us</li>
		</ul>-->
        <ul class="list-unstyled">
			<li><a href="<?=$conf->site_url?>"><?=$nav[0]['name_cms']?></a></li>
            <? if($content[0]['parent_cms']!=0){
					$parent = $general->getSingdet("content_cms where id_cms = ".$content[0]['parent_cms']); ?>
                	<li><a href="<? if($content[0]['parent_cms']==3){ $conf->site_url.$general->smartURLnew2("content_cms",$parent[0]['id_cms']);}?>"><?=$parent[0]['name_cms']?></a></li>
                <? } ?>
			<li><?=$content[0]['name_cms']?></li>
		</ul>
		
		<h3><?=$content[0]['name_cms']?></h3>
</div><!--END OF BREDS-->

<div class="about">
<? $cms=$general->getAll("content_cms where parent_cms=0 and id_cms Not IN(8,12,13,14,15,18,19) and origin_cms='menu'") ?> 
        <? if(is_array($cms)){ ?>
        <h4>Cms</h4>
             <ul>
      <? for($a=0; $a<count($cms); $a++){ ?>
      
       
       <? $link=$general->smartURLnew2("content_cms",$cms[$a]['id_cms']) ?>
       <? if($cms[$a]['id_cms']==1){?>
       <li><a href="<?=$conf->site_url?>"><?=$cms[$a]['name_cms'] ?> </a> </li>
       <? }else {?>
       
 		<li><a href="<?=$conf->site_url.$link?>"><?=$cms[$a]['name_cms'] ?> </a>
        
        <? $cmschilds = $general->getAll(" content_cms where parent_cms = ".$cms[$a]['id_cms']." and parent_cms!=9 and status_cms = '1' order by order_cms "); ?>
        
        
        <? if(is_array($cmschilds)){ ?>      
      <ul>
		<? for($aa=0;$aa<count($cmschilds); $aa++){ ?>      
        <li>&nbsp;&nbsp;&nbsp;<a href="<?=$conf->site_url.$general->smartURLnew2("content_cms",$cmschilds[$aa]['id_cms']);?>"><?=$cmschilds[$aa]['name_cms']?></a></li>
       
        <? } // cms childs loop end ?><br>

         
      </ul>
	<? } // cms childs if condition end ?>  
        
        
         </li>
     
      
       <?  }  }?>
       
       <li><a href="<?=$conf->site_url.$general->smartURLnew2("content_cms",$nav[5]['id_cms']);?>"><?=$nav[5]['name_cms']?></a></li> 
       </ul>
     	 <? }?>
      
      
     <? $pcatg = $general->getAll("category_cat where status_cat=1 order by order_cat");?> 
      <? if(is_array($pcatg)){?>
      <h4>Category & Projects</h4>
      <ul>
      
<? for($s=0;  $s<count($pcatg); $s++){ ?>
<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$conf->site_url.$general->smartURLnew2("category_cat",$pcatg[$s]['id_cat'])?>"><?=$pcatg[$s]['name_cat']?></a></li>
    
        <? $prodct=$general->getAll("product_prd where idcat_prd=".$pcatg[$s]['id_cat']." and status_prd='1' order by order_prd");
if(is_array($prodct)){?>
<ul>
<? for($pp=0; $pp<count($prodct); $pp++){ ?>
<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$conf->site_url.$general->smartURLnew2("product_prd",$prodct[$pp]['id_prd'])?>"><?=$prodct[$pp]['name_prd']?></a></li>
<? }?>

</ul>
<? }?>
      
      <? }?>
      </ul>
      <? }?> 
         
     
         
         
         
<!--<p>Architectural Corner operates in Dubai since 1976 as an architectural and engineering consultancy. Ithas been involved as the architectural and engineering consultant in the growth of Dubai, particularly the Jebel Ali Free Zone, and other industrial zones in Dubai.</p>

<p>Under present management since 2008, Architectural Corner has expanded the scope of the design work in the UAE and abroad, and has worked on various industrial, commercial and residential projects as the lead or design consultant.</p>

<h4>Organization</h4>

<p>Having been established in UAE since 1976, involved in various kinds of projects ranging from residential and commercial to logistic and industrial buildings. With our experienced and committed staff, we offer complete architectural solutions including execution supervision.</p>

<h4>Design Philosophy</h4>
<p>We provide end-to-end professional services, which encapsulate our commitment vision with our tailormade solutions. Our infrastructure & support systems have been developed over a period of time to provide functional, economical and special accent on quality, time and aesthetics.</p>-->

</div><!--END OF CONTACT-->

</div><!--END OF COL MD 11--->
</div><!--END OF CONTAINER--->


</div><!--END OF CONTENT-->




<? include"inc_footer.php";?><!--END OF FOOTER-->

<? include"inc_script.php";?>