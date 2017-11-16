/*
 * populate the staff select
 */

function getStaffSelect(params) {
  params = params || {};
  params.type = params.type || 'GET';
  params.url  = params.url  || 'ajax/ajax_get_staff.php';
  params.data = params.data || [];

  params.doBefore = params.doBefore || function () {};

  params.onSuccess = params.onSuccess || function (response) {};

  if (debug) console.log(params);

  $.ajax({
    type: params.type,
    url: params.url,
    data: params.data.map(function(x) { return Object.keys(x)[0]+'='+Object.values(x)[0]}).join('&'),
    beforeSend: params.doBefore,
    success: params.onSuccess
  });
}

/*
 * SHOW THE ALERT
 */

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

/*
 * MODAL SHIFT DETAIL CODE
 */

 function getShiftDetail(id = null, shiftTemplate) {
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

function deleteShiftEntry(id = null, onSuccess) {
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

        onSuccess();

        $('#shift-detail-modal').modal('hide');

        showAlert("Shift Deleted. Showing updated table.", 'alert-success', 5000);
      }
    });
  }
}

/*
 * EDITABLE SHIFT DETAIL CODE
 */

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
