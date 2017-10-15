<?php
session_start();
require_once '../includes/dbconfig.php';

if (!isset($_SESSION['user_session'])) {
  die("Unauthorized.");
}

if (!isset($_GET['cmd-submit'])) {
  die("Wrong parameters.");
}

if (isset($_POST['cmd-changepw'])) {
  $usr = $_SESSION['user_session'];
  $pw = trim($_POST['old-pw']);
  $new_pw = trim($_POST['new-pw']);
  $rpt_pw = trim($_POST['rpt-pw']);

  $result = changeOwnPassword($DB_con, $DB_tbl_users, $usr, $pw, $new_pw, $rpt_pw);

  if ($result->getSuccess()) {
    echo "Ok: {$result->getMessage()}";
  } else {
    echo "Problem: {$result->getMessage()}";
  }

} elseif (isset($_GET['cmd-addusr'])) {

  echo 'addUser incomplete';

} elseif (isset($_GET['cmd-modusr'])) {
  $adm_usr = $_SESSION['user_session'];
  $adm_pw = trim($_GET['adm-pw']);
  $usr_id = trim($_GET['username']);

  $args = (object) array();

  if (isset($_GET['new-pw'])) $args->new_pw = trim($_GET['new-pw']);

  if (isset($_GET['rpt-pw'])) $args->rpt_pw = trim($_GET['rpt-pw']);

  if (isset($_GET['admin'])) $args->admin = trim($_GET['admin']);

  if (isset($_GET['viewonly'])) $args->viewonly = trim($_GET['viewonly']);

  if (isset($_GET['active'])) $args->viewonly = trim($_GET['active']);

  $result = modUser($DB_con, $DB_tbl_users, $adm_usr, $adm_pw, $usr_id, $args);

  if ($result->getSuccess()) {
    echo "Ok: {$result->getMessage()}";
  } else {
    echo "Problem: {$result->getMessage()}";
  }

} elseif (isset($_GET['cmd-delusr'])) {

  echo 'Del user incomplete';

}

die();

/*
 * Support classes and functions
 */

class Result
{
  private $success;
  private $message;

  public function getSuccess() {
    return $this->success;
  }

  public function getMessage() {
    return $this->message;
  }

  public function setMessage($m) {
    $this->message = $m;
  }

  function __construct($s, $m = '') {
    $this->success = $s;
    $this->message = $m;
  }
}

function changeOwnPassword($db, $db_table, $usr, $pw, $new_pw, $rpt_pw) {

  if ($new_pw !== $rpt_pw) {
    return new Result(false, "Error: New passwords dont match.");
  }

  try {
    $stmt = $db->prepare("SELECT * FROM {$db_table} WHERE login=:log");
    $stmt->bindparam(":log", $usr);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if( !password_verify($pw, $row['password']) ){
      return new Result(false, "Error: Old password doesn't match.");
    } else {

      if ( !changePassword($db, $db_table, $usr, $new_pw) ) {
        return new Result(false, "Failure: Password not updated.");
      } else {
        return new Result(true, "Success: Password updated.");
      }

    }
  } catch (Exception $e) {
    throw new Exception("Error updating password: {$e->getMessage()}");
  }
}

