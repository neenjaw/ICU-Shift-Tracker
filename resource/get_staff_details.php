<?php
session_start();
require_once '../includes/dbconfig.php';

if (!isset($_SESSION['authenticated'])) {
  die("Unauthorized.");
}

if (isset($_GET['staff-id'])) {

  $id = $_GET['staff-id'];
  $param = (object) array();
  $param->{'exclude-roles-from-assignment-count'} = array('Clinician', 'Charge', 'Outreach', 'Float', 'Clinician Prn');

  if (isset($_GET['num-of-shifts'])) $param->{'days'} = intval(trim($_GET['num-of-shifts']));
  if (isset($_GET['since-date'])) $param->{'since-date'} = trim($_GET['since-date']);

  echo json_encode($crud->getStaffDetails($id, $param), JSON_PRETTY_PRINT);

} else {
  echo "Problem.";
}

?>
