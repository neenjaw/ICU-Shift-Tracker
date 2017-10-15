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
    <div class="row justify-content-center">
      <div class="col-6">
        <div id='cmd-options' class="btn-group" role="group" aria-label="First group">
          <button type="button" class="btn btn-primary" data-cmd="changepw">Change Password</button>
          <button type="button" class="btn btn-secondary" data-cmd="addusr">Add a user</button>
          <button type="button" class="btn btn-secondary" data-cmd="modusr">Modify User</button>
          <button type="button" class="btn btn-secondary" data-cmd="delusr">Delete User</button>
        </div>
      </div>
    </div>
    <div id="cmd-row" class="row">
      <div id="cmd-changepw" class="col form-section current">

        <form>
          <div class="form-group">
            <label for="exampleInputPassword1">Old Password</label>
            <input type="password" class="form-control" name="old-pw" id="old-pw" placeholder="Old Password" autocomplete="off">
          </div>
          <div class="form-group">
              <label for="exampleInputPassword1">New Password</label>
              <input type="password" class="form-control" name="new-pw" id="new-pw" placeholder="New Password" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Repeat Password</label>
            <input type="password" class="form-control" name="rpt-pw" id="rpt-pw" placeholder="Repeat Password" autocomplete="off">
          </div>
          <button type="submit" class="btn btn-primary">Change Password</button>
        </form>

      </div>
      <div id="cmd-addusr" class="col form-section">
        <?php if (intval($row['admin']) !== 1): ?>
          <p>You do are not an administrator of this page, contact an administrator to add users.</p>
        <?php else: ?>
          <p>add user</p>
        <?php endif; ?>
      </div>
      <div id="cmd-modusr" class="col form-section">
        <?php if (intval($row['admin']) !== 1): ?>
          <p>You do are not an administrator of this page, contact an administrator to modify users.</p>
        <?php else: ?>
          <p>mod user</p>
        <?php endif; ?>
      </div>
      <div id="cmd-delusr" class="col form-section">
        <?php if (intval($row['admin']) !== 1): ?>
          <p>You do are not an administrator of this page, contact an administrator to delete users.</p>
        <?php else: ?>
          <p>del user</p>
        <?php endif; ?>
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

      $(`#cmd-row`).children().removeClass('current');
      let cmd = $(this).data('cmd');
      $(`#cmd-${cmd}`).addClass('current');
    });
  });
  </script>

  <!-- Footer include -->
  <?php include 'includes/footer.php'; ?>
  <!-- END Footer include -->

</body>

</html>
