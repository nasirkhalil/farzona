<?php include "dbcon.php";
if($_SESSION['admins']['ID'] == ""){

	header("location:index.php");
}
$_GET['id'] = base64_decode($_GET['id']);
if($_GET['type']=="concept"){
	$parenttabid = 19;
	$thumbwidth = $conf->ConceptThumbWidth;
	$thumbheight = $conf->ConceptThumbHeight;
}elseif($_GET['type']=="project"){
	$parenttabid = 4;
	$thumbwidth = $conf->ProjectThumbWidth;
	$thumbheight = $conf->ProjectThumbHeight;
}elseif($_GET['type']=="division"){
	$parenttabid = 20;
	$thumbwidth = $conf->DivisionThumbWidth;
	$thumbheight = $conf->DivisionThumbHeight;
}
if($_POST['button'] != "" || $_POST['button'] != NULL){
	// parameters array
	$params = array(
	'tab' => 'product_prd',
	'id' => 'id_prd',
	'urlfield' => 'name_prd',
	'parent' => '',
	'imgpath' => $conf->absolute_path.$conf->product_dir,
	'thumb' => 1,
	'thumbWidth' => $thumbwidth,
	'thumbHeight' => $thumbheight,
	'parenttab' => 'content_cms',
	'parenttabid' => $parenttabid,
	);
	$chk = $general->updDetailsAdmin($params);
}
$data = $general->getSingdet(" product_prd where id_prd = ".$_GET['id']);
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
            Update <?=$general->PageType($prdtype);?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="manage_<?=$pagetype?>.php?type=<?=$prdtype?>">Manage <?=$general->PageType($prdtype);?></a></li>
            <li class="active">Update <?=$general->PageType($prdtype);?></li>
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
                      <label>Name</label>
                      <input type="text" class="form-control" name="upd_name_prd" value="<?=$data[0]['name_prd']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Title</label>
                      <input type="text" class="form-control" name="upd_metatitle_prd" value="<?=$data[0]['metatitle_prd']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Keywords</label>
                      <input type="text" class="form-control" name="upd_metatag_prd" value="<?=$data[0]['metatag_prd']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Description</label>
                      <input type="text" class="form-control" name="upd_metadescription_prd" value="<?=$data[0]['metadescription_prd']?>" />
                      </div>
                      
                      <? if($prdtype=="project"){?>
                      <div class="col-xs-4">
                      <label>Location</label>
                      <input type="text" class="form-control" name="upd_location_prd" value="<?=$data[0]['location_prd']?>" />
                      </div>
                      <? } ?>
                      
                      <div class="col-xs-12">
                      <label>Details</label>
                      <textarea class="ckeditor" name="upd_details_prd" rows="5" cols="10"><?=$data[0]['details_prd']?></textarea>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Thumb Image</label>
                      <input type="file" class="form-control" name="upd_thumb_name_prd" value="<?=$data[0]['thumb_name_prd']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Thumb Title</label>
                      <input type="text" class="form-control" name="upd_thumb_title_prd" value="<?=$data[0]['thumb_title_prd']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Thumb Alt</label>
                      <input type="text" class="form-control" name="upd_thumb_alt_prd" value="<?=$data[0]['thumb_alt_prd']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Banner Image</label>
                      <input type="file" class="form-control" name="upd_image_name_prd" value="<?=$data[0]['image_name_prd']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Banner Title</label>
                      <input type="text" class="form-control" name="upd_image_title_prd" value="<?=$data[0]['image_title_prd']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Banner Alt</label>
                      <input type="text" class="form-control" name="upd_image_alt_prd" value="<?=$data[0]['image_alt_prd']?>" />
                      </div>
                      <? if($conf->ar==1){ ?>
                      <div class="col-xs-12">
                      <h3>Arabic</h3>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Heading</label>
                      <input type="text" class="form-control" name="upd_headingar_prd" value="<?=$data[0]['headingar_prd']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Label</label>
                      <input type="text" class="form-control" name="upd_labelar_prd" value="<?=$data[0]['labelar_prd']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Image Title</label>
                      <input type="text" class="form-control" name="upd_image_titlear_prd" value="<?=$data[0]['image_titlear_prd']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Image Alt</label>
                      <input type="text" class="form-control" name="upd_image_altar_prd" value="<?=$data[0]['image_altar_prd']?>" />
                      </div>
                      <? } ?>
                      <div class="clearfix"></div>
                      <div class="col-xs-4">
                      <label>Status</label>
                      <select class="form-control" name="upd_status_prd">
                      <option value="1" <? if($data[0]['status_prd']==1) echo 'selected'; ?>>Active</option>
                      <option value="0" <? if($data[0]['status_prd']==0) echo 'selected'; ?>>Inactive</option>
                      </select>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Order</label>
                      <input type="text" class="form-control"  name="upd_order_prd" value="<?=$data[0]['order_prd']?>" />
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
