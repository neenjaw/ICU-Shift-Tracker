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

  <!-- Bootstrap Modals -->

  <!--Login, Signup, Forgot Password Modal -->
  <div id="login-signup-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">

      <!-- login modal content -->
      <div class="modal-content" id="login-modal-content">

        <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal" ><span aria-hidden="true">&times;</span></button> -->

          <h4 class="modal-title"><span class="fa fa-lock"></span> Login Now!</h4>
        </div>

        <div class="modal-body">

          <form method="post" id="login-form" role="form" data-parsley-validate>

            <div class="form-group">
              <label for="login-email">Email address</label>
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-envelope"></span></div>
                <input type="email" class="form-control" name="email" id="login-email" placeholder="name@website.com" aria-describedby="emailHelp" placeholder="Enter email" data-parsley-required data-parsley-type="email" data-parsley-trigger="change" autocomplete="off" spellcheck="false" data-parsley-errors-messages-disabled>
              </div>
              <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>

            <div class="form-group">
              <label for="login-password">Password</label>
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-lock"></span></div>
                <input type="password" class="form-control" name="password" id="login-password" placeholder="Password" data-parsley-required autocomplete="off" data-parsley-errors-messages-disabled data-parsley-trigger="change">
              </div>
            </div>

            <div class="collapse" id="collapse-callout">
              <div class="card card-block bs-callout bs-callout-danger" id="callout-login-error">
                <!-- error will be shown here ! -->
              </div>

              <div class="card card-block bs-callout bs-callout-warning" id="callout-form-error">
                <h4>Oh snap!</h4>
                <p>Invalid email/password combination.</p>
              </div>
            </div>

            <button type="submit" class="btn btn-success btn-block btn-lg" name="btn-login" id="btn-login" onclick="console.log('btn-login clicked');">LOGIN</button>
          </form>
        </div>

        <div class="modal-footer">
          <!--<p>
          <a id="FPModal" href="javascript:void(0)">Forgot Password?</a> |
          <a id="signupModal" href="javascript:void(0)">Request Access!</a>
        </p>-->
      </div>

    </div>
    <!-- login modal content -->

    <!-- signup modal content -->
    <div class="modal-content" id="signup-modal-content">

      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
        <h4 class="modal-title"><span class="fa fa-lock"></span> Request Access!</h4>
      </div>

      <div class="modal-body">
        <form method="post" id="signup-form" role="form">

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon"><span class="fa fa-envelope"></span></div>
              <input name="email" id="email" type="email" class="form-control input-lg" placeholder="Enter Email" required data-parsley-type="email">
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon"><span class="fa fa-lock"></span></div>
              <input name="password" id="passwd" type="password" class="form-control input-lg" placeholder="Enter Password" required data-parsley-length="[6, 10]"
              data-parsley-trigger="keyup">
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon"><span class="fa fa-lock"></span></div>
              <input name="password" id="confirm-passwd" type="password" class="form-control input-lg" placeholder="Retype Password" required
              data-parsley-equalto="#passwd" data-parsley-trigger="keyup">
            </div>
          </div>


          <button type="submit" class="btn btn-success btn-block btn-lg" id="btn-request">REQUEST ACCOUNT!</button>
        </form>
      </div>

      <div class="modal-footer">
        <p>Already a Member? <a id="loginModal" href="javascript:void(0)">Login Here!</a></p>
      </div>

    </div>
    <!-- signup modal content -->

    <!-- forgot password content -->
    <div class="modal-content" id="forgot-password-modal-content">

      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
        <h4 class="modal-title"><span class="fa fa-lock"></span> Recover Password!</h4>
      </div>

      <div class="modal-body">
        <form method="post" id="forgot-password-form" role="form">

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon"><span class="fa fa-envelope"></span></div>
              <input name="email" id="email" type="email" class="form-control input-lg" placeholder="Enter Email" required data-parsley-type="email">
            </div>
          </div>

          <button type="submit" class="btn btn-success btn-block btn-lg" id="btn-forgot">
            <span class="fa fa-send"></span> SUBMIT
          </button>
        </form>
      </div>

      <div class="modal-footer">
        <p>Remember Password? <a id="loginModal1" href="javascript:void(0)">Login Here!</a></p>
      </div>

    </div>
    <!-- forgot password content -->



    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!--Login, Signup, Forgot Password Modal -->










