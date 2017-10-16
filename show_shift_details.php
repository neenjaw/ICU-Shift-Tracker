<?php
include 'includes/pre-header.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-12 col-md-auto">

        <!-- Shift Details Card -->
        <div class="card" style="width: 20rem;">
          <div class="card-block">
            <h4 class="card-title">Shift Details</h4>
            <?php $crud->printShiftEntry($_GET["shift_id"]); ?>
            <a href="javascript:window.history.back();" class="btn btn-primary">Dismiss</a>
          </div>
        </div>


      </div>
    </div>
  </div>
  
  <div class="container">
    <br />
    
    <br />
    
    <br />
  </div>


<?php
include 'includes/pre-script-footer.php';
?>

<script>
  //When document is ready
  $(function () {
    //Set all the shift table cells with a link to point at the page to display the shift details
    $(".card-block p").each(function() {
        $(this).addClass("card-text");
    });
  });
</script>

<?php
include 'includes/footer.php';
?>