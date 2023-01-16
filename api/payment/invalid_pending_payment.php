<?php 
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Payment.php';

$database = new Database();
$db = $database->connect();

$payment = new Payment($db);

$data = json_decode(file_get_contents("php://input"));

$payment->approval_id = $data->approval_id;
$payment->status_id = 3;
$payment->payment_id = null;

if($payment->update_pending_status()) {
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

