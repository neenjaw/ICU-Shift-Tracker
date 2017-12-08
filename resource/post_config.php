<?php
session_start();
require_once '../includes/dbconfig.php';

if (!isset($_SESSION['authenticated'])) {
  die("Unauthorized.");
}

try {
  if (!isset($_POST['cmd-submit'])) {
    die("Wrong parameters.");
  }

  if (isset($_POST['cmd-changepw'])) {

    /*
     *  CHANGE CURRENT USER'S PW
     */

    //required arguments
    $usr = $_SESSION['user']->login;
    if (isset($_POST['old-pw'])) { $pw = trim($_POST['old-pw']);     } else { throw new ConfigException();}
    if (isset($_POST['new-pw'])) { $new_pw = trim($_POST['new-pw']); } else { throw new ConfigException();}
    if (isset($_POST['rpt-pw'])) { $rpt_pw = trim($_POST['rpt-pw']); } else { throw new ConfigException();}

    $result = changeOwnPassword($DB_con, $DB_table, $usr, $pw, $new_pw, $rpt_pw);

  } elseif (isset($_POST['cmd-addusr'])) {


    /*
     *  ADD A NEW USER
     */

    //required arguments
    $adm_usr = $_SESSION['user']->login;
    if (isset($_POST['username'])) { $usr = trim($_POST['username']);  } else { throw new ConfigException();}
    if (isset($_POST['new-pw']))   { $new_pw = trim($_POST['new-pw']); } else { throw new ConfigException();}
    if (isset($_POST['rpt-pw']))   { $rpt_pw = trim($_POST['rpt-pw']); } else { throw new ConfigException();}

    //optional arguments
    $args = (object) array();
    if (isset($_POST['state'])) $args->state = trim($_POST['state']);

    $result = addUser($DB_con, $DB_table, $adm_usr, $usr, $new_pw, $rpt_pw, $_SESSION['user']->login, $args);

  } elseif (isset($_POST['cmd-modusr'])) {

    /*
     *  MODIFY A USER'S ENTRY
     */

    $adm_usr = $_SESSION['user']->login;
    if (isset($_POST['userid'])) { $usr = trim($_POST['userid']); } else { throw new ConfigException();}

    $args = (object) array();
    $args->pw = (object) array();
    if (isset($_POST['new-pw'])) $args->pw->new_pw = trim($_POST['new-pw']);
    if (isset($_POST['rpt-pw'])) $args->pw->rpt_pw = trim($_POST['rpt-pw']);

    $args->flags = (object) array();
    if (isset($_POST['state'])) $args->flags->state = trim($_POST['state']);

    $result = modUser($DB_con, $DB_table, $adm_usr, $usr, $args);

  } elseif (isset($_POST['cmd-delusr'])) {

    /*
     *  DELETE A USER
     */

    $adm_usr = $_SESSION['user']->login;
    if (isset($_POST['userid'])) { $usr = trim($_POST['userid']); } else { throw new ConfigException();}

    $result = delUser($DB_con, $DB_table, $adm_usr, $usr);

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
 * @param  Database $DB       A reference to the database instance
 * @param  String $DB_table   String value containing the user table name string
 * @param  String $usr        String value of the login name
 * @param  String $pw         String value of old password
 * @param  String $new_pw     String value of new password
 * @param  String $rpt_pw     String value, repeat of new password
 * @return Result             Result object to relay success state, message
 */
function changeOwnPassword($DB, $DB_table, $usr, $pw, $new_pw, $rpt_pw) {

  if ($new_pw !== $rpt_pw) {
    return new Result(false, "Error: New passwords dont match.");
  }

  try {
    $stmt = $DB->prepare("SELECT * FROM {$DB_table->users} WHERE login=:log");
    $stmt->bindparam(":log", $usr);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if( !password_verify($pw, $row['password']) ){
      return new Result(false, "Error: Old password doesn't match.");
    } else {

      if ( !changePassword($DB, $DB_table, $usr, $new_pw) ) {
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
 * @param  Database $DB         A reference to the database instance
 * @param  String   $DB_table   String value containing the user table name string
 * @param  String   $adm_usr    String value containing a login name, to be tested if is an administrator
 * @return boolean              true/false whether $adm_usr is an administrator login
 */
function isAdmin($DB, $DB_table, $adm_usr) {
  try {
    //get the user's record
    $stmt = $DB->prepare("SELECT * FROM {$DB_table->users} LEFT JOIN {$DB_table->auth_states} ON {$DB_table->users}.auth_id = {$DB_table->auth_states}.id WHERE login=:log");
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
  if ($row['state'] === "admin") {
    return true;
  }

  //default return state
  return false;
}

/**
 * Function to add a new user to the system
 * @param  Database $DB         A reference to the database instance
 * @param  String   $DB_table   String value containing the user table name string
 * @param  String   $adm_usr    String value containing a login name, to be tested if is an administrator
 * @param  String   $new_usr    String value, new user's login name
 * @param  String   $pw         String value, new user's pw
 * @param  String   $rpt_pw     String value, repeat of pw for confirmation
 * @param  Array    $args       Optional, stdClass object with flags for the creation of the user
 * @return Result             Result object to relay success state, message
 */
function addUser($DB, $DB_table, $adm_usr, $new_usr, $pw, $rpt_pw, $added_by, $args = null) {
  if ($args === null) {
    $args = (object) array();
  }

  //default flags
  if (isset($args->state)) {
    $args->state = filterInt($args->state);
    if ($args->state === null) return new Result(false, "Not valid state value");
  } else {
    $args->state = 2;
  }

  if ($new_usr === null) return new Result(false, "Bad new username.");
  if ($pw === null || $pw !== $rpt_pw) return new Result(false, "Bad Password.");

  if (!isAdmin($DB, $DB_table, $adm_usr)) return new Result(false, "Must be an administrator to perform this action");

  try {
    $stmt = $DB->prepare("SELECT * FROM {$DB_table->users} WHERE login=:log");
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

    $stmt = $DB->prepare("INSERT INTO {$DB_table->users} (login,	password,	auth_id, added_timestamp, added_by) VALUES (?, ?, ?, NULL, ?)");
    $stmt->bindparam(1, $new_usr);
    $stmt->bindparam(2, $hashed_pw);
    $stmt->bindparam(3, $args->state);
    $stmt->bindparam(4, $added_by);
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
 * @param  Database $DB         A reference to the database instance
 * @param  String   $DB_table   String value containing the user table name string
 * @param  String   $adm_usr    String value containing a login name, to be tested if is an administrator
 * @param  String   $usr_id     String value, subject user's login name
 * @param  Array    $args       Optional, stdClass object with flags for the modification of the user
 * @return Result             Result object to relay success state, message
 */
function modUser($DB, $DB_table, $adm_usr, $usr_id, $args = null) {
  if ($args === null) {
    $args = (object) array();
    $args->pw = (object) array();
  }

  //validate arguments if none specified, fail
  $pw_count = count(get_object_vars($args->pw));
  $flag_count = count(get_object_vars($args->flags));
  if (($pw_count === 0) && ($flag_count === 0)) {
    return new Result(false, "No modifications specified for user.");
  } elseif (!in_array($pw_count, [0,2], true)) {
    return new Result(false, "Wrong number of password arguments");
  }

  //make sure set flags are boolean of some sort
  if (isset($args->flags->state)) {
    $args->flags->state = filterInt($args->flags->state);
    if ($args->flags->state === null) return new Result(false, "Not valid auth state value");
  } else {
    $args->flags->state = null;
  }

  //check is user is the admin
  if (!isAdmin($DB, $DB_table, $adm_usr)) {
    return new Result(false, "Must be an administrator to perform this action");
  }

  //get the user's original entry, verifying that it exists
  try {
    $stmt = $DB->prepare("SELECT * FROM {$DB_table->users} WHERE id=:id");
    $stmt->bindparam(":id", $usr_id);
    $stmt->execute();

    $row_before_update = $stmt->fetch(PDO::FETCH_ASSOC);

    if ( $stmt->rowCount() < 0 ) {
      return new Result(false, "User not found.");
    }
  } catch (Exception $e) {
    throw new Exception("Error retriving user: {$e->getMessage()}");
  }

  if ($args->flags->state === null) {
    $args->flags->state = $row_before_update['auth_id'];
  }

  //if only one password supplied, fail
  if (isset($args->pw->new_pw) XOR isset($args->pw->rpt_pw)) {
    return new Result(false, "Need both password and repeat to modify the user's password");
  //if both supplied
  } elseif ( isset($args->pw->new_pw) && isset($args->pw->rpt_pw) ) {
    //if both supplied passwords dont match, fail
    if ($args->pw->new_pw !== $args->pw->rpt_pw) {
      return new Result(false, "Supplied passwords don't match.");
    } else {
      //attempt to change the password
      if (!changePassword($DB, $DB_table, $usr_id, $args->pw->new_pw)) {
        //if unable, fail
        return new Result(false, "Unable to update password.");
      }
    }
  }

  // echo "\$args->flags->state:\n"; var_dump($args->flags->state); echo "\n";

  try {
    $stmt = $DB->prepare("UPDATE {$DB_table->users} SET auth_id=:ai WHERE id=:uid");
    $stmt->bindparam(":uid", $usr_id);
    $stmt->bindparam(":ai", $args->flags->state);

    $stmt->execute();

    if ( $stmt->rowCount() <= 0 ) {
      return new Result(false, "Unable to update record.");
    }
  } catch (Exception $e) {
    throw new Exception("Error updating auth state: {$e->getMessage()}");
  }

  return new Result(true, "Record updated.");
}

/**
 * [changePassword description]
 * @param  Database $DB         A reference to the database instance
 * @param  String   $DB_table   String value containing the user table name string
 * @param  String   $usr        String value of subject's login, where pw to be changed
 * @param  String   $pw         String value of new pw
 * @return Boolean              true/false to represent success/fail state
 */
function changePassword($DB, $DB_table, $usr, $pw) {
  try{
    $hashed_pw = password_hash($pw, PASSWORD_DEFAULT);

    $stmt = $DB->prepare("UPDATE {$DB_table->users} SET password=:pw WHERE id=:id");
    $stmt->bindparam(":id", $usr);
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
 * @param  Database $DB         A reference to the database instance
 * @param  String   $DB_table   String value containing the user table name string
 * @param  String   $adm_usr    String value containing a login name, to be tested if is an administrator
 * @param  String   $usr_id     String value, subject user's login name
 * @return Result               Result object to relay success state, message
 */
function delUser($DB, $DB_table, $adm_usr, $usr_id) {
  if (!isAdmin($DB, $DB_table, $adm_usr)) {
    return new Result(false, "Must be an administrator to perform this action");
  }

  try {
    $stmt = $DB->prepare("DELETE FROM {$DB_table->users} WHERE id=:uid");
    $stmt->bindparam(":uid", $usr_id);
    $stmt->execute();

    if ( $stmt->rowCount() < 0 ) {
      return new Result(false, "User not deleted.");
    }
  } catch (Exception $e) {
    throw new Exception("Error deleting recod: {$e->getMessage()}");
  }

  return new Result(true, "User Deleted.");
}

/**
 * [filterBool description]
 * @param  mixed $val [description]
 * @return mixed      [description]
 */
function filterInt($val) {
  return filter_var($val, FILTER_VALIDATE_INT);
}
