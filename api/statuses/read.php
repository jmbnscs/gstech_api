<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Statuses.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $statuses = new Statuses ($db);

    // GET ID
    $statuses->status_table = isset($_GET['status_table']) ? $_GET['status_table'] : die();

    // Statuses Read Query
    $result = $statuses->read();

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
                'status_id' => $status_id,
                'status_name' => $status_name
            );

            // Push to "data"
            array_push($cat_arr, $post_item);
        }

        // Turn to JSON & Output
        echo json_encode($cat_arr);
    }
    else
    {
        // No Status
        echo json_encode(
            array('message' => 'No Status Found')
        );
    }