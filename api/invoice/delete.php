    <?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Invoice.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $invoice = new Invoice($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to Delete
    $invoice->invoice_id = $data->invoice_id;

    // Delete Invoice
    if($invoice->delete()) {
        echo json_encode(
        array('message' => 'Invoice Deleted')
    );
    } else {
        echo json_encode(
        array('message' => 'Invoice Not Deleted')
    );
    }

