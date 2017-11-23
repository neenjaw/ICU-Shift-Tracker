<?php
session_start();
require_once '../includes/dbconfig.php';

if (!isset($_SESSION['authenticated'])) {
  die("Unauthorized.");
}

if ($_SESSION['user']->auth_state !== 'admin') {
  die("Unauthorized. Must be an administrator.");
}

// $DB_con
// $DB_table->users = $DB_tbl_users;

$sql = "SELECT id, login FROM {$DB_table->users} WHERE login != '{$_SESSION['user']->login}'";

$stmt = $DB_con->prepare($sql);
$stmt->execute();

$result = array();
while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
  array_push($result, $row);
}

echo json_encode($result);

?>
