<? include "dbcon.php";
if(is_numeric($_GET['id'])){
	$details = $general->getSingdet(" content_cms where id_cms = ".$_GET['id']);?>
    <div class="box-body table-responsive">                
	<? if(is_array($details)){ ?>
		<table class="table table-bordered table-striped">
			
			<tbody>
				<tr>
					<td style="text-align:center !important;">Name</td>
					<td>
					<?=$details[0]['name_cms']?>
					</td>
				</tr>
                <? if($details[0]['label_cms']!=""){?>
                <tr>
					<td style="text-align:center !important;">Heading</td>
					<td>
					<?=$details[0]['label_cms']?>
					</td>
				</tr>
                <? } ?>
                <? if($details[0]['metatitle_cms']!=""){?>
                <tr>
					<td style="text-align:center !important;">Meta Title</td>
					<td>
					<?=$details[0]['metatitle_cms']?>
					</td>
				</tr>
                <? } ?>
                <? if($details[0]['metatag_cms']!=""){?>
                <tr>
					<td style="text-align:center !important;">Meta Keywords</td>
					<td>
					<?=$details[0]['metatag_cms']?>
					</td>
				</tr>
                <? } ?>
                <? if($details[0]['metadescription_cms']!=""){?>
                <tr>
					<td style="text-align:center !important;">Meta Description</td>
					<td>
					<?=$details[0]['metadescription_cms']?>
					</td>
				</tr>
                <? } ?>
                <? if($details[0]['short_details_cms']!=""){?>
                <tr>
					<td style="text-align:center !important;">Short Description</td>
					<td>
					<?=$details[0]['short_details_cms']?>
					</td>
				</tr>
                <? } ?>
                <? if($details[0]['details_cms']!=""){?>
                <tr>
					<td style="text-align:center !important;">Details</td>
					<td>
					<?=$details[0]['details_cms']?>
					</td>
				</tr>
                <? } ?>
                <? if($details[0]['image_name_cms']!=""){?>
                <tr>
					<td style="text-align:center !important;">Image</td>
					<td>
                    <img src="<?=$conf->site_url.$conf->general_dir.$details[0]['image_name_cms']?>" width="50%" />					
					</td>
				</tr>
                <? } ?>
                <? if($details[0]['image_alt_cms']!=""){?>
                <tr>
					<td style="text-align:center !important;">Image Alt</td>
					<td>
					<?=$details[0]['image_alt_cms']?>
					</td>
				</tr>
                <? } ?>
                <? if($details[0]['image_title_cms']!=""){?>
                <tr>
					<td style="text-align:center !important;">Image Title</td>
					<td>
					<?=$details[0]['image_title_cms']?>
					</td>
				</tr>
                <? } ?>
			</tbody>
		</table>
	<? } ?>  
	</div>
<?	
}