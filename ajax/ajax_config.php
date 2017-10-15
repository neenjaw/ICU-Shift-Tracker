<?php
session_start();
require_once '../includes/dbconfig.php';

if (!isset($_SESSION['user_session'])) {
  die("Unauthorized.");
}

if (!isset($_POST['cmd-submit'])) {
  die("Wrong parameters.");
}

if (isset($_POST['cmd-changepw'])) {
    $usr = $_SESSION['user_session'];
    $pw = trim($_POST['old-pw']);
    $new_pw = trim($_POST['new-pw']);
    $rpt_pw = trim($_POST['rpt-pw']);

    $result = changePassword($usr, $pw, $new_pw, $rpt_pw);
} elseif (isset($_POST['cmd-addusr'])) {
    $new_usr = $_POST['new-username'];
    $pw = trim($_POST['new-pw']);
    $rpt_pw = trim($_POST['rpt-pw']);
    $admin = trim($_POST['admin']);
    $viewonly = trim($_POST['viewonly']);

    $result = addUser($new_usr, $pw, $rpt_pw, $admin, $viewonly);
} elseif (isset($_POST['cmd-modusr'])) {

} elseif (isset($_POST['cmd-delusr'])) {

}

echo $result->getMessage();
die();

class Result
{
  private $success;
  private $message;

  public getSuccess() {
    return $success;
  }

  public getMessage() {
    return $message;
  }

  public setMessage($m) {
    $this->message = $m;
  }

  function __construct($s, $m = '') {
    $this->success = $s;
    $this->message = $m;
  }
}

function changePassword($usr, $pw, $new_pw, $rpt_pw) {

  if ($new_pw !== $rpt_pw) {
    return new Result(false, "Error: New passwords dont match.");
  }

  try {
    $stmt = $DB_con->prepare("SELECT * FROM {$DB_tbl_users} WHERE login=:log");
    $stmt->bindparam(":log", $usr);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if( !password_verify($pw, $row['password']) ){
      return new Result(false, "Error: Old password doesn't match.");
    } else {
      $new_hashed_pw = password_hash($new_pw, PASSWORD_DEFAULT);

      $stmt = $DB_con->prepare("UPDATE {$DB_tbl_users} SET password=:pw WHERE login=:log");
      $stmt->bindparam(":log", $usr);
      $stmt->bindparam(":pw", $new_hashed_pw);
      $stmt->execute();

      if ( $stmt->rowCount() <= 0 ) {
        return new Result(false, "Failure: Password not updated.");
      }

      return new Result(true, "Success: Password updated.");
    }
  } catch (Exception $e) {
    throw new Exception("Error updating password: {$e->getMessage()}");
  }
}
