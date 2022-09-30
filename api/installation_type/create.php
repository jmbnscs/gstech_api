<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/InstallationType.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate install type object
    $installation_type = new InstallationType ($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $installation_type->install_type_name = $data->install_type_name;

    // Create post
    if ($installation_type->create())
    {
        echo json_encode(
            array ('message' => 'Installation Type Created')
        );
    }
    else
    {
        echo json_encode(
            array ('message' => 'Installation Type Not Created')
        );
    }