<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Ticket.php';

    $database = new Database();
    $db = $database->connect();

    $ticket = new Ticket ($db);

    $ticket->ticket_num = isset($_GET['ticket_num']) ? $_GET['ticket_num'] : die();

    if ($ticket->isTicketNumExist()) {
        echo json_encode(
            array(
                'error' => $ticket->error,
                'exist' => true
            )
        );
    }
    else {
        echo json_encode(
            array(
                'exist' => false
            )
        );
    }