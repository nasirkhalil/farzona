<?php include "dbcon.php";
if($_SESSION['admins']['ID'] == ""){

	header("location:index.php");

}
if(isset($_GET['cid'])){
	$_GET['cid'] = base64_decode($_GET['cid']);
}
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
	$chk=$general->insertDetailsAdmin($params);
}
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
            Add Content
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="manage_cms.php">Manage Content</a></li>
            <li class="active">Add Content</li>
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
                      <label>Parent Menu</label>
                      <?php echo $general->draw_pull_down_tree('pre_parent_cms', $general->get_category_tree('content_cms','parent_cms','id_cms','name_cms',"origin_cms='menu'"), 'content_cms', $_GET['cid'], 'class="form-control"'); ?>
                      </div>
                      <div class="clearfix"></div>
                      
                      <div class="col-xs-4">
                      <label>URL</label>
                      <input type="text" class="form-control" name="pre_url_cms" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Name</label>
                      <input type="text" class="form-control" name="pre_name_cms" />                      
                      </div>
                      
                    <div class="col-xs-4">
                      <label>Heading</label>
                      <input type="text" class="form-control" name="pre_heading_cms" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Title</label>
                      <input type="text" class="form-control" name="pre_metatitle_cms" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Keywords</label>
                      <input type="text" class="form-control" name="pre_metatag_cms" />
                      </div>
                      
                      
                      
                      <div class="col-xs-4">
                      <label>Meta Description</label>
                      <input type="text" class="form-control" name="pre_metadescription_cms" />
                      </div>
                      
                      
                      
                      <div class="col-xs-12">
                      <label>Short Description</label>
                      <textarea class="form-control" name="pre_shortdetails_cms" rows="5"></textarea>
                      </div>
                      
                      
                      
                      
                      
                      <div class="col-xs-12">
                      <label>Details</label>
                      <textarea class="ckeditor" name="pre_details_cms" id="details"></textarea>
                      </div>
                      
                      
                      
                      <div class="col-xs-4">
                      <label>Image</label>
                      <input type="file" name="pre_image_name_cms" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Image Title</label>
                      <input type="text" class="form-control" name="pre_image_title_cms" />
                      </div>
                      
                      
                    
                      
                      <div class="col-xs-4">
                      <label>Image Alt</label>
                      <input type="text" class="form-control" name="pre_image_alt_cms" />
                      </div>
                      
                      
                      
                      <div class="col-xs-4">
                      <label>Thumb Image</label>
                      <input type="file" name="pre_thumb_name_cms" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Thumb Title</label>
                      <input type="text" class="form-control" name="pre_thumb_title_cms" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Thumb Alt</label>
                      <input type="text" class="form-control" name="pre_thumb_alt_cms" />
                      </div>
                      <? if($conf->ar==1){ ?>
                      <div class="col-xs-12">
                      <h3>Arabic</h3>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Name</label>
                      <input type="text" class="form-control" name="pre_namear_cms" />                      
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Heading</label>
                      <input type="text" class="form-control" name="pre_headingar_cms" />
                      </div>
                      <div class="col-xs-4">
                      <label>Arabic Label</label>
                      <input type="text" class="form-control" name="pre_labelar_cms" />
                      </div>
                       <div class="col-xs-4">
                      <label>Arabic Meta Title</label>
                      <input type="text" class="form-control" name="pre_metatitlear_cms" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Meta Keywords</label>
                      <input type="text" class="form-control" name="pre_metatagar_cms" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Meta Description</label>
                      <input type="text" class="form-control" name="pre_metadescriptionar_cms" />
                      </div>
                      
                      <div class="col-xs-12">
                      <label>Arabic Short Description</label>
                      <textarea class="form-control" name="pre_shortdetailsar_cms" rows="5"></textarea>
                      </div>
                      
                      <div class="col-xs-12">
                      <label>Arabic Details</label>
                      <textarea class="ckeditor" name="pre_detailsar_cms" id="details"></textarea>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Image Title</label>
                      <input type="text" class="form-control" name="pre_image_titlear_cms" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Image Alt</label>
                      <input type="text" class="form-control" name="pre_image_altar_cms" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Thumb Title</label>
                      <input type="text" class="form-control" name="pre_thumb_titlear_cms" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Thumb Alt</label>
                      <input type="text" class="form-control" name="pre_thumb_altar_cms" />
                      </div>
                      <? } ?>
                      <div class="clearfix"></div>
                      <div class="col-xs-4">
                      <label>Status</label>
                      <select class="form-control" name="pre_status_cms">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                      </select>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Order</label>
                      <input type="text" class="form-control"  name="pre_order_cms"/>
                      </div>
                                       
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  <input name="pre_origin_cms" type="hidden" value="menu"/>
                    <button type="submit" name="button" value="A d d" class="btn btn-primary">A d d</button>
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