<?php  include 'includes/script-include.php'; ?>

<!-- onLoad, call login modal if not logged in. -->
<?php if (!isset($_SESSION['user_session'])) { ?>
  <script type="text/javascript">
  $(window).on('load', function () {
    $('#login-signup-modal').modal({ backdrop: 'static', keyboard: false })
    $('#login-signup-modal').modal('show');
  });
  </script>
<?php } ?>

<script type="text/javascript">
$(document).ready(function(){

  //$('#Login-Form').parsley();
  //$('#Signin-Form').parsley();
  //$('#Forgot-Password-Form').parsley();

  $('#signupModal').click(function(){
    $('#login-modal-content').fadeOut('fast', function(){
      $('#signup-modal-content').fadeIn('fast');
    });
  });

  $('#loginModal').click(function(){
    $('#signup-modal-content').fadeOut('fast', function(){
      $('#login-modal-content').fadeIn('fast');
    });
  });

  $('#FPModal').click(function(){
    $('#login-modal-content').fadeOut('fast', function(){
      $('#forgot-password-modal-content').fadeIn('fast');
    });
  });

  $('#loginModal1').click(function(){
    $('#forgot-password-modal-content').fadeOut('fast', function(){
      $('#login-modal-content').fadeIn('fast');
    });
  });

});
</script>

<script type="text/javascript">
$(function () {
  $('#callout-login-error').hide();
  $('#callout-form-error').hide();

  $('#login-form').parsley({errorClass: "form-control-danger", successClass: "form-control-success"})
  .on('field:validated', function (e) {

    if (e.validationResult.constructor!==Array) {

      try {
        if ( $('#collapse-callout').hasClass('show') && !$('#collapse-callout').hasClass('collapsing')) {
          $('#collapse-callout').collapse('show');
        }
      }
      catch (err) {
        console.log(err);
      }

      $('#callout-form-error').fadeOut('fast');
      $('#callout-login-error').fadeOut('fast');

      this.$element.closest('.form-group').removeClass('has-danger').addClass('has-success');

    } else {

      $('#callout-login-error').hide();
      $('#callout-form-error').fadeIn('fast');

      try {
        if ( !$('#collapse-callout').hasClass('show') && !$('#collapse-callout').hasClass('collapsing')) {
          $('#collapse-callout').collapse('show');
        }
      }
      catch (err) {
        console.log(err);
      }

      this.$element.closest('.form-group').removeClass('has-success').addClass('has-danger');

    }
  })
  .on('form:submit', function () {

    var data = $("#login-form").serialize();
    $.ajax({
      type: 'POST',
      url: 'ajax/ajax_login_process.php',
      data: data + '&btn-login=1',
      beforeSend: function () {
        $("#btn-login").html('<span class="fa fa-transfer"></span> &nbsp; sending ...');
      },
      success: function (response) {
        if (response == "ok") {
          $("#btn-login").html('<span class="fa fa-check"></span> &nbsp; Signing In ...');
          setTimeout(' window.location.href = "home.php"; ', 1000);
        }
        else {

          $("#callout-login-error").html('<h4><span class="fa fa-info-circle"></span></h4>\r\n<p>' + response + '!</p>');


          $('#callout-form-error').hide();
          $('#callout-login-error').fadeIn('fast');

          try {
            if ( !$('#collapse-callout').hasClass('show') && !$('#collapse-callout').hasClass('collapsing')) {
              $('#collapse-callout').collapse('show');
            }
          }
          catch (err) {
            console.log(err);
          }

          $("#login-email").closest('.form-group').removeClass('has-success').addClass('has-danger');
          $("#login-email").removeClass('form-control-success').addClass('form-control-danger');
          $("#login-password").closest('.form-group').removeClass('has-success').addClass('has-danger');
          $("#login-password").removeClass('form-control-success').addClass('form-control-danger');

          $("#btn-login").html('LOGIN');

        }
      }
    });

    return false;
  });
});
</script>

<?php include 'includes/footer.php'; ?>

</body>

</html>
