<?php
$page_name = basename($_SERVER['PHP_SELF']);
$a_active = ' active';
?>

		<!-- Top nav menu, for small screens -->
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<?= makeNavLink($page_name, 'home.php', '<i class="fa fa-home" aria-hidden="true"></i>
', 'nav-link');?>
			</li>
			<li class="nav-item dropdown">
				<?= makeNavLink($page_name, 'add-unit-shift.php,add-shift.php,mod-shift.php', '<i class="fa fa-calendar-times-o" aria-hidden="true"></i>
', 'nav-link dropdown-toggle', 'data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"'); ?>
				<div class="dropdown-menu">
					<h6 class="dropdown-header">Shifts</h6>
					<?= makeNavLink($page_name, 'add-unit-shift.php', 'Add unit', 'dropdown-item'); ?>
					<?= makeNavLink($page_name, 'add-shift.php', 'Add single', 'dropdown-item'); ?>
					<div class="dropdown-divider"></div>
					<?= makeNavLink($page_name, 'mod-shift.php', 'Modify / Delete', 'dropdown-item disabled'); ?>
				</div>
			</li>
			<li class="nav-item dropdown">
				<?= makeNavLink($page_name, 'add-staff.php,mod-staff.php', '<i class="fa fa-user" aria-hidden="true"></i>
', 'nav-link dropdown-toggle', 'data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"'); ?>
				<div class="dropdown-menu">
					<h6 class="dropdown-header">Staff</h6>
					<?= makeNavLink($page_name, 'add-staff.php', 'Add new', 'dropdown-item'); ?>
					<div class="dropdown-divider"></div>
					<?= makeNavLink($page_name, 'mod-staff.php', 'Modify / Delete', 'dropdown-item disabled'); ?>
				</div>
			</li>
			<li class="nav-item dropdown">
				<?= makeNavLink($page_name, 'pod-report.php,double-report.php', '<i class="fa fa-bar-chart" aria-hidden="true"></i>
', 'nav-link dropdown-toggle', 'data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"'); ?>
				<div class="dropdown-menu">
					<h6 class="dropdown-header">Reports</h6>
					<?= makeNavLink($page_name, 'pod-report.php', 'Pod Assignment', 'dropdown-item disabled'); ?>
					<?= makeNavLink($page_name, 'double-report.php', 'Doubles', 'dropdown-item disabled'); ?>
				</div>
			</li>
			<li class="nav-item dropdown">
				<?= makeNavLink($page_name, 'config.php', '<i class="fa fa-cogs" aria-hidden="true"></i>
', 'nav-link dropdown-toggle', 'data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"'); ?>
				<div class="dropdown-menu">
					<?= makeNavLink($page_name, 'config.php', 'Config', 'dropdown-item disabled'); ?>
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
