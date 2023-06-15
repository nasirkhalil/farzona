<?php include "dbcon.php"; ?>
<?php 
if($_SESSION['admins']['ID'] == ""){
	header("location:index.php");
}
$_GET['cid'] = base64_decode($_GET['cid']);
/*multiple deletion*/
if(isset($_REQUEST['multidelete'])){
	$imgfields = array('name_img');
	$chk = $general->delmulti("prdimages_img","id_img",$conf->absolute_path.$conf->gallery_dir,$imgfields);
	echo $chk; exit();	
}
/*single deletion*/
if(isset($_GET['id'])){
	$imgfields = array('name_img');
	$chk = $general->delGenDetails("prdimages_img","id_img",$conf->absolute_path.$conf->gallery_dir,$imgfields);
	echo $chk; exit();
}
if(isset($_POST['sortion'])){
	$chk = $general->sortDataGeneral("prdimages_img","order_img","id_img");	
}
if(isset($_GET['status'])){
	$_GET['st_id'] = base64_decode($_GET['st_id']);
	if($_GET['status']=='Inactive'){
		
		$qry= "UPDATE prdimages_img set status_img='0' where id_img=".$_GET['st_id'];
		$general->CustomModify($qry);
	 
	} 
	else{
		 
		 $qry1= "UPDATE prdimages_img set status_img='1' where id_img=".$_GET['st_id'];
		 $general->CustomModify($qry1);		
		
	}
}
//echo " prdimages_img where idprd_img = ".$_GET['cid']." and type_img='".$_REQUEST['type']."' order by order_img";
$optbyid=$general->getAll(" prdimages_img where idprd_img = ".$_GET['cid']." order by order_img");
?>
<!DOCTYPE html>
<html>
  <?php include "inc_head.php";
  $prdtype = $_GET['type']; ?>
  <body class="hold-transition skin-blue sidebar-mini">
  	<!--DIALOG BOXES-->
    <div id="confirmation_dialog" title="Delete Confirmation" style="display:none">
      <p>Are you sure,you want to delete this record ?</p>
    </div>
    <div id="confirmation_dialog_multi" title="Delete Confirmation" style="display:none">
      <p>Are you sure,you want to delete these selected records. ?</p>
    </div>
    <div id="dialog-message" title="Message" style="display:none;">
      <p> <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;  "></span> Record has been deleted Successfully . </p>
    </div>
    
    <div id="view_dialog" title="View Details" style="display:none">
      <span id="viewdets"></span>
    </div>
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
            Manage Product Images
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=$conf->site_url?>adminpanel/dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
             <? if($prdtype=='project'){?>
            <li><a href="<?=$conf->site_url?>adminpanel/manage_project.php"><i class="fa fa-dashboard"></i> Manage <?=$prdtype?></a></li>
            <? }else{?>
            <li><a href="<?=$conf->site_url?>adminpanel/manage_products.php"><i class="fa fa-dashboard"></i> Manage <?=$prdtype?></a></li>
            <? }?>
            <li class="active">Manage Product Images</li>
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
                  <h3 class="box-title" style="float:right !important;"><a href="add_prd_gallery.php?cid=<?=base64_encode($_GET['cid'])?>">Add More Images</a></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                <? if(is_array($optbyid)){ ?>
                  <form id="frm" name="manageform" method="post" action="">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                      	<th class="no-sort"><input id="selectall" class="check-all" type="checkbox" /></th>                        
                        <th class="no-sort">Image</th>
                        <th class="no-sort">Status</th>
                        <th class="no-sort">Order</th>
                        <th class="no-sort">&nbsp;</th>                        
                      </tr>
                    </thead>
                    <tbody>
                    <?  
					for($d=0; $d<count($optbyid); $d++){?>
                    	<tr>
                        <td><input type="checkbox" name="checkbox[]" class="case" value="<? echo $optbyid[$d]['id_img'];?>" /></td>
                        <td><img src="<?=$conf->site_url.$conf->gallery_dir.$optbyid[$d]['name_img']?>" width="500" /></td>
                            <td><? if($optbyid[$d]['status_img']==1)
				   { ?><a href='?status=Inactive&cid=<?=base64_encode($_GET['cid'])?>&st_id=<?=base64_encode($optbyid[$d]['id_img'])?>'>Active</a><? }  else { ?><a href='?status=Active&cid=<?=base64_encode($_GET['cid'])?>&st_id=<?=base64_encode($optbyid[$d]['id_img'])?>'>Inactive</a><? } ?></td>
                            <td><input type="text" size="1" name="ordsort_<?php echo $optbyid[$d]['id_img'];?>" value="<?=$optbyid[$d]['order_img']?>" /></td>
                            <td style="text-align:center !important;">
                            <a href="update_prd_gallery.php?id=<?php echo base64_encode($optbyid[$d]['id_img'])?>" target="_self" title="Edit"><img src="dist/img/icons/pencil.png" alt="Edit" /></a>
                            <a href="#" class="delete" id="<? echo $optbyid[$d]['id_img'];?>"><img src="dist/img/icons/cross.png" alt="Delete" /></a>
                            </td>
                        </tr>
                    <? } ?>  
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="5" style="text-align:right;">
                        <!--delete button-->
                        <input type="button" name="delete" class="btn btn-primary delmulti" value="Delete Selected" />
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
