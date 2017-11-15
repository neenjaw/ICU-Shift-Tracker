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
      <div class="col mt-2">
        <h2>Staff Detail</h2>
        <hr>
      </div>
    </div>
    <div class="row">
      <div id="container" class="col">
      </div>
    </div>
  </div>

  <!-- Bootstrap Modal -->
  <div id="shift-detail-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">

      <!-- shift details modal content -->
      <div class="modal-content" id="shift-detail-modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Shift Details:</h5>
          <button id="modal-x-btn" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body" id="shift-detail-text">
        </div>

        <div class="modal-footer clearfix">
          <input type="hidden" id="shift-modified" value="no">
          <button id='modal-delete-shift-btn' class="btn btn-danger">Delete</button>
          <button id='modal-close-btn' class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /.shift-detail modal content -->

    <!-- /.modal-content -->
    </div>
  <!-- /.modal-dialog -->
  </div>

  <!-- Script include -->
  <?php include 'includes/script-include.php'; ?>
  <!-- END Script include -->

  <script id="staff-detail-template" type="text/x-handlebars-template">
    <?php include 'includes/templates/StaffDetail.handlebars'; ?>
  </script>

  <script id="shift-entry-template" type="text/x-handlebars-template">
    <?php include 'includes/templates/ShiftEntryEditable.handlebars'; ?>
  </script>

  <script id="staff-select-template" type="text/x-handlebars-template">
    <?php include 'includes/templates/StaffSelect.handlebars'; ?>
  </script>

  <script>
    var debug = true;
    var staffTemplate = null;
    var shiftTemplate = null;

    //When document is ready
    $(function () {

      staffTemplate = Handlebars.compile($("#staff-detail-template").html());
      shiftTemplate = Handlebars.compile($("#shift-entry-template").html());
      selectTemplate = Handlebars.compile($("#staff-select-template").html());

      var url_string = window.location.href;
      var url = new URL(url_string);
      var staffId = url.searchParams.get("staff-id");
      var urlparam = { 'since-date': url.searchParams.get("since-date"),
                    'num-of-shifts': url.searchParams.get("num-of-shifts")}

      if (debug) console.log(staffId);

      if (staffId !== null) {
        getStaffDetail(staffId, urlparam);
      } else {
        getStaffSelect();
      }

      $("#modal-delete-shift-btn").on("click", function(){
        deleteShiftEntry($(`#shift-details-shift-id`).val());
      });

      $("#modal-close-btn, #modal-x-btn").on("click", function(){
        if ($(`#shift-modified`).val() != 'no') {
          getStaffDetail(staffId);
        }
      });

    });

    function getStaffDetail(id, param = null) {
      param = param || {};
      param['since-date'] = param['since-date'] || null;
      param['num-of-shifts'] = param['num-of-shifts'] || null;

      let data = `staff-id=${id}`;

      if (param['since-date'] !== null) {
        data += `&since-date=${param['since-date']}`;
      }

      if (param['num-of-shifts'] !== null) {
        data += `&num-of-shifts=${param['num-of-shifts']}`;
      }

      $.ajax({
        type: 'GET',
        url: 'ajax/ajax_get_staff_details.php',
        data: data,
        beforeSend: function () {
          if (debug) console.log(`Staff detail to be retrieved:`);
          if (debug) console.log(data);
        },
        success: function (response) {
          if (debug) console.log(`Staff detail response:`);
          if (debug) console.log(response);

          if(response) {
            try {
              let detail = JSON.parse(response);

              $(`#container`).html(staffTemplate(detail));

              $(`#choose-another`).click(function(){
                window.location.href = location.protocol + '//' + location.host + location.pathname;
              });

              $(`#show-all`).click(function(){
                window.location.href = `${location.protocol}//${location.host}${location.pathname}?staff-id=${id}&since-date=${detail['first-shift']}`;
              });

              //Set click event listeners to call up modal after ajax query is returned
              $('a.shift-link').click(function(){
                 let i = $(this).data('shiftId'); //get the shift id
                 getShiftDetail(i);
              });
            } catch(e) {
              alert(e); // error in the above string (in this case, yes)!
            }
          }
        }
      });
    }

    function getStaffSelect() {
      let data = '';

      $.ajax({
        type: 'GET',
        url: 'ajax/ajax_get_staff.php',
        data: data,
        beforeSend: function () {
          if (debug) console.log(`All staff to be retrieved.`);
        },
        success: function (response) {
          if (debug) console.log(`Staff retrieved:`);
          if (debug) console.log(response);

          if(response) {
            try {
              let detail = JSON.parse(response);

              $(`#container`).html(selectTemplate({staff: detail}));
            } catch(e) {
              alert(e); // error in the above string (in this case, yes)!
            }
          }
        }
      });
    }

    function getShiftDetail(id = null) {
      if (id === null) {
        return;
      }

      $.ajax({
        type: 'POST',
        url: 'ajax/ajax_get_shift_details.php',
        data: 'shift_id='+id+'',
        beforeSend: function () {
          $('#shift-detail-text').html('');
        },
        success: function (response) {
          if (debug) { console.log(response); }
          $('#shift-detail-text').html(shiftTemplate(JSON.parse(response))); //add the result between the div tags
          $('#shift-detail-modal').modal('show');	//show the modal

          //set click listeners for edit, submit, cancel here.
          $(`.shift-item-show a`).click(function() {
            shiftDetailEdit($(this));

            return false; //stop click propagation
          });
          $(`button.shift-edit-submit`).click(function() {
            shiftDetailEditSubmit($(this));

            return false; //stop click propagation
          });
          $(`button.shift-edit-cancel`).click(function() {
            shiftDetailEditCancel($(this));

            return false; //stop click propagation
          });
        }
      });
    }

    function deleteShiftEntry(id = null) {
      if (id === null) {
        return;
      }

      $("#modal-button-delete").prop("disabled", true); //disable the button to prevent more clicks

      if (confirm("Are you sure you want to delete this shift?")) {
        $.ajax({
          type: 'POST',
          url: 'ajax/ajax_delete_shift.php',
          data: 'shift_id='+id+'',
          beforeSend: function () {
            if (debug) console.log(`Attempting to delete '${id}'.`);
          },
          success: function (response) {
            if (debug) console.log(response);

            getStaffDetail(staffId);

            $('#shift-detail-modal').modal('hide');

            showAlert("Shift Deleted. Showing updated table.", 'alert-success', 5000);
          }
        });
      }

      $("#modal-button-delete").prop("disabled", false); // re-enable the button
    }

    function showAlert(message = '', alertClass = 'alert-success', alertTimeout = 5000) {
      //display the alert to success
      $('#form-alert').addClass(alertClass);
      $('#form-alert p').html(`<h4>${message}</h4>`);
      $('#alert-container').collapse('show');
      $("#alert-container").focus();

      //set timeout to hide the alert in x milliseconds
      setTimeout(function(){
        $("#alert-container").collapse('hide');

        setTimeout(function(){
          $("#form-alert p").html('');
          $('#form-alert').removeClass(alertClass);
        }, 1000);
      }, alertTimeout);
    }

    function shiftDetailEdit($elem) {
      $elem.parent().hide();
      $elem.parent().siblings().show();
    }

    function shiftDetailEditSubmit($elem) {
      let formData = $elem.closest('form').serializeArray();
      let ref = [];

      jQuery.each(formData, function( index, value ) {
        //alert( `${index}: name: ${value.name}, value: ${value.value}` );
        ref[value.name] = value.value;
      });
      ref[ref['shift-item-id']] = ref[ref['shift-item-id']] || '0';

      if (ref[ref['shift-item-id']] !== ref[`shift-${ref['shift-item-id']}-value`]) {
        let data = `shift-id=${ref['shift-id']}&${ref['shift-item-id']}=${ref[ref['shift-item-id']]}`;

        // submit the form
        $.ajax({
          type: 'POST',
          url: 'ajax/ajax_put_shift_update.php',
          data: data,
          beforeSend: function () {
            if (debug) console.log(`Update to be submitted:`);
            if (debug) console.log(data);
          },
          success: function (response) {
            if (debug) console.log(`Update response:`);
            if (debug) console.log(response);

            if (response.substring(0, 2) === "Ok") {
              if (debug) console.log("Shift updated.");

              let inputType = $(`input[name='${ref['shift-item-id']}-item-type']`).val();
              let newDisplayValue = '';
              if (inputType == 'select') {

                newDisplayValue = $(`select[name='${ref['shift-item-id']}'] option[value='${ref[ref['shift-item-id']]}']`).text();

              } else if (inputType == 'checkbox') {

                if (ref[ref['shift-item-id']] == '1') {
                  newDisplayValue = 'Yes';
                } else {
                  newDisplayValue = 'No';
                }

              }

              $(`#shift-modified`).val('yes');
              $(`input[name='shift-${ref['shift-item-id']}-value']`).val(ref[ref['shift-item-id']]);
              $(`#show-${ref['shift-item-id']}-value`).text(newDisplayValue);
            } else {
              if (debug) console.log("Shift not updated.");
            }
          }
        });
      }

      $parentSpan = $elem.closest('span');
      $parentSpan.hide();
      $parentSpan.siblings().show();
    }

    function shiftDetailEditCancel($elem) {
      $parentSpan = $elem.closest('span');
      $parentSpan.hide();
      $parentSpan.siblings().show();
    }
  </script>

  <!-- Footer include -->
  <?php include 'includes/footer.php'; ?>
  <!-- END Footer include -->

</body>

</html>
