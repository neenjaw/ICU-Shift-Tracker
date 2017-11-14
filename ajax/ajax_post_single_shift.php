<?php
session_start();
require_once '../includes/dbconfig.php';

if (!isset($_SESSION['authenticated'])) {
  die("Unauthorized.");
}

try {
    if (isset($_POST['btn-submit-new-shift'])) {

        //required variables
        if (isset($_POST["staff"])) { $staff_id = $_POST["staff"]; } else { throw new Exception('No staff id submitted.'); }
        if (isset($_POST["date"])) { $shift_date = $_POST["date"]; } else { throw new Exception('No date submitted.'); }
        if (isset($_POST["role"])) { $role = $_POST["role"]; } else { throw new Exception('No role submitted.'); }
        if (isset($_POST["assignment"])) { $assignment = $_POST["assignment"]; } else { throw new Exception('No assignment submitted.'); }
        if (isset($_POST["dayornight"])) { $d_or_n = (($_POST["dayornight"] == 'D') ? false : true); } else { throw new Exception('No day or night modifier submitted.'); }

        //optional variables
        $ck_v = (isset($_POST["nonvent"])) ? false : true;
        $ck_doubled = (isset($_POST["doubled"])) ? true : false;
        $ck_vsick = (isset($_POST["vsick"])) ? true : false;
        $ck_crrt = (isset($_POST["crrt"])) ? true : false;
        $ck_admit = (isset($_POST["admit"])) ? true : false;
        $ck_codepgr = (isset($_POST["codepg"])) ? true : false;
        $ck_evd = (isset($_POST["evd"])) ? true : false;
        $ck_burn = (isset($_POST["burn"])) ? true : false;

        if ($crud->createShiftEntry($shift_date, $staff_id, $role, $assignment, $d_or_n, $ck_doubled, $ck_v, $ck_admit, $ck_vsick, $ck_codepgr, $ck_crrt, $ck_evd, $ck_burn)) {
            echo "ok";
        } else {
            throw new Exception("Could not add new shift entry, check details."); // wrong details
        }

    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
