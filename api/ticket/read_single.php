<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Ticket.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $ticket = new Ticket ($db);

    // GET ID
    $ticket->ticket_num = isset($_GET['ticket_num']) ? $_GET['ticket_num'] : die();

    // Get Post
    $ticket->read_single();

    // Create Array
    $cat_arr = array (
        'ticket_num' => $ticket->ticket_num,
        'concern_id' => $ticket->concern_id,
        'concern_details' => $ticket->concern_details,
        'date_filed' => $ticket->date_filed,
        'date_resolved' => $ticket->date_resolved,
        'resolution_details' => $ticket->resolution_details,
        'ticket_status_id' => $ticket->ticket_status_id,
        'account_id' => $ticket->account_id,
        'admin_id' => $ticket->admin_id,
    );

    // Make JSON
    print_r(json_encode($cat_arr));