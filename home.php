<?php
include 'includes/pre-header.php';

if (!isset($_SESSION['user_session'])) {
    header("Location: index.php");
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<?php include 'includes/alert-header.php' ?>

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

<?php include 'includes/pre-script-footer.php'; ?>

<script>
  //When document is ready
  $(function () {
    //Set all the shift table cells with a link to point at the page to display the shift details
    /*$(".shift-cell a").each(function(entry) {
          var shift_id = $(this).attr("data-shift-entry-id");
          $(this).attr("href", ("show_shift_details.php?shift_id="+shift_id));  
    });*/
    
    //Set click event listeners to call up modal after ajax query is returned
    $('.shift-cell a').click(function(){
      var i = $(this).attr('data-shift-entry-id'); //get the shift id
  
      $.ajax({
        type: 'POST',
        url: 'ajax/ajax_shift_details.php',
        data: 'shift_id='+i+'',
        beforeSend: function () {
          $('#shift-detail-text').html('');
        },
        success: function (response) {
          $('#shift-detail-text').html(response); //add the result between the div tags
          $('#shift-detail-modal').modal('show');	//show the modal
        }
      });
    });

  });
</script>

<?php include 'includes/footer.php'; ?>
















