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

    $customer->login_username = $data->login_username;
    $customer->customer_password = $data->customer_password;
    
    // Get Post
    $customer->login();

    if ($customer->message === 'success' || $customer->message === 'change password') 
    {
        $arr = array (
            'account_id' => $customer->account_id,
            'message' => $customer->message,
        );
    }
    else 
    {
        $arr = array (
            // 'account_id' => $customer->account_id,
            'message' => $customer->message,
        );
    }

    // Make JSON
    print_r(json_encode($arr));