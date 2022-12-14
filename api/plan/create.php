<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Plan.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $plan = new Plan ($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $plan->plan_name = $data->plan_name;
    $plan->bandwidth = $data->bandwidth;
    $plan->price = $data->price;

    // Create post
    if ($plan->create())
    {
        echo json_encode(
            array (
                'success' => true,
                'plan_id' => $plan->plan_id
            )
        );
    }
    else
    {
        echo json_encode(
            array (
                'success' => false,
                'error' => $plan->error
            )
        );
    }