<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Statuses.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate plan object
    $statuses = new Statuses($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // Table to Update
    $statuses->status_table = $data->status_table;

    // ID to Update
    $statuses->status_id = $data->status_id;

    $statuses->status_name = $data->status_name;

    // Update account
    if($statuses->update()) {
        echo json_encode(
            array('message' => 'Status Updated')
    );
    } else {
        echo json_encode(
            array('message' => 'Status not updated')
        );
    }