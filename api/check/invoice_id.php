<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Invoice.php';

    $database = new Database();
    $db = $database->connect();

    $invoice = new Invoice ($db);

    $invoice->invoice_id = isset($_GET['invoice_id']) ? $_GET['invoice_id'] : die();

    if ($invoice->isInvoiceIDExist()) {
        echo json_encode(
            array(
                'exist' => true
            )
        );
    }
    else {
        echo json_encode(
            array(
                'error' => $invoice->error,
                'exist' => false
            )
        );
    }