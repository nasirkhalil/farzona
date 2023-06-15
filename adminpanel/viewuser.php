<? include "dbcon.php"; ?>
<?
if($_SESSION['admins']['ID'] == "")

{

	header("location:index.php");

}

$data = $general->getSingdet(" user_usr where id_usr= ".$_GET['id']);
?>
<meta charset="UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="Admin Style/Style.css" rel="stylesheet" type="text/css" />
<p>&nbsp;</p>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" >
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#999999">
    <tr>
      <td><table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#A59C72" class="border">
        
        <tr>
          <td colspan="3" align="center" valign="middle" class="TitleBackGroundColor"><strong class="pt10_wht_bold"> User Details</strong></td>
        </tr>
        
        <tr>
          <td colspan="5" align="center" valign="middle" bgcolor="#FFFFFF"><table width="26%" border="0" cellspacing="2" bgcolor="#444444">
            <tr>
              
          </table></td>
        </tr>
        <tr>
          <td colspan="5" align="center" valign="middle" bgcolor="#FFFFFF"><strong class="pt12_red"><?=$general->msg?></strong></td>
        </tr>
        
        <tr>
          <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF" class="tableheader">
            
            <table width="82%" >
              
              
				  
				
<tr>
 <td width="43%" height="28" align="center" valign="center"><strong>Name</strong></td>
 <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><?=$data[0]['first_name_usr']?></td> 
</tr>

  <tr>
    <td width="43%" height="28" align="center" valign="center" bgcolor="#FFFFFF"><strong>Email</strong></td>
    <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><?=$data[0]['email_usr']?></td>
  </tr>
  <tr>
    <td width="43%" height="28" align="center" valign="center" bgcolor="#FFFFFF"><strong>Country</strong></td>
    <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><?=$data[0]['country_usr']?></td>
  </tr>
  <? if($data[0]['city_usr']!=""){?>
  <tr>
    <td width="43%" height="28" align="center" valign="center" bgcolor="#FFFFFF"><strong>City</strong></td>
    <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><?=$data[0]['city_usr']?></td>
  </tr>
  <? }?>
  <? if($data[0]['address_usr']!=""){?>
  <tr>
    <td width="43%" height="28" align="center" valign="center" bgcolor="#FFFFFF"><strong>Address</strong></td>
    <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><?=$data[0]['address_usr']?></td>
  </tr>
    <? }?>
  <?php /*?><tr>
    <td width="43%" height="28" align="center" valign="center" bgcolor="#FFFFFF"><strong>Company</strong></td>
    <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><?=$data[0]['company_usr']?></td>
  </tr><?php */?>
  <tr>
    <td width="43%" height="28" align="center" valign="center" bgcolor="#FFFFFF"><strong>Contact No.</strong></td>
    <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><?=$data[0]['contact_usr']?></td>
  </tr>
  <tr>
    <td width="43%" height="28" align="center" valign="center" bgcolor="#FFFFFF"><strong>Status</strong></td>
    <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><? if($data[0]['status_usr']==1){ echo "Active"; }else{ echo "Inactive"; }  ?></td>
  </tr>
  <?php /*?><tr>
    <td width="43%" height="28" align="center" valign="center" bgcolor="#FFFFFF"><strong>Dirhams</strong></td>
    <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><?=$data[0]['dirhams_usr']?></td>
  </tr><?php */?>
  <tr>
    <td width="43%" height="28" align="center" valign="center" bgcolor="#FFFFFF"><strong>Points</strong></td>
    <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><?=$data[0]['point_usr']?></td>
  </tr>
  <tr>
    <td width="43%" height="28" align="center" valign="center" bgcolor="#FFFFFF"><strong>Gift Voucher</strong></td>
    <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><?=$data[0]['giftvoucher_usr']?></td>
  </tr>
   <tr>
    <td width="43%" height="28" align="center" valign="center" bgcolor="#FFFFFF"><strong>Registerarion Date and Time</strong></td>
    <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><?=$data[0]['dateregister_usr']?></td>
  </tr>
           
                    </table> 
          <span id="txtHint2" class="warnings"></span></td>
          </tr>
          
      </table></td>
    </tr>
    <tr>
    <td height="23" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
          <td colspan="4" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
  </table>
</form>
