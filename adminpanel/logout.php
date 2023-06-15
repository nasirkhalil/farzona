<?
session_start();

$_SESSION['admins']['ID'] = '';
$_SESSION['admins']['user'] = '';


session_destroy();

header("Location: index.php?do=logout");
exit();
?>