<?php
session_start();
require_once '../includes/dbconfig.php';

if (!isset($_SESSION['authenticated'])) {
  die("Unauthorized.");
}

if (isset($_POST['shift_id'])) {
  try {
    if (!checkIfNumAndInt($_POST['shift_id'])) { throw new Exception("Shift id must be a numeric integer."); }

    $result = $crud->deleteShiftEntry($_POST['shift_id']);

    if (!$result->success) {
      throw new Exception("Reason unspecified.");
    } else {
      echo "ok - {$result->message}";
    }

  } catch (Exception $e) {
    echo "Unable to delete shift entry: {$e->getMessage()}";
  }
} else {

  echo "Improper arugments.";

}

?>
