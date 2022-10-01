    <?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Concerns.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate concerns object
    $concerns = new Concerns($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // ID to Update
    $concerns->concern_id = $data->concern_id;

    $concerns->concern_category = $data->concern_category;
    $concerns->technical_support_access = $data->technical_support_access;
    $concerns->customer_access = $data->customer_access;

    // Update Concerns
    if($concerns->update()) {
        echo json_encode(
            array('message' => 'Concerns Updated')
    );
    } else {
        echo json_encode(
            array('message' => 'Concerns not updated')
        );
    }
