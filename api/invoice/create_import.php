<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Invoice.php';

    $database = new Database();
    $db = $database->connect();

    $invoice = new Invoice ($db);

    $data = json_decode(file_get_contents("php://input"));

    $invoice->account_id = $data->account_id;
    $invoice->billing_period_end = $data->billing_period_end;
    $invoice->total_bill = $data->total_bill;
    $invoice->running_balance = $data->running_balance;

    // Update account
    if($invoice->create_import()) {
        echo json_encode(
            array('success' => true)
        );
    } else {
        echo json_encode(
            array(
                'success' => false,
                'error' => $invoice->error
            )
        );
    }