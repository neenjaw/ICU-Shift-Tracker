  <div class="container" id="alert-container">
<?php

if (isset($_SESSION['error_msg'])) {

?>
    <div class='alert alert-danger'>
      <button class='close' data-dismiss='alert'>&times;</button>
       <p><strong>'<?php echo $_SESSION['user_session']; ?>'</strong>, there is an error:</p>
       <p><?php echo $error_msg; ?></p>
    </div>
<?php
  unset($_SESSION['error_msg']);

} elseif (isset($_SESSION['welcome_user'])) {
?>
    <div class='alert alert-success'>
      <button class='close' data-dismiss='alert'>&times;</button>
      <strong>Hello '<?php echo $_SESSION['user_session']; ?>'</strong> <p>Successfully logged in.</p>
    </div>
<?php
  unset($_SESSION['welcome_user']);
}
?>

    <div class='alert hidden' id='form-alert'>
      <!-- <button class='close' data-dismiss='alert'>&times;</button> -->
      <p></p>
    </div>
  </div>
