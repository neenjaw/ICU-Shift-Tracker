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

        <!-- Nav menu include -->
<?php include 'includes/nav-menu.php' ?>
        <!-- END nav menu include -->

      </div>
    </div>
    <div class="row justify-content-md-center">
      <div class="col-md-10">
      	<br>
        <h2>Home</h2>
        <h4>Showing last <span id="shift-number"></span> days of shifts entered</h4>

        <!-- GENERATED TABLE -->
        <div id="bin" class="shift-table-div">
          <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
          <span class="sr-only">Loading...</span>
        </div>
        <!-- END GENERATED TABLE -->

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
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body" id="shift-detail-text">
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    <input type="hidden" name="shift-id" value="{{Id-Number}}">
    <div class="card-block">
      <h4 class="card-title">{{Name}}'s shift</h4>
      <h5 class="card-text">{{Date}}-{{D-or-N}}</h5>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">Role: {{Role}}</li>
      <li class="list-group-item">Pod: {{Assignment}}</li>
      <li class="list-group-item">Non-vented: {{NV}}</li>
      <li class="list-group-item">Doubled: {{Double}}</li>
      <li class="list-group-item">Admitted: {{Admit}}</li>
      <li class="list-group-item">Very sick: {{Very-Sick}}</li>
      <li class="list-group-item">Code pager: {{Code-Pager}}</li>
      <li class="list-group-item">CRRT: {{CRRT}}</li>
      <li class="list-group-item">EVD: {{EVD}}</li>
      <li class="list-group-item">Burn: {{Burn}}</li>
    </ul>
  </script>

  <script src="assets/build-shift-table.js"></script>

  <script>
    var shiftTemplate = null;

    //When document is ready
    $(function () {

      //get the first shift table
      getShiftTable(20,0);

      $("#shift-number").html("20");

      //compile the shift template with Handlebars
      shiftTemplate = Handlebars.compile($("#shift-entry-template").html());

    });

    function getShiftTable(days, offset) {
      $.ajax({
        type: 'POST',
        url: 'ajax/ajax_shift_table.php',
        data: 'days='+days+'&offset='+offset+'',
        beforeSend: function () {
        },
        success: function (response) {
          //console.log(response);
          $('#bin').html(buildShiftTable(JSON.parse(response),
            'table table-hover table-responsive table-striped table-sm shift-table',
            'thead-inverse',
            '',
            'shift-row-head shift-date',
            'shift-row-head',
            'shift-cell'));

          //Set click event listeners to call up modal after ajax query is returned
          $('.shift-cell a').click(function(){
            var i = $(this).parent().attr('data-shift-id'); //get the shift id

            $.ajax({
              type: 'POST',
              url: 'ajax/ajax_shift_details.php',
              data: 'shift_id='+i+'',
              beforeSend: function () {
                $('#shift-detail-text').html();
              },
              success: function (response) {
                console.log(response);
                $('#shift-detail-text').html(shiftTemplate(JSON.parse(response))); //add the result between the div tags
                $('#shift-detail-modal').modal('show');	//show the modal
              }
            });
          });
        }
      });
    }
  </script>

  <!-- Footer include -->
<?php include 'includes/footer.php'; ?>
  <!-- END Footer include -->

</body>

</html>
