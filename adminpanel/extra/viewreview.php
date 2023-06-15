<? include "dbcon.php"; ?>
<?
if($_SESSION['admins']['ID'] == "")

{

	header("location:index.php");

}

$data = $general->getSingdet(" product_reviews where id= ".$_GET['id']);
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
          <td colspan="3" align="center" valign="middle" class="TitleBackGroundColor"><strong class="pt10_wht_bold"> Review Details</strong></td>
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
 <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><?=$data[0]['name']?></td> 
</tr>

  <tr>
    <td width="43%" height="28" align="center" valign="center" bgcolor="#FFFFFF"><strong>Email</strong></td>
    <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><?=$data[0]['email']?></td>
  </tr>
  <tr>
    <td width="43%" height="28" align="center" valign="center" bgcolor="#FFFFFF"><strong>Product</strong></td>
    <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><?=$general->getSingleField("product_prd","id_prd",$data[0]['id_prd'],"name_prd")?></td>
  </tr>
  
  <tr>
    <td width="43%" height="28" align="center" valign="center" bgcolor="#FFFFFF"><strong>Comments</strong></td>
    <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><?=$data[0]['comment']?></td>
  </tr>
  
  <tr>
    <td width="43%" height="28" align="center" valign="center" bgcolor="#FFFFFF"><strong>Date</strong></td>
    <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><?=$data[0]['datetime']?></td>
  </tr>
   
  <?php /*?><tr>
    <td width="43%" height="28" align="center" valign="center" bgcolor="#FFFFFF"><strong>Company</strong></td>
    <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><?=$data[0]['company_usr']?></td>
  </tr><?php */?>
  
  <tr>
    <td width="43%" height="28" align="center" valign="center" bgcolor="#FFFFFF"><strong>Status</strong></td>
    <td width="57%" height="28" align="left" valign="top" bgcolor="#FFFFFF" ><? if($data[0]['status']==1){ echo "Active"; }else{ echo "Inactive"; }  ?></td>
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
