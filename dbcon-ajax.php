<? // DBCON FOR AJAX PAGES
ob_start();
session_start();
date_default_timezone_set('UTC');
include_once("conn.php");

$conf = new config();

include_once($conf->absolute_path."classes/DBaccess.php");
include_once($conf->absolute_path."classes/user.php");
include_once($conf->absolute_path."functions/general.php");
include_once($conf->absolute_path."classes/pagging.php");
include_once($conf->absolute_path."classes/cms.php");
include_once($conf->absolute_path."classes/product.php");
include_once($conf->absolute_path."classes/category.php");
include_once($conf->absolute_path."classes/general.php");
include_once($conf->absolute_path."functions/resize-functions.php");
$general = new general();
?>