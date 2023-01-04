<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Invoice.php';

    $database = new Database();
    $db = $database->connect();

    $invoice = new Invoice ($db);

    $data = json_decode(file_get_contents("php://input"));

    $invoice->account_id = $data->account_id;
    $invoice->invoice_id = $data->invoice_id;

    // $result = $invoice->test();

    // echo json_encode($result);

    // $num = $result->rowCount();
    if ($invoice->test()) {
        echo json_encode(
            array(
                'success' => true
            )
            );
    }

    // if ($num > 0)
    // {
    //     $row = $result->fetch(PDO::FETCH_ASSOC);
    //     extract($row);

    //     $to_add = floatval($subscription_amount) + floatval($installation_charge);
    //     $to_sub = floatval($secured_cash) + floatval($prorated_charge);
    //     $running_balance = $to_add - $to_sub;

    //     if ($running_balance < 0) {
    //         $running_balance = 0.00;
    //     }

    //     $running_balance = number_format($running_balance, 2, '.', '');

    //     // $data = array(
    //     //     'secured_cash' => $secured_cash,
    //     //     'subscription_amount' => $subscription_amount,
    //     //     'prorated_charge' => $prorated_charge,
    //     //     'installation_charge' => $installation_charge
    //     // );

    //     $data = array(
    //         'running_balance' => $running_balance,
    //         // 'subscription_amount' => $subscription_amount,
    //         // 'prorated_charge' => $prorated_charge,
    //         // 'installation_charge' => $installation_charge
    //     );

    //     echo json_encode($data);
    // }
    else
    {
        echo json_encode(
            array(
                'error' => $invoice->error,
                'success' => false
            )
        );
    }