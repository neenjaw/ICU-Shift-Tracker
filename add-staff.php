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
    <div class="row justify-content-md-center">
      <div class="col-2">

<!-- Side NAV include -->
<?php include 'includes/side-nav.php' ?>
<!-- END Side NAV include -->

      </div>
      <div class="col-12 col-md-auto">
<!-- Main Content -->
        <h2>Add a new Staff</h2>
        <hr />
        <form id="add-staff-form">
          <div class="form-group form-inline">
            <label class="sr-only" for="first-name-input">First Name</label>
            <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="first-name-input" placeholder="First Name">

            <label class="sr-only" for="last-name-input">Last Name</label>
            <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="last-name-input" placeholder="Last Name">
          </div>

          <div class="form-group">
            <label for="category-select">Select the staff category (eg. RN, LPN, NA, etc..)</label>
            <select class="form-control" id="category-select">
<?php
$form_select_categories = $crud->getAllCateories();
foreach ($form_select_categories as $k => $v) {?>
              <option value="<?php echo ($k); ?>"><?php echo ($v); ?></option>
<?php }
?>
            </select>
          </div>
          <div class="form-group form-inline">
              <button type="submit" class="btn btn-primary" id="submit-new-staff">Add New Staff</button>
          </div>
        </form>

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















