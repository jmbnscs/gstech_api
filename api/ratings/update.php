<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Ratings.php';

    $database = new Database();
    $db = $database->connect();

    $rate = new Ratings($db); 

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to update
    $rate->account_id = $data->account_id;
    $rate->invoice_status = $data->invoice_status;

    // Update Rating
    if ($rate->update()) {
        echo json_encode(
            array('success' => true)
    );
    } 
    else {
        echo json_encode(
            array(
                'success' => false,
                'error' => $rate->error
            )
        );
    }