<?php
session_start();
require_once '../includes/dbconfig.php';

if (!isset($_SESSION['authenticated'])) {
  die("Unauthorized.");
}

// shift-id=460&role_id=2

try {
  if (!isset($_POST['shift-id'])) {
    throw new Exception("Shift ID undefined.");
  } elseif (count($_POST) < 2) {
    throw new Exception("Field undefined.");
  } else {
    $shift_id = $_POST['shift-id'];
    array_shift($_POST);

    if (!$crud->updateShiftEntry($shift_id, $_POST)) {
      throw new Exception("Error updating entry.");
    } else {
      echo "Ok. Shift Updated.";
    }
  }
} catch (Exception $e) {
  echo "Problem: {$e->getMessage()}";
}
?>
