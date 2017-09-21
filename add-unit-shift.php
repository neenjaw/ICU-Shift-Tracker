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
      <div class="col-12 m-2">
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
            <div class="col-sm-10 m-1">
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
            <div id="msf-container" class="col-sm-10">
              <!-- Multi-step form goes here -->

              <form class="unit-shift-form">

                <?php
                //use the CRUD object to access the database and build an option list of the categories
                $form_select_rn = $crud->getRnStaff(); //only need to get this once
                //TODO Do all the $crud operations once, reuse data if able
                //$form_select_na = $crud->getNaStaff();
                //$form_select_uc = $crud->getUcStaff();
                ?>

                <div class="form-section form-inline m-1 col-sm-10">
                  <!-- DATE SELECT -->
                  <div class="form-group col-sm-8">
                    <label class="control-label requiredField mr-1" for="date">Date: </label>
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                      <input class="form-control" id="date" name="date" placeholder="YYYY/MM/DD" value="<?= date('Y-m-d') ?>" type="<?= (($detect->isMobile()) ? 'date' : 'text'); ?>" required>
                    </div>

                    <!-- DAY / NIGHT SELECT -->
                    <div class="btn-group requiredField m-1 col-sm-2" data-toggle="buttons">
                      <label class="btn btn-outline-primary active"><input type="radio" name="d-or-n" id="radio-d-or-n-d" value="D" autocomplete="off" checked required>Day</label>
                      <label class="btn btn-outline-primary"><input type="radio" name="d-or-n" id="radio-d-or-n-n" value="N" autocomplete="off">Night</label>
                    </div>
                  </div>

                </div>

                <!-- TODO start adding the rest of the form elements -->
                <!-- TODO add in the bootstrap handling -->
                <!-- TODO add in the ajax to submit them all -->

                <!-- FIXME NEED TO CHANGE FROM SELECT TO TO CHOSEN - https://harvesthq.github.io/chosen/ -->

                <!-- Select Clinician/Charge -->
                <div class="form-section m-1">
                  <!-- RN Clinician SELECT -->
                  <div class="form-group">
                    <label class="control-label requiredField" for="select">
                      Who is the Clinician for the shift?<span class="asteriskField">*</span>
                    </label>
                    <select class="select form-control" id="select-clinician" name="staff" style="width: 100%" required>
                      <option value="" disabled selected hidden>Please Choose...</option>
                      <?php
                        //Build Staff Select List
                        foreach ($form_select_rn as $k => $v):
                      ?>
                      <option value="<?= $k ?>"><?= $v ?></option>
                      <?php
                        endforeach;
                        //END Build Staff Select List
                      ?>
                    </select>
                  </div>

                  <!-- TODO add logic which hides the charge option select if you are doing a night shift -->
                  <!-- TODO add logic which hides the option of choosing the same person as the clinician -->

                  <!-- RN CHARGE SELECT -->
                  <div class="form-group">
                    <label class="control-label requiredField" for="select">
                      Who is the Charge for the shift?<span class="asteriskField">*</span>
                    </label>
                    <select class="select form-control" id="select-charge" name="staff" style="width: 100%" required>
                      <option value="" disabled selected hidden>Please Choose...</option>
                      <?php
                        //Build Staff Select List
                        //use the CRUD object to access the database and build an option list of the categories
                        foreach ($form_select_rn as $k => $v):
                      ?>
                      <option value="<?= $k ?>"><?= $v ?></option>
                      <?php
                        endforeach;
                        //END Build Staff Select List
                      ?>
                    </select>
                  </div>

                  <!-- TODO assign pods to the clinician/charge -->

                </div>

                <div class="form-section m-1">
                <!-- Select Bedside Nurses for A -->
                <!-- TODO add logic so that clinician and charge cant be selected -->

                  <div class="form-group">
                    <label class="control-label requiredField" for="select">
                      Select the nurses for Pod A<span class="asteriskField">*</span>
                    </label>
                    <select class="select form-control" id="select-poda" name="staff" style="width: 100%" required>
                      <option value="" disabled selected hidden>Please Choose...</option>
                      <?php
                        //Build Staff Select List
                        //use the CRUD object to access the database and build an option list of the categories
                        foreach ($form_select_rn as $k => $v):
                      ?>
                      <option value="<?= $k ?>"><?= $v ?></option>
                      <?php
                        endforeach;
                        //END Build Staff Select List
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-section m-1">
                <!-- Select Bedside Nurses for B -->
                <!-- TODO add logic so that clinician and charge, pod a nurses cant be selected -->

                  <div class="form-group">
                    <label class="control-label requiredField" for="select">
                      Select the nurses for Pod B<span class="asteriskField">*</span>
                    </label>
                    <select class="select form-control" id="select-podb" name="staff" style="width: 100%" required>
                      <option value="" disabled selected hidden>Please Choose...</option>
                      <?php
                        //Build Staff Select List
                        //use the CRUD object to access the database and build an option list of the categories
                        foreach ($form_select_rn as $k => $v):
                      ?>
                      <option value="<?= $k ?>"><?= $v ?></option>
                      <?php
                        endforeach;
                        //END Build Staff Select List
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-section m-1">
                <!-- Select Bedside Nurses for C -->
                <!-- TODO add logic so that clinician and charge, pod a/b nurses cant be selected -->

                  <div class="form-group">
                    <label class="control-label requiredField" for="select">
                      Select the nurses for Pod C<span class="asteriskField">*</span>
                    </label>
                    <select class="select form-control" id="select-podc" name="staff" style="width: 100%" required>
                      <option value="" disabled selected hidden>Please Choose...</option>
                      <?php
                        //Build Staff Select List
                        //use the CRUD object to access the database and build an option list of the categories
                        foreach ($form_select_rn as $k => $v):
                      ?>
                      <option value="<?= $k ?>"><?= $v ?></option>
                      <?php
                        endforeach;
                        //END Build Staff Select List
                      ?>
                    </select>
                  </div>
                </div>

                <!-- <div class="form-section"> -->
                <!-- Who had non-vent -->
                <!-- </div> -->

                <!-- <div class="form-section"> -->
                <!-- Who had double -->
                <!-- </div> -->

                <!-- <div class="form-section"> -->
                <!-- Who admitted -->
                <!-- </div> -->

                <!-- <div class="form-section"> -->
                <!-- Who had very sick -->
                <!-- </div> -->

                <!-- <div class="form-section"> -->
                <!-- Who had code pager -->
                <!-- </div> -->

                <!-- <div class="form-section"> -->
                <!-- Who had crrt -->
                <!-- </div> -->

                <!-- <div class="form-section"> -->
                <!-- Who had evd -->
                <!-- </div> -->

                <!-- <div class="form-section"> -->
                <!-- Who who had burn -->
                <!-- </div> -->

                <!-- <div class="form-section"> -->
                <!-- Select NA's -->
                <!-- Assign Pods -->
                <!-- </div> -->

                <!-- <div class="form-section"> -->
                <!-- Select UC's -->
                <!-- Assign Pods -->
                <!-- </div> -->

                <div class="form-navigation m-1 text-center">
                  <button type="button" class="previous btn btn-secondary">&lt; Previous</button>
                  <button type="button" class="next btn btn-secondary">Next &gt;</button>
                  <button type="submit" class="btn btn-secondary">Submit</button>
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

      // //Activate the Select2 script for the staff select to search easily
      // $("#select-clinician").select2({theme: "bootstrap"});
      // $("#select-charge").select2({theme: "bootstrap"});
      // $("#select-poda").select2({theme: "bootstrap"});
      // $("#select-podb").select2({theme: "bootstrap"});
      // $("#select-podc").select2({theme: "bootstrap"});

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

      //TODO Make the div expand, not just POP into existence
      function navigateTo(index) {
        // Mark the current section with the class 'current'
        $sections
        .removeClass('current')
        .eq(index)
        .addClass('current'); //TODO << ADD SHOW ANIMATION HERE
        // Show only the navigation buttons that make sense for the current section:
        $('.form-navigation .previous').attr("disabled", !(index > 0)).toggleClass("btn-primary", (index > 0)).toggleClass("btn-secondary", !(index > 0));
        var atTheEnd = index >= $sections.length - 1;
        $('.form-navigation .next').attr("disabled", (atTheEnd)).toggleClass("btn-primary", (!atTheEnd)).toggleClass("btn-secondary", (atTheEnd));
        $('.form-navigation [type=submit]').attr("disabled", (!atTheEnd)).toggleClass("btn-primary", (atTheEnd)).toggleClass("btn-secondary", (!atTheEnd));

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
        $('.unit-shift-form').parsley().whenValidate({
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
