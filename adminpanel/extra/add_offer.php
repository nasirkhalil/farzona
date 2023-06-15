<?php include "dbcon.php";
$pagename = basename($_SERVER['PHP_SELF']);
$pagename = explode(".",$pagename);
$pagetype  = explode("_",$pagename[0]);
$pagetype = $pagetype[1];
if($_SESSION['admins']['ID'] == ""){

	header("location:index.php");

}

if($_POST['button'] != "" || $_POST['button'] != NULL){
	$params = array(
	'tab' => 'offers_ofr',
	'id' => 'id_ofr',
	'urlfield' => 'name_ofr',
	'parent' => '',
	'imgpath' => $conf->absolute_path.$conf->general_dir,
	'thumb' => 0,
	'thumbWidth' => 0,
	'thumbHeight' => 0,
	'parenttab' => 'content_cms',
	'parenttabid' => 4,
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
            Add <?=$pagetype?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="manage_<?=$pagetype?>.php">Manage <?=$pagetype?></a></li>
            <li class="active">Add <?=$pagetype?></li>
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
                      <input type="text" class="form-control" name="pre_name_ofr" />
                      </div>
                      <div class="col-xs-4">
                      <label>Meta Title</label>
                      <input type="text" class="form-control" name="pre_metatitle_ofr" />
                      </div>
                      <div class="col-xs-4">
                      <label>Meta Description</label>
                      <input type="text" class="form-control" name="pre_metadescription_ofr" />
                      </div>
                      
                      
                     
                      
                      
                      <div class="col-xs-12">
                      <label>Details</label>
                      <textarea class="ckeditor" name="pre_details_ofr" rows="5"></textarea>
                      </div>
                      
                     <div class="col-xs-4">
                      <label>Image</label>
                      <input type="file" class="form-control" name="pre_image_name_ofr" />
                      </div>
                      <div class="col-xs-4">
                      <label>Image Title</label>
                      <input type="text" class="form-control" name="pre_image_title_ofr" />
                      </div>
                      <div class="col-xs-4">
                      <label>Image Alt</label>
                      <input type="text" class="form-control" name="pre_image_alt_ofr" />
                      </div>
                      
                     
                      
                
                      
                      
                      <div class="col-xs-4">
                      <label>Status</label>
                      <select class="form-control" name="pre_status_ofr">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                      </select>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Order</label>
                      <input type="text" class="form-control"  name="pre_order_ofr"/>
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
    <script type="text/javascript">
	$(document).ready(function(){
		//alert('jquery loaded');
		$('#fckradio').click(function(){
				$('#fckshow').show();
				$('#linkshow').hide();
		});
		
		$('#linkradio').click(function(){
				$('#linkshow').show();
				$('#fckshow').hide();
		});
		
	});
	</script>
  </body>
</html>
