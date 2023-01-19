<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Reports.php';

    $database = new Database();
    $db = $database->connect();

    $reports = new Reports ($db);

    $data = json_decode(file_get_contents("php://input"));

    $reports->date_to = $data->date_to;
    $reports->date_from = $data->date_from;

    $result = $reports->read_prorates();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $data = array(
                'date' => $date,
                'invoice_id' => $invoice_id,
                'account_id' => $account_id,
                'duration' => $duration,
                'prorate_discount' => $prorate_charge
        );

            array_push($arr, $data);
        }

        echo json_encode($arr);
    }
    else
    {
        echo json_encode(
            array('message' => 'No Prorates Found')
        );
    }