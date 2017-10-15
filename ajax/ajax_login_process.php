<?php
session_start();
require_once '../includes/dbconfig.php';

if (isset($_POST['btn-login'])) {
    $user_login = trim($_POST['login']);
    $user_password = trim($_POST['password']);

    try {
        $stmt = $DB_con->prepare("SELECT * FROM ".$DB_tbl_users." WHERE login=:log");
        $stmt->execute(array(":log" => $user_login));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();

        if( password_verify($user_password, $row['password']) ){
            echo "ok"; // log in
            $_SESSION['user_session'] = $row['login'];
            $_SESSION['welcome_user'] = true;
        } else {
            echo "Login or password does not exist"; // wrong details
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
