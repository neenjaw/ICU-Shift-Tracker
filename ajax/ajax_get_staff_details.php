<?php
session_start();
require_once '../includes/dbconfig.php';

if (!isset($_SESSION['authenticated'])) {
  die("Unauthorized.");
}

if (isset($_GET['staff-id']) && isset($_GET['num-of-days'])) {

  $id = intval(trim($_GET['staff-id']));
  $days = intval(trim($_GET['num-of-days']));

  echo json_encode($crud->getStaffDetails($id, $days), JSON_PRETTY_PRINT);

} else {
  echo "Problem.";
}

?>
