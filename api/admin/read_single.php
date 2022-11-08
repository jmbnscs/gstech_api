<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Admin.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Admin object
    $admin = new Admin ($db);

    // GET ID
    $admin->admin_id = isset($_GET['admin_id']) ? $_GET['admin_id'] : die();

    // Admin Read Query
    $result = $admin->read_single();

    // Get row count
    $num = $result->rowCount();

    // Check if any Admin Exist
    if ($num > 0)
    {
        $arr = array();

        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $data = array(
            'admin_id' => $admin_id,
            'admin_username' => $admin_username,
            'admin_password' => $admin_password,
            'admin_email' => $admin_email,
            'mobile_number' => $mobile_number,
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name,
            'birthdate' => $birthdate,
            'address' => $address,
            'employment_date' => $employment_date,
            'login_attempts' => $login_attempts,
            'created_at' => $created_at,
            'admin_status_id' => $admin_status_id,
            'user_level_id' => $user_level_id,
            'hashed' => $hashed,
            'message' => 'success'
        );

        print_r(json_encode($data));
    }
    else
    {
        echo json_encode(
            array('message' => 'error')
        );
    }