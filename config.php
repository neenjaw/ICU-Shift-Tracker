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
    <div class="row">
      <div class="col-sm-3">
        <div id='cmd-options' class="btn-group-vertical mt-3 mb-3" role="group" aria-label="First group">
          <button type="button" class="btn btn-primary btn-block" data-cmd="changepw">Change Password</button>
          <button type="button" class="btn btn-secondary btn-block" data-cmd="addusr">Add a user</button>
          <button type="button" class="btn btn-secondary btn-block" data-cmd="modusr">Modify User</button>
          <button type="button" class="btn btn-secondary btn-block" data-cmd="delusr">Delete User</button>
        </div>
      </div>
      <div id="cmd-container" class="col-sm-9">
        <div id="cmd-changepw" class="form-section current">
          <form id="cmd-changepw-form">
            <div id="cmd-changepw-form-errors">
            </div>
            <div class="form-group">
              <label for="cmd-changepw-old-pw">Old Password</label>
              <input id="cmd-changepw-old-pw"
                     type="password"
                     class="form-control"
                     placeholder="Old Password"
                     autocomplete="off"
                     required>
            </div>
            <div class="form-group">
              <label for="cmd-changepw-new-pw">New Password</label>
              <input id="cmd-changepw-new-pw"
                     type="password"
                     class="form-control"
                     placeholder="New Password"
                     autocomplete="off"
                     data-parsley-equalto="#cmd-changepw-rpt-pw"
                     required>
            </div>
            <div class="form-group">
              <label for="cmd-changepw-rpt-pw">Repeat Password</label>
              <input id="cmd-changepw-rpt-pw"
                     type="password"
                     class="form-control"
                     placeholder="Repeat Password"
                     autocomplete="off"
                     data-parsley-equalto="#cmd-changepw-new-pw"
                     required>
            </div>
            <button id="cmd-changepw-submit" type="submit" class="btn btn-primary">Change Password</button>
          </form>
        </div>
        <div id="cmd-addusr" class="form-section">
          <?php if ($_SESSION['user']->auth_state !== 'admin'): ?>
            <p>You do are not an administrator of this page, contact an administrator to add users.</p>
          <?php else: ?>
            <form id="cmd-addusr-form">
              <div id="cmd-addusr-form-errors">
              </div>
              <div class="form-group">
                <label for="cmd-addusr-new-username">New Username</label>
                <input type="text" class="form-control" id="cmd-addusr-new-username" placeholder="Username" required>
              </div>
              <div class="form-group">
                <label for="cmd-addusr-new-pw">New Password</label>
                <input type="password" class="form-control" id="cmd-addusr-new-pw" placeholder="New Password" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label for="cmd-addusr-rpt-pw">Repeat Password</label>
                <input type="password" class="form-control" id="cmd-addusr-rpt-pw" placeholder="Repeat Password" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label for="cmd-addusr-auth-id">App Authorization:</label>
                <select class="form-control" id="cmd-addusr-auth-id" required>
                  <option selected disabled>loading...</option>
                </select>
              </div>
              <button id="cmd-addusr-submit" type="submit" class="btn btn-primary">Add New User</button>
            </form>
          <?php endif; ?>
        </div>
        <div id="cmd-modusr" class="form-section">
          <?php if ($_SESSION['user']->auth_state !== 'admin'): ?>
            <p>You do are not an administrator of this page, contact an administrator to modify users.</p>
          <?php else: ?>
            <form id="cmd-modusr-form">
              <div id="cmd-modusr-form-errors">
              </div>
              <div class="form-group">
                <label for="cmd-modusr-uid">Select user to modify:</label>
                <select class="form-control" id="cmd-modusr-uid" required>
                  <option selected disabled>loading...</option>
                </select>
              </div>
              <div class="p-2 mb-2 border border-secondary">
                <label class="custom-control custom-checkbox">
                  <input id="cmd-modusr-chk-pw"
                         name="cmd-moduser-chk"
                         type="checkbox"
                         class="custom-control-input"
                         required>
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">Change this user's password?</span>
                </label>
                <div class="form-group">
                  <label for="cmd-modusr-new-pw">New Password</label>
                  <input id="cmd-modusr-new-pw"
                         type="password"
                         class="form-control"
                         placeholder="New Password"
                         autocomplete="off"
                         data-parsley-equalto="#cmd-modusr-rpt-pw"
                         disabled>
                </div>
                <div class="form-group">
                  <label for="cmd-modusr-rpt-pw">Repeat Password</label>
                  <input id="cmd-modusr-rpt-pw"
                         type="password"
                         class="form-control"
                         placeholder="Repeat Password"
                         autocomplete="off"
                         data-parsley-equalto="#cmd-modusr-new-pw"
                         disabled>
                </div>
              </div>
              <div class="p-2 mb-2 border border-secondary">
                <label class="custom-control custom-checkbox">
                  <input id="cmd-modusr-chk-auth"
                         name="cmd-moduser-chk"
                         type="checkbox"
                         class="custom-control-input">
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
            </form>
          <?php endif; ?>
        </div>
        <div id="cmd-delusr" class="form-section">
          <?php if ($_SESSION['user']->auth_state !== 'admin'): ?>
            <p>You do are not an administrator of this page, contact an administrator to delete users.</p>
          <?php else: ?>
            <form id="cmd-delusr-form">
              <div id="cmd-delusr-form-errors">
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect1">Select user to delete:</label>
                <select class="form-control" id="cmd-delusr-uid" required>
                  <option selected disabled>loading...</option>
                </select>
              </div>
              <button id="cmd-delusr-submit" type="submit" class="btn btn-danger">Delete user</button>
            </form>
          <?php endif; ?>
        </div>
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

  <script id="select-option-template" type="text/x-handlebars-template">
    <?php include 'includes/templates/SelectOption.handlebars'; ?>
  </script>

  <script>
  /*
   * TODO Form validation and submission
   * TODO add in form error messages
   */


  var debug = true;

  var optionTemplate;
  var optionLoading = [{value:'', text:'loading...'}];
  var parsleyConfigChg = { errorsContainer: "#cmd-changepw-form-errors" };
  var parsleyConfigAdd = { errorsContainer: "#cmd-addusr-form-errors" };
  var parsleyConfigMod = { errorsContainer: "#cmd-modusr-form-errors" };
  var parsleyConfigDel = { errorsContainer: "#cmd-delusr-form-errors" };

  //ON DOCUMENT READY START
  $(function() {
  //ON DOCUMENT READY START

    $(`#cmd-options`).children().click(function(){
      $(this).removeClass(`btn-secondary`).addClass(`btn-primary`);
      $(this).siblings().removeClass(`btn-primary`).addClass(`btn-secondary`);

      $(`#cmd-container`).children().removeClass('current');
      let cmd = $(this).data('cmd');
      $(`#cmd-${cmd}`).addClass('current');
    });

    $(`#cmd-modusr-chk-pw`).click(function(){
      if ($(this).prop(`checked`)) {
        $(`#cmd-modusr-new-pw`).prop(`disabled`, false);
        $(`#cmd-modusr-rpt-pw`).prop(`disabled`, false);

        $(`#cmd-modusr-new-pw`).prop(`required`, true);
        $(`#cmd-modusr-rpt-pw`).prop(`required`, true);
      } else {
        $(`#cmd-modusr-new-pw`).prop(`required`, false);
        $(`#cmd-modusr-rpt-pw`).prop(`required`, false);

        $(`#cmd-modusr-new-pw`).prop(`disabled`, true);
        $(`#cmd-modusr-rpt-pw`).prop(`disabled`, true);

        $(`#cmd-modusr-new-pw`).prop(`value`, ``);
        $(`#cmd-modusr-rpt-pw`).prop(`value`, ``);
      }
    });

    $(`#cmd-modusr-chk-auth`).click(function(){
      if ($(this).prop(`checked`)) {
        $(`#cmd-modusr-auth-id`).prop(`disabled`, false);
        $(`#cmd-modusr-auth-id`).prop(`required`, true);
      } else {
        $(`#cmd-modusr-auth-id`).prop(`disabled`, true);
        $(`#cmd-modusr-auth-id`).prop(`required`, false);
        $(`#cmd-modusr-auth-id`).prop(`value`, ``);
      }
    });

    optionTemplate = Handlebars.compile($("#select-option-template").html());

    getAuthStates(optionTemplate, optionLoading);
    getUsers(optionTemplate, optionLoading);

    $('#cmd-changepw-form')
    .parsley(parsleyConfigChg)
    .on('form:submit', function () {
      alert("Change pw");
      return false;
    });

    $('#cmd-addusr-form')
    .parsley(parsleyConfigAdd)
    .on('form:submit', function () {
      alert("addusr");
      return false;
    });

    $('#cmd-modusr-form')
    .parsley(parsleyConfigMod)
    .on('form:submit', function () {
      alert("moduser");
      return false;
    });

    $(`#cmd-delusr-form`)
    .parsley(parsleyConfigDel)
    .on('form:submit', function () {
      alert("deluser");
      return false;
    });

  //ON DOCUMENT READY END
  });
  //ON DOCUMENT READY END

  function getAuthStates(pTemplate, defaultList) {
    $.ajax({
      type: 'GET',
      url: 'ajax/ajax_get_auth_states.php',
      data: '',
      beforeSend: function () {
        setSelectToLoading($('#cmd-addusr-auth-id'), pTemplate, {entry: defaultList});
        setSelectToLoading($('#cmd-modusr-auth-id'), pTemplate, {entry: defaultList});
      },
      success: function (response) {
        let al = JSON.parse(response);
        if (debug) console.log("AJAX returned, states list:");
        if (debug) console.log(al);

        //map authStates to appropriate format for makeSelect id->value, state->text
        let mappedStates = $.map(al, function(e, i) {
                             return {value:e.id, text:e.state};
                           });

        fillSelect($('#cmd-addusr-auth-id'), pTemplate, {entry: mappedStates});
        fillSelect($('#cmd-modusr-auth-id'), pTemplate, {entry: mappedStates});
      }
    });
  }

  function getUsers(pTemplate, defaultList) {
    $.ajax({
      type: 'GET',
      url: 'ajax/ajax_get_users.php',
      data: '',
      beforeSend: function () {
        setSelectToLoading($('#cmd-delusr-uid'), pTemplate, {entry: defaultList});
        setSelectToLoading($('#cmd-modusr-uid'), pTemplate, {entry: defaultList});
      },
      success: function (response) {
        let ul = JSON.parse(response);
        if (debug) console.log("AJAX returned, user list:");
        if (debug) console.log(ul);

        //map users to appropriate format for makeSelect id->value, login->text
        let mappedUsers = $.map(ul, function(e, i) {
                            return {value:e.id, text:e.login};
                          });

        fillSelect($('#cmd-modusr-uid'), pTemplate, {entry: mappedUsers});
        fillSelect($('#cmd-delusr-uid'), pTemplate, {entry: mappedUsers});
      }
    });
  }

  function fillSelect($target, pTemplate, entryList) {
    $target.empty()
           .append(pTemplate(entryList));
  }

  function setSelectToLoading($target, pTemplate, entryList) {
    $target.empty()
           .append(pTemplate(entryList))
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
