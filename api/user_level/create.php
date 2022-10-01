<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/UserLevel.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $user_level = new UserLevel ($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $user_level->user_role = $data->user_role;

    // Create post
    if ($user_level->create())
    {
        echo json_encode(
            array ('message' => 'User Level Created')
        );
    }
    else
    {
        echo json_encode(
            array ('message' => 'User Level Not Created')
        );
    }