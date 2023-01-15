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

$restriction->custdata_edit = $data->custdata_edit;
$restriction->payments_edit = $data->payments_edit;
$restriction->prorate_edit = $data->prorate_edit;
$restriction->admindata_edit = $data->admindata_edit;
$restriction->plans_edit = $data->plans_edit;
$restriction->active_claim = $data->active_claim;
$restriction->payments_dlt = $data->payments_dlt;
$restriction->prorate_dlt = $data->prorate_dlt;
$restriction->active_invalid = $data->active_invalid;

$restriction->plans_add = $data->plans_add;
$restriction->admins_add = $data->admins_add;
$restriction->tickets_add = $data->tickets_add;

if($restriction->create_buttons_restriction()) {
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