<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Reports.php';

    $database = new Database();
    $db = $database->connect();

    $reports = new Reports ($db);

    $result = $reports->all_unpaid();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $data = array(
                'month' => $month,
                'count' => $count,
                'total' => $total,
        );

            array_push($arr, $data);
        }

        echo json_encode($arr);
    }
    else
    {
        echo json_encode(
            array('error' => $reports->error)
        );
    }