<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Invoice.php';

    $database = new Database();
    $db = $database->connect();

    $invoice = new Invoice ($db);

    $invoice->account_id = isset($_GET['account_id']) ? $_GET['account_id'] : die();

    $invoice->read_latest();

    $arr = array (
        'invoice_id' => $invoice->invoice_id,
        'invoice_status_id' => $invoice->invoice_status_id,
    );

    print_r(json_encode($arr));