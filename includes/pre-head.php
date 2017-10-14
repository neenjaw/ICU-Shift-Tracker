<?php
session_start();

include_once 'includes/dbconfig.php';

require_once 'libraries/Mobile-Detect-2.8.25/Mobile_Detect.php';
$detect = new Mobile_Detect;

date_default_timezone_set('America/Edmonton');

if (isset($_SESSION['user_session'])) {
    $stmt = $DB_con->prepare("SELECT * FROM ".$DB_tbl_users." WHERE email=:uid");
    $stmt->execute(array(":uid"=>$_SESSION['user_session']));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
}

?>
