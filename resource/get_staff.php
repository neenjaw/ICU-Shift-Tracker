<?php
session_start();
require_once '../includes/dbconfig.php';

if (!isset($_SESSION['authenticated'])) {
  die("Unauthorized.");
}

if (isset($_POST['date'])) {

  echo json_encode($crud->getStaffFilteredByDate(trim($_POST['date'])));

} elseif (isset($_POST['uid'])) {

  echo json_encode($crud->getStaffObj(trim($_POST['uid'])));

} elseif (isset($_POST['category'])) {

  echo json_encode($crud->getAllCategoryObj());

} elseif (isset($_GET['group-by-category'])) {

  echo json_encode($crud->getStaffGroupedByCategory(), JSON_PRETTY_PRINT);

} elseif (isset($_GET['date'])) {

  $data = (object) array();

  $staff = $crud->getStaffGroupedByCategory(trim($_GET['date']));
  $data->staff = $staff->group;

  $assignment = $crud->getAllAssignmentObj();
  $data->assignment = $assignment;

  $role = $crud->getAllRoleObj();
  $data->role = $role;

  echo json_encode($data);

} else {

  echo json_encode($crud->getAllStaffObj());

}

?>
