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
	'urlfield' => 'name_cms',
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
            <li><a href="manage_cms.php">Manage Blocks</a></li>
            <li class="active">Update <?=$data[0]['name_cms']?></li>
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
					
                    
                      <div class="col-xs-4">
                      <label for="exampleInputPassword1">Name</label>
                      <input type="text" class="form-control" name="upd_name_cms" value="<?=$data[0]['name_cms']?>" />
                      </div>
                       <div class="col-xs-4">
                      <label>Page Heading</label>
                      <input type="text" class="form-control" name="upd_heading_cms" value="<?=$data[0]['heading_cms']?>" />
                      </div>
                      
                      <div class="col-xs-12">
                      <label>Short Description</label>
                      <textarea class="ckeditor" name="upd_shortdetails_cms" rows="5"><?=$data[0]['shortdetails_cms']?></textarea>
                      </div>
                    
                      <div class="col-xs-4">
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
