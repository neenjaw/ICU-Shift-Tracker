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
    <div class="row justify-content-md-center">
      <div class="col-12 col-md-auto">
        <br>
        <!-- Main Content -->

        <div class="container">
          <form method="post" id="shift-form">
            <div class="row justify-content-center">
              <div class="col-sm-8">

                <h2>Add a new Shift</h2>
                <hr />

              </div>
            </div>
            <div class="row justify-content-center">

              <div class="col-sm-8 form-control-feedback hidden" id="shift-form-feedback"></div>

            </div>

            <div class="row justify-content-center">

              <div class="col-sm-8 form-group">
                <label class="control-label requiredField" for="select">Select a Staff for the shift:<span class="asteriskField">*</span></label>
                <select class="select form-control" id="select-staff" name="staff">
                  <!--<option value="staff_id">Last, Name - RN</option>-->
                  <option value="" disabled selected hidden>Please Choose...</option>
<?php
//Build Staff Select List
//use the CRUD object to access the database and build an option list of the categories
$form_select_staff = $crud->getAllStaff();
foreach ($form_select_staff as $k => $v) {?>
                  <option value="<?php echo ($k); ?>"><?php echo ($v); ?></option>
<?php }
//END Build Staff Select List
?>
                </select>
              </div>

            </div>
            <div class="row justify-content-center">

              <div class="col-sm-8 form-group">
                <label class="control-label requiredField" for="date">Date<span class="asteriskField">*</span></label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input class="form-control" id="date" name="date" placeholder="YYYY/MM/DD" value="<?php echo date('Y-m-d'); ?>" type="<?php echo (($detect->isMobile()) ? 'date' : 'text'); ?>"/>
                </div>
              </div>

            </div>
            <div class="row justify-content-center">

              <div class="col-sm-8 btn-group requiredField" data-toggle="buttons">
                <label class="btn btn-outline-primary active">
                  <input type="radio" name="d-or-n" id="radio-d-or-n-d" value="D" autocomplete="off" checked> Day
                </label>
                <label class="btn btn-outline-primary">
                  <input type="radio" name="d-or-n" id="radio-d-or-n-n" value="N" autocomplete="off"> Night
                </label>
              </div>

            </div>
            <div class="row justify-content-center">

              <div class="col-sm-8 form-group">
                <label class="control-label requiredField" for="select1">Role<span class="asteriskField">*</span></label>
                <select class="select form-control" id="select-role" name="role">
                  <!--<option value="First Choice">First Choice</option>-->
<?php
//Build Staff Role List
//use the CRUD object to access the database and build an option list of the categories
$form_select_role = $crud->getAllRoles();
foreach ($form_select_role as $k => $v) {?>
                  <option value="<?php echo ($k); ?>"><?php echo ($v); ?></option>
<?php }
//END Build Role Select List
?>
                </select>
              </div>

            </div>
            <div class="row justify-content-center">

              <div class="col-sm-8 form-group">
                <label class="control-label requiredField" for="select2">Pod Assignment<span class="asteriskField">*</span></label>
                <select class="select form-control" id="select-assignment" name="assignment">
                  <!--<option value="First Choice">First Choice</option>-->
                  <option value="" disabled selected hidden>Please Choose...</option>
<?php
//Build Assignment Select List
//use the CRUD object to access the database and build an option list of the categories
$form_select_assignment = $crud->getAllAssignments();
foreach ($form_select_assignment as $k => $v) {?>
                  <option value="<?php echo ($k); ?>"><?php echo ($v); ?></option>
<?php }
//END Build Assignment Select List
?>
                </select>
              </div>

            </div>
            <div class="row justify-content-center">

<!--
Need to add logic to hide check boxes based on the role selected
-->

              <div class="col-sm-8 form-group">
                <label class="control-label">Check all that apply</label>
                <div class="checkbox"><label class="custom-control custom-checkbox"><input name="ck-nonvent" class="custom-control-input" type="checkbox" value="NV"/><span class="custom-control-indicator"></span><span class="custom-control-description">Non-vented?</span></label></div>
                <div class="checkbox"><label class="custom-control custom-checkbox"><input name="ck-doubled" class="custom-control-input" type="checkbox" value="D"/><span class="custom-control-indicator"></span><span class="custom-control-description">Doubled?</span></label></div>
                <div class="checkbox"><label class="custom-control custom-checkbox"><input name="ck-admit" class="custom-control-input" type="checkbox" value="A"/><span class="custom-control-indicator"></span><span class="custom-control-description">Admitted?</span></label></div>
                <div class="checkbox"><label class="custom-control custom-checkbox"><input name="ck-codepg" class="custom-control-input" type="checkbox" value="P"/><span class="custom-control-indicator"></span><span class="custom-control-description">Code pager?</span></label></div>
                <div class="checkbox"><label class="custom-control custom-checkbox"><input name="ck-vsick" class="custom-control-input" type="checkbox" value="VS"/><span class="custom-control-indicator"></span><span class="custom-control-description">Very sick?</span></label></div>
                <div class="checkbox"><label class="custom-control custom-checkbox"><input name="ck-crrt" class="custom-control-input" type="checkbox" value="C"/><span class="custom-control-indicator"></span><span class="custom-control-description">CRRT?</span></label></div>
                <div class="checkbox"><label class="custom-control custom-checkbox"><input name="ck-evd" class="custom-control-input" type="checkbox" value="E"/><span class="custom-control-indicator"></span><span class="custom-control-description">EVD?</span></label></div>
                <div class="checkbox"><label class="custom-control custom-checkbox"><input name="ck-burn" class="custom-control-input" type="checkbox" value="B"/><span class="custom-control-indicator"></span><span class="custom-control-description">Burn?</span></label></div>
              </div>

            </div>
            <div class="row justify-content-end">

              <div class="col-sm-4 form-group">
                <div><button class="btn btn-primary " name="submit" type="submit">Submit</button></div>
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
<?php include 'includes/script-include.php'; ?>
  <!-- END Prefooter Include -->

  <!-- Aux Scripts -->
  <script>
    $(function() {
<?php if (!$detect->isMobile()) { ?>
      $('#date').datepicker({
          format: "yyyy-mm-dd",
          orientation: "bottom auto",
          autoclose: true
      });
<?php } ?>
      $("#select-staff").select2();
    });
  </script>
  <!-- END Aux Scripts -->

  <!-- Footer Include -->
<?php include 'includes/footer.php'; ?>
  <!-- END Footer Include -->

</body>

</html>
