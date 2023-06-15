<?php include "dbcon.php";
$pagename = basename($_SERVER['PHP_SELF']);
$pagename = explode(".",$pagename);
$pagetype  = explode("_",$pagename[0]);
$pagetype = $pagetype[1]; ?>
<?php 
if($_SESSION['admins']['ID'] == ""){
	header("location:index.php");
}
if(isset($_GET['id'])){
	$general->delGenDetails("news_nws","id_nws","",$conf->absolute_path.$conf->banner_dir);
}
if(isset($_POST['sortion'])){
	$chk = $general->sortDataGeneral("news_nws","order_nws","id_nws");	
}
if(isset($_GET['status'])){
	$_GET['st_id'] = base64_decode($_GET['st_id']);
	if($_GET['status']=='Inactive'){
		
		$qry= "UPDATE news_nws set status_nws='0' where id_nws=".$_GET['st_id'];
		$general->CustomModify($qry);
	 
	} 
	else{
		 
		 $qry1= "UPDATE news_nws set status_nws='1' where id_nws=".$_GET['st_id'];
		 $general->CustomModify($qry1);		
		
	}
}
$optbyid=$general->getAll(" news_nws where type_nws='news'");
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
            Manage <?=$pagetype?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=$conf->site_url?>adminpanel/dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Manage <?=$pagetype?></li>
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
                  <h3 class="box-title" style="float:right !important;"><a href="add_<?=$pagetype?>.php">Add <?=$pagetype?></a></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                <? if(is_array($optbyid)){ ?>
                  <form name="manageform" method="post" action="">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>                        
                        <th>Title</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>&nbsp;</th>                        
                      </tr>
                    </thead>
                    <tbody>
                    <? for($d=0; $d<count($optbyid); $d++){?>
                    	<tr>                        	
                            <td><?=$optbyid[$d]['title_nws']?></td>
                            <td><? if($optbyid[$d]['status_nws']==1)
				   { ?><a href='?status=Inactive&st_id=<?=base64_encode($optbyid[$d]['id_nws'])?>'>Active</a><? }  else { ?><a href='?status=Active&st_id=<?=base64_encode($optbyid[$d]['id_nws'])?>'>Inactive</a><? } ?></td>
                            <td><input type="text" size="1" name="ordsort_<?php echo $optbyid[$d]['id_nws'];?>" value="<?=$optbyid[$d]['order_nws']?>" /></td>
                            <td style="text-align:center !important;">
                            <?php /*?><a href="#" class="view" id="<?php echo $optbyid[$d]['id_nws']?>" ><img src="dist/img/icons/view.png" alt="Edit" /></a><?php */?>
                            <a href="update_<?=$pagetype?>.php?id=<?php echo base64_encode($optbyid[$d]['id_nws'])?>" target="_self" title="Edit"><img src="dist/img/icons/pencil.png" alt="Edit" /></a>
                            <a href="#" class="delete" id="<? echo $optbyid[$d]['id_nws'];?>"><img src="dist/img/icons/cross.png" alt="Delete" /></a>
                            </td>
                        </tr>
                    <? } ?>  
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="4" style="text-align:right;"><input type="submit" name="sortion" class="btn btn-primary" value="Update Order" /></th>                        
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
<link rel="stylesheet" type="text/css" href="dist/css/jquery-ui.css"/>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
<script language="javascript">
$(function () {
    
	$("#dialog-message").hide();
	$("#confirmation_dialog").hide();
	$("#confirmation_dialog_multi").hide();
     
	/*Hiding the div with ID dialog-message and #confirmation_dialog These 2 divs are responsible for the modal boxes .*/
   
	/* Function to Initialise a Dialog instance for the modal box */
	function modal_message()
	{
		
		$("#dialog-message").dialog({
			modal: true,
			buttons: {
			Ok: function() {
				$(this).dialog('destroy');
						
				}// OK function
			}
		});
	}

	$('a.delete').click(function(e){ // if a user clicks on the "delete" image
	//e.preventDefault(); //prevent the default browser behavior when clicking   
	var row_id =     $(this).attr('id');
	var parent =   $(this).parent().parent();
	//alert(row_id);
	$('#confirmation_dialog').dialog({ /*Initialising a confirmation dialog box (with  cancel/OK button)*/
					   
		autoOpen: false,
		width: 600,
		//position:[($(window).width() / 2) - (600 / 2), 200],
		buttons: {
			"Ok": function() { //If the user choose to click on "OK" Button
							   
				$(this).dialog('close'); // Close the Confirmation Box
							
				$.ajax({//make the Ajax Request
					type: 'get',
					url: '<? echo basename($_SERVER['PHP_SELF']);?>',
					data:'id=' + row_id,
					beforeSend: function() {
						parent.animate({'backgroundColor':'red'},100);
					},
					success: function(response) {//if the page ajax_delete.php returns the value "1"
		
						parent.fadeOut(500,function() {//remove the Table row .
							parent.remove();
						});
					
						modal_message();//Display the success message in the modal box
					}
				});
			}, 
			"Cancel": function() { //if the User Clicks the button "cancel"
				$(this).dialog('close');
			} 
		}
	});
	
	$('#confirmation_dialog').dialog('open');//Dispplay confirmation Dialogue when user clicks on "delete Image"          
		return false;
	}); // end a.delete
	
	$('a.view').click(function(e){ // if a user clicks on the "delete" image
	//e.preventDefault(); //prevent the default browser behavior when clicking   
	var view_id =     $(this).attr('id');
	
	//alert(row_id);
	$('#view_dialog').dialog({ /*Initialising a confirmation dialog box (with  cancel/OK button)*/
					   
		modal: true,
		autoOpen: false,
		width: 600,
		position: { my: 'top', at: 'top+50+'+getPageScroll()[1]+'' },
		
		open: function(event, ui){			
			$("#viewdets").load('view<?=$pagetype?>.php?id='+view_id);			
			$(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
		},
		buttons: {
			Close: function() {
				$(this).dialog('destroy');
						
			}// Close function
		}		
	});
	
	$('#view_dialog').dialog('open');//Dispplay confirmation Dialogue when user clicks on "delete Image"          
		return false;
	}); // end a.delete		
});// end document.ready
function getPageScroll() {
    var xScroll, yScroll;
    if (self.pageYOffset) {
      yScroll = pageYOffset;
      xScroll = pageXOffset;
    } else if (document.documentElement && document.documentElement.scrollTop) {     // Explorer 6 Strict
      yScroll = document.documentElement.scrollTop;
      xScroll = document.documentElement.scrollLeft;
    } else if (document.body) {// all other Explorers
      yScroll = document.body.scrollTop;
      xScroll = document.body.scrollLeft;    
    }    
    return new Array(xScroll,yScroll) 
}
</script>  
<script>
$(function () {
	$('#example1').DataTable();	
});
</script>
  </body>
</html>
