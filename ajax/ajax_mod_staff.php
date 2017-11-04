<?php
session_start();
require_once '../includes/dbconfig.php';

if (!isset($_SESSION['authenticated'])) {
  die("Unauthorized.");
}


// staff-id=1&
// modstaff-chk=name&
// first-name=joe&
// last-name=smith&
// modstaff-chk=category&
// staff-category=1&
// modstaff-chk=active&
// staff-active=1
//
// array(6) {
//   ["staff-id"]=> string(1) "1"
//   ["modstaff-chk"]=> array(3) {
//     [0]=> string(4) "name"
//     [1]=> string(8) "category"
//     [2]=> string(6) "active"
//   }
//   ["first-name"]=> string(3) "joe"
//   ["last-name"]=> string(5) "smith"
//   ["staff-category"]=> string(1) "1"
//   ["staff-active"]=> string(1) "1"
// }

$field_name = array();
$update_value = array();

var_dump($_POST);

?>
