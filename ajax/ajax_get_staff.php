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

} else {

  echo json_encode($crud->getAllStaffObj());

}

?>
