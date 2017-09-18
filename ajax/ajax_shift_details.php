<?php
session_start();
require_once '../includes/dbconfig.php';

if (isset($_SESSION['user_session']) && isset($_POST['shift_id'])) {

  //$crud->getShiftEntryAsHTML(trim($_POST['shift_id']));
  echo json_encode($crud->getReadableShiftEntry(trim($_POST['shift_id'])));

} else {

  echo "Not ok.";

}

?>
