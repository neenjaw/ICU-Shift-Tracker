<?php

function checkIfNumAndInt($num) {
  if (is_numeric($num)) {
    $num = get_numeric($num);
    if (is_int($num)) {
      return true;
    }
  }
  return false;
}

function get_numeric($val) {
  if (is_numeric($val)) {
    return $val + 0;
  }
  return 0;
}

$db_config = parse_ini_file('dbconfig.ini'); 

$DB_host = $db_config['host'];
$DB_user = $db_config['username'];
$DB_pass = $db_config['password'];
$DB_name = $db_config['dbname'];

$DB_tbl_users = 'shift_login_tbl_users';
$DB_tbl_auth_states = 'shift_login_tbl_user_auth';

$DB_table = (object) array();
$DB_table->users = $DB_tbl_users;
$DB_table->auth_states = $DB_tbl_auth_states;

try
{
 $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
 $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
 echo $e->getMessage();
}

if (isset($_SESSION['authenticated'])) {
    include_once 'classes/class.shift-crud.php';

    $crud = new ShiftCrud($DB_con);
}
?>
