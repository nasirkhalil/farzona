<? include "../../dbcon-ajax.php";
// echo "<pre>"; print_r($_POST);
$cart_id  = $_POST['cart_id'];
$del_qry = "DELETE FROM cart_details WHERE id=".$cart_id;
$del_qry_status = $general->DeleteSingleRecord("cart_details","id",$cart_id,1,1);
if($del_qry_status){
	echo json_encode(array('status'=>true,'msg'=>"Record deleted successfully."));
}else{
	echo json_encode(array('status'=>false,'msg'=>"Error."));
}
?>