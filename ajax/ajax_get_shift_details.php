<?php
session_start();
require_once '../includes/dbconfig.php';

if (!isset($_SESSION['authenticated'])) {
  die("Unauthorized.");
}

if (isset($_POST['shift_id'])) {

  if (isset($_POST['new'])) {
    echo json_encode($crud->getShiftEntryForDisplay(trim($_POST['shift_id'])));
  } else {
    echo json_encode($crud->getReadableShiftEntry(trim($_POST['shift_id'])));
  }

} else {

  echo "Not ok.";

}

?>
