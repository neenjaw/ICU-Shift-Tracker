<?php
session_start();
require_once '../includes/dbconfig.php';

if (!isset($_SESSION['authenticated'])) {
  die("Unauthorized.");
}

if (isset($_POST['shift_id'])) {

<<<<<<< HEAD:ajax/ajax_get_shift_details.php
  echo json_encode($crud->getShiftEntryForDisplay(trim($_POST['shift_id'])));
=======
  if (isset($_POST['new'])) {
    echo json_encode($crud->getShiftEntryForDisplay(trim($_POST['shift_id'])));
  } else {
    echo json_encode($crud->getReadableShiftEntry(trim($_POST['shift_id'])));
  }
>>>>>>> 66aee82c40b3432151554a158a4156f67b803d4e:ajax/ajax_get_shift_details.php

} else {

  echo "Not ok.";

}

?>
