<?php include "dbcon.php";
if($_SESSION['admins']['ID'] == ""){

	header("location:index.php");
}
$_GET['id'] = base64_decode($_GET['id']);
if($_POST['button'] != "" || $_POST['button'] != NULL){
	// parameters array
	$params = array(
	'tab' => 'country_cou',
	'id' => 'id_cou',
	'urlfield' => 'name_cou',
	'parent' => 'parent_cou',
	'imgpath' => $conf->absolute_path.$conf->category_dir,
	'thumb' => 0,
	'thumbWidth' => 0,
	'thumbHeight' => 0,
	'parenttab' => '',
	'parenttabid' => 0,
	);
	$chk = $general->updDetailsAdmin($params);
}
$data = $general->getSingdet(" country_cou where id_cou = ".$_GET['id']);
?>
<!DOCTYPE html>
<html>
  <?php include "inc_head.php"; ?>
  <body class="hold-transition skin-blue sidebar-mini">
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
            Update <?=$general->PageType($pagetype);?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="manage_<?=$pagetype?>.php">Manage <?=$general->PageType($pagetype);?></a></li>
            <li class="active">Update <?=$general->PageType($pagetype);?></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                <?php if(isset($_POST['button'])){
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
                </div><!-- /.box-header -->
                <!-- form start -->
                <form name="addform" method="post" action="" enctype="multipart/form-data">
                  <div class="box-body">
                  
                  <? if($data[0]['parent_cat']!=0) {?>
                  	  <div class="col-xs-4">
                      <label>Parent Category</label>
                      <?php echo $general->draw_pull_down_tree('upd_parent_cat', $general->get_category_tree('category_cat','parent_cat','id_cat','name_cat',""), 'category_cat', $data[0]['parent_cat'], 'class="form-control"'); ?>               
                      </div>
                      <? }?>
                  
                  	  <div class="col-xs-4">
                      <label>Name</label>
                      <input type="text" class="form-control" name="upd_name_cou" value="<?=$data[0]['name_cou']?>" />
                      </div>
                      
                      
                      
                      <div class="clearfix"></div>
                      <div class="col-xs-4">
                      <label>Status</label>
                      <select class="form-control" name="upd_status_cou">
                      <option value="1" <? if($data[0]['status_cou']==1) echo 'selected'; ?>>Active</option>
                      <option value="0" <? if($data[0]['status_cou']==0) echo 'selected'; ?>>Inactive</option>
                      </select>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Order</label>
                      <input type="text" class="form-control"  name="upd_order_cou" value="<?=$data[0]['order_cou']?>" />
                      </div>
                                       
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" name="button" value="Update" class="btn btn-primary">Update</button>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->            
          </div>   <!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php include "inc_footer.php"; ?>
    </div><!-- ./wrapper -->

    <?php include "inc_scripts.php"; ?>   
  </body>
</html>
