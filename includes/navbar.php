
  <!--
  Fixed Navbar along the top of the screen.
  -->
  <nav class="navbar fixed-top navbar-toggleable-sm navbar-inverse bg-inverse">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">ICU Shift Tracker - ALPHA</a>

    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item active"><a class="nav-link" href="#"><?php
              if (isset($_SESSION['user_session'])) {
                  echo '<strong>Hello '.$row['email'].'</strong>' ;
              } else {
                  echo 'Not logged in.';
              }
              ?><span class="sr-only">(current)</span></a></li>
        <?php
          if (isset($_SESSION['user_session'])) {
            echo "<li class=\"nav-item\">";
            echo "<a class=\"nav-link\" href=\"logout.php\">Logout</a>" ;
            echo "</li>\r\n";
          }
        ?>
      </ul>
    </div>
  </nav>
