<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Admin.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Admin object
    $admin = new Admin($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to Delete
    $admin->admin_id = $data->admin_id;

    // Delete Admin
    if($admin->delete()) {
        echo json_encode(
        array('message' => 'Admin Deleted')
    );
    } else {
        echo json_encode(
        array('message' => 'Admin Not Deleted')
    );
    }

