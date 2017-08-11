<?php

$DB_host = 'localhost';
$DB_user = '';
$DB_pass = '';
$DB_name = '';

$DB_tbl_users = 'logindemo01_tbl_users';

try
{
 $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
 $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
 echo $e->getMessage();
}

if (isset($_SESSION['user_session'])) {
    include_once 'classes/class.crud.php';

    $crud = new crud($DB_con);
}
?>
