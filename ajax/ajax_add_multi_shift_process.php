<?php
session_start();
require_once '../includes/dbconfig.php';

/**
 * Shift Entry Exception
 */
class ShiftEntryException extends Exception {

}

function checkIfNumAndInt($num) {
  if (is_numeric($num)) {
    $num = get_numeric($num);
    if (is_int($num)) {
      return true;
    }
  }
  return false;
}

function get_numeric($val) {
  if (is_numeric($val)) {
    return $val + 0;
  }
  return 0;
}

try {
    if (isset($_POST['shiftData'])) {

      $data = json_decode($_POST['shiftData']);

      foreach ($data as $entry) {
        try {

          //check data, if wrong throw exception for malformed data
          if (!isset($entry->staff)) { throw new ShiftEntryException('Need Staff ID'); }
          if (!isset($entry->date)) { throw new ShiftEntryException('Need Shift Date'); }
          if (!isset($entry->role)) { throw new ShiftEntryException('Need role ID'); }
          if (!isset($entry->assignment)) { throw new ShiftEntryException('Need assignment ID'); }
          if (!isset($entry->dayornight)) { throw new ShiftEntryException('Need day/night modifier'); }

          if (!checkIfNumAndInt($entry->staff)) { throw new ShiftEntryException('Staff ID needs to be an integer'); }
          if (!checkIfNumAndInt($entry->role)) { throw new ShiftEntryException('Role ID needs to be an integer'); }
          if (!checkIfNumAndInt($entry->assignment)) { throw new ShiftEntryException('Assignment ID needs to be an integer'); }

          //format data as needed for insertion
          if ($entry->dayornight == "D") {
            $entry->dayornight = 0;
          } elseif ($entry->dayornight == "N") {
            $entry->dayornight = 1;
          } else {
            throw new ShiftEntryException('Day/night modifier needs to be either [D\N]');
          }

          //create vented property of entry, as db tracks vents, not nonvents
          $entry->vented = !$entry->nonvent;

        } catch (ShiftEntryException $e) {
          echo "Error, malformed data: {$e->getMessage()}\n";
        }
      }

      if ($crud->createMultipleShiftEntries($data)) {
        echo "ok";
      } else {
        echo "not ok";
      }

    }
} catch (CRUD_SQL_Exception $e) {
  echo "Unable to create shift entry: {$e->getMessage()}\n";
} catch (PDOException $e) {
  echo $e->getMessage();
}
