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
    <div class="row">
      <form id="cmd-form">
        <div id="cmd-changepw" class="col form-section current">
          <div class="form-group">
            <label for="cmd-changepw-old-pw">Old Password</label>
            <input type="password" class="form-control" id="cmd-changepw-old-pw" placeholder="Old Password" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="cmd-changepw-new-pw">New Password</label>
            <input type="password" class="form-control" id="cmd-changepw-new-pw" placeholder="New Password" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="cmd-changepw-rpt-pw">Repeat Password</label>
            <input type="password" class="form-control" id="cmd-changepw-rpt-pw" placeholder="Repeat Password" autocomplete="off">
          </div>
          <button id="cmd-changepw-submit" type="submit" class="btn btn-primary">Change Password</button>
        </div>
        <div id="cmd-addusr" class="col form-section">
          <?php if ($_SESSION['user']->auth_state !== 'admin'): ?>
            <p>You do are not an administrator of this page, contact an administrator to add users.</p>
          <?php else: ?>
            <div class="form-group">
              <label for="cmd-addusr-new-username">New Username</label>
              <input type="text" class="form-control" id="cmd-addusr-new-username" placeholder="Username">
            </div>
            <div class="form-group">
              <label for="cmd-addusr-new-pw">New Password</label>
              <input type="password" class="form-control" id="cmd-addusr-new-pw" placeholder="New Password" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="cmd-addusr-rpt-pw">Repeat Password</label>
              <input type="password" class="form-control" id="cmd-addusr-rpt-pw" placeholder="Repeat Password" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="cmd-addusr-auth-id">App Authorization:</label>
              <select class="form-control" id="cmd-addusr-auth-id">
                <option selected disabled>loading...</option>
              </select>
            </div>
            <button id="cmd-addusr-submit" type="submit" class="btn btn-primary">Add New User</button>
          <?php endif; ?>
        </div>
        <div id="cmd-modusr" class="col form-section">
          <?php if ($_SESSION['user']->auth_state !== 'admin'): ?>
            <p>You do are not an administrator of this page, contact an administrator to modify users.</p>
          <?php else: ?>
            <div class="form-group">
              <label for="cmd-modusr-uid">Select user to modify:</label>
              <select class="form-control" id="cmd-modusr-uid">
                <option selected disabled>loading...</option>
              </select>
            </div>
            <div class="p-2 mb-2 border border-secondary">
              <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="cmd-modusr-chk-pw">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Change this user's password?</span>
              </label>
              <div class="form-group">
                <label for="cmd-modusr-new-pw">New Password</label>
                <input type="password" class="form-control" id="cmd-modusr-new-pw" placeholder="New Password" autocomplete="off"  disabled>
              </div>
              <div class="form-group">
                <label for="cmd-modusr-rpt-pw">Repeat Password</label>
                <input type="password" class="form-control" id="cmd-modusr-rpt-pw" placeholder="Repeat Password" autocomplete="off"  disabled>
              </div>
            </div>
            <div class="p-2 mb-2 border border-secondary">
              <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="cmd-modusr-chk-auth">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Change this user's app authorization?</span>
              </label>
              <div class="form-group">
                <label for="exampleFormControlSelect1">App Authorization:</label>
                <select class="form-control" id="cmd-modusr-auth-id" disabled>
                  <option selected disabled>loading...</option>
                </select>
              </div>
            </div>
            <button id="cmd-modusr-submit" type="submit" class="btn btn-primary">Add New User</button>
          <?php endif; ?>
        </div>
        <div id="cmd-delusr" class="col form-section">
          <?php if ($_SESSION['user']->auth_state !== 'admin'): ?>
            <p>You do are not an administrator of this page, contact an administrator to delete users.</p>
          <?php else: ?><form>
            <div class="form-group">
              <label for="exampleFormControlSelect1">Select user to delete:</label>
              <select class="form-control" id="cmd-delusr-uid">
                <option selected disabled>loading...</option>
              </select>
            </div>
            <button id="cmd-delusr-submit" type="submit" class="btn btn-danger">Delete user</button>
          <?php endif; ?>
        </div>
      </form>
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

  <script id="select-option-template" type="text/x-handlebars-template">
    <?php include 'includes/templates/SelectOption.handlebars'; ?>
  </script>

  <script>
  /*
   * TODO mod chk enables form
   * TODO Form submission
   *
   * QUESTION if I can't set the global from the async function, THEN HOW?!?!?!?
   */


  var debug = true;

  var optionTemplate;
  var optionLoading = [{value:'', text:'loading...'}];

  var users;
  var authStates;

  $(function() {
    $(`#cmd-options`).children().click(function(){
      $(this).removeClass(`btn-secondary`).addClass(`btn-primary`);
      $(this).siblings().removeClass(`btn-primary`).addClass(`btn-secondary`);

      $(`#cmd-form`).children().removeClass('current');
      let cmd = $(this).data('cmd');
      $(`#cmd-${cmd}`).addClass('current');
    });

    optionTemplate = Handlebars.compile($("#select-option-template").html());

    getAuthStates(optionTemplate, authStates, optionLoading);
    getUsers(optionTemplate, users, optionLoading);
  });

  function getAuthStates(passedTemplate, aList, defaultList) {
    $.ajax({
      type: 'GET',
      url: 'ajax/ajax_get_auth_states.php',
      data: '',
      beforeSend: function () {
        aList = defaultList;
        setSelectToLoading($('#cmd-addusr-auth-id'), passedTemplate, {entry: aList});
        setSelectToLoading($('#cmd-modusr-auth-id'), passedTemplate, {entry: aList});
      },
      success: function (response) {
        aList = JSON.parse(response);
        if (debug) console.log("AJAX returned, states list:");
        if (debug) console.log(aList);

        //map authStates to appropriate format for makeSelect id->value, state->text
        let mappedStates = $.map(aList, function(e, i) {
                             return {value:e.id, text:e.state};
                           });

        fillSelect($('#cmd-addusr-auth-id'), passedTemplate, {entry: mappedStates});
        fillSelect($('#cmd-modusr-auth-id'), passedTemplate, {entry: mappedStates});
      }
    });
  }

  function getUsers(passedTemplate, uList, defaultList) {
    $.ajax({
      type: 'GET',
      url: 'ajax/ajax_get_users.php',
      data: '',
      beforeSend: function () {
        uList = defaultList;
        setSelectToLoading($('#cmd-delusr-uid'), passedTemplate, {entry: uList});
        setSelectToLoading($('#cmd-modusr-uid'), passedTemplate, {entry: uList});
      },
      success: function (response) {
        uList = JSON.parse(response);
        if (debug) console.log("AJAX returned, user list:");
        if (debug) console.log(uList);

        //map users to appropriate format for makeSelect id->value, login->text
        let mappedUsers = $.map(uList, function(e, i) {
                            return {value:e.id, text:e.login};
                          });

        fillSelect($('#cmd-modusr-uid'), passedTemplate, {entry: mappedUsers});
        fillSelect($('#cmd-delusr-uid'), passedTemplate, {entry: mappedUsers});
      }
    });
  }

  function fillSelect($target, passedTemplate, entryList) {
    $target.empty()
           .append(passedTemplate(entryList));
  }

  function setSelectToLoading($target, passedTemplate, entryList) {
    $target.empty()
           .append(passedTemplate(entryList))
           .children()
           .first()
           .attr('disabled', true)
           .attr('selected', true);
  }
  </script>

  <!-- Footer include -->
  <?php include 'includes/footer.php'; ?>
  <!-- END Footer include -->

</body>

</html>
