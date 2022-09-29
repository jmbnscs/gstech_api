<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Ratings.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate post object
    $ratings = new Ratings ($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $ratings->account_id = $data->account_id;

    // Create post
    if ($ratings->create())
    {
        echo json_encode(
            array ('message' => 'Ratings Created')
        );
    }
    else
    {
        echo json_encode(
            array ('message' => 'Ratings Not Created')
        );
    }