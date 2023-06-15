<?php include "dbcon.php";
if($_SESSION['admins']['ID'] == ""){

	header("location:index.php");
}

if($_POST['button'] != "" || $_POST['button'] != NULL){
	// parameters array
	$params = array(
	'tab' => 'photographer_ph',
	'id' => 'id_ph',
	'urlfield' => 'name_ph',
	'parent' => '',
	'imgpath' => $conf->absolute_path.$conf->photographer_dir,
	'thumb' => 1, // 0 for no thumb, 1 for thumb 
	'thumbWidth' => $conf->PhLargeThumbWidth,
	'thumbHeight' => $conf->PhLargeThumbHeight,
	'thumb2' => 1, // 0 for no thumb, 1 for thumb
	'thumb2Width' => $conf->PhSmallThumbWidth,
	'thumb2Height' => $conf->PhSmallThumbHeight,
	'parenttab' => 'content_cms',
	'parenttabid' => 4,
	);
	$chk = $general->insertDetailsAdmin($params);
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
            <li><a href="manage_<?=$pagetype?>.php">Manage <?=$general->PageType($pagetype);?></a></li>
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
                  <? $cities = $general->getAll(" city_c ");
				  if(is_array($cities)){ ?>
                  	  <div class="col-xs-4">
                      <label>Location</label>
                      <select name="pre_location_ph" class="form-control">
                      <? for($c=0; $c<count($cities); $c++){ ?>
                      	<option value="<?=$cities[$c]['name_c']?>" <? if($_POST['location_ph']==$cities[$c]['name_c']) echo 'selected'; ?>><?=$cities[$c]['name_c']?></option>
                      <? } ?>
                      </select>
                      </div>
                  <? } ?>    
                      <div class="col-xs-4">
                      <label>Name</label>
                      <input type="text" class="form-control" name="pre_name_ph" value="<?=$_POST['pre_name_ph']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Designation</label>
                      <input type="text" class="form-control" name="pre_designation_ph" value="<?=$_POST['pre_designation_ph']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Email</label>
                      <input type="text" class="form-control" name="pre_email_ph" value="<?=$_POST['pre_email_ph']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Mobile</label>
                      <input type="text" class="form-control" name="pre_mobile_ph" value="<?=$_POST['pre_mobile_ph']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Passion</label>
                      <input type="text" class="form-control" name="pre_passion_ph" value="<?=$_POST['pre_passion_ph']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Title</label>
                      <input type="text" class="form-control" name="pre_metatitle_ph" value="<?=$_POST['pre_metatitle_ph']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Keywords</label>
                      <input type="text" class="form-control" name="pre_metatag_ph" value="<?=$_POST['pre_metatag_ph']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Meta Description</label>
                      <input type="text" class="form-control" name="pre_metadescription_ph" value="<?=$_POST['pre_metadescription_ph']?>" />
                      </div>
                      
                      <div class="col-xs-12">
                      <label>Short Description</label>
                      <textarea class="form-control" name="pre_shortdetails_ph" rows="5"><?=$_POST['pre_shortdetails_ph']?></textarea>
                      </div>
                      
					  <div class="col-xs-12">
                      <label>Details</label>
                      <textarea class="ckeditor" name="pre_details_ph" id="details"><?=$_POST['pre_details_ph']?></textarea>
                      </div>
                      
<? $cats = $general->getAll(" category_cat where status_cat = '1' order by name_cat "); 
if(is_array($cats)){
	$phexpertise = $general->getAll(" photographerexpertise_pe where idph_pe = ".$_GET['id']);
	$mtarr = array();
	if(is_array($phexpertise)){
		for($a=0; $a<count($phexpertise); $a++){
			$mtarr[] = $phexpertise[$a]['idcat_pe'];
		}
	} ?>                      
                      <div class="col-xs-12">
                      <label>Expertise</label><br />
                      <? for($c=0; $c<count($cats); $c++){ ?>
                               <input type="checkbox" name="expertise[]" value="<?=$cats[$c]['id_cat']?>" <? if(in_array($cats[$c]['id_cat'],$mtarr)) echo 'checked="checked"'; ?> /><?=$cats[$c]['name_cat']?>&nbsp;
							   <? }?>
                      </div>
<? 
} ?>                      
                      <div class="col-xs-4">
                      <label>Photographer Image</label>
                      <input type="file" name="pre_image_name_ph" class="form-control" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Image Title</label>
                      <input type="text" class="form-control" name="pre_image_title_ph" value="<?=$_POST['pre_image_title_ph']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Image Alt</label>
                      <input type="text" class="form-control" name="pre_image_alt_ph" value="<?=$_POST['pre_image_alt_ph']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Show on Home</label>
                      <select name="pre_onhome_ph"class="form-control">                  		<option value="No" selected="selected">No</option>
						<option value="Yes">Yes</option>
            		  </select>
                      </div>
                      
                      <? if($conf->ar==1){ ?>
                      <div class="col-xs-12">
                      <h3>Arabic</h3>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Heading</label>
                      <input type="text" class="form-control" name="pre_headingar_ph" value="<?=$data[0]['headingar_ph']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Label</label>
                      <input type="text" class="form-control" name="pre_labelar_ph" value="<?=$data[0]['labelar_ph']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Image Title</label>
                      <input type="text" class="form-control" name="pre_image_titlear_ph" value="<?=$data[0]['image_titlear_ph']?>" />
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Arabic Image Alt</label>
                      <input type="text" class="form-control" name="pre_image_altar_ph" value="<?=$data[0]['image_altar_ph']?>" />
                      </div>
                      <? } ?>
                      <div class="clearfix"></div>
                      <div class="col-xs-4">
                      <label>Status</label>
                      <select class="form-control" name="pre_status_ph">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                      </select>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Order</label>
                      <input type="text" class="form-control"  name="pre_order_ph" value="<?=$_POST['pre_order_ph']?>" />
                      </div>
                                       
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" name="button" value="Update" class="btn btn-primary">Add</button>
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
