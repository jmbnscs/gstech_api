<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Installation.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate installation object
    $installation = new Installation($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // ID to Update
    $installation->installation_id = $data->installation_id;

    $installation->install_type_id = $data->install_type_id;
    $installation->account_id = $data->account_id;
    $installation->installation_status_id = $data->installation_status_id;

    // Update installation
    if($installation->update()) {
        echo json_encode(
            array('message' => 'Installation Updated')
    );
    } else {
        echo json_encode(
            array('message' => 'Installation not updated')
        );
    }
