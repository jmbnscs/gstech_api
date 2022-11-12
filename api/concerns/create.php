<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Concerns.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $concerns = new Concerns ($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $concerns->concern_category = $data->concern_category;
    $concerns->customer_access = $data->customer_access;

    // Create Concern
    if ($concerns->create())
    {
        echo json_encode(
            array ('message' => 'Concern Created')
        );
    }
    else
    {
        echo json_encode(
            array ('message' => 'Concern Not Created')
        );
    }