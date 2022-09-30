<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Customer.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $customer = new Customer ($db);

    // Category Read Query
    $result = $customer->read();

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
                'customer_id' => $customer_id,
                'account_id' => $account_id,
                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'last_name' => $last_name,
                'billing_address' => $billing_address,
                'mobile_number' => $mobile_number,
                'email' => $email,
                'birthdate' => $birthdate,
                'gstech_id' => $gstech_id,
                'customer_username' => $customer_username,
                'customer_password' => $customer_password,
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
        // No Categories
        echo json_encode(
            array('message' => 'No Customers Found')
        );
    }