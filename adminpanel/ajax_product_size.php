<?php include "dbcon.php";
$size_id = $_POST['size_id'];
$data = $general->getAll("size_details where size_id = ".$size_id);

 ?>
<div class="col-sm-12">
     <div class="row" style="margin-top:4px">
            <div class="col-xs-1" style="text-align: right;">
                <strong>Size</strong>
            </div>
            <div class="col-xs-1">
                <strong>Quantity</strong>
            </div>
        </div>
    <?php
    if( is_array($data) && count($data) > 0 ){
        foreach( $data as $key => $val ){?>
        <div class="row" style="margin-top:4px">
            <div class="col-xs-1" style="text-align: right;">
                <?php echo $val['name']?>
            </div>
            <div class="col-xs-1">
                <input type="text" placeholder="Quantity" name="product_qty[<?=$val['id']?>]" size="4">
            </div>
        </div>
        <?php }
    } ?>
</div>