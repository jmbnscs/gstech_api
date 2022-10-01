<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Statuses.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $statuses = new Statuses ($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Table to Create Status On
    $statuses->status_table = $data->status_table;

    $statuses->status_name = $data->status_name;

    // Create Status
    if ($statuses->create())
    {
        echo json_encode(
            array ('message' => 'Status Created')
        );
    }
    else
    {
        echo json_encode(
            array ('message' => 'Status Not Created')
        );
    }