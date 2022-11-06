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

    // Admin Read Query
    $result = $admin->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any Admin
    if ($num > 0)
    {
        // Admin Array
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
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
                'hashed' => $hashed
            );

            // Push to "data"
            array_push($arr, $data);
        }

        // Turn to JSON & Output
        echo json_encode($arr);
    }
    else
    {
        // No Admins
        echo json_encode(
            array('message' => 'No Admins Found')
        );
    }