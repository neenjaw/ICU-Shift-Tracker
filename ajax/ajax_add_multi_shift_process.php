<?php
session_start();
require_once '../includes/dbconfig.php';

try {
    if (isset($_POST['shiftData'])) {

        $data = json_decode($_POST['shiftData']);

        foreach ($data as $entry) {

          //required variables
          if (isset($entry->staff)) { $staff_id = $entry->staff; } else { throw new Exception('No staff id submitted.'); }
          if (isset($entry->date)) { $shift_date = $entry->date; } else { throw new Exception('No date submitted.'); }
          if (isset($entry->role)) { $role = $entry->role; } else { throw new Exception('No role submitted.'); }
          if (isset($entry->assignment)) { $assignment = $entry->assignment; } else { throw new Exception('No assignment submitted.'); }
          if (isset($entry->dayornight)) { $d_or_n = (($entry->dayornight == 'D') ? false : true); } else { throw new Exception('No day or night modifier submitted.'); }

        //
        //   //optional variables
        //   $ck_v = (isset($entry->nonvent)) ? false : true;
        //   $ck_doubled = (isset($entry->doubled)) ? true : false;
        //   $ck_vsick = (isset($entry->vsick)) ? true : false;
        //   $ck_crrt = (isset($entry->crrt)) ? true : false;
        //   $ck_admit = (isset($entry->admit)) ? true : false;
        //   $ck_codepgr = (isset($entry->codepg)) ? true : false;
        //   $ck_evd = (isset($entry->evd)) ? true : false;
        //   $ck_burn = (isset($entry->burn)) ? true : false;
        //
        //   if ($crud->createShiftEntry($shift_date, $staff_id, $role, $assignment, $d_or_n, $ck_doubled, $ck_v, $ck_admit, $ck_vsick, $ck_codepgr, $ck_crrt, $ck_evd, $ck_burn)) {
        //       echo "ok";
        //   } else {
        //       throw new Exception("Could not add new shift entry, check details."); // wrong details
        //   }
        //
        echo "received";
        }

    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
