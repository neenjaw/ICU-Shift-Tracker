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
          <button type="button" class="btn btn-secondary btn-block" data-cmd="delstaff">Delete Staff</button>
        </div>
      </div>
      <div id="cmd-container" class="col-sm-9">
        <div id="cmd-changepw" class="form-section current">
          <h4>Change Your Password</h4>
          <hr>
          <form id="cmd-changepw-form">
            <input type="hidden" name="cmd-changepw" value="1">
            <div id="cmd-changepw-form-errors">
            </div>
            <div class="form-group">
              <label for="cmd-changepw-old-pw">Old Password</label>
              <input id="cmd-changepw-old-pw"
                     name="old-pw"
                     type="password"
                     class="form-control"
                     placeholder="Old Password"
                     autocomplete="off"
                     required>
            </div>
            <div class="form-group">
              <label for="cmd-changepw-new-pw">New Password</label>
              <input id="cmd-changepw-new-pw"
                     name="new-pw"
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
                     name="rpt-pw"
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
            <h4>Add a New User</h4>
            <hr>
            <form id="cmd-addusr-form">
              <input type="hidden" name="cmd-addusr" value="1">
              <div id="cmd-addusr-form-errors">
              </div>
              <div class="form-group">
                <label for="cmd-addusr-new-username">New Username</label>
                <input id="cmd-addusr-new-username"
                       name="username"
                       type="text"
                       class="form-control"
                       placeholder="Username"
                       data-parsley-pattern="^[a-zA-Z0-9]{4,}$"
                       data-parsley-error-message="New Username must be at least four characters, and only have letters and numbers."
                       required>
              </div>
              <div class="form-group">
                <label for="cmd-addusr-new-pw">New Password</label>
                <input id="cmd-addusr-new-pw"
                       name="new-pw"
                       type="password"
                       class="form-control"
                       placeholder="New Password"
                       autocomplete="off"
                       data-parsley-equalto="#cmd-addusr-rpt-pw"
                       data-parsley-error-message="Passwords don't match."
                       required>
              </div>
              <div class="form-group">
                <label for="cmd-addusr-rpt-pw">Repeat Password</label>
                <input id="cmd-addusr-rpt-pw"
                       name="rpt-pw"
                       type="password"
                       class="form-control"
                       placeholder="Repeat Password"
                       autocomplete="off"
                       data-parsley-equalto="#cmd-addusr-new-pw"
                       data-parsley-error-message="Passwords don't match."
                       required>
              </div>
              <div class="form-group">
                <label for="cmd-addusr-auth-id">App Authorization:</label>
                <select id="cmd-addusr-auth-id"
                        name="state"
                        class="form-control"
                        required>
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
            <h4>Modify a User Entry</h4>
            <hr>
            <form id="cmd-modusr-form">
              <input type="hidden" name="cmd-modusr" value="1">
              <div id="cmd-modusr-form-errors">
              </div>
              <div class="form-group">
                <label for="cmd-modusr-uid">Select user to modify:</label>
                <select id="cmd-modusr-uid"
                        name="userid"
                        class="form-control"
                        required>
                  <option selected disabled>loading...</option>
                </select>
              </div>
              <div class="p-2 mb-2 border border-secondary">
                <label class="custom-control custom-checkbox">
                  <input id="cmd-modusr-chk-pw"
                         name="cmd-moduser-chk"
                         type="checkbox"
                         class="custom-control-input"
                         data-parsley-error-message="You must choose at least one thing to modify."
                         required>
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">Change this user's password?</span>
                </label>
                <div class="form-group">
                  <label for="cmd-modusr-new-pw">New Password</label>
                  <input id="cmd-modusr-new-pw"
                         name="new-pw"
                         type="password"
                         class="form-control"
                         placeholder="New Password"
                         autocomplete="off"
                         data-parsley-equalto="#cmd-modusr-rpt-pw"
                         data-parsley-error-message="Passwords don't match."
                         disabled>
                </div>
                <div class="form-group">
                  <label for="cmd-modusr-rpt-pw">Repeat Password</label>
                  <input id="cmd-modusr-rpt-pw"
                         name="rpt-pw"
                         type="password"
                         class="form-control"
                         placeholder="Repeat Password"
                         autocomplete="off"
                         data-parsley-equalto="#cmd-modusr-new-pw"
                         data-parsley-error-message="Passwords don't match."
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
                  <select id="cmd-modusr-auth-id"
                          name="state"
                          class="form-control"
                          disabled>
                    <option selected disabled>loading...</option>
                  </select>
                </div>
              </div>
              <button id="cmd-modusr-submit" type="submit" class="btn btn-primary">Modify User</button>
            </form>
          <?php endif; ?>
        </div>
        <div id="cmd-delusr" class="form-section">
          <?php if ($_SESSION['user']->auth_state !== 'admin'): ?>
            <p>You do are not an administrator of this page, contact an administrator to delete users.</p>
          <?php else: ?>
            <h4>Delete a User</h4>
            <hr>
            <form id="cmd-delusr-form">
              <input type="hidden" name="cmd-delusr" value="1">
              <div id="cmd-delusr-form-errors">
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect1">Select user to delete:</label>
                <select id="cmd-delusr-uid"
                        name="userid"
                        class="form-control"
                        required>
                  <option selected disabled>loading...</option>
                </select>
              </div>
              <button id="cmd-delusr-submit" type="submit" class="btn btn-danger">Delete user</button>
            </form>
          <?php endif; ?>
        </div>
        <div id="cmd-delstaff" class="form-section">
          <?php if ($_SESSION['user']->auth_state !== 'admin'): ?>
            <p>You do are not an administrator of this page, contact an administrator to delete users.</p>
          <?php else: ?>
            <h4>Delete a Staff</h4>
            <hr>
            <div class="bs-callout bs-callout-danger">
              <h4>Warning:</h4>
              <p>Deleting staff members from the system will also irreversably delete all of their records.</p>
            </div>
            <form id="cmd-delstaff-form">
              <input type="hidden" name="cmd-delstaff" value="1">
              <div id="cmd-delstaff-form-errors">
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect1">Select staff to delete:</label>
                <select id="cmd-delstaff-uid"
                        name="staff-id"
                        class="form-control"
                        required>
                  <option selected disabled>loading...</option>
                </select>
              </div>
              <button id="cmd-delstaff-submit" type="submit" class="btn btn-danger">Delete staff</button>
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

  var debug = true;

  var optionTemplate;
  var optionLoading = [{value:'', text:'loading...'}];
  var parsleyConfigChg = { errorsContainer: "#cmd-changepw-form-errors" };
  var parsleyConfigAdd = { errorsContainer: "#cmd-addusr-form-errors" };
  var parsleyConfigMod = { errorsContainer: "#cmd-modusr-form-errors" };
  var parsleyConfigDel = { errorsContainer: "#cmd-delusr-form-errors" };
  var parsleyConfigDelStaff = { errorsContainer: "#cmd-delstaff-form-errors" };

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
    getAllStaff(optionTemplate, optionLoading);

    $('#cmd-changepw-form')
    .parsley(parsleyConfigChg)
    .on('form:submit', function () {
      if (debug) console.log(`Change password:`);

      let data = $(`#cmd-changepw-form`).serialize();
      if (debug) console.log(data);

      submitConfig(data);

      return false;
    });

    $('#cmd-addusr-form')
    .parsley(parsleyConfigAdd)
    .on('form:submit', function () {
      if (debug) console.log(`Add User:`);

      let data = $(`#cmd-addusr-form`).serialize();
      if (debug) console.log(data);

      submitConfig(data);

      return false;
    });

    $('#cmd-modusr-form')
    .parsley(parsleyConfigMod)
    .on('form:submit', function () {
      if (debug) console.log(`Modify User:`);

      let data = $(`#cmd-modusr-form`).serialize();
      if (debug) console.log(data);

      submitConfig(data);

      return false;
    });

    $(`#cmd-delusr-form`)
    .parsley(parsleyConfigDel)
    .on('form:submit', function () {
      if (debug) console.log(`Delete User:`);

      let data = $(`#cmd-delusr-form`).serialize();
      if (debug) console.log(data);

      submitConfig(data);

      return false;
    });

    $(`#cmd-delstaff-form`)
    .parsley(parsleyConfigDelStaff)
    .on('form:submit', function () {
      if (debug) console.log(`Delete Staff:`);

      let data = $(`#cmd-delstaff-form`).serialize();
      if (debug) console.log(data);

      data = `cmd-submit=1&${data}`;

      $.ajax({
        type: 'POST',
        url: 'ajax/ajax_put_staff.php',
        data: data,
        beforeSend: function () {
          if (debug) console.log("Delete staff submitted:");
          if (debug) console.log(data);
        },
        success: function (response) {
          if (debug) console.log("Delete staff reponse:");
          if (debug) console.log(response);

          if (response.substring(0, 2) === "Ok") {
            if (debug) console.log("Staff deleted.");
            getAllStaff(optionTemplate, optionLoading);
          } else {
            if (debug) console.log("Staff not deleted.");
          }
        }
      });

      return false;
    });

  //ON DOCUMENT READY END
  });
  //ON DOCUMENT READY END

  function submitConfig(data) {
    $.ajax({
      type: 'POST',
      url: 'ajax/ajax_post_config.php',
      data: `cmd-submit=1&${data}`,
      beforeSend: function () {
        if (debug) console.log("Change submitted:");
        if (debug) console.log(data);
      },
      success: function (response) {
        if (debug) console.log("Change reponse:");
        if (debug) console.log(response);

        if (response.substring(0, 2) === "Ok") {
          alertPop(response);
          getUsers(optionTemplate, optionLoading);
          $(`#cmd-delusr-form, #cmd-modusr-form, #cmd-addusr-form, #cmd-changepw-form`).trigger('reset');
        }
      }
    });
  }

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

  function getAllStaff(pTemplate, defaultList) {
    $.ajax({
      type: 'POST',
      url: 'ajax/ajax_get_staff.php',
      data: '',
      beforeSend: function () {
        setSelectToLoading($('#cmd-delstaff-uid'), pTemplate, {entry: defaultList});
      },
      success: function (response) {
        let ul = JSON.parse(response);
        if (debug) console.log("AJAX returned, user list:");
        if (debug) console.log(ul);

        //map users to appropriate format for makeSelect id->value, names->text
        let mappedUsers = $.map(ul, function(e, i) {
                            return {value: e.id, text: `${e.last_name}, ${e.first_name}`};
                          });

        fillSelect($('#cmd-delstaff-uid'), pTemplate, {entry: mappedUsers});
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

  function alertPop(message, showDuration = 5000, classDuration = 1000) {
    //display the alert to success
    $('#form-alert').addClass('alert-success');
    $('#form-alert p').html(`<h4>${message}</h4>`);
    $('#alert-container').collapse('show');
    $("#alert-container").focus();

    //set timeout to hide the alert in x milliseconds
    setTimeout(function(){
      $("#alert-container").collapse('hide');

      setTimeout(function(){
        $("#form-alert p").html('');
        $('#form-alert').removeClass('alert-success');
      }, classDuration);
    }, showDuration);
  }

  </script>

  <!-- Footer include -->
  <?php include 'includes/footer.php'; ?>
  <!-- END Footer include -->

</body>

</html>
