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
    $status = new Statuses ($db);

    // GET ID
    $data = json_decode(file_get_contents("php://input"));

    $status->status_table = $data->status_table;
    $status->status_id = $data->status_id;
    
    // Get Post
    $status->read_single();

    if ($status->status_name === 'error') 
    {
        $arr = array (
            'status_name' => $status->status_name,
        );
    }
    else 
    {
        $arr = array (
            'status_name' => $status->status_name,
        );
    }

    // Make JSON
    print_r(json_encode($arr));