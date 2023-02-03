<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Invoice.php';
    include_once '../../models/Payment.php';
    include_once '../../models/Ratings.php';

    $database = new Database();
    $db = $database->connect();

    $invoice = new Invoice($db);
    $payment = new Payment($db);
    $ratings = new Ratings($db);

    $data = json_decode(file_get_contents("php://input"));

    $invoice->account_id = $data->account_id;
    $invoice->read_latest();

    $invoice_status_before_payment = $invoice->invoice_status_id;

    $invoice->payment_reference_id = $data->payment_reference_id;
    $invoice->amount_paid = $data->amount_paid;
    $invoice->payment_date = $data->payment_date;

    $success = true;

    if ($invoice->update()) {
        $invoice->read_latest();

        $payment->invoice_id = $invoice->invoice_id;
        $payment->account_id = $data->account_id;
        $payment->payment_center = $data->payment_center;
        $payment->payment_id = $data->payment_id;

        if ($payment->update_tagged()) {
            if ($invoice->invoice_status_id == 1) {
                $ratings->account_id = $data->account_id;
                $ratings->invoice_status = $invoice_status_before_payment;

                if ($ratings->update()) {
                    $success = true;
                }
                else {
                    $success = false;
                }
            }
        }
        else {
            $success = false;
        }
    }
    else {
        $success = false;
    }


    if($success) {
        echo json_encode(
            array(
                'success' => true,
                'invoice_id' => $invoice->invoice_id
            )
        );
    } 
    else {
        echo json_encode(
            array(
                'success' => false,
                'error' => $payment->error . ' / ' . $invoice->error . ' / ' . $ratings->error
            )
        );
    }