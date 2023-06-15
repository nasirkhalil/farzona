<?php  include "dbcon.php";
// echo "slug is".$general->slugify('abc xyz$bzy tt'); die;
error_reporting(E_ALL);
ini_set('display_errors', 1);
$chk_prd = "select * from product_prd";
$chk_prd=$general->CustomQuery($chk_prd);
for($i=0; $i<count($chk_prd); $i++){
    $slice = explode(" ", $chk_prd[$i]['shortdetails_prd']);
    $final_link = $slice[0]."/".$general->slugify($chk_prd[$i]['name_prd']);
    $chk_link = "select * from link_lk where links_lk='".$final_link."' and table_lk='product_prd'";
    $chk_link=$general->CustomQuery($chk_link);
    if(is_array($chk_link) && count($chk_link)>0){
        $cat_link =  $general->slugify($general->getSingleField("category_cat","id_cat",$chk_prd[$i]['idcat_prd'],"name_cat"))."/".$final_link;
         $upd = "Update link_lk SET links_lk='".$cat_link."' where id_lk=". $chk_link[0]['id_lk'];
        $general->CustomQuery($upd);
    
    }else{
     echo $ins_link = "insert into link_lk(links_lk,table_lk,idtab_lk) values('".$final_link."','product_prd','".$chk_prd[$i]['id_prd']."')"; 
     $general->CustomQuery($ins_link);
    }
}
die("<br>end");
if($_SESSION['admins']['ID'] == ""){

	header("location:index.php");

}

$_GET['cid'] = base64_decode($_GET['cid']);
?><?php
error_reporting(E_ALL ^ E_NOTICE);
extract($_REQUEST, EXTR_OVERWRITE);
// echo "<pre>"; print_r($general); die;


if($_POST['insert_rec'] == 'yes')
	{ 
		if($_FILES["file"]["name"] != "" or $_FILES["file"]["name"] != NULL)
		{  	
			$file=$_FILES["file"]['name'];
			$ext1 = strrchr($file,".");
			//$catalog_file= "catalog_file".time().$ext1;
			$catalog_file= "quantity".$ext1;
			//if($ext1 == '.xls' or $ext1 == '.xlsx' or $ext1 == '.csv')
			if($ext1 == '.xls' || $ext1 == '.XLS')
			{ //print_r($_FILES);
				@move_uploaded_file($_FILES["file"]["tmp_name"],"phpex/" .$catalog_file);
				///////////////////////////////////////file reading start/////////////////////////
				// die();
				// // including FileReader
				// include( 'csv/FileReader.php' );
				// // including CSVReader
				// include( 'csv/CSVReader.php' );
				die("test d  cfi");
				require_once 'phpex/Excel/reader.php';
				
				$data = new Spreadsheet_Excel_Reader();


				// Set output Encoding.
				$data->setOutputEncoding('CP1251');
				
				$data->read('phpex/'.$catalog_file);
				$cells = $data->sheets[0]['cells'];
				
				foreach ($cells as $key => $cell) {
					// if($key>8) break;
					// echo $cell[5]; continue;

					// echo $cell[5]; continue;
					if(($cell[1] !="" && $cell[1] > 0) && ($cell[20]!="" && $cell[20] >0)  && ($cell[21]!="" && $cell[21] >0) ){
						$size = explode(" ", $cell[2]);
						$size = explode("/", $size[0]);
						//width insertion start
						if( $size[0] != "" && $size[0] > 0  ){
							$width_last_id=$general->insSize(1,$size[0],0);
						}
						//width insertion end
						//hieght ins start
						if( $size[1] != "" && $size[1] > 0  ){
							$height_last_id=$general->insSize(2,$size[1],$width_last_id);
						}
						//hieght ins end
						//rim ins start
						if( $size[2] != "" && $size[2] > 0  ){
							$rim_last_id=$general->insSize(3,$size[2],$height_last_id);
						}
						//rim ins end
						//category insertion start
						// if( $cell[8] != "" ){
						// 	$chk_cate = "select * from category_cat where name_cat='".$cell[8]."'";
						// 	$chk_cate=$general->CustomQuery($chk_cate);
						// 	if(is_array($chk_cate) && count($chk_cate)>0){
						// 		$category_id = $chk_cate[0]['id_cat'];
						// 	}else{
						// 		$ins_cat = "insert into category_cat(cod_cat,name_cat) values('".$cell[7]."','".$cell[8]."')";
						// 		$general->CustomQuery($ins_cat);
						// 		$category_id = mysql_insert_id();
						// 	} 
						// }
						//category insertion end
						//product insertion start
						 $chk_prd = "select * from product_prd where itemcode_prd='".$cell[1]."'";
						 $chk_prd=$general->CustomQuery($chk_prd);
						 
						 if(is_array($chk_prd) && count($chk_prd)>0){
						 	// $category_id = $chk_cate[0]['id_cat'];
						 	
						    
						 }else{
						 	$prd_name = explode(" ",$cell[2]);
						 	$prd_name = $prd_name[2];
						 	$ins_cat = "insert into product_prd(id_width,id_height,id_rim,id_make,id_model,id_year,idcat_prd,name_prd,itemcode_prd,shortdetails_prd,origin_code,origin,category_code,category,pattern_code,pattern,spec_code,spec_desc,speed_code,speed,stock,cash,credit) values('".$width_last_id."','".$height_last_id."','".$rim_last_id."','','','','','".$prd_name."','".$cell[1]."','".$cell[2]."','".$cell[5]."','".$cell[6]."','".$cell[9]."','".$cell[10]."','".$cell[13]."','".$cell[14]."','".$cell[15]."','".$cell[16]."','".$cell[17]."','".$cell[18]."','".$cell[20]."','".$cell[21]."','".$cell[22]."')";
						 	$general->CustomQuery($ins_cat);
						 	// $category_id = mysql_insert_id();
						 } 
						//product insertion end
						}
						// print_r($size);
					}
					// echo "<pre>"; print_r($cell);
					// if($key>10) break;
					// echo $cell[20]."<br>";
				// }
				
				die("test end");
			
				
				$errorMessage="Data updated successfully.";		
				//@unlink("../catalog_files/".$catalog_file);
				//////////////////////////////////////file reading ends//////////////////////////
			}else{
				$errorMessage="This is not a valid file, please select only CSV file.";	
			}
			
		}else{
			$errorMessage="Please select the file";
		}
	}
