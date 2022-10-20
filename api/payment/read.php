<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Payment.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $payment = new Payment ($db);

    // Category Read Query
    $result = $payment->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any Payment
    if ($num > 0)
    {
        // Post Array
        $cat_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $post_item = array(
                'payment_id' => $payment_id,
                'amount_paid' => $amount_paid,
                'payment_reference_id' => $payment_reference_id,
                'account_id' => $account_id,
                'invoice_id' => $invoice_id,
                'tagged' => $tagged,
            );

            // Push to "data"
            array_push($cat_arr, $post_item);
        }

        // Turn to JSON & Output
        echo json_encode($cat_arr);
    }
    else
    {
        // No Categories
        echo json_encode(
            array('message' => 'No Payments Found')
        );
    }