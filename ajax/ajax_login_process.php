<?php
session_start();
require_once '../includes/dbconfig.php';

if (isset($_POST['btn-login'])) {
  $user_login = trim($_POST['login']);
  $user_password = trim($_POST['password']);

  try {
    $sql = "SELECT
              {$DB_table->users}.login as `login`,
              {$DB_table->users}.password as `password`,
              {$DB_table->users}.auth_id as `auth_id`,
              {$DB_table->auth_states}.state as `auth_state`
            FROM
              {$DB_table->users}
            LEFT JOIN
              {$DB_table->auth_states}
            ON
              {$DB_table->users}.auth_id = {$DB_table->auth_states}.id
            WHERE
              login=:log";

    $stmt = $DB_con->prepare($sql);
    $stmt->execute(array(":log" => $user_login));

    if ($stmt->rowCount() > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if( password_verify($user_password, $row['password']) ){
        echo "ok"; // log in
        $_SESSION['authenticated'] = true;
        $_SESSION['user'] = (object) array();
        $_SESSION['user']->login = $row['login'];
        $_SESSION['user']->auth_id = $row['auth_id'];
        $_SESSION['user']->auth_state = $row['auth_state'];

        $_SESSION['welcome_user'] = true;
      } else {
          echo "Login or password does not exist"; // wrong details
      }
    } else {
      echo "Login or password does not exist";
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}
