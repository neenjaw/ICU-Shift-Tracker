
  <!--
  Fixed Navbar along the top of the screen.
  -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">ICU Shift Tracker - ALPHA</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item active"><a class="nav-link" href="#"><?php
              if (isset($_SESSION['authenticated'])) {
                  echo '<strong>Hello '.$_SESSION['user']->login.'</strong>' ;
              } else {
                  echo 'Not logged in.';
              }
              ?><span class="sr-only">(current)</span></a></li>
        <?php
          if (isset($_SESSION['authenticated'])) {
            echo "<li class=\"nav-item\">";
            echo "<a class=\"nav-link\" href=\"logout.php\">Logout</a>" ;
            echo "</li>\r\n";
          }
        ?>
      </ul>
    </div>
  </nav>
