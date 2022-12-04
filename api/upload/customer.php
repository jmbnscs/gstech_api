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

include_once '../../models/Views.php';

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

$account = new Account ($db);
$customer = new Customer ($db);
$install = new Installation ($db);
$rate = new Ratings ($db);

$views = new Views ($db);

$views->plan_name = $data->plan_id;
$views->connection_name = $data->connection_id;
$views->install_type_name = $data->install_type_id;
$views->area_name = $data->area_id;
$result = $views->getImportIDs();

$num = $result->rowCount();

if ($num > 0)
{
    $row = $result->fetch(PDO::FETCH_ASSOC);
    extract($row);

    // $bill_start->format('F');
    $start_date = new DateTime($data->start_date);
    $birthdate = new DateTime($data->birthdate);

    $account->account_id = $data->account_id;
    $account->start_date = $start_date->format('Y-m-d');
    $account->plan_id = $plan_id;
    $account->connection_id = $connection_id;
    $account->area_id = $area_id;

    if ($account->import()) {
        $customer->account_id = $data->account_id;
        $customer->first_name = $data->first_name;
        $customer->middle_name = $data->middle_name;
        $customer->last_name = $data->last_name;
        $customer->billing_address = $data->billing_address;
        $customer->mobile_number = $data->mobile_number;
        $customer->email = $data->email;
        $customer->birthdate = $birthdate->format('Y-m-d');
    
        if ($customer->create()) {
            $install->install_type_id = $install_type_id;
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
}



