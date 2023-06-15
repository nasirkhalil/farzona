<?php include "dbcon.php";
if($_SESSION['admins']['ID'] == ""){

	header("location:index.php");

}
if(isset($_GET['cid'])){
	$_GET['cid'] = base64_decode($_GET['cid']);
}
if($_POST['button'] != "" || $_POST['button'] != NULL){
	// parameter to make url from
	$params = array(
	'tab' => 'blog_b',
	'id' => 'id_b',
	'urlfield' => 'name_b',
	'parent' => '',
	'imgpath' => $conf->absolute_path.$conf->blog_dir,
	'thumb' => 0,
	'thumbWidth' => 265,
	'thumbHeight' => 265,
	'parenttab' => 'content_cms',
	'parenttabid' => 5,
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
            Add <?=$general->PageType($pagetype);?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="manage_<?=$pagetype;?>.php">Manage <?=$general->PageType($pagetype);?></a></li>
            <li class="active">Add <?=$general->PageType($pagetype);?></li>
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
                      <input type="text" class="form-control" name="pre_name_b" />                      
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Title</label>
                      <input type="text" class="form-control" name="pre_metatitle_b" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Keywords</label>
                      <input type="text" class="form-control" name="pre_metatag_b" />
                      </div>
                      
                      
                      
                      <div class="col-xs-4">
                      <label>Meta Description</label>
                      <input type="text" class="form-control" name="pre_metadescription_b" />
                      </div>
                      
                      
                      
                      <div class="col-xs-12">
                      <label>Short Description</label>
                      <textarea class="form-control" name="pre_shortdetails_b" rows="5"></textarea>
                      </div>
                      
                      <div class="col-xs-12">
                      <label>Details</label>
                      <textarea class="ckeditor" name="pre_details_b" id="details"></textarea>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Thumb Image</label>
                      <input type="file" name="pre_thumb_b" class="form-control" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Banner Image</label>
                      <input type="file" name="pre_image_b" class="form-control" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Image Title</label>
                      <input type="text" class="form-control" name="pre_imagetitle_b" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Image Alt</label>
                      <input type="text" class="form-control" name="pre_imagealt_b" />
                      </div>
                      
                      <? if($conf->ar==1){ ?>
                      <div class="col-xs-12">
                      <h3>Arabic</h3>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Name</label>
                      <input type="text" class="form-control" name="pre_namear_b" />                      
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Heading</label>
                      <input type="text" class="form-control" name="pre_headingar_b" />
                      </div>
                      <div class="col-xs-4">
                      <label>Arabic Label</label>
                      <input type="text" class="form-control" name="pre_labelar_b" />
                      </div>
                       <div class="col-xs-4">
                      <label>Arabic Meta Title</label>
                      <input type="text" class="form-control" name="pre_metatitlear_b" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Meta Keywords</label>
                      <input type="text" class="form-control" name="pre_metatagar_b" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Meta Description</label>
                      <input type="text" class="form-control" name="pre_metadescriptionar_b" />
                      </div>
                      
                      <div class="col-xs-12">
                      <label>Arabic Short Description</label>
                      <textarea class="form-control" name="pre_shortdetailsar_b" rows="5"></textarea>
                      </div>
                      
                      <div class="col-xs-12">
                      <label>Arabic Details</label>
                      <textarea class="ckeditor" name="pre_detailsar_b" id="details"></textarea>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Image Title</label>
                      <input type="text" class="form-control" name="pre_image_titlear_b" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Image Alt</label>
                      <input type="text" class="form-control" name="pre_image_altar_b" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Thumb Title</label>
                      <input type="text" class="form-control" name="pre_thumb_titlear_b" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Thumb Alt</label>
                      <input type="text" class="form-control" name="pre_thumb_altar_b" />
                      </div>
                      <? } ?>
                      <div class="clearfix"></div>
                      <div class="col-xs-4">
                      <label>Status</label>
                      <select class="form-control" name="pre_status_b">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                      </select>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Order</label>
                      <input type="text" class="form-control"  name="pre_order_b"/>
                      </div>
                                       
                  </div><!-- /.box-body -->

                  <div class="box-footer">
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
