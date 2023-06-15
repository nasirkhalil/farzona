<?php include "dbcon.php";
if($_SESSION['admins']['ID'] == ""){

	header("location:index.php");

}
if(isset($_GET['cid'])){
	$_GET['cid'] = base64_decode($_GET['cid']);
}
if($_POST['button'] != "" || $_POST['button'] != NULL){
	// parameter to make url from
	$params = array(
	'tab' => 'city_c',
	'id' => 'id_c',
	'urlfield' => 'name_c',
	'parent' => 'idcou_c',
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
				} ?>    
                </div><!-- /.box-header -->
                <!-- form start -->
                <form name="addform" method="post" action="" enctype="multipart/form-data">
                  <div class="box-body">
                  <? $coutry=$general->getAll("country_cou where status_cou=1 order by order_cou");?>
                  <? if(is_array($coutry)) {?>
                  	  <div class="col-xs-4">
                      <label>Parent Category</label>
                      <select name="pre_idcou_c" class="form-control">
                     <? for($a=0;$a<count($coutry);$a++){?>
                      <option value="<?=$coutry[$a]['id_cou'];?>"><?=$coutry[$a]['name_cou'];?></option>
                      <? }?>
                      </select>
                     </div>
                      <? }?>
                      <div class="col-xs-4">
                      <label>Name</label>
                      <input type="text" class="form-control" name="pre_name_c" />                      
                      </div>
                      
                      
                      <div class="clearfix"></div>
                      <div class="col-xs-4">
                      <label>Status</label>
                      <select class="form-control" name="pre_status_c">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                      </select>
                      </div>
                      
                      <div class="col-xs-4">
                      <label>Order</label>
                      <input type="text" class="form-control"  name="pre_order_c"/>
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
  </body>
</html>
