<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Prorate.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $prorate = new Prorate ($db);

    // Category Read Query
    $result = $prorate->read();

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
                'prorate_id' => $prorate_id,
                'duration' => $duration,
                'rate_per_minute' => $rate_per_minute,
                'prorate_charge' => $prorate_charge,
                'account_id' => $account_id,
                'invoice_id' => $invoice_id,
                'prorate_status_id' => $prorate_status_id,
                'created_at' => $created_at
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
            array('message' => 'No Prorate Found')
        );
    }