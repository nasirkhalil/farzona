<?php include "dbcon.php";
if($_SESSION['admins']['ID'] == ""){

	header("location:index.php");

}
$_GET['id'] = base64_decode($_GET['id']);
if($_POST['button'] != "" || $_POST['button'] != NULL){
	// parameters array
	$params = array(
	'tab' => 'content_cms',
	'id' => 'id_cms',
	'urlfield' => 'url_cms',
	'parent' => 'parent_cms',
	'imgpath' => $conf->absolute_path.$conf->general_dir,
	'thumb' => 0,
	'thumbWidth' => 0,
	'thumbHeight' => 0,
	'parenttab' => '',
	'parenttabid' => 0,
	);
	$chk = $general->updDetailsAdmin($params);
}
$data = $general->getSingdet(" content_cms where id_cms = ".$_GET['id']);
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
            Update <?=$data[0]['name_cms']?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="manage_cms.php">Manage Content</a></li>
            <li class="active">Update Content</li>
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
                    <i class="icon fa fa-check"></i>
                    <?=$general->msg?>
                  </div>
                	<!-- success alert ends -->  
                    <? }else{ ?>
                	<!-- not success alert -->
                    <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i>
                    <?=$general->msg?>
                  </div>
                	<!-- Not success alert ends -->
                <? 	   }
				} ?>                  
                </div><!-- /.box-header -->
                <!-- form start -->
                <form name="addform" method="post" action="" enctype="multipart/form-data">
                  <div class="box-body">
					<? if($data[0]['parent_cms']!=0){ ?>
                      <div class="col-xs-4">
                      <label>Parent Menu</label>
                      <?php echo $general->draw_pull_down_tree('upd_parent_cms', $general->get_category_tree('content_cms','parent_cms','id_cms','name_cms',"origin_cms='menu'"), 'content_cms', $data[0]['parent_cms'], 'class="form-control"'); ?>
                      </div>
                      <div class="clearfix"></div>
                    <? } ?>
                   
                      <div class="col-xs-4">
                      <label>URL</label>
                      <input type="text" class="form-control" name="upd_url_cms" value="<?=$data[0]['url_cms']?>" />
                      </div>
                   
                      <div class="col-xs-4">
                      <label>Name</label>
                      <input type="text" class="form-control" name="upd_name_cms" value="<?=$data[0]['name_cms']?>" />
                      </div>
                   
                      <div class="col-xs-4">
                      <label>Page Heading</label>
                      <input type="text" class="form-control" name="upd_heading_cms" value="<?=$data[0]['heading_cms']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Title</label>
                      <input type="text" class="form-control" name="upd_metatitle_cms" value="<?=$data[0]['metatitle_cms']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Keywords</label>
                      <input type="text" class="form-control" name="upd_metatag_cms" value="<?=$data[0]['metatag_cms']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Description</label>
                      <input type="text" class="form-control" name="upd_metadescription_cms" value="<?=$data[0]['metadescription_cms']?>" />
                      </div>
                    
                      <div class="col-xs-12">
                      <label><? if($data[0]['id_cms']==1){?>Welcome Text<? }elseif($data[0]['id_cms']==6){?>Location Map<? }else{ ?>Short Description<? } ?></label>
                      <textarea <? if($data[0]['id_cms']==1 || $data[0]['id_cms']==6){?>class="ckeditor"<? }else{ ?>class="form-control"<? } ?> name="upd_shortdetails_cms" rows="5"><?=$data[0]['shortdetails_cms']?></textarea>
                      </div>
                   
					  <div class="col-xs-12">
                      <label><? if($data[0]['id_cms']==1){?>About Text<? }else{ ?>Details<? } ?></label>
                      <textarea class="ckeditor" name="upd_details_cms" id="details"><?=$data[0]['details_cms']?></textarea>
                      </div>
                   
                      <div class="col-xs-4">
                      <label>Image</label>
                      <input type="file" name="upd_image_name_cms" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Image Title</label>
                      <input type="text" class="form-control" name="upd_image_title_cms" value="<?=$data[0]['image_title_cms']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Image Alt</label>
                      <input type="text" class="form-control" name="upd_image_alt_cms" value="<?=$data[0]['image_alt_cms']?>" />
                      </div>
                   
                      <?php /*?><div class="col-xs-4">
                      <label>Thumb</label>
                      <input type="file" name="upd_thumb_name_cms" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Thumb Title</label>
                      <input type="text" class="form-control" name="upd_thumb_title_cms" value="<?=$data[0]['thumb_title_cms']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Thumb Alt</label>
                      <input type="text" class="form-control" name="upd_thumb_alt_cms" value="<?=$data[0]['thumb_alt_cms']?>" />
                      </div><?php */?>
                   
                      <? if($conf->ar==1){ ?>
                      <div class="col-xs-12">
                      <h3>Arabic</h3>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Name</label>
                      <input type="text" class="form-control" name="upd_namear_cms" value="<?=$data[0]['namear_cms']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Heading</label>
                      <input type="text" class="form-control" name="upd_headingar_cms" value="<?=$data[0]['headingar_cms']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Label</label>
                      <input type="text" class="form-control" name="upd_labelar_cms" value="<?=$data[0]['labelar_cms']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Meta Title</label>
                      <input type="text" class="form-control" name="upd_metatitlear_cms" value="<?=$data[0]['metatitlear_cms']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Meta Keywords</label>
                      <input type="text" class="form-control" name="upd_metatagar_cms" value="<?=$data[0]['metatagar_cms']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Meta Description</label>
                      <input type="text" class="form-control" name="upd_metadescriptionar_cms" value="<?=$data[0]['metadescriptionar_cms']?>" />
                      </div>
                      
                      <div class="col-xs-12">
                      <label>Arabic Short Description</label>
                      <textarea class="form-control" name="upd_shortdetailsar_cms" rows="5"><?=$data[0]['shortdetailsar_cms']?></textarea>
                      </div>
                      
                      <div class="col-xs-12">
                      <label>Arabic Details</label>
                      <textarea class="ckeditor" name="upd_detailsar_cms" id="details"><?=$data[0]['detailsar_cms']?></textarea>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Image Title</label>
                      <input type="text" class="form-control" name="upd_image_titlear_cms" value="<?=$data[0]['image_titlear_cms']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Image Alt</label>
                      <input type="text" class="form-control" name="upd_image_altar_cms" value="<?=$data[0]['image_altar_cms']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Thumb Title</label>
                      <input type="text" class="form-control" name="upd_thumb_titlear_cms" value="<?=$data[0]['thumb_titlear_cms']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Thumb Alt</label>
                      <input type="text" class="form-control" name="upd_thumb_altar_cms" value="<?=$data[0]['thumb_altar_cms']?>" />
                      </div>
                      <? } ?>
                      
                      <div class="clearfix"></div>
                      <?php /*?><? if($data[0]['parent_cms']!=0){?>
                      <div class="col-xs-4">
                      <label>Show on Home</label>
                      <select class="form-control" name="upd_onmain_cms">
                      <option value="1" <? if($data[0]['onmain_cms']==1) echo 'selected'; ?>>Yes</option>
                      <option value="0" <? if($data[0]['onmain_cms']==0) echo 'selected'; ?>>No</option>
                      </select>
                      </div>
                      <? }?><?php */?>
                   
                      <div class="col-xs-4">
                      <label>Status</label>
                      <select class="form-control" name="upd_status_cms">
                      <option value="1" <? if($data[0]['status_cms']==1) echo 'selected'; ?>>Active</option>
                      <option value="0" <? if($data[0]['status_cms']==0) echo 'selected'; ?>>Inactive</option>
                      </select>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Order</label>
                      <input type="text" class="form-control"  name="upd_order_cms" value="<?=$data[0]['order_cms']?>" />
                      </div>
					                                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" name="button" value="A d d" class="btn btn-primary">Update</button>
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
