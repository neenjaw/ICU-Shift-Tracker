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
<?php include 'includes/nav-menu.php' ?>
      </div>
    </div>
    <div class="row justify-content-md-center">
      <div class="col-12 col-md-auto">
      	<br>
        <h2>Home</h2>
        <h4>Showing last <?php echo (isset($_GET['num_days'])) ? $_GET['num_days'] : 20; ?> days of shifts entered</h4>
        <!-- GENERATED TABLE -->
<?php
$num_days = (isset($_GET['num_days'])) ? $_GET['num_days'] : 20;
settype($num_days, 'integer');

$day_offset = (isset($_GET['day_offset'])) ? $_GET['day_offset'] : 0;
settype($day_offset, 'integer');

$crud->printRnShiftTable($num_days, $day_offset);
?>
        <!-- END GENERATED TABLE -->
      </div>
    </div>
  </div>

  <div class="container">
    <br />

    <br />

    <br />
  </div>

  <!-- Bootstrap Modals -->
  <!--Login, Signup, Forgot Password Modal -->
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

<?php include 'includes/script-include.php'; ?>

<script src="includes/templates/ShiftEntry.handlebars" id="shift-entry-template" type="text/x-handlebars-template"></script>

<script>
  var shiftTemplate = null;

  //When document is ready
  $(function () {
    //Set click event listeners to call up modal after ajax query is returned
    $('.shift-cell a').click(function(){
      var i = $(this).attr('data-shift-entry-id'); //get the shift id

      $.ajax({
        type: 'POST',
        url: 'ajax/ajax_shift_details.php',
        data: 'shift_id='+i+'',
        beforeSend: function () {
          $('#shift-detail-text').html();
        },
        success: function (response) {
          $('#shift-detail-text').html(shiftTemplate(response)); //add the result between the div tags
          $('#shift-detail-modal').modal('show');	//show the modal
        }
      });
    });

    console.log($("#shift-entry-template").html());
    shiftTemplate = Handlebars.compile($("#shift-entry-template").html());
  });
</script>

<?php include 'includes/footer.php'; ?>

</body>

</html>
