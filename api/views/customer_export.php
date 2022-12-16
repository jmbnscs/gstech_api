<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Views.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $views = new Views ($db);

    // Category Read Query
    $result = $views->customer_export();

    // Get row count
    $num = $result->rowCount();

    // Check if any posts
    if ($num > 0)
    {
        // Post Array
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $data = array(
                'account_id' => $account_id,
                'start_date' => $start_date,
                'plan_name' => $plan_name,
                'connection_name' => $connection_name,
                'area_name' => $area_name,
                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'last_name' => $last_name,
                'billing_address' => $billing_address,
                'mobile_number' => $mobile_number,
                'email' => $email,
                'birthdate' => $birthdate,
                'install_type_name' => $install_type_name,
                'install_balance' => $install_balance,
                'install_status' => $install_status,
                'billing_end_date' => $billing_end_date,
                'total_bill' => $total_bill,
                'running_balance' => $running_balance
            );

            // Push to "data"
            array_push($arr, $data);
        }

        // Turn to JSON & Output
        echo json_encode($arr);
    }
    else
    {
        // No Categories
        echo json_encode(
            array('message' => 'No Accounts Found')
        );
    }