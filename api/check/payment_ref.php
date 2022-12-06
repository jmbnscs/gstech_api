<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Payment.php';

    $database = new Database();
    $db = $database->connect();

    $payment = new Payment ($db);

    $payment->payment_reference_id = isset($_GET['payment_reference_id']) ? $_GET['payment_reference_id'] : die();

    if ($payment->isPayRefExist()) {
        echo json_encode(
            array(
                'error' => $payment->error,
                'exist' => true
            )
        );
    }
    else {
        echo json_encode(
            array(
                'exist' => false
            )
        );
    }