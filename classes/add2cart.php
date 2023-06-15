<? include "dbcon-ajax.php";?>
<? 
//echo $_POST['quantity'];
$id = $_POST['prid'];
//echo " product_prd where id_prd = ".mysql_real_escape_string($id); die();
	$packg = $general->getSingdet(" product_prd where id_prd = ".mysqli_real_escape_string($general->DBlink,$id));
		
   		//$_POST['qty']=1;
		if($_SESSION['users']['ID']==""){
			$user="";
		}else{
			$user=$_SESSION['users']['ID'];
		}
		
		$tot=$packg[0]['cash'] * $_POST['quantity']; //die();
		$price=$packg[0]['cash'];
		
		
$q="insert into order_temp_ordtem (idprd_ordtem, name_ordtem,price_ordtem, quantity_ordtem, total_ordtem, session_id_ordtem, idusr_ordtem,date_ordtem) values('".mysqli_real_escape_string($general->DBlink,$id)."','".$packg[0]['name_prd']."','".$price."','".mysqli_real_escape_string($general->DBlink,$_POST['quantity'])."','".$tot."','".session_id()."','".$user."','".date("Y-m-d")."')";//die();
		
		
  //echo "order_temp_ordtem where idprd_ordtem='".mysqli_real_escape_string($general->DBlink,$id)."' and session_id_ordtem='".session_id()."'";  		
//echo "order_temp_ordtem where idprd_ordtem='".mysqli_real_escape_string($general->DBlink,$id)."' and session_id_ordtem='".session_id()."'"; 
		   $prev=$general->getSingdet("order_temp_ordtem where idprd_ordtem='".mysqli_real_escape_string($general->DBlink,$id)."' and session_id_ordtem='".session_id()."'");
   if(is_array($prev)){
	   //echo "ssaa"; 
	  

	 //  die();
	  $qry = "update order_temp_ordtem set quantity_ordtem = '".mysqli_real_escape_string($general->DBlink,$_POST['quantity'])."', total_ordtem='".$tot."' where idprd_ordtem='".mysqli_real_escape_string($general->DBlink,$id)."' and session_id_ordtem = '".session_id()."'";
	 // echo "<br>";
	   //echo "order_temp_ordtem where idprd_ordtem='".mysqli_real_escape_string($general->DBlink,$id)."' and session_id_ordtem='".session_id()."'"; die();
      // echo "order_temp_ordtem where idprd_ordtem='".mysql_real_escape_string($id)."' and session_id_ordtem='".session_id()."'";
   $chk=$general->CustomModify($qry);
   header('location:'.$conf->site_url.'cart'.$_SESSION['URL']);
   		//header('location:'.$_SERVER['HTTP_REFERER'].'');
   }else{
      //die("sdsd");
	  //die($_POST['quantity']);
	   if($_POST['quantity']!='')
	  $chk=$general->CustomModify($q);
	   
	   header('location:'.$conf->site_url.'cart'.$_SESSION['URL']);
	  # exit();
  	   }

//else
// header("location:".$_SERVER['HTTP_REFERER']."");
?>
