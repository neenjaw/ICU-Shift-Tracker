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

  <div class="container-fluid">
    <div class="col-12">
      <!-- NAV include -->
      <?php include 'includes/nav-menu.php' ?>
      <!-- END NAV include -->
    </div>

    <div class="col-10">
      <h3>Add Shifts for the Unit</h3>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row justify-content-center">

      <!-- Alert Feedback -->
      <div id="shift-form-feedback" class="col-8 form-control-feedback hidden">
      </div>

    </div>
    <div class="row justify-content-center">
      <div id="msf-container" class="col-sm-12">

        <!-- Multi-step form goes here -->
        <form class="unit-shift-form">

          <?php
          //use the CRUD object to access the database and to build option lists of the staff categories
          $form_select_rn = $crud->getRnStaff();
          $form_select_na = $crud->getNaStaff();
          $form_select_uc = $crud->getUcStaff();
          $form_select_assignment = $crud->getAllAssignments();
          ?>

          <div class="form-section form-inline mt-4 mb-4">

            <!-- DATE SELECT -->
            <div class="form-group">
              <label class="control-label requiredField mr-1" for="date">Date: </label>
              <div class="input-group mt-1">
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                <input class="form-control" id="date" name="date" placeholder="YYYY/MM/DD" value="<?= date('Y-m-d') ?>" type="<?= (($detect->isMobile()) ? 'date' : 'text'); ?>" required>
              </div>

              <!-- DAY / NIGHT SELECT -->
              <div class="btn-group requiredField ml-sm-1 mt-1" data-toggle="buttons">
                <label id="radio-d-or-n-d" class="btn btn-outline-primary active"><input type="radio" name="d-or-n" value="D" autocomplete="off" checked required>Day</label>
                <label id="radio-d-or-n-n" class="btn btn-outline-primary"><input type="radio" name="d-or-n" value="N" autocomplete="off">Night</label>
              </div>
            </div>

          </div>

          <!-- TODO start adding the rest of the form elements -->
          <!-- TODO add in the bootstrap handling -->
          <!-- TODO add in the ajax to submit them all -->

          <!-- FIXME NEED TO CHANGE FROM SELECT TO TO CHOSEN - https://harvesthq.github.io/chosen/ -->

          <!-- Select Clinician/Charge -->
          <div class="form-section mt-4 mb-4">
            <!-- RN Clinician SELECT -->
            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Who is the Clinician for the shift?<span class="asteriskField">*</span>
              </label>


              <div id="nurse-clinician" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              foreach ($form_select_rn as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-radio m-1">
                    <input id="nc-<?= $k ?>" name="nurse-clinician" type="radio" value="<?= $k ?>" data-staff-name="<?= $v ?>" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              endforeach;
              //END Build Staff Select List
              ?>
              </div>

            </div>

            <!-- RN CHARGE SELECT -->
            <div id="fg-charge-nurse" class="form-group">
              <label class="control-label requiredField" for="select">
                Who is the Charge for the shift?<span class="asteriskField">*</span>
              </label>

              <div id="charge-nurse" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              foreach ($form_select_rn as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-radio m-1">
                    <input id="cn-<?= $k ?>" name="charge-nurse" type="radio" value="<?= $k ?>" data-staff-name="<?= $v ?>" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              endforeach;
              //END Build Staff Select List
              ?>
              </div>

            </div>

          </div>


          <div id="fs-nc-and-cn-pod-select" class="form-section mt-4 mb-4">
            <!-- assign pods to the clinician/charge -->

            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Which pod was the Nurse Clinician in?<span class="asteriskField">*</span>
              </label>

              <div id="nc-pod" class="staff-select-group p-0 m-0">
                <?php
                //Build Pod Select List
                foreach ($form_select_assignment as $k => $v):
                  if ( (strpos($v, "B") === false) || (strlen($v) == 1) ) {
                    continue;
                  }
                ?>
                  <div class="inner-item list-group-item-action">
                    <label class="custom-control custom-radio m-1">
                      <input id="nc-pod-<?= $k ?>" name="nc-pod" type="radio" value="<?= $k ?>" data-pod-name="<?= $v ?>" class="custom-control-input">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description"><?= $v ?></span>
                    </label>
                  </div>
                <?php
                endforeach;
                //END Build Pod Select List
                ?>
              </div>

            </div>

            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Which pod was the Charge Nurse in?<span class="asteriskField">*</span>
              </label>

              <div id="cn-pod" class="staff-select-group p-0 m-0">
                <?php
                //Build Pod Select List
                foreach ($form_select_assignment as $k => $v):
                  if ( (strlen($v) > 1) || ($v === "B") ) {
                    continue;
                  }
                ?>
                  <div class="inner-item list-group-item-action">
                    <label class="custom-control custom-radio m-1">
                      <input id="cn-pod-<?= $k ?>" name="cn-pod" type="radio" value="<?= $k ?>" data-pod-name="<?= $v ?>" class="custom-control-input">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description"><?= $v ?></span>
                    </label>
                  </div>
                <?php
                endforeach;
                //END Build Pod Select List
                ?>
              </div>

            </div>
          </div>

          <div id="apod-rn-select" class="form-section mt-4 mb-4">
            <!-- Select Bedside Nurses for A -->
            <!-- TODO add logic so that clinician and charge cant be selected -->

            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the nurses for Pod A<span class="asteriskField">*</span>
              </label>

              <div id="apod-rn" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              foreach ($form_select_rn as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-checkbox m-1">
                    <input id="apod-rn-<?= $k ?>" name="apod-rn[]" type="checkbox" value="<?= $k ?>" data-staff-name="<?= $v ?>" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              endforeach;
              //END Build Staff Select List
              ?>
              </div>

            </div>
          </div>

          <div id="bpod-rn-select" class="form-section mt-4 mb-4">
            <!-- Select Bedside Nurses for B -->
            <!-- TODO add logic so that clinician and charge, pod a nurses cant be selected -->

            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the nurses for Pod B<span class="asteriskField">*</span>
              </label>

              <div id="bpod-rn" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              foreach ($form_select_rn as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-checkbox m-1">
                    <input id="bpod-rn-<?= $k ?>" name="bpod-rn[]" type="checkbox" value="<?= $k ?>" data-staff-name="<?= $v ?>" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              endforeach;
              //END Build Staff Select List
              ?>
              </div>

            </div>
          </div>

          <div id="cpod-rn-select" class="form-section mt-4 mb-4">
            <!-- Select Bedside Nurses for C -->
            <!-- TODO add logic so that clinician and charge, pod a/b nurses cant be selected -->

            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the nurses for Pod C<span class="asteriskField">*</span>
              </label>

              <div id="cpod-rn" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              foreach ($form_select_rn as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-checkbox m-1">
                    <input id="cpod-rn-<?= $k ?>" name="cpod-rn[]" type="checkbox" value="<?= $k ?>" data-staff-name="<?= $v ?>" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              endforeach;
              //END Build Staff Select List
              ?>
              </div>

            </div>
          </div>

          <!-- Who had non-vent -->
          <div id="section-non-vent" class="form-section mt-4 mb-4">
            <div class="form-group">
              <label class="control-label" for="div">
                Which nurses had only non-ventilated patients?
              </label>
              <div id="non-vent" class="staff-select-group p-0 m-0">
                <!-- Add handlebars template here -->
              </div>
            </div>
          </div>

          <!-- Who had double -->
          <div id="section-double" class="form-section mt-4 mb-4">
            <div class="form-group">
              <label class="control-label" for="div">
                Which nurses were doubled?
              </label>
              <div id="double" class="staff-select-group p-0 m-0">
                <!-- Add handlebars template here -->
              </div>
            </div>
          </div>

          <!-- Who admitted -->
          <div id="section-admit" class="form-section mt-4 mb-4">
            <div class="form-group">
              <label class="control-label" for="div">
                Which nurses admitted patients?
              </label>
              <div id="admit" class="staff-select-group p-0 m-0">
                <!-- Add handlebars template here -->
              </div>
            </div>
          </div>

          <!-- Who had very sick -->
          <div id="section-very-sick" class="form-section mt-4 mb-4">
            <div class="form-group">
              <label class="control-label" for="div">
                Which nurses had a very sick patient <small>(3 gtt's or more)</small>?
              </label>
              <div id="very-sick" class="staff-select-group p-0 m-0">
                <!-- Add handlebars template here -->
              </div>
            </div>
          </div>

          <!-- Who had code pager -->
          <div id="section-code-pager" class="form-section mt-4 mb-4">
            <div class="form-group">
              <label class="control-label" for="div">
                Which nurses had the code pager?
              </label>
              <div id="code-pager" class="staff-select-group p-0 m-0">
                <!-- Add handlebars template here -->
              </div>
            </div>
          </div>

          <!-- Who had crrt -->
          <div id="section-crrt" class="form-section mt-4 mb-4">
            <div class="form-group">
              <label class="control-label" for="div">
                Which nurses had crrt?
              </label>
              <div id="crrt" class="staff-select-group p-0 m-0">
                <!-- Add handlebars template here -->
              </div>
            </div>
          </div>

          <!-- Who had evd -->
          <div id="section-evd" class="form-section mt-4 mb-4">
            <div class="form-group">
              <label class="control-label" for="div">
                Which nurses had an EVD?
              </label>
              <div id="evd" class="staff-select-group p-0 m-0">
                <!-- Add handlebars template here -->
              </div>
            </div>
          </div>

          <!-- Who who had burn -->
          <div id="section-burn" class="form-section mt-4 mb-4">
            <div class="form-group">
              <label class="control-label" for="div">
                Which nurses had a burn patient?
              </label>
              <div id="burn" class="staff-select-group p-0 m-0">
                <!-- Add handlebars template here -->
              </div>
            </div>
          </div>

          <div id="outreach-rn-select" class="form-section mt-4 mb-4">
            <!-- Select Bedside Nurses for C -->
            <!-- TODO add logic so that clinician and charge, pod a/b nurses cant be selected -->

            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Who was on outreach?<span class="asteriskField">*</span>
              </label>

              <div id="outreach-rn" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              foreach ($form_select_rn as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-radio m-1">
                    <input id="outreach-rn-<?= $k ?>" name="outreach-rn" type="radio" value="<?= $k ?>" data-staff-name="<?= $v ?>" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              endforeach;
              //END Build Staff Select List
              ?>
              </div>

            </div>
          </div>

          <div class="form-section mt-4 mb-4">
            <!-- Select NA's -->
            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the NA's<span class="asteriskField">*</span>
              </label>

              <div id="na" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              foreach ($form_select_na as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-checkbox m-1">
                    <input id="na-<?= $k ?>" name="na[]" type="checkbox" value="<?= $k ?>" data-staff-name="<?= $v ?>" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              endforeach;
              //END Build Staff Select List
              ?>
              </div>

            </div>
          </div>

          <!-- assign pods to the na's -->
          <div id="na-pod-select" class="form-section mt-4 mb-4">
          </div>

          <div class="form-section mt-4 mb-4">
          <!-- Select UC's -->
          <div class="form-group">
            <label class="control-label requiredField" for="select">
              Select the UC's<span class="asteriskField">*</span>
            </label>

            <div id="uc" class="staff-select-group p-0 m-0">
            <?php
            //Build Staff Select List
            foreach ($form_select_uc as $k => $v):
            ?>
              <div class="inner-item list-group-item-action">
                <label class="custom-control custom-checkbox m-1">
                  <input id="uc-<?= $k ?>" name="uc[]" type="checkbox" value="<?= $k ?>" class="custom-control-input">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description"><?= $v ?></span>
                </label>
              </div>
            <?php
            endforeach;
            //END Build Staff Select List
            ?>
            </div>
          </div>
          </div>

          <!-- <div class="form-section mt-4 mb-4"> -->
          <!-- TODO assign pods to the uc's -->
          <!-- </div> -->

          <div class="form-navigation m-1 text-center">
            <button type="button" id="btn-prev" class="previous btn btn-secondary">&lt; Previous</button>
            <button type="button" id="btn-next" class="next btn btn-secondary">Next &gt;</button>
            <button type="submit" id="btn-submit" class="btn btn-secondary">Submit</button>
          </div>
        </form>

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

  <!-- Handlebars templates -->
  <script id="hbt-shift-modifier-checkbox" type="text/x-handlebars-template">
  <?php include 'includes/templates/UnitShiftShiftModCheckbox.handlebars'; ?>
  </script>
  <script id="hbt-staff-pod-select" type="text/x-handlebars-template">
  <?php include 'includes/templates/StaffPodSelect.handlebars'; ?>
  </script>
  <!-- END Handlebars templates -->

  <!-- Aux Scripts -->
  <script>

  var shiftModifierCheckboxTemplate = null;
  var bedsideRnStaffList = [];
  var naStaffList = [];
  var ucStaffList = [];
  <?php
  $objAssignment = array();
  foreach ($form_select_assignment as $k => $v) {
    array_push($objAssignment, array('id' => $k, 'name' => $v) );
  }
  ?>
  var assignmentList = <?= json_encode($objAssignment) ?>;


  //TODO Bind to the window, so that if user tries to back out while form is dirty, then prompts to ask
  $(function() {

    <?php if (!$detect->isMobile()): ?>
    $('#date').datepicker({
      format: "yyyy-mm-dd",
      orientation: "bottom auto",
      autoclose: true,
      endDate: "0d"
    });
    <?php endif; ?>

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
    //

    /********************************************************
     * FORM PAGINATION - CREDIT TO Parsely.js DOCUMENTATION *
     ********************************************************/
    var $sections = $('.form-section'); // list all all the form-section elements
    var oldIndex = -1; //reference to be able to know if traverseing forward or backward
    function navigateTo(index) {
      // Mark the current section with the class 'current'
      var $temp = $sections.removeClass('current')
                           .eq(index);

      //check if section should be skipped
      while ( $temp.hasClass('skip-section') ) { //loop until section found which shouldnt be skipped
        if ( oldIndex > index ) { //if moving backwards
          $temp = $sections.eq(--index); //look back one more section
        } else if ( oldIndex < index ) { //if moving forwards
          $temp = $sections.eq(++index); //look ahead one more section
        }
      }

      $temp.addClass('current'); //IDEA << ADD SHOW TRANSITION ANIMATION HERE BETWEEN FORMS

      // Show only the navigation buttons that make sense for the current section:
      $('.form-navigation .previous').attr("disabled", !(index > 0))
                                     .toggleClass("btn-primary", (index > 0))
                                     .toggleClass("btn-secondary", !(index > 0));

      var atTheEnd = index >= $sections.length - 1;

      $('.form-navigation .next').attr("disabled", (atTheEnd))
                                 .toggleClass("btn-primary", (!atTheEnd))
                                 .toggleClass("btn-secondary", (atTheEnd));

      $('.form-navigation [type=submit]').attr("disabled", (!atTheEnd))
                                         .toggleClass("btn-primary", (atTheEnd))
                                         .toggleClass("btn-secondary", (!atTheEnd));

      //update progress bar
      var progress = (index + 1)/$sections.length*100;
      $('#step-progress').attr('aria-valuenow', progress).css("width",(progress+"%"));
      $('#step-x-of-y').html(`Step ${index + 1} of ${$sections.length}`);

      //update reference index
      oldIndex = index;
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

    /**************************
     * END -- FORM PAGINATION *
     **************************/

    setClickAreaListeners("div.inner-item");
    hideFormInnerItem($(`#nc-pod-8`));

    //listener which disables/clear chage nurse value depending on nurse clinician value
    var $disabledPrn = null;
    $(`#nurse-clinician div.inner-item`).click(function() {
      if ($disabledPrn !== null) {
          enableFormInnerItem($disabledPrn);
      }
      let $ncChoice = $(this).find("input[type='radio']");

      let $elem = $(`input[type='radio'][name='charge-nurse'][value='${$ncChoice.val()}']`);

      if ($elem !== null) {
        disableFormInnerItem($elem);
        $disabledPrn = $elem;
      }
    });

    //listener to change behavior of form if day shift is selected for input
    $(`#radio-d-or-n-d`).click(function() {
      $(`#fg-charge-nurse`).toggle(true); // show charge nurse select
      $(`#fs-nc-and-cn-pod-select`).toggleClass('skip-section', false); // show section for pod selection for nc/cn

      hideFormInnerItem($(`#nc-pod-8`));
    });

    //listener to change behavior of form if night shift is selected for input
    $(`#radio-d-or-n-n`).click(function() {
      $(`#fg-charge-nurse`).toggle(false); // hide charge nurse select
      $(`#fs-nc-and-cn-pod-select`).toggleClass('skip-section', true); // hide section for pod selection for nc/cn

      showFormInnerItem($(`#nc-pod-8`));
      $(`#nc-pod-8`).prop("checked", true);

      let $cnElem = $(`input[type='radio'][name='charge-nurse']:checked`); //unselect any selected charge-nurse value
      if ($cnElem !== null) { $cnElem.prop("checked", false); }
      let $cnPodElem = $(`input[type='radio'][name='cn-pod']:checked`); //unselect any selected charge-nurse value
      if ($cnPodElem !== null) { $cnPodElem.prop("checked", false); }
    });

    //when next is clicked, evaluate based on previous section(s);
    $('.form-navigation .next').click(function () {
      let currentSectionId = $('.current').prop('id');

      if ( currentSectionId == 'apod-rn-select' ) {
        hideAlreadyPickedForApod();
      } else if ( currentSectionId == 'bpod-rn-select' ) {
        hideAlreadyPickedForBpod();
      } else if ( currentSectionId == 'cpod-rn-select' ) {
        hideAlreadyPickedForCpod();
      } else if ( currentSectionId == 'outreach-rn-select' ) {
        hideAlreadyPickedForOutreach();
      } else if ( currentSectionId == 'section-non-vent' ) {
        bedsideRnStaffList = getBedsideRnStaff();
        popStaffShiftModifierList('#non-vent', 'non-vent', bedsideRnStaffList);
      } else if ( currentSectionId == 'section-double' ) {
        popStaffShiftModifierList('#double', 'double', bedsideRnStaffList);
      } else if ( currentSectionId == 'section-admit' ) {
        popStaffShiftModifierList('#admit', 'admit', bedsideRnStaffList);
      } else if ( currentSectionId == 'section-very-sick' ) {
        popStaffShiftModifierList('#very-sick', 'very-sick', bedsideRnStaffList);
      } else if ( currentSectionId == 'section-code-pager' ) {
        popStaffShiftModifierList('#code-pager', 'code-pager', bedsideRnStaffList);
      } else if ( currentSectionId == 'section-crrt' ) {
        popStaffShiftModifierList('#crrt', 'crrt', bedsideRnStaffList);
      } else if ( currentSectionId == 'section-evd' ) {
        popStaffShiftModifierList('#evd', 'evd', bedsideRnStaffList);
      } else if ( currentSectionId == 'section-burn' ) {
        popStaffShiftModifierList('#burn', 'burn', bedsideRnStaffList);
      } else if ( currentSectionId == 'na-pod-select' ) {
        popNaPodSelectList('#na-pod-select', getNaStaff(), assignmentList);
      }

      //TODO -- NEED TO GET THE PODS from CRUD to JAVASCRIPT
      //popNaPodSelect();
      //popUcPodSelect();

      return true;
    });

    $(`#nc-pod div.inner-item`).click(function() {
      let clickedPodName = $(this).find('input').data('podName').replace(/[\/B]/g, '');

      $(`input[type='radio'][name='cn-pod']`)
        .filter(function() {
          return (!($(this).closest('div').hasClass('st-none'))) && ($(this).data('podName').indexOf(clickedPodName) < 0);
        })
        .prop("checked", true);

      return true;
    });
    $(`#cn-pod div.inner-item`).click(function() {
      let clickedPodName = $(this).find('input').data('podName');

      $(`input[type='radio'][name='nc-pod']`)
        .filter(function() {
          return (!($(this).closest('div').hasClass('st-none'))) && ($(this).data('podName').indexOf(clickedPodName) < 0);
        })
        .prop("checked", true);

      return true;
    });

    //compile the shift modifier checkbox template with Handlebars
    shiftModifierCheckboxTemplate = Handlebars.compile($("#hbt-shift-modifier-checkbox").html());
    staffPodSelectTemplate = Handlebars.compile($("#hbt-staff-pod-select").html());

  });

  function setClickAreaListeners(target) {
    //listener for click in the div to increase radio/checkbox active area
    $(target).click(function() {
      var $elem = $(this).find("input[type='checkbox'], input[type='radio']"); // find checkbox associated
      if (!$elem.prop("disabled")) {
        $elem.prop("checked", !($elem.prop("checked"))); // toggle checked state
      }
      return false; // return false to stop click propigation
    });
  }

  function getBedsideRnStaff() {
      let staffList = $("input[name='apod-rn[]'][type='checkbox']:checked, " +
                        "input[name='bpod-rn[]'][type='checkbox']:checked, " +
                        "input[name='cpod-rn[]'][type='checkbox']:checked")
                        .map(function () {
                          return {id: $(this).val(), name: $(this).data("staffName")};
                        })
                        .get()

      return staffList;
  }

  function getNaStaff() {
      let staffList = $("input[name='na[]'][type='checkbox']:checked")
                        .map(function () {
                          return {id: $(this).val(), name: $(this).data("staffName")};
                        })
                        .get()

      return staffList;
  }

  /**
   * [popStaffShiftModifierList description]
   * @return [type] [description]
   */
  function popStaffShiftModifierList(target, shiftModName, staffList) {
    $(target).html(shiftModifierCheckboxTemplate({modifier: shiftModName, staff: staffList}));
    setClickAreaListeners(`${target} div.inner-item`);
  }

  /**
   * [popNaPodSelectList description]
   * @return [type] [description]
   */
  function popNaPodSelectList(target, staffList, podList) {
    let x = {pod: podList, staff: staffList};
    $(target).html(staffPodSelectTemplate(x));
  }

  /**
   * [hideAlreadyPickedForApod description]
   * @return [type] [description]
   */
  function hideAlreadyPickedForApod() {
    //reset all hidden
    $(`#apod-rn div.st-none`).each(function() {
      showFormInnerItem($(this).find('input'));
    });

    //hide clinician
    let ncVal = $(`input[type='radio'][name='nurse-clinician']:checked`).val();
    hideFormInnerItem($(`input[type='checkbox'][name='apod-rn[]'][value='${ncVal}']`));

    //hide charge nurse
    if ( $(`input[type='radio'][name='d-or-n']:checked`).val() === "D" ) {
      let cnVal = $(`input[type='radio'][name='charge-nurse']:checked`).val();
      hideFormInnerItem($(`input[type='checkbox'][name='apod-rn[]'][value='${cnVal}']`));
    }
  }

  /**
   * [hideAlreadyPickedForBpod description]
   * @return [type] [description]
   */
  function hideAlreadyPickedForBpod() {
    //reset all previously hidden
    $(`#bpod-rn div.st-none`).each(function() {
      showFormInnerItem($(this).find('input'));
    });

    //hide based on previously hidden
    $(`#apod-rn div.st-none`).each(function() {
      let rnVal = $(this).find('input').val();
      hideFormInnerItem($(`input[type='checkbox'][name='bpod-rn[]'][value='${rnVal}']`));
    });

    //hide based on apod picks
    $(`#apod-rn input[type='checkbox'][name='apod-rn[]']:checked`).each(function() {
      let rnVal = $(this).val();
      hideFormInnerItem($(`input[type='checkbox'][name='bpod-rn[]'][value='${rnVal}']`));
    });

  }

  /**
   * [hideAlreadyPickedForCpod description]
   * @return [type] [description]
   */
  function hideAlreadyPickedForCpod() {
    //reset all previously hidden
    $(`#cpod-rn div.st-none`).each(function() {
      showFormInnerItem($(this).find('input'));
    });

    //hide based on previously hidden
    $(`#bpod-rn div.st-none`).each(function() {
      let rnVal = $(this).find('input').val();
      hideFormInnerItem($(`input[type='checkbox'][name='cpod-rn[]'][value='${rnVal}']`));
    });

    //hide based on bpod picks
    $(`#bpod-rn input[type='checkbox'][name='bpod-rn[]']:checked`).each(function() {
      let rnVal = $(this).val();
      hideFormInnerItem($(`input[type='checkbox'][name='cpod-rn[]'][value='${rnVal}']`));
    });

  }

  /**
   * [hideAlreadyPickedForOutreach description]
   * @return [type] [description]
   */
  function hideAlreadyPickedForOutreach() {
    //reset all previously hidden
    $(`#outreach-rn div.st-none`).each(function() {
      showFormInnerItem($(this).find('input'));
    });

    //hide based on previously hidden
    $(`#cpod-rn div.st-none`).each(function() {
      let rnVal = $(this).find('input').val();
      hideFormInnerItem($(`input[type='radio'][name='outreach-rn'][value='${rnVal}']`));
    });

    //hide based on vpod picks
    $(`#cpod-rn input[type='checkbox'][name='cpod-rn[]']:checked`).each(function() {
      let rnVal = $(this).val();
      hideFormInnerItem($(`input[type='radio'][name='outreach-rn'][value='${rnVal}']`));
    });

  }

  /**
   * [showFormInnerItem description]
   * @param  [type] $elem [description]
   * @return [type]       [description]
   */
  function showFormInnerItem($elem) {
    try {
      $elem.closest("div").removeClass('st-none').toggle(true);
      enableFormInnerItem($elem);

      return true;
    } catch (e) {
      return false;
    }
  }

  /**
   * [hideFormInnerItem description]
   * @param  [type] $elem [description]
   * @return [type]       [description]
   */
  function hideFormInnerItem($elem) {
    try {
      $elem.closest("div").addClass('st-none').toggle(false);
      disableFormInnerItem($elem);

      return true;
    } catch (e) {
      return false;
    }
  }

  /**
   * [enableFormInnerItem description]
   * @param  [type] $elem [description]
   * @return [type]       [description]
   */
  function enableFormInnerItem($elem) {
    try {
      $elem.prop("disabled", false);
      $elem.closest("div").toggleClass("list-group-item-action");
      return true;
    } catch (e) {
      return false;
    }
  }

  /**
   * [disableFormInnerItem description]
   * @param  [type] $elem [description]
   * @return [type]       [description]
   */
  function disableFormInnerItem($elem) {
    try {
      $elem.prop("checked", false);
      $elem.prop("disabled", true);
      $elem.closest("div").toggleClass("list-group-item-action");
      return true;
    } catch (e) {
      return false;
    }
  }

  </script>
  <!-- END Aux Scripts -->

  <!-- Footer Include -->
  <?php include 'includes/footer.php'; ?>
  <!-- END Footer Include -->

</body>

</html>
