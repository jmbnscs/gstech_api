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
$payment->payment_center = $data->payment_center;

$payment->amount_paid = $data->amount_paid;
$payment->payment_reference_id = $data->payment_reference_id;

// Update Payment
if($payment->update()) {
    echo json_encode(
        array('message' => 'Payment Record Updated')
);
} else {
    echo json_encode(
        array('message' => 'Payment Record not updated')
    );
}
