<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/UserLevel.php';

    $database = new Database();
    $db = $database->connect();

    $user_level = new UserLevel ($db);

    $data = json_decode(file_get_contents("php://input"));

    $user_level->user_role = $data->user_role;

    if ($user_level->create())
    {
        echo json_encode(
            array (
                'success' => true,
                'user_id' => $user_level->user_id
            )
        );
    }
    else
    {
        echo json_encode(
            array (
                'success' => false,
                'error' => $user_level->error
            )
        );
    }