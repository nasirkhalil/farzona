<?php include "dbcon.php"; ?>
<?php 
if($_SESSION['admins']['ID'] == ""){
	header("location:index.php");
}
/*multiple deletion*/
if(isset($_REQUEST['multidelete'])){
	$imgfields = array('','');
	$chk = $general->delmulti("order_ord","id_ord",$conf->absolute_path.$conf->color_dir,$imgfields);
	$chk = $general->delmulti("order_detail_orddet","idord_orddet",$conf->absolute_path.$conf->color_dir,$imgfields);
	//echo $chk; exit();	
}
/*single deletion*/
if(isset($_GET['id'])){
	$imgfields = array('','');
	$chk = $general->delGenDetails("order_ord","id_ord",$conf->absolute_path.$conf->color_dir,$imgfields);
	$chk = $general->delGenDetails("order_detail_orddet","idord_orddet",$conf->absolute_path.$conf->color_dir,$imgfields);
	//echo $chk; exit();
}
/*sortion*/
if(isset($_POST['sortion'])){
	$chk = $general->sortDataGeneral("order_ord","order_ord","id_ord");	
}
/*status updation*/
if(isset($_POST['statusid'])){
	$id = explode("_",$_POST['statusid']);
	
	//echo "sss".$_POST['value']; die();
	//echo "update order_ord set ordstatus_ord = '".$_POST['value']."' where id_ord = ".$id[1]; die();
	$general->CustomModify("update order_ord set ordstatus_ord = '".$_POST['value']."' where id_ord = ".$id[1]);
	usleep(2000);
	
	$em_data = $general->getAll("order_ord where ordstatus_ord = '".$_POST['value']."' AND id_ord = ".$id[1]."");
	$em_data[0]['email_ord'];
	$getadmin=$general->getAll("setting_set");

		$message='
		<div style="margin:0; font-family: sans-serif; background: #f5f5f5;">

<div style="text-align:center; background:#fefefe; padding: 50px 0; border-bottom:1px solid #bebebe; border-top:1px solid #bebebe;">

<img src="'.$conf->site_url.'images/logo.png" alt="" style="display:block; margin:0 auto;" />

<h1 style="font-size:2.0vw; color:#153c7e ;border-top: 1px solid #bebebe; width: 50%; margin: 0 auto; padding-top: 20px;">Your Order Status</h1>
</div>

<div style="width:800px; margin:0 auto;">
<p style="font-size: 16px; line-height: 25px; color:#6b6b6b; margin: 20px 30px 0; text-align:center;">Dear '.$em_data[0]['name_ord'].',</p>
<p style="font-size: 16px; line-height: 25px; color:#6b6b6b; margin: 20px 30px 0; text-align:center;">Thank you for Order with <a href='.$conf->site_url.'>'.$conf->site_name.'</a></p>
<p style="font-size: 16px; line-height: 25px; color:#6b6b6b; margin: 20px 30px 0;">Your Order Tracking Number '.$em_data[0]['tracking_number_ord'].' Status is now in '.$_POST['value'].' State </a></p>
<p style="font-size: 16px; line-height: 25px; color:#6b6b6b; margin: 20px 30px 0; text-align:center;">Thanks!</p>
<div style="clear:both"></div>
</div>

<div style="width:800px; margin:0 auto 25px; margin-top: 10px; border-top: 1px solid #d4d4d4;padding-top: 30px;">
<div style="width:100%; text-align:center; margin:0 auto;">"'.$getadmin[0]['email_footer_set'].'"
		                   
</div>
</div>
<div style="clear:both"></div>
</div>';


		$to = $em_data[0]['email_ord'];
		$subject=$conf->site_name." Status of Order";
		//echo "<br>to:::".$to."<br>Subject:::". $subject."<br>message:::". $message."<br>headers:::". $headers;
		//echo "$getadmin[0]['namefrom_set'],$getadmin[0]['emailfrom_set'],$to,$subject,$message,'',0";
		$general->sendMail($getadmin[0]['namefrom_set'],$getadmin[0]['emailfrom_set'],$to,$subject,$message,0);
	
	
	echo $_POST['value'];
	if($_POST['value']=='Payment Received'){
		//
		echo "<script type='text/javascript'>window.location.href = '".$_SERVER['PHP_SELF']."';</script>";//echo $_POST['value']; die();
		//header('location:manage_order.php');
	}
		
	exit();
}
/*status updation ends */
/* get all banners by origin */
$optbyid = $general->getAll(" order_ord order by id_ord desc");
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
            Manage <?=$general->PageType($pagetype);?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=$conf->site_url?>adminpanel/dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Manage <?=$general->PageType($pagetype);?></li>
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
                  <!--<h3 class="box-title" style="float:right !important;"><a href="add_<?=$pagetype?>.php">Add <?=$general->PageType($pagetype);?></a></h3>-->
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                <? if(is_array($optbyid)){ ?>
                  <form id="frm" name="manageform" method="post" action="">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                      	<th class="no-sort"><input id="selectall" class="check-all" type="checkbox" /></th>                        
                        <th>Tracking #</th>
                        <th>Item</th>
                        <th class="no-sort">Qty</th>
                        <th>Name</th>
                        <th class="no-sort">Email</th>
                        <th class="no-sort">Contact #</th>
                        <th class="no-sort">Date</th>
                        <th class="no-sort">Total Amount</th>
                        <th class="no-sort">Status</th>
                        <th class="no-sort">Actions</th>                        
                      </tr>
                    </thead>
                    <tbody class="newbody">
                    <? for($d=0; $d<count($optbyid); $d++){?>
                    	<tr>
                        	<td><input type="checkbox" name="checkbox[]" class="case" value="<? echo $optbyid[$d]['id_ord'];?>" /></td>                        	
                            <td><?=$optbyid[$d]['tracking_number_ord']?></td>
                            <?php 	
						//echo "order_detail_orddet where trackingnum_orddet = '".$optbyid[$d]['tracking_number_ord']."'";			
							$ords = $general->getAll("order_detail_orddet where trackingnum_orddet = '".$optbyid[$d]['tracking_number_ord']."'");
						?>  
                        	
                            <td>
                            <? for($dd=0; $dd<count($ords); $dd++){ ?>
                            	<div class="col-md-12" style="height: auto;">
                                	<?=$ords[$dd]['name_orddet']?>
                                    </div>
                                
                            <?php }?>
                            </td>
                            <td>
                             <? for($da=0; $da<count($ords); $da++){ ?>
                             <div class="col-md-12" style="height: auto;">
								<?=$ords[$da]['quantity_orddet']?>
                                </div>
                             <?php }?> 
                            </td>
                            <td><?=$optbyid[$d]['name_ord']?></td>
                            <td><?=$optbyid[$d]['email_ord']?></td>
                            <td><?=$optbyid[$d]['phone_ord']?></td>
                            <td><?=$optbyid[$d]['date_ord']?></td>
                            <td>AED <?=number_format($optbyid[$d]['gross_ord']);?> </td>
                            <td><a href="<?=$conf->admin_url;?>update_status.php?id=<?=base64_encode($optbyid[$d]['id_ord'])?>">Update Status</a></td>
                            <?php /*?><td> <? if($optbyid[$d]['ordstatus_ord']!="Payment Received"){?><b class="ordstatus" id="st_<? echo $optbyid[$d]['id_ord'];?>" style="display: inline"><? if($optbyid[$d]['ordstatus_ord']!="Payment Received"){?><?=$optbyid[$d]['ordstatus_ord']?><? }?></b><? }else { ?><b><?=$optbyid[$d]['ordstatus_ord'];?></b><? }?></td><?php */?>
                            
                            <td style="text-align:center !important;">
                            <!--view-->
                            <a href="#" class="view" id="<?php echo $optbyid[$d]['id_ord']?>" ><img src="dist/img/icons/view.png" alt="Edit" /></a>
                            <?php /*?><!--update-->
                            <a href="update_<?=$pagetype?>.php?id=<?php echo base64_encode($optbyid[$d]['id_ord'])?>" target="_self" title="Edit"><img src="dist/img/icons/pencil.png" alt="Edit" /></a><?php */?>
                            <!--delete-->
                            
                            <a href="#" class="delete" id="<? echo $optbyid[$d]['id_ord'];?>"><img src="dist/img/icons/cross.png" alt="Delete" /></a>
                            
                            </td>
                        </tr>
                    <? } ?>  
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="10" style="text-align:right;">
                        <!--delete button-->
                        <input type="button" name="sortion" class="btn btn-primary delmulti" value="Delete Selected" />
                        <!--sortion button-->
                        </th>                        
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
