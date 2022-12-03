<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Account.php';
include_once '../../models/Customer.php';
include_once '../../models/Installation.php';
include_once '../../models/Ratings.php';

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

$account = new Account ($db);
$customer = new Customer ($db);
$install = new Installation ($db);
$rate = new Ratings ($db);

$account->account_id = $data->account_id;
$account->start_date = $data->start_date;
$account->plan_id = $data->plan_id;
$account->connection_id = $data->connection_id;
$account->area_id = $data->area_id;

if ($account->create()) {
    $customer->account_id = $data->account_id;
    $customer->first_name = $data->first_name;
    $customer->middle_name = $data->middle_name;
    $customer->last_name = $data->last_name;
    $customer->billing_address = $data->billing_address;
    $customer->mobile_number = $data->mobile_number;
    $customer->email = $data->email;
    $customer->birthdate = $data->birthdate;

    if ($customer->create()) {
        $install->install_type_id = $data->install_type_id;
        $install->account_id = $data->account_id;

        if ($install->create()) {
            $rate->account_id = $data->account_id;

            if ($rate->create()) {
                echo json_encode(
                    array ('success' => true)
                );
            }
            else {
                echo json_encode(
                    array (
                        'success' => false,
                        'error' => $rate->error
                    )
                );
            }
        }
        else {
            echo json_encode(
                array (
                    'success' => false,
                    'error' => $install->error
                )
            );
        }
    }
    else {
        echo json_encode(
            array (
                'success' => false,
                'error' => $customer->error
            )
        );
    }
}
else {
    echo json_encode(
        array (
            'success' => false,
            'error' => $account->error
        )
    );
}