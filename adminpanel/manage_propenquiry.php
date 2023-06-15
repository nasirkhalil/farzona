<?php include "dbcon.php"; ?>
<?php 
if($_SESSION['admins']['ID'] == ""){
	header("location:index.php");
}
if(isset($_GET['id'])){
	$general->delGenDetails("enquiry_enq","id_enq","","");
}

$optbyid=$general->getAll(" enquiry_enq where origin_enq = 'enq' order by id_enq desc ");
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
            Manage Properties Enquiries
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=$conf->site_url?>adminpanel/dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Manage Properties Enquiries</li>
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
                <div class="box-body">
                <? if(is_array($optbyid)){ ?>
                  <form name="manageform" method="post" action="">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>                        
                        <th>Name</th>
                        <th>Property Ref #</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Date</th>
                        <th>Actions</th>                        
                      </tr>
                    </thead>
                    <tbody>
                    <? for($d=0; $d<count($optbyid); $d++){?>
                    	<tr>                        	
                            <td><?=$optbyid[$d]['firstname_enq']?></td>
                            <td><?=$optbyid[$d]['idprd_enq']?></td>
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
<script src="dist/js/jquery-ui.js"></script> 
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
					url: 'manage_enquiry.php',
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
			$("#viewdets").load('viewcontact.php?id='+view_id);			
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
	$('#example1').DataTable({"ordering": false});	
});
</script>
  </body>
</html>
