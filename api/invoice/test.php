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
    // $invoice->invoice_id = $data->invoice_id;

    $result = $invoice->test();
    $num = $result->rowCount();

    // if ($invoice->test()) {
    //     echo json_encode(
    //         array(
    //             'success' => true
    //         )
    //         );
    // }

    if ($num > 0)
    {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $data = array(
            'counter' => $counter,
            // 'subscription_amount' => $subscription_amount,
            // 'prorated_charge' => $prorated_charge,
            // 'installation_charge' => $installation_charge
        );

        echo json_encode($data);
    }
    else
    {
        echo json_encode(
            array(
                'error' => $invoice->error,
                'success' => false
            )
        );
    }