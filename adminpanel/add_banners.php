<?php include "dbcon.php";
if($_SESSION['admins']['ID'] == ""){

	header("location:index.php");

}

if($_POST['button'] != "" || $_POST['button'] != NULL){
	$params = array(
	'tab' => 'banner_ban',
	'id' => 'id_ban',
	'urlfield' => 'label_ban',
	'parent' => '',
	'imgpath' => $conf->absolute_path.$conf->banner_dir,
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
            Add <?=$general->PageType($pagetype);?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="manage_<?=$pagetype?>">Manage <?=$general->PageType($pagetype);?></a></li>
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
                  
                      <?php /*?><div class="col-xs-4">
                      <label>Heading Line 1</label>
                      <input type="text" class="form-control" name="pre_label_ban" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Heading Line 2</label>
                      <input type="text" class="form-control" name="pre_heading_ban" />
                      </div><?php */?>
                      
                      <div class="col-xs-4">
                      <label>Banner Image</label>
                      <input type="file" name="pre_image_name_ban" class="form-control" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Image Title</label>
                      <input type="text" class="form-control" name="pre_image_title_ban" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Image Alt</label>
                      <input type="text" class="form-control" name="pre_image_alt_ban" />
                      </div>
                      
                     <?php /*?> <div class="col-xs-12">
                      <label>&nbsp;</label>
                      <input type="radio" name="is_fck_ban" value="Yes"id="fckradio" />FCK
                      &nbsp;&nbsp;&nbsp;
                      <input type="radio" name="is_fck_ban" value="No" id="linkradio" checked />Link
                      </div>
                      
                      <div class="col-xs-4 linkdiv">
                      <label>Link</label>
                      <input type="text" class="form-control" name="pre_link_ban" />
                      </div>
                      
                      <div id="fckdiv" style="display:none;">
                      <div class="col-xs-4">
                      <label>Meta Title</label>
                      <input type="text" class="form-control" name="pre_metatitle_ban" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Keywords</label>
                      <input type="text" class="form-control" name="pre_metatag_ban" />
                      </div>
                      <div class="col-xs-4">
                      <label>Meta Description</label>
                      <input type="text" class="form-control" name="pre_metadescription_ban" />
                      </div>
                      
                      <div class="col-xs-12">
                      <label>Details</label>
                      <textarea class="ckeditor" name="pre_details_ban" rows="5" cols="10"></textarea>
                      </div>
                      </div><?php */?>
                      
                      <?php /*?><? if($conf->ar==1){ ?>
                      <div class="col-xs-12">
                      <h3>Arabic</h3>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Label</label>
                      <input type="text" class="form-control" name="pre_labelar_ban" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Image Title</label>
                      <input type="text" class="form-control" name="pre_image_titlear_ban" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Image Alt</label>
                      <input type="text" class="form-control" name="pre_image_altar_ban" />
                      </div>
                      <? } ?><?php */?>
                      
                      <div class="clearfix"></div>
                      <div class="col-xs-4">
                      <label>Status</label>
                      <select class="form-control" name="pre_status_ban">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                      </select>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Order</label>
                      <input type="text" class="form-control"  name="pre_order_ban"/>
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
				$('#fckdiv').show();
				$('.linkdiv').hide();
		});
		
		$('#linkradio').click(function(){
				$('.linkdiv').show();
				$('#fckdiv').hide();
		});
		
	});
	</script>
  </body>
</html>
