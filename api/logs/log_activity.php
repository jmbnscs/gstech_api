<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/LogsDatabase.php';
    include_once '../../models/Logs.php';

    // Instantiate DB & Connect
    $database = new LogsDatabase();
    $db = $database->connect();

    $log = new Logs ($db);

    $data = json_decode(file_get_contents("php://input"));

    $log->admin_id = $data->admin_id;
    $log->username = $data->username;
    $log->page_accessed = $data->page_accessed;
    $log->activity = $data->activity;
    $log->ip_address = $data->ip_address;
    $log->user_agent = $data->user_agent;

    // Create log
    if ($log->log_activity())
    {
        echo json_encode(
            array (
                'message' => true
            )
        );
    }
    else
    {
        echo json_encode(
            array ('message' => false)
        );
    }