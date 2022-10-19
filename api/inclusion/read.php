<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Inclusion.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $inclusion = new Inclusion ($db);

    // Promo Read Query
    $result = $inclusion->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any Inclusion
    if ($num > 0)
    {
        // Post Array
        $cat_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $post_item = array(
                'inclusion_id' => $inclusion_id,
                'inclusion_code' => $inclusion_code,
                'inclusion_name' => $inclusion_name
            );

            // Push to "data"
            array_push($cat_arr, $post_item);
        }

        // Turn to JSON & Output
        echo json_encode($cat_arr);
    }
    else
    {
        // No Inclusion
        echo json_encode(
            array('message' => 'No Inclusion Found')
        );
    }