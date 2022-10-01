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

    $admin->admin_status_id = $data->admin_status_id;

    // Update admin
    if($admin->update_status()) {
        echo json_encode(
            array('message' => 'Admin Updated')
    );
    } else {
        echo json_encode(
            array('message' => 'Admin not updated')
        );
    }
