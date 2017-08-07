<?php
session_start();
require_once '../includes/dbconfig.php';

try {
    if (isset($_POST['btn-submit-new-staff'])) {
        $first_name = ucwords(trim($_POST['first-name']));
        $last_name = ucwords(trim($_POST['last-name']));
        $category_id = ucwords(trim($_POST['category-id']));
    
        if ($crud->createStaff($first_name, $last_name, $category_id, 1)) {
            echo "ok";
        } else {
            echo "Could not add new staff member, check details."; // wrong details
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
