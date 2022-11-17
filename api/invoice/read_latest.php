<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Invoice.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $invoice = new Invoice ($db);

    // GET ID
    $invoice->account_id = isset($_GET['account_id']) ? $_GET['account_id'] : die();

    // Get Invoice
    $invoice->read_latest();

    // Create Array
    $arr = array (
        'invoice_id' => $invoice->invoice_id,
        'invoice_status_id' => $invoice->invoice_status_id,
    );

    // Make JSON
    print_r(json_encode($arr));