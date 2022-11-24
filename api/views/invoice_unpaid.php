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
    $result = $views->invoice_unpaid();

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
                'invoice_id' => $invoice_id,
                'customer_name' => $first_name . ' ' . $last_name,
                'disconnection_date' => $disconnection_date,
                'running_balance' => $running_balance,
                'status' => $status
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
            array('message' => 'No Invoices Found')
        );
    }