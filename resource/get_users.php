<?php
session_start();
require_once '../includes/dbconfig.php';

if (!isset($_SESSION['authenticated'])) {
  die("Unauthorized.");
}

if ($_SESSION['user']->auth_state !== 'admin') {
  die("Unauthorized. Must be an administrator.");
}

if (isset($_GET['user'])) {

  $sql = "SELECT auth_id FROM {$DB_table->users} WHERE id = :lid";
  $stmt = $DB_con->prepare($sql);
  $stmt->bindparam(":lid", $_GET['user'], PDO::PARAM_STR);
  $stmt->execute();

  if ($stmt->rowCount() < 1) {
    echo "{\"error\":\"Unable to retrieve authorization level\"}";
  } else {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "{\"auth\":{$row['auth_id']}}";
  }

} else {

  $sql = "SELECT id, login FROM {$DB_table->users} WHERE login != '{$_SESSION['user']->login}'";

  $stmt = $DB_con->prepare($sql);
  $stmt->execute();

  $result = array();
  while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($result, $row);
  }

  echo json_encode($result);

}

?>
