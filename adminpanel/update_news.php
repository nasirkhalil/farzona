<?php include "dbcon.php";
$pagename = basename($_SERVER['PHP_SELF']);
$pagename = explode(".",$pagename);
$pagetype  = explode("_",$pagename[0]);
$pagetype = $pagetype[1];
if($_SESSION['admins']['ID'] == ""){

	header("location:index.php");

}
$_GET['id'] = base64_decode($_GET['id']);
if($_POST['button'] != "" || $_POST['button'] != NULL){
	$params = array(
	'tab' => 'news_nws',
	'id' => 'id_nws',
	'urlfield' => 'title_nws',
	'parent' => '',
	'imgpath' => $conf->absolute_path.$conf->news_dir,
	'thumb' => 0,
	'thumbWidth' => 0,
	'thumbHeight' => 0,
	'parenttab' => 'content_cms',
	'parenttabid' => 14,
	);
	$chk = $general->updDetailsAdmin($params);
}
$data = $general->getSingdet(" news_nws where id_nws = ".$_GET['id']);
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
            Update <?=$pagetype?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="manage_<?=$pagetype?>.php">Manage <?=$pagetype?></a></li>
            <li class="active">Update <?=$pagetype?></li>
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
                      <label>Title </label>
                      <input type="text" class="form-control" name="upd_title_nws" value="<?=$data[0]['title_nws']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Title</label>
                      <input type="text" class="form-control" name="upd_metatitle_nws" value="<?=$data[0]['metatitle_nws']?>" />
                      </div>
                      <div class="col-xs-4">
                      <label>Meta Description</label>
                      <input type="text" class="form-control" name="upd_metadescription_nws" value="<?=$data[0]['metadescription_nws']?>" />
                      </div>
                      
                      
                     
                      <div class="col-xs-4">
                      <label>Feedback Comments</label>
                      <input type="text" class="form-control" name="upd_comments_nws" value="<?=$data[0]['comments_nws']?>" />
                      </div>
                      <div class="col-xs-4">
                      <label>Date</label>
                      <input type="text" class="form-control" id="datepicker" name="upd_datetest_nws" value="<?=$data[0]['datetest_nws']?>" />
                      </div>
                      
                      
                      <div class="col-xs-12">
                      <label>Short Description</label>
                      <textarea class="form-control" name="upd_short_detail_nws" rows="5"><?=$data[0]['short_detail_nws']?></textarea>
                      </div>
                      <div class="col-xs-12">
                      <label>Details</label>
                      <textarea class="ckeditor" name="upd_details_nws" rows="5"><?=$data[0]['details_nws']?></textarea>
                      </div>
                      
                     <div class="col-xs-4">
                      <label>Image</label>
                      <input type="file" class="form-control" name="upd_image_name_nws" />
                      </div>
                      <div class="col-xs-4">
                      <label>Image Title</label>
                      <input type="text" class="form-control" name="upd_image_title_nws" value="<?=$data[0]['image_title_nws']?>" />
                      </div>
                      <div class="col-xs-4">
                      <label>Image Alt</label>
                      <input type="text" class="form-control" name="upd_image_alt_nws" value="<?=$data[0]['image_alt_nws']?>" />
                      </div>
                      
                   
                      <div class="col-xs-4">
                      <label>Status</label>
                      <select class="form-control" name="upd_status_nws">
                      <option value="1" <? if($data[0]['status_nws']==1) echo 'selected'; ?>>Active</option>
                      <option value="0" <? if($data[0]['status_nws']==0) echo 'selected'; ?>>Inactive</option>
                      </select>
                      </div>
                      <input type="hidden" class="form-control"  name="upd_type_nws" value="<?=$data[0]['type_nws']?>" />
                      <div class="col-xs-4">
                      <label>Order</label>
                      <input type="text" class="form-control"  name="upd_order_nws" value="<?=$data[0]['order_nws']?>" />
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
