<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Area.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $area = new Area ($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $area->area_name = $data->area_name;

    // Create post
    if ($area->create())
    {
        echo json_encode(
            array ('message' => 'Area Created')
        );
    }
    else
    {
        echo json_encode(
            array ('message' => 'Area Not Created')
        );
    }