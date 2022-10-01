<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Account.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $account = new Account ($db);

    // Category Read Query
    $result = $account->read();

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
                'account_id' => $account_id,
                'start_date' => $start_date,
                'lockin_end_date' => $lockin_end_date,
                'billing_day' => $billing_day,
                'created_at' => $created_at,
                'connection_id' => $connection_id,
                'account_status_id' => $account_status_id,
                'area_id' => $area_id,
                'bill_count' => $bill_count,
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
            array('message' => 'No Plans Found')
        );
    }