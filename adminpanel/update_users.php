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
	// parameters array
	$params = array(
	'tab' => 'user_usr',
	'id' => 'id_usr',
	'urlfield' => 'first_name_usr',
	'parent' => '',
	'imgpath' => $conf->absolute_path.$conf->files_dir,
	'thumb' => 0,
	'thumbWidth' => 0,
	'thumbHeight' => 0,
	'parenttab' => 'content_cms',
	'parenttabid' => 2,
	);
	$chk=$general->updDetailsAdmin($params);
}
$data = $general->getSingdet(" user_usr where id_usr = ".$_GET['id']);
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
            Update Candidate
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="manage_<?=$pagetype?>.php">Manage Candidate</a></li>
            <li class="active">Update Candidate</li>
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
                   <? $locations = $general->getAll(" ccity_cty order by name_cty ");
					  if(is_array($locations)){ ?>
                      <div class="col-xs-4">
                      <label>Location</label>
                      <select name="upd_address_usr" class="form-control">
                      <? for($l=0; $l<count($locations); $l++){?>
                      	<option value="<?=$locations[$l]['id_cty']?>" <? echo $data[0]['address_usr']==$locations[$l]['id_cty']?"selected":"";?>><?=$locations[$l]['name_cty']?></option>
					  <? } ?>
                      </select>
                      </div>
                      <?
					  } ?>
                     
                      
                      <div class="col-xs-4">
                      <label>Name</label>
                      <input type="text" class="form-control" name="upd_first_name_usr" value="<?=$data[0]['first_name_usr']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Email Address</label>
                      <input type="text" class="form-control" name="upd_email_usr" value="<?=$data[0]['email_usr']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Title</label>
                      <input type="text" class="form-control" name="upd_metatitle_usr" value="<?=$data[0]['metatitle_usr']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Keywords</label>
                      <input type="text" class="form-control" name="upd_metatag_usr" value="<?=$data[0]['metatag_usr']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Description</label>
                      <input type="text" class="form-control" name="upd_metadescription_usr" value="<?=$data[0]['metadescription_usr']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Experience</label>
                      <input type="text" class="form-control" name="upd_experience_usr" value="<?=$data[0]['experience_usr']?>" />
                      </div>
                      
                      <div class="col-xs-12">
                      <label>Short Details</label>
                      <textarea class="form-control" name="upd_shortdetails_usr"><?=$data[0]['shortdetails_usr']?></textarea>
                      </div>
                      
                      <div class="col-xs-12">
                      <label>Details</label>
                      <textarea class="ckeditor" name="upd_details_usr"><?=$data[0]['details_usr']?></textarea>
                      </div>
                      <div class="col-xs-4">
                      <label>CV</label>
                      <input type="file" class="form-control"  name="upd_cv_usr"/>
                      </div>
                      
                     <div class="col-xs-4">
                      <label>Status</label>
                      <select class="form-control" name="upd_status_usr">
                      <option value="1" <? echo $data[0]['status_usr']==1?"selected":"";?>>Active</option>
                      <option value="0" <? echo $data[0]['status_usr']==0?"selected":"";?>>Inactive</option>
                      </select>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Order</label>
                      <input type="text" class="form-control"  name="upd_order_usr" value="<?=$data[0]['order_usr']?>"/>
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
