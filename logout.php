<?php
 session_start();
 unset($_SESSION['authenticated']);
 unset($_SESSION['user']);


 if(session_destroy())
 {
  header("Location: index.php");
 }
?>
