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
    <div class="row justify-content-center">
      <div class="col-12">

        <!-- Main Content -->

        <div class="container">
          <div class="row justify-content-center">
            <div class="col-8">
              <h2>Add Shifts for the Unit</h2>
              <hr />
            </div>
          </div>
          <div class="row justify-content-center">

            <!-- Alert Feedback -->
            <div id="shift-form-feedback" class="col-8 form-control-feedback hidden">
            </div>

          </div>
          <div class="row justify-content-center">
            <div id="msf-container" class="col-sm-8">
              <!-- Multi-step form goes here -->

              <form class="demo-form">
                <div class="form-section">
                  <!-- DATE SELECT -->
                  <div class="form-group">
                    <label class="control-label requiredField" for="date">Date<span class="asteriskField">*</span></label>
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                      <input class="form-control" id="date" name="date" placeholder="YYYY/MM/DD" value="<?php echo date('Y-m-d'); ?>" type="<?php echo (($detect->isMobile()) ? 'date' : 'text'); ?>" required>
                    </div>
                  </div>

                  <!-- DAY / NIGHT SELECT -->
                  <div class="btn-group requiredField" data-toggle="buttons">
                    <label class="btn btn-outline-primary active"><input type="radio" name="d-or-n" id="radio-d-or-n-d" value="D" autocomplete="off" checked required>Day</label>
                    <label class="btn btn-outline-primary"><input type="radio" name="d-or-n" id="radio-d-or-n-n" value="N" autocomplete="off">Night</label>
                  </div>
                </div>

                <!-- TODO start adding the rest of the form elements
                TODO add in the bootstrap handling
                TODO add in the ajax to submit them all -->
                <div class="form-section">
                <!-- Select Clinician/Charge -->
                <!-- Assign Pods -->
                </div>
                </div>

                <div class="form-section">
                <!-- Select Bedside Nurses for A -->
                </div>
                </div>

                <div class="form-section">
                <!-- Select Bedside Nurses for B -->
                </div>
                </div>

                <div class="form-section">
                <!-- Select Bedside Nurses for C -->
                </div>
                </div>

                <div class="form-section">
                <!-- Who had non-vent -->
                </div>
                </div>

                <div class="form-section">
                <!-- Who had double -->
                </div>

                <div class="form-section">
                <!-- Who admitted -->
                </div>

                <div class="form-section">
                <!-- Who had very sick -->
                </div>

                <div class="form-section">
                <!-- Who had code pager -->
                </div>

                <div class="form-section">
                <!-- Who had crrt -->
                </div>

                <div class="form-section">
                <!-- Who had evd -->
                </div>

                <div class="form-section">
                <!-- Who who had burn -->
                </div>

                <div class="form-section">
                <!-- Select NA's -->
                <!-- Assign Pods -->
                </div>

                <div class="form-section">
                <!-- Select UC's -->
                <!-- Assign Pods -->
                </div>

                <div class="form-navigation clearfix">
                  <button type="button" class="previous btn btn-secondary float-left">&lt; Previous</button>
                  <button type="button" class="next btn btn-secondary float-right">Next &gt;</button>
                  <input type="submit" class="btn btn-primary float-right">
                </div>
              </form>

            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-8">
            <!-- Progess bar -->
            <div class="progress">
              <div id="step-progress" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <p id="step-x-of-y" class="text-center"></p>
          </div>
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
    //TODO Bind to the window, so that if user tries to back out while form is dirty, then prompts to ask
    $(function() {

      <?php if (!$detect->isMobile()): ?>
      $('#date').datepicker({
          format: "yyyy-mm-dd",
          orientation: "bottom auto",
          autoclose: true
      });
      <?php endif; ?>

      //Activate the Select2 script for the staff select to search easily
      $("#select-staff").select2();

      //bind the parsley.js event
      // $('#unit-shift-form')
      // .parsley({errorClass: "form-control-danger", successClass: "form-control-success"})
      // .on('field:validated', function (e) {
      //   //customize Parsely.js for Bootstrap 4
      //   if (e.validationResult.constructor!==Array) {
      //     this.$element.closest('.form-group').removeClass('has-danger').addClass('has-success');
      //   } else {
      //     this.$element.closest('.form-group').removeClass('has-success').addClass('has-danger');
      //   }
      // })
      var $sections = $('.form-section');

      function navigateTo(index) {
        // Mark the current section with the class 'current'
        $sections
        .removeClass('current')
        .eq(index)
        .addClass('current');
        // Show only the navigation buttons that make sense for the current section:
        $('.form-navigation .previous').toggle(index > 0);
        var atTheEnd = index >= $sections.length - 1;
        $('.form-navigation .next').toggle(!atTheEnd);
        $('.form-navigation [type=submit]').toggle(atTheEnd);

        var progress = (index + 1)/$sections.length*100;
        $('#step-progress').attr('aria-valuenow', progress).css("width",(progress+"%"));
        $('#step-x-of-y').html(`Step ${index + 1} of ${$sections.length}`);
      }

      function curIndex() {
        // Return the current index by looking at which section has the class 'current'
        return $sections.index($sections.filter('.current'));
      }

      // Previous button is easy, just go back
      $('.form-navigation .previous').click(function() {
        navigateTo(curIndex() - 1);
      });

      // Next button goes forward iff current block validates
      $('.form-navigation .next').click(function() {
        $('.demo-form').parsley().whenValidate({
          group: 'block-' + curIndex()
        }).done(function() {
          navigateTo(curIndex() + 1);
        });
      });

      // Prepare sections by setting the `data-parsley-group` attribute to 'block-0', 'block-1', etc.
      $sections.each(function(index, section) {
        $(section).find(':input').attr('data-parsley-group', 'block-' + index);
      });
      navigateTo(0); // Start at the beginning

    });
  </script>
  <!-- END Aux Scripts -->

  <!-- Footer Include -->
  <?php include 'includes/footer.php'; ?>
  <!-- END Footer Include -->

</body>

</html>
