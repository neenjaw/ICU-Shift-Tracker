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
        <h2>Add a new Shift</h2>




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

</script>
<!-- END Aux Scripts -->

<!-- Footer Include -->
<?php include 'includes/footer.php'; ?>
<!-- END Footer Include -->















