<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Plan.php';

    $database = new Database();
    $db = $database->connect();

    $plan = new Plan ($db);

    $plan->plan_name = isset($_GET['plan_name']) ? $_GET['plan_name'] : die();

    if ($plan->isPlanNameExist()) {
        echo json_encode(
            array(
                'error' => $plan->error,
                'exist' => true
            )
        );
    }
    else {
        echo json_encode(
            array(
                'exist' => false
            )
        );
    }