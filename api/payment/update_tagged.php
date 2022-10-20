<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Payment.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Payment object
    $payment = new Payment($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // ID to Update
    $payment->payment_id = $data->payment_id;

    $payment->account_id = $data->account_id;
    $payment->invoice_id = $data->invoice_id;

    // Update payment
    if($payment->update_tagged()) {
        echo json_encode(
            array('message' => 'Payment Tagged')
    );
    } else {
        echo json_encode(
            array('message' => 'Payment not Tagged')
        );
    }