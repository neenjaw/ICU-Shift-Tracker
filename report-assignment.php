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
        <h2>Assignment Report</h2>
        <hr>
      </div>
    </div>
    <div class="row">
      <div id="container" class="col">
      </div>
    </div>
  </div>


  <!-- Script include -->
  <?php include 'includes/script-include.php'; ?>
  <!-- END Script include -->

  <script id="staff-multi-select-template" type="text/x-handlebars-template">
    <?php include 'includes/templates/StaffMultiSelect.handlebars'; ?>
  </script>

  <script src="assets/website-lib.js"></script>

  <script>
    var debug = true;
    var multiSelectTemplate = null;

    //When document is ready
    $(function () {
      multiSelectTemplate = Handlebars.compile($("#staff-multi-select-template").html());

      getStaffSelect($(`#container`), multiSelectTemplate);

      //TODO bind parsely to form submission
      //TODO get staff details of staff array
      //TODO generate a report for all this
      //TODO create template to display report
    });

  </script>

  <!-- Footer include -->
  <?php include 'includes/footer.php'; ?>
  <!-- END Footer include -->

</body>

</html>
