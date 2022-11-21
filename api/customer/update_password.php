<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Customer.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate admin object
    $customer = new Customer($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // ID to Update
    $customer->account_id = $data->account_id;

    $customer->customer_password = $data->customer_password;

    // Update Password
    if($customer->update_password()) {
        echo json_encode(
            array('message' => 'Password Updated')
    );
    } else {
        echo json_encode(
            array('message' => $customer->error)
        );
    }
    