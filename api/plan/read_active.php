<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Plan.php';

    $database = new Database();
    $db = $database->connect();

    $plan = new Plan ($db);

    $result = $plan->read_active();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $data = array(
                'plan_id' => $plan_id,
                'plan_name' => $plan_name,
                'bandwidth' => $bandwidth
            );

            array_push($arr, $data);
        }

        echo json_encode($arr);
    }
    else
    {
        echo json_encode(
            array('message' => 'No Plans Found')
        );
    }