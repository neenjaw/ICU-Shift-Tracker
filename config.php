<?php
include 'includes/pre-head.php';

if (!isset($_SESSION['user_session'])) {
  header("Location: index.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

<head>
  <!-- Header include -->
  <?php include 'includes/head.php';?>
  <!-- END Header include -->

</head>
<body>
  <!-- NAV bar include -->
  <?php include 'includes/navbar.php'; ?>
  <!-- END NAV bar include -->

  <!-- Alert include -->
  <?php include 'includes/alert-header.php' ?>
  <!-- END Alert include -->

  <div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <!-- Nav menu include -->
        <?php include 'includes/nav-menu.php' ?>
        <!-- END nav menu include -->

      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col">
        <h2>Config</h2>
        </div>
    </div>
    <div class="row">

    <!-- <php if (intval($row['admin']) !== 1): >
      <div class="col-12">
        <p>You do are not an administrator of this page, contact an administrator for configuration actions.</p>
      </div>
    <php else: >
    <php endif; > -->

      <div class="col">
        <div id='cmd-options' class="btn-group" role="group" aria-label="First group">
          <button type="button" class="btn btn-secondary">Change Password</button>
          <button type="button" class="btn btn-secondary">Add a user</button>
          <button type="button" class="btn btn-secondary">Modify User</button>
          <button type="button" class="btn btn-secondary">Delete User</button>
        </div>

        <span class="border border-secondary">Pick an option</span>
      </div>
    </div>
  </div>

  <div class="container">
    <br />

    <br />

    <br />
  </div>


  <!-- Script include -->
  <?php include 'includes/script-include.php'; ?>
  <!-- END Script include -->

  <script>
  $(function() {
    $(`#cmd-options`).children().click(function(){
      $(this).removeClass(`btn-secondary`).addClass(`btn-primary`);
      $(this).siblings().removeClass(`btn-primary`).addClass(`btn-secondary`);
    });
  });
  </script>

  <!-- Footer include -->
  <?php include 'includes/footer.php'; ?>
  <!-- END Footer include -->

</body>

</html>
