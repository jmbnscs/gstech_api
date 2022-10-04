    <?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Invoice.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate invoice object
    $invoice = new Invoice($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // ID to Update
    $invoice->invoice_id = $data->invoice_id;
    
    $invoice->payment_reference_id = $data->payment_reference_id;
    $invoice->amount_paid = $data->amount_paid;
    $invoice->payment_date = $data->payment_date;

    // Update Invoice
    if($invoice->update()) {
        echo json_encode(
            array('message' => 'Invoice Updated')
    );
    } else {
        echo json_encode(
            array('message' => 'Invoice not updated')
        );
    }
