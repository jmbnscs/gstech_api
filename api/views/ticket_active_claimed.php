<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Views.php';

    $database = new Database();
    $db = $database->connect();

    $views = new Views ($db);

    $views->admin_id = isset($_GET['admin_id']) ? $_GET['admin_id'] : die();

    $result =  $views->ticket_active_claimed();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $data = $result->fetch(PDO::FETCH_ASSOC);

        print_r(json_encode($data));
    }
    else
    {
        echo json_encode(
            array('message' => 'No Tickets Found')
        );
    }