<?php include "dbcon.php";
$size_id = $_POST['size_id'];
$data = $general->getAll("size_details where size_id = ".$size_id);

 ?>
<div class="col-sm-12">
    <label>Below Sizes will Attach to this product.</label><br>
    <?php
    if( is_array($data) && count($data) > 0 ){
        foreach( $data as $key => $val ){?>
        <div class="col-xs-1">
            <?php echo $val['name']?>
        </div>
        <?php }
    } ?>
</div>