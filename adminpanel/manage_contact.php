<?php include "dbcon.php"; ?>
<?php 
if($_SESSION['admins']['ID'] == ""){
	header("location:index.php");
}
/*multiple deletion*/
if(isset($_REQUEST['multidelete'])){
	$imgfields = array('','');
	$chk = $general->delmulti("enquiry_enq","id_enq","",$imgfields);
	echo $chk; exit();	
}
/*single deletion*/
if(isset($_GET['id'])){
	$imgfields = array('','');
	$chk = $general->delGenDetails("enquiry_enq","id_enq","",$imgfields);
	echo $chk; exit();
}

$optbyid=$general->getAll(" enquiry_enq where origin_enq = 'contact' order by id_enq desc ");
?>
<!DOCTYPE html>
<html>
  <?php include "inc_head.php"; ?>
  <body class="hold-transition skin-blue sidebar-mini">
  	<!--DIALOG BOXES-->
    <div id="confirmation_dialog" title="Delete Confirmation" style="display:none">
      <p>Are you sure,you want to delete this record ?</p>
    </div>
    <div id="confirmation_dialog_multi" title="Delete Confirmation" style="display:none">
      <p>Are you sure,you want to delete these selected records. ?</p>
    </div>
    <div id="dialog-message" title="Message" style="display:none;">
      <p> <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;  "></span> Record has been deleted Successfully . </p>
    </div>
    
    <div id="view_dialog" title="View Details" style="display:none">
      <span id="viewdets"></span>
    </div>
	<!--DIALOG BOXES ENDS-->
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
            Manage Contact Us
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=$conf->site_url?>adminpanel/dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Manage Contact Us</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                <?php if(isset($_POST['sortion'])){
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
                  <h3 class="box-title" style="float:right !important;"></h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                <? if(is_array($optbyid)){ ?>
                  <form id="frm" name="manageform" method="post" action="">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr> 
                      <th><input id="selectall" class="check-all" type="checkbox" /></th>                          
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Date</th>
                        <th>Actions</th>                        
                      </tr>
                    </thead>
                    <tbody>
                    <? for($d=0; $d<count($optbyid); $d++){?>
                    	<tr> 
                        <td><input type="checkbox" name="checkbox[]" class="case" value="<? echo $optbyid[$d]['id_enq'];?>" /></td>                       	
                            <td><?=$optbyid[$d]['firstname_enq']?></td>
                            <td><?=$optbyid[$d]['email_enq']?></td>
                            <td><?=$optbyid[$d]['contact_enq']?></td>
                            <td><?=$optbyid[$d]['date_enq']?></td>
                            <td style="text-align:center !important;">
                            <!--view-->
                            <a href="#" class="view" id="<?php echo $optbyid[$d]['id_enq']?>" ><img src="dist/img/icons/view.png" alt="Edit" /></a>
                            <!--delete-->
                            <a href="#" class="delete" id="<? echo $optbyid[$d]['id_enq'];?>"><img src="dist/img/icons/cross.png" alt="Delete" /></a>
                            </td>
                        </tr>
                    <? } ?>  
                    </tbody> 
                    <tfoot>
                      <tr>
                        <th colspan="6" style="text-align:right;">
                        <!--delete button-->
                        <input type="button" name="delete" class="btn btn-primary delmulti" value="Delete Selected" />
                                                
                      </tr>
                    </tfoot>                   
                  </table>
                  </form>
                <? }else{ ?>
                	<p>No Data Found</p>
                <? } ?>  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php include "inc_footer.php"; ?>
    </div><!-- ./wrapper -->
    <?php include "inc_scripts.php"; ?>    
<?php include "inc_managescripts.php"; ?>
  </body>
</html>
