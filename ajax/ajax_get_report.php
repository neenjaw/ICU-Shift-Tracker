<?php
session_start();
require_once '../includes/dbconfig.php';

if (!isset($_SESSION['authenticated'])) {
  die("Unauthorized.");
}

try {

  echo "Ok.";

} catch (Exception $e) {
  echo "Unable to get report data: {$e}";
}

?>
