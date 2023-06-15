<?
//echo $_SERVER['DOCUMENT_ROOT']; die();
ob_start();

session_start();
date_default_timezone_set('Asia/Dubai');
 //error_reporting(E_ALL);
//ini_set("display_errors", 1);
include_once("conn.php");

$conf = new config();

include_once($conf->absolute_path."classes/DBaccess.php");
include_once($conf->absolute_path."classes/user.php");
include_once($conf->absolute_path."functions/general.php");
include_once($conf->absolute_path."functions/resize-functions.php");
include_once($conf->absolute_path."classes/pagging.php");
include_once($conf->absolute_path."classes/cms.php");
include_once($conf->absolute_path."classes/product.php");
include_once($conf->absolute_path."classes/category.php");
include_once($conf->absolute_path."classes/general.php");
include_once($conf->absolute_path."classes/simpleurl.php");

$url = new SimpleUrl();
$general = new general();
$user = new users();
$cms = new cms();
$product = new product();
$category = new category();
$_SESSION['curr']="AED";
//$chkip = $general->checkIP();
if($chkip){
	include("restricted.php");
	die();
}
if($_SESSION['urltype']==""){
	$general->setURLtype();	
}
$page = $url->returnURL($conf->root_dir);  // function returnURL() in simpleurl class


 $general->checkCanonical($page);
 
$general->checkURL($page);
//echo $page; die();
//print_r($_SESSION);
header('Cache-Control: no cache'); //no cache
?>