<?php 
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Payment.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate Payment object
$payment = new Payment($db);

// Get raw data
$data = json_decode(file_get_contents("php://input"));

// Set ID to Delete
$payment->payment_id = $data->payment_id;

// Delete payment
if($payment->delete()) {
    echo json_encode(
    array('message' => 'Payment Record Deleted')
);
} else {
    echo json_encode(
    array('message' => 'Payment Record Not Deleted')
);
}