function isAdmin($db, $db_table, $adm_usr, $adm_pw) {
  try {
    //get the user's record
    $stmt = $db->prepare("SELECT * FROM {$db_table} WHERE login=:log");
    $stmt->bindparam(":log", $adm_usr);
    $stmt->execute();

    //check if the user is found in the db
    if ( $stmt->rowCount() <= 0 ) {
      return false;
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (Exception $e) {
    throw new Exception("Error retrieveing user: {$e->getMessage()}");
  }

  //authenticate the user
  if( !password_verify($adm_pw, $row['password']) ){
    return false;
  }

  //if the user is authenticated and check for auth as admin
  if (intval($row['admin']) === 1) {
    return true;
  }

  //default return state
  return false;
}

function addUser($db, $db_table, $adm_usr, $adm_pw, $new_usr, $pw, $rpt_pw, $args = null) {

  if (!isAdmin($adm_usr, $adm_pw)) {
    return new Result(false, "Must be an administrator to perform this action");
  }

  return new Result(false, "Incomplete.");
}

function modUser($db, $db_table, $adm_usr, $adm_pw, $usr_id, $args = null) {
  if ($args === null) {
    $args = (object) array();
  }

  //validate arguments if none specified, fail
  if (count(get_object_vars($args)) <= 0) {
    return new Result(false, "No modifications specified for user.");
  }

  //check is user is the admin
  if (!isAdmin($db, $db_table, $adm_usr, $adm_pw)) {
    return new Result(false, "Must be an administrator to perform this action");
  }

  try {
      $stmt = $db->prepare("SELECT * FROM {$db_table} WHERE login=:log");
      $stmt->bindparam(":log", $usr_id);
      $stmt->execute();

      $row_before_update = $stmt->fetch(PDO::FETCH_ASSOC);

      if ( $stmt->rowCount() < 0 ) {
        return new Result(false, "User not found.");
      }
  } catch (Exception $e) {
    throw new Exception("Error updating flags: {$e->getMessage()}");
  }

  if ( !isset($args->admin) ) {
    $args->admin = $row_before_update['admin'];
  }

  if ( !isset($args->active) ) {
    $args->active = $row_before_update['active'];
  }

  if ( !isset($args->viewonly) ) {
    $args->viewonly = $row_before_update['viewonly'];
  }

  //if only one password supplied, fail
  if (isset($args->new_pw) XOR isset($args->rpt_pw)) {
    return new Result(false, "Supplied password doesnt match.");
  //if both supplied
  } elseif ( isset($args->new_pw) && isset($args->rpt_pw) ) {
    //if both supplied passwords dont match, fail
    if ($args->new_pw !== $args->rpt_pw) {
      return new Result(false, "Supplied passwords don't match.");
    } else {
      //attempt to change the password
      if (!changePassword($db, $db_table, $usr_id, $args->new_pw)) {
        //if unable, fail
        return new Result(false, "Unable to update password.");
      }
    }
  }

  //make sure flags are boolean of some sort
  $flag_fail = array();
  if (filter_var($args->admin, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === NULL) {
    array_push($flag_fail, "Admin");
  }
  if (filter_var($args->viewonly, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === NULL) {
    array_push($flag_fail, "View-Only");
  }
  if (filter_var($args->active, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === NULL) {
    array_push($flag_fail, "Active");
  }

  //if flags not boolean, fail
  if (count($flag_fail) > 0 ) {
    $s = implode(', ', $flag_fail);
    return new Result(false, "{$s} flag(s) are not boolean values.");
  }

  //if admin is true as well as viewonly or not active, fail
  if ($args->admin && $args->viewonly) {
    return new Result(false, "Admin and Viewonly flag options not compatible with  flag.");
  }

  //if active is false as well as $admin or not active, fail
  if (!$args->active && ($args->admin || $args->viewonly) ) {
    return new Result(false, "Flag options not compatible with Active flag.");
  }

  try {
      $stmt = $db->prepare("UPDATE {$db_table} SET admin=:ad, active=:ac, viewonly=:vo WHERE login=:log");
      $stmt->bindparam(":log", $usr_id);

      $stmt->bindparam(":ad", $args->admin);
      $stmt->bindparam(":ac", $args->active);
      $stmt->bindparam(":vo", $args->viewonly);

      //TODO REMOVE THIS AFTER TESTING
      //$stmt->execute();

      if ( $stmt->rowCount() < 0 ) {
        return new Result(false, "Unable to update record.");
      }
  } catch (Exception $e) {
    throw new Exception("Error updating flags: {$e->getMessage()}");
  }

  return new Result(true, "Record updated.");
}

function changePassword($db, $db_table, $usr, $pw) {
  try{
    $hashed_pw = password_hash($pw, PASSWORD_DEFAULT);

    $stmt = $db->prepare("UPDATE {$db_table} SET password=:pw WHERE login=:log");
    $stmt->bindparam(":log", $usr);
    $stmt->bindparam(":pw", $hashed_pw);
    $stmt->execute();

    if ( $stmt->rowCount() > 0 ) {
      return true;
    }
  } catch (Exception $e) {
    throw new Exception("Error updating record: {$e->getMessage()}");
  }

  return false;
}

function delUser($db, $db_table, $adm_usr, $adm_pw, $usr_id) {
  if (!isAdmin($adm_usr, $adm_pw)) {
    return new Result(false, "Must be an administrator to perform this action");
  }

  return new Result(false, "Incomplete.");
}
