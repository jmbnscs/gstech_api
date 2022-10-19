<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Admin.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $admin = new Admin ($db);

    // Category Read Query
    $result = $admin->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any posts
    if ($num > 0)
    {
        // Post Array
        $cat_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $post_item = array(
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
                'user_level_id' => $user_level_id
            );

            // Push to "data"
            array_push($cat_arr, $post_item);
        }

        // Turn to JSON & Output
        echo json_encode($cat_arr);
    }
    else
    {
        // No Admins
        echo json_encode(
            array('message' => 'No Admin Found')
        );
    }