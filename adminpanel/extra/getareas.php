<? include "dbcon-ajax.php";
$id=$_POST['id'];

$famls=$general->getAll("ccity_cty where parent_cty = ".$id." and status_cty='1' order by order_cty" );

if($famls!=''){
	
		for($i=0; $i<count($famls); $i++)
		{
			echo "".$famls[$i]['id_cty'].", ".$famls[$i]['name_cty']."/";	
		}
} else {
	echo "0,"."No data found"."/";
}

?>
