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

    $admin->admin_username = $data->admin_username;
    $admin->admin_password = $data->admin_password;
    
    // Get Admin
    $admin->login();

    if ($admin->message === 'success' || $admin->message === 'change password') 
    {
        $arr = array (
            'admin_id' => $admin->admin_id,
            'message' => $admin->message,
        );
    }
    else if ($admin->message === 'Invalid Password')
    {
        $arr = array (
            'login_attempts' => $admin->login_attempts,
            'message' => $admin->message,
        );
    }
    else 
    {
        $arr = array (
            'message' => $admin->message,
        );
    }

    // Make JSON
    print_r(json_encode($arr));