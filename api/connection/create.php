<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Connection.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $connection = new Connection ($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $connection->connection_name = $data->connection_name;

    // Create post
    if ($connection->create())
    {
        echo json_encode(
            array ('message' => 'Connection Created')
        );
    }
    else
    {
        echo json_encode(
            array ('message' => 'Connection Not Created')
        );
    }