<?php include "dbcon.php";
if($_SESSION['admins']['ID'] == ""){

	header("location:index.php");

}
$_GET['id'] = base64_decode($_GET['id']);
$_GET['cid'] = base64_decode($_GET['cid']);
if($_POST['button'] != "" || $_POST['button'] != NULL){
	// parameters array
	$params = array(
	'tab' => 'gallery_gal',
	'id' => 'id_gal',
	'urlfield' => '',
	'parent' => '',
	'imgpath' => $conf->absolute_path.$conf->gallery_dir,
	'thumb' => 1,
	'thumbWidth' => $conf->galleryThumbnailWidth,
	'thumbHeight' => $conf->galleryThumbnailHeight,
	'parenttab' => '',
	'parenttabid' => 0,
	);
	$chk = $general->updgallery($params);
}
$data = $general->getSingdet(" gallery_gal where id_gal = ".$_GET['id']);
?>
<!DOCTYPE html>
<html>
  <?php include "inc_head.php";
  $prdtype = $_GET['type']; ?>
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
            Update Gallery
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="manage_gallery.php">Manage Gallery</a></li>
            
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
                       
                      <?php /*?> <div class="col-xs-4">
                      <label>Caption</label>
                      <input type="text" class="form-control" name="upd_caption_gal" value="<?=$data[0]['caption_gal']?>" />
                      </div><?php */?>
                    
                      
                         <div class="clearfix"></div>
                      <div class="col-xs-4">
                      <label> Image</label>
                      <input type="file" name="upd_image_gal" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Image Title</label>
                      <input type="text" class="form-control" name="upd_image_title_gal" value="<?=$data[0]['image_title_gal']?>" />
                      </div>
                    
                      <div class="col-xs-4">
                      <label>Image Alt</label>
                      <input type="text" class="form-control" name="upd_image_alt_gal" value="<?=$data[0]['image_alt_gal']?>" />
                      </div>
                    
                      <div class="col-xs-4">
                      <label>Status</label>
                      <select class="form-control" name="upd_status_gal">
                      <option value="1" <? if($data[0]['status_gal']==1) echo 'selected'; ?>>Active</option>
                      <option value="0" <? if($data[0]['status_gal']==0) echo 'selected'; ?>>Inactive</option>
                      </select>
                      </div>
                     
                      
                      <div class="col-xs-4">
                      <label>Order</label>
                      <input type="text" class="form-control"  name="upd_order_gal" value="<?=$data[0]['order_gal']?>" />
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
