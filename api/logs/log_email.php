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

    $log->account_id = $data->account_id;
    $log->invoice_id = $data->invoice_id;
    $log->email_sent = $data->email_sent;
    $log->status_id = $data->status_id;

    // Create log
    if ($log->log_email())
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