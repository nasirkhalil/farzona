<?php include "dbcon.php"; 
if(isset($_POST['signin'])){
	$chk = $user->authenticate();
}

if($_GET['action'] == 'logout'){

	$user->Logout();

}?>
<!DOCTYPE html>
<html>
  <?php include "inc_head.php"; ?>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <img src="<?=$conf->site_url?>images/<?=$conf->logo?>" />
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg"><? if(isset($_POST['signin'])){ echo $user->msg; }else{ echo "All fields are required";}?></p>
        <form action="" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="user" class="form-control" placeholder="Username">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="pass" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <!--<label>
                  <input type="checkbox"> Remember Me
                </label>-->
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" name="signin" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

        <a href="forgot.php">I forgot my password</a><br>
       
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
	<?php include "inc_scripts.php"; ?>
<? if(isset($_POST['signin'])){?>    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
$( ".login-box-body" ).effect( "shake" );
    
</script>
<? } ?>        
  </body>
</html>
