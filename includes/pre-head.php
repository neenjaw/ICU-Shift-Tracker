<?php
session_start();

include_once 'includes/dbconfig.php';

require_once 'vendor/Mobile-Detect-2.8.25/Mobile_Detect.php';
$detect = new Mobile_Detect;

date_default_timezone_set('America/Edmonton');

// if (isset($_SESSION['user'])) {
//     $stmt = $DB_con->prepare("SELECT * FROM {$DB_table->users} WHERE login=:log");
//     $stmt->bindparam(":log", $_SESSION['user']);
//     $stmt->execute();
//     $row=$stmt->fetch(PDO::FETCH_ASSOC);
// }

?>
