
<?php if (isset($_SESSION['error_msg'])): ?>
  <div class="container">
    <div class='alert alert-danger'>
      <button class='close' data-dismiss='alert'>&times;</button>
       <p><strong>'<?= $_SESSION['user']->login; ?>'</strong>, there has been an error:</p>
       <p><?= $error_msg; ?></p>
    </div>
  </div>
<?php unset($_SESSION['error_msg']); endif; ?>
<?php if (isset($_SESSION['welcome_user'])): ?>
  <div class="container">
    <div class='alert alert-success'>
      <button class='close' data-dismiss='alert'>&times;</button>
      <strong>Hello '<?= $_SESSION['user']->login; ?>'</strong> <p>You are successfully logged in.</p>
    </div>
  </div>
<?php unset($_SESSION['welcome_user']); endif; ?>
  <div class="container collapse" id="alert-container">
    <div class='alert' id='form-alert'>
      <!-- <button class='close' data-dismiss='alert'>&times;</button> -->
      <p></p>
    </div>
  </div>
