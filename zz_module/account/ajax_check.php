<? include "../../dbcon-ajax.php";
//check mobile exist
if( isset($_POST['check_mobile']) && $_POST['check_mobile'] == 1 ){
  // echo "<pre>"; print_r($_POST);
  $data = $general->GetSingleField("customers","mobile",$_POST['mobile_no'],"id");
  if( $data > 0 ){
    echo "Mobile Number Already exist.";
  }
}
//check email exist
if( isset($_POST['check_email']) && $_POST['check_email'] == 1 ){
  echo "<pre>"; print_r($_POST);

}  
?>