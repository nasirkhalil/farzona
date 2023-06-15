<? include "dbcon.php";
if(is_numeric($_GET['id'])){
	$details = $general->getSingdet(" ccity_cty where id_cty = ".$_GET['id']);?>
    <div class="box-body table-responsive">                
	<? if(is_array($details)){ ?>
		<table class="table table-bordered table-striped">
			<tbody>
				<tr>
					<td style="text-align:center !important;">Emirate Name</td>
					<td>
					<?=$details[0]['name_cty']?>
					</td>
				</tr>
                <tr>
					<td style="text-align:center !important;">Status</td>
					<td>
					<? if($details[0]['status_cty']==1){
						echo "Active";
					}else{
						echo "Inactive";
					}?>
					</td>
				</tr>
                <tr>
					<td style="text-align:center !important;">Order</td>
					<td>
					<?=$details[0]['order_cty']?>
					</td>
				</tr>
			</tbody>
		</table>
	<? } ?>  
	</div>
<?	
}