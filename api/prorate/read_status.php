<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Prorate.php';

    $database = new Database();
    $db = $database->connect();

    $prorate = new Prorate ($db);

    $prorate->prorate_status_id = isset($_GET['prorate_status_id']) ? $_GET['prorate_status_id'] : die();

    $result = $prorate->read_status();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $data = array(
                'prorate_id' => $prorate_id,
                'duration' => $duration,
                'rate_per_minute' => $rate_per_minute,
                'prorate_charge' => $prorate_charge,
                'account_id' => $account_id,
                'invoice_id' => $invoice_id,
                'prorate_status_id' => $prorate_status_id,
                'created_at' => $created_at
            );

            array_push($arr, $data);
        }

        echo json_encode($arr);
    }
    else
    {
        echo json_encode(
            array('message' => 'No Prorate Record Found')
        );
    }