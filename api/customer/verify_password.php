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

    // Instantiate blog post object
    $customer = new Customer ($db);

    // GET ID
    $data = json_decode(file_get_contents("php://input"));

    $customer->account_id = $data->account_id;
    $customer->customer_password = $data->customer_password;
    
    // Verify Customer Password
    // $customer->verify_password();

    if ($customer->verify_password()) 
    {
        $arr = array (
            'message' => 'success',
        );
    }
    else 
    {
        $arr = array (
            'message' => 'error',
        );
    }

    // Make JSON
    print_r(json_encode($arr));