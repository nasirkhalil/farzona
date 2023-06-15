<? include "dbcon.php";
if(is_numeric($_GET['id'])){
	$details = $general->getSingdet(" order_ord where id_ord = ".$_GET['id']);?>
      <script src="<?=$conf->site_url?>js/print.js"></script>
<script type="text/javascript">
function printfunct()
{
//alert('#printdata');
$("#printorder").print();
}
</script> 
    <div class="box-body table-responsive"> 
                  
	<? if(is_array($details)){ ?>
    <div id="printorder">
		<table class="table table-bordered table-striped">
			
			<tbody>
				<tr class="try">
					<td>Tracking Number</td>
					<td><?=$details[0]['tracking_number_ord']?></td>
				</tr>

                <tr class="try">
					<td>Date</td>
					<td>
					<?=$details[0]['date_ord']?>
					</td>
				</tr>

                <tr class="try">
					<td>Name</td>
					<td>
					<?=$details[0]['name_ord']?>
					</td>
				</tr>
                
                <tr class="try">
					<td>Email</td>
					<td>
					<?=$details[0]['email_ord']?>
					</td>
				</tr>
               
                <tr class="try">
					<td>Contact Number</td>
					<td>
					<?=$details[0]['phone_ord']?>
					</td>
				</tr>
                <? if($details[0]['shipment_address_ord']!=""){?>
                <tr class="try">
					<td>Address</td>
					<td>
					<?=$details[0]['shipment_address_ord']?>
					</td>
				</tr>
                <? }?>
                 <? if($details[0]['city_ord']!=""){?>
                <tr class="try">
					<td>City</td>
					<td>
					<?=$details[0]['city_ord']?>
					</td>
				</tr>
                 <? }?>
                 <? if($details[0]['country_ord']!=""){?>
                <tr class="try">
					<td>Country</td>
					<td>
					<?=$details[0]['country_ord']?>
					</td>
				</tr>
                 <? }?>
               
               
                
<? $orddets = $general->getAll(" order_detail_orddet where idord_orddet = '".$details[0]['id_ord']."'");
if(is_array($orddets)){?>                
                <tr>
					<td colspan="2">
                      <table class="table table-bordered table-striped">
                        <tr class="detail">
						  <td colspan="7"><strong>Order Details</strong></td>					
						</tr>
                        <tr class="heading">
                          <!--<th>Image</th>-->
                          <th>Name</th>
                          <?php /*?><td>Color</td>
                          <td>Size</td><?php */?>
                          <th>Price</th>
                          <th>Quantity</th>
                          <th>Sub Total</th>
                        </tr>
                      <? for($d=0; $d<count($orddets); $d++){
						  $ordprd = $general->getSingdet(" product_prd where id_prd = ".$orddets[$d]['idprd_orddet']);
						  //$memprice=$general->getAll("prdmemory_pm where idprd_pm='".$ordprd[0]['id_prd']."' and idmz_pm='".$orddets[$d]['idmem_orddet']."' and idc_pm='".$orddets[$d]['idclr_orddet']."' order by idc_pm");
						   ?>
                        <tr class="order_further">
                          <?php /*?><td>
                         <img src="<?=$conf->site_url.$conf->product_dir.$img[0]['productimage_pc'];?>" alt="<?=$title?>" title="<?=$title?>" width="50px">
                           </td><?php */?>
                          <td><?=$orddets[$d]['name_orddet']?></td>
                         
                          <td>AED <?=number_format($orddets[$d]['price_orddet'])?> </td>
                          <td><?=$orddets[$d]['quantity_orddet']?></td>
                          <td>AED<?=number_format($orddets[$d]['totalprice_orddet']) ?> </td>
                        </tr>
                      <? $gtot+=$rowtot;
					  	 } ?>
                        <tr>
						  <td colspan="7" style="text-align:right;"><strong>Total: </strong>AED<?=number_format($details[0]['amount_ord'])?></td>					
						</tr>
                        <? $vat = (5/100*$details[0]['amount_ord']);?> 
                        <tr>
						  <td style="text-align:right;">VAT Tax (5 %):</td>	
                          <td style="text-align:right;">AED<?=number_format($vat)?> </td>	
                          <td colspan="4" style="text-align:right;"><strong>Grand Total: </strong>AED<?=number_format($details[0]['gross_ord'])?> </td>				
						</tr>
                      </table>
                    </td>					
				</tr>
<? } ?>
			</tbody>
		</table>
        </div>
	<? } ?>  
	</div>
    

       
<?	}?> 
<!--<a href="javascript:void(0);" onclick="printit();"><img src="<?=$conf->site_url?>images/print.png"/></a>-->
<?php /*?><input type="submit" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" name="" value="Print" onclick="printfunct();" /><?php */?>