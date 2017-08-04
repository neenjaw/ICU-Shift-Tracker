<?php
session_start();
require_once '../includes/dbconfig.php';

if (isset($_POST['btn-login'])) {
    $user_email = trim($_POST['email']);
    $user_password = trim($_POST['password']);
  
    try {
        $stmt = $DB_con->prepare("SELECT * FROM ".$DB_tbl_users." WHERE email=:eml");
        $stmt->execute(array(":eml" => $user_email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();
   
        if( password_verify($user_password, $row['password']) ){
            echo "ok"; // log in
            $_SESSION['user_session'] = $row['email'];
            $_SESSION['welcome_user'] = true;
        } else {
            echo "Email or password does not exist"; // wrong details
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
