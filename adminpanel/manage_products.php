<?php include "dbcon.php"; ?>
<?php 
if($_SESSION['admins']['ID'] == ""){
	header("location:index.php");
}
/*multiple deletion*/
if(isset($_REQUEST['multidelete'])){
	$imgfields = array('image_name_prd','thumb_name_prd');
	$chk = $general->delmulti("product_prd","id_prd",$conf->absolute_path.$conf->product_dir,$imgfields);
	echo $chk; exit();	
}
/*single deletion*/
if(isset($_GET['id'])){
	$imgfields = array('image_name_prd','thumb_name_prd');
	$chk = $general->delGenDetails("product_prd","id_prd",$conf->absolute_path.$conf->product_dir,$imgfields);
	echo $chk; exit();
}
/*sortion*/
if(isset($_POST['sortion'])){
	$chk = $general->sortDataGeneral("product_prd","order_prd","id_prd");	
}
/*status updation*/
if(isset($_GET['status'])){
	$_GET['st_id'] = base64_decode($_GET['st_id']);
	if($_GET['status']=='Inactive'){
		$general->UpdStatus("product_prd","id_prd","status_prd",0,$_GET['st_id']);		
	} 
	else{
		 $general->UpdStatus("product_prd","id_prd","status_prd",1,$_GET['st_id']);
	}
}
/*status updation ends */
/* get all banners by origin */
$optbyid = $general->getAll(" product_prd order by order_prd ");
?>
<!DOCTYPE html>
<html>
  <?php include "inc_head.php";
  //$prdtype = $_GET['type'];
  ?>
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
            Manage Product
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=$conf->site_url?>adminpanel/dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Manage Product</li>
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
                  <h3 class="box-title" style="float:right !important;"><a href="add_<?=$pagetype?>.php">Add Product</a></h3>
                </div><!-- /.box-header -->
               
                <div class="box-body table-responsive">
                <div class="btn-group col-md-offset-4" role="group" aria-label="Basic outlined example">
                  <a href="?status=1"><button type="button" class="btn  <?=($_GET['status']==1) ? 'btn-info' : 'btn-default'?>">Live</button></a>
                  <a href="?status=2"><button type="button" class="btn  <?=($_GET['status']==2) ? 'btn-info' : 'btn-default'?>">Pause</button></a>
                  <a href="?status=3"><button type="button" class="btn  <?=($_GET['status']==3) ? 'btn-info' : 'btn-default'?>">Soldout</button></a>
                  <a href="?status=4"><button type="button" class="btn  <?=($_GET['status']==4) ? 'btn-info' : 'btn-default'?>">Upcomming</button></a>
                  <a href="?status=5"><button type="button" class="btn  <?=($_GET['status']==5) ? 'btn-info' : 'btn-default'?>">Discontinue</button></a>
                </div>
                <? if(is_array($optbyid)){ ?>
                  <form id="frm" name="manageform" method="post" action="">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                      	<th class="no-sort"><input id="selectall" class="check-all" type="checkbox" /></th>                        
                        <th class="no-sort">Image</th>
                        
                        
                        <th>Title</th>
                       
                        <th class="no-sort">Status</th>
                        <th class="no-sort">Order</th>
                        <th class="no-sort">&nbsp;</th>                        
                      </tr>
                    </thead>
                    <tbody>
                    <? for($d=0; $d<count($optbyid); $d++){?>
                    	<tr>
                        	<td><input type="checkbox" name="checkbox[]" class="case" value="<? echo $optbyid[$d]['id_prd'];?>" /></td>                        	
                            <td style="width:20%"><img src="<?=$conf->site_url.$conf->product_dir."_".$optbyid[$d]['thumb_name_prd']?>" class="img-responsive" width="50%" />
							</td>
                            <?php /*?><td><?=$general->getSingleField("category_cat","id_cat",$optbyid[$d]['idcat_prd'],"name_cat");?></td><?php */?>
                            <td><?=$optbyid[$d]['name_prd']?></td>
                            <?php /*?><td><?=$general->getSingleField("category_cat","id_cat",$optbyid[$d]['idcat_prd'],"name_cat");?></td><?php */?>
                            <td><? if($optbyid[$d]['status_prd']==1)
				   { ?><a href='?status=Inactive&st_id=<?=base64_encode($optbyid[$d]['id_prd'])?>'>Active</a><? }  else { ?><a href='?status=Active&st_id=<?=base64_encode($optbyid[$d]['id_prd'])?>'>Inactive</a><? } ?></td>
                            <td><input type="text" size="1" name="ordsort_<?php echo $optbyid[$d]['id_prd'];?>" value="<?=$optbyid[$d]['order_prd']?>" /></td>
                            <td style="text-align:center !important;">
                            
                            <!--gallery-->
                            <a href="manage_prd_gallery.php?cid=<?php echo base64_encode($optbyid[$d]['id_prd'])?>" target="_self" title="Gallery"><img src="dist/img/icons/addimage.png" alt="Edit" /></a>
                            
                            <!--Edit
                            <a href="update_<?=$pagetype?>.php?id=<?php echo base64_encode($optbyid[$d]['id_prd'])?>" target="_self" title="Edit"><img src="dist/img/icons/pencil.png" alt="Edit" /></a>-->
                            <!--Delete
                            <a href="#" class="delete" id="<? echo $optbyid[$d]['id_prd'];?>"><img src="dist/img/icons/cross.png" alt="Delete" /></a>-->
                            <!-- action dropdown start -->
                              <div class="btn-group">
                                <button type="button" class="btn btn-default">Edit</button>
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <span class="caret"></span>
                                  <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                  <li><a href="">Edit</a></li>
                                  <li><a href="#">Copy Listing</a></li>
                                  <li><a href="#" class="delete" id="<? echo $optbyid[$d]['id_prd'];?>">Delete Listing</a></li>
                                  <li><a href="#">Listing History</a></li>
                                  <li><a href="#">View Activity</a></li>
                                  <li><a href="#">Print Label</a></li>
                                  <li><a href="#">Discontinue</a></li>
                                </ul>
                              </div>
                            <!-- action dropdown end -->
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
