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

    // Ticket Read Query
    $result = $ticket->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any posts
    if ($num > 0)
    {
        // Post Array
        $cat_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $post_item = array(
                'ticket_id' => $ticket_id,
                'ticket_num' => $ticket_num,
                'concern_id' => $concern_id,
                'concern_details' => $concern_details,
                'date_filed' => $date_filed,
                'date_resolved' => $date_resolved,
                'resolution_details' => $resolution_details,
                'ticket_status_id' => $ticket_status_id,
                'account_id' => $account_id,
                'admin_id' => $admin_id
            );

            // Push to "data"
            array_push($cat_arr, $post_item);
        }

        // Turn to JSON & Output
        echo json_encode($cat_arr);
    }
    else
    {
        // No Ticket
        echo json_encode(
            array('message' => 'No Tickets Found')
        );
    }