<?php
include 'includes/pre-head.php';

if (!isset($_SESSION['authenticated'])) {
  header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Header include -->
  <?php include 'includes/head.php';?>
  <!-- END Header include -->
  <link href="includes/css/shift-table.css?<?= date('l jS \of F Y h:i:s A'); ?>" rel="stylesheet">

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
        <h2>Home</h2>
        <h4>Showing last <span id="shift-number"></span> days of shifts entered</h4>
      </div>
    </div>
    <div class="row">
      <div id="shift-table-div" class="col-md-10">
        <!-- GENERATED TABLE -->
          <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
          <span class="sr-only">Loading...</span>
        <!-- END GENERATED TABLE -->
      </div>
      <div id="right-col" class="col-md-2">
        <!-- <div class="card"> -->
        <div id="sidebar" class="card sticky-top affix" style="width: 170px;">
          <div class="card-body">
            <h4 class="card-title">Legend</h4>
            <p class="card-text">Each letter represents a quick look at the entered shift.</p>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">C: Clinician</li>
            <li class="list-group-item">P: Charge</li>
            <li class="list-group-item">V: Bedside</li>
            <li class="list-group-item">O: Outreach</li>
            <li class="list-group-item">D: Doubled</li>
            <li class="list-group-item">S: Sick</li>
            <li class="list-group-item">R: CRRT</li>
            <li class="list-group-item">B: Burn</li>
            <li class="list-group-item">A: Admit</li>
            <li class="list-group-item">N: Non-vented</li>
            <li class="list-group-item">X: LPN/NA/UC</li>
            <li class="list-group-item">F: Undefined</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <br />

    <br />

    <br />
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

  <script id="shift-entry-template" type="text/x-handlebars-template">
    <?php include 'includes/templates/ShiftEntryEditable.handlebars'; ?>
  </script>

  <script id="shift-table-template" type="text/x-handlebars-template">
    <?php include 'includes/templates/ShiftTable.handlebars'; ?>
  </script>

  <script src="includes/lib/build-shift-table.js"></script>

  <script>
    var debug = true;
    var shiftTemplate = null;
    var shiftTableTemplate = null;
    var daysToPrint = 15;
    var daysOffset = 0;
    var categoryToFetch = "*";
    var staffList = null;
    var options = {
      tableId : 'shift-table',
      tableClasses : 'table table-striped table-responsive table-hover table-sm',
      theadClasses : 'thead-dark',
      rheadClasses : 'staff',
      monthClasses : 'month',
      dateClasses : 'date',
      staffDividerClasses : 'table-dark',
      locale : 'en-us'
    };

    //When document is ready
    $(function () {

      //get the first shift table
      getShiftTable(daysToPrint, daysOffset, categoryToFetch);

      $("#shift-number").html(daysToPrint);

      $("#modal-delete-shift-btn").on("click", function(){
        deleteShiftEntry($(`#shift-details-shift-id`).val());
      });

      $("#modal-close-btn, #modal-x-btn").on("click", function(){
        if ($(`#shift-modified`).val() != 'no') {
          getShiftTable(daysToPrint, daysOffset, categoryToFetch);
        }
      });

      //compile the shift template with Handlebars
      shiftTemplate = Handlebars.compile($("#shift-entry-template").html());
      shiftTableTemplate = Handlebars.compile($("#shift-table-template").html());

      // add the percentOfTotal helper
      Handlebars.registerHelper("printDate", function(dateString) {
        if (debug) console.log(`Date string: '${dateString}'`);
        
        let date = new Date(dateString);
        let month = date.toLocaleString('en-us', { month: "short", timeZone: 'UTC' });
        let day = date.getUTCDate();

        if (debug) console.log(`Month: '${month}', Day: '${day}'`);

        return new Handlebars.SafeString(`${month}<br>${day}`);
      });

    });

    function getShiftTable(days, offset, category) {
      $.ajax({
        type: 'POST',
        url: 'resource/get_shift_table.php',
        data: 'days='+days+'&offset='+offset+'&category='+category,
        beforeSend: function () {
        },
        success: function (response) {
          try {
            let shiftTableData = JSON.parse(response);

            let g = shiftTableData.groups;
            shiftTableData.groups = [];

            for (let i = 0; i < g.length; i++) {
              if (g[i].name == "RN") {
                shiftTableData.groups[0] = g[i];

              } else if (g[i].name == "LPN") {
                shiftTableData.groups[1] = g[i];

              } else if (g[i].name == "NA") {
                shiftTableData.groups[2] = g[i];

              } else if (g[i].name == "UC") {
                shiftTableData.groups[3] = g[i];

              }
            }

            if (debug) console.log("AJAX returned, staff list:");
            if (debug) console.log(shiftTableData);
            $('#shift-table-div').html(shiftTableTemplate(shiftTableData));

            // //Set click event listeners to call up modal after ajax query is returned
            $('a[data-shift-id]')
              .filter(function(i,e){ return e.innerHTML !== '-' })
              .click(function(){ showShiftDetail($(this).data('shiftId')) });
          } catch(e) {
            if (debug) console.log(`Retrieval Error: ${e}`); // error in the above string being parsed!
          }
        }
      });
    }

    function showShiftDetail(id = null) {
      if (id === null) {
        return;
      }

      $.ajax({
        type: 'POST',
        url: 'resource/get_shift_details.php',
        data: 'shift_id='+id+'',
        beforeSend: function () {
          $('#shift-detail-text').html();
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
          url: 'resource/delete_shift.php',
          data: 'shift_id='+id+'',
          beforeSend: function () {
            // nada
          },
          success: function (response) {
            if (debug) { console.log(response); }

            $(`#shift-table-div`).html(`<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>`);
            getShiftTable(daysToPrint, daysOffset, categoryToFetch);

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
          url: 'resource/put_shift_update.php',
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
