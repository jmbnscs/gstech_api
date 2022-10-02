    <?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Ticket.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $ticket = new Ticket($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to Delete
    $ticket->ticket_num = $data->ticket_num;

    // Delete Ticket
    if($ticket->delete()) {
        echo json_encode(
        array('message' => 'Ticket Deleted')
    );
    } else {
        echo json_encode(
        array('message' => 'Ticket Not Deleted')
    );
    }

