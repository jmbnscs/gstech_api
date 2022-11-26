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

    if ($invoice->create())
    {
        echo json_encode(
            array (
                'message' => 'Invoice Created',
                'invoice_id' => $invoice->invoice_id
            )
        );
    }
    else
    {
        echo json_encode(
            array ('message' => 'Invoice Not Created')
        );
    }