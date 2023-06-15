<?php include "dbcon.php"; ?>
<?php 
if($_SESSION['admins']['ID'] == ""){
	header("location:index.php");
}
// decode get variables //
if(isset($_GET['cid'])){
	$_GET['cid'] = base64_decode($_GET['cid']);
}
/*multiple deletion*/
if(isset($_REQUEST['multidelete'])){
	$imgfields = array('image_cat','thumb_name_cat');
	$chk = $general->delmulti("category_cat","id_cat",$conf->absolute_path.$conf->category_dir,$imgfields);
	echo $chk; exit();	
}
/*single deletion*/
if(isset($_GET['id'])){
	$imgfields = array('image_cat','thumb_name_cat');
	$chk = $general->delGenDetails("category_cat","id_cat",$conf->absolute_path.$conf->category_dir,$imgfields);
	echo $chk; exit();
}
/*sortion*/
if(isset($_POST['sortion'])){
	$chk = $general->sortDataGeneral("category_cat","order_cat","id_cat");	
}
/*status updation*/
if(isset($_GET['status'])){
	$_GET['st_id'] = base64_decode($_GET['st_id']);
	if($_GET['status']=='Inactive'){
		$general->UpdStatus("category_cat","id_cat","status_cat",0,$_GET['st_id']);		
	} 
	else{
		 $general->UpdStatus("category_cat","id_cat","status_cat",1,$_GET['st_id']);
	}
}
if(isset($_GET['show'])){
	$_GET['gi_id'] = base64_decode($_GET['gi_id']);
	if($_GET['show']=='No'){
		$general->UpdStatus("category_cat","id_cat","showgallery_cat",0,$_GET['gi_id']);		
	} 
	else{
		 $general->UpdStatus("category_cat","id_cat","showgallery_cat",1,$_GET['gi_id']);
	}
}
/*status updation ends */
/* get categories*/
if(isset($_GET['cid'])){
	$optbyid = $general->getAll(" category_cat where parent_cat = ".$_GET['cid']." order by order_cat ");
}else{
	//echo " category_cat  order by order_cat ";
	$optbyid = $general->getAll(" category_cat  order by order_cat ");
}
?>
<!DOCTYPE html>
<html>
  <?php include "inc_head.php"; ?>
  <body class="hold-transition skin-blue sidebar-mini">
  	<!--DIALOG BOXES-->
    <?php include "inc_dialogboxes.php"; ?>
	<!--DIALOG BOXES ENDS-->
  	<div class="wrapper">

      <?php include "inc_header.php"; ?>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <?php include "inc_leftsidebar.php"; ?>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Manage <?=$general->PageType($pagetype);?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=$conf->site_url?>adminpanel/dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Manage <?=$general->PageType($pagetype);?></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                <?php if(isset($_POST['sortion'])){
					if($chk){?> 
                	<!-- success alert -->
                    <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check"></i> <?=$general->msg?>
                  </div>
                	<!-- success alert ends -->  
                    <? }else{ ?>
                	<!-- not success alert -->
                    <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i> <?=$general->msg?>
                  </div>
                	<!-- Not success alert ends -->
                <? 	   }
				} ?>    
                  <h3 class="box-title" style="float:right !important;"><a href="add_<?=$pagetype?>.php">Add <?=$general->PageType($pagetype);?></a></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                <? if(is_array($optbyid)){ ?>
                  <form id="frm" name="manageform" method="post" action="">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                      	<th class="no-sort"><input id="selectall" class="check-all" type="checkbox" /></th>                        
                        <th>Title</th>
                        <th class="no-sort">Status</th>
                        <th class="no-sort">Show gallery</th>
                        <th class="no-sort">Order</th>
                        <th class="no-sort">&nbsp;</th>                        
                      </tr>
                    </thead>
                    <tbody>
                    <? for($d=0; $d<count($optbyid); $d++){ ?>
                    	<tr>
                        	<td><input type="checkbox" name="checkbox[]" class="case" value="<? echo $optbyid[$d]['id_cat'];?>" /></td>                        	
                            <td><?php /*?><img src="<?=$conf->site_url.$conf->category_dir.$optbyid[$d]['thumb_name_cat']?>" width="20%" /><?php */?> <? if(is_array($child)){?><a href="manage_categories.php?cid=<?=base64_encode($optbyid[$d]['id_cat'])?>"><?=$optbyid[$d]['name_cat']; if($conf->ar==1){ echo " | ".$optbyid[$d]['namear_cat'];}  ?></a><? 
							}else{
								 ?><?=$optbyid[$d]['name_cat']; if($conf->ar==1){ echo " | ".$optbyid[$d]['namear_cat'];} 
							} ?></td>
                            <td><? if($optbyid[$d]['status_cat']==1)
				   { ?><a href='?status=Inactive&st_id=<?=base64_encode($optbyid[$d]['id_cat'])?>'>Active</a><? }  else { ?><a href='?status=Active&st_id=<?=base64_encode($optbyid[$d]['id_cat'])?>'>Inactive</a><? } ?></td>
                   <td><? if($optbyid[$d]['showgallery_cat']==1)
				   { ?><a href='?show=No&gi_id=<?=base64_encode($optbyid[$d]['id_cat'])?>'>Yes</a><? }  else { ?><a href='?show=Yes&gi_id=<?=base64_encode($optbyid[$d]['id_cat'])?>'>No</a><? } ?></td>
                            <td><input type="text" size="1" name="ordsort_<?php echo $optbyid[$d]['id_cat'];?>" value="<?=$optbyid[$d]['order_cat']?>" /></td>
                            <td style="text-align:center !important;">
                            <a href="manage_prd_gallery.php?cid=<?php echo base64_encode($optbyid[$d]['id_cat'])?>&type=category" target="_self" title="Gallery"><img src="dist/img/icons/addimage.png" alt="Edit" /></a>
                            
                            <a href="update_<?=$pagetype?>.php?id=<?php echo base64_encode($optbyid[$d]['id_cat'])?>" target="_self" title="Edit"><img src="dist/img/icons/pencil.png" alt="Edit" /></a>
                            <a href="#" class="delete" id="<? echo $optbyid[$d]['id_cat'];?>"><img src="dist/img/icons/cross.png" alt="Delete" /></a>
                            </td>
                        </tr>
                    <? } ?>  
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="5" style="text-align:right;">
                        <!--delete button-->
                        <input type="button" name="sortion" class="btn btn-primary delmulti" value="Delete Selected" />
                        <!--sortion button-->
                        <input type="submit" name="sortion" class="btn btn-primary" value="Update Order" /></th>                        
                      </tr>
                    </tfoot>
                  </table>
                  </form>
                <? }else{ ?>
                	<p>No Data Found</p>
                <? } ?>  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php include "inc_footer.php"; ?>
    </div><!-- ./wrapper -->
    <?php include "inc_scripts.php"; ?>    
<?php include "inc_managescripts.php"; ?>
  </body>
</html>
