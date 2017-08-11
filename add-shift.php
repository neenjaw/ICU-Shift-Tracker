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

  <div class="container">
    <div class="row">
      <div class="col-12">
        <!-- NAV include -->
<?php include 'includes/nav-menu.php' ?>
        <!-- END NAV include -->
      </div>
    </div>
    <div class="row justify-content-md-center">
      <div class="col-12 col-md-auto">
        <br>
        <!-- Main Content -->

        <div class="container">
          <form method="post" id="shift-form">
            <div class="row justify-content-center">
              <div class="col-sm-8">

                <h2>Add a new Shift</h2>
                <hr />

              </div>
            </div>
            <div class="row justify-content-center">

              <div class="col-sm-8 form-control-feedback hidden" id="shift-form-feedback"></div>

            </div>

            <div class="row justify-content-center">

              <div class="col-sm-8 form-group">
                <label class="control-label requiredField" for="select">Select a Staff for the shift:<span class="asteriskField">*</span></label>
                <select class="select form-control" id="select-staff" name="staff">
                  <!--<option value="staff_id">Last, Name - RN</option>-->
                  <option value="" disabled selected hidden>Please Choose...</option>
<?php
//Build Staff Select List
//use the CRUD object to access the database and build an option list of the categories
$form_select_staff = $crud->getAllStaff();
foreach ($form_select_staff as $k => $v) {?>
                  <option value="<?php echo ($k); ?>"><?php echo ($v); ?></option>
<?php }
//END Build Staff Select List
?>
                </select>
              </div>

            </div>
            <div class="row justify-content-center">

              <div class="col-sm-8 form-group">
                <label class="control-label requiredField" for="date">Date<span class="asteriskField">*</span></label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input class="form-control" id="date" name="date" placeholder="YYYY/MM/DD" value="<?php echo date('Y-m-d'); ?>" type="<?php echo (($detect->isMobile()) ? 'date' : 'text'); ?>"/>
                </div>
              </div>

            </div>
            <div class="row justify-content-center">

              <div class="col-sm-8 btn-group requiredField" data-toggle="buttons">
                <label class="btn btn-outline-primary active"><input type="radio" name="d-or-n" id="radio-d-or-n-d" value="D" autocomplete="off" checked>Day</label>
                <label class="btn btn-outline-primary"><input type="radio" name="d-or-n" id="radio-d-or-n-n" value="N" autocomplete="off">Night</label>
              </div>

            </div>
            <div class="row justify-content-center">

              <div class="col-sm-8 form-group">
                <label class="control-label requiredField" for="select1">Role<span class="asteriskField">*</span></label>
                <select class="select form-control" id="select-role" name="role">
<?php
//Build Staff Role List
//use the CRUD object to access the database and build an option list of the categories
$form_select_role = $crud->getAllRoles();
foreach ($form_select_role as $k => $v) {?>
                  <option value="<?php echo ($k); ?>"><?php echo ($v); ?></option>
<?php }
//END Build Role Select List
?>
                </select>
              </div>

            </div>
            <div class="row justify-content-center">

              <div class="col-sm-8 form-group">
                <label class="control-label requiredField" for="select2">Pod Assignment<span class="asteriskField">*</span></label>
                <select class="select form-control" id="select-assignment" name="assignment">
                  <option value="" disabled selected hidden>Please Choose...</option>
