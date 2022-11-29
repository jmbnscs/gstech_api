<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Admin.php';

    $database = new Database();
    $db = $database->connect();

    $admin = new Admin ($db);

    $data = json_decode(file_get_contents("php://input"));

    $admin->admin_id = $data->admin_id;
    $admin->admin_email = $data->admin_email;
    $admin->mobile_number = $data->mobile_number;
    $admin->first_name = $data->first_name;
    $admin->middle_name = $data->middle_name;
    $admin->last_name = $data->last_name;
    $admin->birthdate = $data->birthdate;
    $admin->address = $data->address;
    $admin->employment_date = $data->employment_date;
    $admin->user_level_id = $data->user_level_id;

    if ($admin->create())
    {
        echo json_encode(
            array ('success' => true)
        );
    }
    else
    {
        echo json_encode(
            array (
                'success' => false,
                'error' => $admin->error
            )
        );
    }