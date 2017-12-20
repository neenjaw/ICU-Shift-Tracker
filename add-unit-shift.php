<?php
include 'includes/pre-head.php';

if (!isset($_SESSION['user'])) {
  header("Location: index.php");
}
?>

<!DOCTYPE html>
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
        <!-- <form id="unit-shift-form" class="unit-shift-form"  data-parsley-validate > -->

          <div class="form-navigation m-1 text-center">
            <button type="button" class="previous btn btn-secondary">&lt; Previous</button>
            <button type="button" class="next btn btn-secondary">Next &gt;</button>
            <button type="button" class="submit btn btn-secondary">Submit</button>
          </div>

          <!-- SHIFT SELECT -->
          <div id="section-date" class="form-section form-inline mt-4 mb-4">
            <form id="section-date-form">
              <div class="form-group">

                <!-- DATE SELECT -->
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
                <!-- END DATE SELECT -->

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
                <!-- END DAY / NIGHT SELECT -->

              </div>
            </form>
          </div>
          <!-- END SHIFT SELECT -->

          <!-- Select Clinician/Charge -->
          <div id="section-nc_cn" class="form-section mt-4 mb-4">
            <form id="section-nc_cn-form">

              <!-- RN Clinician SELECT -->
              <div id="nc-subsection" class="form-group">
                <label class="control-label requiredField" for="nc">
                  Who is the Clinician for the shift?<span class="asteriskField">*</span>
                </label>
                <div id="nc-errors"></div>
                <div id="nc"
                  class="aus-form-group"
                  data-populate-staff-list="rn"
                  data-populate-type="radio"
                  data-populate-prefix="nc"
                  data-populate-required="true">

                  <!-- dynamic staff select built here -->
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>

                </div>
              </div>
              <!-- END RN Clinician SELECT -->

              <!-- RN CHARGE SELECT -->
              <div id="cn-subsection" class="form-group">
                <label class="control-label requiredField" for="cn">
                  Who is the Charge for the shift?<span class="asteriskField">*</span>
                </label>
                <div id="cn-errors"></div>
                <div id="cn"
                  class="aus-form-group"
                  data-populate-staff-list="rn"
                  data-populate-type="radio"
                  data-populate-prefix="cn"
                  data-populate-required="true">

                  <!-- dynamic staff select built here -->
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>

                </div>
              </div>
              <!-- END RN CHARGE SELECT -->

            </form>
          </div>
          <!-- END Select Clinician/Charge -->

          <!-- assign pods to the clinician/charge -->
          <div id="section-nc_cn_pod" class="form-section mt-4 mb-4">
            <form id="section-nc_cn_pod-form">

              <!-- Assign Clinician Pod -->
              <div class="form-group">
                <label class="control-label requiredField" for="select">
                  Which pod was the Nurse Clinician in?<span class="asteriskField">*</span>
                </label>
                <div id="nc_pod-errors"></div>
                <div id="nc_pod"
                  class="aus-form-group"
                  data-populate-staff-list="rn"
                  data-populate-staff-matching="nc"
                  data-populate-assignment-matching="A/B,B/C"
                  data-populate-type="assignmentselect"
                  data-populate-prefix="nc_pod"
                  data-populate-required="true">

                  <!-- dynamic pod select built here -->
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>

                </div>

              </div>

              <div class="form-group">
                <label class="control-label requiredField" for="cn-pod">
                  Which pod was the Charge Nurse in?<span class="asteriskField">*</span>
                </label>
                <div id="cn_pod-errors"></div>
                <div id="cn_pod"
                  class="aus-form-group"
                  data-populate-staff-list="rn"
                  data-populate-staff-matching="cn"
                  data-populate-assignment-matching="A,C"
                  data-populate-type="assignmentselect"
                  data-populate-prefix="cn_pod"
                  data-populate-required="true">

                  <!-- dynamic pod select built here -->
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>

                </div>
              </div>

            </form>
          </div>
          <!-- END assign pods to the clinician/charge -->


          <!-- Floating nurse -->
          <div id="section-float-rn" class="form-section mt-4 mb-4">
            <form id="section-float_rn-form">

              <div id="float_rn-check-subsection" class="form-group">
                <label class="control-label" for="float-rn-check">
                  Was there a float nurse?
                </label>
                <div id="float_rn-check-errors"></div>
                <div id="float_rn-check" class="staff-group">
                  <div class="form-check inner-item list-group-item-action">
                    <label class="form-check-radio m-1">
                      <input id="float_rn-check-yes"
                        name="float_rn-check"
                        type="radio"
                        value="Yes"
                        required
                        data-parsley-errors-container="#float-rn-check-errors"
                        class="form-check-input">
                      Yes
                    </label>
                  </div>
                  <div class="form-check inner-item list-group-item-action">
                    <label class="form-check-radio m-1">
                      <input id="float_rn-check-no"
                        name="float_rn-check"
                        type="radio"
                        value="No"
                        checked
                        class="form-check-input">
                      No
                    </label>
                  </div>
                </div>
              </div>

              <div id="float_rn-subsection" class="form-group">
                <label class="control-label" for="float-rn">
                  Who floated?
                </label>
                <div id="float_rn-errors"></div>
                <div id="float_rn"
                  class="aus-form-group"
                  data-populate-staff-list="rn"
                  data-populate-staff-excluding="cn,nc"
                  data-populate-type="checkbox"
                  data-populate-prefix="float_rn"
                  data-populate-required="false">

                  <!-- dynamic pod select built here -->
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>

                </div>
              </div>

            </form>
          </div>

          <div id="section-apod_rn" class="form-section mt-4 mb-4">
            <form id="section-apod_rn-form">

              <!-- Select Bedside Nurses for A -->
              <div class="form-group">
                <label class="control-label requiredField" for="select">
                  Select the nurses for Pod A<span class="asteriskField">*</span>
                </label>
                <div id="apod_rn-errors"></div>
                <div id="apod_rn"
                  class="aus-form-group"
                  data-populate-staff-list="rn"
                  data-populate-staff-excluding="cn,nc,float_rn"
                  data-populate-type="checkbox"
                  data-populate-prefix="apod_rn"
                  data-populate-required="true">

                  <!-- dynamic pod select built here -->
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>
                </div>
              </div>

            </form>
          </div>

          <div id="section-bpod_rn" class="form-section mt-4 mb-4">
            <form id="section-bpod_rn-form">

              <!-- Select Bedside Nurses for B -->
              <div class="form-group">
                <label class="control-label requiredField" for="select">
                  Select the nurses for Pod B<span class="asteriskField">*</span>
                </label>
                <div id="bpod_rn-errors"></div>
                <div id="bpod_rn"
                  class="aus-form-group"
                  data-populate-staff-list="rn"
                  data-populate-staff-excluding="cn,nc,float_rn,apod_rn"
                  data-populate-type="checkbox"
                  data-populate-prefix="bpod_rn"
                  data-populate-required="true">

                  <!-- dynamic pod select built here -->
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>
                </div>
              </div>

            </form>
          </div>

          <div id="section-cpod_rn" class="form-section mt-4 mb-4">
            <form id="section-cpod_rn-form">

              <!-- Select Bedside Nurses for C -->
              <div class="form-group">
                <label class="control-label requiredField" for="select">
                  Select the nurses for Pod C<span class="asteriskField">*</span>
                </label>
                <div id="cpod_rn-errors"></div>
                <div id="cpod_rn"
                  class="aus-form-group"
                  data-populate-staff-list="rn"
                  data-populate-staff-excluding="cn,nc,float_rn,apod_rn,bpod_rn"
                  data-populate-type="checkbox"
                  data-populate-prefix="cpod_rn"
                  data-populate-required="true">

                  <!-- dynamic pod select built here -->
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>
                </div>
              </div>

            </form>
          </div>

          <!-- Who had non-vent -->
          <div id="section-non_vent_mod" class="form-section mt-4 mb-4">
            <form id="section-non_vent_mod-form">

              <div class="form-group">
                <label class="control-label" for="div">
                  Which nurses had only non-ventilated patients?
                </label>
                <div id="non_vent_mod"
                  class="aus-form-group"
                  data-populate-staff-list="rn"
                  data-populate-staff-matching="apod_rn,bpod_rn,cpod_rn"
                  data-populate-type="checkbox"
                  data-populate-prefix="non_vent_mod"
                  data-populate-required="false">

                  <!-- dynamic pod select built here -->
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>
                </div>
              </div>

            </form>
          </div>

          <!-- Who had double -->
          <div id="section-double_mod" class="form-section mt-4 mb-4">
            <form id="section-double_mod-form">

              <div class="form-group">
                <label class="control-label" for="div">
                  Which nurses were doubled?
                </label>
                <div id="double_mod"
                  class="aus-form-group"
                  data-populate-staff-list="rn"
                  data-populate-staff-matching="apod_rn,bpod_rn,cpod_rn"
                  data-populate-type="checkbox"
                  data-populate-prefix="double_mod"
                  data-populate-required="false">

                  <!-- dynamic pod select built here -->
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>
                </div>
              </div>

            </form>
          </div>

          <!-- Who admitted -->
          <div id="section-admit_mod" class="form-section mt-4 mb-4">
            <form id="section-admit_mod-form">

              <div class="form-group">
                <label class="control-label" for="div">
                  Which nurses admitted patients?
                </label>
                <div id="admit_mod"
                  class="aus-form-group"
                  data-populate-staff-list="rn"
                  data-populate-staff-matching="apod_rn,bpod_rn,cpod_rn"
                  data-populate-type="checkbox"
                  data-populate-prefix="admit_mod"
                  data-populate-required="false">

                  <!-- dynamic pod select built here -->
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>
                </div>
              </div>

            </form>
          </div>

          <!-- Who had very sick -->
          <div id="section-very_sick_mod" class="form-section mt-4 mb-4">
            <form id="section-very_sick_mod-form">

              <div class="form-group">
                <label class="control-label" for="div">
                  Which nurses had a very sick patient <small>(3 gtt's or more)</small>?
                </label>
                <div id="very_sick_mod"
                  class="aus-form-group"
                  data-populate-staff-list="rn"
                  data-populate-staff-matching="apod_rn,bpod_rn,cpod_rn"
                  data-populate-type="checkbox"
                  data-populate-prefix="very_sick_mod"
                  data-populate-required="false">

                  <!-- dynamic pod select built here -->
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>
                </div>
              </div>

            </form>
          </div>

          <!-- Who had code pager -->
          <div id="section-code_pager_mod" class="form-section mt-4 mb-4">
            <form id="section-code_pager_mod-form">

              <div class="form-group">
                <label class="control-label" for="div">
                  Which nurses had the code pager?
                </label>
                <div id="code_pager_mod"
                  class="aus-form-group"
                  data-populate-staff-list="rn"
                  data-populate-staff-matching="apod_rn,bpod_rn,cpod_rn"
                  data-populate-type="checkbox"
                  data-populate-prefix="code_pager_mod"
                  data-populate-required="false">

                  <!-- dynamic pod select built here -->
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>
                </div>
              </div>

            </form>
          </div>

          <!-- Who had crrt -->
          <div id="section-crrt_mod" class="form-section mt-4 mb-4">
            <form id="section-crrt_mod-form">

              <div class="form-group">
                <label class="control-label" for="div">
                  Which nurses had crrt?
                </label>
                <div id="crrt_mod"
                  class="aus-form-group"
                  data-populate-staff-list="rn"
                  data-populate-staff-matching="apod_rn,bpod_rn,cpod_rn"
                  data-populate-type="checkbox"
                  data-populate-prefix="crrt_mod"
                  data-populate-required="false">

                  <!-- dynamic pod select built here -->
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>
                </div>
              </div>

            </form>
          </div>

          <!-- Who had evd -->
          <div id="section-evd_mod" class="form-section mt-4 mb-4">
            <form id="section-evd_mod-form">

              <div class="form-group">
                <label class="control-label" for="div">
                  Which nurses had an EVD?
                </label>
                <div id="evd_mod"
                  class="aus-form-group"
                  data-populate-staff-list="rn"
                  data-populate-staff-matching="apod_rn,bpod_rn,cpod_rn"
                  data-populate-type="checkbox"
                  data-populate-prefix="evd_mod"
                  data-populate-required="false">

                  <!-- dynamic pod select built here -->
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>
                </div>
              </div>

            </form>
          </div>

          <!-- Who who had burn -->
          <div id="section-burn_mod" class="form-section mt-4 mb-4">
            <form id="section-burn_mod-form">

              <div class="form-group">
                <label class="control-label" for="div">
                  Which nurses had a burn patient?
                </label>
                <div id="burn_mod"
                  class="aus-form-group"
                  data-populate-staff-list="rn"
                  data-populate-staff-matching="apod_rn,bpod_rn,cpod_rn"
                  data-populate-type="checkbox"
                  data-populate-prefix="burn_mod"
                  data-populate-required="false">

                  <!-- dynamic pod select built here -->
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>
                </div>
              </div>

            </form>
          </div>

          <div id="section-na" class="form-section mt-4 mb-4">
            <form id="section-na-form">

            <!-- Select NA's -->
              <div class="form-group">
                <label class="control-label requiredField" for="select">
                  Select the NA's<span class="asteriskField">*</span>
                </label>
                <div id="na-errors">
                </div>
                <div id="na"
                  class="aus-form-group"
                  data-populate-staff-list="na"
                  data-populate-type="checkbox"
                  data-populate-prefix="na"
                  data-populate-required="false">

                  <!-- dynamic pod select built here -->
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>
                </div>
              </div>

            </form>
          </div>

          <!-- assign pods to the na's -->
          <div id="section-na_pod" class="form-section mt-4 mb-4 skip-section">
            <form id="section-na-pod-form">

            <!-- Select NA's Pod-->
            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the NA's Assignment<span class="asteriskField">*</span>
              </label>
              <div id="na_pod-errors"></div>
              <div id="na_pod"
                class="aus-form-group"
                data-populate-staff-list="na"
                data-populate-staff-matching="na"
                data-populate-assignment-excluding="Float"
                data-populate-type="assignmentselect"
                data-populate-prefix="na_pod"
                data-populate-required="false">

                <!-- dynamic pod select built here -->
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
              </div>
            </div>

            </form>
          </div>

          <div id="section-uc" class="form-section mt-4 mb-4">
            <form id="section-uc-form">

            <!-- Select UC's -->
            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the UC's<span class="asteriskField">*</span>
              </label>
              <div id="uc-errors"></div>
              <div id="uc"
                class="aus-form-group"
                data-populate-staff-list="uc"
                data-populate-type="checkbox"
                data-populate-prefix="uc"
                data-populate-required="false">

                <!-- dynamic pod select built here -->
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
              </div>
            </div>

            </form>
          </div>

          <!-- assign pods to the uc's -->
          <div id="section-uc_pod" class="form-section mt-4 mb-4 skip-section">
            <form id="section-uc_pod-form">

            <!-- Select UC's Pod-->
            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the UC's Assignment<span class="asteriskField">*</span>
              </label>
              <div id="uc_pod-errors"></div>
              <div id="uc_pod"
                class="aus-form-group"
                data-populate-staff-list="uc"
                data-populate-staff-matching="uc"
                data-populate-assignment-excluding="Float"
                data-populate-type="assignmentselect"
                data-populate-prefix="uc_pod"
                data-populate-required="false">

                <!-- dynamic pod select built here -->
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
              </div>
            </div>

            </form>
          </div>

          <!-- Select Outreach rn -->
          <div id="section-outreach_rn" class="form-section mt-4 mb-4">
            <form id="section-outreach-form">

            <div class="form-group">
              <label class="control-label requiredField" for="outrach-rn">
                Who was on outreach?<span class="asteriskField">*</span>
              </label>
              <div id="outreach_rn-errors"></div>
              <div id="outreach_rn"
                class="aus-form-group"
                data-populate-staff-list="rn"
                data-populate-staff-excluding="cn,nc,float_rn,apod_rn,bpod_rn,cpod_rn"
                data-populate-type="radio"
                data-populate-prefix="outreach_rn"
                data-populate-required="true">

                <!-- dynamic pod select built here -->
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
              </div>
            </div>

            </form>
          </div>

          <div class="form-navigation m-1 text-center">
            <button type="button" class="previous btn btn-secondary">&lt; Previous</button>
            <button type="button" class="next btn btn-secondary">Next &gt;</button>
            <button type="button" class="submit btn btn-secondary">Submit</button>
          </div>
        <!-- </form> -->

      </div>
    </div>

    <div class="row justify-content-center">
      <!-- Progess bar -->
      <div class="col-8">
        <div class="progress">
          <div id="step-progress" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
    </div>

  </div>

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
          <button id="modal-close" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.submission modal content -->
    </div>
  </div>

  <!-- Prefooter Include -->
  <?php include 'includes/script-include.php'; ?>
  <!-- END Prefooter Include -->

  <!-- Handlebars templates -->
  <script id="add-unit-shift-select-template" type="text/x-handlebars-template">
    <?php include 'includes/templates/AddUnitShiftSelect.handlebars'; ?>
  </script>
  <script id="add-unit-shift-radio-template" type="text/x-handlebars-template">
    <?php include 'includes/templates/AddUnitShiftRadio.handlebars'; ?>
  </script>
  <script id="add-unit-shift-assignmentselect-template" type="text/x-handlebars-template">
    <?php include 'includes/templates/AddUnitShiftAssignmentSelect.handlebars'; ?>
  </script>
  <script id="add-unit-shift-checkbox-template" type="text/x-handlebars-template">
    <?php include 'includes/templates/AddUnitShiftCheckbox.handlebars'; ?>
  </script>
  <!-- END Handlebars templates -->

  <!-- Aux Scripts -->
  <script>
  //Global scope variables
  var debug = true; // debug flag

  var $sections = null;
  var $btnNext = null;
  var $btnPrev = null;
  var $btnSubmit = null;

  var oldIndex = null;

  var roleRefArray = null;

  var dateLast = null;
  var dateChangeTimer; //variable to prevent ajax request for staff to not update too often
  var dateChangeTimerInterval = 1500;

  var populate = {
    item: [
      "#nc", "#cn", "#nc_pod", "#cn_pod", "#float_rn", "#apod_rn", "#bpod_rn",
      "#cpod_rn", "#non_vent_mod", "#double_mod", "#code_pager_mod", "#admit_mod",
      "#very_sick_mod", "#crrt_mod", "#evd_mod", "#burn_mod", "#na", "#na_pod",
      "#uc", "#uc_pod", "#outreach_rn"
    ],
    listener: {
      nc: [ncListener],
      nc_pod: [ncPodListener],
      cn_pod: [cnPodListener],
      na: [naListener],
      uc: [ucListener]
    },
    template: {
      select : {
        container: "#add-unit-shift-select-template",
        template: null
      },
      radio : {
        container: "#add-unit-shift-radio-template",
        template: null
      },
      checkbox : {
        container: "#add-unit-shift-checkbox-template",
        template: null
      },
      assignmentselect : {
        container: "#add-unit-shift-assignmentselect-template",
        template: null
      }
    },
    list: null
  };

  var apodRn = [];
  var bpodRn = [];
  var cpodRn = [];
  var bedsideUnchanged = false;

  $(function() {

    <?php if (!$detect->isMobile()): ?>
    $('#date').datepicker({
      format: "yyyy-mm-dd",
      orientation: "bottom auto",
      autoclose: true,
      endDate: "0d"
    });
    <?php endif; ?>

    for (let key in populate.template) {
      populate.template[key].template = Handlebars.compile($(populate.template[key].container).html());
    }

    /**
     * Event listener for change of date to populate the staff list
     * Prevents ajax from being called too often
     */
    $('#date').on('change', function(){
      if (debug) console.log("Date change event occured.");
      //clear out the old timer
      clearTimeout(dateChangeTimer);
      //get the value of the current date selected
      let d = $(this).val();
      //make a new timer
      dateChangeTimer = setTimeout( function(){
        if (debug) console.log("Change timeout elapsed, calling function.");
        getStaff(d);
      }, dateChangeTimerInterval);
    })

    //get the initial list of staff based on default date
    getStaff($('#date').val());

    /********************************************************
     * FORM PAGINATION - CREDIT TO Parsely.js DOCUMENTATION *
     ********************************************************/
    $sections = $('.form-section'); // array of all the form-section elements
    $btnNext = $('.form-navigation .next');
    $btnPrev = $('.form-navigation .previous');
    $btnSubmit = $('.form-navigation .submit');

    oldIndex = -1; //reference to be able to know if traverseing forward or backward

    // Return the current index by looking at which section has the class 'current'
    function curIndex() {
      return oldIndex;
    }

    // Previous button is easy, just go back
    $btnPrev.click(function() {
      navigateTo(curIndex() - 1);
    });

    // Next button goes forward if current block validates
    $btnNext.click(function() {
      $sections.eq(curIndex()).find('form').parsley().whenValidate().done(function() {
        navigateTo(curIndex() + 1);
      });
    });

    //Submit button click event, validate the form, then call the submit forms function
    $btnSubmit.click(function () {
      $sections.eq(curIndex()).find('form').parsley().whenValidate().done(function() {
        alert('Submit attempted.');
        // submitUnitShiftForm();
      });
    });

    //navigates to the current form section
    function navigateTo(index) {
      // remove the current class from the previously current section
      if (oldIndex !== -1) {
        $sections.eq(oldIndex).removeClass('current');
        $sections.eq(oldIndex).slideUp("fast")
      }
      let $temp = $sections.eq(index);

      //check if any data should be updated in the form based on changes made
      updateFormSection($temp);

      //check if section should be skipped
      while ( $temp.hasClass('skip-section') ) { //loop until section found which shouldnt be skipped
        if ( oldIndex > index ) { //if moving backwards
          $temp = $sections.eq(--index); //look back one more section
        } else if ( oldIndex < index ) { //if moving forwards
          $temp = $sections.eq(++index); //look ahead one more section
        }
        updateFormSection($temp);
      }

      //add the current class to the now current section
      $temp.addClass('current');
      $temp.slideDown("slow");

      // Show only the navigation buttons that make sense for the current section:
      $btnPrev.attr("disabled", !(index > 0))
        .toggleClass("btn-primary", (index > 0))
        .toggleClass("btn-secondary", !(index > 0));

      let atTheEnd = index >= $sections.length - 1;

      $btnNext.attr("disabled", (atTheEnd))
        .toggleClass("btn-primary", (!atTheEnd))
        .toggleClass("btn-secondary", (atTheEnd));

      $btnSubmit.attr("disabled", (!atTheEnd))
        .toggleClass("btn-primary", (atTheEnd))
        .toggleClass("btn-secondary", (!atTheEnd));

      //update progress bar
      let progress = (index + 1)/$sections.length*100;
      $('#step-progress').attr('aria-valuenow', progress).css("width",(progress+"%"));
      //$('#step-x-of-y').html(`Step ${index + 1} of ${$sections.length}`);

      //update reference index
      oldIndex = index;
    }

    /**
     * Control logic to update each form based on the previous sections of the form completed.
     * @param  DOMelement $section reference to the div which has the 'sec'
     * @return [type]          [description]
     */
    function updateFormSection($section) {
      let sectionId = $section.prop('id'); //get the current section's name
      if (debug) console.log(`Updating form section: '${sectionId}'`);
      if (debug) console.log($section);

      let $fgroups = $($section).find('.aus-form-group');
      $fgroups.each(function(index, element){
        let prefix = $(this).data('populatePrefix');
        let type = $(this).data('populateType');
        let required = $(this).data('populateRequired');

        let staffMatching = $(this).data('populateStaffMatching');
        let staffIdMatch = [];
        let staffIdExclude = [];

        if (debug && staffMatching) console.log(`> Show staff matching selections from these sections: '${staffMatching}'`);

        //prep the matching id's array
        if (staffMatching) {
          let splitStaffMatching = staffMatching.split(',');

          for (let i = 0; i < splitStaffMatching.length; i++) {
            let $match = $(`#${splitStaffMatching[i]}`);

            staffIdMatch = staffIdMatch.concat($match.find(`input:checked, option:selected`).get().map(function($e){ return $($e).val(); }));
          } // end for
        }

        let staffExcluding = $(this).data('populateStaffExcluding');
        if (debug && staffExcluding) console.log(`> Exclude staff from these sections in the staff list: '${staffExcluding}'`);

        //prep the excluding id's array
        if (staffExcluding) {
          let splitStaffExcluding = staffExcluding.split(',');

          for (let i = 0; i < splitStaffExcluding.length; i++) {
            let $exclude = $(`#${splitStaffExcluding[i]}`);

            staffIdExclude = staffIdExclude.concat($exclude.find(`input:checked, option:selected`).get().map(function($e){ return $($e).val(); }));
          } // end for
        }

        if (type === 'assignmentselect') {
          $(this).find('select').each(function(){
            let $parentRow = $(this).closest('div.row');

            if (staffMatching) {
              $parentRow.hide();
              $(this).prop("disabled", true);
              if (required) $(this).prop('required', false);

              for (let i = 0; i < staffIdMatch.length; i++) {
                if ($(this).attr('id') === `${prefix}-${type}-${staffIdMatch[i]}`) {
                  $parentRow.show();
                  $(this).prop("disabled", false);
                  $(this).find('option:selected').prop("selected", true);
                  if (required) $(this).prop('required', true);
                  break;
                }
              } // end for
            } else {
              $parentRow.show();
              $(this).prop("disabled", false);
              if (required) $(this).prop('required', true);
            } // end if

            if (staffExcluding) {
              for (let i = 0; i < staffIdExclude.length; i++) {
                if ($(this).attr('id') === `${prefix}-${type}-${staffIdExclude[i]}`) {
                  $parentRow.hide();
                  $(this).prop("disabled", true);
                  $(this).find('option:selected').prop("selected", false);
                  if (required) $(this).prop('required', false);
                  break;
                }
              } // end for
            } // end if
          }); //end .each
        } else if (type === 'radio' || type === 'checkbox') {
          $(this).find('input').each(function(index){
            let $parentRow = $(this).closest('div.form-check');

            if (staffMatching) {
              $parentRow.hide();
              $(this).prop("disabled", true);
              $(this).prop("checked", false);
              if (required) $(this).prop('required', false);

              for (let i = 0; i < staffIdMatch.length; i++) {
                if ($(this).val() === staffIdMatch[i]) {
                  $parentRow.show();
                  $(this).prop("disabled", false);
                  if (required) $(this).prop('required', true);
                  break;
                }
              } // end for
            } else {
              $parentRow.show();
              $(this).prop("disabled", false);
              $(this).prop("checked", false);
              if (required) $(this).prop('required', true);
            } // end if...else

            if (staffExcluding) {
              for (let i = 0; i < staffIdExclude.length; i++) {
                if ($(this).val() === staffIdExclude[i]) {
                  $parentRow.hide();
                  $(this).prop("disabled", true);
                  $(this).prop("checked", false);
                  if (required) $(this).prop('required', false);
                  break;
                }
              } // end for
            } // end if
          }); //end .each
        } else if (type === 'select') {
          $(this).find('option').each(function(index){
            $(this).show();
            $(this).prop("disabled", false);

            if (staffMatching) {
              for (let i = 0; i < staffIdMatch.length; i++) {
                if ($(this).val() !== staffIdMatch[i]) {
                  $(this).hide();
                  $(this).prop("disabled", true).prop("selected", false);
                }
              } // end for
            } // end if

            if (staffExcluding) {
              for (let i = 0; i < staffIdExclude.length; i++) {
                if ($(this).val() === staffIdMatch[i]) {
                  $(this).hide();
                  $(this).prop("disabled", true).prop("selected", false);
                }
              } // end for
            } // end if

          }); //end .each
        }
      }); //end .each
    }

    // Prepare sections by setting the `data-parsley-group` attribute to 'block-0', 'block-1', etc.
    $sections.each(function(index, section) {
      $(this).data('blockIndex', index);
    });
    navigateTo(0); // Start at the beginning

    /***************************************
     * END -- FORM PAGINATION / VALIDATION *
     ***************************************/

    // /**
    //  * listener to change behavior of form if float nurse is to be selected
    //  * @var [type]
    //  */
    $(`#float_rn-check-yes`).change(function() {
      $(`#float_rn-subsection`).slideDown('slow'); //show float nurse select
      $(`input[name='float-rn']`).first().prop("required", true); // add the required property to the float-rn select
    });

    // /**
    //  * listener to change behavior of form if no float nurse is to be added
    //  * @var [type]
    //  */
    $(`#float_rn-check-no`).change(function() {
      $(`#float_rn-subsection`).slideUp('fast'); //show float nurse select
      $(`input[name='float_rn']`).first().prop("required", false); // add the required property to the float-rn select

      let $frnElem = $(`input[type='checkbox'][name='float_rn']:checked`); //unselect any selected float-rn value
      if ($frnElem !== null) { $frnElem.prop("checked", false); }
    });


    /**
     * listener to change behavior of form if day shift is selected for input
     * @var [type]
     */
    $(`#day-or-night-day`).closest('label').click(function() {
      $(`#cn-subsection`).toggle(true); // show charge nurse select
      $(`#section-nc_cn_pod`).toggleClass('skip-section', false); // show section for pod selection for nc/cn

      $(`input[name='cn']`).first().prop("required", true); // add the required property to the first cn
      $(`#cn_pod input`).first().prop("required", true); // add the required property to the first cn-pod
    });

    /**
     * listener to change behavior of form if night shift is selected for input
     * @var [type]
     */
    $(`#day-or-night-night`).closest('label').click(function() {
      $(`#cn-subsection`).toggle(false); // hide charge nurse select

      $(`#section-nc_cn_pod`).toggleClass('skip-section', true); // hide section for pod selection for nc/cn

      $(`input[name='cn'][required]`).prop("required", false); // remove the required property from the cn select
      $(`input[name='cn_pod'][required]`).prop("required", false); // remove the required property from the cn select

      //TODO: auto pod A/B/C for the nc

      let $cnElem = $(`input[type='radio'][name='cn']:checked`); //unselect any selected cn value
      if ($cnElem !== null) $cnElem.prop("checked", false);

      let $cnPodElem = $(`input[type='radio'][name='cn_pod']:checked`); //unselect any selected cn value
      if ($cnPodElem !== null) $cnPodElem.prop("checked", false);
    });

  }); //End on document ready function

  /**
   * based on the date selected, get a list of staff not already entered for that day
   * then add the data to the populate global var, call the populate form
   *
   * @param  string date a date in the 'yyyy-mm-dd' format
   */
  function getStaff(date) {

    //
    // HELPER FUNCTIONS
    //
    function getLists(data) {
      let rn = {}, na = {}, uc = {}, assignment = null, role = null;

      //merge staff arrays
      function mergeArrays(a, b) {
        let s = [];

        //while items remain
        while (a.length || b.length) {

          if (a.length === 0) { //if a is empty, push b
            s.push(b[0]);
            b.shift();

          } else if ( b.length === 0 ) { // if b is empty, push a
            s.push(a[0]);
            a.shift();

          } else if (a[0].name > b[0].name){ //if a.name > b.name, push b
            s.push(b[0]);
            b.shift();

          } else { // else push a
            s.push(a[0]);
            a.shift();
          }
        }

        return s;
      }

      //get the lists of staff from the data object
      for (let i = 0; i < data.staff.length; i++) {
        if (data.staff[i].name.toLowerCase() == "rn") {
          rn = data.staff[i];
        } else if (data.staff[i].name.toLowerCase() == "uc") {
          uc = data.staff[i];
        } else if (data.staff[i].name.toLowerCase() == "lpn") {
          if (jQuery.isEmptyObject(na)) {
            na = data.staff[i];
            na.name = "NA";
          } else {
            na.staff = mergeArrays(na.staff, data.staff[i].staff);
          }
        } else if (data.staff[i].name.toLowerCase() == "na") {
          if (jQuery.isEmptyObject(na)) {
            na = data.staff[i];
          } else {
            na.staff = mergeArrays(na.staff, data.staff[i].staff);
          }
        }
      }

      //get the assignment and roles from the data
      assignment = assignment || data.assignment;
      role = role || data.role;

      return x = { rn:rn, na:na, uc:uc, assignment:assignment, role:role }

    }
    //
    // END HELPER FUNCTION
    //

    if (debug) console.log('getStaff() called.');

    date = date || null;

    if (date === null) return false;
    if (date === dateLast) return false;

    $.ajax({
       url: 'resource/get_staff.php',
       type: 'GET',
       data: `date=${date}`,
       beforeSend: function () {
         if (debug) console.log ("getStaff() beforeSend:");
       },
       success: function(data) {
         if (debug) console.log("getStaff() success:");

         if (data) {
           if (debug) console.log("> Data returned:");

           try {

             data = JSON.parse(data);
             if (debug) console.log(data);

             populate.list = getLists(data);
             populatePage(populate);

           } catch (e) {
             if (debug) console.log("> Data error: "+e);
           }

         } else {
           if (debug) console.log("> Get Failed:");
         }
       }
    });
  }

  /**
   * [populatePage description]
   * @param  [type] data [description]
   * @return [type]      [description]
   */
  function populatePage(data) {

    //
    // HELPER FUNCTIONS
    //
    function getPopulateParam($elem) {
      let o = {};

      o.prefix = $elem.attr('data-populate-prefix') || null;
      o.type = $elem.attr('data-populate-type') || null;
      o.staffList = $elem.attr('data-populate-staff-list') || null;
      o.staffMatching = $elem.attr('data-populate-staff-matching') || null;
      o.staffExcluding = $elem.attr('data-populate-staff-excluding') || null;
      o.assignmentMatching = $elem.attr('data-populate-assignment-matching') || null,
      o.assignmentExcluding = $elem.attr('data-populate-assignment-excluding') || null,
      o.required = $elem.attr('data-populate-required') || null;

      if (o.required === "false") {
        o.required = null;
      }

      return o;
    }
    //
    // END HELPER FUNCTIONS
    //

    //loop through the items
    for (let i = 0; i < data.item.length; i++) {
      let curItem = data.item[i];

      let $curElem = $(curItem);
      // if (debug) console.log($curElem);

      let params = getPopulateParam($curElem);
      if (params.assignmentMatching) params.assignmentMatchingArray = params.assignmentMatching.split(",");
      if (params.assignmentExcluding) params.assignmentExcludingArray = params.assignmentExcluding.split(",");
      if (debug) console.log(params);

      let template = data.template[params.type].template;
      if (params.staffList) {
        $curElem.html(template({
          prefix: params.prefix,
          type: params.type,
          assignment: data.list.assignment.filter(function(elem) {
            let result = true;

            if (params.assignmentMatching) {
              result = false;

              for (let j = 0; j < params.assignmentMatchingArray.length; j++) {
                let match = params.assignmentMatchingArray[j];

                if (elem.assignment === match) {
                  result = true;
                  break;
                }
              }
            }

            if (result && params.assignmentExcluding) {
              for (let j = 0; j < params.assignmentExcludingArray.length; j++) {
                let exclude = params.assignmentExcludingArray[j];

                if (elem.assignment === exclude) {
                  result = false;
                  break;
                }
              }
            }

            return result;
          }),
          staff: data.list[params.staffList].staff,
          name: data.list[params.staffList].name,
          required: params.required
        }));

        //if needed, add listeners
        let curItemListenerArray = data.listener[curItem.slice(1)];
        if (debug) console.log(">> Listener Array");
        if (debug) console.log(curItemListenerArray);

        if (curItemListenerArray) {
          for (let i = 0; i < curItemListenerArray.length; i++) {
            curItemListenerArray[i]();
          }
        }
      }
    }

    return true;
  }

  // /**
  //  * Gathers the form data, reorganizes to make appropriate for AJAX submission to backend
  //  */
  // function submitUnitShiftForm() {
  //   let assignmentLookup = createAssignmentLookup(assignmentList);
  //   let roleLookup = createRoleLookup(roleList);
  //
  //   let submission = [];
  //   let formData = [];
  //   let serializedForm = $('#unit-shift-form').serializeArray();
  //
  //   if (debug) console.log("Serialized Array Form Contents:");
  //   if (debug) console.log(serializedForm);
  //
  //   for( let i=0; i < serializedForm.length; i++ ) {
  //     let formPropertyName = serializedForm[i].name;
  //     formPropertyName = formPropertyName.replace(/\[\]$/, '');
  //
  //     formData[formPropertyName] = formData[formPropertyName] || [];
  //
  //     formData[formPropertyName].push(serializedForm[i].value);
  //   }
  //
  //   //create lookup tables, catch non-existing data with '|| []'
  //   let nonVentLookup = createModLookup(formData['non-vent-mod'] || []);
  //   let doubleLookup = createModLookup(formData['double-mod'] || []);
  //   let vSickLookup = createModLookup(formData['very-sick-mod'] || []);
  //   let crrtLookup = createModLookup(formData['crrt-mod'] || []);
  //   let admitLookup = createModLookup(formData['admit-mod'] || []);
  //   let codePgLookup = createModLookup(formData['code-pager-mod'] || []);
  //   let evdLookup = createModLookup(formData['evd-mod'] || []);
  //   let burnLookup = createModLookup(formData['burn-mod'] || []);
  //
  //   let date = formData['date'][0];
  //   let dayOrNight = formData['day-or-night'][0];
  //
  //   //add the clinician to the submission array
  //   submission.push(createStaffEntryObj(
  //     formData['nc'][0], formData['date'][0], roleLookup['Clinician'], formData['nc-pod'][0], dayOrNight
  //   ));
  //
  //   //check if charge nurse exists, if it does, push it too.
  //   if (dayOrNight === 'D') {
  //     submission.push(createStaffEntryObj(
  //       formData['cn'][0], formData['date'][0], roleLookup['Charge'], formData['cn-pod'][0], dayOrNight
  //     ));
  //   }
  //
  //   //float
  //   if ( formData['float-rn-check'][0] === "Yes" ) {
  //     for ( let i = 0; i < formData['float-rn'].length; i++ ) {
  //       submission.push(createStaffEntryObj(
  //         formData['float-rn'][i], formData['date'][0], roleLookup['Bedside'], assignmentLookup['Float'], dayOrNight
  //       ));
  //     }
  //   }
  //
  //
  //   //apod
  //   for ( let i = 0; i < formData['apod-rn'].length; i++ ) {
  //     let sid = formData['apod-rn'][i];
  //
  //     submission.push(createStaffEntryObj(
  //       sid, date, roleLookup['Bedside'], assignmentLookup['A'], dayOrNight,
  //         isModSelected(sid, nonVentLookup),
  //         isModSelected(sid, doubleLookup),
  //         isModSelected(sid, vSickLookup),
  //         isModSelected(sid, crrtLookup),
  //         isModSelected(sid, admitLookup),
  //         isModSelected(sid, codePgLookup),
  //         isModSelected(sid, evdLookup),
  //         isModSelected(sid, burnLookup)
  //     ));
  //   }
  //
  //   //bpod
  //   for ( let i = 0; i < formData['bpod-rn'].length; i++ ) {
  //     let sid = formData['bpod-rn'][i];
  //
  //     submission.push(createStaffEntryObj(
  //       sid, date, roleLookup['Bedside'], assignmentLookup['B'], dayOrNight,
  //         isModSelected(sid, nonVentLookup),
  //         isModSelected(sid, doubleLookup),
  //         isModSelected(sid, vSickLookup),
  //         isModSelected(sid, crrtLookup),
  //         isModSelected(sid, admitLookup),
  //         isModSelected(sid, codePgLookup),
  //         isModSelected(sid, evdLookup),
  //         isModSelected(sid, burnLookup)
  //     ));
  //   }
  //
  //   //cpod
  //   for ( let i = 0; i < formData['cpod-rn'].length; i++ ) {
  //     let sid = formData['cpod-rn'][i];
  //
  //     submission.push(createStaffEntryObj(
  //       sid, date, roleLookup['Bedside'], assignmentLookup['C'], dayOrNight,
  //         isModSelected(sid, nonVentLookup),
  //         isModSelected(sid, doubleLookup),
  //         isModSelected(sid, vSickLookup),
  //         isModSelected(sid, crrtLookup),
  //         isModSelected(sid, admitLookup),
  //         isModSelected(sid, codePgLookup),
  //         isModSelected(sid, evdLookup),
  //         isModSelected(sid, burnLookup)
  //     ));
  //   }
  //
  //   //outreach
  //   for ( let i = 0; i < formData['outreach-rn'].length; i++ ) {
  //     let sid = formData['outreach-rn'][i];
  //
  //     submission.push(createStaffEntryObj(
  //       sid, date, roleLookup['Outreach'], assignmentLookup['Float'], dayOrNight
  //     ));
  //   }
  //
  //   //na - there may not always be an NA specified, check
  //   formData['na'] = formData['na'] || [];
  //   if (formData['na'] !== []) {
  //     for ( let i = 0; i < formData['na'].length; i++ ) {
  //       let sid = formData['na'][i];
  //
  //       submission.push(createStaffEntryObj(
  //         sid, date, roleLookup['NA'], formData[`na-pod-${sid}`][0], dayOrNight
  //       ));
  //     }
  //   }
  //
  //   //uc - there may not always be a UC specified, check
  //   formData['uc'] = formData['uc'] || [];
  //   if (formData['uc'] !== []) {
  //     for ( let i = 0; i < formData['uc'].length; i++ ) {
  //       let sid = formData['uc'][i];
  //
  //       submission.push(createStaffEntryObj(
  //         sid, date, roleLookup['UC'], formData[`uc-pod-${sid}`][0], dayOrNight
  //       ));
  //     }
  //   }
  //
  //   if (debug) { console.log(submission); }
  //
  //   //data is appropriate for submission, now submit it
  //   submitUnitShifts(submission);
  // }
  //
  // /**
  //  * Helper function to create shift entry object to be returned for submission
  //  * @param  int  staffId         [description]
  //  * @param  string  date         [description]
  //  * @param  int  roleId          [description]
  //  * @param  int  assignmentId    [description]
  //  * @param  char  dayOrNight     [description]
  //  * @param  boolean nonVent      [description]
  //  * @param  boolean doubled      [description]
  //  * @param  boolean vsick        [description]
  //  * @param  boolean crrt         [description]
  //  * @param  boolean admit        [description]
  //  * @param  boolean codepg       [description]
  //  * @param  boolean evd          [description]
  //  * @param  boolean burn         [description]
  //  * @return Object               [description]
  //  */
  // function createStaffEntryObj(staffId, date, roleId, assignmentId, dayOrNight,
  //   nonVent = false, doubled = false, vsick = false, crrt = false, admit = false, codepg = false, evd = false, burn = false) {
  //
  //   let staffEntry = {
  //           staff : staffId,
  //           date : date,
  //           role : roleId,
  //           assignment : assignmentId,
  //           dayornight : dayOrNight,
  //           nonvent : nonVent,
  //           doubled : doubled,
  //           vsick : vsick,
  //           crrt : crrt,
  //           admit : admit,
  //           codepg : codepg,
  //           evd : evd,
  //           burn : burn
  //         };
  //
  //   return staffEntry;
  // }
  //
  // function createAssignmentLookup(assignmentObjArr) {
  //   let aArray = [];
  //
  //   for(let i = 0; i < assignmentObjArr.length; i++) {
  //     aArray[assignmentObjArr[i].assignment] = assignmentObjArr[i].id;
  //   }
  //
  //   return aArray;
  // }
  //
  // function createRoleLookup(roleObjArray) {
  //   let rArray = [];
  //
  //   for(let i = 0; i < roleObjArray.length; i++) {
  //     rArray[roleObjArray[i].role] = roleObjArray[i].id;
  //   }
  //
  //   return rArray;
  // }
  //
  // function createModLookup(modSelectArray) {
  //   let mArray = [];
  //
  //   for ( let i = 0; i < modSelectArray.length; i++ ) {
  //     mArray[modSelectArray[i]] = true;
  //   }
  //
  //   return mArray;
  // }
  //
  // function isModSelected(staffId, modLookup) {
  //   let b = false;
  //
  //   if ( (typeof(modLookup) != 'undefined') && (typeof(modLookup[staffId]) != 'undefined') ) { b = true; }
  //
  //   return b;
  // }
  //
  // /**
  //  * Submit the form data to backend
  //  * @param  Array[Object] submissionData   An Array of ShiftEntry Objects, ready for submission to backend
  //  */
  // function submitUnitShifts(submissionData) {
  //   submissionData = submissionData || []; // catch null/undefined arguments
  //
  //   //catch bad parameter data, return to exit function
  //   if ( submissionData === [] ) {
  //     if (debug) { console.log("Warning: no data passed to submit via ajax handler"); }
  //     return;
  //   }
  //
  //   $.ajax({
  // 	   url: 'resource/post_multiple_shift.php',
  // 	   type: 'post',
  // 	   data: {"shiftData" : JSON.stringify(submissionData)},
  //      beforeSend: function () {
  //        if (debug) { console.log("AJAX sent."); }
  //        $('#submission-modal-body').html(`<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
  //                                          <span class="sr-only">Loading...</span>`);
  //        $('#submission-modal').modal('show');	//show the modal
  //      },
  // 	   success: function(data) {
  //        if (debug) { console.log("AJAX returned."); }
  //
  //        if (data === "ok") {
  //
  //          if (debug) { console.log("Data submission ok."); }
  //   	     $('#submission-modal-body').html("<h3>Success!</h3><p>click close to reset the form.</p>");
  //          $('#modal-close').on('click', function(){
  //            location.reload();
  //          });
  //
  //        } else {
  //
  //          if (debug) { console.log("Data submission not ok."); }
  //          $('#submission-modal-body').html(`<h3>There was a problem!</h3>
  //                                            <p>${data}</p>
  //                                            <p>Click close, find the problem, resubmit.</p>`);
  //
  //        }
  //
  //        if (debug) { console.log(data); }
  // 	   }
  // 	});
  // }
  //
  //

  function ncListener() {
    if (debug) console.log('>> Setting nc listener.');

    $(`input[name='nc']`).click(function(){
      let clickedId = $(this).attr('id');
      let splitId = clickedId.split('-');

      $(`input[name='cn']:disabled`).parent().removeClass('aus-disabled-label');
      $(`input[name='cn']:disabled`).attr("disabled", false);
      $(`#cn-radio-${splitId[2]}`).attr("disabled", true);
      $(`#cn-radio-${splitId[2]}`).prop("checked", false);
      $(`#cn-radio-${splitId[2]}`).parent().addClass('aus-disabled-label');
    });
  }

  function ncPodListener() {
    /**
     * when the nc's assigned pod is clicked, the charge nurse's pod changes to the appropriate selection
     * @var [type]
     */

    $(`select[name='nc_pod']`).change(function() {
      let selectedValue = $(this).val();
      // if (debug) console.log(`>> Selected Value: ${selectedValue}`);
      let selectedPod = $(this).children(`option:selected`).text();
      // if (debug) console.log(`>> Selected Pod: ${selectedPod}`);
      let selectedMainPod = selectedPod.replace(/[\/B]/g, '');
      // if (debug) console.log(`>> Selected Main Pod: ${selectedMainPod}`);

      $(`select[name='cn_pod']:visible`).children(`option`).filter(function(){
        return ($(this).text() !== selectedMainPod);
      }).prop('selected', true);

      return true;
    });
  }

  function cnPodListener() {
    /**
     * when the cn's assigned pod is clicked, the nc's pod changes to the appropriate selection
     * @var [type]
     */

   $(`select[name='cn_pod']`).change(function() {
     let selectedValue = $(this).val();
     // if (debug) console.log(`>> Selected Value: ${selectedValue}`);
     let selectedMainPod = $(this).children(`option:selected`).text();
     // if (debug) console.log(`>> Selected Main Pod: ${selectedPod}`);d}`);

     $(`select[name='nc_pod']:visible`).children(`option`).filter(function(){
       return (!$(this).text().includes(selectedMainPod));
     }).prop('selected', true);

     return true;
   });
  }

  function naListener() {
    $(`input[name='na']`).click(function(){
      if ($(`input[name='na']:checked`).length > 0) {
        $(`#section-na_pod`).removeClass('skip-section');
        $(`#section-na_pod div.aus-form-group`).data('populateRequired', true);
      } else {
        $(`#section-na_pod`).addClass('skip-section');
        $(`#section-na_pod div.aus-form-group`).data('populateRequired', false);
      }
    });
  }

  function ucListener() {
    $(`input[name='uc']`).click(function(){
      if ($(`input[name='uc']:checked`).length > 0) {
        $(`#section-uc_pod`).removeClass('skip-section');
        $(`#section-na_pod div.aus-form-group`).data('populateRequired', true);
      } else {
        $(`#section-uc_pod`).addClass('skip-section');
        $(`#section-na_pod div.aus-form-group`).data('populateRequired', false);
      }
    });
  }

  </script>
  <!-- END Aux Scripts -->

  <!-- Footer Include -->
  <?php include 'includes/footer.php'; ?>
  <!-- END Footer Include -->

</body>

</html>
