<?php include "dbcon.php";
if ($_SESSION['admins']['ID'] == "") {

  header("location:index.php");

}
$sizes = $general->getAll("sizes");
if (isset($_GET['cid'])) {
  $_GET['cid'] = base64_decode($_GET['cid']);
}
if ($_POST['button'] != "" || $_POST['button'] != NULL) {
  // parameter to make url from
  $params = array(
    'tab' => 'product_prd',
    'id' => 'id_prd',
    'urlfield' => 'name_prd',
    'parent' => 'idcat_prd',
    'imgpath' => $conf->absolute_path . $conf->product_dir,
    'thumb' => 1,
    'thumbWidth' => $conf->thumbnailWidth,
    'thumbHeight' => $conf->thumbnailWidth,
    'parenttab' => 'category_cat',
    'parenttabid' => '',
  );
  $chk = $general->insertDetailsAdmin($params);
}
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
        <h1>Add Product</h1>
        <ol class="breadcrumb">
          <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li><a href="manage_<?= $pagetype; ?>.php?type=<?= $prdtype ?>">Manage Product</a></li>
          <li class="active">Add Product</li>
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
                <?php if (isset($_POST['button'])) {
                  if ($chk) { ?>
                    <!-- success alert -->
                    <div class="alert alert-success alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <i class="icon fa fa-check"></i> <?= $general->msg ?>
                    </div>
                    <!-- success alert ends -->
                  <? } else { ?>
                    <!-- not success alert -->
                    <div class="alert alert-danger alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <i class="icon fa fa-ban"></i> <?= $general->msg ?>
                    </div>
                    <!-- Not success alert ends -->
                  <? }
                } ?>
              </div><!-- /.box-header -->
              <!-- form start -->
              <form name="addform" method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="pre_created_at" value="<?php echo date('Y-m-d G:i:s') ?>">
                <input type="hidden" name="pre_updated_at" value="<?php echo date('Y-m-d G:i:s') ?>">
                <div class="box-body">
                  <div class="col-xs-4">
                    <label>Parent Category</label>
                    <?php echo $general->draw_pull_down_tree('pre_idcat_prd', $general->get_category_tree('category_cat', 'parent_cat', 'id_cat', 'name_cat', ""), 'category_cat', '', 'class="form-control"'); ?>
                  </div>

                  <div class="col-xs-4">
                    <label>Name</label>
                    <input type="text" class="form-control" name="pre_name_prd" />
                  </div>

                  <div class="col-xs-4">
                    <label>Meta Title</label>
                    <input type="text" class="form-control" name="pre_metatitle_prd" />
                  </div>

                  <div class="col-xs-4">
                    <label>Meta Keywords</label>
                    <input type="text" class="form-control" name="pre_metatag_prd" />
                  </div>



                  <div class="col-xs-4">
                    <label>Meta Description</label>
                    <input type="text" class="form-control" name="pre_metadescription_prd" />
                  </div>


                  <!-- <div class="col-xs-4">
                      <label>Location</label>
                      <input type="text" class="form-control" name="pre_location_prd" />
                      </div>
                      <div class="col-xs-4">
                      <label>Type</label>
                      <input type="text" class="form-control" name="pre_type_prd" />
                      </div> -->
                  <div class="col-xs-12">
                    <label>Details</label>
                    <textarea class="ckeditor" name="pre_details_prd" rows="5" cols="10"></textarea>
                  </div>

                  <div class="col-xs-4">
                    <label>Thumb Image</label>
                    <input type="file" class="form-control" name="pre_thumb_name_prd" />
                  </div>

                  <div class="col-xs-4">
                    <label>Thumb Title</label>
                    <input type="text" class="form-control" name="pre_thumb_title_prd" />
                  </div>

                  <div class="col-xs-4">
                    <label>Thumb Alt</label>
                    <input type="text" class="form-control" name="pre_thumb_alt_prd" />
                  </div>

                  <?php /*?><div class="col-xs-4">
                 <label>Banner Image</label>
                 <input type="file" class="form-control" name="pre_image_name_prd" />
                 </div>
                 
                 <div class="col-xs-4">
                 <label>Banner Title</label>
                 <input type="text" class="form-control" name="pre_image_title_prd" />
                 </div>
                 
                 <div class="col-xs-4">
                 <label>Banner Alt</label>
                 <input type="text" class="form-control" name="pre_image_alt_prd" />
                 </div><?php */?>


                  <? if ($conf->ar == 1) { ?>
                    <div class="col-xs-12">
                      <h3>Arabic</h3>
                    </div>

                    <div class="col-xs-4">
                      <label>Arabic Name</label>
                      <input type="text" class="form-control" name="pre_namear_prd" />
                    </div>

                    <div class="col-xs-4">
                      <label>Arabic Heading</label>
                      <input type="text" class="form-control" name="pre_headingar_prd" />
                    </div>
                    <div class="col-xs-4">
                      <label>Arabic Label</label>
                      <input type="text" class="form-control" name="pre_labelar_prd" />
                    </div>
                    <div class="col-xs-4">
                      <label>Arabic Meta Title</label>
                      <input type="text" class="form-control" name="pre_metatitlear_prd" />
                    </div>

                    <div class="col-xs-4">
                      <label>Arabic Meta Keywords</label>
                      <input type="text" class="form-control" name="pre_metatagar_prd" />
                    </div>

                    <div class="col-xs-4">
                      <label>Arabic Meta Description</label>
                      <input type="text" class="form-control" name="pre_metadescriptionar_prd" />
                    </div>

                    <div class="col-xs-12">
                      <label>Arabic Short Description</label>
                      <textarea class="form-control" name="pre_shortdetailsar_prd" rows="5"></textarea>
                    </div>

                    <div class="col-xs-12">
                      <label>Arabic Details</label>
                      <textarea class="ckeditor" name="pre_detailsar_prd" id="details"></textarea>
                    </div>

                    <div class="col-xs-4">
                      <label>Arabic Image Title</label>
                      <input type="text" class="form-control" name="pre_image_titlear_prd" />
                    </div>

                    <div class="col-xs-4">
                      <label>Arabic Image Alt</label>
                      <input type="text" class="form-control" name="pre_image_altar_prd" />
                    </div>

                    <div class="col-xs-4">
                      <label>Arabic Thumb Title</label>
                      <input type="text" class="form-control" name="pre_thumb_titlear_prd" />
                    </div>

                    <div class="col-xs-4">
                      <label>Arabic Thumb Alt</label>
                      <input type="text" class="form-control" name="pre_thumb_altar_prd" />
                    </div>
                  <? } ?>
                  <div class="col-xs-4">
                    <label>Status</label>
                    <select class="form-control" name="pre_size_id">
                    <?php foreach($sizes as $key => $size){?>    
                      <option value="<?php echo $size['name']?>"><?php echo $size['name']?></option>
                    <?php } ?>
                    </select>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-xs-4">
                    <label>Show on Home</label>
                    <select class="form-control" name="pre_onmain_prd">
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                    </select>
                  </div>
                  <div class="col-xs-4">
                    <label>Status</label>
                    <select class="form-control" name="pre_status_prd">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                    </select>
                  </div>

                  <div class="col-xs-4">
                    <label>Order</label>
                    <input type="text" class="form-control" name="pre_order_prd" />
                  </div>

                </div><!-- /.box-body -->

                <div class="box-footer">
                  <button type="submit" name="button" value="A d d" class="btn btn-primary">A d d</button>
                </div>
              </form>
            </div><!-- /.box -->

          </div><!--/.col (left) -->
        </div> <!-- /.row -->
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <?php include "inc_footer.php"; ?>
  </div><!-- ./wrapper -->

  <?php include "inc_scripts.php"; ?>
</body>

</html>