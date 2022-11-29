<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Customer.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate customer object
    $customer = new Customer ($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $customer->account_id = $data->account_id;
    $customer->first_name = $data->first_name;
    $customer->middle_name = $data->middle_name;
    $customer->last_name = $data->last_name;
    $customer->billing_address = $data->billing_address;
    $customer->mobile_number = $data->mobile_number;
    $customer->email = $data->email;
    $customer->birthdate = $data->birthdate;

    // Create customer
    if ($customer->create())
    {
        echo json_encode(
            array ('success' => true)
        );
    }
    else
    {
        echo json_encode(
            array (
                'success' => false,
                'error' => $customer->error
            )
        );
    }