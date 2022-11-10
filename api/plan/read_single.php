<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Plan.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $plan = new plan ($db);

    // GET ID
    $plan->plan_id = isset($_GET['plan_id']) ? $_GET['plan_id'] : die();

    // Get Post
    $plan->read_single();

    // Create Array
    $cat_arr = array (
        'plan_id' => $plan->plan_id,
        'plan_name' => $plan->plan_name,
        'bandwidth' => $plan->bandwidth,
        'price' => $plan->price,
        'plan_status_id' => $plan->plan_status_id,
    );

    // Make JSON
    print_r(json_encode($cat_arr));