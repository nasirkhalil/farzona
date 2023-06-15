<? include "dbcon.php";
if(is_numeric($_GET['id'])){
	$details = $general->getSingdet(" enquiry_enq where id_enq = ".$_GET['id']);?>
    <div class="box-body table-responsive">                
	<? if(is_array($details)){ ?>
		<table class="table table-bordered table-striped">
			
			<tbody>
				<tr>
					<td style="text-align:center !important;">Name</td>
					<td>
					<?=$details[0]['firstname_enq']?>
					</td>
				</tr>
                <? if($details[0]['idprd_enq']!=""){ ?>
                <tr>
					<td style="text-align:center !important;">Product Name</td>
					<td>
					<?=$general->GetSingleField("product_prd","id_prd",$details[0]['idprd_enq'],"name_prd");?>
					</td>
				</tr>
                <? } ?>
                <tr>
					<td style="text-align:center !important;">Email</td>
					<td>
					<?=$details[0]['email_enq']?>
					</td>
				</tr>
               <? if($details[0]['contact_enq']!=""){?>
                <tr>
					<td style="text-align:center !important;">Contact</td>
					<td>
					<?=$details[0]['contact_enq']?>
					</td>
				</tr>
                <? }?>
                <? if($details[0]['subject_enq']!=""){?>
                <tr>
					<td style="text-align:center !important;">Subject</td>
					<td>
					<?=$details[0]['subject_enq']?>
					</td>
				</tr>
                <? }?>
                <tr>
					<td style="text-align:center !important;">Message</td>
					<td>
					<?=$details[0]['details_enq']?>
					</td>
				</tr>
                <tr>
					<td style="text-align:center !important;">Date</td>
					<td>
					<?=$details[0]['date_enq']?>
					</td>
				</tr>
			</tbody>
		</table>
	<? } ?>  
	</div>
<?	
}