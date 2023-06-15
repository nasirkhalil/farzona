<?php include "dbcon.php"; ?>
<?php 
if($_SESSION['admins']['ID'] == ""){
	header("location:index.php");
}
/*multiple deletion*/
if(isset($_REQUEST['multidelete'])){
	$imgfields = array('image_name_ph');
	$chk = $general->delmultiPhotographer("photographer_ph","id_ph",$conf->absolute_path.$conf->photographer_dir,$imgfields);
	echo $chk; exit();	
}
/*single deletion*/
if(isset($_GET['id'])){
	$imgfields = array('image_name_ph');
	$chk = $general->delPhotographer("photographer_ph","id_ph",$conf->absolute_path.$conf->photographer_dir,$imgfields);
	echo $chk; exit();
}
/*sortion*/
if(isset($_POST['sortion'])){
	$chk = $general->sortDataGeneral("photographer_ph","order_ph","id_ph");	
}
/*status updation*/
if(isset($_GET['status'])){
	$_GET['st_id'] = base64_decode($_GET['st_id']);
	if($_GET['status']=='Inactive'){
		$general->UpdStatus("photographer_ph","id_ph","status_ph",0,$_GET['st_id']);		
	} 
	else{
		 $general->UpdStatus("photographer_ph","id_ph","status_ph",1,$_GET['st_id']);
	}
}
/*status updation ends */
/* get all banners by origin */
$optbyid = $general->getAll(" photographer_ph order by order_ph ");
?>
<!DOCTYPE html>
<html>
  <?php include "inc_head.php"; ?>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th class="no-sort">Mobile</th>
                        <th>Location</th>
                        <th class="no-sort">Status</th>
                        <th class="no-sort">Order</th>
                        <th class="no-sort">Actions</th>                        
                      </tr>
                    </thead>
                    <tbody>
                    <? for($d=0; $d<count($optbyid); $d++){?>
                    	<tr>
                        	<td><input type="checkbox" name="checkbox[]" class="case" value="<? echo $optbyid[$d]['id_ph'];?>" /></td>                        	
                            <td><?=$optbyid[$d]['name_ph']?></td>
                            <td><?=$optbyid[$d]['email_ph']?></td>
                            <td><?=$optbyid[$d]['mobile_ph']?></td>
                            <td><?=$optbyid[$d]['location_ph']?></td>
                            <td><? if($optbyid[$d]['status_ph']==1)
				   { ?><a href='?status=Inactive&st_id=<?=base64_encode($optbyid[$d]['id_ph'])?>'>Active</a><? }  else { ?><a href='?status=Active&st_id=<?=base64_encode($optbyid[$d]['id_ph'])?>'>Inactive</a><? } ?></td>
                            <td><input type="text" size="1" name="ordsort_<?php echo $optbyid[$d]['id_ph'];?>" value="<?=$optbyid[$d]['order_ph']?>" /></td>
                            <td style="text-align:center !important;">
                            <a href="update_<?=$pagetype?>.php?id=<?php echo base64_encode($optbyid[$d]['id_ph'])?>" target="_self" title="Edit"><img src="dist/img/icons/pencil.png" alt="Edit" /></a>
                            <a href="#" class="delete" id="<? echo $optbyid[$d]['id_ph'];?>"><img src="dist/img/icons/cross.png" alt="Delete" /></a>
                            </td>
                        </tr>
                    <? } ?>  
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="8" style="text-align:right;">
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
