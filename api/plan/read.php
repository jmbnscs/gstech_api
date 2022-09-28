<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../model/Plan.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $plan = new Plan ($db);

    // Category Read Query
    $result = $plan->read();

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
                'plan_id' => $plan_id,
                'plan_name' => $plan_name,
                'bandwidth' => $bandwidth,
                'price' => $price,
                'rate_per_minute' => $rate_per_minute,
                'created_at' => $created_at,
                'promo_id' => $promo_id,
                'plan_status_id' => $plan_status_id,
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