<?php
session_start();
require_once '../../includes/dbconfig.php';

if (isset($_SESSION['user_session']) && isset($_GET['test'])) {

  echo json_encode($crud->getShiftTableObject());

} else {

  echo "Not ok.";

}

?>
