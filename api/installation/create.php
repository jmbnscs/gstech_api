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

    if ($installation->install_type_id === 2 || $installation->install_type_id === "2")
    {
        $installation->installation_total_charge = 1200;
        $installation->installation_balance = 1200;
        $installation->installment = 6;
        $installation->installation_status_id = 2;
    }
    else
    {
        $installation->installation_total_charge = 0;
        $installation->installation_balance = 0;
        $installation->installment = 0;
        $installation->installation_status_id = 1;
    }

    // Create post
    if ($installation->create())
    {
        echo json_encode(
            array ('message' => 'Installation Created')
        );
    }
    else
    {
        echo json_encode(
            array ('message' => 'Installation Not Created')
        );
    }