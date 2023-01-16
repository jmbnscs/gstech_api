<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Payment.php';

    $database = new Database();
    $db = $database->connect();

    $payment = new Payment ($db);

    $payment->approval_id = isset($_GET['approval_id']) ? $_GET['approval_id'] : die();

    $result = $payment->read_single_pending();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $payment->status_id = $status;
        $payment->getApprovalStatus();

        $arr = array(
            'approval_id' => $approval_id,
            'account_id' => $account_id,
            'date_uploaded' => $date_uploaded,
            'status' => $payment->status_name,
        );

        print_r(json_encode($arr));
    }
    else
    {
        echo json_encode(
            array('message' => 'No Payment Record Found')
        );
    }