?>
<!DOCTYPE html>
<html>
  <?php include "inc_head.php";
  $prdtype = $_GET['type']; ?>
  <body class="hold-transition skin-blue sidebar-mini">
  <div class="my_mask"></div>
    <div class="wrapper">

      <?php include "inc_header.php"; ?>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
      	<!-- sidebar: style can be found in sidebar.less -->
      	<?php include "inc_leftsidebar.php"; ?>
      	<!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add Files
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Add Files</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                <?php if(isset($_POST['button'])){
					if($chk){?> 
                	<!-- success alert -->
                    <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check"></i> <?=$general->msg?>
                  </div>
                	<!-- success alert ends -->  
                    <? }else{ ?>
                	<!-- not success alert -->
                    <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i> <?=$general->msg?>
                  </div>
                	<!-- Not success alert ends -->
                <? 	   }
				} ?>    
                </div><!-- /.box-header -->
                <!-- form start -->
                <form name="addform" method="post" action="" enctype="multipart/form-data">
                  <div class="box-body">
                    
                      <div class="col-xs-4">
                      
                      <label>Select Files</label>
                      <input type="file" name="file" size="40">
                      </div>
                      </div>
                      <div class="col-xs-12">
                      <label>&nbsp;</label>
                      </div>
                      <div class="col-xs-12">
                      
                      </div>                                       
                  </div><!-- /.box-body -->
 <input name="insert_rec" type="hidden" id="insert_rec" value="yes">
                  <div class="box-footer">
                    <button type="submit" name="Submit" value="A d d" class="btn btn-primary">A d d</button>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->            
          </div>   <!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php include "inc_footer.php"; ?>
    </div><!-- ./wrapper -->
    <?php include "inc_scripts.php"; ?>
  </body>
</html>
