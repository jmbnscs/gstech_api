<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Restriction.php';

$database = new Database();
$db = $database->connect();

$restriction = new Restriction($db);

$data = json_decode(file_get_contents("php://input"));

$restriction->user_id = $data->user_id;

$restriction->customer_list = $data->customer_list;
$restriction->customer_add = $data->customer_add;
$restriction->invoice_view = $data->invoice_view;
$restriction->invoice_payment = $data->invoice_payment;
$restriction->invoice_prorate = $data->invoice_prorate;
$restriction->invoice_payment_add = $data->invoice_payment_add;
$restriction->plan_view = $data->plan_view;
$restriction->ticket_page = $data->ticket_page;
$restriction->ticket_active = $data->ticket_active;
$restriction->ticket_invalid = $data->ticket_invalid;
$restriction->admin_view = $data->admin_view;

if($restriction->create_pages_restriction()) {
    echo json_encode(
        array('success' => true)
    );
} else {
    echo json_encode(
        array(
            'success' => false,
            'error' => $restriction->error
        )
    );
}