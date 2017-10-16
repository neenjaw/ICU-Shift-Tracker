<?php
session_start();
require_once '../includes/dbconfig.php';

try {
  if (!isset($_SESSION['user_session'])) {
    die("Unauthorized.");
  }

  if (!isset($_GET['cmd-submit'])) {
    die("Wrong parameters.");
  }

  if (isset($_GET['cmd-changepw'])) {

    /*
     *  CHANGE CURRENT USER'S PW
     */

    //required arguments
    $usr = $_SESSION['user_session'];
    if (isset($_GET['old-pw'])) { $pw = trim($_GET['old-pw']); } else { throw new ConfigException();}
    if (isset($_GET['new-pw'])) { $new_pw = trim($_GET['new-pw']); } else { throw new ConfigException();}
    if (isset($_GET['rpt-pw'])) { $rpt_pw = trim($_GET['rpt-pw']); } else { throw new ConfigException();}

    $result = changeOwnPassword($DB_con, $DB_tbl_users, $usr, $pw, $new_pw, $rpt_pw);

  } elseif (isset($_GET['cmd-addusr'])) {

    /*
     *  ADD A NEW USER
     */

    //required arguments
    $adm_usr = $_SESSION['user_session'];
    if (isset($_GET['username'])) { $usr = trim($_GET['username']); } else { throw new ConfigException();}
    if (isset($_GET['new-pw'])) { $new_pw = trim($_GET['new-pw']); } else { throw new ConfigException();}
    if (isset($_GET['rpt-pw'])) { $rpt_pw = trim($_GET['rpt-pw']); } else { throw new ConfigException();}

    //optional arguments
    $args = (object) array();
    if (isset($_GET['admin'])) $args->admin = trim($_GET['admin']);
    if (isset($_GET['viewonly'])) $args->viewonly = trim($_GET['viewonly']);

    $result = addUser($DB_con, $DB_tbl_users, $adm_usr, $usr, $new_pw, $rpt_pw, $args);

  } elseif (isset($_GET['cmd-modusr'])) {

    /*
     *  MODIFY A USER'S ENTRY
     */

    $adm_usr = $_SESSION['user_session'];
    if (isset($_GET['username'])) { $usr = trim($_GET['username']); } else { throw new ConfigException();}

    $args = (object) array();
    if (isset($_GET['new-pw'])) $args->new_pw = trim($_GET['new-pw']);
    if (isset($_GET['rpt-pw'])) $args->rpt_pw = trim($_GET['rpt-pw']);
    if (isset($_GET['admin'])) $args->admin = trim($_GET['admin']);
    if (isset($_GET['viewonly'])) $args->viewonly = trim($_GET['viewonly']);
    if (isset($_GET['active'])) $args->viewonly = trim($_GET['active']);

    $result = modUser($DB_con, $DB_tbl_users, $adm_usr, $usr, $args);

  } elseif (isset($_GET['cmd-delusr'])) {

    /*
     *  DELETE A USER
     */

    $adm_usr = $_SESSION['user_session'];
    if (isset($_GET['username'])) { $usr = trim($_GET['username']); } else { throw new ConfigException();}

    $result = delUser($DB_con, $DB_tbl_users, $adm_usr, $usr);

  }

  if (isset($result)) {
    if ($result->getSuccess()) {
      echo "Ok: {$result->getMessage()}";
    } else {
      echo "Problem: {$result->getMessage()}";
    }
  }
} catch (ConfigException $e) {
  echo "Error: {$e->getMessage()}";
}

die();

/*
 * Support classes and functions
 */

class ConfigException extends Exception {
}

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

/**
 * Function to change the current session user's password, based on logged in user
 * @param  Database $db       A reference to the database instance
 * @param  String $db_table   String value containing the user table name string
 * @param  String $usr        String value of the login name
 * @param  String $pw         String value of old password
 * @param  String $new_pw     String value of new password
 * @param  String $rpt_pw     String value, repeat of new password
 * @return Result             Result object to relay success state, message
 */
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

/**
 * Check if the current logged in user is an Administrator
 * @param  Database $db         A reference to the database instance
 * @param  String   $db_table   String value containing the user table name string
 * @param  String   $adm_usr    String value containing a login name, to be tested if is an administrator
 * @return boolean              true/false whether $adm_usr is an administrator login
 */
function isAdmin($db, $db_table, $adm_usr) {
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

  //if the user is authenticated and check for auth as admin
  if (intval($row['admin']) === 1) {
    return true;
  }

  //default return state
  return false;
}

/**
 * Function to add a new user to the system
 * @param  Database $db         A reference to the database instance
 * @param  String   $db_table   String value containing the user table name string
 * @param  String   $adm_usr    String value containing a login name, to be tested if is an administrator
 * @param  String   $new_usr    String value, new user's login name
 * @param  String   $pw         String value, new user's pw
 * @param  String   $rpt_pw     String value, repeat of pw for confirmation
 * @param  Array    $args       Optional, stdClass object with flags for the creation of the user
 * @return Result             Result object to relay success state, message
 */
