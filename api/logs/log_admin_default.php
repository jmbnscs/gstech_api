<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/LogsDatabase.php';
    include_once '../../models/Logs.php';

    $database = new LogsDatabase();
    $db = $database->connect();

    $log = new Logs ($db);

    $data = json_decode(file_get_contents("php://input"));

    $log->admin_id = $data->admin_id;
    $log->def_username = $data->def_username;
    $log->def_password = $data->def_password;

    if ($log->log_admin_default())
    {
        echo json_encode(
            array (
                'success' => true
            )
        );
    }
    else
    {
        echo json_encode(
            array (
                'success' => false,
                'error' => $log->error
            )
        );
    }