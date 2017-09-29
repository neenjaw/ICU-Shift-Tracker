<?php

session_start();
require_once '../dbconfig.php';

try {
  if (true) {


    echo json_encode($crud->getRnStaff(), JSON_PRETTY_PRINT);
    echo "<hr />"

  } else {
    throw new Exception('Wrong arguments.');
  }
} catch (PDOException $e) {
  echo $e;
}

?>
