    <?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Ticket.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate plan object
    $ticket = new Ticket($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // ID to Update
    $ticket->ticket_num = $data->ticket_num;

    $ticket->ticket_status_id = $data->ticket_status_id;
    $ticket->admin_id = $data->admin_id;

    // Update ticket
    if($ticket->update()) {
        echo json_encode(
            array('message' => 'Ticket Claimed')
    );
    } else {
        echo json_encode(
            array('message' => 'Ticket not claimed')
        );
    }
