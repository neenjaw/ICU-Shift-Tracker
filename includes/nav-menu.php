<?php
$page_name = basename($_SERVER['PHP_SELF']);
$a_active = ' active';
?>

		<!-- Top nav menu, for small screens -->
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<?php echo makeNavLink($page_name, 'home.php', 'Home', 'nav-link');?>
			</li>
			<li class="nav-item dropdown">
				<?php echo makeNavLink($page_name, 'add-unit-shift.php,add-shift.php,mod-shift.php', 'Shifts', 'nav-link dropdown-toggle', 'data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"'); ?>
				<div class="dropdown-menu">
					<?php echo makeNavLink($page_name, 'add-unit-shift.php', 'Add unit', 'dropdown-item'); ?>
					<?php echo makeNavLink($page_name, 'add-shift.php', 'Add single', 'dropdown-item'); ?>
					<div class="dropdown-divider"></div>
					<?php echo makeNavLink($page_name, 'mod-shift.php', 'Modify / Delete', 'dropdown-item'); ?>
				</div>
			</li>
			<li class="nav-item dropdown">
				<?php echo makeNavLink($page_name, 'add-staff.php,mod-staff.php', 'Staff', 'nav-link dropdown-toggle', 'data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"'); ?>
				<div class="dropdown-menu">
					<?php echo makeNavLink($page_name, 'add-staff.php', 'Add new', 'dropdown-item'); ?>
					<div class="dropdown-divider"></div>
					<?php echo makeNavLink($page_name, 'mod-staff.php', 'Modify / Delete', 'dropdown-item'); ?>
				</div>
			</li>
			<li class="nav-item dropdown">
				<?php echo makeNavLink($page_name, 'pod-report.php,double-report.php', 'Reports', 'nav-link dropdown-toggle', 'data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"'); ?>
				<div class="dropdown-menu">
					<?php echo makeNavLink($page_name, 'pod-report.php', 'Pod Assignment', 'dropdown-item'); ?>
					<?php echo makeNavLink($page_name, 'double-report.php', 'Doubles', 'dropdown-item'); ?>
				</div>
			</li>
			<li class="nav-item dropdown">
				<?php echo makeNavLink($page_name, 'config.php', '&nbsp;', 'nav-link dropdown-toggle', 'data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"'); ?>
				<div class="dropdown-menu">
					<?php echo makeNavLink($page_name, 'config.php', 'Config', 'dropdown-item'); ?>
				</div>
			</li>
		</ul>
		<!-- End top nav menu, for small screens -->

<?php

function makeNavLink($cur_page_name, $page_target, $link_text = '', $class_list = '', $other_param = '')
{
    $match = false;

    $page_array = explode( ',', $page_target );

    foreach ( $page_array as $v ) {
        if ($v == $cur_page_name) {
            $match = true;
            break;
        }
    }

    return '<a class="' . $class_list . (($match) ? ' active': '') .
        '" href="' . ( ($match) ? '#' : ( (count($page_array) > 1) ? '#' : $page_target ) ) .
        '"' . ( ($other_param != '') ? ' '.$other_param : '' ) . '>' . $link_text . '</a>' . "\r\n";
}
?>
