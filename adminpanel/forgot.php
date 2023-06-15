<?php include "dbcon.php";
if(isset($_POST['Submit']))
{
$pass = $general->genpassword(6);
		
		$security="select * from admin_adm where username_adm='".$_POST['name']."'";
		 $dataa = $general->CustomQuery($security);
		 if($dataa!=''){
	     $ss  = $dataa[0]["admin_salt_adm"];

		$query = "UPDATE admin_adm set password_adm='".$user->hashthepass($pass, $ss)."' where username_adm='".$_POST['name']."'"; 
		$change=$general->CustomModify($query);
 	// Email Section
	$admdetails=$general->getSingdet("setting_set ");
	$multiadmins = explode(",",$admdetails[0]['emailto_set']);
	
	$message = $admdetails[0]['email_header_set']."
		<table width='500' border='0' align='center'>
					<tr>
					  <td colspan='2'>&nbsp;</td>
				   </tr>
				<tr>
				  <td colspan='2'><strong>Hi ".$_POST['name']."!!</strong></td>
				</tr>
				<tr>
				  <td colspan='2'>Your new password is. </td>
				 </tr>
				 <tr>
				  <td colspan='2'>".$pass." </td>
				 </tr>
			  </table>".$admdetails[0]['email_footer_set'];
			
			$to = $admdetails[0]['emailto_set'];
			
			$subject=$conf->site_name." - Admin Forgot Password ";
			//echo "<br>to:::".$to."<br>Subject:::". $subject."<br>message:::". $message."<br>headers:::". $headers;
			for($i=0; $i<count($multiadmins); $i++){

				$to = trim($multiadmins[$i]);
	
				if($to!=""){
					$general->sendMail($admdetails[0]['namefrom_set'],$admdetails[0]['emailfrom_set'],$to,$subject,$message,'',0);
				}
			}
			$successmsg = "Password recovered successfully, Your new password has been mailed to ".$to."";
		 } 
		 else {
			 $admdetails=$general->getSingdet("setting_set ");
			 $errormsg="An email has been sent to ".$to = $admdetails[0]['emailto_set']." with further information. If you do not receive an email then please confirm you have entered correct user name.";
			 }
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
        <p class="login-box-msg">
        <? if(!isset($_POST['Submit'])){ ?><strong>Please enter your username below.</strong><? } ?>
        <font color="#FF0000"><? echo $errormsg;?></font></p>
        <? if($successmsg==""){ ?>
        <form action="" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="name" class="form-control" placeholder="Username" required/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
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
              <button type="submit" name="Submit" class="btn btn-primary btn-block btn-flat">Proceed</button>
            </div><!-- /.col -->
          </div>
        </form>
		<? }else{ ?>
				<font color="#FF0000"><? echo $successmsg;?></font>
        <? } ?>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
	<?php include "inc_scripts.php"; ?>    
  </body>
</html>
