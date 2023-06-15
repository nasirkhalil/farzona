<?php include "dbcon.php";
  $data = $general->getAll("size_details where parent_id=".$_POST['parent_id']);
  $content = "";
  if(is_array($data)){
    foreach ($data as $key => $val) {
      // echo $val['value'];
      $content .= "<option value='".$val['id']."'>".$val['value']."</option>";
    }
  }
  echo  $content;
 ?>