<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Concerns.php';

    $database = new Database();
    $db = $database->connect();

    $concerns = new Concerns ($db);

    $concerns->concern_id = isset($_GET['concern_id']) ? $_GET['concern_id'] : die();

    $result = $concerns->read_single();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $arr = array(
            'concern_id' => $concern_id,
            'concern_category' => $concern_category,
            'customer_access' => $customer_access
        );

        print_r(json_encode($arr));
    }
    else
    {
        echo json_encode(
            array('message' => 'No Concerns Found')
        );
    }