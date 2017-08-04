<?php
    $page_name = basename($_SERVER['PHP_SELF']);
    $a_active = ' active';
?>
        <!-- Side navigation bar -->
        <ul class="nav flex-column hidden-md-down">
          <li class="nav-item">
            <h5>Menu</h5>
          </li>
          <li class="nav-item">
            <a<?php makeNavLink($page_name, 'home.php'); ?>>Home</a>
          </li>
          <li class="nav-item">
            <h5>Shifts</h5>
          </li>
          <li class="nav-item">
            <a<?php makeNavLink($page_name, 'add-shift.php'); ?>>Add new</a>
          </li>
          <li class="nav-item">
            <a<?php makeNavLink($page_name, 'mod-shift.php'); ?>>Modify / Delete</a>
          </li>
          <li class="nav-item">
            <h5>Staff</h5>
          </li>
          <li class="nav-item">
            <a<?php makeNavLink($page_name, 'add-staff.php'); ?>>Add new</a>
          </li>
          <li class="nav-item">
            <a<?php makeNavLink($page_name, 'mod-staff.php'); ?>>Modify / Delete</a>
          </li>
          <li class="nav-item">
            <h5>Reports</h5>
          </li>
          <li class="nav-item">
            <a<?php makeNavLink($page_name, 'report-pod.php'); ?>>Pod Assignment</a>
          </li>
          <li class="nav-item">
            <a<?php makeNavLink($page_name, 'report-doubles.php'); ?>>Doubles</a>
          </li>
          <li class="nav-item">
            <h5>--------------</h5>
          </li>
          <li class="nav-item">
            <a<?php makeNavLink($page_name, 'config.php', '#', 'active', true); ?>>Config</a>
          </li>
        </ul>
        <!-- End side navigation bar -->

        <!-- Top nav menu, for small screens -->
        <ul class="nav flex-column hidden-lg-up">
        asd
        </ul>
        <!-- End top nav menu, for small screens -->

<?php
function makeNavLink($cur_page_name, $page_target, $active_target = "#", $active_class = "active", $disabled = false) {
    $b = ($cur_page_name == $page_target);
    ?> class="nav-link<?php echo (($b) ? ' '.$active_class : ''); echo (($disabled) ? ' disabled' : ''); ?>" href="<?php echo (($b) ? $active_target : $page_target); ?>"<?php
}
?>