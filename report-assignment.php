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

  <script id="staff-report-select-template" type="text/x-handlebars-template">
    <?php include 'includes/templates/StaffReportSelect.handlebars'; ?>
  </script>

  <script id="staff-report-assignment-template" type="text/x-handlebars-template">
    <?php // include 'includes/templates/StaffReportAssignment.handlebars'; ?>
  </script>

  <script src="assets/website-lib.js?<?= date('l jS \of F Y h:i:s A'); ?>"></script>

  <script>
    var debug = true;
    var reportSelectTemplate = null;

    const onStaffSuccess = function (response) {
      if (debug) console.log(`Staff retrieved:`);
      if (debug) console.log(response);

      if(response) {
        try {
          response = JSON.parse(response);

          $($(`#container`)).html(reportSelectTemplate(response));

          //TODO bind parsely to form submission
          $('form')
          .parsley()
          .on('form:submit', function () {
            submitReportStaff();
            return false; //return false to prevent HTML form submission
          });

        } catch(e) {
          alert(e); // error in the above string being parsed!
        }
      }
    }

    var staffSelectParam = {
      onSuccess: onStaffSuccess,
      data: [{'group-by-category':'true'}]
    }

    function submitReportStaff() {
      return null;
    }

    //When document is ready
    $(function () {
      reportSelectTemplate = Handlebars.compile($("#staff-report-select-template").html());

      // add the percentOfTotal helper
      Handlebars.registerHelper("percentOfTotal", function(number, total) {
        let percent = number / total * 100;
        percent = percent.toString();

        let i = percent.indexOf('.');

        if (i>0) {
          return percent.substr(0, (percent.indexOf('.')+1))+"%";
        } else {
          return percent+"%";
        }
      });

      getStaffSelect(staffSelectParam);
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
