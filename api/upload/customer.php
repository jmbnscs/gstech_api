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
include_once '../../models/Invoice.php';

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

$account = new Account ($db);
$customer = new Customer ($db);
$install = new Installation ($db);
$rate = new Ratings ($db);

$views = new Views ($db);
$invoice = new Invoice ($db);

$views->plan_name = $data->plan_name;
$views->connection_name = $data->connection_name;
$views->install_type_name = $data->install_type_name;
$views->area_name = $data->area_name;
$views->install_status = $data->install_status;
$result = $views->getImportIDs();

$num = $result->rowCount();

if ($num > 0)
{
    $row = $result->fetch(PDO::FETCH_ASSOC);
    extract($row);

    // $bill_start->format('F');
    $start_date = new DateTime($data->start_date);
    $birthdate = new DateTime($data->birthdate);
    $billing_period_end = new DateTime($data->billing_end_date);

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
                if ($install_type_id == 2) {
                    $install->installation_balance = $data->installation_balance;
                    $install->installation_status_id = $install_status_id;

                    $install->update_import();
                }

                $rate->account_id = $data->account_id;
    
                if ($rate->create()) {
                    $invoice->account_id = $data->account_id;
                    $invoice->billing_period_end = $billing_period_end->format('Y-m-d');
                    $invoice->total_bill = $data->total_bill;
                    $invoice->running_balance = $data->running_balance;

                    if ($invoice->create_import()) {
                        echo json_encode(
                            array ('success' => true)
                        );
                    }
                    else {
                        $invoice->delete();
                        echo json_encode(
                            array (
                                'success' => false,
                                'error' => $invoice->error
                            )
                        );
                    }
                }
                else {
                    $customer->delete();
                    $account->delete();
                    $install->delete();
                    $rate->delete();
                    
                    echo json_encode(
                        array (
                            'success' => false,
                            'error' => $rate->error
                        )
                    );
                }
                
            }
            else {
                $customer->delete();
                $account->delete();
                $install->delete();
                echo json_encode(
                    array (
                        'success' => false,
                        'error' => $install->error
                    )
                );
            }
        }
        else {
            $customer->delete();
            $account->delete();

            echo json_encode(
                array (
                    'success' => false,
                    'error' => $customer->error
                )
            );
        }
    }
    else {
        $account->delete();
        echo json_encode(
            array (
                'success' => false,
                'error' => $account->error
            )
        );
    }
}



