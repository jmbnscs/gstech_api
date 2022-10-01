<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Ticket.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Ticket object
    $ticket = new Ticket ($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $ticket->concern_id = $data->concern_id;
    $ticket->concern_details = $data->concern_details;
    $ticket->date_filed = $data->date_filed;
    $ticket->ticket_status_id = $data->ticket_status_id;
    $ticket->account_id = $data->account_id;

    // Create Ticket
    if ($ticket->create())
    {
        echo json_encode(
            array ('message' => 'Ticket Created')
        );
    }
    else
    {
        echo json_encode(
            array ('message' => 'Ticket Not Created')
        );
    }