<?
ob_start();
session_start();
error_reporting();
include_once("../conn.php");

$conf = new config();

include_once($conf->absolute_path."classes/DBaccess.php");
include_once($conf->absolute_path."classes/user.php");
include_once($conf->absolute_path."classes/general.php");
include_once($conf->absolute_path."classes/order.php");
include_once($conf->absolute_path."functions/general.php");
include_once($conf->absolute_path."functions/resize-functions.php");
include_once($conf->absolute_path."classes/product.php");
include_once($conf->absolute_path."classes/category.php");
include_once($conf->absolute_path."classes/pagging.php");
include_once($conf->absolute_path."classes/cms.php");

$user = new users();
$cms = new cms();
$general= new general();
$product= new product();
$category= new category();
$order = new order();
if($_SESSION['urltype']==""){
	$general->setURLtype();
}
?>
