<?php include "dbcon.php";
if($_SESSION['admins']['ID'] == ""){

	header("location:index.php");

}
$_GET['id'] = 1;
if($_POST['button'] != "" || $_POST['button'] != NULL){
	// parameters array
	$params = array(
	'tab' => 'setting_set',
	'id' => 'id_set',
	'urlfield' => '',
	'parent' => '',
	'imgpath' => $conf->absolute_path.$conf->general_dir,
	'thumb' => 0,
	'thumbWidth' => 0,
	'thumbHeight' => 0,
	'parenttab' => '',
	'parenttabid' => 0,
	);
	$chk = $general->updDetailsAdmin($params);
}
$data = $general->getSingdet(" setting_set where id_set = 1");
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
            Update General Settings
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="manage_email.php">Manage General Settings</a></li>
            <li class="active">Update General Settings</li>
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
                    
                      <div class="col-xs-6">
                      <label>Receiver Name</label>
                      <input type="text" class="form-control" name="upd_nameto_set" value="<?=$data[0]['nameto_set']?>" />
                      </div>
                    
                    
                      <div class="col-xs-6">
                      <label>Receiver Email</label>
                      <input type="text" class="form-control" name="upd_emailto_set" value="<?=$data[0]['emailto_set']?>" />
                      </div>
                      
                      <div class="col-xs-6">
                      <label>Sender Name</label>
                      <input type="text" class="form-control" name="upd_namefrom_set" value="<?=$data[0]['namefrom_set']?>" />
                      </div>
                    
                    
                      <div class="col-xs-6">
                      <label>Sender Email</label>
                      <input type="text" class="form-control" name="upd_emailfrom_set" value="<?=$data[0]['emailfrom_set']?>" />
                      </div>
                    
                      <div class="col-xs-12">
                      <label>Email Header</label>
                      <textarea class="ckeditor" name="upd_email_header_set" rows="5"><?=$data[0]['email_header_set']?></textarea>
                      </div>
                      
                      <div class="col-xs-12">
                      <label>Email Footer</label>
                      <textarea class="ckeditor" name="upd_email_footer_set" rows="5"><?=$data[0]['email_footer_set']?></textarea>
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
