<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Promo.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $promo = new Promo ($db);

    // Promo Read Query
    $result = $promo->read();

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
                'promo_id' => $promo_id,
                'plan_id' => $plan_id,
                'inclusion_id' => $inclusion_id
            );

            // Push to "data"
            array_push($cat_arr, $post_item);
        }

        // Turn to JSON & Output
        echo json_encode($cat_arr);
    }
    else
    {
        // No Promo
        echo json_encode(
            array('message' => 'No Promo Found')
        );
    }