    <?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Installation.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate installation object
    $installation = new Installation($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // ID to Update
    $installation->account_id = $data->account_id;
    $installation->balance  = $data->balance;
    $installation->status_id = $data->status_id;

    // Update account
    if($installation->update_import()) {
        echo json_encode(
            array('success' => true)
        );
    } else {
        echo json_encode(
            array(
                'success' => false,
                'error' => $installation->error
            )
        );
    }
