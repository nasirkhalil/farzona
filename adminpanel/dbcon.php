<?
ob_start();
session_start();
error_reporting(1);
ini_set('display_errors','On');
ini_set('error_reporting',E_ALL);
error_reporting(E_ALL);
include_once("../conn.php");
date_default_timezone_set('Asia/Karachi');
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
include_once($conf->absolute_path."classes/banner.php");

$user = new users();
$cms = new cms();
$banner = new banner();
$general= new general();
$product= new product();
$category= new category();
$order = new order();
?>