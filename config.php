<?php
include 'includes/pre-head.php';

if (!isset($_SESSION['user'])) {
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
      <div class="col">
        <div id='cmd-options' class="btn-group mt-3 mb-3" role="group" aria-label="First group">
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
            <input type="password" class="form-control" id="old-pw" placeholder="Old Password" autocomplete="off">
          </div>
          <div class="form-group">
              <label for="exampleInputPassword1">New Password</label>
              <input type="password" class="form-control" id="new-pw" placeholder="New Password" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Repeat Password</label>
            <input type="password" class="form-control" id="rpt-pw" placeholder="Repeat Password" autocomplete="off">
          </div>
          <button type="submit" class="btn btn-primary">Change Password</button>
        </form>

      </div>
      <div id="cmd-addusr" class="col-4 form-section">
        <?php if ($_SESSION['user']->auth_state !== 'admin'): ?>
          <p>You do are not an administrator of this page, contact an administrator to add users.</p>
        <?php else: ?>
          <form>
            <div class="form-group">
              <label for="exampleFormControlInput1">New Username</label>
              <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="new-pw">New Password</label>
                <input type="password" class="form-control" id="new-pw" placeholder="New Password" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="rpt-pw">Repeat Password</label>
              <input type="password" class="form-control" id="rpt-pw" placeholder="Repeat Password" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="exampleFormControlSelect1">App Authorization:</label>
              <select class="form-control" id="state">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Add New User</button>
          </form>
        <?php endif; ?>
      </div>
      <div id="cmd-modusr" class="col-4 form-section">
        <?php if ($_SESSION['user']->auth_state !== 'admin'): ?>
          <p>You do are not an administrator of this page, contact an administrator to modify users.</p>
        <?php else: ?>
          <form>
            <div class="form-group">
              <label for="exampleFormControlSelect1">Select user to modify:</label>
              <select class="form-control" id="state">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
            </div>
            <div class="p-2 mb-2 border border-secondary">
              <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Change this user's password?</span>
              </label>
              <div class="form-group">
                  <label for="new-pw">New Password</label>
                  <input type="password" class="form-control" id="new-pw" placeholder="New Password" autocomplete="off"  disabled>
              </div>
              <div class="form-group">
                <label for="rpt-pw">Repeat Password</label>
                <input type="password" class="form-control" id="rpt-pw" placeholder="Repeat Password" autocomplete="off"  disabled>
              </div>
            </div>
            <div class="p-2 mb-2 border border-secondary">
              <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Change this user's app authorization?</span>
              </label>
              <div class="form-group">
                <label for="exampleFormControlSelect1">App Authorization:</label>
                <select class="form-control" id="state" disabled>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Add New User</button>
          </form>
        <?php endif; ?>
      </div>
      <div id="cmd-delusr" class="col-4 form-section">
        <?php if ($_SESSION['user']->auth_state !== 'admin'): ?>
          <p>You do are not an administrator of this page, contact an administrator to delete users.</p>
        <?php else: ?><form>
          <form>
            <div class="form-group">
              <label for="exampleFormControlSelect1">Select user to delete:</label>
              <select class="form-control" id="state">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
            </div>
            <button type="submit" class="btn btn-danger">Delete user</button>
          </form>
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
