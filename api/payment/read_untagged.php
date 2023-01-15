<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Payment.php';

    $database = new Database();
    $db = $database->connect();

    $payment = new Payment ($db);

    $result = $payment->read_untagged();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $data = array(
                'payment_center' => $payment_center,
                'payment_id' => $payment_id,
                'amount_paid' => $amount_paid,
                'payment_reference_id' => $payment_reference_id,
                'payment_date' => $payment_date,
                'tagged' => $tagged,
                'success' => true
            );

            array_push($arr, $data);
        }

        echo json_encode($arr);
    }
    else
    {
        echo json_encode(
            array('success' => false)
        );
    }