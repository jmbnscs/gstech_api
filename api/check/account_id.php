<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Account.php';

    $database = new Database();
    $db = $database->connect();

    $account = new Account ($db);

    $account->account_id = isset($_GET['account_id']) ? $_GET['account_id'] : die();

    if ($account->isAccountExist()) {
        echo json_encode(
            array(
                'error' => $account->error,
                'exist' => true
            )
        );
    }
    else {
        echo json_encode(
            array(
                'exist' => false
            )
        );
    }