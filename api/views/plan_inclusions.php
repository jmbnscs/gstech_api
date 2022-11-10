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
    $plan_inclusions = new Views ($db);

    // GET ID
    $plan_inclusions->plan_id = isset($_GET['plan_id']) ? $_GET['plan_id'] : die();

    // Account Read Query
    $result = $plan_inclusions->plan_inclusions();

    // Get row count
    $num = $result->rowCount();

    // Check if any Accounts Exist
    if ($num > 0)
    {
        // Post Array
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $data = array(
                'plan_id' => $plan_id,
                'promo_id' => $promo_id,
                'inclusion_id' => $inclusion_id,
                'inclusion_code' => $inclusion_code,
                'message' => 'success'
            );

            // Push to "data"
            array_push($arr, $data);
        }

        // Turn to JSON & Output
        echo json_encode($arr);
    }
    else
    {
        echo json_encode(
            array('message' => 'error')
        );
    }

    
