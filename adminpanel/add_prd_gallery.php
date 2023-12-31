<?php include "dbcon.php";
if($_SESSION['admins']['ID'] == ""){

	header("location:index.php");

}
$_GET['cid'] = base64_decode($_GET['cid']);
if($_POST['button'] != "" || $_POST['button'] != NULL){
	$chk=$general->insertProductGallery("prdimages_img");
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
            Add <?=$general->PageType($prdtype);?> Gallery
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="manage_products.php?type=<?=$prdtype?>">Manage <?=$general->PageType($prdtype);?></a></li>
            <li><a href="manage_<?=$pagetype?>.php?cid=<?=base64_encode($_GET['cid'])?>&type=<?=$prdtype?>">Manage <?=$general->PageType($prdtype);?> Gallery</a></li>
            <li class="active">Add <?=$general->PageType($prdtype);?> Image</li>
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
                      <br />
                      <div id="mulitplefileuploader" class="btn btn-primary"><label>Select Images</label></div>
                      </div>
                      <div class="col-xs-12">
                      <label>&nbsp;</label>
                      </div>
                      <div class="col-xs-12">
                      <div id="piclist" style="text-align:left;"></div>
                      </div>                                       
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" name="button" value="A d d" class="btn btn-primary">A d d</button>
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
    <? if($_REQUEST['type']=='category'){
		$url=	$conf->admin_url.'multiuploader/uploadcatgallery.php';
	}else{
		$url= $conf->admin_url.'multiuploader/uploadgallery.php';
	}
		
		
		?>
<link href="<?=$conf->admin_url?>multiuploader/css/uploadfilemulti.css" rel="stylesheet">
    
<script src="<?=$conf->admin_url?>multiuploader/js/jquery.fileuploadmulti.min.js"></script>
    
<script>
var allimgs="";
$(document).ready(function()
{
$('.my_mask').click(function(e) {
    $(this).hide();
});
var settings = {
	url: "<?=$url?>",
	method: "POST",
	allowedTypes:"jpg,png,gif,doc,pdf,zip",
	fileName: "myfile",
	multiple: true,
	onSuccess:function(files,data,xhr)
	{		
		$("#status").html("");
		$("#piclist").append("<div id='a_"+$.trim(data)+"'><span width='200'><img src='<?=$conf->site_url.$conf->gallery_dir?>"+$.trim(data)+"' width='100' height='100' /><br />"+$.trim(data)+"<div class='delit'><img src='multiuploader/upload-cancel.png'/></div></span><input type='hidden' name='modpics[]' value='"+$.trim(data)+"' /><input type='hidden' name='type' value='<?=$_REQUEST['type']?>' /><input type='text' class='form-control' name='caption[]' placeholder='Caption' /><br /><input type='text' name='alt[]' class='form-control' placeholder='Image Alt' /><br /><input type='text' name='title[]' class='form-control' placeholder='Image Title' /><br /><input type='text' class='form-control' name='order[]' placeholder='Order' /><br /></div>");	
		allimgs += $.trim(data)+",";
		$('.upload-statusbar').fadeOut('slow');
		$('.my_mask').fadeOut('slow');
		$("#submitbtn").fadeIn();	
		
	},
    afterUploadAll:function(data)
    {
		//alert("all images uploaded!!");
    },
	onError: function(files,status,errMsg)
	{		
		$("#status").html("<font color='red'>Upload is Failed</font>");
	}
}
$("#mulitplefileuploader").uploadFile(settings);

// delete image from folder on clicking delete
$("body").on("click",".delit", function(sds){
			//alert(sds);	
	var pic = $.trim($(this).parent(['span']).text());
		
	var obj = $(this).parent(['span']);
	
	$.post("multiuploader/delpics.php",{ pic: pic, path:'<?=$conf->absolute_path.$conf->gallery_dir?>' }, function(data) {
		if(data!=""){
			var b = $('div[id="a_'+pic+'"]');
			b.empty();
			//alert($.trim(data));
			//removing hidden input field
			obj.fadeOut("slow");
			obj.remove();
			
			$('input[value="'+$.trim(data)+'"]').remove();
					
//			$(this).parent(['span']).remove();
		}
	});
		
});

//deleting uploaded images on window closes without form submit
/*$(window).unload( function () { 
			
	if(allimgs!=""){
		//alert(allimgs);
		var list = allimgs.split(",");
		for(var i=0;i<list.length;i++){
			$.post("../multiuploader/delpics.php",{ pic: list[i] }, function(data) {});
		}
	}
	else{return false;}
});*/	

});// end document.ready
</script>
  </body>
</html>
