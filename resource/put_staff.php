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
if (isset($_POST['cmd-submit']) && isset($_POST['cmd-delstaff'])) {
  if (isset($_POST['staff-id'])) {
    $sid = trim($_POST['staff-id']);

    if ($crud->deleteStaff($sid)) {
      echo "Ok. Deleted.";
    } else {
      echo "Problem. Unable to Delete Staff.";
    }
  } else {
    echo "Problem.  Staff unspecified for delete.";
  }
} elseif (isset($_POST['modstaff-chk'])) {
  if (isset($_POST['first-name'])) {
    $first_name = trim($_POST['first-name']);
  } else {
    $first_name = null;
  }

  if (isset($_POST['last-name'])) {
    $last_name = trim($_POST['last-name']);
  } else {
    $last_name = null;
  }

  if (isset($_POST['staff-category'])) {
    $category_id = trim($_POST['staff-category']);
  } else {
    $category_id = null;
  }

  if (isset($_POST['staff-active'])) {
    $active = trim($_POST['staff-active']);
  } else {
    $active = null;
  }

  if ($crud->updateStaff($_POST['staff-id'], $first_name, $last_name, $category_id, $active)) {
    echo "Ok. Updated.";
  } else {
    echo "Problem.";
  }
}
?>
