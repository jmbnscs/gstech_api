<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Payment.php';

    $database = new Database();
    $db = $database->connect();

    $payment = new Payment ($db);

    $payment->account_id = isset($_GET['account_id']) ? $_GET['account_id'] : die();

    $result = $payment->read_single_payment_approval();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $cat_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $payment->status_id = $status;
            $payment->getApprovalStatus();

            $post_item = array(
                'approval_id' => $approval_id,
                'account_id' => $account_id,
                'date_uploaded' => $date_uploaded,
                'status' => $payment->status_name
            );

            array_push($cat_arr, $post_item);
        }

        echo json_encode($cat_arr);
    }
    else
    {
        echo json_encode(
            array('message' => 'No Payment Approval Found')
        );
    }