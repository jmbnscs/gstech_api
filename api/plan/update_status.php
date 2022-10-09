<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Plan.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate invoice object
    $plan = new Plan($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // ID to Update
    $plan->plan_id = $data->plan_id;

    $plan->plan_status_id = $data->plan_status_id;

    // Update plan
    if($plan->update_status()) {
        echo json_encode(
            array('message' => 'Plan Updated',
            'plan_id' => $plan->plan_id,
            'plan_status_id' => $plan->plan_status_id)
    );
    } else {
        echo json_encode(
            array('message' => 'Plan not updated')
        );
    }