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
    $views->prorate_id = isset($_GET['prorate_id']) ? $_GET['prorate_id'] : die();

    // Category Read Query
    $result = $views->prorate_single();

    // Get row count
    $num = $result->rowCount();

    // Check if any Prorate Record
    if ($num > 0)
    {
        // Payment Array
        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $arr = array(
            'prorate_id' => $prorate_id,
            'account_id' => $account_id,
            'customer_name' => $first_name . ' ' . $last_name,
            'duration' => $duration,
            'amount' => $amount,
            'status' => $status
        );

        print_r(json_encode($arr));
    }
    else
    {
        // No Payment
        echo json_encode(
            array('message' => 'No Prorate Records Found')
        );
    }