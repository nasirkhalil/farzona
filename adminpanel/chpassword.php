<?php include "dbcon.php";
if($_SESSION['admins']['ID'] == ""){

	header("location:index.php");

}
if(isset($_POST['button'])){
	$chk = $user->updPass();
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
            Change Password
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Change Password</li>
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
                    <i class="icon fa fa-check"></i> <?=$user->msg?>
                  </div>
                	<!-- success alert ends -->  
                    <? }else{ ?>
                	<!-- not success alert -->
                    <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i> <?=$user->msg?>
                  </div>
                	<!-- Not success alert ends -->
                <? 	   }
				} ?>    
                </div><!-- /.box-header -->
                <!-- form start -->
                <form name="updform" method="post" action="" enctype="multipart/form-data" onSubmit="return validate();">
                  <div class="box-body">
                    
                      <div class="col-xs-12">
                      <label>Old Password</label>
                      <input type="password" class="form-control" name="op"  />
                      </div>
                    
                    
                      <div class="col-xs-12">
                      <label>New Password</label>
                      <input type="password" class="form-control" name="np"  />
                      </div>
                      
                      <div class="col-xs-12">
                      <label>Confirm Password</label>
                      <input type="password" class="form-control" name="cp"  />
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
<script type="text/javascript">
function validate()
{
	
		var op = document.updform.op.value;
		var np = document.updform.np.value;
		var cp = document.updform.cp.value;
		
		if (op == "")
		{
			alert ("Please Enter The Old Password");
			document.updform.op.focus();					
			return false;
		}
		if (np == "")
		{
			alert ("Please Enter New Password");
			document.updform.np.focus();					
			return false;
		}
		if (cp == "")
		{
			alert ("Please Enter The confirm Password");
			document.updform.cp.focus();					
			return false;
		}
		
		if (np != cp)
		{
			alert ("New Password & Confirm Password Must Be The Same");	
			document.updform.np.focus();					
			return false;
		}
}
</script>
    <?php include "inc_scripts.php"; ?>   
  </body>
</html>
