<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Account.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Account object
    $account = new Account ($db);

    // Get raw account data
    $data = json_decode(file_get_contents("php://input"));

    $account->account_id = $data->account_id;
    $account->start_date = $data->start_date;
    $account->plan_id = $data->plan_id;
    $account->connection_id = $data->connection_id;
    $account->account_status_id = $data->account_status_id;
    $account->area_id = $data->area_id;

    // Create Account
    if ($account->create())
    {
        echo json_encode(
            array ('success' => true)
        );
    }
    else
    {
        echo json_encode(
            array (
                'success' => false,
                'error' => $account->error
            )
        );
    }