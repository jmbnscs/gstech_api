<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Ticket.php';

    $database = new Database();
    $db = $database->connect();

    $ticket = new Ticket ($db);

    $ticket->account_id = isset($_GET['account_id']) ? $_GET['account_id'] : die();

    $result = $ticket->ticket_display();

    $num = $result->rowCount();

    // Check if any Payment Record
    if ($num > 0)
    {
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $data = array(
                'ticket_num' => $ticket_num,
                'category' => $category,
                'date_filed' => $date_filed,
                'date_resolved' => ($date_resolved == null) ? 'N/A' : $date_resolved,
                'status' => $status,
            );

            array_push($arr, $data);
        }

        // Turn to JSON & Output
        echo json_encode($arr);
    }
    else
    {
        echo json_encode(
            array('message' => 'No Ticket Records Found')
        );
    }