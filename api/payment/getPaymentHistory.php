<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Payment.php';

    $database = new Database();
    $db = $database->connect();

    $payment = new Payment ($db);

    $payment->invoice_id = isset($_GET['invoice_id']) ? $_GET['invoice_id'] : die();

    $result = $payment->getPaymentHistory();

    // echo json_encode($result);

    $num = $result->rowCount();

    // Check if any Payment Record
    if ($num > 0)
    {
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $data = array(
                'payment_center' => $payment_center,
                'amount_paid' => $amount_paid,
                'payment_reference_id' => $payment_reference_id,
                'payment_date' => $payment_date,
            );

            // $data = array(
            //     'account_id' => $account_id,
            //     'disconnection_date' => $disconnection_date,
            // );

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