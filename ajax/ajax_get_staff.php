<?php
session_start();
require_once '../includes/dbconfig.php';

if (isset($_SESSION['user_session']) && isset($_POST['date'])) {

  echo json_encode($crud->getStaffFilteredByDate(trim($_POST['date'])));

} else {

  echo "Not ok.";

}

?>
