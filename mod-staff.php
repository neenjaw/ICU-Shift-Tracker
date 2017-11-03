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
        <h2>Modify / Delete Staff</h2>
      </div>
    </div>
    <div class="row">
      <div id="container" class="col">
        <h4>Modify a Staff Entry</h4>
        <hr>
        <form id="modstaff-form">
          <input type="hidden" name="modstaff" value="1">

          <div id="modstaff-form-errors">
          </div>

          <div class="form-group">
            <label for="staff-uid">Select user to modify:</label>
            <select id="staff-uid"
                    name="staff-id"
                    class="form-control"
                    required>
              <option selected disabled>loading...</option>
            </select>
          </div>

          <div class="p-2 mb-2 border border-secondary">
            <label class="custom-control custom-checkbox">
              <input id="modstaff-name-chk"
                     name="modstaff-chk"
                     type="checkbox"
                     class="custom-control-input"
                     data-parsley-error-message="You must choose at least one thing to modify."
                     required>
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">Change this staff's name?</span>
            </label>
            <!-- First Name -->
            <div class="form-group">
              <label for="first-name">First Name</label>
              <input type="text" class="form-control" id="first-name" name="first-name" placeholder="First Name" disabled>
            </div>
            <!-- Last Name -->
            <div class="form-group">
              <label for="last-name">Last Name</label>
              <input type="text" class="form-control" id="last-name" name="last-name" placeholder="Last Name" disabled>
            </div>
          </div>

          <div class="p-2 mb-2 border border-secondary">
            <label class="custom-control custom-checkbox">
              <input id="modstaff-category-chk"
                     name="modstaff-chk"
                     type="checkbox"
                     class="custom-control-input">
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">Change this staff's category?</span>
            </label>
            <!-- Category -->
            <div class="form-group">
              <label for="staff-category">Staff Category</label>
              <select class="form-control" id="staff-category" name="staff-category" disabled>
                <option selected disabled>loading...</option>
              </select>
            </div>
          </div>

          <div class="p-2 mb-2 border border-secondary">
            <label class="custom-control custom-checkbox">
              <input id="modstaff-activity-chk"
                     name="modstaff-chk"
                     type="checkbox"
                     class="custom-control-input">
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">Change active/inactive?</span>
            </label>
            <!-- Active / Inactive -->
            <div class="form-group">
              <label for="staff-active">Staff Active?</label>
              <select class="form-control" id="staff-active" name="staff-active" disabled>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
            </div>
          </div>

          <button id="cmd-modusr-submit" type="submit" class="btn btn-primary">Modify Staff</button>

        </form>
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

  //TODO LIST -- Got the user, need to uupdate the name and category to match the user selected
  //TODO      -- Adapt the checkbox enable disable

  var debug = true;

  var optionTemplate;
  var optionLoading = [{value:'', text:'loading...'}];
  var parsleyConfigChg = { errorsContainer: "#modstaff-form-errors" };

  //ON DOCUMENT READY START
  $(function() {
  //ON DOCUMENT READY START

    //TODO adapt this one....
    // $(`#cmd-modusr-chk-auth`).click(function(){
    //   if ($(this).prop(`checked`)) {
    //     $(`#cmd-modusr-auth-id`).prop(`disabled`, false);
    //     $(`#cmd-modusr-auth-id`).prop(`required`, true);
    //   } else {
    //     $(`#cmd-modusr-auth-id`).prop(`disabled`, true);
    //     $(`#cmd-modusr-auth-id`).prop(`required`, false);
    //     $(`#cmd-modusr-auth-id`).prop(`value`, ``);
    //   }
    // });
    $(`#staff-uid`).change(function() {
      if (debug) console.log(`Handler for .change() called.`);
      getStaff($(`#staff-uid`).val());
    });
    $(`#modstaff-name-chk`).click(function(){
      //TODO finish
    });
    $(`#modstaff-category-chk`).click(function(){
      //TODO finish
    });
    $(`#modstaff-activity-chk`).click(function(){
      //TODO finish
    });

    optionTemplate = Handlebars.compile($("#select-option-template").html());

    getCategories(optionTemplate, optionLoading);
    getAllStaff(optionTemplate, optionLoading);

    $('#modstaff-form')
    .parsley(parsleyConfigChg)
    .on('form:submit', function () {
      if (debug) console.log(`Mod Staff:`);

      let data = $(`#cmd-changepw-form`).serialize();
      if (debug) console.log(data);

      submitModStaff(data);

      return false;
    });

  //ON DOCUMENT READY END
  });
  //ON DOCUMENT READY END

  function submitModStaff(data) {
    $.ajax({
      type: 'POST',
      url: 'ajax/ajax_mod_staff.php',
      data: data,
      beforeSend: function () {
        if (debug) console.log("Change submitted:");
        if (debug) console.log(data);
      },
      success: function (response) {
        if (debug) console.log("Change reponse:");
        if (debug) console.log(response);
      }
    });
  }

  function getStaff(uid) {
    let data = `uid=${uid}`;

    $.ajax({
      type: 'POST',
      url: 'ajax/ajax_get_staff.php',
      data: data,
      beforeSend: function () {
        if (debug) console.log("Uid submitted:");
        if (debug) console.log(data);
      },
      success: function (response) {
        let user = JSON.parse(response);

        if (debug) console.log("Staff reponse:");
        if (debug) console.log(user);

        setStaffName(user);
        setStaffCategory(user);
        setStaffActive(user);
      }
    });
  }

  function setStaffName(user) {
    let u = user || {};
    u.last_name = user.last_name || '';
    u.first_name = user.first_name || '';

    return null;
  }

  function setStaffCategory(user) {
    return null;
  }

  function setStaffActive(user) {
    return null;
  }

  function getAllStaff(pTemplate, defaultList) {
    $.ajax({
      type: 'POST',
      url: 'ajax/ajax_get_staff.php',
      data: '',
      beforeSend: function () {
        setSelectToLoading($('#staff-uid'), pTemplate, {entry: defaultList});
      },
      success: function (response) {
        let ul = JSON.parse(response);
        if (debug) console.log("AJAX returned, user list:");
        if (debug) console.log(ul);

        //map users to appropriate format for makeSelect id->value, names->text
        let mappedUsers = $.map(ul, function(e, i) {
                            return {value: e.id, text: `${e.last_name}, ${e.first_name}`};
                          });

        fillSelect($('#staff-uid'), pTemplate, {entry: mappedUsers});
      }
    });
  }

  function getCategories(pTemplate, defaultList) {
    let data = `category=all`;

    $.ajax({
      type: 'POST',
      url: 'ajax/ajax_get_staff.php',
      data: data,
      beforeSend: function () {
        if (debug) console.log("AJAX called, data sent:");
        if (debug) console.log(data);

        setSelectToLoading($('#staff-category'), pTemplate, {entry: defaultList});
      },
      success: function (response) {
        let cl = JSON.parse(response);
        if (debug) console.log("AJAX returned, category list:");
        if (debug) console.log(cl);

        //map users to appropriate format for makeSelect id->value, names->text
        let mappedCategories = $.map(cl, function(e, i) {
                                 return {value: e.id, text: e.category};
                               });

        fillSelect($('#staff-category'), pTemplate, {entry: mappedCategories});
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
