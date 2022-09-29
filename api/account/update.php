<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Account.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate plan object
$account = new Account($db);

// Get raw data
$data = json_decode(file_get_contents("php://input"));

// ID to Update
$account->account_id = $data->account_id;

$account->start_date = $data->start_date;
$account->lockin_end_date = $data->lockin_end_date;
$account->billing_day = $data->billing_day;
$account->plan_id = $data->plan_id;
$account->connection_id = $data->connection_id;
$account->account_status_id = $data->account_status_id;
$account->area_id = $data->area_id;
$account->bill_count = $data->bill_count;

// Update account
if($account->update()) {
    echo json_encode(
        array('message' => 'Account Updated')
);
} else {
    echo json_encode(
        array('message' => 'Account not updated')
    );
}
