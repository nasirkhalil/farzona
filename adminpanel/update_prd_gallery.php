<?php include "dbcon.php";
if($_SESSION['admins']['ID'] == ""){

	header("location:index.php");

}
$_GET['id'] = base64_decode($_GET['id']);
if($_POST['button'] != "" || $_POST['button'] != NULL){
	// parameters array
	$params = array(
	'tab' => 'prdimages_img',
	'id' => 'id_img',
	'urlfield' => '',
	'parent' => '',
	'imgpath' => $conf->absolute_path.$conf->gallery_dir,
	'thumb' => 1,
	'thumbWidth' => $conf->galleryThumbnailWidth,
	'thumbHeight' => $conf->galleryThumbnailHeight,
	'thumb2' => 1,
	'thumb2Width' => $conf->DivisionThumbWidth,
	'thumb2Height' => $conf->DivisionThumbHeight,
	'parenttab' => '',
	'parenttabid' => 0,
	);
	$chk = $general->updgallery($params);
}
$data = $general->getSingdet(" prdimages_img where id_img = ".$_GET['id']);
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
            Update <?=$general->PageType($prdtype);?> Gallery
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="manage_prd_gallery.php?cid=<?=base64_encode($data[0]['idprd_img'])?>&type=<?=$prdtype?>">Manage <?=$general->PageType($prdtype);?> Gallery</a></li>
            <li class="active">Update <?=$general->PageType($prdtype);?> Gallery</li>
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
                        
                      <div class="col-xs-4">
                      <label><?=$general->PageType($prdtype);?> Image</label>
                      <input type="file" name="upd_name_img" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Image Caption</label>
                      <input type="text" class="form-control" name="upd_caption_img" value="<?=$data[0]['caption_img']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Image Title</label>
                      <input type="text" class="form-control" name="upd_title_img" value="<?=$data[0]['title_img']?>" />
                      </div>
                    
                      <div class="col-xs-4">
                      <label>Image Alt</label>
                      <input type="text" class="form-control" name="upd_alt_img" value="<?=$data[0]['alt_img']?>" />
                      </div>
                    
                      <div class="col-xs-4">
                      <label>Status</label>
                      <select class="form-control" name="upd_status_img">
                      <option value="1" <? if($data[0]['status_img']==1) echo 'selected'; ?>>Active</option>
                      <option value="0" <? if($data[0]['status_img']==0) echo 'selected'; ?>>Inactive</option>
                      </select>
                      </div>
                      <input type="hidden" class="form-control"  name="upd_type_img" value="<?=$data[0]['type_img']?>" />
                      <div class="col-xs-4">
                      <label>Order</label>
                      <input type="text" class="form-control"  name="upd_order_img" value="<?=$data[0]['order_img']?>" />
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
