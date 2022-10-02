<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Invoice.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $invoice = new Invoice ($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $invoice->account_id = $data->account_id;

    // Create Invoice
    if ($invoice->create())
    {
        echo json_encode(
            array ('message' => 'Invoice Created')
        );
    }
    else
    {
        echo json_encode(
            array ('message' => 'Invoice Not Created')
        );
    }