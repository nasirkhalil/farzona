<? include "../../dbcon-ajax.php";
// echo "<pre>"; print_r($_POST);
$session_id       = session_id();
$product_id       = $_POST['product_id'];
$product_size_id  = $_POST['product_size_id'];
$product_quantity = $_POST['product_quantity'];
//first check cart main entry
$cart_data = $general->getAll("carts WHERE session_id = '$session_id'"); 
if( is_array($cart_data) && count($cart_data) > 0 ){
   $cart_id = $cart_data[0]['id']; 
}else{
	$cart_id = $general->InsertRecord('carts','session_id,customer_id',"'$session_id',22");
}
// echo "<pre>"; print_r($cart_data); die;
//product entry in cart
$cart_product_qry  = " cart_details WHERE cart_id = $cart_id AND product_id = $product_id AND size_id = $product_size_id";
$cart_product_data = $general->getAll($cart_product_qry);
// die('test dfssdf');
if( is_array($cart_product_data) && count($cart_product_data) > 0 ){
	die("testing..");
}else{
	$product_data = $general->CustomQuery("SELECT color_id,sku,name_prd,thumb_name_prd,price_prd,sale_price,
																				 (SELECT name FROM colors WHERE id = product_prd.color_id ) AS product_color,
																				 (SELECT name FROM size_details WHERE id = $product_size_id) AS product_size
																			 FROM product_prd WHERE id_prd =".$product_id);
	$product_data = $product_data[0];
	// echo "<pre>"; print_r($product_data); die;
	if( $product_data['sale_price'] > 0 ){
		$price = $product_data['sale_price'];
	}else{
		$price = $product_data['price_prd'];
	}
	//echo "<pre>"; print_r($product_data);
	$cart_product_insert        = "cart_id, product_id, size_id, color_id, product_sku, product_name,product_image,product_color, product_size, product_quantity, product_price";
	$cart_product_insert_values = "$cart_id,$product_id,$product_size_id,".$product_data['color_id'].",'".$product_data['sku']."','".$product_data['name_prd']."','".$product_data['thumb_name_prd']."','".$product_data['product_color']."','".$product_data['product_size']."','$product_quantity','".$price."'";
	$general->InsertRecord('cart_details',$cart_product_insert,$cart_product_insert_values);
}

?>