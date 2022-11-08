<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Admin.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate admin object
    $admin = new Admin($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // ID to Update
    $admin->admin_id = $data->admin_id;

    $admin->admin_email = $data->admin_email;
    $admin->mobile_number = $data->mobile_number;
    $admin->address = $data->address;
    $admin->user_level_id = $data->user_level_id;

    // Update admin
    if($admin->update()) {
        echo json_encode(
            array('message' => 'success')
        );
    } else {
        echo json_encode(
            array('message' => $admin->error)
        );
    }
    