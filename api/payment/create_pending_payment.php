<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Payment.php';
    include_once '../../models/Invoice.php';

    $database = new Database();
    $db = $database->connect();

    $payment = new Payment ($db);
    $invoice = new Invoice ($db);

    $data = json_decode(file_get_contents("php://input"));

    $payment->approval_id = $data->approval_id;
    $payment->payment_center = $data->payment_center;
    $payment->amount_paid = $data->amount_paid;
    $payment->payment_reference_id = $data->payment_reference_id;
    $payment->payment_date = $data->payment_date;
    $payment->account_id = $data->account_id;

    if ($payment->create_pending_payment())
    {
        $invoice->amount_paid = $data->amount_paid;
        $invoice->payment_reference_id = $data->payment_reference_id;
        $invoice->payment_date = $data->payment_date;
        $invoice->account_id = $data->account_id;

        if ($invoice->update()) {
            $payment->invoice_id = $invoice->invoice_id;

            if ($payment->update_tagged()) {

                $payment->status_id = 2;
                
                if ($payment->update_pending_status()) {
                    echo json_encode(
                        array (
                            'success' => true
                        )
                    );
                }
                else
                {
                    echo json_encode(
                        array ('success' => false)
                    );
                }
            }
            else
            {
                echo json_encode(
                    array ('success' => false)
                );
            }
        }
        else
        {
            echo json_encode(
                array ('success' => false)
            );
        }
    }
    else
    {
        echo json_encode(
            array ('success' => false)
        );
    }