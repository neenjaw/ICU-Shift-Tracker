<?php
session_start();
require_once '../includes/dbconfig.php';

if (isset($_SESSION['user_session']) && isset($_POST['shift_id'])) {

  $crud->printShiftEntry(trim($_POST['shift_id']));

} else {

  echo "Not ok.";
  
}

?>
