<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Payment.php';

    $database = new Database();
    $db = $database->connect();

    $payment = new Payment ($db);

    $payment->account_id = isset($_GET['account_id']) ? $_GET['account_id'] : die();

    $result = $payment->read_single_account();

    $num = $result->rowCount();

    // Check if any Payment Record
    if ($num > 0)
    {
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $data = array(
                'payment_id' => $payment_id,
                'amount_paid' => $amount_paid,
                'payment_reference_id' => $payment_reference_id,
                'payment_date' => $payment_date,
                'account_id' => $account_id,
                'invoice_id' => $invoice_id,
                'tagged' => $tagged,
            );

            array_push($arr, $data);
        }

        // Turn to JSON & Output
        echo json_encode($arr);
    }
    else
    {
        echo json_encode(
            array('message' => 'No Payment Records Found')
        );
    }