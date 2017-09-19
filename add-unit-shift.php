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
          <form method="post" id="shift-form" data-parsley-validate>
            <div class="row justify-content-center">
              <div class="col-sm-8">

                <h2>Add Shifts for the Unit</h2>
                <hr />

              </div>
            </div>
            <div class="row justify-content-center">

              <div class="col-sm-8 form-control-feedback hidden" id="shift-form-feedback"></div>

            </div>
            <div class="row justify-content-center">

            </div>
            <div class="row justify-content-center">

              <div class="col-sm-8 form-group">
                <div><button class="btn btn-primary btn-block btn-lg" id="shift-submit" name="btn-submit-new-shift" type="submit" value="validate">Submit</button></div>
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
      <?php if (!$detect->isMobile()): ?>
      $('#date').datepicker({
          format: "yyyy-mm-dd",
          orientation: "bottom auto",
          autoclose: true
      });
      <? endif; ?>
      //Activate the Select2 script for the staff select to search easily
      $("#select-staff").select2();

      //Bind the Role Select Change event to selectively display the checkboxes
      $( "#select-role" ).change(function() {

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
        //IDEA When form submitted, open modal, then...
        //show progressbar
        //loop -> submit each person's shift individually
        //when 

        var data = $('#shift-form').serialize()  + '&btn-submit-new-shift=1';

        $.ajax({
          type: 'POST',
          url: 'ajax/ajax_add_single_shift_process.php',
          data: data,
          beforeSend: function () {
            $('#shift-submit').html('<span class="fa fa-exchange"></span> &nbsp; Attempting ...');
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
              $('#form-alert').addClass('alert-success');
              $('#form-alert p').html('<h4>Shift successfully added!</h4>');
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

              //reset the form, return focus first input of first step

            } else {
              //give feedback if there is a problem with the form
            }

            $('#shift-submit').html('Submit');
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
