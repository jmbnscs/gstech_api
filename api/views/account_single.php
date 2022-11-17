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

    // GET ID
    $views->account_id = isset($_GET['account_id']) ? $_GET['account_id'] : die();

    // Category Read Query
    $result = $views->account_single();

    // Get row count
    $num = $result->rowCount();

    // Check if any Prorate Record
    if ($num > 0)
    {
        // Payment Array
        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $data = array(
            'account_id' => $account_id,
            'start_date' => $start_date,
            'lockin_end_date' => $lockin_end_date,
            'billing_day' => $billing_day,
            'plan_name' => $plan_name,
            'connection_type' => $connection_type,
            'area_name' => $area_name,
            'bill_count' => $bill_count,
            'status_name' => $status_name
        );

        print_r(json_encode($data));
    }
    else
    {
        // No Payment
        echo json_encode(
            array('message' => 'No Accounts Found')
        );
    }