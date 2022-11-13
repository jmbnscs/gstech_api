<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Payment.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Payment object
    $payment = new Payment ($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $payment->amount_paid = $data->amount_paid;
    $payment->payment_reference_id = $data->payment_reference_id;
    $payment->payment_date = $data->payment_date;

    // Create Payment
    if ($payment->create())
    {
        echo json_encode(
            array (
                'message' => 'Payment Record Created',
                'payment_id' => $payment->payment_id
            )
        );
    }
    else
    {
        echo json_encode(
            array ('message' => 'Payment Record Not Created')
        );
    }