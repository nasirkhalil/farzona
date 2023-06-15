<?php include "dbcon.php";
if($_SESSION['admins']['ID'] == ""){

	header("location:index.php");

}
if(isset($_POST['size_type_id']) && $_POST['size_type_id']!=""){
  // echo "tesignt"; die;
  // echo "<pre>"; print_r($_POST); die;
  $parent_id = 0;
  if($_POST['size_type_id']==2){
    $parent_id = $_POST['width_id'];
  }else if($_POST['size_type_id']==3){
    $parent_id = $_POST['height_id'];
  }else if($_POST['size_type_id']==5){
    $parent_id = $_POST['make_id'];
  }else if($_POST['size_type_id']==6){
    $parent_id = $_POST['model_id'];
  }
  // die("size_details where size_type_id=".$_POST['size_type_id']." and value=".$_POST['value']." and parent_id=".$parent_id);
  $chk_rec = $general->getAll("size_details where size_type_id=".$_POST['size_type_id']." and value=".$_POST['value']." and parent_id=".$parent_id);
  if( is_array($chk_rec) && count($chk_rec) > 0 ){
     $resp = ['status'=>0,"msg"=>"Record already exist."];
  }else{
    $q = "insert into size_details(size_type_id,value,parent_id) values(".$_POST['size_type_id'].",'".$_POST['value']."',".$parent_id.")";
    $chk=$general->CustomQuery($q);
    if($chk){
      $resp = ['status'=>1,"msg"=>"Added successfully."];
    }else{
      $resp = ['status'=>0,"msg"=>"Error while adding data."];
    }
  }
  echo json_encode($resp);
  return;
}
if(isset($_GET['cid'])){
	$_GET['cid'] = base64_decode($_GET['cid']);
}
if($_POST['button'] != "" || $_POST['button'] != NULL){
	// parameter to make url from
	$params = array(
	'tab' => 'size_details1',
	'id' => 'id',
	'urlfield' => '',
	'parent' => 'parent_id',
	'imgpath' => $conf->absolute_path.$conf->category_dir,
	'thumb' => 0,
	'thumbWidth' => 265,
	'thumbHeight' => 265,
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
				} ?>    <!-- success alert -->
                    <div class="alert alert-success alert-dismissable hidden">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check"></i> <span class="add_msg"></span>
                  </div>
                  <div class="alert alert-danger alert-dismissable hidden">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i> <span class="add_msg"></span>
                  </div>
                  <!-- success alert ends -->  
                </div><!-- /.box-header -->
                <!-- form start -->
                <form name="addform" id="addform" method="post" action="" enctype="multipart/form-data">
                  <div class="box-body">
                    <div class="row">
                        <?php $size_type = $general->getAll("size_type where status=1")  ?>
                        <div class="col-xs-4">
                          <label>Type </label>
                          <select name="size_type_id" id="size_type_id" onchange="showType(this.value)" class="form-control">
                            <option value="">-Select Type-</option>
                            <?php if(is_array($size_type)){
                              for($i=0; $i<count($size_type); $i++) { ?>
                                <option value="<?php echo $size_type[$i]['id'] ?>"><?php echo $size_type[$i]['name']?></option>
                            <?php }
                              } ?>
                          </select>                     
                        </div>
<!--                         <div class="col-xs-4">
                          <label>Select </label>
                          <select name="pre_parent_id" class="form-control">
                          <option value="">--Select--</option>
                          <? $subsize=$general->getAll("size_details1 where parent_id=".$size[$z]['id']); if(is_array($subsize)){?>
                          <? for($zz=0;$zz<count($subsize);$zz++){?>
                          <option value="<?=$subsize[$zz]['id'];?>">>>> <?=$subsize[$zz]['value'];?></option>
                          <? }?>
                          <? }?>
                          </select>           
                        </div> -->                     
                          <!-- <div class="clearfix"></div> -->
                     <!--    <div class="col-xs-4">
                          <label>Status</label>
                          <select class="form-control" name="pre_status">
                          <option value="1">Active</option>
                          <option value="0">Inactive</option>
                          </select>
                        </div> -->
                    </div>
                    <div class="row" id="by_size" style="display:none">
                        <?php $width = $general->getAll("size_details where size_type_id=1 and status=1")  ?>
                        <div class="col-xs-4" id="sb_width">
                          <label>Width </label>
                          <select onchange="showHiegth(this.value)" name="width_id" id="width_id" class="form-control">
                            <option value="">-Select Type-</option>
                            <?php if(is_array($width)){
                              for($i=0; $i<count($width); $i++) { ?>
                                <option value="<?php echo $width[$i]['id'] ?>"><?php echo $width[$i]['value']?></option>
                            <?php }
                              } ?>
                          </select>                     
                        </div>
                        <div class="col-xs-4" id="sb_height">
                          <label>Hieght </label>
                          <select name="height_id" id="height_id" class="form-control ajax-sel-render-hieght">
                          </select>           
                        </div>                     
                    </div>
                    <div class="row" id="by_vehicle" style="display:none">
                        <?php $make = $general->getAll("size_details where size_type_id=4 and status=1")  ?>
                        <div class="col-xs-4" id="sb_make">
                          <label>Make </label>
                          <select onchange="showHiegth(this.value)" name="make_id" id="make_id" class="form-control">
                            <option value="">-Select Type-</option>
                            <?php if(is_array($make)){
                              for($i=0; $i<count($make); $i++) { ?>
                                <option value="<?php echo $make[$i]['id'] ?>"><?php echo $make[$i]['value']?></option>
                            <?php }
                              } ?>
                          </select>                     
                        </div>
                        <div class="col-xs-4" id="sb_model">
                          <label>Model </label>
                          <select name="model_id" id="model_id" class="form-control ajax-sel-render-model">
                          </select>           
                        </div>                     
                    </div>
                    <div class="row">
                      <div class="col-xs-4">
                        <label>Title </label>
                        <input type="text" name="value" id="pre_value" class="form-control">        
                      </div> 
                    </div> <!-- end .row -->
                      
                     
                                       
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    
                  </div>
                </form>
                <button type="submit" onclick="saveRec()" name="button" value="A d d" class="btn btn-primary">A d d</button>
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
<script type="text/javascript">
  function saveRec() {
    $.ajax({
      type: 'POST',
      url: 'add_size.php',
      data:$('#addform').serialize(),
      success: function(response) {//if the page ajax_delete.php returns the value "1"
        var resp = $.parseJSON(response);
         
        $('#pre_value').val('');
        if(resp.status==1){
          $(".alert-success").removeClass("hidden");
          $(".alert-danger").addClass("hidden");

          $(".add_msg").html(resp.msg);
          location.reload();
        }else if(resp.status==0){
          $(".alert-danger").removeClass("hidden");
          $(".alert-success").addClass("hidden");

          $(".add_msg").html(resp.msg);
        }
      }
    });
  }
  function showHiegth(val) {
    $.ajax({//make the Ajax Request
      type: 'POST',
      url: 'ajax_size.php',
      data:'parent_id='+val,
      success: function(response) {//if the page ajax_delete.php returns the value "1"
        // alert(response);
        var type_val = $('#size_type_id').val();
        if(type_val==3){
          $('.ajax-sel-render-hieght').html(response);
        }else if(type_val==6){
          $('.ajax-sel-render-model').html(response);
        }
      }
    });
  }

  function showType(val) {
    if(val==1 || val==2 || val==3){
      $('#by_size').show();
      if(val==2){
        $('#sb_width').show();
        $('#sb_height').hide();
      }else if(val==3){
        $('#sb_width').show();
        $('#sb_height').show();
      }else{
        $('#sb_width').hide();
        $('#sb_height').hide();
      }
    }else{
      $('#sb_width').hide();
      $('#sb_height').hide();
      $('#by_size').hide();

    }
    //for vehicle
    if(val==4 || val==5 || val==6){
      $('#by_vehicle').show();
      if(val==5){
        $('#sb_make').show();
        $('#sb_model').hide();
      }else if(val==6){
        $('#sb_make').show();
        $('#sb_model').show();
      }else{
        $('#sb_make').hide();
        $('#sb_model').hide();
      }
    }else{
      $('#by_vehicle').hide();

    }
  }
</script>