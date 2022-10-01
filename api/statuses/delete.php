<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Statuses.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate account object
    $statuses = new Statuses($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // Set Table to Delete
    $statuses->status_table = $data->status_table;

    // Set ID to Delete
    $statuses->status_id = $data->status_id;

    // Delete account
    if($statuses->delete()) {
        echo json_encode(
        array('message' => 'Status Deleted')
    );
    } else {
        echo json_encode(
        array('message' => 'Status Not Deleted')
    );
    }
