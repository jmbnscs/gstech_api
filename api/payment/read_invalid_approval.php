<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Payment.php';

    $database = new Database();
    $db = $database->connect();

    $payment = new Payment ($db);

    $result = $payment->read_invalid_approval();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $payment->status_id = $status;
            $payment->getApprovalStatus();

            $data = array(
                'approval_id' => $approval_id,
                'account_id' => $account_id,
                'date_uploaded' => $date_uploaded,
                'status' => $payment->status_name
            );

            array_push($arr, $data);
        }

        echo json_encode($arr);
    }
    else
    {
        echo json_encode(
            array('message' => 'No Payments Found')
        );
    }