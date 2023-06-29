<? $nav=$general->getAll("content_cms where parent_cms=0 and origin_cms='menu' order by id_cms"); //print_r($nav); die();?>
<div class="header">
	<div class="container">

			<nav class="navbar navbar-expand-lg navbar-light">
  <a class="navbar-brand" href="<?=$conf->site_url?>"><img src="<?=$conf->site_url?>images/logo.png" alt="" class="img-fluid"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ml-auto">
     
      <li class="nav-item active"><a class="nav-link" href="<?=$conf->site_url?>"><?=$nav[0]['name_cms']?></a></li>
      <? $seabout = $general->getAll("content_cms where parent_cms='".$nav[1]['id_cms']."' and status_cms=1 order by order_cms");?>
      <? if(is_array($seabout)){?>
      
         <li class="nav-item dropdown">
       <!-- <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          About Us
        </a>-->
        <a class="nav-link dropdown-toggle" href="<?=$conf->site_url.$general->smartURLnew2("content_cms",$nav[1]['id_cms'])?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?=$nav[1]['name_cms']?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <? for($s=0;$s<count($seabout);$s++){?>
          <a class="dropdown-item" href="<?=$conf->site_url.$general->smartURLnew2("content_cms",$seabout[$s]['id_cms'])?>"><?=$seabout[$s]['name_cms']?></a>
          <? }?>
          <!--<a class="dropdown-item" href="#">Introduction</a>
          <a class="dropdown-item" href="#">Organization Chart</a>
          <a class="dropdown-item" href="#">Our Team</a>-->
        </div>
      </li>
      <? } else {?>
      <li class="nav-item"><a class="nav-link" href="<?=$conf->site_url.$general->smartURLnew2("content_cms",$nav[1]['id_cms'])?>"><?=$nav[1]['name_cms']?></a></li>
      <? }?>
      <!--<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Services
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="#">Architectural Services</a>
          <a class="dropdown-item" href="#">Pre- Contractact Services</a>
          <a class="dropdown-item" href="#">Post Contract Services</a>
        </div>
      </li>-->
      <? $servc = $general->getAll("content_cms where parent_cms='".$nav[2]['id_cms']."' and status_cms=1 order by order_cms");?>
      <? if(is_array($servc)){?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="<?=$conf->site_url.$general->smartURLnew2("content_cms",$nav[2]['id_cms'])?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?=$nav[2]['name_cms']?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <? for($s=0;$s<count($servc);$s++){?>
          <a class="dropdown-item" href="<?=$conf->site_url.$general->smartURLnew2("content_cms",$servc[$s]['id_cms'])?>"><?=$servc[$s]['name_cms']?></a>
          <? }?>
        </div>
      </li>
      
      <? } else {?>
      <li class="nav-item"><a class="nav-link" href="<?=$conf->site_url.$general->smartURLnew2("content_cms",$nav[2]['id_cms'])?>"><?=$nav[2]['name_cms']?></a></li>
      <? }?>
 <? $prodcat = $general->getAll("category_cat where status_cat=1 order by order_cat");?>
<? if(is_array($prodcat)){?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="<?=$conf->site_url.$general->smartURLnew2("content_cms",$nav[3]['id_cms'])?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?=$nav[3]['name_cms']?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <? for($s=0;$s<count($prodcat);$s++){?>
          <a class="dropdown-item" href="<?=$conf->site_url.$general->smartURLnew2("category_cat",$prodcat[$s]['id_cat'])?>"><?=$prodcat[$s]['name_cat']?></a>
          <? }?>
        </div>
      </li>
      
      <? } else {?>
      <li class="nav-item"><a class="nav-link" href="<?=$conf->site_url.$general->smartURLnew2("content_cms",$nav[3]['id_cms'])?>"><?=$nav[3]['name_cms']?></a></li>
      <? }?>

       
          <li class="nav-item"><a class="nav-link" href="<?=$conf->site_url.$general->smartURLnew2("content_cms",$nav[4]['id_cms'])?>"><?=$nav[4]['name_cms']?></a></li>
           <li class="nav-item"><a class="nav-link" href="<?=$conf->site_url.$general->smartURLnew2("content_cms",$nav[5]['id_cms'])?>"><?=$nav[5]['name_cms']?></a></li>
    </ul>
  </div>
</nav>
	</div><!--END OF CONTAINER-->
</div>