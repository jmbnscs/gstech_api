<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Ratings.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate ratings object
    $ratings = new Ratings ($db);

    // Ratings Read Query
    $result = $ratings->read();

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
                'rating_id' => $rating_id,
                'rating_base' => $rating_base,
                'delinquent_ratings' => $delinquent_ratings,
                'avg_rating' => $avg_rating,
                'ratings_status_id' => $ratings_status_id,
                'account_id' => $account_id,
            );

            // Push to "data"
            array_push($cat_arr, $post_item);
        }

        // Turn to JSON & Output
        echo json_encode($cat_arr);
    }
    else
    {
        // No Ratings
        echo json_encode(
            array('message' => 'No Ratings Found')
        );
    }