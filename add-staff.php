<?php
include 'includes/pre-header.php';

if (!isset($_SESSION['user_session'])) {
    header("Location: index.php");
}
?>

<!-- Header include -->
<?php include 'includes/header.php';?>
<!-- END Header include -->

<!-- NAV bar include -->
<?php include 'includes/navbar.php'; ?>
<!-- END NAV bar include -->

<!-- Alert include -->
<?php include 'includes/alert-header.php' ?>
<!-- END Alert include -->

  <div class="container">
    <div class="row">
      <div class="col">
<!-- NAV include -->
<?php include 'includes/nav-menu.php' ?>
<!-- END NAV include -->
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col">
      <br>
<!-- Main Content -->

        <div class="container">
          <form id="add-staff-form">
            <div class="row justify-content-center">
              <div class="col-sm-8">

                <h2>Add a new Staff</h2>
                <hr />

              </div>
            </div>
            <div class="row justify-content-center">

              <div class="col-sm-8 form-control-feedback hidden" id="staff-name-group-feedback"></div>

            </div>
            <div class="row justify-content-center">

              <div class="col-sm-4 form-group">
            	  <label for="first-name">First Name</label>
        	      <input type="text" class="form-control" id="first-name" name="first-name" placeholder="First Name"
      	        	data-parsley-required data-parsley-trigger="change" autocomplete="off" spellcheck="false"
  	            	data-parsley-errors-messages-disabled>
              </div>

              <div class="col-sm-4 form-group">
              	<label for="last-name">Last Name</label>
          	    <input type="text" class="form-control" id="last-name" name="last-name" placeholder="Last Name"
      	        	data-parsley-required data-parsley-trigger="change" autocomplete="off" spellcheck="false"
  	            	data-parsley-errors-messages-disabled>
              </div>

            </div>
            <div class="row justify-content-center">

              <div class="col-sm-8 form-group" id="cat-id-group">
                <label for="category-id">Select the staff category (eg. RN, LPN, NA, etc..)</label>
                <select class="form-control" id="category-id" name="category-id" data-parsley-required>
                  <option value="" disabled selected hidden>Please Choose...</option>
    <?php
    //Build Option List
    //use the CRUD object to access the database and build an option list of the categories
    $form_select_categories = $crud->getAllCateories();
    foreach ($form_select_categories as $k => $v) {?>
                  <option value="<?php echo ($k); ?>"><?php echo ($v); ?></option>
    <?php }
    //END Build Option List
    ?>
                </select>
              </div>

            </div>
            <div class="row justify-content-end">

              <div class="col-sm-4 form-group">
                  <button type="submit" class="btn btn-primary" id="btn-submit-new-staff">Add New Staff</button>
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
<?php include 'includes/pre-script-footer.php'; ?>
<!-- END Prefooter Include -->

<!-- Aux Scripts -->
<script>
/*
 * Bind parsley.js event listeners here.
 */

  $(function () {
	$('#add-staff-form')
	.parsley({errorClass: "form-control-danger", successClass: "form-control-success"})
    .on('field:validated', function (e) {

      if (e.validationResult.constructor!==Array) {

        this.$element.closest('.form-group').removeClass('has-danger').addClass('has-success');

      } else {

        this.$element.closest('.form-group').removeClass('has-success').addClass('has-danger');

      }
    })
    .on('form:submit', function () {
      var data = $('#add-staff-form').serialize();
      console.log(data + '&btn-submit-new-staff=1');
      $.ajax({
        type: 'POST',
        url: 'ajax/ajax_add_staff_process.php',
        data: data + '&btn-submit-new-staff=1',
        beforeSend: function () {
          $('#btn-submit-new-staff').html('<span class="fa fa-transfer"></span> &nbsp; adding ...');
        },
        success: function (response) {
		  console.log(response);

          if (response == "ok") {

        	//clear the feedback message
            $('#staff-name-group-feedback').html('');

            //clear the form group classes
            $('#staff-name-group').removeClass('has-danger').removeClass('has-success');
            $('#cat-id-group').removeClass('has-danger').removeClass('has-success');

            //clear the form control classes
            $('#first-name').removeClass('form-control-danger').removeClass('form-control-success');
            $('#last-name').removeClass('form-control-danger').removeClass('form-control-success');
            $('#category-id').removeClass('form-control-danger').removeClass('form-control-success');

            //display the alert to success
            $('#form-alert').addClass('alert-success');
            $('#form-alert p').html('<h4>Staff successfully added!</h4>');
            $('#form-alert').show();

            //set timeout to hide the alert in x milliseconds
            setTimeout(function(){
                $("#form-alert").hide();
                $("#form-alert p").html('');
                $('#form-alert').removeClass('alert-success');
            }, 5000);

            //reset the form, return focus to first name
            $('#add-staff-form').trigger('reset');
            $("#first-name").focus()

          } else {

            $('#staff-name-group-feedback').html('<span class="fa fa-info-circle"></span> &nbsp; That name is already entered.');

            $('#staff-name-group').removeClass('has-success').addClass('has-danger');
            $('#first-name').removeClass('form-control-success').addClass('form-control-danger');
            $('#login-password').removeClass('form-control-success').addClass('form-control-danger');

          }

          $('#btn-submit-new-staff').html('Add New Staff');
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
