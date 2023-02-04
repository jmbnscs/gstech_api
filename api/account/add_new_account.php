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

    $account = new Account ($db);
    $customer = new Customer ($db);
    $installation = new Installation ($db);
    $ratings = new Ratings ($db);

    $error_counter = 0;

    $data = json_decode(file_get_contents("php://input"));

    $account->account_id = $data->account_id;
    $customer->account_id = $data->account_id;
    $installation->account_id = $data->account_id;
    $ratings->account_id = $data->account_id;

    // Create Account Record
    $account->start_date = $data->start_date;
    $account->plan_id = $data->plan_id;
    $account->connection_id = $data->connection_id;
    $account->area_id = $data->area_id;

    // Create Customer Record
    $customer->first_name = $data->first_name;
    $customer->middle_name = $data->middle_name;
    $customer->last_name = $data->last_name;
    $customer->billing_address = $data->billing_address;
    $customer->mobile_number = $data->mobile_number;
    $customer->email = $data->email;
    $customer->birthdate = $data->birthdate;

    // Create Installation Record
    $installation->install_type_id = $data->install_type_id;

    (!$account->create()) ? $error_counter++ : $error_counter = $error_counter;
    (!$customer->create()) ? $error_counter++ : $error_counter = $error_counter;
    (!$installation->create()) ? $error_counter++ : $error_counter = $error_counter;
    (!$ratings->create()) ? $error_counter++ : $error_counter = $error_counter;

    if ($error_counter > 0) {
        $ratings->delete();
        $installation->delete();
        $customer->delete();
        $account->delete();

        echo json_encode(
            array (
                'success' => false,
                'error' => 'Some error has occured, please try again.'
            )
        );
    }
    else {
        echo json_encode(
            array ('success' => true)
        );
    }