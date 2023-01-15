<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Payment.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Payment object
    $payment = new Payment ($db);

    // GET ID
    $payment->payment_id = isset($_GET['payment_id']) ? $_GET['payment_id'] : die();

    // Payment Read Query
    $result = $payment->read_single();

    // Get row count
    $num = $result->rowCount();

    // Check if any Payment Record
    if ($num > 0)
    {
        // Payment Array
        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $payment->center_id = $payment_center;
        $payment->getPaymentCenter();

        $arr = array(
            'payment_center' => $payment_center,
            'payment_center_name' => $payment->payment_center,
            'payment_id' => $payment_id,
            'amount_paid' => $amount_paid,
            'payment_reference_id' => $payment_reference_id,
            'payment_date' => $payment_date,
            'account_id' => $account_id,
            'invoice_id' => $invoice_id,
            'tagged' => $tagged,
        );

        print_r(json_encode($arr));
    }
    else
    {
        // No Payment
        echo json_encode(
            array('message' => 'No Payment Record Found')
        );
    }