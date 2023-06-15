<? 
#configuration directives
class config {
	var $absolute_path="C:/xampp741/htdocs/ferzona/";#include ending /
	var $site_url="http://localhost/ferzona/";#include ending /
	var $site_urlar="http://localhost/ferzona/ar/";#include ending /
	var $admin_url="http://localhost/ferzona/adminpanel/";#include ending /
	var $root_dir ="/ferzona/";
	var $db_name="ferzona";
	var $db_user="root";
	var $db_pass=""; 
	var $db_host="localhost";
	var $upload_size_allowed="1048576";//in bytes
	var $site_name="Architectural Corner";
	var $logo="logo.png";
	var $ar="0";
	
	var $general_dir="prod_images/general_images/";//spaw image director with ending slash
	var $category_dir="prod_images/category_images/";//spaw image director with ending slash
	var $product_dir="prod_images/product_images/";//spaw image director with ending slash
	var $banner_dir="prod_images/banner_images/";//spaw image director with ending slash
	var $gallery_dir="prod_images/gallery_images/";//spaw image director with ending slash
	var $files_dir="prod_images/files/";//spaw image director with ending slash
	
	var $clients_dir="prod_images/client_images/";
	
	var $blog_dir="prod_images/blog_images/";
	
	var $property_dir="files/properties/";
	
	var $thumbnailWidth=100;//width of the thumbnails generated for product images
	var $galleryThumbnailWidth=253;
	var $galleryThumbnailHeight=253;
	var $ConceptThumbWidth=316;
	var $ConceptThumbHeight=316;
	var $ProjectThumbWidth=215;
	var $ProjectThumbHeight=153;
	var $DivisionThumbWidth=422;
	var $DivisionThumbHeight=312;
	var $msg="";
	var $msg2="";
	
	/*var $smtphost="mail.vertilex.ae";
    var $smtpuser="medline@vertilex.ae";
    var $smtppass="!QAZXSW@#$";*/
    
}
?>