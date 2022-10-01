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
    $invoice->plan_id = $data->plan_id;

    $invoice->invoice_id = $data->invoice_id;
    $invoice->bandwidth = $data->bandwidth;
    $invoice->price = $data->price;
    $invoice->promo_id = $data->promo_id;
    $invoice->plan_status_id = $data->plan_status_id;

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
