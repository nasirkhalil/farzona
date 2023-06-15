<?php include "dbcon.php";
if($_SESSION['admins']['ID'] == ""){

	header("location:index.php");
}
$_GET['id'] = base64_decode($_GET['id']);
if($_POST['button'] != "" || $_POST['button'] != NULL){
	// parameters array
	$params = array(
	'tab' => 'blog_b',
	'id' => 'id_b',
	'urlfield' => 'name_b',
	'parent' => '',
	'imgpath' => $conf->absolute_path.$conf->blog_dir,
	'thumb' => 0,
	'thumbWidth' => 0,
	'thumbHeight' => 0,
	'parenttab' => 'content_cms',
	'parenttabid' => 5,
	);
	$chk = $general->updDetailsAdmin($params);
}
$data = $general->getSingdet(" blog_b where id_b = ".$_GET['id']);
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
                  
                  	  <div class="col-xs-4">
                      <label>Title</label>
                      <input type="text" class="form-control" name="upd_name_b" value="<?=$data[0]['name_b']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Title</label>
                      <input type="text" class="form-control" name="upd_metatitle_b" value="<?=$data[0]['metatitle_b']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Keywords</label>
                      <input type="text" class="form-control" name="upd_metatag_b" value="<?=$data[0]['metatag_b']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Description</label>
                      <input type="text" class="form-control" name="upd_metadescription_b" value="<?=$data[0]['metadescription_b']?>" />
                      </div>
                      
                      <div class="col-xs-12">
                      <label>Short Description</label>
                      <textarea class="form-control" name="upd_shortdetails_b" rows="5"><?=$data[0]['shortdetails_b']?></textarea>
                      </div>
                      
					  <div class="col-xs-12">
                      <label>Details</label>
                      <textarea class="ckeditor" name="upd_details_b" id="details"><?=$data[0]['details_b']?></textarea>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Thumb Image</label>
                      <input type="file" name="upd_thumb_b" class="form-control" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Banner Image</label>
                      <input type="file" name="upd_image_b" class="form-control" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Image Title</label>
                      <input type="text" class="form-control" name="upd_imagetitle_b" value="<?=$data[0]['imagetitle_b']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Image Alt</label>
                      <input type="text" class="form-control" name="upd_imagealt_b" value="<?=$data[0]['imagealt_b']?>" />
                      </div>
                      
                      <? if($conf->ar==1){ ?>
                      <div class="col-xs-12">
                      <h3>Arabic</h3>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Heading</label>
                      <input type="text" class="form-control" name="upd_headingar_b" value="<?=$data[0]['headingar_b']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Label</label>
                      <input type="text" class="form-control" name="upd_labelar_b" value="<?=$data[0]['labelar_b']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Image Title</label>
                      <input type="text" class="form-control" name="upd_image_titlear_b" value="<?=$data[0]['image_titlear_b']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Image Alt</label>
                      <input type="text" class="form-control" name="upd_image_altar_b" value="<?=$data[0]['image_altar_b']?>" />
                      </div>
                      <? } ?>
                      <div class="clearfix"></div>
                      <div class="col-xs-4">
                      <label>Status</label>
                      <select class="form-control" name="upd_status_b">
                      <option value="1" <? if($data[0]['status_b']==1) echo 'selected'; ?>>Active</option>
                      <option value="0" <? if($data[0]['status_b']==0) echo 'selected'; ?>>Inactive</option>
                      </select>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Order</label>
                      <input type="text" class="form-control"  name="upd_order_b" value="<?=$data[0]['order_b']?>" />
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
