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

    // Instantiate plan object
    $customer = new Customer($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // ID to Update
    $customer->account_id = $data->account_id;

    $customer->billing_address = $data->billing_address;
    $customer->mobile_number = $data->mobile_number;
    $customer->email = $data->email;

    // Update account
    if($customer->update()) {
        echo json_encode(
            array('message' => 'Customer Updated')
    );
    } else {
        echo json_encode(
            array('message' => 'Customer not updated')
        );
    }