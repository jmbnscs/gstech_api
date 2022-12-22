<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Reports.php';

    $database = new Database();
    $db = $database->connect();

    $reports = new Reports ($db);
    $reports->month = isset($_GET['month']) ? $_GET['month'] : die();

    $result = $reports->unpaid();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $arr = array();

        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $data = array(
            'month' => $month,
            'count' => $count,
            'total' => $total,
        );

        print_r(json_encode($data));
    }
    else
    {
        echo json_encode(
            array('error' => $reports->error)
        );
    }