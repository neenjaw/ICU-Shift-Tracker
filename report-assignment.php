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

  <script src="includes/lib/website-lib.js?<?= date('l jS \of F Y h:i:s A'); ?>"></script>

  <script>
    var debug = true;
    var reportSelectTemplate = null;
    var reportDisplayTemplate = null;

    const onStaffSuccess = function (response) {
      if (debug) console.log(`Staff retrieved:`);
      if (debug) console.log(response);

      if(response) {
        try {
          response = JSON.parse(response);

          $(`#container`).html(reportSelectTemplate(response));

          //TODO bind parsely to form submission
          $('form')
          .parsley()
          .on('form:submit', function () {
            submitReportStaff();
            return false; //return false to prevent HTML form submission
          });

        } catch(e) {
          alert(`Select Error: ${e}`); // error in the above string being parsed!
        }
      }
    };

    const onReportSuccess = function (response) {
      if (debug) console.log(`Report data retrieved:`);
      if (debug) console.log(response);

      if(response) {
        try {
          response = JSON.parse(response);
          if (debug) console.log(`parsed:`);
          if (debug) console.log(response);

          let byGroup = [];
          $.each(response, function(index, value){
            byGroup[value.category] = byGroup[value.category] || [];

            let assignmentArray = value['assign-count'];
            let aCount = 0;
            let bCount = 0;
            let cCount = 0;
            $.each(assignmentArray, function(i, v){
              if (v.assignment === "A") {
                aCount = v.count;
              } else if (v.assignemtn === "B") {
                bCount = v.count;
              } else if (v.assignemtn === "C") {
                cCount = v.count;
              }
            });

            let modArray = value['mod-count'];
            let dCount = 0;
            $.each(modArray, function(i, v){
              if (v.mod === "Doubled") {
                dCount = v.count;
              }
            });

            byGroup[value.category].push({
              id: value.id,
              name: value.name,
              lastWorked: value.shift[0].date,
              lastRole: value.shift[0].role,
              lastPod: value.shift[0].assignment,
              aPodCount: aCount,
              bPodCount: bCount,
              cPodCount: cCount,
              doubleCount: dCount
            });
          });

          if (debug) console.log('byGroup');
          if (debug) console.log(byGroup);

          $(`#container`).empty().html(reportDisplayTemplate({group: byGroup}));

        } catch(e) {
          alert(`Report Error: ${e}`); // error in the above string being parsed!
        }
      } else {
        if (debug) console.log('Report failure.');
      }
    };

    var staffSelectParam = {
      url: 'resource/get_staff.php',
      data: [{'group-by-category':'true'}],
      onSuccess: onStaffSuccess
    };

    var staffReportParam = {
      url: 'resource/get_staff_details.php',
      onSuccess: onReportSuccess
    };

    function submitReportStaff() {
      let x = $('form').serializeArray();

      if (debug) console.log(`Staff to be reported on:`);
      if (debug) console.log(x);

      x = x.map( function(e){ return { [e.name]:e.value }; } );

      if (debug) console.log(`Mapped serializeArray data:`);
      if (debug) console.log(x);

      staffReportParam.data = x;

      getData(staffReportParam);
      //TODO get staff details of staff array
      //TODO generate a report for all this
      //TODO create template to display report
    }

    //When document is ready
    $(function () {
      reportSelectTemplate = Handlebars.compile($("#staff-report-select-template").html());
      reportDisplayTemplate = Handlebars.compile($("#staff-report-assignment-template").html());

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

      getData(staffSelectParam);
    });

  </script>

  <!-- Footer include -->
  <?php include 'includes/footer.php'; ?>
  <!-- END Footer include -->

</body>

</html>
