<?php
include("../dbcon.php");

@unlink($_REQUEST['path'].$_REQUEST['pic']);
@unlink($_REQUEST['path']."_".$_REQUEST['pic']);
echo $_REQUEST['pic'];


?>