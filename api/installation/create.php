<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Installation.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $installation = new Installation ($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $installation->install_type_id = $data->install_type_id;
    $installation->account_id = $data->account_id;

    // Create post
    if ($installation->create())
    {
        echo json_encode(
            array ('success' => true)
        );
    }
    else
    {
        echo json_encode(
            array (
                'success' => false,
                'error' => $installation->error
            )
        );
    }