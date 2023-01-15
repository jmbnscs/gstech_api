<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Payment.php';

    $database = new Database();
    $db = $database->connect();

    $payment = new Payment ($db);

    $result = $payment->read_advanced_payments();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $payment->center_id = $payment_center;
            $payment->getPaymentCenter();

            $data = array(
                'payment_center' => $payment->payment_center,
                'payment_id' => $payment_id,
                'amount_paid' => $amount_paid,
                'payment_reference_id' => $payment_reference_id,
                'account_id' => $account_id,
                'invoice_id' => $invoice_id,
                'tagged' => $tagged,
                'payment_date' => $payment_date
            );

            array_push($arr, $data);
        }

        echo json_encode($arr);
    }
    else
    {
        echo json_encode(
            array('message' => 'No Payments Found')
        );
    }