function addUser($db, $db_table, $adm_usr, $new_usr, $pw, $rpt_pw, $args = null) {
  $debug = false;
  if ($debug) var_dump($args);

  if ($args === null) {
    $args = (object) array();
  }

  //default flags
  if (!isset($args->admin) || (filter_var($args->admin, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === NULL)) {
    $args->admin = false;
  } else {
    $args->admin = boolval($args->admin);
  }
  if (!isset($args->viewonly) || (filter_var($args->admin, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === NULL)) {
    $args->viewonly = false;
  }else {
    $args->viewonly = boolval($args->viewonly);
  }
  $args->active = true;

  if ($args->admin && $args->viewonly) return new Result(false, "User can't be admin and viewonly.");
  if ($new_usr === null) return new Result(false, "Bad new username.");
  if ($pw === null || $pw !== $rpt_pw) return new Result(false, "Bad Password.");

  if (!isAdmin($db, $db_table, $adm_usr)) return new Result(false, "Must be an administrator to perform this action");

  try {
    $stmt = $db->prepare("SELECT * FROM {$db_table} WHERE login=:log");
    $stmt->bindparam(":log", $new_usr);
    $stmt->execute();

    if ( $stmt->rowCount() > 0 ) {
      return new Result(false, "Username already chosen. Pick another");
    }
  } catch (Exception $e) {
    throw new Exception("Error with select: {$e->getMessage()}");
  }

  try {
    $hashed_pw = password_hash($pw, PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO {$db_table} (login,	password,	active,	viewonly,	admin) VALUES (?,?,?,?,?)");
    $stmt->bindparam(1, $new_usr);
    $stmt->bindparam(2, $hashed_pw);
    $stmt->bindparam(3, $args->active);
    $stmt->bindparam(4, $args->viewonly);
    $stmt->bindparam(5, $args->admin);
    $stmt->execute();

    if ( $stmt->rowCount() <= 0 ) {
      return new Result(false, "Unable to insert new record.");
    }
  } catch (Exception $e) {
    throw new Exception("Error with insert: {$e->getMessage()}");
  }

  return new Result(true, "Record inserted successfully.");
}

/**
 * [modUser description]
 * @param  Database $db         A reference to the database instance
 * @param  String   $db_table   String value containing the user table name string
 * @param  String   $adm_usr    String value containing a login name, to be tested if is an administrator
 * @param  String   $usr_id     String value, subject user's login name
 * @param  Array    $args       Optional, stdClass object with flags for the modification of the user
 * @return Result             Result object to relay success state, message
 */
function modUser($db, $db_table, $adm_usr, $usr_id, $args = null) {
  if ($args === null) {
    $args = (object) array();
  }

  //validate arguments if none specified, fail
  if (count(get_object_vars($args)) <= 0) {
    return new Result(false, "No modifications specified for user.");
  }

  //check is user is the admin
  if (!isAdmin($db, $db_table, $adm_usr)) {
    return new Result(false, "Must be an administrator to perform this action");
  }

  //get the user's original entry, verifying that it exists
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

  //make sure flags are boolean of some sort
  $flag_fail = array();
  if ( !isset($args->admin) || (filter_var($args->admin, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === NULL)) {
    $args->admin = $row_before_update['admin'];
  }

  if ( !isset($args->active) || (filter_var($args->admin, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === NULL) ) {
    $args->active = $row_before_update['active'];
  }

  if ( !isset($args->viewonly) || (filter_var($args->admin, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === NULL) ) {
    $args->viewonly = $row_before_update['viewonly'];
  }

  //if admin is true as well as viewonly or not active, fail
  if ($args->admin && $args->viewonly) {
    return new Result(false, "Admin and Viewonly flag options not compatible with  flag.");
  }

  //if active is false as well as $admin or not active, fail
  if (!$args->active && ($args->admin || $args->viewonly) ) {
    return new Result(false, "Flag options not compatible with Active flag.");
  }

  //if only one password supplied, fail
  if (isset($args->new_pw) XOR isset($args->rpt_pw)) {
    return new Result(false, "Need both password and repeat to modify the user's password");
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

  try {
      $stmt = $db->prepare("UPDATE {$db_table} SET admin=:ad, active=:ac, viewonly=:vo WHERE login=:log");
      $stmt->bindparam(":log", $usr_id);

      $stmt->bindparam(":ad", $args->admin);
      $stmt->bindparam(":ac", $args->active);
      $stmt->bindparam(":vo", $args->viewonly);

      $stmt->execute();

      if ( $stmt->rowCount() < 0 ) {
        return new Result(false, "Unable to update record.");
      }
  } catch (Exception $e) {
    throw new Exception("Error updating flags: {$e->getMessage()}");
  }

  return new Result(true, "Record updated.");
}

/**
 * [changePassword description]
 * @param  Database $db         A reference to the database instance
 * @param  String   $db_table   String value containing the user table name string
 * @param  String   $usr        String value of subject's login, where pw to be changed
 * @param  String   $pw         String value of new pw
 * @return Boolean              true/false to represent success/fail state
 */
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

/**
 * [delUser description]
 * @param  Database $db         A reference to the database instance
 * @param  String   $db_table   String value containing the user table name string
 * @param  String   $adm_usr    String value containing a login name, to be tested if is an administrator
 * @param  String   $usr_id     String value, subject user's login name
 * @return Result               Result object to relay success state, message
 */
function delUser($db, $db_table, $adm_usr, $usr_id) {
  if (!isAdmin($adm_usr, $adm_pw)) {
    return new Result(false, "Must be an administrator to perform this action");
  }

  return new Result(false, "Incomplete.");
}
