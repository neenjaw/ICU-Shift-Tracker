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
      <div class="col">
        <h2>Staff Detail</h2>
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

  <script id="staff-detail-template" type="text/x-handlebars-template">
    <?php include 'includes/templates/StaffDetail.handlebars'; ?>
  </script>

  <script id="shift-entry-template" type="text/x-handlebars-template">
    <?php include 'includes/templates/ShiftEntryComplete.handlebars'; ?>
  </script>

  <script>
    var debug = true;
    var staffTemplate = null;
    var shiftTemplate = null;

    //When document is ready
    $(function () {

      staffTemplate = Handlebars.compile($("#staff-detail-template").html());
      shiftTemplate = Handlebars.compile($("#shift-entry-template").html());

      var url_string = window.location.href;
      var url = new URL(url_string);
      var staffId = url.searchParams.get("staff-id");
      if (debug) console.log(staffId);

      getStaffDetail(staffId);

    });

    function getStaffDetail(id, days = null) {
      let data = `staff-id=${id}`;

      if (days !== null) {
        data += `&num-of-days=${days}`;
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
            } catch(e) {
              alert(e); // error in the above string (in this case, yes)!
            }
          }
        }
      });
    }
  </script>

  <!-- Footer include -->
  <?php include 'includes/footer.php'; ?>
  <!-- END Footer include -->

</body>

</html>
