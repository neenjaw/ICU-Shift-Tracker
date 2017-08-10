<?php
session_start();

include_once 'includes/dbconfig.php';

if (isset($_SESSION['user_session'])) {
    $stmt = $DB_con->prepare("SELECT * FROM ".$DB_tbl_users." WHERE email=:uid");
    $stmt->execute(array(":uid"=>$_SESSION['user_session']));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
}

?>
