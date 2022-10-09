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
    $invoice->invoice_id = isset($_GET['invoice_id']) ? $_GET['invoice_id'] : die();

    // Get Invoice
    $invoice->read_single();

    // Create Array
    $cat_arr = array (
        'invoice_id' => $invoice->invoice_id,
        'account_id' => $invoice->account_id,
        'billing_period_start' => $invoice->billing_period_start,
        'billing_period_end' => $invoice->billing_period_end,
        'disconnection_date' => $invoice->disconnection_date,
        'previous_bill' => $invoice->previous_bill,
        'previous_payment' => $invoice->previous_payment,
        'balance' => $invoice->balance,
        'secured_cash' => $invoice->secured_cash,
        'subscription_amount' => $invoice->subscription_amount,
        'prorated_charge' => $invoice->prorated_charge,
        'installation_charge' => $invoice->installation_charge,
        'total_bill' => $invoice->total_bill,
        'invoice_status_id' => $invoice->invoice_status_id,
        'invoice_reference_id' => $invoice->invoice_reference_id,
        'payment_reference_id' => $invoice->payment_reference_id,
        'amount_paid' => $invoice->amount_paid,
        'running_balance' => $invoice->running_balance,
        'payment_date' => $invoice->payment_date,
    );

    // Make JSON
    print_r(json_encode($cat_arr));