<?php
session_start();
require_once '../includes/dbconfig.php';

if (!isset($_SESSION['authenticated'])) {
  die("Unauthorized.");
}

if (isset($_POST['staff-id']) && isset($_POST['num-of-days'])) {

  echo json_encode($crud->getStaffDetails($id, $days));

} else {

  echo "Problem.";
}

?>
