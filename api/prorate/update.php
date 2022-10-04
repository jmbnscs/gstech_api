<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Prorate.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate plan object
    $prorate = new Prorate($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // ID to Update
    $prorate->prorate_id = $data->prorate_id;

    $prorate->account_id = $data->account_id;
    $prorate->duration = $data->duration;

    // Update Prorate
    if($prorate->update()) {
        echo json_encode(
            array('message' => 'Prorate Updated')
    );
    } else {
        echo json_encode(
            array('message' => 'Prorate not updated')
        );
    }