<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Admin.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $admin = new Admin ($db);

    // GET ID
    $data = json_decode(file_get_contents("php://input"));

    $admin->admin_id = $data->admin_id;
    $admin->admin_password = $data->admin_password;
    
    // Verify Admin Password
    // $admin->verify_password();

    if ($admin->verify_password()) 
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