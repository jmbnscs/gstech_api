<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: image');

    include_once '../../config/Database.php';
    include_once '../../models/Payment.php';

    $database = new Database();
    $db = $database->connect();

    $payment = new Payment ($db);

    $payment->approval_id = isset($_GET['approval_id']) ? $_GET['approval_id'] : die();

    $result = $payment->get_uploaded_image();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $row = $result->fetch(PDO::FETCH_ASSOC);

        echo $row['uploaded_image'];
        
    }
    // else
    // {
    //     echo json_encode(
    //         array('message' => 'No Payments Found')
    //     );
    // }