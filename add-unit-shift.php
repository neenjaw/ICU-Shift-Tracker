<?php
include 'includes/pre-head.php';

if (!isset($_SESSION['user_session'])) {
  header("Location: index.php");
}

//use the CRUD object to access the database and to build option lists of the staff categories
$form_select_rn = $crud->getRnStaff();
$form_select_na = $crud->getNaStaff();
$form_select_uc = $crud->getUcStaff();
$form_select_assignment = $crud->getAllAssignments();

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
        <form id="unit-shift-form" class="unit-shift-form">

          <div class="form-section form-inline mt-4 mb-4">

            <!-- DATE SELECT -->
            <div class="form-group">
              <label class="control-label requiredField mr-1" for="date">Date: </label>
              <div class="input-group mt-1">
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                <input class="form-control"
                       id="date"
                       name="date"
                       placeholder="YYYY/MM/DD"
                       value="<?= date('Y-m-d') ?>"
                       type="<?= (($detect->isMobile()) ? 'date' : 'text'); ?>"
                       <?= (($detect->isMobile()) ? ('max="'.date('Y-m-d').'" ') : ''); ?>
                       required>
              </div>

              <!-- DAY / NIGHT SELECT -->
              <div class="btn-group requiredField ml-sm-1 mt-1" data-toggle="buttons">
                <label id="radio-d-or-n-d" class="btn btn-outline-primary active"><input type="radio" name="d-or-n" value="D" autocomplete="off" checked required>Day</label>
                <label id="radio-d-or-n-n" class="btn btn-outline-primary"><input type="radio" name="d-or-n" value="N" autocomplete="off">Night</label>
              </div>
            </div>

          </div>

          <!-- TODO add in the ajax to submit them all -->

          <!-- Select Clinician/Charge -->
          <div class="form-section mt-4 mb-4">
            <!-- RN Clinician SELECT -->
            <div class="form-group">
              <label class="control-label requiredField" for="nurse-clinician">
                Who is the Clinician for the shift?<span class="asteriskField">*</span>
              </label>
              <div id="nc-select-errors"></div>
              <div id="nurse-clinician" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              $i = true;
              foreach ($form_select_rn as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-radio m-1">
                    <input id="nc-<?= $k ?>"
                           name="nurse-clinician"
                           type="radio"
                           value="<?= $k ?>"
                           <?= ($i === true)? ' required data-parsley-errors-container="#nc-select-errors"':'' ?>
                           data-staff-name="<?= $v ?>"
                           class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              $i = false;
              endforeach;
              //END Build Staff Select List
              ?>
              </div>

            </div>

            <!-- RN CHARGE SELECT -->
            <div id="fg-charge-nurse" class="form-group">
              <label class="control-label requiredField" for="charge-nurse">
                Who is the Charge for the shift?<span class="asteriskField">*</span>
              </label>
              <div id="cn-select-errors"></div>
              <div id="charge-nurse" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              $i = true;
              foreach ($form_select_rn as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-radio m-1">
                    <input id="cn-<?= $k ?>"
                           name="charge-nurse"
                           type="radio"
                           value="<?= $k ?>"
                           <?= ($i === true)? ' required data-parsley-errors-container="#cn-select-errors"':'' ?>
                           data-staff-name="<?= $v ?>"
                           class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              $i = false;
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
              <div id="nc-pod-select-errors"></div>
              <div id="nc-pod" class="staff-select-group p-0 m-0">
                <?php
                //Build Pod Select List
                $i = true;
                foreach ($form_select_assignment as $k => $v):
                  if ( (strpos($v, "B") === false) || (strlen($v) == 1) ) {
                    continue;
                  }
                ?>
                  <div class="inner-item list-group-item-action">
                    <label class="custom-control custom-radio m-1">
                      <input id="nc-pod-<?= $k ?>"
                             name="nc-pod"
                             type="radio"
                             value="<?= $k ?>"
                             <?= ($i === true)? ' required data-parsley-errors-container="#nc-pod-select-errors"':'' ?>
                             data-pod-name="<?= $v ?>"
                             class="custom-control-input">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description"><?= $v ?></span>
                    </label>
                  </div>
                <?php
                $i = false;
                endforeach;
                //END Build Pod Select List
                ?>
              </div>

            </div>

            <div class="form-group">
              <label class="control-label requiredField" for="cn-pod">
                Which pod was the Charge Nurse in?<span class="asteriskField">*</span>
              </label>
              <div id="cn-pod-select-errors"></div>
              <div id="cn-pod" class="staff-select-group p-0 m-0">
                <?php
                //Build Pod Select List
                $i = true;
                foreach ($form_select_assignment as $k => $v):
                  if ( (strlen($v) > 1) || ($v === "B") ) {
                    continue;
                  }
                ?>
                  <div class="inner-item list-group-item-action">
                    <label class="custom-control custom-radio m-1">
                      <input id="cn-pod-<?= $k ?>"
                             name="cn-pod"
                             type="radio"
                             value="<?= $k ?>"
                             <?= ($i === true)? ' required data-parsley-errors-container="#cn-pod-select-errors"':'' ?>
                             data-pod-name="<?= $v ?>"
                             class="custom-control-input">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description"><?= $v ?></span>
                    </label>
                  </div>
                <?php
                $i = false;
                endforeach;
                //END Build Pod Select List
                ?>
              </div>

            </div>
          </div>

          <div id="apod-rn-select" class="form-section mt-4 mb-4">
            <!-- Select Bedside Nurses for A -->

            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the nurses for Pod A<span class="asteriskField">*</span>
              </label>
              <div id="apod-rn-errors"></div>
              <div id="apod-rn" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              $i = true;
              foreach ($form_select_rn as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-checkbox m-1">
                    <input id="apod-rn-<?= $k ?>"
                           name="apod-rn[]"
                           type="checkbox"
                           value="<?= $k ?>"
                           <?= ($i === true)? ' required data-parsley-errors-container="#apod-rn-errors"':'' ?>
                           data-staff-name="<?= $v ?>"
                           class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              $i = false;
              endforeach;
              //END Build Staff Select List
              ?>
              </div>

            </div>
          </div>

          <div id="bpod-rn-select" class="form-section mt-4 mb-4">
            <!-- Select Bedside Nurses for B -->

            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the nurses for Pod B<span class="asteriskField">*</span>
              </label>
              <div id="bpod-rn-errors"></div>
              <div id="bpod-rn" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              $i = true;
              foreach ($form_select_rn as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-checkbox m-1">
                    <input id="bpod-rn-<?= $k ?>"
                           name="bpod-rn[]"
                           type="checkbox"
                           value="<?= $k ?>"
                           <?= ($i === true)? ' required data-parsley-errors-container="#bpod-rn-errors"':'' ?>
                           data-staff-name="<?= $v ?>"
                           class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              $i = false;
              endforeach;
              //END Build Staff Select List
              ?>
              </div>

            </div>
          </div>

          <div id="cpod-rn-select" class="form-section mt-4 mb-4">
            <!-- Select Bedside Nurses for C -->
            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the nurses for Pod C<span class="asteriskField">*</span>
              </label>
              <div id="cpod-rn-errors"></div>
              <div id="cpod-rn" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              $i = true;
              foreach ($form_select_rn as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-checkbox m-1">
                    <input id="cpod-rn-<?= $k ?>"
                           name="cpod-rn[]"
                           type="checkbox"
                           value="<?= $k ?>"
                           <?= ($i === true)? ' required data-parsley-errors-container="#cpod-rn-errors"':'' ?>
                           data-staff-name="<?= $v ?>"
                           class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              $i = false;
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

            <div class="form-group">
              <label class="control-label requiredField" for="outrach-rn">
                Who was on outreach?<span class="asteriskField">*</span>
              </label>
              <div id="outreach-rn-errors"></div>
              <div id="outreach-rn" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              $i = true;
              foreach ($form_select_rn as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-radio m-1">
                    <input id="outreach-rn-<?= $k ?>"
                           name="outreach-rn"
                           type="radio"
                           value="<?= $k ?>"
                           <?= ($i === true)? ' required data-parsley-errors-container="#outreach-rn-errors"':'' ?>
                           data-staff-name="<?= $v ?>"
                           class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              $i = false;
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
              <div id="na-select-errors"></div>
              <div id="na" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              $i = true;
              foreach ($form_select_na as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-checkbox m-1">
                    <input id="na-<?= $k ?>"
                           name="na[]"
                           type="checkbox"
                           value="<?= $k ?>"
                           <?= ($i === true)? ' required data-parsley-errors-container="#na-select-errors"':'' ?>
                           data-staff-name="<?= $v ?>"
                           class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              $i = false;
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
              <div id="uc-select-errors"></div>
              <div id="uc" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              $i = true;
              foreach ($form_select_uc as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-checkbox m-1">
                    <input id="uc-<?= $k ?>"
                           name="uc[]"
                           type="checkbox"
                           value="<?= $k ?>"
                           <?= ($i === true)? ' required data-parsley-errors-container="#uc-select-errors"':'' ?>
                           data-staff-name="<?= $v ?>"
                           class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              $i = false;
              endforeach;
              //END Build Staff Select List
              ?>
              </div>
            </div>
          </div>

          <!-- assign pods to the uc's -->
          <div id="uc-pod-select" class="form-section mt-4 mb-4">
          </div>

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
  ?>var assignmentList = <?= json_encode($objAssignment) ?>;


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

    // Return the current index by looking at which section has the class 'current'
    function curIndex() {
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

    //catch the on-submit event, collect/format data from the form, submit via ajax
    $('#unit-shift-form').parsley().on('form:submit', function () {
      alert("hi");
      return false;
    });


    /***************************************
     * END -- FORM PAGINATION / VALIDATION *
     ***************************************/

    //call the function to set listeners on the div's that contain the checkboxes to make more accessible
    setClickAreaListeners("div.inner-item");
    //hide the option for the nc to select pod 'A/B/C' when the day shift button is preselected (default state)
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
        hideAlreadyPicked('apod-rn', ['nurse-clinician', 'charge-nurse']);

      } else if ( currentSectionId == 'bpod-rn-select' ) {
        hideAlreadyPicked('bpod-rn', ['nurse-clinician', 'charge-nurse', 'apod-rn[]']);

      } else if ( currentSectionId == 'cpod-rn-select' ) {
        hideAlreadyPicked('cpod-rn', ['nurse-clinician', 'charge-nurse', 'apod-rn[]', 'bpod-rn[]']);

      } else if ( currentSectionId == 'outreach-rn-select' ) {
        hideAlreadyPicked('outreach-rn', ['nurse-clinician', 'charge-nurse', 'apod-rn[]', 'bpod-rn[]', 'cpod-rn[]']);

      } else if ( currentSectionId == 'section-non-vent' ) {
        bedsideRnStaffList = getStaffFromCheckboxes(['apod-rn[]', 'bpod-rn[]', 'cpod-rn[]']);
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
        popPodSelectList('#na-pod-select', getStaffFromCheckboxes(['na[]']), assignmentList);

      } else if ( currentSectionId == 'uc-pod-select' ) {
        popPodSelectList('#uc-pod-select', getStaffFromCheckboxes(['uc[]']), assignmentList);

      }

      return true;
    });

    //when the nc's assigned pod is clicked, the charge nurse's pod changes to the appropriate selection
    $(`#nc-pod div.inner-item`).click(function() {
      let clickedPodName = $(this).find('input').data('podName').replace(/[\/B]/g, ''); //which main pod was chosen, get rid of the B-pod

      $(`input[type='radio'][name='cn-pod']`)
        .filter(function() {
          //find the non-matching main pod assignment -- eg: if pod A was chosen by nc, choose pod C for cn
          return (!($(this).closest('div').hasClass('st-none'))) && ($(this).data('podName').indexOf(clickedPodName) < 0);
        })
        .prop("checked", true); //select it

      return true;
    });

    $(`#cn-pod div.inner-item`).click(function() {
      let clickedPodName = $(this).find('input').data('podName'); //which main pod was chosen

      $(`input[type='radio'][name='nc-pod']`)
        .filter(function() {
          //find the non-matching main pod assignment -- eg: if pod A was chosen by cn, choose pod C for nc
          return (!($(this).closest('div').hasClass('st-none'))) && ($(this).data('podName').indexOf(clickedPodName) < 0);
        })
        .prop("checked", true); // select it

      return true;
    });

    //compile the shift modifier checkbox template with Handlebars
    shiftModifierCheckboxTemplate = Handlebars.compile($("#hbt-shift-modifier-checkbox").html());
    staffPodSelectTemplate = Handlebars.compile($("#hbt-staff-pod-select").html());

  }); //End on document ready function

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

  function getStaffFromCheckboxes(names) {
    let jquerySelector = '';

    //iterate through the array of checkbox names to check for selected staff, building the query selector string
    names.forEach(function (name) {
      jquerySelector += `input[name='${name}'][type='checkbox']:checked, `;
    });
    //get rid of the last comma and space (', ')
    jquerySelector = jquerySelector.slice(0, -2);

    //find the selected staff, map the results into an array of object literals
    return $(jquerySelector).map(function () {
                              return {id: $(this).val(), name: $(this).data("staffName")};
                              })
                            .get();
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
  function popPodSelectList(target, staffList, podList) {
    let x = {pod: podList, staff: staffList};
    $(target).html(staffPodSelectTemplate(x));
  }

  /**
   * This hides staff choices in a target div element based on an array of specified divs
   * @param  string targetId    the id of the target div
   * @param  string[] hideBasedOn the id('s) of the divs to base the hiding on
   * @return void
   */
  function hideAlreadyPicked(targetId, hideBasedOn) {
    //reset all hidden
    $(`#${targetId} div.st-none`).each(function() {
      showFormInnerItem($(this).find('input'));
    });

    //foreach radio/checkbox name specified
    hideBasedOn.forEach(function(s) {
      //select any checked staff
      $(`input[name='${s}']:checked`).each(function() {
        //get the staff id (set as value)
        let val = $(this).val();
        //hide the staff choice from the current target
        hideFormInnerItem($(`#${targetId} input[value='${val}']`));
      });
    });
  }

  /**
   * Shows the inner inner-item
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
