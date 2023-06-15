<?php include "dbcon.php"; ?>
<?php 
if($_SESSION['admins']['ID'] == ""){
	header("location:index.php");
}?>
<!DOCTYPE html>
<html>
  <?php include "inc_head.php"; ?>
  <body class="hold-transition skin-blue sidebar-mini">
  	<!--DIALOG BOXES-->    
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
            Dashboard
            <small>Administration Panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">
          <? $cmsdashboard = $general->getAll(" content_cms where origin_cms = 'menu' and parent_cms = 0 order by name_cms "); ?>            
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><? if(is_array($cmsdashboard)){ echo count($cmsdashboard);}else{ echo 0;}?></h3>
                  <p>Content Pages</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="manage_cms.php" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
<? $enqdashboard = $general->getAll(" enquiry_enq where origin_enq = 'contact' order by id_enq desc "); ?>            
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><? if(is_array($enqdashboard)){ echo count($enqdashboard);}else{ echo 0;}?></h3>
                  <p>Enquiries</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="manage_contact.php" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
<? $testimdashboard = $general->getAll(" product_prd where type_prd = 'concept' "); ?>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><? if(is_array($testimdashboard)){ echo count($testimdashboard);}else{ echo 0;}?></h3>
                  <p>Concepts</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="manage_products.php?type=concept" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
<? $cltdashboard = $general->getAll(" client_clt "); ?>            
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><? if(is_array($cltdashboard)){ echo count($cltdashboard);}else{ echo 0;}?></h3>
                  <p>Clients</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="manage_clients.php" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div><!-- /.row -->
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-6 connectedSortable">
<? $cmsdashboard = $general->getAll(" content_cms where origin_cms = 'menu' and parent_cms = 0 order by name_cms limit 10 "); ?>            
              <? if(is_array($cmsdashboard)){ ?>
              <!-- TABLE: CONTENT PAGES -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Content Pages</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody>
                      <? for($c=0; $c<count($cmsdashboard); $c++){ ?>
                        <tr>
                          <td><?=$cmsdashboard[$c]['name_cms']?></td>
                          <td><a href="#" class="viewcms" id="<?php echo $cmsdashboard[$c]['id_cms']?>" ><img src="dist/img/icons/view.png" alt="Edit" /></a></td>                          
                        </tr>
                      <? } ?>  
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">                  
                  <a href="manage_cms.php" class="btn btn-sm btn-default btn-flat pull-right">View All Pages</a>
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
			<? } ?>

            </section><!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-6 connectedSortable">
<? $enqdashboard = $general->getAll(" enquiry_enq where origin_enq = 'contact' order by id_enq desc limit 10 "); ?>            
            <? if(is_array($enqdashboard)){ ?>
              <!-- TABLE: LATEST ENQUIRIES -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Latest Enquiries</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Date</th>
                          <th>&nbsp;</th>                          
                        </tr>
                      </thead>
                      <tbody>
                      <? for($e=0; $e<count($enqdashboard); $e++){ ?>
                        <tr>
                          <td><?=$enqdashboard[$e]['firstname_enq']?></td>
                          <td><?=$enqdashboard[$e]['date_enq']?></td>
                          <td><a href="#" class="viewenq" id="<?php echo $enqdashboard[$e]['id_enq']?>" ><img src="dist/img/icons/view.png" alt="Edit" /></a></td>                          
                        </tr>
                      <? } ?>  
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">                  
                  <a href="manage_contact.php" class="btn btn-sm btn-default btn-flat pull-right">View All Enquiries</a>
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
              <? } ?>            
            </section><!-- right col -->
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php include "inc_footer.php"; ?>
    </div><!-- ./wrapper -->
    <?php include "inc_scripts.php"; ?> 
<link rel="stylesheet" type="text/css" href="dist/css/jquery-ui.css"/>
<script src="dist/js/jquery-ui.js"></script> 
<script language="javascript">
$(function () {
    
	$("#view_dialog").hide();
     
	/*Hiding the div with ID dialog-message and #confirmation_dialog These 2 divs are responsible for the modal boxes .*/
   
	
	$('a.viewcms').click(function(e){ // if a user clicks on the "delete" image
	//e.preventDefault(); //prevent the default browser behavior when clicking   
	var view_id =     $(this).attr('id');
	
	//alert(row_id);
	$('#view_dialog').dialog({ /*Initialising a confirmation dialog box (with  cancel/OK button)*/
					   
		modal: true,
		autoOpen: false,
		width: 600,
		position: { my: 'top', at: 'top+50+'+getPageScroll()[1]+'' },
		
		open: function(event, ui){			
			$("#viewdets").load('viewcms.php?id='+view_id);			
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
	}); // end a.viewcms
	
	$('a.viewenq').click(function(e){ // if a user clicks on the "delete" image
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
	}); // end a.viewenq
			
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
</script>       
  </body>
</html>
