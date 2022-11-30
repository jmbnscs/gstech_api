<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Admin.php';

    $database = new Database();
    $db = $database->connect();

    $admin = new Admin($db);

    $data = json_decode(file_get_contents("php://input"));

    $admin->admin_id = $data->admin_id;
    $admin->admin_password = $data->admin_password;
    $admin->admin_username = $data->admin_username;

    if($admin->reset_password()) {
        echo json_encode(
            array('success' => true)
    );
    } 
    else {
        echo json_encode(
            array(
                'success' => false,
                'error' => $admin->error
            )
        );
    }
    