<?php
//Build Assignment Select List
//use the CRUD object to access the database and build an option list of the categories
$form_select_assignment = $crud->getAllAssignments();
foreach ($form_select_assignment as $k => $v) {?>
                  <option value="<?php echo ($k); ?>"><?php echo ($v); ?></option>
<?php }
//END Build Assignment Select List
?>
                </select>
              </div>

            </div>
            <div class="row justify-content-center">

              <div class="col-sm-8 form-group collapse show" id="check-box-group">
                <label class="control-label">Check all that apply</label>
                <div class="checkbox"><label class="custom-control custom-checkbox"><input name="ck-nonvent" class="custom-control-input" type="checkbox" value="NV"/><span class="custom-control-indicator"></span><span class="custom-control-description">Non-vented?</span></label></div>
                <div class="checkbox"><label class="custom-control custom-checkbox"><input name="ck-doubled" class="custom-control-input" type="checkbox" value="D"/><span class="custom-control-indicator"></span><span class="custom-control-description">Doubled?</span></label></div>
                <div class="checkbox"><label class="custom-control custom-checkbox"><input name="ck-admit" class="custom-control-input" type="checkbox" value="A"/><span class="custom-control-indicator"></span><span class="custom-control-description">Admitted?</span></label></div>
                <div class="checkbox"><label class="custom-control custom-checkbox"><input name="ck-codepg" class="custom-control-input" type="checkbox" value="P"/><span class="custom-control-indicator"></span><span class="custom-control-description">Code pager?</span></label></div>
                <div class="checkbox"><label class="custom-control custom-checkbox"><input name="ck-vsick" class="custom-control-input" type="checkbox" value="VS"/><span class="custom-control-indicator"></span><span class="custom-control-description">Very sick?</span></label></div>
                <div class="checkbox"><label class="custom-control custom-checkbox"><input name="ck-crrt" class="custom-control-input" type="checkbox" value="C"/><span class="custom-control-indicator"></span><span class="custom-control-description">CRRT?</span></label></div>
                <div class="checkbox"><label class="custom-control custom-checkbox"><input name="ck-evd" class="custom-control-input" type="checkbox" value="E"/><span class="custom-control-indicator"></span><span class="custom-control-description">EVD?</span></label></div>
                <div class="checkbox"><label class="custom-control custom-checkbox"><input name="ck-burn" class="custom-control-input" type="checkbox" value="B"/><span class="custom-control-indicator"></span><span class="custom-control-description">Burn?</span></label></div>
              </div>

            </div>
            <div class="row justify-content-center">

              <div class="col-sm-8 form-group">
                <div><button class="btn btn-primary btn-block btn-lg" name="btn-submit-new-shift" type="submit">Submit</button></div>
              </div>

            </div>
          </form>
        </div>


        <!-- END Main Content -->
      </div>
    </div>
  </div>

  <!-- Spacer for the bottom -->
  <div class="container">
    <br />
    <br />
    <br />
  </div>
  <!-- Spacer for the bottom -->

  <!-- Prefooter Include -->
<?php include 'includes/script-include.php'; ?>
  <!-- END Prefooter Include -->

  <!-- Aux Scripts -->
  <script>
    $(function() {
<?php if (!$detect->isMobile()) { ?>
      $('#date').datepicker({
          format: "yyyy-mm-dd",
          orientation: "bottom auto",
          autoclose: true
      });
<?php } ?>
      //Activate the Select2 script for the staff select to search easily
      $("#select-staff").select2();

      //Bind the Role Select Change event to selectively display the checkboxes
      $( "#select-role" ).change(function() {
        //alert( "Handler called: value: " + $(this).val() + " text: " + $("#select-role option:selected").text() );
        var selectVal = $(this).val();
        switch(selectVal) {
          case "5": //If the bedside role is selected, then show the checkboxes
            $("#check-box-group").collapse('show');
            break;
          default: //else hide them
            $("#check-box-group").collapse('hide');
        }
      });

      //bind the parsley.js event
      $('#shift-form')
      .parsley({errorClass: "form-control-danger", successClass: "form-control-success"})
      .on('field:validated', function (e) {
        //customize Parsely.js for Bootstrap 4
        if (e.validationResult.constructor!==Array) {
          this.$element.closest('.form-group').removeClass('has-danger').addClass('has-success');
        } else {
          this.$element.closest('.form-group').removeClass('has-success').addClass('has-danger');
        }
      })
      .on('form:submit', function () {
        var data = $('#shift-form').serialize();
        console.log(data + '&btn-submit-new-shift=1');
        $.ajax({
          type: 'POST',
          url: 'ajax/ajax_add_single_shift_process.php',
          data: data,
          beforeSend: function () {
            $('#btn-submit-new-shift').html('<span class="fa fa-transfer"></span> &nbsp; Attempting ...');
          },
          success: function (response) {
            console.log(response);

            if (response == "ok") {
              //clear the feedback message
              $('#shift-form-feedback').html('');

              //clear the form group classes
              $('.form-group').each(function(){
                $(this).removeClass('has-danger').removeClass('has-success');
              });

              //clear the form control classes
              $('.form-control-danger').each(function(){ $(this).removeClass('form-control-danger'); });
              $('.form-control-success').each(function(){ $(this).removeClass('form-control-success'); });

              //display the alert to success
              //$('#form-alert').addClass('alert-success');
              //$('#form-alert p').html('<h4>Staff successfully added!</h4>');
              //$('#form-alert').show();

              //set timeout to hide the alert in x milliseconds
              //setTimeout(function(){
              //  $("#form-alert").hide();
              //  $("#form-alert p").html('');
              //  $('#form-alert').removeClass('alert-success');
              //}, 5000);

              //reset the form, return focus to first name
              $('#shift-form').trigger('reset');
              $("#select-staff").focus()

            } else {

              $('#staff-name-group-feedback').html('<span class="fa fa-info-circle"></span> &nbsp; There is a problem with this entry.');

              //feedback logic for form submission
            }

            $('#btn-submit-new-shift').html('Submit');
          }
        });

        return false;
      });

    });
  </script>
  <!-- END Aux Scripts -->

  <!-- Footer Include -->
<?php include 'includes/footer.php'; ?>
  <!-- END Footer Include -->

</body>

</html>
