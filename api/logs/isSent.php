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

    $log->invoice_id = $data->invoice_id;
    $log->status_id = $data->status_id;
    $log->today_date = $data->today_date;

    if ($log->isSent()) {
        echo json_encode(
            array('message' => true)
        );
    }
    else {
        echo json_encode(
            array('message' => false)
        );
    }