<?php
session_start();
require_once '../includes/dbconfig.php';

/*

THIS DOESNT DO THE CORRECT FUNCTION YET

THIS IS JUST COPIED AS AN INITIAL TEMPLATE

*/

try {
    if (isset($_POST['btn-submit-new-shift'])) {
        var_dump($_POST);

        //if ($crud->createStaff($first_name, $last_name, $category_id, 1)) {
        //    echo "ok";
        //} else {
        //    echo "Could not add new shift member, check details."; // wrong details
        //}
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
