<?php
session_start();
require_once '../includes/dbconfig.php';

if (!isset($_SESSION['authenticated'])) {
  die("Unauthorized.");
}

try {
  if (isset($_POST['days']) && isset($_POST['offset']) && isset($_POST['category'])) {
    if (!is_numeric($_POST['days'])) { throw new Exception('Arg 1 not an integer'); }
    if (!is_numeric($_POST['offset'])) { throw new Exception('Arg 2 not an integer'); }

    if (isset($_POST['test'])) {
      echo json_encode($crud->getShiftTableObjectTest(intval($_POST['days']), intval($_POST['offset']), $_POST['category']));
    } else {
      echo json_encode($crud->getShiftTableObject(intval($_POST['days']), intval($_POST['offset']), $_POST['category']));
    }
  } else {
    throw new Exception('Wrong arguments.');
  }
} catch (PDOException $e) {
  echo $e;
}

?>
