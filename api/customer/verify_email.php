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
    $customer->email = $data->email;
    
    // Get Post
    $customer->verify_email();

    if ($customer->message === 'success') 
    {
        $arr = array (
            'success' => true
        );
    }
    else 
    {
        $arr = array (
            'message' => $customer->message,
            'success' => false
        );
    }

    // Make JSON
    print_r(json_encode($arr));