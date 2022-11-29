<?php 
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Payment.php';

$database = new Database();
$db = $database->connect();

$payment = new Payment($db);

$data = json_decode(file_get_contents("php://input"));

$payment->payment_id = $data->payment_id;

// Delete payment
if($payment->delete()) {
    echo json_encode(
        array ('success' => true)
    );
}
else
{
    echo json_encode(
        array (
            'success' => false,
            'error' => $payment->error
        )
    );
}

