<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Invoice.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Invoice object
    $invoice = new Invoice ($db);

    $invoice->invoice_status_id = isset($_GET['invoice_status_id']) ? $_GET['invoice_status_id'] : die();

    // Invoice Read Query
    $result = $invoice->read_by_status();

    // Get row count
    $num = $result->rowCount();

    // Check if any Invoice
    if ($num > 0)
    {
        // Invoice Array
        $cat_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $post_item = array(
                'invoice_id' => $invoice_id,
                'account_id' => $account_id,
                'billing_period_start' => $billing_period_start,
                'billing_period_end' => $billing_period_end,
                'disconnection_date' => $disconnection_date,
                'previous_bill' => $previous_bill,
                'previous_payment' => $previous_payment,
                'balance' => $balance,
                'secured_cash' => $secured_cash,
                'subscription_amount' => $subscription_amount,
                'prorated_charge' => $prorated_charge,
                'installation_charge' => $installation_charge,
                'total_bill' => $total_bill,
                'invoice_status_id' => $invoice_status_id,
                'invoice_reference_id' => $invoice_reference_id,
                'payment_reference_id' => $payment_reference_id,
                'amount_paid' => $amount_paid,
                'running_balance' => $running_balance,
                'payment_date' => $payment_date,
            );

            // Push to "data"
            array_push($cat_arr, $post_item);
        }

        // Turn to JSON & Output
        echo json_encode($cat_arr);
    }
    else
    {
        // No Invoices
        echo json_encode(
            array('message' => 'No Invoices Found')
        );
    }