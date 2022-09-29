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

// Instantiate plan object
$plan = new Plan($db);

// Get raw data
$data = json_decode(file_get_contents("php://input"));

// ID to Update
$plan->plan_id = $data->plan_id;

$plan->plan_name = $data->plan_name;
$plan->bandwidth = $data->bandwidth;
$plan->price = $data->price;
$plan->promo_id = $data->promo_id;
$plan->plan_status_id = $data->plan_status_id;

// Update Plan
if($plan->update()) {
    echo json_encode(
        array('message' => 'Plan Updated')
);
} else {
    echo json_encode(
        array('message' => 'Plan not updated')
    );
}
