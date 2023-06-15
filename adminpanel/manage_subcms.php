<?php include "dbcon.php"; ?>
<?php 
if($_SESSION['admins']['ID'] == ""){
	header("location:index.php");
}
/*VERY IMPORTANT TO DECODE THE GET PAREMETER FIRST*/
$_GET['cid'] = base64_decode($_GET['cid']);
/*VERY IMPORTANT TO DECODE THE GET PAREMETER ENDS*/
/*multiple deletion*/
if(isset($_REQUEST['multidelete'])){
	$imgfields = array('image_name_cms','thumb_name_cms');
	$chk = $general->delmulti("content_cms","id_cms",$conf->absolute_path.$conf->general_dir,$imgfields);
	echo $chk; exit();	
}
/*single deletion*/
if(isset($_GET['id'])){
	$imgfields = array('image_name_cms','thumb_name_cms');
	$chk = $general->delGenDetails("content_cms","id_cms",$conf->absolute_path.$conf->general_dir,$imgfields);
	echo $chk; exit();
}
/*sortion*/
if(isset($_POST['sortion'])){
	$chk = $general->sortDataGeneral("content_cms","order_cms","id_cms");
}
/*status updation*/
if(isset($_GET['status'])){
	$_GET['st_id'] = base64_decode($_GET['st_id']);
	if($_GET['status']=='Inactive'){
		$general->UpdStatus("content_cms","id_cms","status_cms",0,$_GET['st_id']);		
	} 
	else{
		 $general->UpdStatus("content_cms","id_cms","status_cms",1,$_GET['st_id']);
	}
}
/*status updation ends */
// parent id as a parameter
$optbyid=$general->getAll(" content_cms where parent_cms = ".$_GET['cid']." order by order_cms ");
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
            Manage Content
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=$conf->site_url?>adminpanel/dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Manage Content</li>
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
                  <h3 class="box-title" style="float:right !important;"><a href="add_cms.php?cid=<?=base64_encode($_GET['cid'])?>">Add Content</a></h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">                
                <? if(is_array($optbyid)){ ?>
                  <form id="frm" name="manageform" method="post" action="">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                      	<th class="no-sort"><input id="selectall" class="check-all" type="checkbox" /></th>
                        <th>Name</th>
                        <th class="no-sort">Status</th>
                        <th class="no-sort">Order</th>
                        <th class="no-sort">&nbsp;</th>                        
                      </tr>
                    </thead>
                    <tbody>
                    <? for($d=0; $d<count($optbyid); $d++){
						$child=$cms->getSubCMS($optbyid[$d]['id_cms']); ?>
                    	<tr>
                        	<td><input type="checkbox" name="checkbox[]" class="case" value="<? echo $optbyid[$d]['id_cms'];?>" /></td>
                        	<td><? 
							if(is_array($child)){?><a href="manage_subcms.php?cid=<?=base64_encode($optbyid[$d]['id_cms'])?>"><?=$optbyid[$d]['name_cms']; if($conf->ar==1){ echo " | ".$optbyid[$d]['namear_cms'];}  ?></a><? 
							}else{ ?><?=$optbyid[$d]['name_cms'];if($conf->ar==1){ echo " | ".$optbyid[$d]['namear_cms'];} 
							} ?></td>
                            <td><? if($optbyid[$d]['status_cms']==1)
				   { ?><a href='?status=Inactive&st_id=<?=base64_encode($optbyid[$d]['id_cms'])?>&cid=<?=base64_encode($_GET['cid'])?>'>Active</a><? }  else { ?><a href='?status=Active&st_id=<?=base64_encode($optbyid[$d]['id_cms'])?>&cid=<?=base64_encode($_GET['cid'])?>'>Inactive</a><? } ?></td>
                            <td><input type="text" size="1" name="ordsort_<?php echo $optbyid[$d]['id_cms'];?>" value="<?=$optbyid[$d]['order_cms']?>" /></td>
                            <td style="text-align:center !important;">
                            <?php /*?><a href="#" class="view" id="<?php echo $optbyid[$d]['id_cms']?>" ><img src="dist/img/icons/view.png" alt="Edit" /></a><?php */?>
                            <a href="update_cms.php?id=<?php echo base64_encode($optbyid[$d]['id_cms'])?>" target="_self" title="Edit"><img src="dist/img/icons/pencil.png" alt="Edit" /></a> 
							<a href="#" class="delete" id="<? echo $optbyid[$d]['id_cms'];?>"><img src="dist/img/icons/cross.png" alt="Delete" /></a>
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
