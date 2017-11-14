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
        <h2>Modify Staff</h2>
        <hr>
      </div>
    </div>
    <div class="row">
      <div id="container" class="col">
        <form id="modstaff-form">
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
                     name="modstaff-chk[]"
                     value="name"
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
              <input type="text"
                      id="first-name"
                      class="form-control"
                      name="first-name"
                      placeholder="First Name"
                      disabled
                      required
                      minlength="2"
                      data-parsley-error-message="First name is required. Minimum 2 characters.">
              <input type="hidden" id="first-name-original">
            </div>
            <!-- Last Name -->
            <div class="form-group">
              <label for="last-name">Last Name</label>
              <input type="text"
                      class="form-control"
                      id="last-name"
                      name="last-name"
                      placeholder="Last Name"
                      disabled
                      required
                      minlength="2"
                      data-parsley-error-message="Last name is required. Minimum 2 characters.">
              <input type="hidden" id="last-name-original">
            </div>
          </div>

          <div class="p-2 mb-2 border border-secondary">
            <label class="custom-control custom-checkbox">
              <input id="modstaff-category-chk"
                     name="modstaff-chk[]"
                     value="category"
                     type="checkbox"
                     class="custom-control-input">
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">Change this staff's category?</span>
            </label>

            <!-- Category -->
            <div class="form-group">
              <label for="staff-category">Staff Category</label>
              <select class="form-control"
                      id="staff-category"
                      name="staff-category"
                      required
                      disabled>
                <option selected disabled>loading...</option>
              </select>
            </div>

            <input type="hidden" id="staff-category-original">
          </div>

          <div class="p-2 mb-2 border border-secondary">
            <label class="custom-control custom-checkbox">
              <input id="modstaff-activity-chk"
                     name="modstaff-chk[]"
                     value="active"
                     type="checkbox"
                     class="custom-control-input">
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">Change active/inactive?</span>
            </label>
            <!-- Active / Inactive -->
            <div class="form-group">
              <label for="staff-active">Staff Active?</label>
              <select class="form-control"
                      id="staff-active"
                      name="staff-active"
                      disabled>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
            </div>

            <input type="hidden" id="staff-active-original">
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

  //TODO LIST -- Need to handle the response from the mod-staff ajax

  var debug = true;

  var optionTemplate;
  var optionLoading = [{value:'', text:'loading...'}];
  var parsleyConfig = { errorsContainer: "#modstaff-form-errors" };

  //ON DOCUMENT READY START
  $(function() {
  //ON DOCUMENT READY START

    $(`#staff-uid`).change(function() {
      if (debug) console.log(`Handler for .change() called.`);
      getStaff($(`#staff-uid`).val());
    });

    $(`#modstaff-name-chk`).click(function(){
      if ($(this).prop(`checked`)) {
        $(`#first-name`).prop('disabled', false);
        $(`#last-name`).prop('disabled', false);
      } else {
        $(`#first-name`).prop('disabled', true);
        $(`#first-name`).val($(`#first-name-original`).val());

        $(`#last-name`).prop('disabled', true);
        $(`#last-name`).val($(`#last-name-original`).val());
      }
    });

    $(`#modstaff-category-chk`).click(function(){
      if ($(this).prop(`checked`)) {
        $(`#staff-category`).prop('disabled', false);
      } else {
        $(`#staff-category`).prop('disabled', true);

        let prevCategory = $(`#staff-category-original`).val();
        $(`#staff-category option[value='${prevCategory}']`).prop('selected', true);
      }
    });

    $(`#modstaff-activity-chk`).click(function(){
      if ($(this).prop(`checked`)) {
        $(`#staff-active`).prop('disabled', false);
      } else {
        $(`#staff-active`).prop('disabled', true);

        let prevActive = $(`#staff-active-original`).val();
        $(`#staff-active option[value='${prevActive}']`).prop('selected', true);
      }
    });

    optionTemplate = Handlebars.compile($("#select-option-template").html());

    getCategories(optionTemplate, optionLoading);
    getAllStaff(optionTemplate, optionLoading);

    $('#modstaff-form')
    .parsley(parsleyConfig)
    .on('form:submit', function () {
      let data = $('#modstaff-form').serialize();

      if (debug) console.log("Form submitted:");
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
      url: 'ajax/ajax_put_staff.php',
      data: data,
      beforeSend: function () {
        if (debug) console.log("Change submitted:");
        if (debug) console.log(data);
      },
      success: function (response) {
        if (debug) console.log("Change reponse:");
        if (debug) console.log(response);

        if (response.substring(0, 2) === "Ok") {
          getAllStaff(optionTemplate, optionLoading);

          let fname = $(`#first-name`).val();
          let lname = $(`#last-name`).val();

          //display the alert to success
          $('#form-alert').addClass('alert-success');
          $('#form-alert p').html(`<h4>${fname} ${lname} successfully modified!</h4>`);
          $('#alert-container').collapse('show');
          $("#alert-container").focus();

          //set timeout to hide the alert in x milliseconds
          setTimeout(function(){
            $("#alert-container").collapse('hide');

            setTimeout(function(){
              $("#form-alert p").html('');
              $('#form-alert').removeClass('alert-success');
            }, 1000);
          }, 5000);

          $('#modstaff-form').trigger("reset");

          $(`#first-name, #last-name, #staff-category, #staff-active`).prop("disabled", true);
        }
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

    $(`#first-name-original`).val(u.first_name);
    $(`#first-name`).val(u.first_name);

    $(`#last-name-original`).val(u.last_name);
    $(`#last-name`).val(u.last_name);
  }

  function setStaffCategory(user) {
    $(`#staff-category-original`).val(user.category_id);
    $(`#staff-category option[value='${user.category_id}']`).prop('selected', true);
  }

  function setStaffActive(user) {
    $(`#staff-active-original`).val(user.bool_is_active);
    $(`#staff-active option[value='${user.bool_is_active}']`).prop('selected', true);
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

        getStaff($(`#staff-uid option`).first().val());
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
