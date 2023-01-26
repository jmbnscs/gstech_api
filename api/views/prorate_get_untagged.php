<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Views.php';

    $database = new Database();
    $db = $database->connect();

    $views = new Views ($db);

    $filter = isset($_GET['filter']) ? $_GET['filter'] : die();

    if ($filter == 'All') {
        $result =  $views->prorate_all_untagged();
    }
    else if ($filter == 'This Month') {
        $result = $views->prorate_month_unpaid();
    }
    else if ($filter == 'This Year') {
        $result = $views->prorate_year_unpaid();
    }

    $num = $result->rowCount();

    if ($num > 0)
    {
        $data = $result->fetch(PDO::FETCH_ASSOC);

        print_r(json_encode($data));
    }
    else
    {
        echo json_encode(
            array('message' => 'No Prorate Found')
        );
    }