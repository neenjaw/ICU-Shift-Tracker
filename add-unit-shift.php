<?php
include 'includes/pre-head.php';

if (!isset($_SESSION['user_session'])) {
  header("Location: index.php");
}
//FIXME - selecting NC doesnt limit CN
//FIXME - make it so not required to select NA or UC
//FIXME - make it so if no NA or UC selected, pod selection is also skipped
//FIXME - make it so if no NA or UC selected, shift submission doesnt try to fix it.

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

          <div class="form-navigation m-1 text-center">
            <button type="button" id="btn-prev" class="previous btn btn-secondary">&lt; Previous</button>
            <button type="button" id="btn-next" class="next btn btn-secondary">Next &gt;</button>
            <button type="submit" id="btn-submit" class="btn btn-secondary">Submit</button>
          </div>

          <div id="section-date-select" class="form-section form-inline mt-4 mb-4">

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
                <label class="btn btn-outline-primary active">
                  <input id="day-or-night-day" type="radio" name="day-or-night" value="D" autocomplete="off" checked required>
                  Day
                </label>
                <label class="btn btn-outline-primary">
                  <input id="day-or-night-night" type="radio" name="day-or-night" value="N" autocomplete="off">
                  Night
                </label>
              </div>
            </div>

          </div>

          <!-- Select Clinician/Charge -->
          <div id="section-nc-cn-select" class="form-section mt-4 mb-4">
            <!-- RN Clinician SELECT -->
            <div class="form-group">
              <label class="control-label requiredField" for="nc-select">
                Who is the Clinician for the shift?<span class="asteriskField">*</span>
              </label>
              <div id="nc-select-errors"></div>
              <div id="nc-select" class="staff-select-group p-0 m-0" data-populate-with-staff-group="RN" data-populate-type="radio" data-populate-prefix="nc" data-populate-required="true">
                <!-- dynamic staff select built here -->
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
              </div>

            </div>

            <!-- RN CHARGE SELECT -->
            <div id="cn-select-group" class="form-group">
              <label class="control-label requiredField" for="cn-select">
                Who is the Charge for the shift?<span class="asteriskField">*</span>
              </label>
              <div id="cn-select-errors"></div>
              <div id="cn-select" class="staff-select-group p-0 m-0" data-populate-with-staff-group="RN" data-populate-type="radio" data-populate-prefix="cn" data-populate-required="true">
                <!-- dynamic staff select built here -->
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
              </div>

            </div>

          </div>


          <div id="section-nc-cn-pod-select" class="form-section mt-4 mb-4">
            <!-- assign pods to the clinician/charge -->

            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Which pod was the Nurse Clinician in?<span class="asteriskField">*</span>
              </label>
              <div id="nc-pod-select-errors"></div>
              <div id="nc-pod-select" class="staff-select-group p-0 m-0">
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
                             name="nc-pod-select"
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
              <div id="cn-pod-select" class="staff-select-group p-0 m-0">
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
                             name="cn-pod-select"
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



          <!-- Floating nurse -->
          <div id="section-float-rn-select" class="form-section mt-4 mb-4">
            <div class="form-group">
              <label class="control-label" for="float-rn-check">
                Was there a float nurse?
              </label>
              <div id="float-rn-check-errors"></div>
              <div id="float-rn-check" class="staff-select-group p-0 m-0">
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-radio m-1">
                    <input id="float-rn-check-yes"
                    name="float-rn-check"
                    type="radio"
                    value="Yes"
                    required
                    data-parsley-errors-container="#float-rn-check-errors"
                    class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Yes</span>
                  </label>
                </div>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-radio m-1">
                    <input id="float-rn-check-no"
                    name="float-rn-check"
                    type="radio"
                    value="No"
                    checked
                    class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">No</span>
                  </label>
                </div>
              </div>
            </div>

            <div id="float-rn-select-group" class="form-group">
              <label class="control-label" for="float-rn-select">
                Who floated?
              </label>
              <div id="float-rn-select-errors"></div>
              <div id="float-rn-select" class="staff-select-group p-0 m-0" data-populate-with-staff-group="RN" data-populate-type="checkbox" data-populate-prefix="float-rn" data-populate-required="false">
                <!-- dynamic staff select built here -->
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
              </div>
            </div>
          </div>

          <div id="section-apod-rn-select" class="form-section mt-4 mb-4">
            <!-- Select Bedside Nurses for A -->

            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the nurses for Pod A<span class="asteriskField">*</span>
              </label>
              <div id="apod-rn-select-errors"></div>
              <div id="apod-rn-select" class="staff-select-group p-0 m-0" data-populate-with-staff-group="RN" data-populate-type="checkbox" data-populate-prefix="apod-rn" data-populate-required="true">
                <!-- dynamic staff select built here -->
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
              </div>

            </div>
          </div>

          <div id="section-bpod-rn-select" class="form-section mt-4 mb-4">
            <!-- Select Bedside Nurses for B -->

            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the nurses for Pod B<span class="asteriskField">*</span>
              </label>
              <div id="bpod-rn-select-errors"></div>
              <div id="bpod-rn-select" class="staff-select-group p-0 m-0" data-populate-with-staff-group="RN" data-populate-type="checkbox" data-populate-prefix="bpod-rn" data-populate-required="true">
                <!-- dynamic staff select built here -->
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
              </div>

            </div>
          </div>

          <div id="section-cpod-rn-select" class="form-section mt-4 mb-4">
            <!-- Select Bedside Nurses for C -->
            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the nurses for Pod C<span class="asteriskField">*</span>
              </label>
              <div id="cpod-rn-select-errors"></div>
              <div id="cpod-rn-select" class="staff-select-group p-0 m-0" data-populate-with-staff-group="RN" data-populate-type="checkbox" data-populate-prefix="cpod-rn" data-populate-required="true">
                <!-- dynamic staff select built here -->
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
              </div>

            </div>
          </div>

          <!-- Who had non-vent -->
          <div id="section-non-vent-mod-select" class="form-section mt-4 mb-4">
            <div class="form-group">
              <label class="control-label" for="div">
                Which nurses had only non-ventilated patients?
              </label>
              <div id="non-vent-mod-select" class="staff-select-group p-0 m-0">
                <!-- Add handlebars template here -->
              </div>
            </div>
          </div>

          <!-- Who had double -->
          <div id="section-double-mod-select" class="form-section mt-4 mb-4">
            <div class="form-group">
              <label class="control-label" for="div">
                Which nurses were doubled?
              </label>
              <div id="double-mod-select" class="staff-select-group p-0 m-0">
                <!-- Add handlebars template here -->
              </div>
            </div>
          </div>

          <!-- Who admitted -->
          <div id="section-admit-mod-select" class="form-section mt-4 mb-4">
            <div class="form-group">
              <label class="control-label" for="div">
                Which nurses admitted patients?
              </label>
              <div id="admit-mod-select" class="staff-select-group p-0 m-0">
                <!-- Add handlebars template here -->
              </div>
            </div>
          </div>

          <!-- Who had very sick -->
          <div id="section-very-sick-mod-select" class="form-section mt-4 mb-4">
            <div class="form-group">
              <label class="control-label" for="div">
                Which nurses had a very sick patient <small>(3 gtt's or more)</small>?
              </label>
              <div id="very-sick-mod-select" class="staff-select-group p-0 m-0">
                <!-- Add handlebars template here -->
              </div>
            </div>
          </div>

          <!-- Who had code pager -->
          <div id="section-code-pager-mod-select" class="form-section mt-4 mb-4">
            <div class="form-group">
              <label class="control-label" for="div">
                Which nurses had the code pager?
              </label>
              <div id="code-pager-mod-select" class="staff-select-group p-0 m-0">
                <!-- Add handlebars template here -->
              </div>
            </div>
          </div>

          <!-- Who had crrt -->
          <div id="section-crrt-mod-select" class="form-section mt-4 mb-4">
            <div class="form-group">
              <label class="control-label" for="div">
                Which nurses had crrt?
              </label>
              <div id="crrt-mod-select" class="staff-select-group p-0 m-0">
                <!-- Add handlebars template here -->
              </div>
            </div>
          </div>

          <!-- Who had evd -->
          <div id="section-evd-mod-select" class="form-section mt-4 mb-4">
            <div class="form-group">
              <label class="control-label" for="div">
                Which nurses had an EVD?
              </label>
              <div id="evd-mod-select" class="staff-select-group p-0 m-0">
                <!-- Add handlebars template here -->
              </div>
            </div>
          </div>

          <!-- Who who had burn -->
          <div id="section-burn-mod-select" class="form-section mt-4 mb-4">
            <div class="form-group">
              <label class="control-label" for="div">
                Which nurses had a burn patient?
              </label>
              <div id="burn-mod-select" class="staff-select-group p-0 m-0">
                <!-- Add handlebars template here -->
              </div>
            </div>
          </div>

          <div id="section-outreach-rn-select" class="form-section mt-4 mb-4">
            <!-- Select Bedside Nurses for C -->

            <div class="form-group">
              <label class="control-label requiredField" for="outrach-rn">
                Who was on outreach?<span class="asteriskField">*</span>
              </label>
              <div id="outreach-rn-select-errors"></div>
              <div id="outreach-rn-select" class="staff-select-group p-0 m-0" data-populate-with-staff-group="RN" data-populate-type="radio" data-populate-prefix="outreach-rn" data-populate-required="true">
                <!-- dynamic staff select built here -->
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
              </div>

            </div>
          </div>

          <div id="section-na-select" class="form-section mt-4 mb-4">
            <!-- Select NA's -->
            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the NA's<span class="asteriskField">*</span>
              </label>
              <div id="na-select-errors"></div>
              <div id="na-select" class="staff-select-group p-0 m-0" data-populate-with-staff-group="NA,LPN" data-populate-type="checkbox" data-populate-prefix="na" data-populate-required="false">
                <!-- dynamic staff select built here -->
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
              </div>

            </div>
          </div>

          <!-- assign pods to the na's -->
          <div id="section-na-pod-select" class="form-section mt-4 mb-4">
            <!-- dynamic pod select template generated here -->
          </div>

          <div id="section-uc-select" class="form-section mt-4 mb-4">
            <!-- Select UC's -->
            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the UC's<span class="asteriskField">*</span>
              </label>
              <div id="uc-select-errors"></div>
              <div id="uc-select" class="staff-select-group p-0 m-0" data-populate-with-staff-group="UC" data-populate-type="checkbox" data-populate-prefix="uc" data-populate-required="false">
                <!-- dynamic staff select built here -->
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
              </div>
            </div>
          </div>

          <!-- assign pods to the uc's -->
          <div id="section-uc-pod-select" class="form-section mt-4 mb-4">
            <!-- dynamic pod select template generated here -->
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

        <!-- <p id="step-x-of-y" class="text-center"></p> -->
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

  <!-- Bootstrap Modal -->
  <div id="submission-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <!-- submission modal content -->
      <div class="modal-content" id="shift-detail-modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Submission Details:</h5>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body" id="submission-modal-body"></div>
        <div class="modal-footer">
          <button id="close-modal" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.submission modal content -->
    </div>
  </div>


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
  var debug = true;

  var shiftModifierCheckboxTemplate = null;
  var staffPodSelectTemplate = null;

  var lastDate = null;
  var $disabledPrn = null;

  var staffList = {}; //Object of all the staff not previously selected for the date to be added
  var bedsideRnStaffList = [];
  var assignmentList = JSON.parse('<?= json_encode($crud->getAllAssignmentObj()) ?>');
  var roleList = JSON.parse('<?= json_encode($crud->getAllRoleObj()) ?>');

  var $sections = null;

  var dateChangeTimer; //variable to prevent ajax request for staff to not update too often
  var dateChangeTimerInterval = 3000;

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
    $sections = $('.form-section'); // list all all the form-section elements
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
      //$('#step-x-of-y').html(`Step ${index + 1} of ${$sections.length}`);

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

        let currentSectionId = $('.current').prop('id');

        if ( currentSectionId == 'section-nc-cn-select' ) {
          //getStaffFilteredByDate($('#date').val());

        } else if ( currentSectionId == 'section-float-rn-select' ) {
          hideAlreadyPicked('#float-rn-select', ['nc-select', 'cn-select']);

        } else if ( currentSectionId == 'section-apod-rn-select' ) {
          hideAlreadyPicked('#apod-rn-select', ['nc-select', 'cn-select', 'float-rn-select']);

        } else if ( currentSectionId == 'section-bpod-rn-select' ) {
          hideAlreadyPicked('#bpod-rn-select', ['nc-select', 'cn-select', 'float-rn-select', 'apod-rn-select']);

        } else if ( currentSectionId == 'section-cpod-rn-select' ) {
          hideAlreadyPicked('#cpod-rn-select', ['nc-select', 'cn-select', 'float-rn-select', 'apod-rn-select', 'bpod-rn-select']);

        } else if ( currentSectionId == 'section-outreach-rn-select' ) {
          hideAlreadyPicked('#outreach-rn-select', ['nc-select', 'cn-select', 'float-rn-select', 'apod-rn-select', 'bpod-rn-select', 'cpod-rn-select']);

        } else if ( currentSectionId == 'section-non-vent-mod-select' ) {
          bedsideRnStaffList = getStaffFromCheckboxes(['apod-rn-select', 'bpod-rn-select', 'cpod-rn-select']);
          popStaffShiftModifierList('#non-vent-mod-select', 'non-vent-mod-select', bedsideRnStaffList);

        } else if ( currentSectionId == 'section-double-mod-select' ) {
          popStaffShiftModifierList('#double-mod-select', 'double-mod-select', bedsideRnStaffList);

        } else if ( currentSectionId == 'section-admit-mod-select' ) {
          popStaffShiftModifierList('#admit-mod-select', 'admit-mod-select', bedsideRnStaffList);

        } else if ( currentSectionId == 'section-very-sick-mod-select' ) {
          popStaffShiftModifierList('#very-sick-mod-select', 'very-sick-mod-select', bedsideRnStaffList);

        } else if ( currentSectionId == 'section-code-pager-mod-select' ) {
          popStaffShiftModifierList('#code-pager-mod-select', 'code-pager-mod-select', bedsideRnStaffList);

        } else if ( currentSectionId == 'section-crrt-mod-select' ) {
          popStaffShiftModifierList('#crrt-mod-select', 'crrt-mod-select', bedsideRnStaffList);

        } else if ( currentSectionId == 'section-evd-mod-select' ) {
          popStaffShiftModifierList('#evd-mod-select', 'evd-mod-select', bedsideRnStaffList);

        } else if ( currentSectionId == 'section-burn-mod-select' ) {
          popStaffShiftModifierList('#burn-mod-select', 'burn-mod-select', bedsideRnStaffList);

        } else if ( currentSectionId == 'section-na-pod-select' ) {
          popPodSelectList('#section-na-pod-select', 'na-pod-select', getStaffFromCheckboxes(['na-select']), assignmentList);
          setParsleyJsGroup('#section-na-pod-select', $('#section-na-pod-select').data('blockIndex'));

        } else if ( currentSectionId == 'section-uc-pod-select' ) {
          popPodSelectList('#section-uc-pod-select', 'uc-pod-select', getStaffFromCheckboxes(['uc-select']), assignmentList);
          setParsleyJsGroup('#section-uc-pod-select', $('#section-uc-pod-select').data('blockIndex'));

        }
      });
    });

    // Prepare sections by setting the `data-parsley-group` attribute to 'block-0', 'block-1', etc.
    $sections.each(function(index, section) {
      $(this).data('blockIndex', index);
      setParsleyJsGroup(section, index);
    });
    navigateTo(0); // Start at the beginning

    //catch the on-submit event, collect/format data from the form, submit via ajax
    $('#unit-shift-form').parsley().on('form:submit', function () {
      submitUnitShiftForm();
      return false;
    });

    /***************************************
     * END -- FORM PAGINATION / VALIDATION *
     ***************************************/

    //call the function to set listeners on the div's that contain the checkboxes to make more accessible
    setClickAreaListeners("div.staff-select-group");
    //hide the option for the nc to select pod 'A/B/C' when the day shift button is preselected (default state)
    hideFormInnerItem($(`#nc-pod-8`));

    /**
     * listener which disables/clear chage nurse value depending on nurse clinician value
     * @var [type]
     */
    $(`#nc-select div.inner-item`).click(function() { // FIXME -- this is a bad call, only calls at the beginning.
      if ($disabledPrn !== null) {
          enableFormInnerItem($disabledPrn);
      }
      let $ncChoice = $(this).find("input[type='radio']");

      let $elem = $(`input[type='radio'][name='cn-select'][value='${$ncChoice.val()}']`);

      if ($elem !== null) {
        disableFormInnerItem($elem);
        $disabledPrn = $elem;
      }
    });

    /**
     * listener to change behavior of form if float nurse is to be selected
     * @var [type]
     */
    $(`#float-rn-check-yes`).closest('div').click(function() {
      $(`#float-rn-select-group`).toggle(true); //show float nurse select
      $(`input[name='float-rn-select']`).first().prop("required", true); // add the required property to the float-rn-select select
    });

    /**
     * listener to change behavior of form if no float nurse is to be added
     * @var [type]
     */
    $(`#float-rn-check-no`).closest('div').click(function() {
      $(`#float-rn-select-group`).toggle(false); //show float nurse select
      $(`input[name='float-rn-select']`).first().prop("required", false); // add the required property to the float-rn-select select

      let $frnElem = $(`input[type='checkbox'][name='float-rn-select']:checked`); //unselect any selected float-rn-select value
      if ($frnElem !== null) { $frnElem.prop("checked", false); }
    });


    /**
     * listener to change behavior of form if day shift is selected for input
     * @var [type]
     */
    $(`#day-or-night-day`).closest('label').click(function() {
      $(`#cn-select-group`).toggle(true); // show charge nurse select
      $(`#section-nc-cn-pod-select`).toggleClass('skip-section', false); // show section for pod selection for nc/cn

      $(`input[name='cn-select']`).first().prop("required", true); // add the required property to the first cn-select
      $(`#cn-pod-select input`).first().prop("required", true); // add the required property to the first cn-pod-select

      hideFormInnerItem($(`#nc-pod-8`));
    });

    /**
     * listener to change behavior of form if night shift is selected for input
     * @var [type]
     */
    $(`#day-or-night-night`).closest('label').click(function() {
      $(`#cn-select-group`).toggle(false); // hide charge nurse select

      $(`#section-nc-cn-pod-select`).toggleClass('skip-section', true); // hide section for pod selection for nc/cn

      $(`input[name='cn-select'][required]`).prop("required", false); // remove the required property from the cn-select select
      $(`input[name='cn-pod-select'][required]`).prop("required", false); // remove the required property from the cn-select select

      showFormInnerItem($(`#nc-pod-8`)); //auto-select pod A/B/C for the nc
      $(`#nc-pod-8`).prop("checked", true);

      let $cnElem = $(`input[type='radio'][name='cn-select']:checked`); //unselect any selected cn-select value
      if ($cnElem !== null) { $cnElem.prop("checked", false); }

      let $cnPodElem = $(`input[type='radio'][name='cn-pod-select']:checked`); //unselect any selected cn-select value
      if ($cnPodElem !== null) { $cnPodElem.prop("checked", false); }
    });

    /**
     * when the nc's assigned pod is clicked, the charge nurse's pod changes to the appropriate selection
     * @var [type]
     */
    $(`#nc-pod-select div.inner-item`).click(function() {
      let clickedPodName = $(this).find('input').data('podName').replace(/[\/B]/g, ''); //which main pod was chosen, get rid of the B-pod

      $(`input[type='radio'][name='cn-pod-select']`)
        .filter(function() {
          //find the non-matching main pod assignment -- eg: if pod A was chosen by nc, choose pod C for cn
          return (!($(this).closest('div').hasClass('st-none'))) && ($(this).data('podName').indexOf(clickedPodName) < 0);
        })
        .prop("checked", true); //select it

      return true;
    });

    /**
     * when the cn's assigned pod is clicked, the nc's pod changes to the appropriate selection
     * @var [type]
     */
    $(`#cn-pod-select div.inner-item`).click(function() {
      let clickedPodName = $(this).find('input').data('podName'); //which main pod was chosen

      $(`input[type='radio'][name='nc-pod-select']`)
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

  function setParsleyJsGroup(section, index) {
    return $(section).find(':input').attr('data-parsley-group', 'block-' + index);
  }

  function setClickAreaListeners(target) {
    //listener for click in the div to increase radio/checkbox active area
    $(target).find(`div.inner-item`).each(function(){
      $(this).click(function() {
        var $elem = $(this).find("input[type='checkbox'], input[type='radio']"); // find checkbox associated
        if (!$elem.prop("disabled")) {
          $elem.prop("checked", !($elem.prop("checked"))); // toggle checked state
        }
        return false; // return false to stop click propigation
      });
    })
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
    setClickAreaListeners(`${target}`);
  }

  /**
   * [popNaPodSelectList description]
   * @return [type] [description]
   */
  function popPodSelectList(target, sectionName, staffList, podList) {
    let x = {section: sectionName, pod: podList, staff: staffList};
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
    $(`${targetId} div.st-none`).each(function() {
      showFormInnerItem($(this).find('input'));
    });

    //foreach radio/checkbox name specified
    hideBasedOn.forEach(function(s) {
      //select any checked staff
      $(`input[name='${s}']:checked`).each(function() {
        //get the staff id (set as value)
        let val = $(this).val();
        //hide the staff choice from the current target
        hideFormInnerItem($(`${targetId} input[value='${val}']`));
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

  function submitUnitShiftForm() {
    let assignmentLookup = createAssignmentLookup(assignmentList);
    let roleLookup = createRoleLookup(roleList);

    let submission = [];
    let formData = [];
    let serializedForm = $('#unit-shift-form').serializeArray();

    // console.log(serializedForm);

    for( let i=0; i < serializedForm.length; i++ ) {
      let formPropertyName = serializedForm[i].name;
      formPropertyName = formPropertyName.replace(/\[\]$/, '');

      formData[formPropertyName] = formData[formPropertyName] || [];

      formData[formPropertyName].push(serializedForm[i].value);
    }

    let nonVentLookup = createModLookup(formData['non-vent-mod-select'] || []);
    let doubleLookup = createModLookup(formData['double-mod-select'] || []);
    let vSickLookup = createModLookup(formData['very-sick-mod-select'] || []);
    let crrtLookup = createModLookup(formData['crrt-mod-select'] || []);
    let admitLookup = createModLookup(formData['admit-mod-select'] || []);
    let codePgLookup = createModLookup(formData['code-pager-mod-select'] || []);
    let evdLookup = createModLookup(formData['evd-mod-select'] || []);
    let burnLookup = createModLookup(formData['burn-mod-select'] || []);

    let date = formData['date'][0];
    let dayOrNight = formData['day-or-night'][0];

    // console.log(formData);

    //add the clinician to the submission array
    submission.push(createStaffEntryObj(
      formData['nc-select'][0], formData['date'][0], roleLookup['Clinician'], formData['nc-pod-select'][0], dayOrNight
    ));

    //check if charge nurse exists, if it does, push it too.
    if (dayOrNight === 'D') {
      submission.push(createStaffEntryObj(
        formData['cn-select'][0], formData['date'][0], roleLookup['Charge'], formData['cn-pod-select'][0], dayOrNight
      ));
    }

    //float
    if ( formData['float-rn-check'][0] === "Yes" ) {
      for ( let i = 0; i < formData['float-rn-select'].length; i++ ) {
        submission.push(createStaffEntryObj(
          formData['float-rn-select'][i], formData['date'][0], roleLookup['Bedside'], assignmentLookup['Float'], dayOrNight
        ));
      }
    }


    //apod
    for ( let i = 0; i < formData['apod-rn-select'].length; i++ ) {
      let sid = formData['apod-rn-select'][i];

      submission.push(createStaffEntryObj(
        sid, date, roleLookup['Bedside'], assignmentLookup['A'], dayOrNight,
          isModSelected(sid, nonVentLookup),
          isModSelected(sid, doubleLookup),
          isModSelected(sid, vSickLookup),
          isModSelected(sid, crrtLookup),
          isModSelected(sid, admitLookup),
          isModSelected(sid, codePgLookup),
          isModSelected(sid, evdLookup),
          isModSelected(sid, burnLookup)
      ));
    }

    //bpod
    for ( let i = 0; i < formData['bpod-rn-select'].length; i++ ) {
      let sid = formData['bpod-rn-select'][i];

      submission.push(createStaffEntryObj(
        sid, date, roleLookup['Bedside'], assignmentLookup['B'], dayOrNight,
          isModSelected(sid, nonVentLookup),
          isModSelected(sid, doubleLookup),
          isModSelected(sid, vSickLookup),
          isModSelected(sid, crrtLookup),
          isModSelected(sid, admitLookup),
          isModSelected(sid, codePgLookup),
          isModSelected(sid, evdLookup),
          isModSelected(sid, burnLookup)
      ));
    }

    //cpod
    for ( let i = 0; i < formData['cpod-rn-select'].length; i++ ) {
      let sid = formData['cpod-rn-select'][i];

      submission.push(createStaffEntryObj(
        sid, date, roleLookup['Bedside'], assignmentLookup['C'], dayOrNight,
          isModSelected(sid, nonVentLookup),
          isModSelected(sid, doubleLookup),
          isModSelected(sid, vSickLookup),
          isModSelected(sid, crrtLookup),
          isModSelected(sid, admitLookup),
          isModSelected(sid, codePgLookup),
          isModSelected(sid, evdLookup),
          isModSelected(sid, burnLookup)
      ));
    }

    //outreach
    for ( let i = 0; i < formData['outreach-rn-select'].length; i++ ) {
      let sid = formData['outreach-rn-select'][i];

      submission.push(createStaffEntryObj(
        sid, date, roleLookup['Outreach'], assignmentLookup['Float'], dayOrNight
      ));
    }

    //na
    for ( let i = 0; i < formData['na-select'].length; i++ ) {
      let sid = formData['na-select'][i];

      submission.push(createStaffEntryObj(
        sid, date, roleLookup['NA'], formData[`na-pod-select-${sid}`][0], dayOrNight
      ));
    }

    //uc
    for ( let i = 0; i < formData['uc-select'].length; i++ ) {
      let sid = formData['uc-select'][i];

      submission.push(createStaffEntryObj(
        sid, date, roleLookup['UC'], formData[`uc-pod-select-${sid}`][0], dayOrNight
      ));
    }

    if (debug) { console.log(submission); }

    submitUnitShifts(submission);
  }

  function createStaffEntryObj(staffId, date, roleId, assignmentId, dayOrNight,
    nonVent = false, doubled = false, vsick = false, crrt = false, admit = false, codepg = false, evd = false, burn = false) {

    let staffEntry = {
            staff : staffId,
            date : date,
            role : roleId,
            assignment : assignmentId,
            dayornight : dayOrNight,
            nonvent : nonVent,
            doubled : doubled,
            vsick : vsick,
            crrt : crrt,
            admit : admit,
            codepg : codepg,
            evd : evd,
            burn : burn
          };

    return staffEntry;
  }

  function createAssignmentLookup(assignmentObjArr) {
    let aArray = [];

    for(let i = 0; i < assignmentObjArr.length; i++) {
      aArray[assignmentObjArr[i].assignment] = assignmentObjArr[i].id;
    }

    return aArray;
  }

  function createRoleLookup(roleObjArray) {
    let rArray = [];

    for(let i = 0; i < roleObjArray.length; i++) {
      rArray[roleObjArray[i].role] = roleObjArray[i].id;
    }

    return rArray;
  }

  function createModLookup(modSelectArray) {
    let mArray = [];

    for ( let i = 0; i < modSelectArray.length; i++ ) {
      mArray[modSelectArray[i]] = true;
    }

    return mArray;
  }

  function isModSelected(staffId, modLookup) {
    let b = false;

    if ( (typeof(modLookup) != 'undefined') && (typeof(modLookup[staffId]) != 'undefined') ) { b = true; }

    return b;
  }

  function submitUnitShifts(submissionData) {
    submissionData = submissionData || []; // catch null/undefined arguments

    if ( submissionData === [] ) {
      if (debug) { console.log("Warning: no data passed to submit via ajax handler"); }
      return;
    }

    $.ajax({
  	   url: 'ajax/ajax_add_multi_shift_process.php',
  	   type: 'post',
  	   data: {"shiftData" : JSON.stringify(submissionData)},
       beforeSend: function () {
         if (debug) { console.log("AJAX sent."); }
         $('#submission-modal-body').html(`<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>`);
         $('#submission-modal').modal('show');	//show the modal
       },
  	   success: function(data) {
         if (debug) { console.log("AJAX returned."); }

         if (data === "ok") {

           if (debug) { console.log("Data submission ok."); }
    	     $('#submission-modal-body').html("<h3>Success!</h3><p>click close to reset the form.</p>");
           $('#modal-close').on('click', function(){
             location.reload();
           });

         } else {

           if (debug) { console.log("Data submission not ok."); }
           $('#submission-modal-body').html(`<h3>There was a problem!</h3><p>${data}</p><p>Click close, find the problem, resubmit.</p>`);

         }

         if (debug) { console.log(data); }
  	   }
  	});
  }

  function getStaffFilteredByDate(date) {
    date = date || null;

    if (date === null) { return null; }
    if (date === lastDate) { return false; }

    $.ajax({
  	   url: 'ajax/ajax_get_staff.php',
  	   type: 'post',
  	   data: `date=${date}`,
       beforeSend: function () {

       },
  	   success: function(data) {
         if (debug) { console.log("AJAX returned."); }

         if (data !== 'Not ok.') {
           lastDate = date;
           staffList = JSON.parse(data);

           if (debug) { console.log(staffList); }

           populateStaffSelect(staffList);
         }
  	   }
  	});
  }

  function populateStaffSelect(list) {
    $('div[data-populate-with-staff-group]').each(function(index, element) {
      let group = $( this ).data('populateWithStaffGroup').split(',');
      let type = $( this ).data('populateType');
      let prefix = $( this ).data('populatePrefix');
      let required = $( this ).data('populateRequired');

      if (group.length == 0) throw `'data-populate-with-staff-group' attribute requires at least 1 group to be specified`;

      $( this ).empty();
      for (let i = 0; i < group.length; i++) {
        if (group[i] in list) {
          createCustomSelect($( this ), type, required, prefix, list[group[i]]);
        }
      }
      setParsleyJsGroup($(this), $( this ).closest('div.form-section').data('blockIndex'));
      setClickAreaListeners($(this));
    });
  }

  function createCustomSelect($container, type, required, prefix, staff) {
    let first = true; //boolean flag for first iteration
    for (let i = 0; i < staff.length; i++) {
      //create wrapper div, set classes, append to fragment
      let $div = $('<div></div>').addClass(`inner-item list-group-item-action`);
      $container.append($div);

      //create child label, wrapper for input, span contents
      let $label = $('<label></label>').addClass(`custom-control custom-${type} m-1`);
      $div.append($label);

      //create input with properties, on first iteration add extra properties as specified
      let $input = $('<input></input>')
                    .prop("id", `${prefix}-${staff[i].id}`)
                    .prop("name", `${prefix}-select`)
                    .prop("type", `${type}`)
                    .prop("value", `${staff[i].id}`)
                    .attr("data-staff-name", `${staff[i].name} (${staff[i].category})`)
                    .addClass('custom-control-input');
      if (first) {
        $input.prop("required", required);
        $input.attr("data-parsley-errors-container", `#${prefix}-select-errors`);
      }
      $label.append($input);

      //create control indicator span
      $label.append($('<span></span>')
                      .addClass('custom-control-indicator'));

      //create description span
      $label.append($('<span></span>')
                      .addClass('custom-control-description')
                      .text(`${staff[i].name} (${staff[i].category})`));

      //set first iteration boolean flag to false
      first = false;
    }

    //return the DOM fragement
    return $container;
  }

  </script>
  <!-- END Aux Scripts -->

  <!-- Footer Include -->
  <?php include 'includes/footer.php'; ?>
  <!-- END Footer Include -->

</body>

</html>
