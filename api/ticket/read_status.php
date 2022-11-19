<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Ticket.php';

    $database = new Database();
    $db = $database->connect();

    $ticket = new Ticket ($db);

    $ticket->ticket_status_id = isset($_GET['ticket_status_id']) ? $_GET['ticket_status_id'] : die();

    $result = $ticket->read_status();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $data = array(
                'ticket_num' => $ticket_num,
                'concern_id' => $concern_id,
                'concern_details' => $concern_details,
                'date_filed' => $date_filed,
                'date_resolved' => $date_resolved,
                'resolution_details' => $resolution_details,
                'ticket_status_id' => $ticket_status_id,
                'account_id' => $account_id,
                'admin_id' => $admin_id,
                'user_level' => $user_level
            );

            array_push($arr, $data);
        }

        echo json_encode($arr);
    }
    else
    {
        echo json_encode(
            array('message' => 'No Ticket Record Found')
        );
    }